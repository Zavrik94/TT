<?php
require_once "taskManager.php";

class getAnswer extends taskManager
{
    private function searchAllTasks() {
        $answer = mysqli_query($this->conn, "SELECT * FROM `task`");
        $result = [];
        $result[] = ["error" => false];
        while ($res = mysqli_fetch_assoc($answer)) {
            $id = $res["id"];
            unset($res["id"]);
            $result[] = [$id => $res];
        }
        return json_encode($result);
    }
}