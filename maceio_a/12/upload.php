<?php
$file = $_FILES['file'];
$contents = file_get_contents($file['tmp_name']);
file_put_contents('./uploads/' . $file['name'], $contents);
header('location: http://10.83.10.136/BR_SPEED_MODULES/12/');
