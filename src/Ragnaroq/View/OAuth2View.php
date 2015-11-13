<?php
namespace Ragnaroq\View;

use Ragnaroq\Base\BaseView;
use Ragnaroq\Model\OAuth2Model;

/**
 * Class OAuth2View
 * @package Ragnaroq\View
 */
class OAuth2View extends BaseView
{
    public function defineTemplate()
    {
        $this->setTemplate("OAuth2/AuthorizeCallback");
    }

    public function output()
    {
        /** @var OAuth2Model $model */
        $model = $this->model;
        require $this->getTemplate();
    }
}
