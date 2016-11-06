<?php

class FaqModel extends Model{

    public function getList($pagination = false, $only_published = false){
        $sql = "select * from faq";
        if(!$pagination)
        {
            if($only_published){
                $sql.= " and is_published = 1";
            }
            $sql.= " ORDER BY id DESC ";
            $sql.= " LIMIT 3 ";
        } else {
            if($only_published){
                $sql.= " and is_published = 1";
            }
            $number = 3*($pagination-1);
            $sql.= " ORDER BY id DESC ";
            $sql.= " LIMIT {$number},3 ";
        }
        return $this->db->query($sql);
    }

    public function getCount(){
        $sql = "SELECT COUNT(*) as `count` FROM news";
        $result = $this->db->query($sql);
        return $result[0]['count'];
    }

    public function save($data, $id=null){
        
        $id = (int)$id;
        $question = Validate::fixString($data['question']);
        $question = $this->db->escape($question);
        $answer = Validate::fixString($data['answer']);
        $answer = $this->db->escape($answer);
        $is_published = isset($data['is_published']) ? 1 : 0;
        
        if(!$id){ // Add new record
            $sql = "
            INSERT INTO faq
                SET question = '{$question}',
                    answer = '{$answer}',
                    is_published = {$is_published}
            ";
        } else {// Update existing record
            $sql = "
            UPDATE faq
                SET question = '{$question}',
                    answer = '{$answer}',
                    is_published = {$is_published}
                WHERE id = {$id}
            ";
        }

        return $this->db->query($sql);
    }

    public function getById( $id)
    {
        $id=(int)$id;
        $sql = "select * from faq where id = '{$id}' limit 1" ;
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function delete($id){
        $id = (int)$id;
        $sql = "delete from faq where id = {$id}";
        return $this->db->query($sql);
    }
}