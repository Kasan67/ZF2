<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Admin\Filter\CustomerAddInputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Admin\Entity\Customer;

class CustomerAddForm extends Form implements ObjectManagerAwareInterface
{
    
    protected $objectManager;
    
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager; 
    }
    
    public function getObjectManager()
    {
        return $this->objectManager; 
    }
    
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('customerAddForm');
        $this->setObjectManager($objectManager);
        $this->createElements();
    }
    
    public function createElements()
    {
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');
        
        $this->setInputFilter(new CustomerAddInputFilter());
        
        $this->add(array(
            'name' => 'category',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Category',
                'empty_option' => 'Выберите категорию... ',
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Admin\Entity\Category',
                'property' => 'categoryName'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));
        
        $this->add(array(
            'name' => 'login',
            'type' => 'Text',
            'options' => array(
                'min' => 3,
                'max' => 100,
                'label' => 'Login',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Text',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));
        
        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'min' => 3,
                'max' => 100,
                'label' => 'Email',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));
        
        $this->add(array(
            'name' => 'accountExpired',
            'type' => 'date',
            'options' => array(
                'label' => 'Date',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));
        
        $this->add(array(
            'name' => 'avatarExtension',
            'type' => 'text',
            'options' => array(
                'label' => 'avatarExtension',
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Сохранить',
                'id' => 'btn_submit',
                'class' => 'btn btn-success'
            ),
        ));
    }
    
}