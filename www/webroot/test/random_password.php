<meta charset="utf-8">
<?php

// Символы, которые будут использоваться в пароле.
$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

// Количество символов в пароле.
$max=8;

// Определяем количество символов в $chars
$size=strlen($chars)-1;

// Определяем пустую переменную, в которую и будем записывать символы.
$password=null;

// Создаём пароль.
while($max--)
    $password.=$chars[rand(0,$size)];

// Выводим созданный пароль.
echo
    "<center> 
        Сгенерированный пароль: 
            <hr><font face=verdana color=red size=7><b>".$password."</b></font><hr> 
            <a href=&#63;>Создать новый пароль.</a>
    </center>";
?>