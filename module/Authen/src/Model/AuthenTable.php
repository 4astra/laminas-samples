<?php

namespace Authen\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Authen\Model\Login;

class AuthenTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function authenticate(Login $login)
    {

        $rowset = $this->tableGateway->select(['username' => $login->username, 'password' => $login->password]);
        $row = $rowset->current();
        if (!$row) {
            return null;
            // throw new RuntimeException(sprintf(
            //     'Could not find row with identifier %s',
            //     $login->username
            // ));
        }

        return $row;
    }
}
