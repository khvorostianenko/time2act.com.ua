<?php

class NewsModel extends Model{

    public function getList(){
        $sql = "SELECT * FROM news";
        $result = $this->db->query($sql);
        return $result;
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
        $date = Validate::fixString($data['date']);
        $date = $this->db->escape($date);
        $title = Validate::fixString($data['title']);
        $title = $this->db->escape($title);
        $news = Validate::fixString($data['news']);
        $news = $this->db->escape($news);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if(!$id){ // Add new record
            $sql = "
            INSERT INTO news
                SET date = '{$date}',
                    title = '{$title}',
                    news = '{$news}',
                    is_published = {$is_published}
            ";
        } else {// Update existing record
            $sql = "
            UPDATE news
                SET date = '{$date}',
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
}