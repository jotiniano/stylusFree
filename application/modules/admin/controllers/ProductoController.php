<?php
class Admin_ProductoController extends App_Controller_Action
{

    public function init() 
    {
       parent::init();
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            echo $this->_redirect($this->view->url(array("module" => "admin",
                        controller => "auth",
                        action => "index")));
        }
        $this->view->activeProducto = 'class="active"';
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
                $modelProducto = new App_Model_Producto();
                $fecha = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
                $data['fechaRegistro'] = $fecha;
                $data['usuarioRegistro'] = $this->view->authData->idUsuario;
                $data['estado'] = App_Model_Producto::ESTADO_ACTIVO;                
                $id = $modelProducto->actualizarDatos($data);
                
                $foto = $form->foto->getFileName();
                if (!empty ($foto)) {
                    $config = Zend_Registry::get('config');
                    $ruta = $config->app->mediaRoot;

                    $form->foto->addFilter(
                            'Rename', array(
                        'target' => $ruta . $id . ".jpeg",
                        'overwrite' => true)
                    );
                    $form->foto->receive();
                    $data['idProducto'] = $id;
                    $data['foto'] = $id . ".jpeg";
                    $modelProducto->actualizarDatos($data);                    
                }
                
                
                $this->_flashMessenger->addMessage("Guardado con éxito");
                $this->_redirect('/producto');
                
            } else {
                $this->_flashMessenger->addMessage("Verifique sus datos");
                $form->populate($data);
            }
        }
    }
    
    public function editarAction()
    {   
        $modelProducto = new App_Model_Producto();
        $form = new App_Form_CrearProducto();
        $id = $this->_getParam('id');
        $producto = $modelProducto->getProductosPorId($id);
        $form->populate($producto);        
         
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();            
            $data['idProducto'] = $id;            
            if ($form->isValidPartial(
                    array('nombreProducto' => $data['nombreProducto'], 
                        'precio' => $data['precio']))) {
                $modelProducto = new App_Model_Producto();
                $data['usuarioRegistro'] = $this->view->authData->idUsuario;                
                $cond = array_key_exists("fotoAnt", $data);
                
                if (!$cond) {
                    $foto = $form->foto->getFileName();                    
                    if (!empty ($foto)) {
                        $data['foto'] = $id . ".jpeg";

                        $config = Zend_Registry::get('config');
                        $ruta = $config->app->mediaRoot;

                        $form->foto->addFilter(
                                'Rename', array(
                            'target' => $ruta . $id . ".jpeg",
                            'overwrite' => true)
                        );
                        $form->foto->receive();
                    }
                }                
                $id = $modelProducto->actualizarDatos($data);
                
                $this->_flashMessenger->addMessage("Producto editado con éxito");
                $this->_redirect('/producto/');
            
            } else {                
                $form->populate($data);
                $this->_flashMessenger->addMessage("Verifique sus datos");                
            }
        }
        $this->view->ruta = $this->config->app->mediaRoot;
        $this->view->form = $form;
        $this->view->producto = $producto;
    }
    
    
    public function eliminarAction()
    {        
        $modelProducto = new App_Model_Producto();
        $id = $this->_getParam('id');        
        $data = array(
            'idProducto' => $id,
            'estado' => App_Model_Producto::ESTADO_ELIMINADO
        );
        
        $modelProducto->actualizarDatos($data);
        $this->_flashMessenger->addMessage("Producto eliminado con éxito");
        $this->_redirect('/producto');
    }
    public function eliminarfotoAction()
    {
        $modelProducto = new App_Model_Producto();
        $id = $this->_getParam('id');        
        $data = array(
            'idProducto' => $id,
            'foto' => ''
        );
        
        $modelProducto->actualizarDatos($data);
        $this->_flashMessenger->addMessage("Imagen eliminada con éxito");
        $this->_redirect('/producto/editar/id/'.$id);
    }

}