<?php
namespace Deeptruth\Mailchimp;

use Deeptruth\Mailchimp\Traits\Campaign;
use Deeptruth\Mailchimp\Traits\Subscribers;
use Exception;

/**
* Mailchimp Package API
*/

class MailchimpAPI
{
	
	use Campaign;
	use Subscribers;


	protected $api_key;        // API key or token generated in Mailchimp Account
	protected $api_endpoint;   // API endpoint URL

    /**
     * Prepare API Request
     *
     * @param String $api_key   
     */
    public function __construct($api_key)
    {
        $this->prepareAPIRequest($api_key);
    }

    /**
     * Prepare API Request before calling the makeRequest
     * 
     * @param String $api_key   
     *
     * @return void
     */
    private function prepareAPIRequest($api_key)
    {
        $api_key_parts = "";
        if(count($api_key_parts = explode("-", $api_key)) != 2){
            throw new Exception("Invalid API Key");
        }

        $this->setAPIKey($api_key);
        $this->setAPIEndpoint("https://$api_key_parts[1].api.mailchimp.com/3.0");
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
	private function makeRequest($http_verb, $url_params, $args = [])
    {
        if (!function_exists('curl_init') || !function_exists('curl_setopt')) {
            throw new Exception("cURL support is required, but can't be found.");
        }

        $url = $this->getAPIEndpoint()."/$url_params";
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
    private function prepareCurlMethodAndParameters(&$ch, $url, $args, $http_verb){
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
    private function prepareResponse(&$ch){
        $response_content = curl_exec($ch);
        
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        $header = substr($response_content, 0, $header_size);
        $body = substr($response_content, $header_size);

        $body = json_decode($body,true);
        
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

}
