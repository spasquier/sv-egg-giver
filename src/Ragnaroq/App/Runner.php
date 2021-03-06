<?php
namespace Ragnaroq\App;

use Ragnaroq\Base\BaseController;
use Ragnaroq\Base\BaseModel;
use Ragnaroq\Base\BaseView;
use Ragnaroq\Base\HtmlPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class Runner
{
    /** @var  Request */
    public static $request;

    /**
     * Runner constructor.
     */
    public function __construct()
    {
        static::$request = Request::createFromGlobals();
        if (!static::$request->hasPreviousSession())
        {
            $session = new Session();
            $session->start();
            static::$request->setSession($session);
        }
    }

    /**
     * Starts the application
     */
    public function start()
    {
        $page = static::$request->get('path', '/');
        $method = static::$request->getMethod();
        try
        {
            if (!empty($page) && !empty($method))
            {
                $routes = require Runner::getConfigDir() . "/routes.php";
                foreach ($routes as $method_key => $route) {
                    if ($method == $method_key) {
                        foreach ($route as $key => $components) {
                            if ($page == $key) {
                                $model = $components['model'];
                                $controller = $components['controller'];
                                $action = $components['action'];
                                break;
                            }
                        }
                    }
                }
                if (isset($model, $controller, $action))
                {
                    /** @var BaseModel $routeModel */
                    $routeModel = new $model();
                    $routeView = new BaseView($routeModel);
                    /** @var BaseController $routeController */
                    $routeController = new $controller($routeModel, $routeView);
                    if (method_exists($routeController, $action))
                    {
                        $routeController->beforeAction();
                        $routeController->$action();
                        $routeController->afterAction();
                    }
                    else
                    {
                        HtmlPage::renderError5xx(500, "Bad backend configuration!");
                    }
                }
                else
                {
                    HtmlPage::renderError4xx(404, "Page not found!");
                }
            }
            else
            {
                HtmlPage::renderError4xx(400, "Bad request!");
            }
        }
        catch(\Exception $e)
        {
            syslog(LOG_ALERT, "[{$e->getCode()}] SVEggGiverApp: Fatal error."
                . "{$e->getMessage()}. Error trace: {$e->getTraceAsString()}");
            HtmlPage::renderError5xx(500, "Server was destroyed!");
        }
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
            'model' => "Ragnaroq\\Model\\" . $prefix . 'Model',
            'controller' => "Ragnaroq\\Controller\\" . $prefix . 'Controller',
            'action' => $action
        );
    }

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

    public static function getViewDir()
    {
        return dirname(__DIR__) . "/View";
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
}
