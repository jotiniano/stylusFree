<?php

class Admin_UserController extends App_Controller_Action
{
    
    /**
     *
     * @var Application_Model_User
     */
    protected $mUser;

    public function init() {
        parent::init();
        $this->mUser = new App_Model_User();
        $this->indexUrl = $this->view->url(array('controller'=>'user','action'=>'index'),null,true);
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            echo $this->_redirect($this->view->url(array("module" => "admin",
                        controller => "auth",
                        action => "index")));
        }
        
         $this->view->activeUsuario = 'class="active"';
    }
    
    
    public function indexAction()
    {
        $form = new App_Form_BuscarUsuario();
        $modelUsuario = new App_Model_User();
        
        $result = $modelUsuario->lista();
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $form->populate($data);
            $result = $modelUsuario->buscarUsuario($data);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
    }
    
    public function crearAction()
    {
        $form = new App_Form_CrearUsuario();
        $this->view->form = $form; 
        if($this->getRequest()->isPost()){            
            
            $data = $this->getRequest()->getPost();
           
            if ($form->isValid($data)) {
                $modeloUsuario = new App_Model_User();
                $fechaRegistro = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['nombreUsuario'] = $data['nombreUsuario'];
                $data['apellidoUsuario'] = $data['apellidoUsuario'];
                $data['fechaRegistro'] = $fechaRegistro;
                $data['usuario'] =  $data['usuario'];
                $data['clave'] =  $data['clave'];
                $data['idTipoUsuario'] =  $data['tipoUsuario'];
                $data['estado'] = App_Model_User::ESTADO_ACTIVO;
                $modeloUsuario->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Usuario guardado con exito");
                $this->_redirect($this->indexUrl);
                
            } else {
                $form->populate($data);                
            }
        }
        
    }
    
    public function editarAction(){
        $modeloUsuario = new App_Model_User();
        $form = new App_Form_CrearUsuario();
        $id = $this->_getParam('id');
        $usuario = $modeloUsuario->getUsuarioPorId($id);
        
        $form->populate($usuario);        
        $form->getElement('tipoUsuario')->setValue($usuario['idTipoUsuario']); 
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getPost();
            $data['idUsuario'] = $id;
            if ($form->isValid($data)) {                
                $id = $modeloUsuario->actualizarDatos($data);
                $this->_flashMessenger->addMessage("Usuario editado con éxito");
                $this->_redirect('/user/');
                
            } else {
                $form->populate($data);                
            }
        }
        $this->view->form = $form;
    }
    
    public function eliminarAction(){
        
        $modeloUsuario = new App_Model_User();
        $id = $this->_getParam('id');
        $data = array(
            'idUsuario' => $id,
            'estado' => App_Model_User::ESTADO_ELIMINADO
        );        
        $modeloUsuario->actualizarDatos($data);
        $this->_flashMessenger->addMessage("Usuario eliminado con exito");
        $this->_redirect($this->indexUrl);
        
        
    }
   
    public function buscarUsuarioServicioAction(){
        
        $this->view->activeUsuario = '';
        $form = new App_Form_BuscarUsuario();
        $modelUsuario = new App_Model_User();
        
        $result = $modelUsuario->lista();
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $form->populate($data);
            $result = $modelUsuario->buscarUsuario($data);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
    }
    
    public function getUsuariosAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $idServicio = $this->_getParam('id');
        
        $modelUserSer = new App_Model_UsuarioServicio();
        
        $result = $modelUserSer->getUsuariosPorServicio($idServicio);
        
        echo Zend_Json::encode($result);
        
    }
    


}
