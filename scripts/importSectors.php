<?php

require_once '../vendor/autoload.php';

try {
    global $kernel;
    $htmlFileName = 'index.html';

    if (!file_exists($htmlFileName)) {
        throw new Exception($htmlFileName. ' not present in directory');
    }

    $html = file_get_contents($htmlFileName);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $xpath = new DOMXpath($dom);
    $nodes = $xpath->query("//option");

    $previousNode = null;
    $currentLevel = null;
    $result = array();
    $levelIndetifier = "&nbsp;&nbsp;&nbsp;&nbsp;";
    foreach ($nodes as $key => $node) {
        $levelCounter = substr_count(htmlentities($node->nodeValue), $levelIndetifier);

        // moving levelup from options tree
        if ($levelCounter < $currentLevel) {
            $currentLevel = $levelCounter;
        }
        //moving leveldown from options tr
        else if ($levelCounter > $currentLevel) {
            $currentLevel = $levelCounter;
            $parents[$currentLevel] = $previousNode;
        }

        $result[] = test($node->nodeValue, $parents[$currentLevel], $result);
        $previousNode = $node->nodeValue;

    }
var_dump($result);
} catch (Exception $e) {

    var_dump($e->getMessage());
}

function test($nodeValue, $previousLevelParent, $result)
{
    $levelIndetifier = "&nbsp;&nbsp;&nbsp;&nbsp;";

    $currentLevel = substr_count(htmlentities($nodeValue), $levelIndetifier);

    if ($currentLevel == 0) {
        $parent = null;
    } else {
        $parent = $previousLevelParent;
    }

    $result = array(
        'name' => str_replace("&nbsp;", "", htmlentities($nodeValue)),
        'parent' => str_replace("&nbsp;", "", htmlentities($parent))
    );

    return $result;
}
