<?php

namespace Authen;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\AuthenTable::class => function ($container) {
                    $tableGateway = $container->get(Model\AuthenTableGateway::class);
                    return new Model\AuthenTable($tableGateway);
                },
                Model\AuthenTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Login());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AuthenController::class => function ($container) {
                    return new Controller\AuthenController(
                        $container->get(Model\AuthenTable::class)
                    );
                },
            ],
        ];
    }
}
