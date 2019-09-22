<?php

namespace backend\get;

use backend\Error;

class getAnswer
{

    public function getAnswer() {
        $id = $this->checkID();
        if ($id == -1) {
            $error = new Error(6);
            return $error->getError();
        }
        if (array_key_exists('task',$_GET)) {
            $task = new getTask();
            return $task->searchTask($id);
        }
        elseif (array_key_exists('tag',$_GET)) {
            $tag = new getTag();
            return $tag->searchTag($id);
        }
        else {
            $error = new Error(2);
            return $error->getError();
        }
    }

    private function checkID() {
        if (array_key_exists('id',$_GET)) {
            if (!is_numeric($_GET["id"]) || (int)$_GET["id"] < 0) {
                return -1;
            }
            return (int)$_GET["id"];
        }
        return 0;
    }
}