<?php
namespace Ragnaroq\App\Page;

use Ragnaroq\App\Runner;

class HtmlPage
{
    public static function renderError4xx($code, $message)
    {
        require Runner::getTemplateDir() . "/Base/Error4xx.php";
    }

    public static function renderError5xx($code, $message)
    {
        require Runner::getTemplateDir() . "/Base/Error5xx.php";
    }
}