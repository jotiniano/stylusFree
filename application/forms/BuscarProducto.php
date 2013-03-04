<?php

class App_Form_BuscarProducto extends App_Form
{
    public function init() {        
        parent::init();
        
        $e = new Zend_Form_Element_Text('idProducto');
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('nombreProducto');
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
          $e = new Zend_Form_Element_Text('precio');
        $e->setAttrib('class', 'span8');
        $this->addElement($e);       
        
        $e = new Zend_Form_Element_Submit('buscar');
        $e->setLabel('Buscar')->setAttrib('class', 'btn pull-right');
        $this->addElement($e);        
        
    }
}