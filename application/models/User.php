<?php

/**
 * Description of User
 *
 * @author James
 */
class App_Model_User extends App_Db_Table_Abstract {

    protected $_name = 'usuario';

    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 0;
    const TABLA_CLIENTE = 'usuario';
    const TIPO_CLIENTE = 4;

    /**
     * @param array $datos
     * @param string $condicion para el caso de actualizacion
     * @return int Identificador de la columna
     */
    private function _guardar($datos, $condicion = NULL) {
        $id = 0;
        if (!empty($datos['id'])) {
            $id = (int) $datos['id'];
        }
        unset($datos['id']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->update($datos, 'id = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
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
    
    
     public function buscarUsuario(array $data = array()) {

        $db = $this->getAdapter();

        $select = $db->select()
                ->from(array('u' => $this->_name), $this->_getCols())
                ->where('u.estado = ?', self::ESTADO_ACTIVO)
                ->where('u.idTipoUsuario = ?', App_Model_User::TIPO_CLIENTE);
        
        if (isset ($data['idUsuario']) and !empty($data['idUsuario']))
            $select->where('u.idUsuario = ?', $data["idUsuario"]);

        if (isset($data["nombreUsuario"]) and !empty($data["nombreUsuario"])) {
            $concat = new Zend_Db_Expr("CONCAT(TRIM(u.nombreUsuario), ' ', TRIM(u.apellidoUsuario))");
            $select->where("$concat like ?", "%{$data["nombreUsuario"]}%");
        }        
        
        $select->order('idUsuario')
                ->limit(50);

        return $db->fetchAll($select);
    }
}