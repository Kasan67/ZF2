<?php

namespace AdminPage;

use AdminPage\Model\AdminPageTable;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            "factories" => array(
                "AdminPage\Model\AdminPageTable" => function ($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new AdminPageTable($dbAdapter);
                    return $table;
                },
            ),
        );
    }
}
