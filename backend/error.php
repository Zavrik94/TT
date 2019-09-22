<?php

namespace backend;

class Error
{
    private $error_id;

    function __construct($id) {
        $this->error_id = $id;
    }

    public function getError() {
        if ($this->error_id == 1)
            return $this->help();
        $result = ["error" => true];
        $result["error_id"] = $this->error_id;
        $result["error_desc"] = $this->getErrorDescriprion();
        return json_encode($result);
    }

    private function getErrorDescriprion() {
        switch ($this->error_id) {
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

    private function help() {
        return "
        Описание работы RestFullAPI</br>
        - поиск по задачам/тегам:</br>
                отправить GET метод \"task|tag\"</br>
                пример: localhost?task, localhost?tag;</br>
                для поиска конекретой задачи/тега добавить GET переменную id</br>
                пример: localhost?task&id=1, localhost?tag&id=1;</br>
            - добавление задачи/тега:</br>
                отправить методом POST JSON.</br>
                структура JSON:</br>
                {</br>
                    \"type\"=\"task|tag\" - тип добавляемых данных</br>
                    \"name\"=\"some name\" - имя добавляемой задачи/тега</br>
                    \"description\"=\"some description\" - описание задачи(только для задач, в тегах игнорируется)</br>
                    \"tags|tasks\"=[] - массив привязок задач-тегов(к задачам привязуем теги по id, к тегам задачи)</br>
                }</br>
            Формат возвращаемых данных JSON.</br>
            структуры JSON:</br>
                при поиске:</br>
                {</br>
                    \"error\":false - флаг указания ошибки</br>
                    \"rows\":int - количество найденых значение</br>
                    \"id\":{} структура найденных задач/тегов, где id их номер в БД</br>
                    \"tasks|tags\" - привязанные теги к задаче или задачи к тегу(при поиске определенной задачи/тега)</br>
                }</br>
                при добавлении:</br>
                {</br>
                    \"error\":false - флаг указания ошибки</br>
                    \"id\":(int) - id добавленное задачи/тега</br>
                }</br>
                при ошибке:</br>
                {</br>
                    \"error\":true;</br>
                    \"error_id\":(int) - id ошибки</br>
                    \"error_desc\":(string) - описание ошибки</br>
                }</br>
                описание ошибок:</br>
                2 : \"GET task error\";</br>
                3 : \"POST task error\";</br>
                4 : \"Wrong type on search task\";</br>
                5 : \"Wrong type on add task\";</br>
                6 : \"Wrong id for search\";</br>
                7 : \"Add error: Wrong task name\";</br>
                8 : \"Add error: Wrong task description\";</br>
                9 : \"Add error: Wrong tag name\";</br>
               ";
    }
}