<?php

namespace AdminPage\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class AdminPageTable extends AbstractTableGateway
{
    protected $table = 'customer';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new AdminPage());
        
        $this->initialize();
        
    }
    
    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }
    
    public function getCustomer($id)
    {
        $id = (int)$id;
        $rowSet = $this->select(array(
            'id' => $id,
        ));
        $row = $rowSet->current();
        
        if (!$row) { 
            throw new Exception("Could not find row $id");
        }
        
        return $row;
    }
    
    public function saveCustomer(AdminPage $page)
    {
        $data = array('group_id' => $page->group_id,
                      'login' => $page->login,
                      'email' => $page->email,
                      'account_expire' => $page->account_expire,
                      'avatar_extension' => $page->avatar_extension,
                     );
        $id = (int) $page->id;
        
        if(!$id){
            $this->insert($data);
        }elseif($this->getCustomer($id)){
            $this->update(
                    $data, 
                    array(
                        'id' => $id,
                    )
                );
        }else {
            throw new Exception('Form id does not exist');
        }
    }
    
    public function deleteCustomer($id)
    {
        $this->delete(array(
            'id' => $id, 
            ));
    }
    
}