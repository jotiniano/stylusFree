<?php

class App_Form_EditarUsuarioServicio extends App_Form
{
    public function init() {
        parent::init();
        
        //usuario
        $e = new Zend_Form_Element_Hidden('idUsuarioServicio');
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Text('nombreUsuario');
        $e->setLabel('Nombre');
        $e->setAttrib('disabled', true);
        $e->setRequired();
        $v = new Zend_Validate_StringLength(array('min'=>1,'max'=>45));
        $e->addValidator($v);
        $this->addElement($e);
        // servicio
        
        $model = new App_Model_Producto();
        $listaServicio = $this->fetchPairs($model->lista($tipo=2));
        
        $this->addElement(new Zend_Form_Element_Select('idServicio'));
        $this->getElement('idServicio')->addMultiOption('', 'Seleccione Servicio');
        $this->getElement('idServicio')->addMultiOptions($listaServicio);
        $this->getElement('idServicio')->setAttrib('class', 'span8');
        $this->getElement('idServicio')->setRequired();                                        
        
        
        //comision
        $e = new Zend_Form_Element_Text('comision');
        $e->setAttrib('class', 'span8')
                ->setFilters(array("StripTags"))
                ->addValidator('float');
        $v = new Zend_Validate_StringLength(array('min'=>0));
        $e->addValidator($v);
        $e->setRequired();
        $this->addElement($e);
       
        
        // submit
        $e = new Zend_Form_Element_Submit('guardar');
        $e->setLabel('Grabar');
        $e->setAttrib('class', 'btn primary');
        $this->addElement($e);
        
    }
    
       function fetchPairs($array){
        $data=array();
        foreach ($array as $index){
            $arrayKey=array_keys($index);
            if(count($arrayKey)>=2)
            $data[$index[$arrayKey[0]]] = $index[$arrayKey[1]];
            else
            $data[$index[$arrayKey[0]]] = $index[$arrayKey[0]];    
        }
        return $data;
    }
}

?>
