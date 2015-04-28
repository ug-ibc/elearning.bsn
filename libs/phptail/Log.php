<?php
/**
 * Require the library
 */
require 'PHPTail.php';
/**
 * Initilize a new instance of PHPTail
 * @var PHPTail
 */
$tail = new PHPTail("/home/ovancop/Data/htdocs/florakb/flora-kalbar.info/logs/Log-18-05-2014.txt");

/**
 * We're getting an AJAX call
 */
if(isset($_GET['ajax']))  {
        echo $tail->getNewLines($_GET['lastsize'], $_GET['grep'], $_GET['invert']);
        die();
}
/**
 * Regular GET/POST call, print out the GUI
 */
$tail->generateGUI();
