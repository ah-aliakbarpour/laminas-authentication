<?php

namespace Auth\Repository;

use Doctrine\DBAL\DriverManager;
use Laminas\Crypt\Password\Bcrypt;

class UserRepository
{
    public const TABLE_NAME = 'user';
    public const IDENTITY_COLUMN = 'email';
    public const CREDENTIAL_COLUMN = 'password';
    protected $query;

    public function __construct($config)
    {
        $connectionParams = $config['db_doctrine'];
        $conn = DriverManager::getConnection($connectionParams);
        $this->query = $conn->createQueryBuilder();
    }

    public function save(array $data)
    {
        $this->query->insert(self::TABLE_NAME)
            ->values([
                'name' => ':name',
                'email' => ':email',
                'password' => ':password',
            ])
            ->setParameters([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => (new Bcrypt())->create($data['password']),
            ]);

        return $this->query->executeStatement();
    }

    public function delete($id)
    {
        //
    }

    public function getUserByIdentity(string $identityValue, array $columns = [self::CREDENTIAL_COLUMN])
    {
        return $this->query->select($columns)
            ->from(self::TABLE_NAME)
            ->where(self::IDENTITY_COLUMN . '= :' . self::IDENTITY_COLUMN)
            ->setParameter(self::IDENTITY_COLUMN, $identityValue)
            ->fetchAssociative();
    }

    public function getCredential(string $identity)
    {
        //
    }
}