<?php

/**
 * Description of User
 *
 * @author James
 */
class App_Model_TicketDetalle extends App_Db_Table_Abstract {

    protected $_name = 'detalleticket';
    
    const TABLA_TICKET = 'detalleticket';

    /**
     * @param array $datos
     * @param string $condicion para el caso de actualizacion
     * @return int Identificador de la columna
     */
    private function _guardar($datos, $condicion = NULL) {
        $id = 0;
        if (!empty($datos['idDetalleTicket'])) {
            $id = (int) $datos['idDetalleTicket'];
        }
        unset($datos['idDetalleTicket']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->update($datos, 'idDetalleTicket = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }
    
    public function actualizarDatos($datos) 
    {
        return $this->_guardar($datos);
    }
    
    public function verificarUso($id){
       $query = $this->getAdapter()->select()
                ->from($this->_name)
                ->where('idUsuario = ?', $id);
       return $this->getAdapter()->fetchRow($query);
    }
}
