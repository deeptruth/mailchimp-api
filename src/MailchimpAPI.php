<?php
namespace Deeptruth\Mailchimp;

use Deeptruth\Mailchimp\Modules\Campaign;
use Deeptruth\Mailchimp\Traits\Subscribers;
use Exception;

/**
* Mailchimp Package API
*/

class MailchimpAPI
{
	

	protected $api_key;        // API key or token generated in Mailchimp Account

    /**
     * Prepare API Request
     *
     * @param String $api_key   
     */
    public function __construct($api_key)
    {
        $this->setAPIKey($api_key);
    }

    /**
     * Campaign module
     *
     * @return Campaign Instance
     */
    public function campaign(){

        return new Campaign($this->getAPIKey());
    }

    /**
     * Get API Key
     *
     * @return String $api_key
     */
    public function getAPIKey()
    {
        return $this->api_key;   
    }

    /**
     * Set API Key
     *
     * @return void
     */
    public function setAPIKey($api_key)
    {
        $this->api_key = $api_key;
    }

}

