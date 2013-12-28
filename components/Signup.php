<?php namespace Plugins\RainLab\MailChimp\Components;

use Modules\Cms\Classes\ComponentBase;

class Signup extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'Signup Form',
            'description' => 'Sign up a new person to a mailing list.'
        ];
    }

    public function defineProperties()
    {
        return [
            'api-key' => [
                'description' => 'Get an API Key from http://admin.mailchimp.com/account/api/',
                'title' => 'MailChimp API Key',
                'type'=>'string'
            ],

            'list-id' => [
                'description' => 'In MailChimp account, select List > Tools and look for a List ID.',
                'title' => 'MailChimp List ID',
                'type' => 'string'
            ]
        ];
    }

    public function onSignup()
    {
        $email = post('email');

        // @todo Use validation class
        if (!$email) throw new \Exception('No Email address provided');
        if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $email))
            throw new \Exception('Email address is invalid');

        require_once(PATH_BASE . '/plugins/rainlab/mailchimp/vendor/MCAPI.class.php');

        $api = new \MCAPI($this->property('api-key'));

        $this->page['error'] = null;

        if ($api->listSubscribe($this->property('list-id'), $email, '') !== true)
            $this->page['error'] = $api->errorMessage;
    }

}