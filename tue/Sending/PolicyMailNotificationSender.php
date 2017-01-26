<?php

namespace Tue\Sending;

use App\Policy;
use App\TravelOffer;
use App\apiModels\internal\v2 as internal;

class PolicyMailNotificationSender extends MailSender {

    public function setPolicy(Policy $policy)
    {
        $this->_srcPolicy = $policy;
        
        return $this;
    }

    protected function attachPolicyDocument()
    {
        $template_name = $this->_srcPolicy->partner->apis->travel->printTemplateSettings->name;
        $printing = app()->make('PdfPrinter');
        $pdf = $printing->getDocumentFromJson($template_name, $this->_srcPolicy);
        
        if ($pdf->IsError()) {
            app('log')->error($pdf->ErrorMsg());
        } else {
            $this->attachData($pdf->File(), $pdf->ContentType());
        }
    }
   
    public function send()
    {
        app('log')->debug(
            "Start sending policy mail notification for policy 
            {$this->_srcPolicy->id} using PolicyMailNotificationSender"
        );

        if (isset($this->_srcPolicy->policy_holder->email) 
            && isset($this->_srcPolicy->product->configuration->mailTemplate) 
            && (($this->_srcPolicy->getSource() == 'import' && $this->_srcPolicy->product->configuration->mailOnImport)
            || ($this->_srcPolicy->getSource() == 'issue' && $this->_srcPolicy->product->configuration->mailOnIssue))
        ) {
            try {
                $this->attachPolicyDocument();
            } catch (\Exception $e) {
                app('log')->error("Can't attach policy document");
                return false;
            }

            try {
                $mailSendRequest = $this->getBody();
                $mailSendRequest->setRecipient($this->_srcPolicy->policy_holder->email);
                $mailSendRequest->setSubject((string) $this->_srcPolicy->product->configuration->mailSubject);
                
                $template = $this->_srcPolicy->product->configuration->mailTemplate;
                $parser = app()->make('TemplateParserFromObject');
                $mailSendRequest->setBody($parser::parse($template, $this->_srcPolicy));

                $companies = TravelOffer::getCompaniesFromElements(
                    $this->_srcPolicy->product
                );
                $this->setCompany($companies);

                $this->setSrcId($this->_srcPolicy->id);
                $this->setSrcType('policy');
            } catch (\InvalidArgumentException $exception) {
                app('log')->notice('Error when setting policy mail notification to send');
                app('log')->notice($exception);
                $this->setStatus(self::STATUS_ERR);
                $this->addError(
                    [
                        'code' => 'SET_POLICY_MAIL_NOTIFICATION',
                        'text' => 'Error when setting policy mail notification to send: '
                                . $exception->getMessage()
                    ]
                );
            }
            parent::send();
        } else {
            app('log')->debug(
                "Policy mail notification for policy {$this->_srcPolicy->id} 
                wasn't send because policy didn't meet the conditions for sending"
            );
        }

        app('log')->debug(
            "End sending policy mail notification for policy 
            {$this->_srcPolicy->id} using PolicyMailNotificationSender"
        );

        return $this;
    }
}
