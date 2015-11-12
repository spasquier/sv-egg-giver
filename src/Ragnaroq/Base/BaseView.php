<?php
namespace Ragnaroq\Base;

use Ragnaroq\App\Runner;

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
    /** @var  string */
    private $template;

    /**
     * BaseView constructor.
     *
     * @param $controller BaseController Controller that will handle the model
     * @param $model BaseModel Model that will be rendered by this view
     */
    public function __construct(BaseController $controller, BaseModel $model)
    {
        $this->controller = $controller;
        $this->model = $model;
        $this->defineTemplate();
    }

    /**
     * Sets the template to be used in the view.
     *
     * @param $templateName string Name of the template inside the base
     * template directory without the extension, for example: "Folder\File",
     * "Folder/Folder/File" or simply "File"
     */
    public function setTemplate($templateName)
    {
        $this->template = Runner::getTemplateDir() . "/$templateName.php";
    }

    /**
     * Gets the absolute directory of the template to be
     * required for rendering the view of this model.
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * In this method you must assign the name of the template
     * using the method "setTemplate".
     *
     * @return void
     */
    protected abstract function defineTemplate();


    /**
     * Must output the final HTML page with Model data
     * previously processed by the Controller
     *
     * @return void
     */
    abstract function output();
}
