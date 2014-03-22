<?php namespace RainLab\MailChimp;

/**
 * The plugin.php file (called the plugin initialization script) defines the plugin information class.
 */

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'        => 'MailChimp',
            'description' => 'Provides MailChimp integration services.',
            'author'      => 'Alexey Bobkov, Samuel Georges',
            'icon'        => 'icon-envelope'
        ];
    }

    public function registerComponents()
    {
        return [
            '\RainLab\MailChimp\Components\Signup' => 'mailSignup'
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'MailChimp',
                'icon'        => 'icon-envelope',
                'description' => 'Configure MailChimp API access.',
                'class'       => 'RainLab\MailChimp\Models\Settings',
                'order'       => 210
            ]
        ];
    }

}