<?php

class Admin_IndexController extends App_Controller_Action
{

    public function indexAction()
    {   
    	$this->_flashMessenger->addMessage("Ejemplo");
        //$this->_helper->layout->setLayout('layout-prueba');        
    }
    public function index2Action()
    {       
        
    }    

}

