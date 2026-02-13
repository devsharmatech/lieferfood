<?php
  // Get the JSON contents from POST data
  $json = file_get_contents('php://input');
  
  if (isset($json)) {
    // decode the json data
    $myResponse = json_decode($json);
	if ($myResponse->trackingstatus == "0") {
	  // WinOrder has acknowledged the order, delete order from server and do not serve again
      unlink("order_".$myResponse->ordersid.".json");
	}  
  };
?>