<?php

class Admin_AlertaController extends App_Controller_Action
{

    public function init()
    {
        parent::init();
        /* Initialize action controller here */
        
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            echo $this->_redirect($this->view->url(array("module" => "admin",
                        controller => "auth",
                        action => "index")));
        }
    }
    
    public function indexAction()
    {       	
        $this->view->activeAlerta = 'class="active"';
        $modelAlerta = new App_Model_Alerta();
        $this->view->listarAlerta = $modelAlerta->listarAlerta();
        
    }
 
    
    public function eliminarAction(){
        $modeloAlerta = new App_Model_Alerta();
        $modeloCliente = new App_Model_Cliente();
        $id = $this->_getParam('id');
        $idC = $this->_getParam('idC');
        $dataCliente['idCliente'] = $idC;
        $dataCliente['alerta'] = "0";
        $modeloCliente->actualizarDatos($dataCliente);

        $modeloAlerta->deleteAlerta($id);
        $this->_flashMessenger->addMessage("Alerta eliminada con exito");
        $this->_redirect('/cliente/');
                
    }

}

