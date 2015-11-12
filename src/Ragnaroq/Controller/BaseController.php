<?php
namespace Ragnaroq\Controller;

use Ragnaroq\Model\BaseModel;

class BaseController
{
    protected $model;

    public function __construct(BaseModel $model) {
        $this->model = $model;
    }
}