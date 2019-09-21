<?php

namespace backend\post;

use backend\Error;

class postAnswer
{
    private $conn;
    private $post;

    function __construct($post) {
        $this->post = $post;
        $this->conn = new \PDO('mysql:host=' . DBHOST . ':' . DBPOST . ';dbname=' . DBNAME, DBLOGIN, DBPASS);
    }

    public function getAnswer() {
        if ($this->post['task'] == "add") {
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
        $answer=$this->conn->lastInsertId();
        $result[] = ["error" => false];
        $result[] = ["id" => $answer];
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
        $answer=$this->conn->lastInsertId();
        $result[] = ["error" => false];
        $result[] = ["id" => $answer];
        return json_encode($result);
    }
}