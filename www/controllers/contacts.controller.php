<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 02.08.2016
 * Time: 19:25
 */
class ContactsController extends  Controller{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Message();
    }

    // старый
    public function index(){
        if($_POST){
            if($this->model->save($_POST))
            {
                Session::setFlash('Thank you! Your message was sent successfully!');
            }
        }
        
    }

    // старый
    public  function admin_index(){
        $this->data = $this->model->getList();
    }
}