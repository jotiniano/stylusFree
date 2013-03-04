<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_Servicio extends App_Db_Table_Abstract {

    protected $_name = 'servicio';
     protected $_nameProducto = 'producto';
    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 0;
    const TABLA_SERVICIO = 'servicio';
    
    /**
     * @param array $datos
     * @param string $condicion para el caso de actualizacion
     * @return int Identificador de la columna
     */
    private function _guardar($datos, $condicion = NULL) {
        $id = 0;
        if (!empty($datos['idServicio'])) {
            $id = (int) $datos['idServicio'];
        }
        unset($datos['idServicio']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->update($datos, 'idServicio= ' . $id . $condicion);
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
        $query = $this->getAdapter()
                ->select()->from(array('servicio' => $this->_name))
                ->where('servicio.estado = ?', App_Model_Producto::ESTADO_ACTIVO);
        return $this->getAdapter()->fetchAll($query);
    }
    
    public function listarDatos() {
         $query = $this->getAdapter()->select()
                 ->from(array('s'=>$this->_name),array(
                    's.idServicio',
                    's.descripcionServicio',)) 
                ->order('s.descripcionServicio asc');        

        return $this->getAdapter()->fetchAll($query);
        
        
    }
    
    public function buscarServicio(array $data = array()) {
        $db = $this->getAdapter();

        $select = $db->select()
                ->from(array('servicio' => $this->_name), $this->_getCols())
                ->where('servicio.estado = ?', self::ESTADO_ACTIVO);

        if (isset ($data['idServicio']) and !empty($data['idServicio']))
            $select->where('servicio.idServicio = ?', $data['idServicio']);

        if (isset($data["descripcionServicio"]) and !empty($data["descripcionServicio"]))
            $select->where("servicio.descripcionServicio like ?", "%{$data["descripcionServicio"]}%");        
        
        $select->order('idServicio')
                ->limit(50);

        return $db->fetchAll($select);
    }
    
     public function getServicioPorId($id = NULL) 
    {
        $query = $this->getAdapter()->select()
                 ->from(array('s'=>$this->_name),array(
                    's.idServicio',
                    's.descripcionServicio',
                    's.precio',
                    's.idTipoMoneda',
                     's.apuntes',
                    ))
            ->where('estado = ?', 1);
        
        if ($id) {
            $query->where('idServicio= ?', $id)->order('s.descripcionServicio asc');
            return $this->getAdapter()->fetchRow($query);
        }
        $query->order('s.descripcionServicio asc');
        return $this->getAdapter()->fetchAll($query);
    }
    
}
