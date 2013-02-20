<?php

/**
 * Description of User
 *
 * @author Steve Villano Esteban
 */
class App_Model_UsuarioServicio extends App_Db_Table_Abstract {

    protected $_nameUsuario = 'usuario';
    protected $_nameTipoUsuario = 'tipoUsuario';
    protected $_nameUsuarioServicio = 'usuarioServicio';
    protected $_nameServicio = 'servicio';
    

    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 0;
    
    const TIPO_USUARIO_ESTILISTA = 3;
    
    /**
     * @param array $datos
     * @param string $condicion para el caso de actualizacion
     * @return int Identificador de la columna
     */
    private function _guardar($datos, $condicion = NULL) {
        $id = 0;
        if (!empty($datos['idUsuarioServicio'])) {
            echo "primer if";
            $id = (int) $datos['idUsuarioServicio'];
        }
        unset($datos['idUsuarioServicio']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));
        print_r($this->_getCols());
        print_r($datos);
        exit();
        if ($id > 0) {
            $condicion = '';
            if (!empty($condicion)) {
                $condicion = ' AND ' . $condicion;
            }

            $cantidad = $this->update($datos, 'idUsuarioServicio = ' . $id . $condicion);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }

    public function actualizarDatos($datos) {
        return $this->_guardar($datos);
    }
   
    
    public function insertUsuarioServicio($data){
       $s = $this->insert(array('idUsuario'=>$data['idUsuario'])); 
       
    }
    
     
    public  function listarUsuarioServicio(){
        $db = $this->getAdapter();

       $select = $db->select()
                
                ->from(array('usuarioServicio'=>$this->_nameUsuarioServicio),array(
                    'usuarioServicio.comision',
                    'usuarioServicio.idUsuarioServicio',
                    'usuario.idUsuario',
                    'usuario.nombreUsuario',
                    'usuario.usuario',
                    'servicio.idServicio',
                    'servicio.descripcionServicio',
                    'servicio.precio'
                    ))
             
                ->join(array('servicio'=>$this->_nameServicio), 'usuarioServicio.idServicio = servicio.idServicio','')
                ->join(array('usuario'=>$this->_nameUsuario), 'usuarioServicio.idUsuario = usuario.idUsuario','')
                ->where('usuario.idTipoUsuario = ?', self::TIPO_USUARIO_ESTILISTA);
                $select->order('idUsuarioServicio');
                

        return $db->fetchAll($select);
             
    }
    
    public function buscarUsuarioServicio(array $data = array()){
         $db = $this->getAdapter();

         $select = $db->select()
                
                ->from(array('usuarioServicio'=>$this->_nameUsuarioServicio),array(
                    'usuarioServicio.comision',
                    'usuarioServicio.idUsuarioServicio',
                    'usuario.idUsuario',
                    'usuario.nombreUsuario',
                    'usuario.usuario',
                    'servicio.idServicio',
                    'servicio.descripcionServicio',
                    'servicio.precio'
                    ))
             
                ->join(array('servicio'=>$this->_nameServicio), 'usuarioServicio.idServicio = servicio.idServicio','')
                ->join(array('usuario'=>$this->_nameUsuario), 'usuarioServicio.idUsuario = usuario.idUsuario','')
                ->where('usuario.idTipoUsuario = ?', self::TIPO_USUARIO_ESTILISTA);
        
        if (isset ($data['idUsuarioServicio']) and !empty($data['idUsuarioServicio'])){
            $select->where('usuarioServicio.idUsuarioServicio = ?', $data["idUsuarioServicio"]);
        }
        if (isset($data["nombreUsuario"]) and !empty($data["nombreUsuario"])) {
            $concat = new Zend_Db_Expr("CONCAT(TRIM(usuario.nombreUsuario), ' ', TRIM(usuario.apellidoUsuario))");
            $select->where("$concat like ?", "%{$data["nombreUsuario"]}%");
        }  
        if (isset($data["descripcionServicio"]) and !empty($data["descripcionServicio"]))
            $select->where("servicio.descripcionServicio like ?", "%{$data["descripcionServicio"]}%");   
        
        
        $select->order('idUsuarioServicio')
                ->limit(50);

        return $db->fetchAll($select);
    }
    public function getUsuariosPorServicio($idServicio)
    {
        $db = $this->getAdapter();
        
        $select = $db->select()
            ->from(array('us' => 'usuarioservicio'), 
                array('idUsuario' => 'us.idUsuario', 
                    'nombreUsuario' => "CONCAT(u.nombreUsuario, ' ', u.apellidoUsuario)")
            )
            ->joinInner(array('u' => $this->_nameUsuario), 'us.idUsuario = u.idUsuario', array())
            ->where('us.idServicio = ?', $idServicio)
            ->where('u.idTipoUsuario = ?', '3')
            ->group('idUsuario')
            
            ;
        
        return $db->fetchAll($select);
        
    }

}
