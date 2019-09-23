<?php


namespace backend\get;


class getTask
{
    private $conn;


    function __construct() {
        $this->conn = new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBLOGIN, DBPASS);
    }

    public function searchTask($task_id) {
        $answer = $this->conn->query("SELECT * FROM task" . ($task_id == 0 ? "" : " WHERE id = $task_id"));
        $result = ["error" => false, "rows" => $answer->rowCount()];
        while ($res = $answer->fetch(\PDO::FETCH_ASSOC)) {
            $result["tasks"][] = $res;
        }
        if ($task_id > 0) {
            $result["tags"] = $this->searchTags($task_id);
        }
        return json_encode($result);
    }

    private function searchTags($id) {
        $result = [];
        $answer = $this->conn->query("SELECT * FROM relations WHERE id_task = $id");
        while ($res = $answer->fetch(\PDO::FETCH_ASSOC)) {
            $id_tag = $res['id_tag'];
            $search = $this->conn->query("SELECT * FROM tag WHERE id = $id_tag");
            $result[] = [$id_tag => $search->fetch(\PDO::FETCH_ASSOC)];
        }
        return $result;
    }
}