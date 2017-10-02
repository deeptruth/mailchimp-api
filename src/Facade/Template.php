<?php

namespace Deeptruth\Mailchimp\Facade;

use Deeptruth\Mailchimp\Facade\MailchimpFacade as Facade;

/**
 * 
 */
class Template extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'Deeptruth\\Mailchimp\\Template\\Template';
    }

}
