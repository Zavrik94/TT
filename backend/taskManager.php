<?php

namespace backend;

use backend\get\getAnswer;
use backend\post\postAnswer;


class taskManager
{
//    private $conn;
    private $get;
    private $post;
//    private $json;

    function __construct($get, $post) {
        $this->get = $get;
        $this->post = $post;
        return $this;
    }

    private function parsRequest() {
        if ($this->get != []) {
            $get = new getAnswer($this->get);
            return $get->getAnswer();
        }
        elseif ($this->post != []) {
            $post = new postAnswer($this->post);
            return $post->getAnswer();
        }
        else {
            $error = new Error(1);
            return $error->getError();
        }
    }

    public function getAnswer() {
        return $this->parsRequest();
    }
}