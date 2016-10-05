<?php

namespace Tue\Sending;

class SenderFactory {
    public static function getSender($type){
    	switch ($type) {
    		case 'sms':
		        return smsSender::getInstance();
	        case 'policy':
	        	return policySender::getInstance();  
    	}
    }
}
