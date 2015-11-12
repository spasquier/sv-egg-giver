<?php
namespace Ragnaroq\Model;

use Ragnaroq\App\Runner;

/**
 * Class BaseModel
 * @package Ragnaroq\Model
 */
abstract class BaseModel
{
    private $template;

    /**
     * BaseModel constructor.
     *
     * @param $templateName string Name of the template inside the base
     * template directory without the extension, for example: "Folder\File",
     * "Folder/Folder/File" or simply "File"
     */
    public function __construct($templateName) {
        $this->template = Runner::getTemplateDir() . "/$templateName.php";
    }

    /**
     * Gets the absolute directory of the template to be
     * required for rendering the view of this model.
     *
     * @return string
     */
    public function getTemplateDir() {
        return $this->template;
    }
}
