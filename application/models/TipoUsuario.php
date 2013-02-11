<?php

/**
 * Description of User
 *
 * @author James
 */
class App_Model_TipoUsuario extends App_Db_Table_Abstract {

    protected $_name = 'tipousuario';

    const TABLA_TIPOUSUARIO = 'tipousuario';

    
    function getTipoUsuario(){
        $smt = $this->_name->select()
                ->query();
        $result = $smt->fetch();
        $smt->closeCursor();
        return $result;
    }
}