<?php

namespace Authen\Controller;

use Authen\Form\LoginForm;
use Authen\Model\AuthenTable as AuthenTableModel;
use Authen\Model\Login as LoginUser;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\I18n\Translator\Translator;
use Laminas\Mvc\Plugin\FlashMessenger;

class AuthenController extends AbstractActionController
{
    private $table;
    private $translator;
    private $auth_service;
    // private $flashMessenger;

    public function __construct(AuthenTableModel $table)
    {
        $this->table = $table;
        $this->translator = new Translator();
        // $this->flashMessenger = new FlashMessenger();
    }

    public function indexAction()
    {
        $form = new LoginForm();
        $form->get('submit')->setValue($this->translator->translate('login'));

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $login = new LoginUser();
        $form->setInputFilter($login->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }


        if ($request->isPost()) {

            $login->exchangeArray($form->getData());

            $result = $this->table->authenticate($login);

            if (isset($result)) {
                return $this->redirect()->toRoute('album');
            }
        }

        return $this->redirect()->toRoute('blog');
    }
}
