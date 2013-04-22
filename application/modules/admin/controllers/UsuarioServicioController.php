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
            $dato = $this->getRequest()->getPost();
            $data['nombreUsuario'] = $dato['nombreUsuario'];
            $data['descripcionServicio'] = $dato['descripcionServicio'];
               
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
            
            $dato = $this->getRequest()->getPost();
           
            //if ($form->isValid($dato)) {
                $modeloUsuarioServicio = new App_Model_UsuarioServicio();
                $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['idUsuario'] = $dato['idUsuario'];
                $data['idServicio'] = $dato['idServicio'];
                $data['comision'] =$dato['comision'];
                $data['fechaRegistro'] = $fechaRegistro;
                $modeloUsuarioServicio->insertUsuarioServicio($data);
                
                $this->_flashMessenger->addMessage("Servicio para el Usuario guardado con exito");
                $this->_redirect($this->indexUrl);
                
            //} else {
              //  $form->populate($data);                
            //}
        }
    }
    
    
    public function editarAction(){
        $modeloUsuarioServicio = new App_Model_UsuarioServicio();
        $form = new App_Form_EditarUsuarioServicio();
        
        $id = $this->_getParam('id');
        
        $resultado = $modeloUsuarioServicio->getUsuarioServicioEditar($id);
        
        $form->getElement('idUsuarioServicio')->setValue($resultado['idUsuarioServicio']);
        $form->getElement('nombreUsuario')->setValue($resultado['nombreUsuario']);
        $form->getElement('idServicio')->setValue($resultado['idProducto']);
        $form->getElement('comision')->setValue($resultado['comision']);
        $this->view->form = $form;
        if($this->getRequest()->isPost()){            
              
            $dato = $this->getRequest()->getPost();
              
            
                $modeloUsuarioServicio = new App_Model_UsuarioServicio();
               
                $data['idUsuarioServicio'] = $dato['idUsuarioServicio'];
                $data['idServicio'] = $dato['idServicio'];
                $data['comision'] =$dato['comision'];
               
                $modeloUsuarioServicio->updateUsuarioServicio($data,$data['idUsuarioServicio']);
                
                $this->_flashMessenger->addMessage("Servicio Actualizado");
                $this->_redirect($this->indexUrl);
                
            
        }
      
        
        
    }
    
    public function eliminarAction(){
        
        $modeloUsuarioServicio = new App_Model_UsuarioServicio();
        $id = $this->_getParam('id');
        
        /*
        $modeloTicketDetalle = new App_Model_TicketDetalle();
        $data = $modeloTicketDetalle->verificarUso($id);
        if(count($data)>0){
            $this->_flashMessenger->addMessage("El usuario tiene ticket elaborados");
            $this->_redirect($this->indexUrl);
        }else{*/
            $modeloUsuarioServicio->eliminarUsuarioServicio($id);
            $this->_flashMessenger->addMessage("Servicio eliminado con exito"); $this->_redirect($this->indexUrl);
            
        //}
        
        
    }


}