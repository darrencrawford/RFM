<?php


$string = <<<XML
<a>
 <foo name="one" game="lonely">1</foo>
</a>
XML;


//$xml=simplexml_load_file("result.xml");

$xml = simplexml_load_string($string);
foreach($xml->foo[0]->attributes() as $a => $b) {
    echo $a,'="',$b,"\"\n";
}
?>