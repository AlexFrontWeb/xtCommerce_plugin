<?php

//This query does a search for any Web pages relevant to "XML Query"
$query =
  "http://api.search.yahoo.com/WebSearchService/V1/webSearch?" .
  "query=%5C%22XML%20Query%5C%22&appid=YahooDemo";

//Create the DOM Document object from the XML returned by the query
$xml = file_get_contents($query);
$dom = new DOMDocument();
$dom = DOMDocument::loadXML($xml);

function xml_to_result($dom)
{
  //This function takes the XML document and maps it to a
  //PHP object so that you can manipulate it later.

  //First, retrieve the root element for the document
  $root = $dom->firstChild;

  //Next, loop through each of its attributes
  foreach ($root->attributes as $attr) {
    $res[$attr->name] = $attr->value;
  }

  //Now, loop through each of the children of the root element
  //and treat each appropriately.

  //Start with the first child node.  (The counter, i, is for
  //tracking results.
  $node = $root->firstChild;
  $i = 0;

  //Now keep looping through as long as there is a node to work
  //with.  (At the bottom of the loop, the code moves to the next
  //sibling, so when it runs out of siblings, the routine stops.
  while ($node) {
    //For each node, check to see whether it's a Result element or
    //one of the informational elements at the start of the document.
    switch ($node->nodeName) {
      //Result elements need more analysis.
      case 'Result':
        //Add each child node of the Result to the result object,
        //again starting with the first child.
        $subnode = $node->firstChild;
        while ($subnode) {
          //Some of these nodes just are just whitespace, which does
          //not have children.
          if ($subnode->hasChildNodes()) {
            //If it does have children, get a NodeList of them, and
            //loop through it.
            $subnodes = $subnode->childNodes;
            foreach ($subnodes as $n) {
              //Again check for children, adding them directly or
              //indirectly as appropriate.
              if ($n->hasChildNodes()) {
                foreach ($n->childNodes as $cn) {
                  $res[$i][$subnode->nodeName][$n->nodeName] = trim(
                    $cn->nodeValue
                  );
                }
              } else {
                $res[$i][$subnode->nodeName] = trim($n->nodeValue);
              }
            }
          }
          //Move on to the next subnode.
          $subnode = $subnode->nextSibling;
        }
        $i++;
        break;
      //Other elements are just added to the result object.
      default:
        $res[$node->nodeName] = trim($node->nodeValue);
        break;
    }

    //Move on to the next Result of informational element
    $node = $node->nextSibling;
  }
  return $res;
}

//First, convert the XML to a DOM object you can manipulate.
$res = xml_to_result($dom);

//Use one of those "informational" elements to display the total
//number of results for the query.
echo "<p>The query returns " .
  $res["totalResultsAvailable"] .
  " total results  The first 10 are as follows:</p>";

//Now loop through each of the actual results.
for ($i = 0; $i < $res['totalResultsReturned']; $i++) {
  echo "<a href='" .
    $res[$i]['ClickUrl'] .
    "'><b>" .
    $res[$i]['Title'] .
    "</b></a>:  ";
  echo $res[$i]['Summary'];

  echo "<br /><br />";
}

?>
