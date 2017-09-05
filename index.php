<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require 'vendor/autoload.php';

use Deeptruth\Mailchimp\MailchimpAPI;


$a = new MailchimpAPI("81a905c2bd6d5d25ff4d6caa73e64597-us16");

// Make Campaign
// $a->makeCampaign(
// 		array(
// 			'type' 		=> 'regular',
// 			'recipients' => array(
// 				'list_id' => 'fd8307066d'
// 			),
// 			'settings' => array(
// 				'subject_line' 	=> 'This is a test campaign',
// 				'reply_to'		=> 'aaron.tolentino@nuworks.ph',
// 				'from_name'		=> 'Aaron Tolentino Nuworks'
// 			)
// 		)
// 	);

/*---------------------------------------------------------*/

// Delete Campaign
// $a->deleteCampaign('179d2e7139');

/*---------------------------------------------------------*/

// Get All Campaign
echo "<pre>";
var_dump($a->getAllCampaigns());

/*---------------------------------------------------------*/

// Get Campaign per ID
// echo "<pre>";
// var_dump($a->getCampaignPerID('4eea4ff53d'));

/*---------------------------------------------------------*/

// Update Campaign
// $a->updateCampaign("4eea4ff53d",
// 		array(
// 			'recipients' => array(
// 				'list_id' => 'fd8307066d'
// 			),
// 			'settings' => array(
// 				'subject_line' 	=> 'This is a test campaign update',
// 				'reply_to'		=> 'aaron.tolentino@nuworks.ph',
// 				'from_name'		=> 'Aaron Tolentino Nuworks'
// 			)
// 		)
// 	);


/*---------------------------------------------------------*/
// Make Subsribers
// $a->makeSubscibers("asd");