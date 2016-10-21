<?php

namespace Tue\Sending;

use App\apiModels\internal\v2 as internal;

abstract class SenderQueueAbstract implements SenderInterface {

    const STATUS_OK = 'OK';
    const STATUS_WARN = 'WARN';
    const STATUS_ERR = 'ERR';

    protected $envelope;

    protected static $_instances = [];

    function __construct() {
        $this->envelope = new internal\Model\Envelope();
        $this->envelope->setStatus(self::STATUS_OK);
    }

    public static function getInstance() {
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

    public function addErrors($errors) {
        $this->setErrors(array_merge($this->getErrors() ?: [], $errors));
    }

    public function send() {
        $this->setSendDate(new \DateTime());
        $this->setType(static::TYPE);
        $this->setVersion(static::VERSION);

        if (!$this->getErrors()) {
            $this->setErrors([]);
        }
        
        if (!$this->valid()) {
            $this->setStatus(self::STATUS_ERR);
            // @todo nie dodawane sa bledy walidacji koperty (i nieco slusznie, bo bledy dotycza body, ale status juz wszystkiego :-( )
        }

        // @todo dodać logowanie do mongo o wysłanej wiadomości

        app('Amqp')->publish(static::QUEUE_ROUTING_KEY, (string) $this->envelope, ['exchange' => static::QUEUE_EXCHANGE]);
        app('log')->debug('Publish ' . static::TYPE . ' in version ' . static::VERSION . ' in RabbitMQ: ' . env('RABBITMQ_ROUTING_KEY_EXPORT_POLICY'));
    }
}
