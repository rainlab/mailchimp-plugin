<?php namespace RainLab\MailChimp;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'MailChimp',
            'description' => 'Provides MailChimp integration services.',
            'author'      => 'Alexey Bobkov, Samuel Georges',
            'icon'        => 'icon-envelope',
            'homepage'    => 'https://github.com/rainlab/mailchimp-plugin'
        ];
    }

    public function registerComponents()
    {
        return [
            'RainLab\MailChimp\Components\Signup' => 'mailSignup'
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
                'order'       => 600
            ]
        ];
    }
}
