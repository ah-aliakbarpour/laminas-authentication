<?php

namespace Auth\Controller;

use Auth\Form\LoginRegisterForm;
use Auth\Model\User;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use RuntimeException;

class AuthController extends AbstractActionController
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function registerAction()
    {
        $auth = new AuthenticationService();

        if($auth->hasIdentity())
            return $this->redirect()->toRoute('home');

        $request = $this->getRequest();
        $form = new LoginRegisterForm();

        if($request->isPost()) {
            $formData = $request->getPost()->toArray();
            $form->setData($formData);
            $form->setInputFilter($this->user->registerFormInputFilters());

            if($form->isValid()) {
                try {
                    $data = $form->getData();
                    $this->user->register($data);
                    $this->flashMessenger()->addSuccessMessage('Account successfully created.');

                    return $this->redirect()->toRoute('login');
                } catch(RuntimeException $exception) {
                    $this->flashMessenger()->addErrorMessage($exception->getMessage());
                    return $this->redirect()->refresh();
                }
            }
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function loginAction()
    {
        $auth = new AuthenticationService();

        if($auth->hasIdentity())
            return $this->redirect()->toRoute('home');

        $request = $this->getRequest();
        $form = new LoginRegisterForm();

        if($request->isPost()) {
            $formData = $request->getPost()->toArray();
            $form->setData($formData);
            $form->setInputFilter($this->user->loginFormInputFilters());

            if($form->isValid()) {
                if ($this->user->login($form, $auth)) {
                    $this->flashMessenger()->addSuccessMessage('Login was successful!');
                    return $this->redirect()->toRoute('profile');
                }
                else {
                    $this->flashMessenger()->addErrorMessage('Email or Password is incorrect!');
                    return $this->redirect()->refresh();
                }
            }
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService();
        if($auth->hasIdentity()) {
            $auth->clearIdentity();
        }

        return $this->redirect()->toRoute('login');
    }

    public function profileAction()
    {
        $auth = new AuthenticationService();

        if(!$auth->hasIdentity())
            return $this->redirect()->toRoute('login');

        return new ViewModel();
    }
}