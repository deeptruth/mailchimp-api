<?php

namespace Deeptruth\Mailchimp\Subscriber;

use \Exception;
use Deeptruth\Mailchimp\Subscriber\Member;
use Deeptruth\Mailchimp\MailchimpContainer;
use Deeptruth\Mailchimp\MailchimpAPIRequest;

class Subscriber extends MailchimpAPIRequest
{

    protected $module_name = 'lists';

    /**
     * Member of a list. Build through container and set the module URI
     * @return Member instance
     */
    public function member()
    {

        $container = MailchimpContainer::getInstance() ?: new MailchimpContainer();

        if (!$this->getModuleID()) {

            throw new Exception("Subscriber id not declared");
        }

        $memberClass = $container->make("Deeptruth\\Mailchimp\\Subscriber\\Member", array($this->getAPIKey(), $this->getModuleID()));

        $memberClass->setModuleRequestURI($this->module_name . "/" . $this->getModuleID() . "/members");

        return $memberClass;
    }

}
