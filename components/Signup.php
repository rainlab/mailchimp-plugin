<?php namespace RainLab\MailChimp\Components;

use Validator;
use ValidationException;
use ApplicationException;
use Cms\Classes\ComponentBase;
use RainLab\MailChimp\Models\Settings;
use DrewM\MailChimp\MailChimp;

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
            ],
            'confirm' => [
                'title'       => 'Double Opt-in',
                'description' => 'Enable confirmation to MailChimp list subscription.',
                'type'        => 'checkbox'
            ],
        ];
    }

    public function onSignup()
    {
        $settings = Settings::instance();
        if (!$settings->api_key) {
            throw new ApplicationException('MailChimp API key is not configured.');
        }

        /*
         * Validate input
         */
        $data = post();

        $rules = [
            'email' => 'required|email|min:2|max:64',
        ];

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        /*
         * Sign up to Mailchimp via the API
         */

        $MailChimp = new MailChimp($settings->api_key);

        $this->page['error'] = null;

        $subscriptionData = [
            'email_address' => post('email'),
            'status'        => $this->property('confirm') ? 'pending' : 'subscribed',
        ];

        if (isset($data['merge']) && is_array($data['merge']) && count($data['merge'])) {
            $subscriptionData['merge_fields'] = $data['merge'];
        }

        $result = $MailChimp->post("lists/".$this->property('list')."/members", $subscriptionData);

        if (!$MailChimp->success()) {
            $this->page['error'] = $MailChimp->getLastError();
        }
    }
}
