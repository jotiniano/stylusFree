<?php

class Admin_TicketController extends App_Controller_Action
{

    public function indexAction()
    {   
        //$this->_helper->layout->setLayout('layout-prueba');        
        $this->_flashMessenger->addMessage("ticket");
    }

}

