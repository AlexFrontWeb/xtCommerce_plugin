<?php

include 'example.php';

$xml = new SimpleXMLElement($xmlstr);

echo $xml->book[0]->plot;
echo $xml->book[0]->characters->character[0]->name;

/* Access the <success> nodes of the first book.
 * Output the success indications, too. */
foreach ($xml->book[0]->success as $success) {
  switch ((string) $success['type']) {
    // Get attributes as element indices
    case 'bestseller':
      echo $success, ' months on bestseller list';
      break;
    case 'bookclubs':
      echo $success, ' bookclub listings';
      break;
  }
}
/* change element*/
$xml->book[0]->characters->character[0]->name = 'Big Cliff';
// add child
$character = $xml->book[0]->characters->addChild('character');
$character->addChild('name', 'Yellow Cat');
$character->addChild('desc', 'aloof');

$success = $xml->book[0]->addChild('success', '2');
$success->addAttribute('type', 'reprints');

echo $xml->asXML();
?>

