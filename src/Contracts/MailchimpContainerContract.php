<?php

namespace Deeptruth\Mailchimp\Contracts;

interface MailchimpContainerContract
{

    /**
     * Create if new instance, use the registered instance if existing
     * @param String $abstract     		namespace of the class
     * @param Array $parameters         Parameter method supplied upon calling _call magic method
     * 
     * @return mixed
     */
    public function make($abstract, $parameters);

    /**
     * Build Module class through ReflectionClass
     *
     * @param String $concrete     	concrete class of the module
     * @param Array $api_key            API Key supplied upon calling _call magic method
     *
     * @return Object               
     */
    public function build($concrete, $api_key);
}
