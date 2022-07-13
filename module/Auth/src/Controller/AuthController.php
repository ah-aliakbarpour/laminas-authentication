<?php

namespace Auth\Controller;

use Auth\Form\LoginRegisterForm;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    public function registerAction()
    {
        $form = new LoginRegisterForm();

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function loginAction()
    {
        $form = new LoginRegisterForm();

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function logoutAction()
    {
        echo 'logout';
    }

    public function profileAction()
    {
        return new ViewModel();
    }
}