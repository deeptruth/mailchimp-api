<?php
namespace Deeptruth\Mailchimp\Traits;

/**
* Campaign Trait CRUD
*/

trait Campaign
{
	/**
	 * Make Campaign. To implement validation of required keys
	 * 
	 * @param Array $args 	Array of arguments from API documentation of Mailchimp. 
	 *
	 *
	 */
	public function makeCampaign($args = [])
	{
		// var_dump($args);exit;
		return $this->makeRequest('post','campaigns',$args);
	}

	/**
	 * Update Campaign
	 *
	 * @param Int $id 	ID of campaign
	 * @param Array $args 	Array of arguments from API documentation of Mailchimp. 
	 * 
	 *
	 */
	public function updateCampaign($id = 0, $args = [])
	{
		return $this->makeRequest('patch',"campaigns/$id",$args);
	}

	/**
	 * Delete Campaign
	 *
	 * @param Int $id 	ID of campaign
	 *
	 *
	 */
	public function deleteCampaign($id = 0)
	{
		return $this->makeRequest('delete',"campaigns/$id",$id);
	}

	/**
	 * Get all Campaign
	 *
	 * @return Array campaigns
	 */
	public function getAllCampaigns()
	{
		$campaigns = $this->makeRequest('get','campaigns');
		return $campaigns['campaigns'];
	}

	/**
	 * Get Campaign by ID
	 * 
	 * @param Int $id 	ID of campaign
	 *
	 * @return Array campaign
	 */
	public function getCampaignPerID($id = 0)
	{
		$campaign = $this->makeRequest('get','/campaigns/'.$id);
		return $campaign;
	}
	
}