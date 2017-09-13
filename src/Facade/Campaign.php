<?php
namespace Deeptruth\Mailchimp\Facade;

use Deeptruth\Mailchimp\Classes\MailchimpFacade;

class Campaign extends MailchimpFacade
{
	/**
	 * 
	 */
	protected static function setModuleNamespace()
	{
		return "Deeptruth\\Mailchimp\\Modules\\Campaign";
	}
	
}