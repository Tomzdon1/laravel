<?php

namespace Tue\Sending;

class SenderFactory {
    public static function getSender($type){
    	switch ($type) {
    		case 'sms':
		        return SmsSender::getInstance();
	        case 'mail':
		        return MailSender::getInstance();
	        case 'policy':
	        	return PolicySender::getInstance();  
    	}
    }
}
