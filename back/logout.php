<?php

include 'session.php';

logout();

$returnData['rt_code'] = 1;

$json = json_encode($returnData);

echo $json;