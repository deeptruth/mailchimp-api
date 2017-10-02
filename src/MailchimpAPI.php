<?php

namespace Deeptruth\Mailchimp;

use Exception;
use Deeptruth\Mailchimp\MailchimpContainer;

/**
 * Mailchimp Package API
 */
class MailchimpAPI extends MailchimpContainer
{

    /**
     * API key or token generated in Mailchimp Account
     * @var String
     */
    protected $api_key;

    /**
     * Prepare API Request
     *
     * @param String $api_key   
     */
    public function __construct($api_key = "")
    {
        $this->setAPIKey($api_key);

        $this->instance("mailchimp", $this);

        self::setInstance($this);
    }

    /**
     * Return a module class when calling a valid module
     * 
     * @param String $method        Method name which equivalent to lowercased Class
     * @param Array $params         Parameter method supplied upon calling
     *
     * @return Object               
     * 
     */
    public function __call($method, $params)
    {

        if (count($params) > 1) {
            throw new Exception("Error Processing Request. Module class not found", 1);
        }

        $className = ucfirst($method);
        $module = __DIR__ . "/$className/$className.php";
        $module_id = isset($params[0]) ? $params[0] : null;
        if (file_exists($module)) {
            $class = "Deeptruth\\Mailchimp\\$className\\$className";
            return $this->make($class, array($this->getAPIKey(), $module_id));
        }

        throw new Exception("Error Processing Request. Module class not found", 1);
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
