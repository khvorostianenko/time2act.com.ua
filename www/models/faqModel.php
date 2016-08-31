<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 29.08.2016
 * Time: 19:35
 */
class FaqModel extends Model{

    public function getList(){
        $handle = file_get_contents('../models/faq_text.txt');
        $result = explode(PHP_EOL.PHP_EOL, $handle);

        return $result;
    }
    
}