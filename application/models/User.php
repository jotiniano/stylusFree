<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_User extends App_Db_Table_Abstract {

    protected $_name = 'usuario';
    protected $_nameTipoUsuario = 'tipoUsuario';
    protected $_nameServicio = 'servicio';
    

    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 0;
    const TABLA_USUARIO = 'usuario';
    const TIPO_CLIENTE = 4;
    const TIPO_USUARIO_ESTILISTA = 3;
    
    /**
     * @param array $datos
     * @param string $condicion para el caso de actualizacion
     * @return int Identificador de la columna
     */
    private function _guardar($datos, $condicion = NULL) {
        $id = 0;
        if (!empty($datos['idUsuario'])) {
            $id = (int) $datos['idUsuario'];
        }
        unset($datos['idUsuario']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->update($datos, 'idUsuario = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    
    public function getUsuarioPorId($id, $tipo = NULL) 
    {
        $query = $this->getAdapter()->select()
                ->from($this->_name)
                ->where('idUsuario = ?', $id);
        if ($tipo)
            $query->where ('idTipoUsuario = ?', $tipo);
        
        return $this->getAdapter()->fetchRow($query);
    }
    
    
    public function lista() {
        /*$query = $this->getAdapter()
                ->select()->from(array('c' => $this->_name))
                ->where('c.estado = ?', App_Model_User::ESTADO_ACTIVO);
        */
        $query = "SELECT * FROM
                    tipousuario t
                        INNER JOIN usuario u
                            ON (t.idTipoUsuario = u.idTipoUsuario)
                    where u.estado = 1";
        

        return $this->getAdapter()->fetchAll($query);
    }
    
    
      public function listarDatos() {
         $query = $this->getAdapter()->select()
                 ->from(array('usuario'=>$this->_name),array(
                    'usuario.idUsuario',
                    'usuario.usuario',)) 
                ->where('usuario.idTipoUsuario = ?', self::TIPO_USUARIO_ESTILISTA);
        return $this->getAdapter()->fetchAll($query);
        
        
    }
    public function buscarUsuario(array $data = array()) {

        $db = $this->getAdapter();

        $select = $db->select()
                
                ->from(array('u'=>$this->_name),array(
                    'u.idUsuario',
                    'u.nombreUsuario',
                    'u.apellidoUsuario',
                    'u.fechaRegistro',
                    'u.usuario',
                    'u.estado',
                    'tu.idTipoUsuario',
                    'tu.descripcion',
                    ))
             
                ->join(array('tu'=>$this->_nameTipoUsuario), 'tu.idTipoUsuario = u.idTipoUsuario','')
                ->where('u.estado = ?', self::ESTADO_ACTIVO);
        
        if (isset ($data['idUsuario']) and !empty($data['idUsuario'])){
            $select->where('u.idUsuario = ?', $data["idUsuario"]);
        }
        if (isset($data["nombreUsuario"]) and !empty($data["nombreUsuario"])) {
            $concat = new Zend_Db_Expr("CONCAT(TRIM(u.nombreUsuario), ' ', TRIM(u.apellidoUsuario))");
            $select->where("$concat like ?", "%{$data["nombreUsuario"]}%");
        }        
        
        $select->order('idUsuario')
                ->limit(50);

        return $db->fetchAll($select);
    }
    
    public function getUsuarioWork() 
    {        
        $query = "SELECT u.idUsuario as usuario, concat(u.nombreUsuario, ' ', u.apellidoUsuario) as nombre
            FROM tipousuario t
                        INNER JOIN usuario u
                            ON (t.idTipoUsuario = u.idTipoUsuario)
                    where u.estado = 1 and t.idTipoUsuario = 3";        

        return $this->getAdapter()->fetchAll($query);
    }

   
   
}
