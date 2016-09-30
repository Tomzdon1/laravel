<?php

namespace Tue\ParsingTemplate;

class TemplateParserFromObject implements TemplateParserInterface {

    public static function parse($template, $sourceObject) {
        return preg_replace_callback(
            '|\[[^]]+\]|',
            function ($matches) use ($sourceObject) {
                $replacementString = '';
                $property = str_replace('.', '->', substr($matches[0], 1, -1));
                
                try {
                    $replacementString = $sourceObject->{$property};
                    
                    if (!isset($replacementString)) {
                        throw new \Exception();
                    }
                } catch (\Exception $e) {
                    $replacementString = $matches[0];
                }
                
                return $replacementString;
            },
            $template
        );
    }
}
