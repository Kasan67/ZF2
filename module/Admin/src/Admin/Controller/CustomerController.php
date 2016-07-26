<?php

namespace Admin\Controller;

use Application\Controller\BaseController as BaseController;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

use Admin\Entity\Customer;

use Admin\Form\CustomerAddForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

//use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

class CustomerController extends BaseController
{
    
    protected function getUserForm(Customer $user)
    {
        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm('Admin\Entity\Customer');
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), '\Customer'));
        $form->bind($user);
        
        return $form;
    }
    
//    protected function getLoginForm(User $user)
//    {
//        $form = $this->getUserForm($user);
//        $form->setAttribute('action', '/auth-doctrine/index/login/');
//        $form->setValidationGroup('usrName', 'usrPassword');
//        
//        return $form;
//    }
    
    protected function getRegForm(Customer $user)
    {
        $form = $this->getUserForm($user);
        $form->setAttribute('action', '/admin/customer/add/');
        $form->get('submit')->setAttribute('value', 'Зарегистрировать');
        $form->get('email')->setAttribute('type', 'email');
        
        return $form;
    }
    
    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query
            ->select('u')
            ->from('Admin\Entity\Customer', 'u')
            ->orderBy('u.id', 'DESC');

        $adapter = new DoctrineAdapter(new ORMPaginator($query));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(3);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        
        return array('customers' => $paginator);
    }
    
    public function addAction()
    {
        
        $em = $this->getEntityManager();
        $form = new CustomerAddForm($em);
        
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $message = $status = '';
            
            $data = $request->getPost();
            $customer = new Customer();
            $form->setHydrator(new DoctrineHydrator($em, '\Customer'));
            $form->bind($customer);
            $form->setData($data);
            
            if($form->isValid())
            {
                $em->persist($customer);
                $em->flush();
                
                $status = 'success';
                $message = 'Пользователь добавлен';
            }else{
                $status = 'error';
                $message = 'Ошибка параметров';
                foreach($form->getInputFilter()->getInvalidInput() as $errors){
                    foreach($errors->getMessages() as $error){
                        $message .= ' ' . $error;
                    }
                }
            }
        }else{
            return array('form' => $form);
        }
        
        if($message)
        {
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/customer');
    }
    
    public function editAction()
    {
        $status = $message = '';
        $em = $this->getEntityManager();
        $form = new CustomerAddForm($em);
        
        $id = (int) $this->params()->fromRoute('id', 0);
        
        $customer = $em->find('Admin\Entity\Customer', $id);
        if(empty($customer)){
            $message = "Пользователь не найден";
            $status = "error";
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
            return $this->redirect()->toRoute('admin/customer');
        }
        
        $form->setHydrator(new DoctrineHydrator($em, '\Customer'));
        $form->bind($customer);
        
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $data = $request->getPost();
            $form->setData($data);
            
            if($form->isValid())
            {
                $em->persist($customer);
                $em->flush();
                
                $status = 'success';
                $message = 'Данные обновлены';
            }else{
                $status = 'error';
                $message = 'Ошибка параметров';
                foreach($form->getInputFilter()->getInvalidInput() as $errors){
                    foreach($errors->getMessages() as $error){
                        $message .= ' ' . $error;
                    }
                }
            }
        }else{
            return array('form' => $form, 'id' => $id);
        }
        
        if($message)
        {
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/customer');
    }
    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();
        $status = 'success';
        $message = 'Пользователь удален';
        
        try {
            $repository = $em->getRepository('Admin\Entity\Customer');
            $item = $repository->find($id);
            $em->remove($item);
            $em->flush();
        }
        catch (\Exception $ex){
            $status = 'error';
            $message = 'Ошибка удаления: ' . $ex->getMessage();
        }
        $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
        return $this->redirect()->toRoute('admin/customer');
    }
}