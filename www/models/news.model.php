<?php

class NewsModel extends Model{

    public function getList($pagination = false, $only_published = false){
        $sql = "select * from news";
        if(!$pagination)
        {
            if($only_published){
                $sql.= " and is_published = 1";
            }
            $sql.= " ORDER BY id DESC";
            $sql.= " LIMIT 7 ";
        } else {
            if($only_published){
                $sql.= " and is_published = 1";
            }
            $number = 7*($pagination-1);
            $sql.= " ORDER BY id DESC";
            $sql.= " LIMIT {$number},7 ";
        }
        return $this->db->query($sql);
    }

    public function getCount(){
        $sql = "SELECT COUNT(*) as `count` FROM news";
        $result = $this->db->query($sql);
        return $result[0]['count'];
    }

    public function getById( $id)
    {
        $id=(int)$id;
        $sql = "select * from news where id = '{$id}' limit 1" ;
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function save($data, $id=null){

        $id = (int)$id;
        if(!empty($data['date'])){
            $date = Validate::fixString($data['date']);
            $date = $this->db->escape($date);
        } else {
            $date = $today = date("Y-m-d H:i:s");
        }
        $title = Validate::fixString($data['title']);
        $title = $this->db->escape($title);
        $news = Validate::fixString($data['news']);
        $news = $this->db->escape($news);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if(!$id){ // Add new record
            $sql = "
            INSERT INTO news
                SET `date` = '{$date}',
                    title = '{$title}',
                    news = '{$news}',
                    is_published = {$is_published}
            ";
        } else {// Update existing record
            $sql = "
            UPDATE news
                SET `date` = '{$date}',
                    title = '{$title}',
                    news = '{$news}',
                    is_published = {$is_published}
                WHERE id = {$id}
            ";
        }

        return $this->db->query($sql);
    }

    public function delete($id){
        $id = (int)$id;
        $sql = "delete from news where id = {$id}";
        return $this->db->query($sql);
    }


public function search($data, $pagination = false)
{
    $message = 'Вы искали ';

    if(isset($data['content'])){
        $_SESSION['is_published'] = isset($data['is_published'])? 1: 0;
        $_SESSION['period'] = $data['period'];
        $_SESSION['content'] = $data['content'];
    } else {
        $data['is_published'] = $_SESSION['is_published'];
        $data['period'] = $_SESSION['period'];
        $data['content'] = $_SESSION['content'];
    }

    //ddd($_SESSION);

    if(isset($data['is_published'])){
        $is_published = 1;
        $message.= 'опубликованные новости ';
    } else {
        $is_published = 0;
        $message.= 'не опубликованные новости ';
    }



    $sql = "SELECT * FROM news WHERE is_published = {$is_published}";

    foreach($data as $key => $value){
        if($key == 'period' && $value != ''){
            $sql.= " AND date > (NOW() - INTERVAL 60*60*24*{$value} MINUTE) ";
            switch($value){
                case '1':
                    $message.= 'за сутки ';
                    break;
                case '30':
                    $message.= 'за месяц ';
                    break;
                default:
                    $message.= 'за все время ';
                    break;
            }
        }
        if($key == 'content' && $value != ''){
                $sql.= " AND (title LIKE '%{$value}%' OR news LIKE '%{$value}%')";
                $message.= " с контентом: '{$value}'";
        }
    }


    $sql_for_count = preg_replace('/SELECT \*/','SELECT COUNT(*) as `count`',$sql);
    $result = $this->db->query($sql_for_count);
    $count = $result[0]['count'];

    $sql.=" ORDER BY id DESC ";
    if($pagination)
    {
        $number = 7*($pagination-1);
        $sql.= " LIMIT {$number},7 ";
    } else {
        $sql.= " LIMIT 7 ";
    }

    $result = $this->db->query($sql);
    $result[0]['message'] = $message;
    $result[0]['count'] = $count;
    return $result;

}

}