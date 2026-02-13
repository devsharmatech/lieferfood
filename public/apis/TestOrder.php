<?php
class AddInfo {
}
class SubArticle {
 public $Comment; //String
 public $Price; //String
 public $Count; //String

}
class SubArticleList {
 public $SubArticle; //array( SubArticle )

}
class Article {
 public $Price; //String
 public $ArticleSize; //String
 public $ArticleName; //String
 public $ArticleNo; //String
public $SubArticleList; //SubArticleList
 public $Count; //String

}
class ArticleList {
public $Article; //Article

}
class StoreData {
 public $StoreId; //String
 public $StoreName; //String

}
class ServerData {
 public $Agent; //String
 public $CreateDateTime; //Date
 public $Referer; //String
 public $IpAddress; //String

}
class DeliveryAddress {
 public $LastName; //String
 public $AddAddress; //String
 public $Company; //String
 public $Zip; //String
 public $Street; //String
 public $Latitude; //String
 public $Country; //String
 public $Longitude; //String
 public $HouseNo; //String
 public $Title; //String
 public $PhoneNo; //String
 public $City; //String

}
class Customer {
public $DeliveryAddress; //DeliveryAddress

}
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

function CreateNewOrder($OrderID) {
// construct a new order
$myOrder = new Order;
// OrderID should be your unique
$myOrder->OrderID = $OrderID;
// additional info
$myOrder->AddInfo = new AddInfo;
$myOrder->AddInfo->PaymentType = 'Barzahlung';
$myOrder->AddInfo->DiscountPercent = 10;
$myOrder->AddInfo->Total = 9.18;
// server data
$myOrder->ServerData = new ServerData;
$myOrder->ServerData->CreateDateTime = date( DateTime::RFC3339, time() );
$myOrder->ServerData->IpAddress = $_SERVER['REMOTE_ADDR'];
$myOrder->ServerData->Agent = $_SERVER['HTTP_USER_AGENT'];
// store data
$myOrder->StoreData = new StoreData;
$myOrder->StoreData->StoreName = 'My online-shop';
// customer deliver address
$myOrder->Customer = new Customer;
$myOrder->Customer->DeliveryAddress = new DeliveryAddress;
$myOrder->Customer->DeliveryAddress->LastName = 'Doe';
$myOrder->Customer->DeliveryAddress->FirstName = 'John';
$myOrder->Customer->DeliveryAddress->Street = 'Hoyaer Straße';
$myOrder->Customer->DeliveryAddress->HouseNo = '13';
$myOrder->Customer->DeliveryAddress->Zip = '28205';
$myOrder->Customer->DeliveryAddress->City = 'Bremen';
$myOrder->Customer->DeliveryAddress->EMail = 'support@winorder.de';
$myOrder->Customer->DeliveryAddress->PhoneNo = '0421-2477828';

// add new main article with size/variant
$Article = new Article;
$Article->Count = 1;
$Article->ArticleName = 'Pizza Hawaii';
$Article->ArticleSize = 'Mittel (ca. 32cm)';
$Article->ArticleNo = 'P22';
$Article->Price = 7.8;
// first topping
$SubArticle1 = new SubArticle;
$SubArticle1->ArticleName = 'Schinken';
$SubArticle1->Count = 1;
$SubArticle1->Price = 0.9;
// second topping
$SubArticle2 = new SubArticle;
$SubArticle2->ArticleName = 'Putenbruststreifen';
$SubArticle2->Count = 1;
$SubArticle2->Price = 1.5;
// comment to the main article
$SubArticle3 = new SubArticle;
$SubArticle3->Comment = 'hot!';
$SubArticle3->Count = 1;

// comment to the order
$Comment = new Article;
$Comment->Count = 1;
$Comment->Comment = 'Testbestellung: Pronto Pronto!';

// add items to the article list
$Article->SubArticleList = new SubArticleList;
$Article->SubArticleList->SubArticle = array($SubArticle1, $SubArticle2, $SubArticle3);
$myOrder->ArticleList = new ArticleList;
$myOrder->ArticleList->Article = array($Article, $Comment);

  
  // save as JSON  
  $json = json_encode($myOrder, JSON_PRETTY_PRINT);
  file_put_contents("order_".$OrderID.".json", $json);
  return $json;
}

  $OrderID = uniqid();
  $json = CreateNewOrder($OrderID); 
  header('Content-Type: application/json');  
  echo($json);
?>