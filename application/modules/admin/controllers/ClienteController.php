<?php

class Admin_ClienteController extends App_Controller_Action
{
    protected $_mCliente;

    public function init() 
    {
       parent::init();
    }
    
    public function indexAction()
    {        
        //$this->_flashMessenger->addMessage("Ejemplo");
        $form = new App_Form_BuscarCliente();
        $modelCliente = new App_Model_Cliente();
        
        $result = $modelCliente->lista();
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $form->populate($data);
            $result = $modelCliente->buscarClientes($data);            
        }
        
        
        $this->view->form = $form;
        
        
        
        $this->view->result = $result; 
    }
    
    public function nuevoAction()
    {

    }
    public function eliminarAction()
    {
        //if ($this->isAuth){        
        $modelCliente = new App_Model_Cliente();
        $id = $this->_getParam('id');
        $data = array(
            'idCliente' => $id,
            'estado' => App_Model_Cliente::ESTADO_ELIMINADO
        );        
        $modelCliente->actualizarDatos($data);
        $this->_flashMessenger->addMessage("Cliente eliminado con exito");
        $this->_redirect('/cliente');
        //}
    }

}