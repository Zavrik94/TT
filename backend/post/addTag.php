<?php


namespace backend\post;

use backend\Error;

class addTag
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
        if ($arr == null)
            return ;
        foreach ($arr as $cur_item) {
            $this->conn->query("INSERT INTO relations SET id_task=$cur_item,id_tag=$this->cur_id");
        }
    }
}