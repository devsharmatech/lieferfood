<?php
class Order {
public $AddInfo; //AddInfo
 public $OrderID; //String
public $ArticleList; //ArticleList
public $StoreData; //StoreData
public $ServerData; //ServerData
public $Customer; //Customer

}
class OrderList {
 public $Order; //array( Order )
 public $CreateDateTime; //Date

}
class EShopOrder {
public $OrderList; //OrderList
}
  $myJSON = '{}';
  // wrap into EShop orderlist
  $EShopOrders = new EShopOrder;
  $EShopOrders->OrderList = new OrderList; 
  $EShopOrders->OrderList->Order = array();
  $EShopOrders->OrderList->CreateDateTime = date( DateTime::RFC3339, time() );
  // get all order files
  $files = scandir("./");
  foreach($files as $value) {
    $ext = pathinfo($value, PATHINFO_EXTENSION); 
	if ($ext == 'json') {
	  // load order and append to orderlist array
	  $Order = json_decode(file_get_contents($value), true);
	  array_push($EShopOrders->OrderList->Order, $Order);
	};
  }
	
  // set content-type to JSON
  header('Content-Type: application/json');
  
  $myJSON = json_encode($EShopOrders, JSON_PRETTY_PRINT);  
  echo $myJSON;
?>