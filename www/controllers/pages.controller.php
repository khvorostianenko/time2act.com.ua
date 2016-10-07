<?php

class PagesController extends Controller{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new PageModel();
    }
    public function index(){
    }

    public function view(){
        $params = App::getRouter()->getParams();

        if( isset($params[0])) {
            $alias = strtolower($params[0]);
            $this->data['page'] = $this->model->getByAlias($alias);
        }
    }

    public function user_index(){
    }

    public function admin_index(){
        
    }
}