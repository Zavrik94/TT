<?php
include_once "taskManager.php";

function answerRequest($get, $post) {
    $taskMan = new taskManager($get, $post);

    return $taskMan->getAnswer();

}

echo answerRequest($_GET, $_POST);
//var_export($res);
