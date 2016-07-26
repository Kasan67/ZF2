<?php 

namespace Admin\Filter;

use Zend\InputFilter\InputFilter;

class CustomerAddInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'     => 'login',
            'required' => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 100,
                    ),
                ),
            ),
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ), 
        ));
        
        $this->add(array(
            'name'     => 'password',
            'required' => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'max' => 100,
                    ),
                ),
            ),
            'filters'  => array(
                array('name' => 'StringTrim'),
            ), 
        ));
        
        
        $this->add(array(
            'name'     => 'email',
            'required' => true,
            'filters'  => array(
                array('name' => 'StringTrim'),
            ), 
        ));
        
        
        $this->add(array(
            'name'     => 'category',
            'required' => true,
        ));
    }
}