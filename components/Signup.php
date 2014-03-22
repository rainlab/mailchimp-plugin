<?php namespace RainLab\MailChimp\Components;

use Validator;
use Cms\Classes\ComponentBase;
use October\Rain\Support\ValidationException;
use RainLab\MailChimp\Models\Settings;
use System\Classes\ApplicationException;

class Signup extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Signup Form',
            'description' => 'Sign up a new person to a mailing list.'
        ];
    }

    public function defineProperties()
    {
        return [
            'list' => [
                'title'       => 'MailChimp List ID',
                'description' => 'In MailChimp account, select List > Tools and look for a List ID.',
                'type'        => 'string'
            ]
        ];
    }

    public function onSignup()
    {
        $settings = Settings::instance();
        if (!$settings->api_key)
            throw new ApplicationException('MailChimp API key is not configured.');

        /*
         * Validate input
         */
        $data = post();

        $rules = [
            'email' => 'required|email|min:2|max:64',
        ];

        $validation = Validator::make($data, $rules);
        if ($validation->fails())
            throw new ValidationException($validation);

        /*
         * Sign up to Mailchimp via the API
         */
        require_once(PATH_BASE . '/plugins/rainlab/mailchimp/vendor/MCAPI.class.php');

        $api = new \MCAPI($settings->api_key);

        $this->page['error'] = null;

        if ($api->listSubscribe($this->property('list'), post('email'), '') !== true)
            $this->page['error'] = $api->errorMessage;
    }

}