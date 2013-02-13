<?php

class Admin_AgendaController extends App_Controller_Action
{
    protected $_mCliente;

    public function init() 
    {
       parent::init();
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            echo $this->_redirect(
                $this->view->url(
                    array(
                        "module" => "admin",
                        controller => "auth",
                        action => "index"
                    )
                )
            );
        }
    }
    
    public function indexAction()
    {
        


        $r = new App_Model_Reserva();
        $listado = "";
        $reservas = $r->listarReserva();
        foreach ($reservas as $key => $value) {
            $listado[$key]["title"] = $value["idReserva"]."|".$value["nombre"]." ".$value["apellidos"];
            $listado[$key]["start"] = date('D, d M y H:i:s', strtotime($value["fechaIni"]))." 0000";
            $listado[$key]["end"] = date('D, d M y H:i:s', strtotime($value["fechaFin"]))." 0000";
            $listado[$key]["allDay"] = false;
        }

        $this->view->reservas = json_encode($listado);

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

        //Mensajes
        $p = $this->_getParam("ac");
        
        if ($p=="er") {
            $this->_flashMessenger->addMessage("Reserva Eliminada con Exito");
        }
        if ($p=="ar") {
            $this->_flashMessenger->addMessage("Reserva Agregada con Exito");
        }
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
        $c = new App_Model_Cliente();
        $lista = $c->listarByQuery($buscar);
        $clientes = "";
        foreach ($lista as $index=>$item) {

            $clientes[$index]["id"] = $item["idCliente"];
            $clientes[$index]["value"] = $item["nombreCliente"]." ".$item["apellidoCliente"];;
        }
        echo json_encode($clientes);
    }

    public function eliminarReservaAction()
    {
        $r = new App_Model_Reserva();
        $idReserva = $this->_getParam("idReserva");
        if (isset($idReserva)) {
            $r->eliminarReserva($idReserva);
            $this->_redirect('/agenda?ac=er');
        } else {
            $this->_redirect('/agenda');
        }
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

        if (isset($idcliente)) {
            //Agregar la Reserva
            $nfi = explode("-", $fechaIni);
            $nff = explode("-", $fechaFin);


            $data["fechaIni"] = $nfi[2]."-".$nfi[1]."-".$nfi[0]." ".$horaIni;
            $data["fechaFin"] = $nff[2]."-".$nff[1]."-".$nff[0]." ".$horaFin;
            $data["descripcion"] = $descripcion;
            $data["idCliente"] = $idcliente;
            $data["idUsuario"] = $this->view->authData->idUsuario;

           

            $r = new App_Model_Reserva();
            $idReserva = $r->insertarReserva($data);

            //Fin Agregar Reserva
            
            $result["status"] = "true";
            $result["url"] = "agenda?ac=ar";
            echo json_encode($result);
        } else {
            $result["status"] = "false";
        }
    }


}