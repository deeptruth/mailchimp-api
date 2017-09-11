<?php
namespace Deeptruth\Mailchimp\Modules;

use Deeptruth\Mailchimp\Services\ModulesCrudService;

class Member extends ModulesCrudService
{
	protected $module_name = 'members';

	/**
	 * Set modulename with parent id
	 */
	public function __construct($api_key, $args)
	{
		$this->setModuleRequestURI($args);
		parent::__construct($api_key);
	}

	/**
	 * Overwrite setModuleRequestURI method with parent id
	 *
	 * @param Array $args 		Parameter of class. This is array for flexibility in other and future modules.
	 *
	 * @return void
	 */
	public function setModuleRequestURI($args){
		$parent_id = $args[0];
		$this->module_request_uri = "lists/$parent_id/members";
	}
}