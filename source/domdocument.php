<?php

$doc = new DomDocument;

// We must validate the document before referring to the id
$doc->validateOnParse = true;
$doc->Load('result.xml');

echo "Total Logins is: " . 
$doc->getElementById('Total Logins KinobodyElite')->tagName . "\n";


/*
DOMDocument {
  DOMNodeList getElementsByTagName(string name);
}
*/



?>