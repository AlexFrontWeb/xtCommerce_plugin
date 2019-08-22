<?php

//Создает XML-строку и XML-документ при помощи DOM
$dom = new DomDocument('1.0');

//добавление корня - <books>
$books = $dom->appendChild($dom->createElement('books'));

//добавление элемента <book> в <books>
$book = $books->appendChild($dom->createElement('book'));

// добавление элемента <title> в <book>
$title = $book->appendChild($dom->createElement('title'));

// добавление элемента текстового узла <title> в <title>
$title->appendChild($dom->createTextNode('Great American Novel'));

//генерация xml
$dom->formatOutput = true; // установка атрибута formatOutput
// domDocument в значение true
// save XML as string or file
$test1 = $dom->saveXML(); // передача строки в test1
$dom->save('book1.xml'); // сохранение файла

?>
