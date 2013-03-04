<?php

class App_Form_CrearUsuarioServicio extends App_Form
{
    public function init() {
        parent::init();
        
        //usuario
        $modelUsuario = new App_Model_User();
        $listaUsuarioEstilista = $this->fetchPairs($modelUsuario->listarDatos());
        
        $this->addElement(new Zend_Form_Element_Select('idUsuario'));
        $this->getElement('idUsuario')->addMultiOption('', 'Seleccione Usuario');
        $this->getElement('idUsuario')->addMultiOptions($listaUsuarioEstilista);
        $this->getElement('idUsuario')->setAttrib('class', 'span8');
        $this->getElement('idUsuario')->setRequired();         

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
