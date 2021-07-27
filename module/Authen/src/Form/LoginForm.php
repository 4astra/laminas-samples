<?php

namespace Authen\Form;

use Laminas\Form\Form;
use Laminas\I18n\Translator\Translator;

class LoginForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('user');
        $translator = new Translator();

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'username',
            'type' => 'text',
            'options' => [
                'label' => $translator->translate('username'),
            ],
        ]);
        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => $translator->translate('password'),
            ],
        ]);
        // $this->add([
        //     'name' => 'remember',
        //     'type' => 'checkbox',
        //     'options' => [
        //         'label' => 'Remember me?',
        //     ],
        // ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => $translator->translate('go'),
                'id'    => 'submitbutton',
            ],
        ]);
    }
}
