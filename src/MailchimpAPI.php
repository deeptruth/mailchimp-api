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
     * @param Array $params         Parameter method supplied upon calling
     *
     * @return Object               
     * 
     */
    public function __call($method, $params) {
        $className  = ucfirst($method);
        $module = __DIR__.'/Modules/'.$className.'.php';

        if (file_exists($module)) {
            
            return $this->buildModuleClass($className, $params);
        }

        throw new Exception("Error Processing Request. Module class not found", 1);
        
    }

    /**
     * Build Module class through ReflectionClass
     *
     * @param String $className     ClassName of the module
     * @param Array $params         Parameter method supplied upon calling _call magic method
     *
     * @return Object               
     */
    private function buildModuleClass($className, $params)
    {
        $class = "Deeptruth\\Mailchimp\\Modules\\$className";
        $reflectionClass = new \ReflectionClass($class);

        if(count($params) > 0){
            return $reflectionClass->newInstanceArgs([$this->getAPIKey(), $params]);
        }
        
        return $reflectionClass->newInstanceArgs([$this->getAPIKey()]);
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

