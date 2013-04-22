<?php

class Admin_ServicioController extends App_Controller_Action
{
    
    /**
     *
     * @var Application_Model_User
     */
    protected $mServicio;

    public function init() {
        parent::init();
        $this->mServicio = new App_Model_Servicio();
        $this->indexUrl = $this->view->url(array('controller'=>'servicio','action'=>'index'),null,true);
         $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
             $this->_redirect($this->view->url(array("module" => "admin",
                        controller => "auth",
                        action => "index")));
        }
        $this->view->activeServicio = 'class="active"';
    }
    
    public function indexAction()
    {
        $form = new App_Form_BuscarProducto();
       // $modeloServicio = new App_Model_Servicio();
        $modelProducto = new App_Model_Producto();
        $result = $modelProducto->lista($tipo = 2);
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $form->populate($data);
            $result = $modelProducto->buscarProductos($data,$tipo = 2);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
        
        
        
        
    }
    
    
    public function crearAction(){
        $form = new App_Form_CrearServicio();
        $this->view->form = $form; 
        if($this->getRequest()->isPost()){            
            
            $dato = $this->getRequest()->getPost();
           
            if ($form->isValid($dato)) {
                //$modeloServicio = new App_Model_Servicio();
                $modeloProducto = new App_Model_Producto();
                $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['nombreProducto'] = $dato['descripcionServicio'];
                $data['precio'] = $dato['precio'];
                $data['fechaRegistro'] = $fechaRegistro;
                $data['usuarioRegistro'] = $this->view->authData->idUsuario;
                $data['estado'] = App_Model_Producto::ESTADO_ACTIVO;
                $data['apuntes'] = $dato['apuntes'];
                $data['idTipoMoneda'] = $dato['idTipoMoneda'];
                $data['tipo'] = '2';
                $modeloProducto->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Servicio guardado con exito");
                $this->_redirect($this->indexUrl);
                
            }
        }
    }
    
    public function eliminarAction(){
        $modeloServicio = new App_Model_Servicio();
        $id = $this->_getParam('id');
        $data = array(
            'idServicio' => $id,
            'estado' => App_Model_Servicio::ESTADO_ELIMINADO
        );        
        $modeloServicio->actualizarDatos($data);
        $this->_flashMessenger->addMessage("Servicio eliminado con exito");
        $this->_redirect($this->indexUrl);
    }
    
    public function editarAction(){
        //$modeloServicio = new App_Model_Servicio();
        $modeloProducto = new App_Model_Producto();
        $form = new App_Form_CrearServicio();
        $id = $this->_getParam('id');
        $servicio = $modeloProducto->getProductosPorId($id);
       
       // $form->populate($servicio);    
        
        $form->getElement('descripcionServicio')->setValue($servicio['nombreProducto']);
        $form->getElement('precio')->setValue($servicio['precio']);
        $form->getElement('idTipoMoneda')->setValue($servicio['idTipoMoneda']);
        $form->getElement('apuntes')->setValue($servicio['apuntes']);
         
        if($this->getRequest()->isPost()){            
            $dato = $this->getRequest()->getPost();
            $data['idProducto'] = $id;
            if ($form->isValid($dato)) {                
                $modeloProducto = new App_Model_Producto();
                $data['nombreProducto'] = $dato['descripcionServicio'];
                $data['precio'] = $dato['precio'];
                $data['apuntes'] = $dato['apuntes'];
                $data['idTipoMoneda'] = $dato['idTipoMoneda'];
                
                $id = $modeloProducto->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Servicio editado con éxito");
                $this->_redirect('/servicio/');
                
            } else {
                $form->populate($data);                
            }
        }
        $this->view->form = $form;
        
    }


}