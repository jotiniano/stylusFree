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
        $form = new App_Form_BuscarServicio();
        $modeloServicio = new App_Model_Servicio();
        
        $result = $modeloServicio->lista();
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $form->populate($data);
            $result = $modeloServicio->buscarServicio($data);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
    }
    
    
    public function crearAction(){
        $form = new App_Form_CrearServicio();
        $this->view->form = $form; 
        if($this->getRequest()->isPost()){            
            
            $data = $this->getRequest()->getPost();
           
            if ($form->isValid($data)) {
                $modeloServicio = new App_Model_Servicio();
                $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['descripcionServicio'] = $data['descripcionServicio'];
                $data['precio'] = $data['precio'];
                $data['fechaRegistro'] = $fechaRegistro;
                $data['estado'] = App_Model_Servicio::ESTADO_ACTIVO;
                $modeloServicio->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Sservicio guardado con exito");
                $this->_redirect($this->indexUrl);
                
            } else {
                $form->populate($data);                
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
        $modeloServicio = new App_Model_Servicio();
        $form = new App_Form_CrearServicio();
        $id = $this->_getParam('id');
        $servicio = $modeloServicio->getServicioPorId($id);
        
        $form->populate($servicio);        
         
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getPost();
            $data['idServicio'] = $id;
            if ($form->isValid($data)) {                
                $id = $modeloServicio->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Servicio editado con éxito");
                $this->_redirect('/servicio/');
                
            } else {
                $form->populate($data);                
            }
        }
        $this->view->form = $form;
        
    }


}