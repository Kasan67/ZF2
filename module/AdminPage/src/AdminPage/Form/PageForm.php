<?php

namespace AdminPage\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use AdminPage\Model\AdminPage;
//use Zend\Form\Fieldset;

class PageForm extends Form
{
    public function __cunstruct($name = null)
    {
        parent::__construct('page');
        $this->setAttribute('method', 'post');
//        $this->setAttribute('enctype', 'multipart/form-data');
//        $this->setAttribute('id', 'pageform');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        )); 
        $this->add(array(
            'name' => 'group_id',
            'attributes' => array(
                'type'  => 'number',
            ),
        ));
        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'login',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'password',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'email',
            ),
        ));
        $this->add(array(
            'name' => 'account_expired',
            'attributes' => array(
                'type'  => 'date',
            ),
            'options' => array(
                'label' => 'Date to',
            ),
        ));  
        $this->add(array(
            'name' => 'avatar_extension',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'jpeg',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'Submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}