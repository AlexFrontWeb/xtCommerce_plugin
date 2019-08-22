<?php

$doc = new DOMDocument();

// Мы не хотим возиться с пробелами
$doc->preserveWhiteSpace = false;

$doc->Load('book.xml');

$xpath = new DOMXPath($doc);

// Мы начали с корневого элемента
$query = '//book/chapter/para/informaltable/tgroup/tbody/row/entry[. = "en"]';

$entries = $xpath->query($query);

foreach ($entries as $entry) {
  echo "Found {$entry->previousSibling->previousSibling->nodeValue}," .
    " by {$entry->previousSibling->nodeValue}\n";
}
?>
