<?php
namespace Ragnaroq\View;

use Ragnaroq\Base\BaseView;
use Ragnaroq\Model\ExampleModel;

/**
 * In the view you must implement two methods: "defineTemplate" to
 * set the HTML-PHP template that will be rendered and "output" where
 * you define the variables used in your template and require that template.
 *
 * Class ExampleView
 * @package Ragnaroq\View
 */
class ExampleView extends BaseView
{
    public function defineTemplate()
    {
        $this->setTemplate("Example/Welcome");
    }

    public function output()
    {
        /** @var ExampleModel $model */
        $model = $this->model;
        $person_name = "{$model->name} {$model->lastName}";
        require $this->getTemplate();
    }
}
