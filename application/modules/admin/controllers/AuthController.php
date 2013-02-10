<?php

class Admin_AuthController extends App_Controller_Action
{
    
    public function init() {
        parent::init();
        $this->view->headScript()->appendFile($this->view->s('/js/auth.js'));            
    }

    public function indexAction(){
        
     Zend_Layout::getMvcInstance()->setLayout('login');
     $this->view->idBody = 'login-bg';
     $form = new App_Form_Login();
      
     
      //CSS
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/screen.css'
        );
        $this->view->headLink()->appendStylesheet(
            $this->getConfig()->app->mediaUrl . '/css/formularios/screen.css'
        );
        
        //JS
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/formularios/lib/jquery.js'
        );
        
        $this->view->headScript()->appendFile(
            $this->getConfig()->app->mediaUrl . '/js/formularios/jquery.validate.js'
        );
        
       if ($this->getRequest()->isPost()) {
            
           if ($form->isValid($this->_getAllParams()) && 
                    $this->autentificateUser($this->_getParam('email'), 
                            $this->_getParam('pwd'))) {
                
             
                $this->_redirect($this->view->url(array("module" => "admin",
                            "controller" => "index",
                            "action" => "index")));
            } else {
                echo "error"; exit();
            }
            
        }
        
        $this->view->formLogin = $form;
    }
    
    public function loginAction()
    {
        $this->_helper->layout->setlayout('login');
        $form = new App_Form_Login();
        if( $this->_request->isPost() ){
            $params = $this->_getAllParams();
            if($form->isValid($params)){
                $this->_helper->redirector->gotoUrl('/');
            }
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector->gotoRoute(array(), 'login', true);
    }
}

