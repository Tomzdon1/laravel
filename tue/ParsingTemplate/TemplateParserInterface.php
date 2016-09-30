<?php

namespace Tue\ParsingTemplate;

interface TemplateParserInterface {
    public static function parse($template, $data);
}
