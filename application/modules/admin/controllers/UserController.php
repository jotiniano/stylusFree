<?php

class Admin_UserController extends App_Controller_Action
{
    
    /**
     *
     * @var Application_Model_User
     */
    protected $mUser;

    public function init() {
        parent::init();
        $this->mUser = new App_Model_User();
        $this->indexUrl = $this->view->url(array('controller'=>'user','action'=>'index'),null,true);
    }
    
    public function indexAction()
    {
        $form = new App_Form_BuscarUsuario();
        
       
        $modelUsuario = new App_Model_Usuario();
        print_r($form);
        exit; 
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