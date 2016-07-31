<?php

namespace Admin\Form;

use Zend\InputFilter;
use Zend\Form\Element;
use Zend\Form\Form;

class UploadForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->addInputFilter();
    }

    public function addElements()
    {
        $file = new Element\File('image-file');
        $file->setLabel('Image Upload: ')
             ->setAttribute('id', 'image-file');
        $this->add($file);
    }
    public function addInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();
        $fileInput = new InputFilter\FileInput('image-file');
        $fileInput->setRequired(true);
        $fileInput->getValidatorChain()
            ->attachByName('filesize',      array('max' => 204800))
            ->attachByName('filemimetype',  array('mimeType' => 'image/png, image/jpeg, image/gif'))
            ->attachByName('fileimagesize', array('maxWidth' => 2000, 'maxHeight' => 2000));
        $fileInput->getFilterChain()
            ->attachByName('filerenameupload', array(
                'target'    => './public/upload/',
                'use_upload_extension' => true,
                'overwrite'       => true,
                'use_upload_name' => true,
            ));
        $inputFilter->add($fileInput);
        $this->setInputFilter($inputFilter);
    }
}