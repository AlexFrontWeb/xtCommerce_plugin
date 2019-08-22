<?php

// Create new XSLTProcessor
$xslt = new XSLTProcessor();

//Both the source document and the stylesheet must be
//DOMDocuments, but the result can be a DOMDocument,
//a file, or even a String.

// Load the XSLT stylesheet
$xsl = new DOMDocument();
$xsl->load('recipe.xsl');

// Load the stylesheet into the processor
$xslt->importStylesheet($xsl);

// Load XML input file
$xml = new DOMDocument();
$xml->load('recipe.xml');

//Now choose an output method and transform to it:

// Transform to a string
$results = $xslt->transformToXML($xml);
echo "String version:";
echo htmlentities($results);

// Transform to DOM object
$results = $xslt->transformToDoc($xml);
echo "The root of the DOM Document is ";
echo $results->documentElement->nodeName;

// Transform to a file
$results = $xslt->transformToURI($xml, 'results.txt');

?>
