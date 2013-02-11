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
        $p = $this->_getParam("action");
        if ($p=="er") {
            $this->_flashMessenger->addMessage("Reserva Eliminada con Exito");
        }
        if ($p=="ar") {
            $this->_flashMessenger->addMessage("Reserva Agregada con Exito");
        }

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

        //datepicker
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/datepicker-bootstrap/datepicker.css'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/datepicker-bootstrap/bootstrap-datepicker.js'
        );

        //timepicker
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/timepicker/bootstrap-timepicker.min.css'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/timepicker/bootstrap-timepicker.min.js'
        );

        //autocomplete
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/bootstrap-typeahead-new.js'
        );

        //Helper Date
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/dateHelper.js'
        );

        //$this->_flashMessenger->addMessage("Ejemplo");
    }
    
    public function nuevaReservaAction()
    {
        $this->_helper->layout()->disableLayout();

        $this->view->start = $this->_getParam('start');
        $this->view->end = $this->_getParam('end');
        $this->view->allDay = $this->_getParam('allDay');
    }

    public function listarClientesAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $buscar = $this->_getParam("query");
        /*$repoUser = new App_Model_Cliente();
        $lista = $repoUser->listUsernames($buscar);
        $usernames = "";
        foreach ($lista as $item) {
            $usernames[]["value"] = $item->getUsername();
        }*/
        $clientes[0]["id"] = "1";
        $clientes[0]["value"] = "Solman Vaisman";
        
        echo json_encode($clientes);
    }
    public function eliminarReservaAction()
    {
        $this->_redirect('/agenda?action=er');
    }
    public function registrarReservaAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $fechaIni = $this->_getParam("fecha_reserva_ini");
        $fechaFin = $this->_getParam("fecha_reserva_fin");
        $horaIni = $this->_getParam("hora_reserva_ini");
        $horaFin = $this->_getParam("hora_reserva_fin");
        $descripcion = $this->_getParam("descripcion");
        $idcliente = $this->_getParam("idcliente");
        
        //Agregar la Reserva


        //Fin Agregar Reserva
        
        $result["status"] = "false";
        $result["url"] = "agenda?action=ar";
        echo json_encode($result);
    }


}