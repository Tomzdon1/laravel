<?php

namespace Tue\Sending;

use App\apiModels\internal\v2 as internal;

abstract class SenderQueueAbstract implements SenderInterface {

    const STATUS_OK = 'OK';
    const STATUS_WARN = 'WARN';
    const STATUS_ERR = 'ERR';

    protected $envelope;

    protected static $_instances = [];

    function __construct()
    {
        $this->envelope = new internal\Model\Envelope();
        $this->envelope->setStatus(self::STATUS_OK);
    }

    public static function getInstance()
    {
        $class = get_called_class();
        if (!isset(static::$_instances[$class])) {
            static::$_instances[$class] = new static();
        }

        return static::$_instances[$class];
    }

    public function __call($name, $arguments)
    {
        try {
            return call_user_func_array(array($this->envelope, $name), $arguments);
        } catch (\InvalidArgumentException $exception) {
            $this->envelope->setStatus(self::STATUS_ERR);
        }
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(array($this->envelope, $name), $arguments);
    }

    public function addError($error)
    {
        if (!is_array($this->getErrors())) {
            $this->setErrors([]);
        }

        $merged = array_merge($this->getErrors(), [$error]);
        $this->setErrors($merged);
    }

    public function send()
    {
        $this->setSendDate(new \DateTime());
        $this->setType(static::TYPE);
        $this->setVersion(static::VERSION);
        $this->setSrcSystem(env('APP_CODE', 'cp'));

        if (!$this->getErrors()) {
            $this->setErrors([]);
        }

        if (!$this->valid()) {
            app('log')->notice('Valid of envelope fail', $this->listInvalidProperties());
            
            $this->setStatus(self::STATUS_ERR);
            foreach ($this->listInvalidProperties() as $invalidProperty) {
                $this->addError(
                    [
                        'code' => 'INVALID_PROPERTY_VALUE',
                        'text' => $invalidProperty
                    ]
                );
            }
        }

        app('Amqp')->publish(static::QUEUE_ROUTING_KEY, (string) $this->envelope, ['exchange' => static::QUEUE_EXCHANGE]);
        
        !env('APP_DEBUG', false) ?: app('log')->debug('Publish ' . static::TYPE . ' in version ' . static::VERSION . ' in RabbitMQ exchange: ' . static::QUEUE_EXCHANGE);
    }
}
