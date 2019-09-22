<?php

namespace backend\post;

use backend\Error;

class postAnswer
{
    private $post;

    function __construct() {
        $postData = file_get_contents('php://input');
        $this->post = json_decode($postData, true);
    }

    public function getAnswer() {
        if (array_key_exists('type',$this->post)) {
            return $this->add();
        }
        else {
            $error = new Error(3);
            return $error->getError();
        }
    }


    private function add() {
        if ($this->post['type'] == 'task') {
            $task = new addTask();
            return $task->add();
        }
        elseif ($this->post['type'] == 'tag') {
            $tag = new addTag();
            return $tag->add();
        }
        else {
            $error = new Error(5);
            return $error->getError();
        }
    }
}