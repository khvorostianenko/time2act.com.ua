<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 29.08.2016
 * Time: 19:34
 */
class FaqController extends Controller{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new FaqModel();
    }

    public function index()
    {
        $this->data['faq'] = $this->model->getList();
    }

    public function admin_index(){
        $this->data['faq'] = $this->model->getList();
    }

    public function admin_edit(){
        if((isset($_POST['question']) && isset($_POST['answer']) && isset($_POST['id'])) && isset($_POST['id']) && ($_POST['question'] != '' && $_POST['answer'] != '')){
            $id = $_POST['id'];
            $result = $this->model->save($_POST, $id);
            if($result){
                Session::setFlash('Page was saved.');
            } else{
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/faq');
        }

        if (isset($this->params[0])){
            $this->data['faq'] = $this->model->getById($this->params[0]);
        }else{
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/faq/');
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
            Router::redirect('/admin/faq');
        }
    }

    public function admin_add(){
        if((isset($_POST['question']) && isset($_POST['answer'])) && ($_POST['question'] != '' && $_POST['answer'] != '')){
            $result = $this->model->save($_POST);
            if($result){
                Session::setFlash('Page was saved.');
            } else{
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/faq');
        }
    }
}