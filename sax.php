<?php

//Этот класс содержит все методы обратного вызова,
//которые автоматически управляют данными XML.
class SaxClass
{
  private $hit = false;
  private $titleHit = false;

  //обратный вызов для начала каждого элемента
  function startElement($parser_object, $elementname, $attribute)
  {
    if ($elementname == "entry") {
      if ($attribute['ID'] == 5225) {
        $this->hit = true;
      } else {
        $this->hit = false;
      }
    }
    if ($this->hit && $elementname == "title") {
      $this->titleHit = true;
    } else {
      $this->titleHit = false;
    }
  }

  //обратный вызов для конца каждого элемента
  function endElement($parser_object, $elementname)
  {
  }

  //обратный вызов для содержимого каждого элемента
  function contentHandler($parser_object, $data)
  {
    if ($this->titleHit) {
      echo trim($data) . "<br />";
    }
  }
}

//Функция запуска парсинга, когда все значения установлены
//и файл открыт
function doParse($parser_object)
{
  if (!($fp = fopen("tooBig.xml", "r")));

  //прокрутка данных
  while ($data = fread($fp, 4096)) {
    //анализ фрагмента
    xml_parse($parser_object, $data, feof($fp));
  }
}

$SaxObject = new SaxClass();
$parser_object = xml_parser_create();
xml_set_object($parser_object, $SaxObject);

//Не меняйте регистр данных
xml_parser_set_option($parser_object, XML_OPTION_CASE_FOLDING, false);

xml_set_element_handler($parser_object, "startElement", "endElement");
xml_set_character_data_handler($parser_object, "contentHandler");

doParse($parser_object);

?>
