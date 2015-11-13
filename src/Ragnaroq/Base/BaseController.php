<?php
namespace Ragnaroq\Base;

use Ragnaroq\App\Auth\Session;
use Ragnaroq\App\Runner;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BaseController
 * @package Ragnaroq\Controller
 */
class BaseController
{
    /** @var BaseModel $model */
    protected $model;
    /** @var Request $request */
    protected $request;
    /** @var  Session */
    protected $session;

    /**
     * BaseController constructor.
     *
     * @param BaseModel $model Model that will be handled by this Controller
     */
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
        $this->request = empty(Runner::$request)
            ? Request::createFromGlobals()
            : Runner::$request;
        $this->session = new Session($this->request);
    }

    /**
     * The micro-framework call this function
     * before every action of the Controller.
     */
    public function beforeAction()
    {

    }

    /**
     * The micro-framework calls this function
     * after every action of the Controller.
     */
    public function afterAction()
    {

    }
}
