<?php

date_default_timezone_set('Asia/Calcutta');

if(isset($_GET['script'])) {
    require 'scripts/' . $_GET['script'] . '/index.php';
} else {
require 'application/mvc.php';
}

?>
