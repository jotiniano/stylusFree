<?php

class App_Form_RegistrarIngresos extends App_Form
{
    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        parent::init();
        
        // NOMBRE ALUMNO
        $nombreAlumno = new Zend_Form_Element_Text('nombreAlumno');
        $this->addElement($nombreAlumno);

        // TIPO CONCEPTO
        //$tc = new Application_Model_Tipoconcepto();
        $tc = array('1' => 'aas');
        $tipoconcepto = new Zend_Form_Element_Select('idTipoConcepto');
        $tipoconcepto->addMultiOption('0', '-- Seleccione tipo de concepto --');
        $tipoconcepto->addMultiOptions($tc);
        
        $tipoconcepto->setRequired(true)
            ->addFilter('Int')
            ->addValidator('NotEmpty',true, array('integer','zero'));
        $tipoconcepto->setErrorMessages(array("isEmpty"=>"Debe seleccionar un Tipo concepto"));
        $this->addElement($tipoconcepto);
        
        // CONCEPTO
        $concepto = new Zend_Form_Element_Select('idConcepto');
        $concepto->addMultiOption('0', '-- Seleccionar --');
        $concepto->setRequired(true)
            ->addFilter('Int')
            ->addValidator('NotEmpty',true, array('integer','zero'));
        $concepto->setErrorMessages(array("isEmpty"=>"Debe seleccionar un Concepto"));
        $this->addElement($concepto);
        
        // MEDIO DE PAGO
        //$md = new Application_Model_MedioPago();
        $md = array('1' => 'ass');
        $medioPago = new Zend_Form_Element_Select('idMedioPago');
        $medioPago->addMultiOption('0', '-- Seleccione Medio Pago --');
        $medioPago->addMultiOptions($md);
        
        $medioPago->setRequired(true)
            ->addFilter('Int')
            ->addValidator('NotEmpty',true, array('integer','zero'));
        $medioPago->setErrorMessages(array("isEmpty"=>"Debe seleccionar un Medio pago"));
        $this->addElement($medioPago);
        
        // IMPORTE
        $importe = new Zend_Form_Element_Text('importe');
        $this->addElement($importe);
        
        // BANCO
        $bc = array('1' => 'banco');
        $banco = new Zend_Form_Element_Select('idBanco');
        $banco->addMultiOption('0', '-- Seleccione Banco --');
        $banco->addMultiOptions($bc);
        
        $banco->setRequired(true)
            ->addFilter('Int')
            ->addValidator('NotEmpty',true, array('integer','zero'));
        $banco->setErrorMessages(array("isEmpty"=>"Debe seleccionar un Banco"));
        $this->addElement($banco);
        
        // CUENTA BANCARIA
        $cuentaBancaria = new Zend_Form_Element_Select('idCuentaBancaria');
        $cuentaBancaria->addMultiOption('0', '-- Seleccionar --');
        $cuentaBancaria->setRequired(true)
            ->addFilter('Int')
            ->addValidator('NotEmpty',true, array('integer','zero'));
        $cuentaBancaria->setErrorMessages(array("isEmpty"=>"Debe seleccionar Cuenta Bancaria"));
        $this->addElement($cuentaBancaria);
        
        // NUMERO DE OPERACION
        $numeroOperacion = new Zend_Form_Element_Text('numeroOperacion');
        $this->addElement($numeroOperacion);
        

        


    }

}

