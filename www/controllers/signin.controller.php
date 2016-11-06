<?php

// В данном классе помимо авторизации на сайт содержатся методы смены пароля
// используется класс Mail папки lib
// используется класс validate
// класс password
class SigninController extends Controller{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new SigninModel();
    }

    public function index()
    {
        Session::setFlash('Войти в личный кабинет');
        
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
                        Session::set('role', $user['role']);
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

    public function admin_index()
    {
        // Постараться убрать тут инициализацию
        $this->data['message'] = '';
        $this->data['color'] = '';
        $_POST['loyout_flag'] = 1;

        if(isset($_POST['email']) && isset($_POST['password']))
        {
            Session::delete('admin');

            if($_POST['email'] == '' && $_POST['password'] == '')
            {
                $this->data['message'] = 'Недостаточно параметров для входа!';
                $this->data['color'] = 'red';
            }
            else
            {
                $email = Validate::fixString($_POST['email']);
                $password = Validate::fixString($_POST['password']);
                $user = $this->model->getAdminByLogin($email);
                if(!$user){
                    $this->data['message'] = "Пользователь с email: {$email} не является администратором";
                    $this->data['color'] = 'red';
                }  else
                {
                    $hash = $user['password'];
                    if(Password::verifyPassAndHash($password, $hash))
                    {
                        Session::set('role', 'admin');
                        Router::redirect('/admin');
                    } else {
                        $this->data['message'] =  'Неверное значение имени и пароля!';
                        $this->data['color'] = 'red';
                    }
                }
            }

        } else {
            if(Session::get('role')){
                Router::redirect('/admin');
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

    public function forget(){

        // Постараться убрать тут инициализацию
        $this->data['message'] = '';
        $this->data['color'] = '';

        if(!empty($_POST['email'])){
            $email = Validate::fixString($_POST['email']);
            $user = $this->model->getByLogin($email);
            if(!$user)
            {
                $this->data['message'] = "Пользователь с email: {$email} не зарегистрирован";
                $this->data['color'] = 'red';
            }
                else
            {
                // Записываем емейл в сессию (понадобится при обновлении пароля)
                Session::set('email', $email);
                // Генерируем рандомный код (8 буквоцифр),
                $code = $this->random_code(8);
                // записываем в сессию
                Session::set('code', $code);
                // отправка через Мейлер письма,
                $message = "Проверочный код: {$code}";
                Session::set('message', Mail::send_mail($email, $message));
                header('Location: /signin/verify');
                // перекидываем на страницу ввода кода
            }
        }
    }

    public function random_code($length){
        // Символы, которые будут использоваться в пароле.
        $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

        // Количество символов в пароле.
        $max=$length;

        // Определяем количество символов в $chars
        $size=strlen($chars)-1;

        // Определяем пустую переменную, в которую и будем записывать символы.
        $code='';

        // Создаём код
        while($max--){
            $code.=$chars[rand(0,$size)];
        }

        // Возвращаем готовый код
        return $code;
    }
    
    public function verify(){

        Session::setFlash(Session::get('message'));
        if(!empty($_POST['code'])){
            if(Session::get('code') == trim($_POST['code'])){
                header('Location: /signin/change');
            } else {
                Session::setFlash('Вы ввели не верный код. Введите еще раз или запросите новый код');
            }
        }
    }

    public function change(){
        Session::setFlash('Введите новый пароль');

        $this->data['message'] = '';
        $this->data['color'] = '';
        $this->data['email'] = '';

        if(Session::get('login')){
            Router::redirect('/user');
        }

        if(isset($_POST['password']) && isset($_POST['passwordRepeat']) ){
            $validate = new Validate($_POST);

            if ( $validate->getFail()!= "") {
                $this->data['message'] = 'В Вашей форме найдены ошибки: <br>'.$validate->getFail().'';
                $this->data['color'] = 'red';
            } else {
                $email = Validate::fixString(Session::get('email'));
                    $password = Validate::fixString($_POST['password']);
                    $model = new SignupModel();
                    $user_update = $model->userPasswordUpdate($email, $password);
                    if(!$user_update){
                        $this->data['message'] = 'Произошла ошибка обновлении пароля. Попробуйте через еще раз';
                        $this->data['color'] = 'red';
                    }
                    else {
                        $this->data['message'] = 'Вы успешно сменили пароль. Теперь Вы можете зайти в свой личный кабинет с новым паролем';
                        $this->data['color'] = '#a0c437';
                        $this->data['email'] = '';
                    }
            }
        }

    }
}

