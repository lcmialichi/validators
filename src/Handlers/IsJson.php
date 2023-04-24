<?php


namespace Source\Validators\Handlers;

class IsJson
{

    public function validate($data)
    {
       return json_decode($data) !== null;
    }
}
