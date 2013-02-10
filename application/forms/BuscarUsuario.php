<?php

class App_Form_BuscarUsuario extends App_Form
{
    public function init() {
        
        parent::init();
        
        $e = new Zend_Form_Element_Text('idUsuario');
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('nombre');
        $e->setAttrib('class', 'span8');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('usuario');
        $e->setAttrib('class', 'span8');
        $this->addElement($e);        
        
        $e = new Zend_Form_Element_Submit('buscar');
        $e->setLabel('Buscar')->setAttrib('class', 'btn pull-right');
        $this->addElement($e);
        
        foreach($this->getElements() as $e) {
            $e->removeDecorator('DtDdWrapper');
            $e->removeDecorator('Label');
            $e->removeDecorator('HtmlTag');
        }    
        
    }
}