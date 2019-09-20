<?php
require_once "getAnswer.php";
require_once "postAnswer.php";

class taskManager
{
    private $conn;
    private $get;
    private $post;
    private $json;

    function __construct($get, $post) {
        $this->get = $get;
        $this->post = $post;
        $this->conn = mysqli_connect('localhost', 'root', 'root', 'taskmanager', '3307');
        return $this;
    }

    private function parsRequest() {
        if ($this->get != []) {
            if ($this->get['taskType'] == "search") {
               $this->getRequestOnSearch();
            }
            else if ($this->get['taskType'] == "searchOne") {
                $this->getRequestOnSearchOne();
            }
            else {
                $this->error(2);
            }
        }
        else if ($this->post != []) {
            $this->getRequestOnAdd();
        }
        else {
            return $this->error(1);
        }
    }

    private function getRequestOnSearch() {
        if ($this->get['what'] == "task") {
            return $this->searchAllTasks();
        }
        else if ($this->get['what'] == "tag") {
            return "searching all tags";
        }
        else {
            return "not what";
        }
    }

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

    private function searchAllTags() {
        $answer = mysqli_query($this->conn, "SELECT * FROM `tag`");
        $result = array();
        while ($res = mysqli_fetch_assoc($answer)) {
            $result[] =  $res;
        }
        return json_encode($result);
    }

    private function addNewTask($name, $desc) {
        $curDate = date("Y-m-d");
        $answer = mysqli_query($this->conn, "INSERT INTO `task` (`name`, `description`, `date`) VALUES (\"$name\", \"$desc\", \"$curDate\")");
    }

    public function getAnswer() {
        return $this->parsRequest();
    }

    private function convertArray($arr) {
        $res = array();
        $res[] = $arr["name"];
    }

    private function error($errorType) {
        return null;
    }
}