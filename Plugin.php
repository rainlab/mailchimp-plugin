<?php namespace Plugins\RainLab\MailChimp;

/**
 * The plugin.php file (called the plugin initialization script) defines the plugin information class.
 */

use Modules\System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name' => 'MailChimp',
            'description' => 'Provides MailChimp integration services.',
            'author' => 'Alexey Bobkov, Samuel Georges',
            'icon' => 'icon-envelope'
        ];
    }

    public function registerComponents()
    {
        return [
            '\Plugins\RainLab\MailChimp\Components\Signup' => 'mailSignup'
        ];
    }

}