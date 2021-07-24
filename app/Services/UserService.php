<?php


namespace App\Services;


use App\Models\User;

class UserService implements \App\Contracts\UserServiceInterface
{
    /**
     * @var User
     */
    private $model;

    /**
     * UserService constructor.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }


    /**
     * @inheritDoc
     */
    public function create(array $payload)
    {
        return $this->model = $this->model->create( $payload );
    }

    public function findByEmail( string  $email )
    {
        return $this->model->whereEmail( $email )->first();
    }
}
