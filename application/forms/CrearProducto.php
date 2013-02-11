<?php

class App_Form_CrearProducto extends App_Form
{
    public function init() {
        
        parent::init();
        
        $e = new Zend_Form_Element_Text('idProducto');
        $e->setAttrib('class', 'span8');  
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('nombreProducto');
        $e->setAttrib('class', 'span8');
        $e->setFilters(array("StripTags", "StringTrim"));
        $e->setRequired(true);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('precio');
        $e->setRequired(true);
        $e->setFilters(array("StripTags", "StringTrim", "HtmlEntities"));
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_File('foto');        
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Submit('guardar');
        $e->setLabel('Guardar')->setAttrib('class', 'btn pull-right');
        $this->addElement($e);
        
        $this->addElement('hash', 'csrf', array(
                    'ignore' => true,
                ));
         foreach($this->getElements() as $e) {
            $e->removeDecorator('DtDdWrapper');
            $e->removeDecorator('Label');
            $e->removeDecorator('HtmlTag');
        } 
        
        
        
    }
}