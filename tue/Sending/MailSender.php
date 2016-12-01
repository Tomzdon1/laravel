<?php

namespace Tue\Sending;

use App\apiModels\internal\v2 as internal;

class MailSender extends SenderQueueAbstract {
   
    const TYPE = 'mail-send-request';
    const VERSION = '2.1.0';
    const QUEUE_EXCHANGE = 'email';
    const QUEUE_ROUTING_KEY = '';

    private $mailSendRequest;
    private $attachments = [];
    private $rawAttachments = [];

    function __construct() {
        parent::__construct();

        $this->mailSendRequest = new internal\Model\MailSendRequest();

        $this->setBody($this->mailSendRequest);
    }

    public function send() {
        $this->buildAttachments($this->mailSendRequest);
        parent::send();
    }

    /**
     * Attach a file.
     *
     * @param  string  $file
     * @param  array  $options
     * @return $this
     */
    public function attach($file, array $options = [])
    {
        $this->attachments[] = compact('file', 'options');
        return $this;
    }
    /**
     * Attach in-memory data as an attachment.
     *
     * @param  string  $data
     * @param  string  $name
     * @param  array  $options
     * @return $this
     */
    public function attachData($data, $name, array $options = [])
    {
        $this->rawAttachments[] = compact('data', 'name', 'options');
        return $this;
    }

     /**
     * Add all of the attachments to the mail send request.
     *
     * @param  internal\Model\MailSendRequest $message
     * @return $this
     */
    protected function buildAttachments($message)
    {
        $attachments = $message->getAttachments() ? : [];
        
        foreach ($this->attachments as $attachment) {
            $attachmentInstance = $this->createAttachmentFromPath($attachment['file'], $attachment['options']);
            array_push($attachments, $attachmentInstance);
            
        }

        foreach ($this->rawAttachments as $attachment) {
            $attachmentInstance = $this->createAttachmentFromData($attachment['data'], $attachment['name'], $attachment['options']);
            array_push($attachments, $attachmentInstance);
        }
        
        $message->setAttachments($attachments);
        
        return $this;
    }

    /**
     * Create a Attachment instance.
     *
     * @param  string  $file
     * @param  array   $options
     * @return internal\Model\MailAttachments
     */
    protected function createAttachmentFromPath($file, $options = [])
    {
        return internal\Mappers\MailAttachmentMapper::fromPath($file, $options);
    }

    /**
     * Create Attachment instance from data.
     *
     * @param  string  $data
     * @param  string  $name
     * @param  array   $options
     * @return internal\Model\MailAttachments
     */
    protected function createAttachmentFromData($data, $name, $options)
    {
        return internal\Mappers\MailAttachmentMapper::fromData($data, $name, $options);
    }
}
