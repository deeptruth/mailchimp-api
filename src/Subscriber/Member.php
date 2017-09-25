<?php
namespace Deeptruth\Mailchimp\Subscriber;

use Deeptruth\Mailchimp\MailchimpAPIRequest;

class Member extends MailchimpAPIRequest
{
	protected $module_name = 'members';
}