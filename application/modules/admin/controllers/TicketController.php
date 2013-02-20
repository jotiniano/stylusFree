<?php

class Admin_TicketController extends App_Controller_Action
{
     public function init() {
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
        $form = new App_Form_BuscarTicket();
        $modelTicket = new App_Model_Ticket();
        
        $result = $modelTicket->lista();
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $form->populate($data);
            $result = $modelTicket->lista($data);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
    }
    
    public function index2Action()
    {
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/admin/ticket.js'
        );
        $form = new App_Form_RegistrarIngresos();
        
        $this->view->form = $form;
        
        if ($this->_request->isPost()) {
            var_dump($this->_getAllParams());
            exit;
        }
    }


    public function nuevoAction()
    {   
        $idCliente = $this->_getParam('id', "");
        $this->view->idCliente = $idCliente;
        
        $idUsuario = $this->authData->idUsuario;
        $name = "";
        
        if($idCliente) {
            $modelCliente = new App_Model_User();
            $user = $modelCliente->getUsuarioPorId($idCliente, 3);
            $name = $user['nombreUsuario'] . ' ' . $user['apellidoUsuario'];
        }
        $this->view->nombreUser = $name;
        
        $modelUsuario = new App_Model_User();
        $this->view->users = $modelUsuario->getUsuarioWork();
        
        $modelServicio = new App_Model_Servicio();
        $this->view->servicios = $modelServicio->getServicioPorId();        
        
        $this->view->headScript()->appendFile(
                $this->getConfig()->app->mediaUrl . '/js/admin/ticket.js'
        );
        //Javascripts
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/fullcalendar/jquery-ui-1.8.23.custom.min.js'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/fullcalendar/fullcalendar.min.js'
        );

        //autocomplete
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/bootstrap-typeahead-new.js'
        );
        
        if ($this->_request->isPost()) {
            $data = $this->_getAllParams();            
            
            $modelTicket = new App_Model_Ticket();
            $modelTicketDeta = new App_Model_TicketDetalle();
            $total = array_sum($data["detalleCosto"]);            
            
            $dataTicket = array(
                'idUsuario' => $idUsuario,
                'fechaCreacion' => Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss'),
                'idCliente' => $data["otroCliente"],
                'total' => $total,

            );                        
            
            $idTicket = $modelTicket->actualizarDatos($dataTicket);            
            $detalle = array();
            $tam = sizeof($data['detalleServicio']);
            
            for ($i = 0; $i < $tam; $i++) {
                $detalle['idTicket'] = $idTicket;
                $detalle['idServicio'] = $data['detalleServicio'][$i];
                $detalle['precio'] = $data['detalleCosto'][$i];
                $detalle['idUsuario'] = $data['detalleWorker'][$i];                
                $modelTicketDeta->actualizarDatos($detalle);                
                
            }
            
            $this->_flashMessenger->addMessage("Ticket Generado con exito : ");
            $this->_flashMessenger->addMessage("Total por Servicio : " . $total);            
            
            $this->_redirect('/ticket/nuevo');
            
            
        }

    }

}

