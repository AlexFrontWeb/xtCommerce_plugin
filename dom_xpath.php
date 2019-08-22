<?php

// Парсинг большого документа посредством XMLReader с Expand - DOM/DOMXpath
$reader = new XMLReader();

$reader->open("tooBig.xml");

while ($reader->read()) {
  switch ($reader->nodeType) {
    case XMLREADER::ELEMENT:
      if ($reader->localName == "entry") {
        if ($reader->getAttribute("ID") == 5225) {
          $node = $reader->expand();
          $dom = new DomDocument();
          $n = $dom->importNode($node, true);
          $dom->appendChild($n);
          $xp = new DomXpath($dom);
          $res = $xp->query("/entry/title");
          echo $res->item(0)->nodeValue;
        }
      }
  }
}

?>
