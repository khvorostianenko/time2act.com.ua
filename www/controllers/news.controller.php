<?php

class NewsController extends Controller{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new NewsModel();
    }

    public function index()
    {
        $this->data['news'] = $this->model->getList();
    }
    
    public function admin_index()
    {
        $this->data['news'] = $this->model->getList();
    }

    public function admin_edit(){
        if((isset($_POST['date']) && isset($_POST['title']) && isset($_POST['news']) && isset($_POST['id'])) 
            && ($_POST['date'] != '' && $_POST['title'] != '' && $_POST['news'] != '' && $_POST['id'] != '')){
            $id = $_POST['id'];
            $result = $this->model->save($_POST, $id);
            if($result){
                Session::setFlash('Page was saved.');
            } else{
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/news');
        }

        if (isset($this->params[0])){
            $this->data['news'] = $this->model->getById($this->params[0]);
        }else{
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/faq/');
        }
    }

    public function admin_add(){
        if((isset($_POST['date']) && isset($_POST['title']) && isset($_POST['news']))
            && ($_POST['date'] != '' && $_POST['title'] != '' && $_POST['news'] != '')){
            $result = $this->model->save($_POST);
            if($result){
                Session::setFlash('Page was saved.');
            } else{
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/news');
        }
    }

    public function admin_delete(){
        if(isset($this->params[0])){
            $result = $this->model->delete($this->params[0]);
            if($result){
                Session::setFlash('Page was deleted.');
            } else{
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/news');
        }
    }

}