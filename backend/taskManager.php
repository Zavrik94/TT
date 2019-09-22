<?php

namespace backend;

use backend\get\getAnswer;
use backend\post\postAnswer;


class taskManager
{

    private function parsRequest() {
        if ($_GET != []) {
            $get = new getAnswer();
            return $get->getAnswer();
        }
        elseif ($_POST != []) {
            $post = new postAnswer();
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