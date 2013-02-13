<?php

/**
 * Description of User
 *
 * @author James 
 * @email james.otiniano@gmail.com
 */
class App_Model_Ticket extends App_Db_Table_Abstract {

    protected $_name = 'ticket';

    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 0;
    const TABLA_TICKET = 'ticket';
    
    public function lista($data = NULL) 
    {
        $query = $this->getAdapter()
                ->select()->from(
                    array('t' => $this->_name)                    
                )
                ->join(
                        array('u' => App_Model_User::TABLA_USUARIO), 
                        't.idUsuario = u.idUsuario', 
                        array('nombreUsuario', 'apellidoUsuario', 
                            'idTipoUsuario')
                )
                ->join(
                        array('c' => App_Model_Cliente::TABLA_CLIENTE), 
                        'c.idCliente = t.idCliente', 
                        array('nombreCliente', 'apellidoCliente', 
                            'idTipoUsuario')
                );
        
        if ($data) {
            if (isset($data['idUsuario']) and !empty($data['idUsuario'])) {
                $query->where('u.idUsuario = ?', $data["idUsuario"]);
            }
            if (isset($data["nombre"]) and !empty($data["nombre"])) {
                $concat = new Zend_Db_Expr("CONCAT(TRIM(u.nombreUsuario), ' ', TRIM(u.apellidoUsuario))");
                $query->where("$concat like ?", "%{$data["nombre"]}%");
            }
        }
        
        $query->limit(100);

        return $this->getAdapter()->fetchAll($query);
    }
    
}