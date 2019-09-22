<?php

include_once "env.php";

function __autoload($class)
{
    $parts = str_replace('\\', '/', $class);
    require $parts . '.php';
}

use backend\taskManager;

function answerRequest() {
    $taskMan = new taskManager();

    return $taskMan->getAnswer();
}

echo answerRequest();

