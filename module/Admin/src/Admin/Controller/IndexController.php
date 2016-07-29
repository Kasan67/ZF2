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
        
        $messages = null;
        $request = $this->getRequest();
        
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $user = $form->getData();
                
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
//                
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($user['login']);
                $adapter->setCredentialValue($user['password']);
                //ломается на этой строке при вызове $authService->authenticate() с ошибкой The class 'Admin\Entity\Customer' was not found in the chain configured namespaces 
                $authResult = $authService->authenticate();
                $identity = null;
                
                if($authResult->isValid()){
                    $identity = $authResult->getIdentity();
                    $authService->getStorage()->write($identity);
                }
                
                
                //$authResult = $em->getRepository('Admin\Entity\Customer')->login($user, $this->getServiceLocator());
//                if($authResult->getCode() != \Zend\Authentication\Result::SUCCESS){
//                    foreach($authResult->getMessages() as $message){
//                        $messages .= "$message\n";
//                    }
//                }else{
//                    return array(
//                        
//                    );
//                }
            } 
        }
        
//        $data = $this->getRequest()->getPost();
//
//        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
//
//        $adapter = $authService->getAdapter();
//        $adapter->setIdentityValue($data['login']);
//        $adapter->setCredentialValue($data['password']);
//        $authResult = $authService->authenticate();
//
//        if ($authResult->isValid()) {
//            return $this->redirect()->toRoute('/admin/');
//        }
//
//        return new ViewModel(array(
//            'error' => 'Your authentication credentials are not valid',
//        ));

        return array( 
            'form' => $form,
            'message' => $messages,
        );
    }
    
    
}
