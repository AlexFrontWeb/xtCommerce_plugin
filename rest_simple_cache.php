<?php

//This query does a search for any Web pages relevant to "XML Query"
$query =
  "http://api.search.yahoo.com/WebSearchService/V1/webSearch?" .
  "query=%5C%22XML%20Query%5C%22&appid=YahooDemo";

//The cached material should only last for 2 hours, so you need the
//current time.
$currentTime = microtime(true);

//This is where I put my tempfile; you can store yours in a more
//convenient location.
$cache = 'c:\temp\yws_' . md5($query);

//First check for an existing version of the time, and then check
//to see whether or not it's expired.
if (file_exists($cache) && filemtime($cache) > time() - 7200) {
  //If there's a valid cache file, load its data.
  $data = file_get_contents($cache);
} else {
  //If there's no valid cache file, grab a live version of the
  //data and save it to a temporary file.  Once the file is complete,
  //copy it to a permanent file.  (This prevents concurrency issues.)
  $data = file_get_contents($query);
  $tempName = tempnam('c:\temp', 'YWS');
  file_put_contents($tempName, $data);
  rename($tempName, $cache);
}

//Wherever the data came from, load it into a SimpleXML object.
$xml = simplexml_load_string($data);

//From here, the rest of the file is the same.

// Load up the root element attributes
foreach ($xml->attributes() as $name => $attr) {
  $res[$name] = $attr;
}
//Use one of those "informational" elements to display the total
//number of results for the query.
echo "<p>The query returns " .
  $res["totalResultsAvailable"] .
  " total results  The first 10 are as follows:</p>";

//Unlike with DOM, where we loaded the entire document into the
//result object, with SimpleXML, we get back an object in the
//first place, so we can just use the number of results returned
//to loop through the Result members.

for ($i = 0; $i < $res['totalResultsReturned']; $i++) {
  //The object represents each piece of data as a member variable
  //rather than an array element, so the syntax is a little bit
  //different from the DOM version.

  $thisResult = $xml->Result[$i];

  echo "<a href='" .
    $thisResult->ClickUrl .
    "'><b>" .
    $thisResult->Title .
    "</b></a>:  ";
  echo $thisResult->Summary;

  echo "<br /><br />";
}

?>
