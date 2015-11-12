<?php
namespace Ragnaroq\Controller;

use Ragnaroq\Model\ExampleModel;

class ExampleController extends BaseController
{
    public function greet() {
        /** @var ExampleModel $model */
        $model = $this->model;
        $model->name = "Salvador";
        $model->lastName = "Pasquier";
    }
}
