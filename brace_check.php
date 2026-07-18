<?php
$f = file_get_contents('C:/xampp/htdocs/hifi11-fixed (1)/hifi11/index.php');
$start = strpos($f, '<!-- ====== OPENING OFFER');
$end = strpos($f, '<!-- ====== VALUE COMPARISON TABLE');
echo substr($f, $start, $end - $start) . "\n---END---\n";
