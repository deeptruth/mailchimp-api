<?php
namespace Deeptruth\Mailchimp;


use \ReflectionClass;
use Deeptruth\Mailchimp\Contracts\MailchimpContainerContract;
use Deeptruth\Mailchimp\Contracts\MailchimpAPIRequestContract;

/**
* 
*/
class MailchimpContainer implements MailchimpContainerContract
{

	/**
	 * Available instances
	 *
	 * @var array
	 */
	public $instances = [];

    /**
     * Instance
     * @var mixed
     */
    protected static $instance;

	/**
	 * Determine if the container is built. Create if new, use if existing. 
	 * 
	 * @param String $concrete     		concrete class of the module
     * @param Array $parameters         Parameter method supplied upon calling _call magic method
     * 
	 * @return mixed
	 */
	public function make($abstract, $parameters)
	{
        $api_key = isset($parameters[0]) ? $parameters[0] : null;
        $module_id = isset($parameters[1]) ? $parameters[1] : null;
        
		if(isset($this->instances[$abstract])){

            return $this->resolveModuleID($this->instances[$abstract], $module_id);

		}

        return $this->resolveModuleID($this->build($abstract, $api_key), $module_id);
	}

	/**
     * Build Module class through ReflectionClass
     *
     * @param String $concrete     		ClassName of the module
     *
     * @return Object               
     */
    public function build($concrete, $api_key)
    {

        $reflectionClass = new ReflectionClass($concrete);
        return $this->instance($concrete, $reflectionClass->newInstanceArgs([$api_key]));
    }

    /**
     * Check if module id exist then bind the module id on the instance
     *
     * @param Object $concrete      Concrete class
     * @param String $module_id     Module if of the module created
     * 
     * @return Object
     */
    private function resolveModuleID($concrete, $module_id = null)
    {
        if(isset($module_id)){
            $concrete->setModuleID($module_id);
        }
        return  $concrete;
    }

    /**
     * Set the shared instance of the container
     *
     * @param \Nucleus\Core\Container\ContainerContract
     *
     * @return void
     */
    public static function setInstance(MailchimpContainerContract $instance)
    {
        static::$instance = $instance;
    }

    /**
	 * Register the existing instance as a shared in the container
	 *
	 * @param string $abstract
	 * @param mixed $instance
	 *
	 * @return void
	 */
	public function instance($abstract, $instance)
	{
		return $this->instances[$abstract] = $instance;
	}


    /**
     * Get the shared instance of the container
     */
    public static function getInstance()
    {
        return static::$instance;
    }
}