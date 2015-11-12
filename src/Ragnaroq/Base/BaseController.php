<?php
namespace Ragnaroq\Base;

use Ragnaroq\App\Runner;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BaseController
 * @package Ragnaroq\Controller
 */
class BaseController
{
    protected $model;
    private $request;

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
    }

    protected function request()
    {
        return $this->request;
    }
}
