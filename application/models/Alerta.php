<?php

/**
 * Description of User
 *
 * @author James
 */
class App_Model_Alerta extends App_Db_Table_Abstract
{

    protected $_name = 'alerta';

    const ATENDIDO_SI = 1;
    const ATENDIDO_NO = 0;
    const TABLA_ALERTA = 'alerta';
    const TABLA_CLIENTE = 'cliente';
    
    /**
     * @param array $datos
     * @param string $condicion para el caso de actualizacion
     * @return int Identificador de la columna
     */
    
    public function listarAlerta() 
    {
        $query = $this->getAdapter()
                ->select()->from(array('a' => $this->_name),array(
                    'a.idAlerta',
                    'CAST(a.fechaAlerta as DATE) as fechaAlerta',
                    'a.atendido',
                    'a.descripcion',
                    'c.idCliente',
                    'c.nombreCliente',
                    'c.apellidoCliente',
                    'c.telefono',
                    'c.celular',
                    'c.correo',
                    'c.alerta'
                ))
                ->join(array('c'=>App_Model_Cliente::TABLA_CLIENTE), 'a.idCliente= c.idCliente','')
                ->where('a.atendido = ?', App_Model_Alerta::ATENDIDO_NO)
                ->order('fechaAlerta')
                ->limit(50);

        return $this->getAdapter()->fetchAll($query);
    }

    
    public function insertAlerta($data){
       $idUS = $this->insert($data);
       return $idUS;
       
    }
    
    public function deleteAlerta($id){
        $where = 'idAlerta = '.$id;
        $this->delete($where);
    }
    

}