<?php

return array(
    'router' => array(
        'routes' => array(
            'adminpage' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/page[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AdminPage\Controller\Page',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'AdminPage\Controller\Page' => 'AdminPage\Controller\PageController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'page' => __DIR__ . '/../view',
        ),
    ),
    'form_elements' => array(
    'invokables' => array(
        'page-form' => 'AdminPage\Form\PageForm',
        )
    )
);
