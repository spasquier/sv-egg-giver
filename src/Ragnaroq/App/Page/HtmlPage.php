<?php
namespace Ragnaroq\App\Page;

use Ragnaroq\App\Runner;

class HtmlPage
{
    public function renderError4xx($code, $message)
    {
        require Runner::getTemplateDir() . "/Base/Error4xx.php";
    }

    public function renderError5xx($code, $message)
    {
        require Runner::getTemplateDir() . "/Base/Error5xx.php";
    }
}