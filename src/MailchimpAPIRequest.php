<?php

namespace Deeptruth\Mailchimp;

use Exception;
use Deeptruth\Mailchimp\Contracts\MailchimpAPIRequestContract;

/**
 * Mailchimp Package API
 */
abstract class MailchimpAPIRequest implements MailchimpAPIRequestContract
{

    /**
     * API key or token generated in Mailchimp Account
     */
    protected $api_key;

    /**
     * API endpoint URL
     */
    protected $api_endpoint;

    /**
     * API endpoint version
     */
    protected $api_version = '3.0';

    /**
     * Module name
     */
    protected $module_name;

    /**
     * Module request uri
     */
    protected $module_request_uri;

    /**
     * Module ID for the module that has child to be inserted in the URI
     */
    protected $module_id;

    /**
     * Prepare API Request
     *
     * @param String $api_key   
     */
    public function __construct($api_key = "")
    {
        if (empty($this->getModuleName())) {

            throw new \Exception("Please provide modulename", 1);
        }

        if (empty($this->getModuleRequestURI())) {

            throw new \Exception("Please provide module request uri", 1);
        }

        $this->setAPIKey($api_key);
    }

    /**
     * Initialize mailchimp API
     * @return [type] [description]
     */
    public function init($api_key, $module_id = "")
    {
        $this->setAPIKey($api_key);
        $this->setModuleID($module_id);
    }

    /**
     * Prepare API Request before calling the makeRequest
     * 
     * @param String $api_key   
     *
     * @return void
     */
    private function prepareAPIRequest()
    {
        $api_key = $this->getAPIKey();

        $api_key_parts = "";
        if (count($api_key_parts = explode("-", $api_key)) != 2) {
            throw new Exception("Invalid API Key");
        }

        $this->setAPIEndpoint("https://$api_key_parts[1].api.mailchimp.com/" . $this->api_version);
    }

    /**
     * Make Request using curl
     *
     * @param   String $http_verb     HTTP method of curl to perform: (post | get | delete | patch | put)
     * @param   String $url_params    URL parameters such as methods of API, id's etc..
     * @param   String $args          Other arguments on Mailchimp API
     *
     * @return  Array                Body of curl
     */
    protected function makeRequest($http_verb, $url_params, $args = [])
    {
        if (!function_exists('curl_init') || !function_exists('curl_setopt')) {
            throw new Exception("cURL support is required, but can't be found.");
        }

        $this->prepareAPIRequest();

        $url = $this->getAPIEndpoint() . "/$url_params";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/vnd.api+json',
            'Content-Type: application/vnd.api+json',
            'Authorization: apikey ' . $this->getAPIKey()
        ]);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Deeptruth/Mailchimp (github.com/deeptruth/mailchimp-api)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $this->prepareCurlMethodAndParameters($ch, $url, $args, $http_verb);

        $response_body = $this->prepareResponse($ch);

        curl_close($ch);
        return $response_body;
    }

    /**
     * Prepare Curl method and Parameters before curl_exec triggers
     * @param   CURL $ch      Curl instance
     * @param   String $url   URL of Curl
     * @param   Array $args   Data passed to post
     *
     * @return  void
     */
    private function prepareCurlMethodAndParameters(&$ch, $url, $args, $http_verb)
    {
        switch ($http_verb) {
            case 'post':
                curl_setopt($ch, CURLOPT_POST, true);
                $this->addRequestArgs($ch, $args);
                break;
            case 'get':
                $query = http_build_query($args, '', '&');
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
                break;
            case 'delete':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'patch':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                $this->addRequestArgs($ch, $args);
                break;
            case 'put':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                $this->addRequestArgs($ch, $args);
                break;
        }
    }

    /**
     * Set Post fields
     *
     * @param CURL $ch      Curl instance
     * @param Array $data   Data passed to post
     *
     * @return void
     */
    private function addRequestArgs(&$ch, $data)
    {
        $encoded = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
    }

    /**
     * Prepare Response 
     *
     * @param CURL $ch      Curl instance
     *
     * @return Array $body  Response body of CURL
     */
    private function prepareResponse(&$ch)
    {
        $response_content = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        $header = substr($response_content, 0, $header_size);
        $body = substr($response_content, $header_size);

        $body = json_decode($body, true);

        return $body;
    }

    /**
     * Get API Key
     *
     * @return String $api_key
     */
    public function getAPIKey()
    {
        return $this->api_key;
    }

    /**
     * Set API Key
     *
     * @return void
     */
    public function setAPIKey($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * Get API Endpoint
     *
     * @return String $api_key
     */
    public function getAPIEndpoint()
    {
        return $this->api_endpoint;
    }

    /**
     * Set API Endpoint
     *
     * @return void
     */
    public function setAPIEndpoint($api_endpoint)
    {
        $this->api_endpoint = $api_endpoint;
    }

    /**
     * Get module URI. If URI is not available use the module name instead
     *
     * @return String $module_request_uri
     */
    public function getModuleRequestURI()
    {
        if (empty($this->module_request_uri)) {

            $this->module_request_uri = $this->getModuleName();
        }

        return $this->module_request_uri;
    }

    /**
     * Set module URI
     *
     * @param String $module_request_uri       URI of the request
     *
     * @return void
     */
    public function setModuleRequestURI($module_request_uri)
    {
        $this->module_request_uri = $module_request_uri;
    }

    /**
     * Get module name
     *
     * @return String $module_name
     */
    public function getModuleName()
    {
        return $this->module_name;
    }

    /**
     * Set module URI
     *
     * @param String $module_id       module id
     *
     * @return void
     */
    public function setModuleID($module_id)
    {
        $this->module_id = $module_id;
    }

    /**
     * Get module name
     *
     * @return String $module_name
     */
    public function getModuleID()
    {
        return $this->module_id;
    }

    /**
     * Set module name
     *
     * @param String $module_name       Modulename
     *
     * @return void
     */
    public function setModuleName($module_name)
    {
        $this->module_name = $module_name;
    }

    /**
     * Make Module. To implement validation of required keys
     * 
     * @param Array $args   Array of arguments from API documentation of Mailchimp. 
     *
     *
     */
    public function store($args = [])
    {
        return $this->makeRequest('post', $this->getModuleRequestURI(), $args);
    }

    /**
     * Update Module
     *
     * @param Int $id   ID of module
     * @param Array $args   Array of arguments from API documentation of Mailchimp. 
     * 
     *
     */
    public function update($id = null, $args = [])
    {
        $id = isset($id) ? $id : $this->getModuleID();
        return $this->makeRequest('patch', $this->getModuleRequestURI() . "/$id", $args);
    }

    /**
     * Delete Module
     *
     * @param Int $id   ID of module
     *
     *
     */
    public function delete($id = null)
    {
        $id = isset($id) ? $id : $this->getModuleID();
        return $this->makeRequest('delete', $this->getModuleRequestURI() . "/$id", $id);
    }

    /**
     * Get all Module
     *
     * @return Array module
     */
    public function all()
    {
        $module = $this->makeRequest('get', $this->getModuleRequestURI());
        return $module[$this->getModuleName()];
    }

    /**
     * Get Module by ID
     * 
     * @param Int $id   ID of module
     *
     * @return Array module
     */
    public function find($id = null)
    {
        $id = isset($id) ? $id : $this->getModuleID();
        $module = $this->makeRequest('get', $this->getModuleRequestURI() . "/$id");
        return $module;
    }

}
