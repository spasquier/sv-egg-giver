<?php
namespace Ragnaroq\App;

use Ragnaroq\App\Page\HtmlPage;
use Ragnaroq\View\BaseView;

class Runner
{
    /**
     * Gets the absolute directory of the app.
     *
     * @return string
     */
    public static function getAppDir()
    {
        return dirname(dirname(dirname(__DIR__)));
    }

    /**
     * Gets the absolute directory of the configuration for the app.
     *
     * @return string
     */
    public static function getConfigDir()
    {
        return Runner::getAppDir() . "/config";
    }

    /**
     * Gets the absolute directory that contains php-html templates
     *
     * @return string
     */
    public static function getTemplateDir()
    {
        return dirname(__DIR__) . "/Template";
    }

    /**
     * Generates an array with the MVC set and the specific action that will
     * be executed when an user access an specific route of this app.
     *
     * @param $prefix string Prefix of the classes for the MVC pattern
     * @param $action string Name of the Controller method that will be executed
     * @return array
     */
    public static function mvcAction($prefix, $action)
    {
        return array(
            'model' => "Ragnaroq\\Model\\" . ucfirst($prefix) . 'Model',
            'view' => "Ragnaroq\\View\\" . ucfirst($prefix) . 'View',
            'controller' => "Ragnaroq\\Controller\\" . ucfirst($prefix) . 'Controller',
            'action' => $action
        );
    }

    /**
     * Starts the application
     */
    public function start()
    {
        $page = $_GET['page'];
        try {
            if (!empty($page)) {
                $routes = require Runner::getConfigDir() . "/routes.php";
                foreach($routes as $key => $route){
                    if ($page == $key) {
                        $model = $route['model'];
                        $view = $route['view'];
                        $controller = $route['controller'];
                        $action = $route['action'];
                        break;
                    }
                }
                if (isset($model, $view, $controller, $action)) {
                    $routeModel = new $model();
                    $routeController = new $controller($routeModel);
                    /** @var BaseView $routeView */
                    $routeView = new $view($routeController, $routeModel);
                    if (method_exists($routeController, $action)) {
                        $routeController->$action();
                    } else {
                        $page = new HtmlPage();
                        $page->renderError5xx(500, "Bad backend configuration!");
                        return;
                    }
                    $routeView->output();
                } else {
                    $page = new HtmlPage();
                    $page->renderError4xx(404, "Page not found!");
                    return;
                }
            } else {
                $page = new HtmlPage();
                $page->renderError4xx(400, "Bad request!");
                return;
            }
        } catch(\Exception $e) {
            syslog(LOG_ALERT, "[{$e->getCode()}] SVEggGiverApp: Fatal error."
                . "{$e->getMessage()}. Error trace: {$e->getTraceAsString()}");
            $page = new HtmlPage();
            $page->renderError5xx(500, "Server was destroyed!");
            return;
        }
    }
}
