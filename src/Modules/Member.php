<?php
namespace Deeptruth\Mailchimp\Modules;

use Deeptruth\Mailchimp\Services\ModulesCrudService;

class Member extends ModulesCrudService
{
	protected $modulename = 'members';

	/**
	 * Set modulename with parent id
	 */
	public function __construct($api_key, $args)
	{
		$this->setModuleName($args);
		parent::__construct($api_key);
	}

	/**
	 * Overwrite set modulename with parent id
	 */
	public function setModuleName($args){
		$parent_id = $args[0];
		$this->modulename = "lists/$parent_id/members";
	}
}