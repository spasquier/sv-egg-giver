<?php
namespace Ragnaroq\View;

use Ragnaroq\Base\BaseView;

/**
 * Here you must simply pass data from your model to your view template,
 * but just if you want, the template can be just static HTML.
 *
 * Class OAuth2View
 * @package Ragnaroq\View
 */
class HomeView extends BaseView
{
    public function defineTemplate()
    {
        $this->setTemplate("Home");
    }

    public function output()
    {
        $response = $this->model->response;
        require $this->getTemplate();
    }
}
