<?php

namespace Authen\Controller;

use Authen\Form\LoginForm;
use Authen\Model\AuthenTable as ModelAuthenTable;
use Authen\Model\User as LoginUser;
use Laminas\Mvc\Controller\AbstractActionController;


class AuthenController extends AbstractActionController
{
    private $table;
    public function __construct(ModelAuthenTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        $form = new LoginForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $album = new LoginUser();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }


        return $this->redirect()->toRoute('album');
    }
}
