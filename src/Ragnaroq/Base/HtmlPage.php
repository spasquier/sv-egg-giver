<?php
namespace Ragnaroq\Base;

use Ragnaroq\App\Runner;

class HtmlPage
{
    public static function renderError4xx($code, $message)
    {
        require Runner::getTemplateDir() . "/Error4xx.php";
    }

    public static function renderError5xx($code, $message)
    {
        require Runner::getTemplateDir() . "/Error5xx.php";
    }
}