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
     * @return string
     */
    public function getViewTemplate($templateName)
    {
        return Runner::getViewDir() . "/$templateName.php";
    }

    /**
     * Gets the base template
     */
    public function getBaseTemplate()
    {
        return Runner::getTemplateDir() . "Base.php";
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
        $templateFile = $this->getViewTemplate($viewName);
        $_viewContent = $this->renderToString($templateFile, $viewData);
        extract($viewData);
        require $this->getBaseTemplate();
    }

    /**
     * Renders a parsed PHP template to a string
     *
     * @param $file string Absolute file path
     * @param $vars array Variables to be used in the PHP template
     * @return string
     */
    private function renderToString($file, $vars = null)
    {
        if (is_array($vars) && !empty($vars))
            extract($vars);
        ob_start();
        include $file;
        return ob_get_clean();
    }
}
