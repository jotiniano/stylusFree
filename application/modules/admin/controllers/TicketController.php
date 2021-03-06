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
        $this->view->orden = $this->_getParam('ord', "");
        
        $idUsuario = $this->authData->idUsuario;
        $name = "";
        
        if($idCliente) {
            $modelCliente = new App_Model_Cliente();
            $user = $modelCliente->getClientesPorId($idCliente);
            if ($user) {
                 $idCliente = $user['idCliente'];
                 $name = $user['nombreCliente'] . ' ' . $user['apellidoCliente'];
            }
        }
        $this->view->idCliente = $idCliente;
        $this->view->nombreUser = $name;
        
        //$modelUsuario = new App_Model_User();
        //$this->view->users = $modelUsuario->getUsuarioWork();
        
        $modelServicio = new App_Model_Servicio();
        $this->view->servicios = $modelServicio->getServicioPorId();        
        
        $modelProdcuto = new App_Model_Producto();
        $this->view->productos = $modelProdcuto->lista($tipo=1);
        
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
            $db = $this->getAdapter();
            $db->beginTransaction();
            try {
            $modelTicket = new App_Model_Ticket();
            $modelTicketDeta = new App_Model_TicketDetalle();
            $total = array_sum($data["detalleCosto"]);            
            
            $dataTicket = array(
                'idUsuario' => $idUsuario,
                'fechaCreacion' => Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss'),
                'idCliente' => $data["otroCliente"],
                'total' => $total,
                'visa' => $data["visa"],
                'mastercard' => $data["mastercard"],
                'efectivo' => $data["efectivo"],

            );                        
            
            $idTicket = $modelTicket->actualizarDatos($dataTicket);            
            $detalle = array();
            $tam = sizeof($data['detalleServicio']);
            
            if ($tam > 0) {
                for ($i = 0; $i < $tam; $i++) {
                    $detalle['idTicket'] = $idTicket;
                    $detalle['idProducto'] = $data['detalleServicio'][$i];
                    $detalle['precio'] = $data['detalleCosto'][$i];
                    $detalle['idUsuario'] = $data['detalleWorker'][$i];
                    $detalle['comision'] = $data['detalleComision'][$i];
                    if ($detalle['idProducto']) 
                        $modelTicketDeta->actualizarDatos($detalle);
                }
            $db->commit();            
            $this->_flashMessenger->addMessage("Ticket Generado con exito : Total por Servicio : S/. " . $total);
            
            } else
                $this->_flashMessenger->addMessage("Tiene que ingresar al menos un producto");            
            
            } catch (Zend_Exception $e){
                $db->rollBack();
                $this->_flashMessenger->addMessage("Ocurrio un error intentelo nuevamente");                
            }
            $this->_redirect('/ticket/nuevo/id/'.$data["otroCliente"].'/ord/'.$idTicket);
            
            
            
        }

    }
    public function productotipo1Action()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $idTipo = $this->_getParam('id');
        
        $modelProducto = new App_Model_Producto();
        
        $result = $modelProducto->getProductos($idTipo);
        
        echo Zend_Json::encode($result);
        
    }
    public function productotipoAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        
        $idTipo = $this->_getParam("id");
        $nombre = $this->_getParam("query");
        
        $modelProducto = new App_Model_Producto();
        
        $result = $modelProducto->getProductos($idTipo, $nombre);
        
        //echo Zend_Json::encode($result);
        
        $clientes = "";
        foreach ($result as $index=>$item) {
            $clientes[$index]["id"] = $item["idProducto"];
            $clientes[$index]["value"] = $item["nombreProducto"];
            $clientes[$index]["data"] = $item["nombreProducto"];
            if ($idTipo == '1')
                $clientes[$index]["comision"] = "0.06";
            else 
                $clientes[$index]["comision"] = "0";
            $clientes[$index]["precio"] = $item["precio"];
        }
        //<option comision="0.06" precio="17.96" id="idItem" data="INOA" value="1">
        //echo json_encode($clientes);
        echo Zend_Json::encode($clientes);
    }
    
    public function imprimirAction()
    {
        $this->_helper->layout->disableLayout();
        $orden = $this->_getParam('orden');
        $numero = sprintf("%05s",$orden); 
        $razon = $this->config->app->razonsocial;
        $ruc = $this->config->app->ruc;
        $aut = $this->config->app->autsunat;
        

        $path = APPLICATION_PATH . "/../library/dompdf/dompdf_config.inc.php";
        $pathFont = APPLICATION_PATH . "/../library/dompdf/lib/Helvetica.afm";
        require_once($path);
        $model = new App_Model_Ticket();
        $modelDeta = new App_Model_TicketDetalle();
        $data = $model->buscarTicketId($orden);
        $deta = $modelDeta->buscarDetalleTicketId($orden);        
        $detalle = "";
        foreach ($deta as $item):
            $detalle .= "<tr><td>{$item['nombreProducto']}</td><td style='text-align:right'>{$item['precio']}</td></tr>";
        endforeach;
        
        $igv = round($data['total']*0.18, 2);
        $subtotal = $data['total'] - $igv;
        
        
        $fuente = 'Courier New';
        $style = "font-family: '".$fuente."' ";
        
        $font = "font-family: Courier New";
        $fecha = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');

        $html = '
            <html>
            <head>
            <style type="text/css" media="all">
            body {font-family: "Helvetica";
                  margin: 0px 0px 0px 0px;
                  }
            </style>
            </head>
              <body style="font-size: 13px;padding-top: 5px; padding-bottom: 5px;">
               <span class="text">MANICOLOR Salón y Spá </span> <br>
               <span class="text">Fernandez y Torres SCR Ltds </span> <br>
               <span class="text">Av. De las Artes Norte 961 San Borja </span> <br>
               <span class="text">RUC : '. $ruc .'</span> <br>
               <span class="text">Aut Sunat : '. $aut .'</span> <br>
               <span class="text">POS:  01</span> <br>
               <span class="text">Boleta de Venta</span> <br>
               <span class="text">No : 01 - '. $numero .'</span> <br>
               <span class="text">Fecha :  '. $data['fechaCreacion'] .'</span> <br>               
                
		--------------------- <br>
                  <table style="0">                  
				  <tr>
                  <td width="250px" ><u>Producto</u></td>
                  <td><u>Precio</u></td>
                  </tr>
				' 
                . 
                $detalle
                . '
<tr>
                  <td colspan= "2">______</td>
                  
                  </tr>                                   
<tr>



                  <td>Total : </td>
                  <td style="text-align:right">' . $data['total']. '</td>
                  </tr>
                  <tr>
                  <td>IGV : </td>
                  <td style="text-align:right">' . $igv . '</td>
                  </tr>
                  <tr>
                  <td>Subtotal : </td>
                  <td  style="text-align:right">' .  $subtotal . '</td>
                  </tr>
				  <tr>
                  <td colspan = "2">-------------------</td>
                  </tr>
                                    <tr>
                  <td colspan= "2">
                  <span>Cliente : ' . $data['nombreCliente'] . ' ' .$data['apellidoCliente'] .'</span><br>              
                  </td>
                  
                  </tr> 
                  <tr>
                  <td colspan = "2">-------------------</td>
                  </tr>
				  <tr>
                  <td colspan = "2"><p style="font-size: 10px">***** GRACIAS POR VISITARNOS *******	</p></td>                
                  </tr>
                  
                  </table>
              </body>
            </html>
			
		   ';


            $dompdf = new DOMPDF();
            $dompdf->set_paper('c6');
            //$dompdf->selectFont($pathFont);
            $dompdf->load_html(utf8_decode($html));

            $dompdf->render();
            $dompdf->stream("my_pdf.pdf", array("Attachment" => 0));


            exit;        

    }
    
    public function listarClientesAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $buscar = $this->_getParam("query");
        $c = new App_Model_Cliente();
        $lista = $c->listarByQuery($buscar);
        $clientes = "";
        foreach ($lista as $index=>$item) {

            $clientes[$index]["id"] = $item["idCliente"];
            $clientes[$index]["value"] = $item["nombreCliente"]." ".$item["apellidoCliente"];;
        }
        echo json_encode($clientes);
    }

}

