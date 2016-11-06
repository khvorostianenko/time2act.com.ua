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

    public function admin_search(){

        if(!empty($this->params[0]))
        {
            $this->data['pagination'] = $this->params[0];
        } else {
            $this->data['pagination'] = '';
        }

        $this->data['news'] = $this->model->search($_POST, $this->data['pagination']);
        $this->data['count'] = $this->data['news'][0]['count'];
        $this->data['count_for_paginatior'] = (is_int($this->data['count']/7))? $this->data['count']/7:floor($this->data['count']/7 + 1);

    }
    
    
    public function admin_index()
    {

        if(!empty($this->params[0]))
        {
            $this->data['pagination'] = $this->params[0];
        } else {
            $this->data['pagination'] = '';
        }

        Session::set('page','news');
        $this->data['news'] = $this->model->getList($this->data['pagination']);
        $this->data['count'] = $this->model->getCount();
        $this->data['count_for_paginatior'] = (is_int($this->data['count']/7))? $this->data['count']/7:floor($this->data['count']/7 + 1);
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
        if((isset($_POST['title']) && isset($_POST['news']))
            && ($_POST['title'] != '' && $_POST['news'] != '')){
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