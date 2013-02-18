<?php

class App_Form_CrearTicket extends App_Form
{
    public function init() {
        parent::init();
               
        $e = new Zend_Form_Element_Text('idCliente');
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('nombre');
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('precio');
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Select('idServicio');
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Submit('buscar');
        $e->setLabel('Buscar')->setAttrib('class', 'btn pull-right');
        $this->addElement($e);        
        
    }
}