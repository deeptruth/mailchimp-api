<?php
namespace Deeptruth\Mailchimp\Modules;

use Deeptruth\Mailchimp\Services\ModulesCrudService;

class Campaign extends ModulesCrudService
{
	protected $modulename = 'campaigns';

	/**
	 * Send Campaign
	 * 
	 * @param Int $id 	ID of module
	 *
	 * @return Array module
	 */
	public function send($id = 0)
	{
		$module = $this->makeRequest('post',$this->modulename."/$id/actions/send");

		return $module;
	}
	
}