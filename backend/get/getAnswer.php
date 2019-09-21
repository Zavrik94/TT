<?php

namespace backend\get;

use backend\Error;

class getAnswer
{
    private $conn;
    private $get;

    function __construct($get) {
        $this->get = $get;
        $this->conn = new \PDO('mysql:host=' . DBHOST . ':' . DBPOST . ';dbname=' . DBNAME, DBLOGIN, DBPASS);

    }

    public function getAnswer() {
        if ($this->get['task'] == "search") {
            if ($this->get['id'] && !is_numeric($this->get['id'])) {
                $error = new Error(6);
                return $error->getError();
            }
            $id = $this->get['id'] == null ? 0 : (int)$this->get['id'];
            if ($id < 0) {
                $error = new Error(6);
                return $error->getError();
            }
            return $this->getRequestOnSearch($id);
        }
        else {
            $error = new Error(2);
            return $error->getError();
        }
    }

    private function getRequestOnSearch($id) {
        if ($this->get['type'] == "task") {
            return $this->searchTask($id);
        }
        elseif ($this->get['type'] == "tag") {
            return $this->searchTag($id);
        }
        else {
            $error = new Error(4);
            return $error->getError();
        }
    }

    private function searchTask($id) {
        $answer = $this->conn->query("SELECT * FROM task" . ($id == 0 ? "" : " WHERE id = $id"));
        $result = [];
        $result[] = ["error" => false, "rows" => $answer->rowCount()];
        while ($res = $answer->fetch(\PDO::FETCH_ASSOC)) {
            $id = (int)$res["id"];
            unset($res["id"]);
            $result[] = [$id => $res];
        }
        return json_encode($result);
    }

    private function searchTag($id) {
        $answer = $this->conn->query("SELECT * FROM tag"  . ($id == 0 ? "" : " WHERE id = $id"));
        $result = [];
        $result[] = ["error" => false, "rows" => $answer->rowCount()];
        while ($res = $answer->fetch(\PDO::FETCH_ASSOC)) {
            $id = $res["id"];
            unset($res["id"]);
            $result[] = [$id => $res];
        }
        return json_encode($result);
    }
}