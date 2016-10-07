<?php

class FaqModel extends Model{

    public function getList(){
        $sql = "SELECT * FROM faq";
        $result = $this->db->query($sql);
        return $result;
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