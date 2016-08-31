<?php

class SigninController extends Controller{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new SigninModel();
    }

    public function index()
    {
        // Постараться убрать тут инициализацию
        $this->data['message'] = '';
        $this->data['color'] = '';

        if(isset($_POST['email']) && isset($_POST['password']))
        {
            Session::delete('login');

            if($_POST['email'] == '' && $_POST['password'] == '')
            {
                $this->data['message'] = 'Недостаточно параметров для входа!';
                $this->data['color'] = 'red';
            }
            else
            {
                $email = Validate::fixString($_POST['email']);
                $password = Validate::fixString($_POST['password']);
                $user = $this->model->getByLogin($email);
                if(!$user){
                    $this->data['message'] = "Пользователь с email: {$email} не зарегистрирован";
                    $this->data['color'] = 'red';
                }  else
                {
                    $hash = $user['password'];
                    if(Password::verifyPassAndHash($password, $hash))
                    {
                        echo 'Sov';
                        Session::set('login', $email);
                        header('Location: user');
                    } else {
                        $this->data['message'] =  'Неверное значение имени и пароля!';
                        $this->data['color'] = 'red';
                    }
        }
            }

        } else {
            if(Session::get('login')){
                Router::redirect('user');
            }
        }
    }

    public function fix_string($string)
    {
        $string = strip_tags($string);
        $string = htmlentities($string);
        $string = stripslashes($string);
        
        // real_escape_string находится в модели
        //return $connection->real_escape_string($string);
        
        return $string;
    }
}

