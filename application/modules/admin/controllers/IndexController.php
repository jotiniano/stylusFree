<?php

class Admin_IndexController extends App_Controller_Action
{

    public function indexAction()
    {   
    	$this->_flashMessenger->addMessage("Ejemplo");
        //$this->_helper->layout->setLayout('layout-prueba');        
        $this->_flashMessenger->addMessage("aaaaaaa");
        echo "holaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";    
    }
    public function index2Action()
    {       
        
    }    

}

