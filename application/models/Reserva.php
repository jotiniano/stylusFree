<?php

/**
 * Description of User
 *
 * @author James
 */
class App_Model_Reserva extends App_Db_Table_Abstract
{

    protected $_name = 'reserva';

    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 0;

   
    public function insertarReserva($data) 
    {
        $idAccount = $this->insert(
            array(
                'idCliente'     => $data['idCliente'],
                'idUsuario'     => $data['idUsuario'],
                'fechaInicio'   => $data['fechaIni'],
                'fechaFin'      => $data['fechaFin'],
                'descripcion'   => $data['descripcion'],
                'idEstilista'   => $data['idEstilista'],
                'estado'        => 1,
                'fechaRegistro' => date('Y-m-d H:i:s'),
            )
        );
        return $idAccount;
    }

    public function listarReserva() 
    {
        $query = $this->getAdapter()
                ->select()->from(
                    array('r' => $this->_name),
                    array(
                        "idReserva"     => "r.idReserva",
                        "nombre"        => "c.nombreCliente",
                        "apellidos"     => "c.apellidoCliente",
                        "fechaIni"      => "r.fechaInicio",
                        "fechaFin"      => "r.fechaFin",
                        "descripcion"   => "r.descripcion"
                    )
                )
                ->join(
                    array('c' => 'cliente'),
                    'r.idCliente = c.idCliente',
                    array()
                )
                ->where('c.estado = ?', App_Model_Cliente::ESTADO_ACTIVO)
                ->where('r.estado = ?', App_Model_Reserva::ESTADO_ACTIVO)
                ->order('r.fechaRegistro');

        return $this->getAdapter()->fetchAll($query);
    }

    public function eliminarReserva($idReserva) 
    {
        $this->update(
            array(
                'estado' => App_Model_Cliente::ESTADO_ELIMINADO
            ),
            $this->getAdapter()->quoteInto('idReserva = ?', $idReserva)
        );
    }

    public function getReserva($idReserva) 
    {
        $query = $this->getAdapter()
                ->select()->from(
                    array('r' => $this->_name),
                    array(
                        "idReserva"     => "r.idReserva",
                        "idCliente"     => "r.idCliente",
                        "nombre"        => "c.nombreCliente",
                        "apellidos"     => "c.apellidoCliente",
                        "fechaIni"      => "r.fechaInicio",
                        "fechaFin"      => "r.fechaFin",
                        "descripcion"   => "r.descripcion",
                        "idestilista"   => "r.idEstilista"
                    )
                )
                ->join(
                    array('c' => 'cliente'),
                    'r.idCliente = c.idCliente',
                    array()
                )
                ->where('c.estado = ?', App_Model_Cliente::ESTADO_ACTIVO)
                ->where('r.estado = ?', App_Model_Reserva::ESTADO_ACTIVO)
                ->where('r.idReserva = ?', $idReserva);
                
        return $this->getAdapter()->fetchAll($query);
    }
    
    public function pdf($data) 
    {        
        $query = $this->getAdapter()
                ->select()->from(
                    array('r' => $this->_name),
                    array(
                        "idReserva"     => "r.idReserva",
                        "idCliente"     => "r.idCliente",
                        "idUsuario"     => "r.idUsuario",
                        "nombre"        => "c.nombreCliente",
                        "apellidos"     => "c.apellidoCliente",
                        "fechaIni"      => "r.fechaInicio",
                        "fechaFin"      => "r.fechaFin",
                        "descripcion"   => "r.descripcion",
                        "idestilista"   => "r.idEstilista",
                        "nombree"       => "u.nombreUsuario",
                        "apellidoe"     => "u.apellidoUsuario",
                        "nombreu"       => "us.nombreUsuario",
                        "apellidou"     => "us.apellidoUsuario"
                    )
                )
                ->join(
                    array('c' => 'cliente'),
                    'r.idCliente = c.idCliente',
                    array()
                )
                ->join(
                    array('u' => 'usuario'),
                    'u.idUsuario = r.idEstilista',
                    array()
                )
                ->join(
                    array('us' => 'usuario'),
                    'us.idUsuario = r.idUsuario',
                    array()
                )
                ->where('c.estado = ?', App_Model_Cliente::ESTADO_ACTIVO)
                ->where('r.estado = ?', App_Model_Reserva::ESTADO_ACTIVO)
                ->where("DATE_FORMAT( r.fechaInicio, '%Y-%m-%d') >= ?", $data['fechaI'])
                ->where("DATE_FORMAT( r.fechaFin, '%Y-%m-%d') <= ?", $data['fechaF'])
                ;
                
        
                
        return $this->getAdapter()->fetchAll($query);
    }


}
