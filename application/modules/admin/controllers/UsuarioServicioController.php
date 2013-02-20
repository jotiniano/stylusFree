<?php

class Admin_UsuarioServicioController extends App_Controller_Action
{
    
    /**
     *
     * @var Application_Model_User
     */
    
    
    public function init() {
        parent::init();
        
        $this->indexUrl = $this->view->url(array('controller'=>'usuario-servicio','action'=>'index'),null,true);
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            echo $this->_redirect($this->view->url(array("module" => "admin",
                        controller => "auth",
                        action => "index")));
        }
         $this->view->activeUsuarioServicio = 'class="active"';
    }
    
    
    public function indexAction()
    {
        $form = new App_Form_BuscarUsuarioServicio();
        $modelUsuario = new App_Model_UsuarioServicio();
        
        $result = $modelUsuario->listarUsuarioServicio();
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $form->populate($data);
            $result = $modelUsuario->buscarUsuarioServicio($data);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
    }
    
    
    public function crearAction(){
        $form = new App_Form_CrearUsuarioServicio();
        $this->view->form = $form; 
        if($this->getRequest()->isPost()){            
            
            $data = $this->getRequest()->getPost();
           
            if ($form->isValid($data)) {
                $modeloUsuarioServicio = new App_Model_UsuarioServicio();
                $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['idUsuario'] = $data['idUsuario'];
                $data['idServicio'] = $data['idServicio'];
                $data['comision'] =$data['comision'];
                $data['fechaRegistro'] = $fechaRegistro;
                $modeloUsuarioServicio->insertUsuarioServicio($data);
                
                $this->_flashMessenger->addMessage("Servicio para el Usuario guardado con exito");
                $this->_redirect($this->indexUrl);
                
            } else {
                $form->populate($data);                
            }
        }
    }
    
    
    public function editarAction(){}
    
    public function eliminarAction(){
        
        $modeloUsuarioServicio = new App_Model_UsuarioServicio();
        $modeloTicketDetalle = new App_Model_TicketDetalle();
        $id = $this->_getParam('id');
        $data = $modeloTicketDetalle->verificarUso($id);
        //print_r($data);
       
        if(count($data)>0){
            $this->_flashMessenger->addMessage("El usuario tiene ticket elaborados");
            $this->_redirect($this->indexUrl);
        }else{
            //$modeloUsuarioServicio->eliminarUsuarioServicio($id);
            $this->_flashMessenger->addMessage("Servicio eliminado con exito");
        }
        
        
    }


}