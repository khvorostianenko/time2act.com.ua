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
}