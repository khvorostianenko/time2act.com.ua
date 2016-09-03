<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 02.08.2016
 * Time: 12:02
 */
class PagesController extends Controller{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Page();
    }
    public function index(){
//        NB! Для главной страницы данные из базы не нужны
//        $this->data['pages'] = $this->model->getList();
    }

    public function view(){
        $params = App::getRouter()->getParams();

        if( isset($params[0])) {
            $alias = strtolower($params[0]);
            $this->data['page'] = $this->model->getByAlias($alias);
        }
    }

    public function user_index(){
        if(!Session::get('login')){
            Router::redirect('/signin');
        }
    }

    public function admin_index(){
        
    }

    public function admin_add(){
        if($_POST){
            $result = $this->model->save($_POST);
            if($result){
                Session::setFlash('Page was saved.');
            } else{
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/pages');
        }

    }
    
    public function admin_edit(){

        if($_POST){
            $id = isset($_POST['id']) ? $_POST['id']  : null;
            $result = $this->model->save($_POST, $id);
            if($result){
                Session::setFlash('Page was saved.');
            } else{
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/pages');
        }

        if (isset($this->params[0])){
            $this->data['page'] = $this->model->getById($this->params[0]);
        }else{
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/pages/');
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
            Router::redirect('/admin/pages');
        }
    }

}