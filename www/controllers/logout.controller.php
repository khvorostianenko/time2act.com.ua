<?php

class LogoutController extends Controller
{
    public function index()
    {
        Session::delete('login');
        Router::redirect('/signin');
    }

}