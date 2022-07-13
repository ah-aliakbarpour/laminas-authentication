<?php

namespace Auth\Factory;

use Auth\Model\User;
use Auth\Repository\UserRepository;
use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\Adapter;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): User
    {
        return new User($container->get(UserRepository::class), $container->get(Adapter::class));
    }
}