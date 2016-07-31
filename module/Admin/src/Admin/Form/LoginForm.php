<?php

namespace Admin\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = 'null')
    {
        parent::__construct('loginForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');
        
        $this->add(array(
            'name' => 'login',
            'type' => 'Text',
            'options' => array(
                'min' => 3,
                'max' => 50,
                'label' => 'Login',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'min' => 3,
                'max' => 50,
                'label' => 'Password',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Вход',
                'id' => 'btn_submit',
                'class' => 'btn btn-success'
            ),
        ));
    }
}