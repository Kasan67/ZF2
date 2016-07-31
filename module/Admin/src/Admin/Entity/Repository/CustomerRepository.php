<?php

namespace Admin\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function login($user, $sm){
        $authService = $sm->get('Zend\Authentication\AuthenticationService');
        $adapter = $authService->getAdapter();
        $adapter->setIdentityValue($user['login']);
        $adapter->setCredentialValue($user['password']);
        $authResult = $authService->authenticate();
        $identity = null;
        
        if ($authResult->isValid()) {
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
        }
        
        return $authResult;
    }
}