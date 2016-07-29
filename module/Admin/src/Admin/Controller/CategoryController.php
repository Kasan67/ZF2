<?php

namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;
use Admin\Form\CategoryAddForm;
use Admin\Entity\Category;
use Zend\Db\Sql\Select;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

//use Admin\Model\CategoryTable;

class CategoryController extends BaseController
{
    public function indexAction()
    {
        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;

        $query = $this->getEntityManager()->createQueryBuilder();
        $query
            ->select('u')
            ->from('Admin\Entity\Category', 'u')
            ->orderBy('u.'.$order_by, $order);
        
        $adapter = new DoctrineAdapter(new ORMPaginator($query));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(3);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        
        return array('category' => $paginator,
                    'order_by' => $order_by,
                    'order' => $order,
                    );
        
    }
    
    public function addAction()
    {
        $form = new CategoryAddForm;
        $status = $message = '';
        $em = $this->getEntityManager();
        
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $category = new Category();
                $category->exchangeArray($form->getData());
                
                $em->persist($category);
                $em->flush();
                
                $status = 'success';
                $message = 'Категория добавлена';
                
            }else{
                $status = 'error';
                $message = 'Ошибка параметров';
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
        
        return $this->redirect()->toRoute('admin/category');
    }
    
    public function editAction()
    {
        $status = $message = '';
        $em = $this->getEntityManager();
        $form = new CategoryAddForm;
        
        $id = (int) $this->params()->fromRoute('id', 0);
        
        $category = $em->find('Admin\Entity\Category', $id);
        if(empty($category)){
            $message = "Категория не найдена";
            $status = "error";
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
            return $this->redirect()->toRoute('admin/category');
        }
           
        $form->bind($category);
           
        $request = $this->getRequest();
           
        if($request->isPost())
        {
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid())
            {
                $em->persist($category);
                $em->flush();
                
                $status = 'success';
                $message = 'Категория обновлена';
                
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
        return $this->redirect()->toRoute('admin/category');
    }
    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();
        $status = 'success';
        $message = 'Категория удалена';
        
        try {
            $repository = $em->getRepository('Admin\Entity\Category');
            $category = $repository->find($id);
            $em->remove($category);
            $em->flush();
        }
        catch (\Exception $ex){
            $status = 'error';
            $message = 'Ошибка удаления категории: ' . $ex->getMessage();
        }
        $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
        return $this->redirect()->toRoute('admin/category');
    }
}
