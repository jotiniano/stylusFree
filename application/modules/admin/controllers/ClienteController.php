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
        
        
        $this->view->form = $form;
        
        
        
        $this->view->result = $result; 
    }
    
    public function nuevoAction()
    {

    }
    public function listarAction()
    {

    }

}