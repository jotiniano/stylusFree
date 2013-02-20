<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_TipoUsuario extends App_Db_Table_Abstract {

    protected $_name = 'tipousuario';

    const TABLA_TIPOUSUARIO = 'tipousuario';

    
    function getTipoUsuario(){
         $query = $this->getAdapter()
                ->select()->from(array('tipoUsuario' => $this->_name));
         return $this->getAdapter()->fetchAll($query);
        
        
    }
}