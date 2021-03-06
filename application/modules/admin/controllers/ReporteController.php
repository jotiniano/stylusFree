<?php
class Admin_ReporteController extends App_Controller_Action
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
         $this->view->activeReporte = 'class="active"';
        
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/datepicker-bootstrap/datepicker.css'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/datepicker-bootstrap/bootstrap-datepicker.js'
        );
        
        $form = new App_Form_FiltrarReporte();
        $modelReporte = new App_Model_Reporte();
        $result = array();
        if($this->getRequest()->isPost()){
            $dato = $this->getRequest()->getPost();
            $result = $modelReporte->listarReporte($dato);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
    }
    
    public function estilistaAction(){
        $this->view->activeEstilista = 'class="active"';
        
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/datepicker-bootstrap/datepicker.css'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/datepicker-bootstrap/bootstrap-datepicker.js'
        );
        
        $form = new App_Form_FiltrarReporte();
        $modelReporte = new App_Model_Reporte();
        $result = array();
        $dato = array();
        if($this->getRequest()->isPost()){
            $dato = $this->getRequest()->getPost();
            $result = $modelReporte->getReporteEstilista2($dato);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
        $this->view->dato = $dato;
    }


    public function ventaDiariaAction(){
        $this->view->activeVentaDiaria = 'class="active"';
        $fecha = Zend_Date::now()->toString('YYYY-MM-dd');
        $this->view->fecha = $fecha;
        $modelReporte = new App_Model_Reporte();
        $ventaDiaria = $modelReporte->listarVentaDiaria($fecha);
        $this->view->ventaDiaria = $ventaDiaria;
        
    }
    
    public function ventaDiariaDetalleAction(){
        $this->view->activeVentaDiaria = 'class="active"';
        $idticket = $this->_getParam('id');
        
        $modelReporte = new App_Model_Reporte();
        $ticket = $modelReporte->getTicket($idticket);
        $detalleTicket = $modelReporte->getDetalleTicket($idticket);
        
        $this->view->ticket = $ticket;
        $this->view->detalleTicket = $detalleTicket;
    }
    
   

}