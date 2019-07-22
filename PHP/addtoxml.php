<?php

$file = '/feed.xml';

$xml = simplexml_load_file($file);
echo($xml);

$thing = $xml->item;
$thing->addChild('test', 'test val');
$xml->asXML($file);

die("done");
