
<?php


ob_clean();
header_remove();
error_reporting(0);
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");
class OrderService {
    private $pdo;

    public function __construct($host, $db, $user, $pass) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            return json_encode(["OrderList" => ["Order" => [], "CreateDateTime" => date(DATE_RFC3339)]],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }

    private function validateApiKey($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM winorder_apis WHERE code = :username AND secret_key = :password");
        $stmt->execute([':username' => $username, ':password' => $password]);
        return $stmt->fetch();
    }

    private function getVendorDetails($vendorId) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :vendor_id");
        $stmt->execute([':vendor_id' => $vendorId]);
        return $stmt->fetch();
    }

   private function getOrders($vendorId) {
    $stmt = $this->pdo->prepare("SELECT * FROM orders 
     WHERE order_status = 'pending' AND payment_status != 0 AND vendor_id = :vendor_id AND created_at = CURDATE() ORDER BY created_at DESC");
     $stmt->execute([':vendor_id' => $vendorId]);
     return $stmt->fetchAll();
     }

    private function getOrderItems($orderId) {
        $stmt = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll();
    }

    private function getOrderedFood($foodId) {
        $stmt = $this->pdo->prepare("SELECT * FROM food_items WHERE id = :food_id");
        $stmt->execute([':food_id' => $foodId]);
        return $stmt->fetch();
    }

    private function formatArticleList($orderItems) {
        $articleList = [];
        foreach ($orderItems as $item) {
            $extras = json_decode($item['extras'], true) ?? [];
            $subArticles = array_map(function ($extra) {
                return [
                    "Comment" => null,
                    "Price" => (float)($extra['price'] ?? null),
                    "Count" => 1,
                    "ArticleName" => $extra['name'] ?? null,
                ];
            }, $extras);

            $foodData = $this->getOrderedFood($item['food_id']);
            $articleList[] = [
                "Price" => (float)$item['price'],
                "ArticleSize" => $item['variant'] ?? null,
                "ArticleName" => $item['food_item_name'] ?? null,
                "ArticleNo" => $foodData['external_id'] ?? null,
                "SubArticleList" => ["SubArticle" => $subArticles],
                "Count" => $item['quantity'] ?? 1,
                "Comment" => $item['extra_note'] ?? null,
            ];
        }
        return $articleList;
    }

    private function formatDeliveryAddress($order) {
        $deliveryAddress = json_decode($order['address'], true);
        $food_receiver = json_decode($order['food_receiver'], true);
        return [
            "LastName" => $food_receiver['last_name'] ?? null,
            "AddAddress" => $deliveryAddress['additional_address'] ?? null,
            "Floor" => $deliveryAddress['floor'] ?? null,
            "Company" => $deliveryAddress['company_name'] ?? null,
            "Zip" => $deliveryAddress['postal_code'] ?? null,
            "Street" => $deliveryAddress['street'] ?? null,
            "Latitude" => $deliveryAddress['latitude'] ?? null,
            "Country" => $deliveryAddress['country'] ?? null,
            "Longitude" => $deliveryAddress['longitude'] ?? null,
            "HouseNo" => $deliveryAddress['house_number'] ?? null,
            "Title" => $deliveryAddress['title'] ?? null,
            "PhoneNo" => $food_receiver['phone'] ?? null,
            "City" => $deliveryAddress['city'] ?? null,
            "FirstName" => $food_receiver['first_name'] ?? null,
            "EMail" => $food_receiver['email'] ?? null,
        ];
    }
    
    private function updateOrderStatus($orderId, $trackingStatus) {
        // Map trackingstatus (numeric) to order_status (string enum)
        $statusMapping = [
            '0' => 'pending',
            '1' => 'confirmed',
            '2' => 'preparing',
            '5' => 'out_for_delivery',
            '6' => 'delivered',
            '7' => 'cancelled',
         ];

        if (!isset($statusMapping[$trackingStatus])) {
            http_response_code(400);
            return ['error' => 'Invalid tracking status.'];
        }
        $orderId=$orderId;
        $orderStatus = $statusMapping[$trackingStatus];

        // Update the order status
        $stmt = $this->pdo->prepare("UPDATE orders SET order_status = :status WHERE uid = :order_id");
        $stmt->execute([':status' => $orderStatus, ':order_id' => $orderId]);

        if ($stmt->rowCount() > 0) {
            return ['message' => 'Order status updated successfully.', 'order_id' => $orderId, 'new_status' => $orderStatus];
        }

        return ['error' => 'Order not found or no changes made.'];
    }
public function formatId($id) {
    $length = strlen((string) $id);
    $totalLength = $length + 1;
    return 'L' . str_pad($id, $totalLength - 1, '0', STR_PAD_LEFT);
}

public function extractId($formattedId) {
    // return (int) substr($formattedId, 1);
    return (int)$formattedId;
}

private function formatOrderTime($timeString) {
    if (empty($timeString)) {
        return null;
    }
    if (preg_match('/^(2[0-3]|[01]?[0-9]):([0-5][0-9])$/', $timeString)) {
        return $timeString;
    }
    
    return null;
}

    public function getOrdersResponse($username, $password) {
        if (!$username || !$password) {
            return json_encode(["OrderList" => ["Order" => new stdClass(), "CreateDateTime" => date(DATE_RFC3339)]], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $apiData = $this->validateApiKey($username, $password);
        if (!$apiData) {
            return json_encode(["OrderList" => ["Order" => new stdClass(), "CreateDateTime" => date(DATE_RFC3339)]], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        if ($apiData['status'] == 0) {
            return json_encode(["OrderList" => ["Order" => new stdClass(), "CreateDateTime" => date(DATE_RFC3339)]], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $vendor = $this->getVendorDetails($apiData['vendor_id']);
        if (!$vendor) {
            return json_encode(["OrderList" => ["Order" => new stdClass(), "CreateDateTime" => date(DATE_RFC3339)]], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $orders = $this->getOrders($apiData['vendor_id']);
        $responses = [];
        if(isset($orders[0])){
          foreach ($orders as $order) {
            $orderItems = $this->getOrderItems($order['id']);
            $articleList = $this->formatArticleList($orderItems);
            $deliveryAddress = $this->formatDeliveryAddress($order);
            $totalAm=$order['total_amount']+$order['discount'];
            $paymentMethod=(isset($order['payment_method']) && $order['payment_method']!="card_payment") ? $order['payment_method'] : 'EC-Karte';
            $responses[] = [
                "AddInfo" => [
                    "PaymentType" => $paymentMethod ?? null,
                    "DiscountPercent" => isset($order['discount']) && $order['total_amount'] > 0
                        ? (float)number_format(($order['discount'] / $totalAm) * 100, 2)
                        : (float)0,
                    "DeliverLumpSum"=>(float)$order['delivery_price'] ?? null,    
                    "Total" => (float)($order['total_amount']) ?? null,
                    "DateTimeOrder" => $this->formatOrderTime($order['custome_time'] ?? null),
                    "Comment" => "Deine Bestellnummer : ".$this->formatId($order['id'])." \n ".$order['special_instructions'],
                    "CurrencyStr" => "€",
                ],
                "OrderID" => $order['uid'] ?? null,
                "ArticleList" => ["Article" => $articleList],
                "StoreData" => [
                    "StoreId" => $vendor['id'] ?? null,
                    "StoreName" => $vendor['name'] ?? null,
                ],
                "ServerData" => [
                    "Agent" => $_SERVER['HTTP_USER_AGENT'] ?? null,
                    "CreateDateTime" => date(DATE_RFC3339),
                    "Referer" => $_SERVER['HTTP_REFERER'] ?? null,
                    "IpAddress" => $_SERVER['REMOTE_ADDR'] ?? null,
                ],
                "Customer" => [
                    "DeliveryAddress" => $deliveryAddress,
                ],
            ];
        }  
        }

        // Build response dynamically
$response = [
    "OrderList" => [
        "Order" => [],
        "CreateDateTime" => date(DATE_RFC3339),
    ]
];

if (!empty($responses)) {
    $response["OrderList"]["Order"] = $responses;
}

return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    public function handleRequest($method, $username , $password, $requestData){
      if ($method === 'POST' && isset($requestData['ordersid'], $requestData['trackingstatus'])) {
            return json_encode($this->updateOrderStatus($requestData['ordersid'], (int)$requestData['trackingstatus']));
      }  
      if ($method === 'GET') {
           return $this->getOrdersResponse($username, $password);
      }
    }
}

// Usage example
try {
    $orderService = new OrderService('localhost', 'lieferfood', 'lieferfood', 'lieferfood@2026');
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
    if ($authHeader) {
        list($type, $credentials) = explode(' ', $authHeader, 2);
        if (strcasecmp($type, 'Basic') === 0) {
            list($username, $password) = explode(':', base64_decode($credentials), 2);
        }
    }
    
    $username = $username ?? $_SERVER['HTTP_APP_KEY'];
    $password = $password ?? $_SERVER['HTTP_KEY_SECRET'];
    
    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true);
    echo $orderService->handleRequest($method, $username ?? null, $password ?? null, $input);
    
} catch (Exception $e) {
    return json_encode(["OrderList" => ["Order" => [], "CreateDateTime" => date(DATE_RFC3339)]], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

