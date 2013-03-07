<?php

/**
 * Description of User
 *
 * @author James
 */
class App_Model_Producto extends App_Db_Table_Abstract {

    protected $_name = 'producto';

    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 0;
    const TABLA_CLIENTE = 'producto';

    /**
     * @param array $datos
     * @param string $condicion para el caso de actualizacion
     * @return int Identificador de la columna
     */
    private function _guardar($datos, $condicion = NULL) {
        $id = 0;
        if (!empty($datos['idProducto'])) {
            $id = (int) $datos['idProducto'];
        }
        unset($datos['idProducto']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->update($datos, 'idProducto = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function getProductosPorId($id) {
        $query = $this->getAdapter()->select()
                ->from($this->_name)
                ->where('estado = ?', App_Model_Producto::ESTADO_ACTIVO)
                ->where('idProducto = ?', $id);

        return $this->getAdapter()->fetchRow($query);
    }

    public function lista($tipo) {
        $query = $this->getAdapter()
                ->select()->from(array('p' => $this->_name))
                ->where('p.estado = ?', App_Model_Producto::ESTADO_ACTIVO)
                 ->where('p.tipo = ?',$tipo);

        return $this->getAdapter()->fetchAll($query);
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
    
    public function buscarProductos(array $data = array(),$tipo) {

        $db = $this->getAdapter();

        $select = $db->select()
                ->from(array('p' => $this->_name), $this->_getCols())
                ->where('p.estado = ?', self::ESTADO_ACTIVO)
                ->where('p.tipo = ?',$tipo);

        if (isset ($data['idProducto']) and !empty($data['idProducto']))
            $select->where('p.idProducto = ?', $data['idProducto']);

        if (isset($data["nombreProducto"]) and !empty($data["nombreProducto"]))
            $select->where("p.nombreProducto like ?", "%{$data["nombreProducto"]}%");        
        
        if (isset($data["precio"]) and !empty($data["precio"]))
            $select->where("p.precio like ?", "%{$data["precio"]}%");        
        
        $select->order('idProducto');
                

        return $db->fetchAll($select);
    }
    
    public function getProductos($idTipo)
    {
        $db = $this->getAdapter();
        
        $select = $db->select()->from(array('p' => 'producto'), 
                    array('idProducto', 'nombreProducto', 'contenido', 
                        'precio', 'tipo'));
            
        if ($idTipo == '2') {
            $select->join(
                array('us' => 'usuarioservicio'), 
                    'us.idServicio = p.idProducto',
                    array('us.comision')
                );
        }
        $select->where('p.estado = ?', '1')
                ->where('p.tipo = ?', $idTipo);
        
        
        
        return $db->fetchAll($select);
        
    }
}