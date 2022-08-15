<?php

namespace App\Rules;

use App\Carriers\Exception\UnknownXmlFormatException;
use DOMDocument;
use Illuminate\Contracts\Validation\Rule;

class XmlRule implements Rule
{

    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        libxml_use_internal_errors(true);
        $dataXml = new DOMDocument('1.0', 'utf-8');
        $dataXml->loadXML($value);
        $errors = libxml_get_errors();

        return empty($errors);
    }

    /**
     * @return string
     * @throws UnknownXmlFormatException
     */
    public function message(): string
    {
        return throw new UnknownXmlFormatException('Unknown format from XML carrier.');
    }
}
