<?php

namespace Auth\Factory;

use Auth\Controller\AuthController;
use Auth\Model\User;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AuthControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new AuthController($container->get(User::class));
    }
}