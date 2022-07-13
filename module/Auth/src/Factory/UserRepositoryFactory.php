<?php

namespace Auth\Factory;

use Auth\Repository\UserRepository;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): UserRepository
    {
        return new UserRepository($container->get('config'));
    }
}