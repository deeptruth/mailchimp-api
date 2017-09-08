<?php
namespace Deeptruth\Mailchimp\Contracts;

interface ModulesCrudContract{

	/**
	 * Create or Store Data in Module
	 * 
	 * @param Array $args 	Array of arguments from API documentation of Mailchimp. 
	 *
	 *
	 */
	public function store($args = []);

	/**
	 * Update Module
	 *
	 * @param Int $id 	ID of Data
	 * @param Array $args 	Array of arguments from API documentation of Mailchimp. 
	 * 
	 *
	 */
	public function update($id = 0, $args = []);

	/**
	 * Delete Module Data
	 *
	 * @param Int $id 	ID of Data
	 *
	 */
	public function delete($id = 0);

	/**
	 * Get all Module Data
	 *
	 * @return Array
	 */
	public function all();

	/**
	 * Get Campaign by ID
	 * 
	 * @param Int $id 	ID of campaign
	 */
	public function getByID($id = 0);
}