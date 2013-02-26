<?php

class App_Form_CrearUsuario extends App_Form
{
    public function init() {
        parent::init();
        
        // name
        $e = new Zend_Form_Element_Text('nombreUsuario');
        $e->setLabel('Nombre');
        $e->setRequired();
        $v = new Zend_Validate_StringLength(array('min'=>1,'max'=>45));
        $e->addValidator($v);
        $this->addElement($e);

        // lastname
        $e = new Zend_Form_Element_Text('apellidoUsuario');
        $e->setLabel('Apellidos');
        $v = new Zend_Validate_StringLength(array('min'=>1,'max'=>45));
        $e->addValidator($v);
        $this->addElement($e);
        
        // usuario
        $e = new Zend_Form_Element_Text('usuario');
        $e->setLabel('Usuario');
        $e->setRequired();
        $v = new Zend_Validate_StringLength(array('min'=>1,'max'=>45));
        $e->addValidator($v);
        $this->addElement($e);


        // pwd
        $e = new Zend_Form_Element_Password('clave');
        $e->setLabel('Password');
        $e->setRequired();
        $v = new Zend_Validate_StringLength(array('min'=>5,'max'=>30));
        $e->addValidator($v);
        $this->addElement($e);
        
        // role
        $e = new Zend_Form_Element_Select('tipoUsuario');
        
        /*$e->addMultiOptions(App_Model_User::getRoles());
        $e->setValue(App_Model_User::ROLE_USER);*/
       
        /*$modeloTipoUsuario = new App_Model_TipoUsuario();
        $lista = $modeloTipoUsuario->getTipoUsuario();
        print_r($lista);
        foreach($lista as $row){
            $e->addMultiOption($row->idTipoUsuario, $row->descripcion);
        }*/
        $e->addMultiOption('', 'Seleccione');
        $e->addMultiOption('1', 'Admin');
        $e->addMultiOption('2', 'Counter');
        $e->addMultiOption('3', 'Estilista');
        //$e->setRequired();
        $this->addElement($e);
        
       
        
        // submit
        $e = new Zend_Form_Element_Submit('guardar');
        $e->setLabel('Guardar');
        $e->setAttrib('class', 'btn primary');
        $this->addElement($e);
        
    }
}

?>
