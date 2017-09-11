<?php
namespace Deeptruth\Mailchimp\Modules;

use Deeptruth\Mailchimp\Services\ModulesCrudService;

class Campaign extends ModulesCrudService
{
	protected $module_name = 'campaigns';

	/**
	 * Send Campaign
	 * 
	 * @param Int $id 	ID of module
	 *
	 * @return Array module
	 */
	public function send($id = 0)
	{
		$module = $this->makeRequest('post',$this->getModuleName()."/$id/actions/send");

		return $module;
	}

	/**
	 * Replicate Campaign
	 * 
	 * @param Int $id 	ID of module
	 *
	 * @return Array module
	 */
	public function replicate($id = 0)
	{
		$module = $this->makeRequest('post',$this->getModuleName()."/$id/actions/replicate");

		return $module;
	}
	
}