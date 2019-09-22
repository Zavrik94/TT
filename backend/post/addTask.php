<?php


namespace backend\post;

use backend\Error;

class addTask
{
    private $conn;
    private $post;
    private $cur_id;

    function __construct() {
        $postData = file_get_contents('php://input');
        $this->post = json_decode($postData, true);
        $this->conn = new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBLOGIN, DBPASS);
    }

    public function add() {
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

    private function addRelations($arr) {
        if ($arr == null)
            return ;
        foreach ($arr as $cur_item) {
            $this->conn->query("INSERT INTO relations SET id_task=$this->cur_id,id_tag=$cur_item");
        }
    }
}