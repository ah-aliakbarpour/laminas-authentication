<?php

namespace Auth\Repository;

use Auth\Entity\UserEntity;

class UserRepository
{
    public function __construct()
    {
    }

    public function save(array $data)
    {
        //
    }

    public function delete($id)
    {
        //
    }

    public function getUserByIdentity(string $identity, array $columns)
    {
        //
    }

    public function getCredential(string $identity)
    {
        //
    }
}