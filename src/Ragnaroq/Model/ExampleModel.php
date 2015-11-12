<?php
namespace Ragnaroq\Model;

class ExampleModel extends BaseModel
{
    public $name;
    public $lastName;

    public function __construct(){
        parent::__construct("Example/Welcome");
    }
}
