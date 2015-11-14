<?php
namespace Ragnaroq\Base;

use Ragnaroq\App\Runner;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BaseView
 * @package Ragnaroq\View
 */
class BaseView
{
    /** @var  BaseModel */
    protected $model;
    /** @var  string */
    private $template;
    /** @var  Request */
    protected $request;

    /**
     * BaseView constructor.
     *
     * @param $model BaseModel Model that will be rendered by this view
     */
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
        $this->request = empty(Runner::$request)
            ? Request::createFromGlobals()
            : Runner::$request;
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
        $this->template = Runner::getViewDir() . "/$templateName.php";
    }


    /**
     * Must output the final HTML page with Model data
     * previously processed by the Controller
     *
     * @return void
     */
    /**
     * Output the view passing the model data
     *
     * @param $viewName string View template name
     * @param $viewData array Array containing variables to be used in the view
     */
    public function render($viewName, $viewData = array())
    {
        $model = $this->model;
        extract($viewData);
        $this->setTemplate($viewName);
        require $this->template;
    }
}
