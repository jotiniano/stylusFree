<?php

class App_Form_CrearCliente extends App_Form
{
    public function init() {
        
        parent::init();
        
        $e = new Zend_Form_Element_Text('idCliente');
        $e->setAttrib('class', 'span8');  
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('nombreCliente');        
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('apellidoCliente');
        $e->setRequired(true);
        $e->setFilters(array("StripTags", "StringTrim"));        
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('fechaNacimiento');
        $e->setAttrib('class', 'span8');
        $e->setRequired(true);
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);        
        
        $e = new Zend_Form_Element_Text('correo');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $v = new Zend_Validate_EmailAddress();
        $e->addValidator($v);
        $e->setRequired(true);
        $e->addFilter(new Zend_Filter_HtmlEntities());
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('telefono');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('dni');
        $e->setAttrib('class', 'span8')
                ->setFilters(array("StripTags"))
                ->addValidator('Digits');
        $v = new Zend_Validate_StringLength(array('min'=>8));
        $e->addValidator($v);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('celular');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        
        $e = new Zend_Form_Element_Text('direccion');
        //$e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Submit('guardar');
        $e->setLabel('Guardar')->setAttrib('class', 'btn pull-right');
        $this->addElement($e);
        
        $this->addElement('hash', 'csrf', array(
                    'ignore' => true,
                ));
        
         foreach($this->getElements() as $e) {
            $e->clearDecorators();
            $e->addDecorator("ViewHelper");
         }
        
        
        
    }
}