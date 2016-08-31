<?php
class AboutController extends Controller
{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new AboutUs();
    }
    
    public function index()
    {
    }

}