<?php

namespace Auth\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;

class LoginRegisterForm extends Form
{
    public function __construct()
    {
        parent::__construct('register');
        $this->setAttribute('method', 'post');

        // Name
        $this->add([
            'type' => Element\Text::class,
            'name' => 'name',
            'options' => [
                'label' => 'Name',
            ],
            'attributes' => [
                'required' => true,
                'size' => 40,
                'maxlength' => 25,
                'pattern' => '^[a-zA-Z0-9]+$',
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'placeholder' => 'Enter Your Name',
            ]
        ]);

        // Email
        $this->add([
            'type' => Element\Email::class,
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'required' => true,
                'size' => 40,
                'maxlength' => 128,
                'pattern' => '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'placeholder' => 'Enter Your Email',
            ]
        ]);

        // Password
        $this->add([
            'type' => Element\Password::class,
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'required' => true,
                'size' => 40,
                'maxlength' => 25,
                'autocomplete' => false,
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'placeholder' => 'Enter Your Password',
            ]
        ]);

        // Confirm Password
        $this->add([
            'type' => Element\Password::class,
            'name' => 'confirm_password',
            'options' => [
                'label' => 'Confirm Password',
            ],
            'attributes' => [
                'required' => true,
                'size' => 40,
                'maxlength' => 25,
                'autocomplete' => false,
                'data-toggle' => 'tooltip',
                'class' => 'form-control',
                'placeholder' => 'Repeat Your Password',
            ]
        ]);

        // Submit Button
        $this->add([
            'type' => Element\Submit::class,
            'name' => 'submit',
            'attributes' => [
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}