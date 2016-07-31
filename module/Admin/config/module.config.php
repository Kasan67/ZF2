<?php

namespace Admin;

return array(
    
    'doctrine' => array(
        'driver' => array(
            'admin_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Admin/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Admin\Entity' => 'admin_entity'
                ),
            )
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Admin\Entity\Customer',
                'identity_property' => 'login',
                'credential_property' => 'password',
                'credential_callable' => function( $user, $passwordGiven) {
                    if($user->getPassword() == $passwordGiven){
                        return true;
                    }else{
                        return false;
                    }
                },
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'index'    =>  'Admin\Controller\IndexController',
            'category' =>  'Admin\Controller\CategoryController',
            'customer' =>  'Admin\Controller\CustomerController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/admin/',
                    'defaults' => array(
                        'controller' => 'index',
                        'action'     => 'login',
                    ),
                ),
                'may_terminate' => true,
            
                'child_routes' => array(
                    'category' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'category/[:action/][:id/][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'controller' => 'category',
                                'action' => 'index'
                            )
                        )
                    ),
                    'customer' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'customer/[:action/][:id/][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'controller' => 'customer',
                                'action' => 'index'
                            )
                        )
                    ),
                    'default' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'admin/[:action/[:id/]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ), //child_routes
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'admin_navigation' => 'Admin\Lib\AdminNavigationFactory',
        ),
    ),
    'navigation' => array(
        
        'default' => array(
            array(
                'label' => 'Главная',
                'route' => 'home',
            ),
        ),
        'admin_navigation' => array(
            array(
                'label' => 'Панель управления',
                'route' => 'admin',
                'action' => 'index',
                'resuorce' => 'Admin\Controller\Index',
                
                'pages' => array(
                    array(
                        'label' => 'Пользователи',
                        'route' => 'admin/customer',
                        'action' => 'index',
                    ),
                    array(
                        'label' => 'Добавить пользователя',
                        'route' => 'admin/customer',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Категории',
                        'route' => 'admin/category',
                        'action' => 'index',
                    ),
                    array(
                        'label' => 'Добавить категорию',
                        'route' => 'admin/category',
                        'action' => 'add',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'display_exceptions' => true,
    ),
    
);
