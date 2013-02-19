<?php

class App_Form_CrearUsuarioServicio extends App_Form
{
    public function init() {
        parent::init();
        
        //usuario
        
        $e = new Zend_Form_Element_Select('nombreUsuario');
        $e->addMultiOption('', 'Seleccione');
        $e->addMultiOption('1', 'Admin');
        $e->addMultiOption('2', 'Counter');
        $e->addMultiOption('3', 'Estilista');
        $e->setRequired();
        $this->addElement($e);
        
        
        // servicio
        /*
        $model = new App_Model_Servicio();
        $valor = $model->listarDatos();
        $this->addElement('select','descripcionServicio',array(
                          'label' => 'Tipo de Objeto',
                          'value' => 'parametro',
                          'multiOptions' => $this->fetchPairs($valor)
                            )
        );*/
        $model = new App_Model_Servicio();
        $listaServicio = $this->fetchPairs($model->listarDatos());
        
        $this->addElement(new Zend_Form_Element_Select('descripcionServicio'));
        $this->getElement('descripcionServicio')->addMultiOption('', 'Seleccione Servicio');
        $this->getElement('descripcionServicio')->addMultiOptions($listaServicio);
        $this->getElement('descripcionServicio')->setAttrib('class', 'span8');
        $this->getElement('descripcionServicio')->setRequired();                                        
        

        
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
        $e->setLabel('Add');
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
