<?php
namespace Deeptruth\Mailchimp\Facade;

use Deeptruth\Mailchimp\Classes\MailchimpFacade;

class Template extends MailchimpFacade
{
	/**
	 * 
	 */
	protected static function setModuleNamespace()
	{
		return "Deeptruth\\Mailchimp\\Modules\\Template";
	}
	
}