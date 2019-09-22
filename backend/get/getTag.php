<?php


namespace backend\get;


class getTag
{
    private $conn;

    function __construct() {
        $this->conn = new \PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBLOGIN, DBPASS);
    }

    public function searchTag($tag_id) {
        $answer = $this->conn->query("SELECT * FROM tag" . ($tag_id == 0 ? "" : " WHERE id = $tag_id"));
        $result = ["error" => false, "rows" => $answer->rowCount()];
        while ($res = $answer->fetch(\PDO::FETCH_ASSOC)) {
            $result["tags"][] = $res;
        }
        if ($tag_id > 0) {
            $result["tasks"] = $this->searchTasks($tag_id);
        }
        return json_encode($result);
    }

    private function searchTasks($id) {
        $result = [];
        $answer = $this->conn->query("SELECT * FROM relations WHERE id_tag = $id");
        while ($res = $answer->fetch(\PDO::FETCH_ASSOC)) {
            $id_task = $res['id_task'];
            $search = $this->conn->query("SELECT * FROM task WHERE id = $id_task");
            $result[] = [$id_task => $search->fetch(\PDO::FETCH_ASSOC)];
        }
        return $result;
    }
}