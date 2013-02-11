<?php

class Admin_AgendaController extends App_Controller_Action
{
    protected $_mCliente;

    public function init() 
    {
       parent::init();
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            echo $this->_redirect($this->view->url(array("module" => "admin",
                        controller => "auth",
                        action => "index")));
        }
    }
    
    public function indexAction()
    {
        //CSS
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/fullcalendar/fullcalendar.css'
        );
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/fullcalendar/fullcalendar.print.css',
            array('media' => 'print')
        );
        
        //Javascripts
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/fullcalendar/jquery-ui-1.8.23.custom.min.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/fullcalendar/fullcalendar.min.js'
        );


        //$this->_flashMessenger->addMessage("Ejemplo");
    }
    
    public function nuevoAction()
    {

    }
    public function listarAction()
    {

    }

}