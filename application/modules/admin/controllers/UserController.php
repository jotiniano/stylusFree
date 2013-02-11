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
                $data['nombreUsuario'] = $params['nombre'];
                $data['apellidoUsuario'] = $params['apellido'];
                $data['fechaRegistro'] = $fechaRegistro;
                $data['usuario'] =  $params['usuario'];
                $data['clave'] =  $params['clave'];
                $data['idTipoUsuario'] =  '2';
                $data['estado'] = App_Model_User::ESTADO_ACTIVO;
                $modeloUsuario->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Cliente guardado con exito");
                $this->_redirect($this->indexUrl);
                
            } else {
                $form->populate($data);                
            }
        }
        
        
        
        
    }
    
    public function editarAction(){
        
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
   


}