<?php

namespace backend\post;

use backend\Error;

class postAnswer
{
    private $conn;
    private $post;
    private $cur_id;

    function __construct() {
        $postData = file_get_contents('php://input');
        $this->post = json_decode($postData, true);
        $this->conn = new \PDO('mysql:host=' . DBHOST . ':' . DBPOST . ';dbname=' . DBNAME, DBLOGIN, DBPASS);
    }

    public function getAnswer() {
        if (array_key_exists('type',$this->post)) {
            return $this->add();
        }
        else {
            $error = new Error(3);
            return $error->getError();
        }
    }


    private function add() {
        if ($this->post['type'] == 'task') {
            return $this->addTask();
        }
        elseif ($this->post['type'] == 'tag') {
            return $this->addTag();
        }
        else {
            $error = new Error(5);
            return $error->getError();
        }
    }

    private function addTask() {
        if (!$this->post['name']) {
            $error = new Error(7);
            return $error->getError();
        }
        elseif (!$this->post['description']) {
            $error = new Error(8);
            return $error->getError();
        }
        $date = date('Y-m-d');
        $name = $this->post['name'];
        $desc = $this->post['description'];
        $this->conn->query("INSERT INTO task SET name='$name',description='$desc',date='$date'");
        $this->cur_id=$this->conn->lastInsertId();
        $result = ["error" => false];
        $result["id"] = (int)$this->cur_id;
        $this->addRelations($this->post['tags']);
        return json_encode($result);
    }

    private function addTag() {
        if (!$this->post['name']) {
            $error = new Error(9);
            return $error->getError();
        }
        $date = date('Y-m-d');
        $name = $this->post['name'];
        $this->conn->query("INSERT INTO tag SET name='$name',date='$date'");
        $this->cur_id=$this->conn->lastInsertId();
        $result[] = ["error" => false];
        $result[] = ["id" => $this->cur_id];
        $this->addRelations($this->post['tasks']);
        return json_encode($result);
    }

    private function addRelations($arr) {
        foreach ($arr as $cur_item) {
            if ($this->post['type'] == 'task')
                $this->conn->query("INSERT INTO relations SET id_task=$this->cur_id,id_tag=$cur_item");
            elseif ($this->post['type'] == 'tag')
                var_export($this->conn->query("INSERT INTO relations SET id_task=$cur_item,id_tag=$this->cur_id"));
        }
    }
}