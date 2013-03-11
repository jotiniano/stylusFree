<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_Reporte extends App_Db_Table_Abstract {
    
    protected $_name = 'usuario';
    protected $_nameTipoUsuario = 'tipoUsuario';
    protected $_nameCliente = 'cliente';
    protected $_nameTicket = 'ticket';
    protected $_nameTicketDetalle = 'detalleticket';
    protected $_nameProducto = 'producto';
    

    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 0;
    const TABLA_USUARIO = 'usuario';
    const TIPO_USUARIO_ESTILISTA = 3;
    
    /**
     * @param array $datos
     * @param string $condicion para el caso de actualizacion
     * @return int Identificador de la columna
     */
    private function _guardar($datos, $condicion = NULL) {
       
        $id = 0;
        if (!empty($datos['idUsuarioServicio'])) {
            echo "primer if";
            $id = (int) $datos['idUsuarioServicio'];
        }
        unset($datos['idUsuarioServicio']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));
        print_r($datos);
        exit();
        
        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->update($datos, 'idUsuarioServicio = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    
    public function insertUsuarioServicio($data){
        
       
       $idUS = $this->insert(
            array(
                'idUsuario'     => $data['idUsuario'],
                'idServicio'   => $data['idServicio'],
                'comision'   => $data['comision'],
                'fechaRegistro' => $data['fechaRegistro'],
            )
        );
        return $idUS;
       
    }
    
    
    public  function listarReporte($dato){
       $db = $this->getAdapter();

       $select = $db->select()
                
                ->from(array('usuario'=>$this->_name),array(
                    'usuario.nombreUsuario',
                    'ticket.idTicket',
                    'tipoUsuario.descripcion',
                    'cliente.nombreCliente',
                    'ticket.fechaCreacion',
                    'ticket.total'
                    ))
             
                ->join(array('ticket'=>$this->_nameTicket), 'usuario.idUsuario = ticket.idUsuario','')
                ->join(array('cliente'=>$this->_nameCliente), 'cliente.idCliente = ticket.idCliente','')
                ->join(array('tipoUsuario'=>  App_Model_TipoUsuario::TABLA_TIPOUSUARIO), 'tipoUsuario.idTipoUsuario = usuario.idTipoUsuario','')
                ->where('usuario.estado = 1')
                ->where('DATE(fechaCreacion) BETWEEN "'.$dato['fechaInicial'].'" AND "'.$dato['fechaFinal'].'"');
        return $db->fetchAll($select);
             
    }
    
    public function buscarUsuarioServicio(array $data = array()){
         $db = $this->getAdapter();

         $select = $db->select()
                
                ->from(array('usuarioServicio'=>$this->_nameUsuarioServicio),array(
                    'usuarioServicio.comision',
                    'usuarioServicio.idUsuarioServicio',
                    'usuario.idUsuario',
                    'usuario.nombreUsuario',
                    'usuario.usuario',
                    'servicio.idServicio',
                    'servicio.descripcionServicio',
                    'servicio.precio'
                    ))
             
                ->join(array('servicio'=>$this->_nameServicio), 'usuarioServicio.idServicio = servicio.idServicio','')
                ->join(array('usuario'=>$this->_nameUsuario), 'usuarioServicio.idUsuario = usuario.idUsuario','')
                ->where('usuario.idTipoUsuario = ?', self::TIPO_USUARIO_ESTILISTA);
        
        if (isset ($data['idUsuarioServicio']) and !empty($data['idUsuarioServicio'])){
            $select->where('usuarioServicio.idUsuarioServicio = ?', $data["idUsuarioServicio"]);
        }
        if (isset($data["nombreUsuario"]) and !empty($data["nombreUsuario"])) {
            $concat = new Zend_Db_Expr("CONCAT(TRIM(usuario.nombreUsuario), ' ', TRIM(usuario.apellidoUsuario))");
            $select->where("$concat like ?", "%{$data["nombreUsuario"]}%");
        }  
        if (isset($data["descripcionServicio"]) and !empty($data["descripcionServicio"]))
            $select->where("servicio.descripcionServicio like ?", "%{$data["descripcionServicio"]}%");   
        
        
        $select->order('idUsuarioServicio')
                ->limit(50);

        return $db->fetchAll($select);
    }
    public function getUsuariosPorServicio($idServicio)
    {
        $db = $this->getAdapter();
        
        $select = $db->select()
            ->from(array('us' => 'usuarioservicio'), 
                array('idUsuario' => 'us.idUsuario', 
                    'nombreUsuario' => "CONCAT(u.nombreUsuario, ' ', u.apellidoUsuario)")
            )
            ->joinInner(array('u' => $this->_nameUsuario), 'us.idUsuario = u.idUsuario', array())
            ->where('us.idServicio = ?', $idServicio)
            ->where('u.idTipoUsuario = ?', '3')
            ->group('idUsuario')
            
            ;
        
        return $db->fetchAll($select);
        
    }
    
    
    public function listarVentaDiaria($fecha){
        
        $db = $this->getAdapter();

       $select = $db->select()
                
                ->from(array('usuario'=>$this->_name),array(
                    'ticket.idTicket',
                    'usuario.nombreUsuario',
                    'ticket.efectivo',
                    'ticket.mastercard',
                    'ticket.visa',
                    'ticket.total',
                    'ticket.fechaCreacion'
                    ))
             
                ->join(array('ticket'=>$this->_nameTicket), 'usuario.idUsuario = ticket.idUsuario','')
                ->where('usuario.estado = 1')
                ->where('CAST(ticket.fechaCreacion as DATE) = ?' , $fecha)
                ;
        return $db->fetchAll($select);
    }
    
    public function getTicket($idTicket){
      $db = $this->getAdapter();

      $select = $db->select()
                
                ->from(array('usuario'=>$this->_name),array(
                    'usuario.nombreUsuario',
                    'cliente.nombreCliente',
                    'cliente.apellidoCliente',
                    'ticket.idTicket',
                    'ticket.fechaCreacion',
                    'ticket.efectivo',
                    'ticket.mastercard',
                    'ticket.total',
                    'ticket.visa',
                    'usuario.usuario',
                    
                    ))
             
                ->join(array('ticket'=>$this->_nameTicket), 'usuario.idUsuario = ticket.idUsuario','')
                ->join(array('cliente'=>$this->_nameCliente), 'cliente.idCliente = ticket.idCliente','')
                //->join(array('tipoUsuario'=>$this->_nameTipoUsuario), 'tipoUsuario.idTipoUsuario = usuario.idTipoUsuario','')
                ->where('usuario.estado = 1')
                ->where('ticket.idTicket= ?',$idTicket);
      
          
        return $db->fetchRow($select);
    }
    
    public function getDetalleTicket($idTicket){
        
      $db = $this->getAdapter();

      $select = $db->select()
                
                ->from(array('usuario'=>$this->_name),array(
                    'dt.idDetalleTicket',
                    'dt.idTicket',
                    'dt.comision',
                    'dt.precio',
                    'producto.nombreProducto',
                    'producto.tipo',
                    'usuario.usuario',
                    ))
                ->join(array('dt'=>$this->_nameTicketDetalle), 'usuario.idUsuario = dt.idUsuario','')
                ->join(array('producto'=>$this->_nameProducto), 'dt.idProducto = producto.idProducto','')
                ->where('dt.idTicket = ?',$idTicket);
        return $db->fetchAll($select);
      
    }
    
    public function getReporteEstilista($dato)
    {
     $db = $this->getAdapter();

      $select = $db->select()
                
                ->from(array('usuario'=>$this->_name),array(
                    'usuario.idUsuario',
                    'usuario.usuario',
                    'usuario.idTipoUsuario',
                    'ticket.idTicket',
                    'ticket.fechaCreacion',
                    'ticket.total',
                    'detalleticket.idProducto',
                    'producto.nombreProducto',
                    'producto.tipo',
                    'detalleticket.comision',
                    'ue.usuario as usuarioEstilista',
                    'detalleticket.idUsuario as idUsuarioEstilista',

                    ))
                
                ->join(array('detalleticket'=>$this->_nameTicketDetalle), 'usuario.idUsuario = detalleticket.idUsuario','')
                ->join(array('ticket'=>$this->_nameTicket), 'detalleticket.idTicket = ticket.idTicket','')
                ->join(array('producto'=>$this->_nameProducto), 'detalleticket.idProducto = producto.idProducto','')
                ->join(array('ue'=>$this->_name), 'ue.idUsuario = detalleticket.idUsuario','')
                ->where('detalleticket.idUsuario= ?',$dato['idUsuario'])
                ->where('DATE(ticket.fechaCreacion) BETWEEN "'.$dato['fechaInicial'].'" AND "'.$dato['fechaFinal'].'"');
               
        return $db->fetchAll($select);
    }
}
