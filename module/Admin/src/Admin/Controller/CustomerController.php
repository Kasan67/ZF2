<?php

namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Admin\Entity\Customer;
use Admin\Form\CustomerAddForm;
use Admin\Form\UploadForm;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Select;

class CustomerController extends BaseController
{ 
    public function indexAction()
    {
        $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('u')
              ->from('Admin\Entity\Customer', 'u')
              ->orderBy('u.'.$order_by, $order);
        $adapter = new DoctrineAdapter(new ORMPaginator($query));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(3);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        
        return array(
                    'customers' => $paginator,
                    'order_by' => $order_by,
                    'order' => $order,
                    );
    }
    
    public function addAction()
    {
        $em = $this->getEntityManager();
        $form = new CustomerAddForm($em);
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $message = '';
            $status = '';
            $data = $request->getPost();
            $customer = new Customer();
            $form->setHydrator(new DoctrineHydrator($em, '\Customer'));
            $form->bind($customer);
            $form->setData($data);
            
            if ($form->isValid()) {
                $em->persist($customer);
                $em->flush();
                $status = 'success';
                $message = 'Пользователь добавлен';
            } else {
                $status = 'error';
                $message = 'Ошибка параметров';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors) {
                    foreach ($errors->getMessages() as $error) {
                        $message .= ' ' . $error;
                    }
                }
            }
        } else {
            return array('form' => $form);
        }
        if ($message) {
            $this->flashMessenger()
                 ->setNamespace($status)
                 ->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/customer');
    }
    
    public function editAction()
    {
        $status = '';
        $message = '';
        $em = $this->getEntityManager();
        $form = new CustomerAddForm($em);
        $id = (int) $this->params()->fromRoute('id', 0);
        $customer = $em->find('Admin\Entity\Customer', $id);
        
        if (empty($customer)) {
            $message = 'Пользователь не найден';
            $status = 'error';
            $this->flashMessenger()
                 ->setNamespace($status)
                 ->addMessage($message);
            return $this->redirect()->toRoute('admin/customer');
        }
        $form->setHydrator(new DoctrineHydrator($em, '\Customer'));
        $form->bind($customer);
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $em->persist($customer);
                $em->flush();
                $status = 'success';
                $message = 'Данные обновлены';
            } else {
                $status = 'error';
                $message = 'Ошибка параметров';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors) {
                    foreach ($errors->getMessages() as $error) {
                        $message .= ' ' . $error;
                    }
                }
            }
        } else {
            return array('form' => $form, 'id' => $id);
        }
        if ($message) {
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
        catch (\Exception $ex) {
            $status = 'error';
            $message = 'Ошибка удаления: ' . $ex->getMessage();
        }
        $this->flashMessenger()
             ->setNamespace($status)
             ->addMessage($message);
        return $this->redirect()->toRoute('admin/customer');
    }
    
    public function uploadAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $form = new UploadForm('upload-form');
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $post['image-file']['name'] = $id;
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $customer = $em->find('Admin\Entity\Customer', $id);
                $type = $post['image-file']['type'];
                $data = $form->getData();
                $customer->setAvatarExtension($type);
                $em->persist($customer);
                $em->flush();
                return $this->redirect()->toRoute('admin/customer');
            }
        }
        return array('form' => $form);
    }
}