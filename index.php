<?php

include_once "env.php";

function __autoload($class)
{
    $parts = str_replace('\\', '/', $class);
    require $parts . '.php';
}

use backend\taskManager;

function answerRequest($get, $post) {
    $taskMan = new taskManager($get, $post);

    return $taskMan->getAnswer();
}

echo answerRequest($_GET, $_POST);
