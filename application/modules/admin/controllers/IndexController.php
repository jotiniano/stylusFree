<?php

class Admin_IndexController extends App_Controller_Action
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
        $this->view->idTipoUsuario = $this->authData->idTipoUsuario;
        
    }
    public function index2Action()
    {       
        
    }    

}

