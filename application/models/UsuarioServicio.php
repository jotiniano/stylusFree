<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_UsuarioServicio extends App_Db_Table_Abstract {
    
    protected $_name = 'usuarioservicio';
    protected $_nameUsuario = 'usuario';
    protected $_nameTipoUsuario = 'tipoUsuario';
    protected $_nameUsuarioServicio = 'usuarioservicio';
    protected $_nameServicio = 'servicio';
    

    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 0;
    const TABLA_USUARIO_SERVICIO = 'usuarioServicio';
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
    
    public function verificarUso($id){
        $query = $this->getAdapter()->select()
                ->from($this->_name)
                ->where('idUsuario = ?', $id);
        return $this->getAdapter()->fetchRow($query);
    }
    
    public function eliminarUsuarioServicio($id){
        $where = $this->getAdapter()->quoteInto('idUsuarioServicio =?', $id);
        $this->delete($where);
    }
    
    public  function listarUsuarioServicio(){
        $db = $this->getAdapter();

       $select = $db->select()
                
                ->from(array('usuarioServicio'=>$this->_nameUsuarioServicio),array(
                    'usuarioServicio.comision',
                    'usuarioServicio.idUsuarioServicio',
                    'usuarioServicio.idUsuario as usuarioServicio',
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
                $select->order('idUsuarioServicio');
                

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

}
