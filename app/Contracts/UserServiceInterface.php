<?php


namespace App\Contracts;


interface UserServiceInterface
{
    /**
     * @param array $payload
     * @return mixed
     */
    public function create(array $payload);

    public function findByEmail( string  $email );
}
