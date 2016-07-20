<?php

namespace AdminPage\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AdminPage\Model\AdminPage;
use AdminPage\Form\PageForm;

class PageController extends AbstractActionController
{
    protected $pageTable;
    
    //http://zf2app/page
    //AdminPage/Controller/Pagecontroller::indexAction
    public function indexAction()
    {
        return new ViewModel(
            array(
                'customer' => $this->getPageTable()->fetchAll(),
            )
        );
    }
    
    //http://zf2app/page/delete
    //AdminPage/Controller/Pagecontroller::deleteAction
    public function deleteAction()
    {
        return new ViewModel();
    } 
    
    //http://zf2app/page/modify
    //AdminPage/Controller/Pagecontroller::modifyAction
    public function modifyAction()
    {
        return new ViewModel();
    } 
    
    //http://zf2app/page/add
    //AdminPage/Controller/Pagecontroller::addAction
    public function addAction()
    {
        $form = new PageForm();
        $request = $this->getRequest();
        
        if($request->isPost()){
            $page = new AdminPage();
            
            $form->setInputFilter($page->getInputFilter());
            $form->setData($request->getPost());
            
            if($form->isValid()){
                $page->exchangeArray($form->getData());
                $this->getPageTable()->saveCustomer($page);
                
                return $this->redirect()->toRoute("adminpage");
            }
        }
        return array( 'form' => $form );
    }
    
    public function getPageTable()
    {
        if(!$this->pageTable){
            $sm = $this->getServiceLocator();
            $this->pageTable = $sm->get("AdminPage\Model\AdminPageTable");
        }
        return $this->pageTable;
        
    }
}
