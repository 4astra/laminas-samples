<?php

namespace Authen\Controller;

use Authen\Form\LoginForm;
use Authen\Model\AuthenTable as AuthenTableModel;
use Authen\Model\User as LoginUser;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\I18n\Translator\Translator;

class AuthenController extends AbstractActionController
{
    private $table;
    private $translator;

    public function __construct(AuthenTableModel $table)
    {
        $this->table = $table;
        $this->translator = new Translator();
    }

    public function indexAction()
    {
        $form = new LoginForm();
        $form->get('submit')->setValue($this->translator->translate('login'));

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $loggin = new LoginUser();
        $form->setInputFilter($loggin->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }




        return $this->redirect()->toRoute('album');
    }
}
