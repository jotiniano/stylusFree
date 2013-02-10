<?php

class Admin_AuthController extends App_Controller_Action
{
    
    public function init() {
        parent::init();
        $this->view->headScript()->appendFile($this->view->s('/js/auth.js'));            
    }

<<<<<<< HEAD
    public function indexAction(){
        
     Zend_Layout::getMvcInstance()->setLayout('login');
     $this->view->idBody = 'login-bg';
     $form = new App_Form_Login();
      
     
      //CSS
=======
    public function indexAction()
    {
        //////CSS
>>>>>>> 269bb8e0d24bced6aed3200b63230e6b872065df
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
        
        Zend_Layout::getMvcInstance()->setLayout('login');
        $this->view->idBody = 'login-bg';
        $form = new App_Form_Login();
        $this->view->formLogin = $form; 
            
        if ($form->isValid($this->_getAllParams()) &&
                $this->autentificateUser($this->_getParam('email'), $this->_getParam('pwd'))) {

            $this->_redirect($this->view->url(array("module" => "admin",
                        "controller" => "index",
                        "action" => "index")));
        } else {
            echo "error";
            exit();
        }
<<<<<<< HEAD
        
        $this->view->formLogin = $form;
    }
=======
}
>>>>>>> 269bb8e0d24bced6aed3200b63230e6b872065df
    
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

