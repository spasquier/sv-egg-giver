<?php
namespace Ragnaroq\View;

use Ragnaroq\Controller\BaseController;
use Ragnaroq\Model\BaseModel;

/**
 * Class BaseView
 * @package Ragnaroq\View
 */
abstract class BaseView
{
    /** @var  BaseModel */
    protected $model;
    /** @var  BaseController */
    protected $controller;

    /**
     * BaseView constructor.
     *
     * @param $controller BaseController Controller that will handle the model
     * @param $model BaseModel Model that will be rendered by this view
     */
    public function __construct(BaseController $controller, BaseModel $model) {
        $this->controller = $controller;
        $this->model = $model;
    }

    /**
     * Must output the final HTML page with Model data
     * previously processed by the Controller
     *
     * @return mixed
     */
    abstract function output();
}
