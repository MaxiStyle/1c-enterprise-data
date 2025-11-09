<?php

namespace MaxiStyle\EnterpriseData\Builders;

use DOMDocument;
use DOMElement;

class DocumentBuilder
{
    public function append(DOMDocument &$dom, DOMElement &$parent, string $name, ?string $value): void
    {
        if ($value !== null) {
            $parent->appendChild($dom->createElement($name, $value));
        }
    }
}
