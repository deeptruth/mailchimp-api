<?php
namespace Deeptruth\Mailchimp\Facade;

use Deeptruth\Mailchimp\Classes\MailchimpFacade;

class Member extends MailchimpFacade
{
	/**
	 * 
	 */
	protected static function setModuleNamespace()
	{
		return "Deeptruth\\Mailchimp\\Modules\\Member";
	}
	
}