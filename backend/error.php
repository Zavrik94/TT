<?php

namespace backend;

class Error
{
    private $error_id;

    function __construct($id) {
        $this->error_id = $id;
    }

    public function getError() {
        $result = [];
        $result[] = ["error" => true];
        $result[] = ["id" => $this->error_id, "error_desc" => $this->getErrorDescriprion()];
        return json_encode($result);
    }

    private function getErrorDescriprion() {
        switch ($this->error_id) {
            case 1 : return "Can`t find any GET or POST data";
            case 2 : return "GET task error";
            case 3 : return "POST task error";
            case 4 : return "Wrong type on search task";
            case 5 : return "Wrong type on add task";
            case 6 : return "Wrong id for search";
            case 7 : return "Add error: Wrong task name";
            case 8 : return "Add error: Wrong task description";
            case 9 : return "Add error: Wrong tag name";
        }
    }
}