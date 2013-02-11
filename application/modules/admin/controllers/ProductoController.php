<?php
class Admin_ProductoController extends App_Controller_Action
{

    public function init() 
    {
       parent::init();
    }
    
    public function indexAction()
    {   
        $form = new App_Form_BuscarProducto();
        $modelProducto = new App_Model_Producto();
        
        $result = $modelProducto->lista();
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $form->populate($data);
            $result = $modelProducto->buscarProductos($data);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
    }
    
    public function crearAction()
    {        
        $form = new App_Form_CrearProducto();
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
        $modelCliente = new App_Model_Cliente();
        $form = new App_Form_CrearCliente();
        $id = $this->_getParam('id');
        $cliente = $modelCliente->getClientesPorId($id);
        $form->populate($cliente);        
         
        if($this->getRequest()->isPost()){            
            $data = $this->getRequest()->getPost();
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

}