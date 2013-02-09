<?php

/**
 * Description of User
 *
 * @author James
 */
class App_Model_Agenda extends App_Db_Table_Abstract {

    protected $_name = 'agenda';

    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 0;
    const TABLA_AGENDA = 'agenda';

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
}