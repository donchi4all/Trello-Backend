<?php


namespace App\Contracts;


use Illuminate\Http\Request;

interface AuthServiceInterface
{
    /**
     * @param array $payload
     * @return mixed
     */
    public function register( array $payload );

    /**
     *
     * @return mixed
     */
    public function login(Request $request);

    /**
     * @return mixed
     */
    public function logout();
}
