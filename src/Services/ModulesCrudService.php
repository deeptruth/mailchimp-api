<?php
namespace Deeptruth\Mailchimp\Services;

use Deeptruth\Mailchimp\Classes\MailchimpAPIRequest;
use Deeptruth\Mailchimp\Contracts\ModulesCrudContract;

class ModulesCrudService extends MailchimpAPIRequest implements ModulesCrudContract
{
	protected $modulename = '';
	/**
	 * Make Campaign. To implement validation of required keys
	 * 
	 * @param Array $args 	Array of arguments from API documentation of Mailchimp. 
	 *
	 *
	 */
	public function store($args = [])
	{
		// var_dump($args);exit;
		return $this->makeRequest('post',$this->modulename,$args);
	}

	/**
	 * Update Campaign
	 *
	 * @param Int $id 	ID of campaign
	 * @param Array $args 	Array of arguments from API documentation of Mailchimp. 
	 * 
	 *
	 */
	public function update($id = 0, $args = [])
	{
		return $this->makeRequest('patch',$this->modulename."/$id",$args);
	}

	/**
	 * Delete Campaign
	 *
	 * @param Int $id 	ID of campaign
	 *
	 *
	 */
	public function delete($id = 0)
	{
		return $this->makeRequest('delete',$this->modulename."/$id",$id);
	}

	/**
	 * Get all Campaign
	 *
	 * @return Array campaigns
	 */
	public function all()
	{
		$campaigns = $this->makeRequest('get',$this->modulename);
		return $campaigns[$this->modulename];
	}

	/**
	 * Get Campaign by ID
	 * 
	 * @param Int $id 	ID of campaign
	 *
	 * @return Array campaign
	 */
	public function getByID($id = 0)
	{
		$campaign = $this->makeRequest('get',$this->modulename."/$id");
		return $campaign;
	}

	/**
	 * Send Campaign
	 * 
	 * @param Int $id 	ID of campaign
	 *
	 * @return Array campaign
	 */
	public function send($id = 0)
	{
		$campaign = $this->makeRequest('post',$this->modulename."/$id/actions/send");

		return $campaign;
	}
	
}