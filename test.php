<?php

require_once('vendor/autoload.php');
// require_once("Censure.class.php");

use Censure\Censure;

var_dump(Censure::is_bad('сука'));
var_dump(Censure::is_bad('fuck'));
var_dump(Censure::fix('Это пиздёж!'));
