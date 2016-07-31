<?php

namespace Admin\Controller;

use Application\Controller\BaseController as BaseController;
use Admin\Entity\Customer;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Admin\Form\LoginForm;

class IndexController extends BaseController
{
    public function indexAction()
    {
        
    }
    
    public function loginAction()
    {
        $em = $this->getEntityManager();
        $user = new Customer();
        $form = new LoginForm();
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $form->getData();
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($user['login']);
                $adapter->setCredentialValue($user['password']);
                $authResult = $authService->authenticate();
                if ($authResult->isValid()) {
                    return $this->redirect()->toRoute('admin');
                }
            }
        }
        return array('form' => $form);
    }
    
    public function logoutAction()
    {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
        }
        $auth->clearIdentity();
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->forgetMe();
        
        return $this->redirect()->toRoute('admin/default', array('controller' => 'index', 'action' => 'login'));
    }
}
