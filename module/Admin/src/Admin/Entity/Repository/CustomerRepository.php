<?php

namespace Admin\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function login(\Admin\Entity\Customer $user, $sm){
        $authService = $sm->get('Zend\Authentication\AuthenticationService');
        $adapter = $authService->getAdapter();
        $adapter->setIdentityValue($user->getLogin());
        $adapter->setCredentialValue($user->getPassword());
        $authResult = $authService->authenticate();
        $identity = null;
        
        if($authResult->isValid()){
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
        }
        
        return $authResult;
    }
}