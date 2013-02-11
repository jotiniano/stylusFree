<?php

class App_Form_CrearUsuario extends App_Form
{
    public function init() {
        parent::init();
        
        // name
        $e = new Zend_Form_Element_Text('nombre');
        $e->setLabel('Nombre');
        $e->setRequired();
        $v = new Zend_Validate_StringLength(array('min'=>1,'max'=>45));
        $e->addValidator($v);
        $this->addElement($e);

        // lastname
        $e = new Zend_Form_Element_Text('apellido');
        $e->setLabel('Apellidos');
        $v = new Zend_Validate_StringLength(array('min'=>1,'max'=>45));
        $e->addValidator($v);
        $this->addElement($e);
        
        // usuario
        $e = new Zend_Form_Element_Text('usuario');
        $e->setLabel('Usuario');
        $v = new Zend_Validate_StringLength(array('min'=>1,'max'=>45));
        $e->addValidator($v);
        $this->addElement($e);


        // pwd
        $e = new Zend_Form_Element_Text('pwd');
        $e->setLabel('Password');
        $e->setRequired();
        $v = new Zend_Validate_StringLength(array('min'=>6,'max'=>64));
        $e->addValidator($v);
        $this->addElement($e);
        
        // role
        $e = new Zend_Form_Element_Select('tipoUsuario');
        $e->setLabel("Tipo Usuario");
        /*$e->addMultiOptions(App_Model_User::getRoles());
        $e->setValue(App_Model_User::ROLE_USER);*/
        $e->setRequired();
        $this->addElement($e);
        
        
        // submit
        $e = new Zend_Form_Element_Submit('submit');
        $e->setLabel('Add');
        $e->setAttrib('class', 'btn primary');
        $this->addElement($e);
        
    }
}

?>
