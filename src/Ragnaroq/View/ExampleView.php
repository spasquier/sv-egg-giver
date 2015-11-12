<?php
namespace Ragnaroq\View;

class ExampleView extends BaseView
{
    public function output()
    {
        $person_name = "{$this->model->name} {$this->model->lastName}";
        require $this->model->getTemplateDir();
    }
}
