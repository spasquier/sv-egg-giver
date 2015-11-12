<?php
namespace Ragnaroq\Controller;

use Ragnaroq\Base\BaseController;
use Ragnaroq\Model\ExampleModel;

/**
 * In a controller you must define the actions of your web app,
 * in each action you handle the corresponding model for the
 * controller or any other model you need to instantiate.
 *
 * Class ExampleController
 * @package Ragnaroq\Controller
 */
class ExampleController extends BaseController
{
    /**
     * Just set the name and lastname for the ExampleModel
     * that will be showed in the view.
     */
    public function greet() {
        /** @var ExampleModel $model */
        $model = $this->model;
        $model->name = "Salvador";
        $model->lastName = "Pasquier";
    }
}
