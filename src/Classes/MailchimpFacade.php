<?php
namespace Deeptruth\Mailchimp\Classes;

/**
* 
*/
abstract class MailchimpFacade
{

	/**
	 * Set the namespace of the module for the init
	 */
	protected static function setModuleNamespace()
	{
		throw new \Exception("Please set module namespace", 1);
	}

	/**
	 * Initialize mailchimp module class through static method
	 * 
	 * @params mixed
	 *
	 * return Object
	 */
    public static function init()
    {
    	$params = func_get_args();
    	$namespace  = static::setModuleNamespace();
    	$reflectionClass = new \ReflectionClass($namespace);
    	
		if(count($params) == 1){
            return $reflectionClass->newInstanceArgs([$params[0]]);
        }else{
        	$api_key = $params[0]; //get the api key from the static init function
        	array_splice($params, 0, 1); //remove api key for the second parameter
        	return $reflectionClass->newInstanceArgs([$api_key, $params]);
        }

        throw new \Exception("Error on getting api key");
    }
}