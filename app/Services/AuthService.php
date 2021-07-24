<?php


namespace App\Services;


use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class AuthService implements \App\Contracts\AuthServiceInterface
{
    /**
     * @var User
     */
    private $user;


    /**
     * AuthService constructor.
     */
    public function __construct( User $user )
    {
        $this->user = $user;
    }


    /**
     * @inheritDoc
     */
    public function register(array $payload)
    {
        return $this->user->create($payload);
    }

    /**
     * @inheritDoc
     */
    public function login( Request $request)
    {
        // confirm user credetials is valid
        if(!Auth::attempt([
            "email"=>$request->email,
            "password"=>$request->password
        ])){
            throw new \Exception ("Invalid login credentials. Please try again.");
        }

        $oauthRequest = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => $request->client_id,
            'client_secret' => $request->client_secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*',
        ]);

        // since we are creating a mock request, set the origin of the mock request to match that of the original
        // request. the logic to determine whether this origin is allowed is handled by the CORS middleware
        $oauthRequest->headers->add(['Origin' => $request->headers->get('Origin') ?? '']);
        $response = app()->handle($oauthRequest);

        return array_merge(
            ['statusCode'=>$response->getStatusCode()],
            json_decode($response->getContent(), true)
        );
    }

    /**
     * @inheritDoc
     */
    public function logout()
    {
        $accessToken = Auth::user()->token();
        if(empty($accessToken)) {
            return Auth::logout();
        }

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $this->clearSession(Auth::user());
        $accessToken->revoke();

        return true;
    }

    /**
     * Clear all user login sessions
     *
     * @return boolean
     */
    public function clearSession($user = null)
    {
        $user = $user ?? Auth::user();
        DB::table('oauth_access_tokens AS OAT')
            ->join('oauth_refresh_tokens AS ORT', 'OAT.id', 'ORT.access_token_id')
            ->where('OAT.user_id', $user->id)
            ->when($user, function($query, $user){
                if(isset($user->token()->id)) $query->where('OAT.id', '!=', $user->token()->id);
            })
            ->update([
                'OAT.revoked' => true,
                'ORT.revoked' => true
            ]);

        return true;
    }

}
