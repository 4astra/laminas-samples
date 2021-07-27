<?php

namespace Authen\Model;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;
use Laminas\Validator\NotEmpty;

class User implements InputFilterAwareInterface
{
    public $username;
    public $password;
    private $inputFilter;

    public function exchangeArray(array $data)
    {

        $this->username = !empty($data['username']) ? $data['username'] : null;
        $this->password  = !empty($data['password']) ? $data['password'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'username',
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
                        'min' => 2,
                        'max' => 100,
                        'messages' => [
                            StringLength::TOO_SHORT => 'Username is too short'
                        ]
                    ],

                ],
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Please enter your username'
                        ]
                    ]
                ]
            ],
        ]);

        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Please enter your password'
                        ]
                    ]
                ]
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

    public function getArrayCopy()
    {
        return [
            'username' => $this->username,
            'password'  => $this->password,
        ];
    }
}
