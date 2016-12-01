<?php

namespace App\apiModels\internal\v2\Mappers;

use Illuminate\Support\Facades\Storage;
use App\apiModels\internal\v2\Model\MailAttachment;

class MailAttachmentMapper
{
    public static function fromPath($path, $options = [], MailAttachment $attachment = null)
    {
        if (!$attachment) {
            $attachment = new MailAttachment();
        }

        $data = Storage::get($path);
        $meta = Storage::getMetadata($path);
        $name = basename($meta['path']);
        
        if (!array_key_exists('mime', $options)) {
            $options['mime'] = Storage::getMimetype($path);
        }

        return self::fromData($data, $name, $options, $attachment);
    }

    public static function fromData($data, $name, $options, MailAttachment $attachment = null)
    {
        if (!$attachment) {
            $attachment = new MailAttachment();
        }

        $attachment->setName($name);
        $attachment->setFile(base64_encode($data));
        $attachment->setContentType($options['mime']);

        return $attachment;
    }
}
