<?php

// create document
$dom = new DOMDocument('1.0', 'utf-8');

$element = $dom->createElement('param');
$element->setAttribute('name','value');
$dom->appendChild($element);


// append node


// CDATA
 $ct = $appendToNode->ownerDocument->createCDATASection($text);
$appendToNode->appendChild($ct);

// output xml
echo $dom->saveXML();

