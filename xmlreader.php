<?php

$reader = new XMLReader();
$reader->open("tooBig.xml");
while ($reader->read()) {
  switch ($reader->nodeType) {
    case XMLREADER::ELEMENT:
      if ($reader->localName == "entry") {
        if ($reader->getAttribute("ID") == 5225) {
          while ($reader->read()) {
            if ($reader->nodeType == XMLREADER::ELEMENT) {
              if ($reader->localName == "title") {
                $reader->read();
                echo $reader->value;
                break;
              }
              if ($reader->localName == "entry") {
                break;
              }
            }
          }
        }
      }
  }
}
?>
