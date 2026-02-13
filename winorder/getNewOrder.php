<?php
header("Content-Type: application/json");
error_reporting(0);
ini_set('display_errors', 0);

/**
 * Log Request & Response
 */
function logRequest($headers, $body = null, $response = null) {
    $logFile = __DIR__ . "/request_log.txt";
    $date = date("Y-m-d H:i:s");

    $logData  = "============================\n";
    $logData .= "Date: $date\n";
    $logData .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN') . "\n";
    $logData .= "Method: " . ($_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN') . "\n";
    $logData .= "Headers: " . json_encode($headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

    if ($body) {
        $logData .= "Body: " . json_encode($body, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    }
    if ($response) {
        $logData .= "Response: " . $response . "\n";
    }

    $logData .= "============================\n\n";
    file_put_contents($logFile, $logData, FILE_APPEND);
}

class OrderService {
    private $pdo;

    public function __construct($host, $db, $user, $pass) {
        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$db;charset=utf8mb4", 
                $user, $pass, 
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            $this->pdo = null; // mark DB as unavailable
        }
    }

    private function validateApiKey($username, $password) {
        if (!$this->pdo) return null;
        $stmt = $this->pdo->prepare("SELECT * FROM winorder_apis WHERE code = :username AND secret_key = :password");
        $stmt->execute([':username' => $username, ':password' => $password]);
        return $stmt->fetch();
    }

    private function getVendorDetails($vendorId) {
        if (!$this->pdo) return null;
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :vendor_id");
        $stmt->execute([':vendor_id' => $vendorId]);
        return $stmt->fetch();
    }

    private function getOrders($vendorId) {
        if (!$this->pdo) return [];
        $stmt = $this->pdo->prepare("
            SELECT * FROM orders 
            WHERE order_status = 'pending' AND payment_status != 0 
            AND vendor_id = :vendor_id AND DATE(created_at) = CURDATE() 
            ORDER BY created_at DESC
        ");
        $stmt->execute([':vendor_id' => $vendorId]);
        return $stmt->fetchAll();
    }

    private function getOrderItems($orderId) {
        if (!$this->pdo) return [];
        $stmt = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll();
    }

    private function getOrderedFood($foodId) {
        if (!$this->pdo) return [];
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
                    "Comment" => $extra['info'] ?? null,
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
                "Comment" => null,
            ];
        }
        return $articleList;
    }

    private function formatDeliveryAddress($order) {
        $deliveryAddress = json_decode($order['address'], true) ?? [];
        $food_receiver = json_decode($order['food_receiver'], true) ?? [];
        return [
            "LastName" => $food_receiver['last_name'] ?? null,
            "AddAddress" => $deliveryAddress['additional_address'] ?? null,
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
        if (!$this->pdo) return ['error' => 'DB connection failed.'];

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
        $orderStatus = $statusMapping[$trackingStatus];

        $stmt = $this->pdo->prepare("UPDATE orders SET order_status = :status WHERE uid = :order_id");
        $stmt->execute([':status' => $orderStatus, ':order_id' => $orderId]);

        if ($stmt->rowCount() > 0) {
            return ['message' => 'Order status updated successfully.', 'order_id' => $orderId, 'new_status' => $orderStatus];
        }
        return ['error' => 'Order not found or no changes made.'];
    }

    public function formatId($id) {
        $length = strlen((string)$id);
        $totalLength = $length + 1;
        return 'L' . str_pad($id, $totalLength - 1, '0', STR_PAD_LEFT);
    }

    private function formatOrderTime($timeString) {
        if (empty($timeString)) return null;
        return preg_match('/^(2[0-3]|[01]?[0-9]):([0-5][0-9])$/', $timeString) ? $timeString : null;
    }

    public function getOrdersResponse($username, $password) {
        if (!$this->pdo || !$username || !$password) {
            return json_encode([
                "OrderList" => [
                    "Order" => [null],
                    "CreateDateTime" => date(DATE_RFC3339)
                ]
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $apiData = $this->validateApiKey($username, $password);
        if (!$apiData || $apiData['status'] == 0) {
            return json_encode([
                "OrderList" => [
                    "Order" => [null],
                    "CreateDateTime" => date(DATE_RFC3339)
                ]
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $vendor = $this->getVendorDetails($apiData['vendor_id']);
        if (!$vendor) {
            return json_encode([
                "OrderList" => [
                    "Order" => [null],
                    "CreateDateTime" => date(DATE_RFC3339)
                ]
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $orders = $this->getOrders($apiData['vendor_id']);
        $responses = [];

        foreach ($orders as $order) {
            $orderItems = $this->getOrderItems($order['id']);
            $articleList = $this->formatArticleList($orderItems);
            $deliveryAddress = $this->formatDeliveryAddress($order);
            $totalAm = $order['total_amount'] + $order['discount'];
            $paymentMethod = ($order['payment_method'] ?? null) !== "card_payment" ? $order['payment_method'] : 'EC-Karte';

            $responses[] = [
                "AddInfo" => [
                    "PaymentType" => $paymentMethod ?? null,
                    "DiscountPercent" => isset($order['discount']) && $order['total_amount'] > 0
                        ? (float)number_format(($order['discount'] / $totalAm) * 100, 2)
                        : 0,
                    "DeliverLumpSum" => (float)($order['delivery_price'] ?? 0),
                    "Total" => (float)($order['total_amount'] ?? 0),
                    "DateTimeOrder" => $this->formatOrderTime($order['custome_time'] ?? null),
                    "Comment" => "Deine Bestellnummer : " . $this->formatId($order['id']),
                    "CurrencyStr" => "\u20ac",
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

        return json_encode([
            "OrderList" => [
                "Order" => $responses,
                "CreateDateTime" => date(DATE_RFC3339)
            ]
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function handleRequest($method, $username , $password, $requestData){
        if ($method === 'POST' && isset($requestData['ordersid'], $requestData['trackingstatus'])) {
            return json_encode($this->updateOrderStatus($requestData['ordersid'], (int)$requestData['trackingstatus']));
        }  

        if ($method === 'GET') {
            return $this->getOrdersResponse($username, $password);
        }

        // PUT or any other method returns empty order
        return json_encode([
            "OrderList" => [
                "Order" => [null],
                "CreateDateTime" => date(DATE_RFC3339)
            ]
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

// Main Execution
try {
    $orderService = new OrderService('localhost', 'u511436824_lieferfood', 'u511436824_lieferfood', 'Lieferfood@123!@');
    $method = $_SERVER['REQUEST_METHOD'];

    // Collect headers
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
    } else {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
    }

    // Auth
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
    if ($authHeader) {
        list($type, $credentials) = explode(' ', $authHeader, 2);
        if (strcasecmp($type, 'Basic') === 0) {
            list($username, $password) = explode(':', base64_decode($credentials), 2);
        }
    }

    $username = $username ?? ($_SERVER['HTTP_APP_KEY'] ?? null);
    $password = $password ?? ($_SERVER['HTTP_KEY_SECRET'] ?? null);

    $input = json_decode(file_get_contents('php://input'), true);

    // Handle request & capture response
    $response = $orderService->handleRequest($method, $username, $password, $input);

    // Log request + response
    logRequest($headers, $input, $response);

    // Send response
    header('Content-Length: ' . strlen($response));
    echo $response;
    exit;

} catch (Exception $e) {
    $fallback = json_encode([
        "OrderList" => [
            "Order" => [null],
            "CreateDateTime" => date(DATE_RFC3339)
        ]
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    logRequest([], [], $fallback);
    header('Content-Length: ' . strlen($fallback));
    echo $fallback;
    exit;
}
