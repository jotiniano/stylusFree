<?php
class Admin_ClienteController extends App_Controller_Action
{
    protected $_mCliente;

    
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
        $this->view->activeCliente = 'class="active"';
    }
    
    public function indexAction()
    {        
        //$this->_flashMessenger->addMessage("Ejemplo");
        $form = new App_Form_BuscarCliente();
        $modelCliente = new App_Model_Cliente();
        
        $result = $modelCliente->lista();
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $form->populate($data);
            $result = $modelCliente->buscarClientes($data);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
    }
    
    public function crearAction()
    {        
        //datepicker
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/datepicker-bootstrap/datepicker.css'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/datepicker-bootstrap/bootstrap-datepicker.js'
        );
        $form = new App_Form_CrearCliente();
        $this->view->form = $form; 
        if($this->getRequest()->isPost()){            
            
            $data = $this->getRequest()->getPost();
            
            if ($form->isValid($data)) {
                $modelCliente = new App_Model_Cliente();
                $fecha = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['fechaUltimaVisita'] = $fecha;
                $data['estado'] = App_Model_Cliente::ESTADO_ACTIVO;
                $data['totalVisitas'] = 1;
                $data['idTipoUsuario'] = App_Model_User::TIPO_CLIENTE;
                $id = $modelCliente->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Cliente guardado con exito");
                $this->_redirect('/cliente');
                
            } else {
                $form->populate($data);                
            }
        }
    }
    
    public function editarAction()
    {   
        //datepicker
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/datepicker-bootstrap/datepicker.css'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/datepicker-bootstrap/bootstrap-datepicker.js'
        );
        $modelCliente = new App_Model_Cliente();
        $form = new App_Form_CrearCliente();
        $id = $this->_getParam('id');
        $cliente = $modelCliente->getClientesPorId($id);
        $form->populate($cliente);        
        $fecha =  $form->fechaNacimiento->getValue(); 
        if ($fecha == 0) $form->fechaNacimiento->setValue("");
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getParams();            
            $data['idCliente'] = $id;
            if ($form->isValid($data)) {                
                $id = $modelCliente->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Cliente editado con éxito");
                $this->_redirect('/cliente/');
                
            } else {
                $form->populate($data);                
            }
        }
        $this->view->form = $form;
    }
    
    
    public function eliminarAction()
    {
        //if ($this->isAuth){        
        $modelCliente = new App_Model_Cliente();
        $id = $this->_getParam('id');
        $data = array(
            'idCliente' => $id,
            'estado' => App_Model_Cliente::ESTADO_ELIMINADO
        );        
        $modelCliente->actualizarDatos($data);
        $this->_flashMessenger->addMessage("Cliente eliminado con exito");
        $this->_redirect('/cliente');
        //}
    }

    public function alertaAction(){
         //datepicker
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/datepicker-bootstrap/datepicker.css'
        );
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/datepicker-bootstrap/bootstrap-datepicker.js'
        );
        $form = new App_Form_CrearAlerta();
        $this->view->form = $form; 
        
        $modelCliente = new App_Model_Cliente();
        $form = new App_Form_CrearCliente();
        $id = $this->_getParam('id');
        $cliente = $modelCliente->getClientesPorId($id);
        $this->view->dataCliente = $cliente;
        if($this->getRequest()->isPost()){            
            
            $dato = $this->getRequest()->getPost();
            
                $modelAlerta = new App_Model_Alerta();
                $data = array(
                'idCliente'   => $id,
                'fechaAlerta'   => $dato['fechaAlerta'],
                'descripcion'   => $dato['descripcion'],
                'atendido' => "0",
                    
                );
                
                $dato['idCliente'] = $id;
                $dato['alerta'] = "1";
                
                $idCliente = $modelCliente->actualizarDatos($dato);
                $idAlerta = $modelAlerta->insertAlerta($data);
                
                
                $this->_flashMessenger->addMessage("Alerta registrata con exito");
                $this->_redirect('/cliente');
        }
    }
}