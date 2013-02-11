<?php

class Admin_ServicioController extends App_Controller_Action
{
    
    /**
     *
     * @var Application_Model_User
     */
    protected $mServicio;

    public function init() {
        parent::init();
        $this->mServicio = new App_Model_Servicio();
        $this->indexUrl = $this->view->url(array('controller'=>'servicio','action'=>'index'),null,true);
    }
    
    public function indexAction()
    {
        $form = new App_Form_BuscarUsuario();
        $modelUsuario = new App_Model_User();
        
        $result = $modelUsuario->lista();
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $form->populate($data);
            $result = $modelUsuario->buscarUsuario($data);
        }
        $this->view->form = $form;
        $this->view->result = $result; 
    }
    
    public function newAction()
    {
        $form = new App_Form_User();
        if($this->_request->isPost()){
            $params = $this->_getAllParams();
            if($form->isValid($params)){
                $this->mUser->create($form->getValues(), $this->authData->id);
                $this->getMessenger()->success('New User Added');
                $this->_redirect($this->indexUrl);
            }
        }
        $this->view->form = $form;
    }
    
    public function activateAction() {
        $this->changeActiveFlag('1', 'User Activated');
    }

    public function deactivateAction() {
        $this->changeActiveFlag('0', 'User Deactivated');
    }
    
    private function changeActiveFlag($value, $msg){
        $db = $this->mUser->getAdapter();
        $where = $db->quoteInto('id = ?', $this->_getParam('id'));
        $this->mUser->update(array('active'=>$value), $where);
        $this->getMessenger()->success($msg);
        $this->_redirect($this->indexUrl);
    }
    
    


}