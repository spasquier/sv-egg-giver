<?php
namespace Ragnaroq\App;

class Config
{
    private $settings;
    /** @var Config $instance */
    private static $instance = null;

    /**
     * Config constructor.
     */
    private function __construct()
    {
        $this->settings = Runner::getConfigDir() . "/settings.php";
    }

    /**
     * Gets the value of a configuration.
     *
     * @param $configName string Name of the configuration property
     * @param $defaultValue string Default value of the configuration in case it hasn't been set
     * @return string
     */
    public static function get($configName, $defaultValue = null)
    {
        if (null === Config::$instance) {
            Config::$instance = new Config();
        }
        return isset(Config::$instance->settings[$configName])
            ? Config::$instance->settings[$configName]
            : $defaultValue;
    }
}
