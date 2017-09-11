<?php
namespace Deeptruth\Mailchimp;

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
     * Return a a module class when calling a valid module
     * 
     * @param String $method        Method name which equivalent to lowercased Class
     *
     * @return Object               
     * 
     */
    public function __call($method, $params) {
        $class  = ucfirst($method);
        $module = __DIR__.'/Modules/'.$class.'.php';

        if (file_exists($module)) {
            $class = "Deeptruth\\Mailchimp\\Modules\\$class";

            if(count($params) > 0){
                return new $class($this->getAPIKey(), $params);
            }

            return new $class($this->getAPIKey());
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

