<?php

class NewsController extends Controller{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new NewsModel();
    }

    public function index()
    {
        
    }
}