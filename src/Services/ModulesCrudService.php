<?php
namespace Deeptruth\Mailchimp\Services;

use Deeptruth\Mailchimp\Classes\MailchimpAPIRequest;
use Deeptruth\Mailchimp\Contracts\ModulesCrudContract;

class ModulesCrudService extends MailchimpAPIRequest implements ModulesCrudContract
{
	
	/**
	 * Make Module. To implement validation of required keys
	 * 
	 * @param Array $args 	Array of arguments from API documentation of Mailchimp. 
	 *
	 *
	 */
	public function store($args = [])
	{
		return $this->makeRequest('post',$this->getModuleRequestURI(),$args);
	}

	/**
	 * Update Module
	 *
	 * @param Int $id 	ID of module
	 * @param Array $args 	Array of arguments from API documentation of Mailchimp. 
	 * 
	 *
	 */
	public function update($id = 0, $args = [])
	{
		return $this->makeRequest('patch',$this->getModuleRequestURI()."/$id",$args);
	}

	/**
	 * Delete Module
	 *
	 * @param Int $id 	ID of module
	 *
	 *
	 */
	public function delete($id = 0)
	{
		return $this->makeRequest('delete',$this->getModuleRequestURI()."/$id",$id);
	}

	/**
	 * Get all Module
	 *
	 * @return Array module
	 */
	public function all()
	{
		$module = $this->makeRequest('get',$this->getModuleRequestURI());
		return $module[$this->getModuleName()];
	}

	/**
	 * Get Module by ID
	 * 
	 * @param Int $id 	ID of module
	 *
	 * @return Array module
	 */
	public function getByID($id = 0)
	{
		$module = $this->makeRequest('get',$this->getModuleRequestURI()."/$id");
		return $module;
	}


	
}