<?php

namespace Auth\Model;

use Auth\Form\LoginRegisterForm;
use Auth\Repository\UserRepository;
use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Result;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Adapter\Adapter;
use Laminas\Filter\StringToLower;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\Session\SessionManager;
use Laminas\Validator\Db\NoRecordExists;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

class User
{
    private $userRepository;
    private $dbAdapter;

    public function __construct(UserRepository $userRepository, Adapter $dbAdapter)
    {
        $this->userRepository = $userRepository;
        $this->dbAdapter = $dbAdapter;
    }

    public function register($data)
    {
        return $this->userRepository->save($data);
    }

    // If every thing was correct, returns true
    public function login(LoginRegisterForm $form, AuthenticationService $auth): bool
    {
        $authAdapter = new CredentialTreatmentAdapter(
            $this->dbAdapter,
            UserRepository::TABLE_NAME,
            UserRepository::IDENTITY_COLUMN,
            UserRepository::CREDENTIAL_COLUMN,
        );

        $data = $form->getData();
        $authAdapter->setIdentity($data['email']);

        $info = $this->userRepository->getUserByIdentity($data['email']);

        if(!(new Bcrypt())->verify($data['password'], $info['password']))
            return false;

        $authAdapter->setCredential($info['password']);

        $authResult = $auth->authenticate($authAdapter);

        // If authenticate is successfully done
        if ($authResult->getCode() === Result::SUCCESS) {
            // Implement remember_me checkbox
            if($data['remember_me'] == 1) {
                $session = new SessionManager();
                $timeToAlive = 1814400;
                $session->rememberMe($timeToAlive);
            }

            return true;
        }

        return false;
    }

    public function registerFormInputFilters(): InputFilter
    {
        $inputFilter = new InputFilter();

        // name
        $inputFilter->add(
            [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 25,
                        ],
                    ],
                ],
            ]
        );

        //email
        $inputFilter->add(
            [
                'name' => 'email',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => StringToLower::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                    ['name' => EmailAddress::class],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 6,
                            'max' => 128,
                            'messages' => [
                                StringLength::TOO_SHORT => 'Email address must have at least 6 characters',
                                StringLength::TOO_LONG => 'Email address must have at most 128 characters',
                            ],
                        ],
                    ],
                    [
                        'name' => NoRecordExists::class,
                        'options' => [
                            'table' => UserRepository::TABLE_NAME,
                            'field' => 'email',
                            'adapter' => $this->dbAdapter,
                        ],
                    ],
                ],
            ]
        );

        // Password
        $inputFilter->add(
            [
                'name' => 'password',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 8,
                            'max' => 25,
                            'messages' => [
                                StringLength::TOO_SHORT => 'Password must have at least 8 characters',
                                StringLength::TOO_LONG => 'Password must have at most 25 characters',
                            ],
                        ],
                    ],
                ],
            ]
        );

        // Confirm Password
        $inputFilter->add(
            [
                'name' => 'confirm_password',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                    [
                        'name' => Identical::class,
                        'options' => [
                            'token' => 'password',
                            'messages' => [
                                Identical::NOT_SAME => 'Passwords do not match!',
                            ],
                        ],
                    ],
                ],
            ]
        );

        return $inputFilter;
    }

    public function loginFormInputFilters(): InputFilter
    {
        $inputFilter = new InputFilter();

        //email
        $inputFilter->add(
            [
                'name' => 'email',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => StringToLower::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                    ['name' => EmailAddress::class],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 6,
                            'max' => 128,
                            'messages' => [
                                StringLength::TOO_SHORT => 'Email address must have at least 6 characters',
                                StringLength::TOO_LONG => 'Email address must have at most 128 characters',
                            ],
                        ],
                    ],
                ],
            ]
        );

        // Password
        $inputFilter->add(
            [
                'name' => 'password',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 8,
                            'max' => 25,
                            'messages' => [
                                StringLength::TOO_SHORT => 'Password must have at least 8 characters',
                                StringLength::TOO_LONG => 'Password must have at most 25 characters',
                            ],
                        ],
                    ],
                ],
            ]
        );

        return $inputFilter;
    }
}