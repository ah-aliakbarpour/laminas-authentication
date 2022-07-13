<?php

namespace Auth\Model;

use Auth\Repository\UserRepository;
use Laminas\Filter\StringToLower;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

class User
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($data)
    {
        return $this->userRepository->save($data);
    }

    public function loginRegisterFormInputFilters(): InputFilter
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
//                    [
//                        'name' => NoRecordExists::class,
//                        'options' => [
//                            'table' => $this->table,
//                            'field' => 'email',
//                            'adapter' => $this->adapter,
//                        ],
//                    ],
                ],
            ]
        );

        // password
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

        # filter and validate confirm_password field
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
}