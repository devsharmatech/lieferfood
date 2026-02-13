# PHP-EShop-Server example
WinOrder online-shop interface (EShop) server example for WinOrder POS written in PHP.

You have an online-shop and want to transfer your orders to the WinOrder POS automatically, then you are in the right place!

The interface documentation (german only) [PDF is here](https://www.winorder.com/download/WinOrder-EShop-Spezifikation.pdf).

This is a very simple example for a server-side implementation of the WinOrder EShop interface in PHP.
We don't use a database here, the pending orders are stored as a file on the server.

## TestOrder.php
This PHP script creates a sample order in JSON format. When called (GET), the order is created in JSON format, displayed in the browser and saved as a file in the same directory for later retrieval.
The script shows how to create the syntactically correct JSON format for WinOrder POS from PHP objects.

## GetNewOrders.php
WinOrder POS calls the /GetNewOrders endpoint to retrieve new online orders.
The example script returns all previously created test orders as JSON. For simplicity, all orders are stored as "order_xxx.json" in the same directory.
In real world you probably use a database.

## SendTrackingStatus.php
After WinOrder has successfully received the JSON data it sends a feedback to your server. This script handles the
"successfully received" feedback, mapped in the JSON with "trackingstatus=0".
In the example, the file of the current online order is deleted. 
In the real use case, you would set the status of the order in your database to "successfully received".

## Optional: PreparationTime.php
WinOrder has a slider for current restaurant's preparation time. 
The current preparation time is the time required by the restaurant to take the order until it is ready for delivery.
The restaurant owner can set this time with a slider. WinOrder PUT's the current preparation time back to your server to the endpoint /PreparationTime.
In this example the PUT requests is simply saved to file. "preparation.txt" contains the payload of the PUT request.
This endpoint is optional and not needed for order processing.

### Testing with WinOrder
You can test the retrieval with a local [WinOrder installation](https://www.winorder.com/herunterladen/testversion/):
WinOrder has an integrated WebServer built in, activate it in program settings/Online-Shop/Webserver and set a valid local hostname/IP.
The WWW root is located in the directory "[C:\ProgramData\PixelPlanet\WinOrder7\wwwroot](C:%5CProgramData%5CPixelPlanet%5CWinOrder7%5Cwwwroot)".
Load this repository in the www subdirectory "/PHP-EShop-Server".

### Establish the connection in WinOrder

Activate the local webserver for testing:
![webserver](https://user-images.githubusercontent.com/11274319/180400328-3eb3c351-92e0-44fe-b10c-b55bb4b65ef2.PNG)

Add a new online store in WinOrder, set the transfer type to "WinOrder (REST)" and the web service URL to the local web server:

![ShopSettings](https://user-images.githubusercontent.com/109801232/184105500-ef5d30fd-99c1-474c-8de5-d85aeecd5465.PNG)



Call "http://[your_local_host]/PHP-EShop-Server/TestOrder" in the web browser. The call generates a test order and outputs the sample order in JSON format in the web browser.
The order is saved as an "order_xx.json" file in the same directory. The script "TestOrder.php" shows how to create an order in JSON format in PHP.

WinOrder calls the URL endpoint /GetNewOrders in the specified interval. The script GetNewOrders.php searches for JSON files and returns them.
WinOrder reads the JSON orders and reports successful receipt back to the /SendTrackingStatus URL endpoint. The SendTrackingStatus.php script evaluates the status
and looks for the corresponding file and deletes it so that the same order is not transmitted multiple times.
Your server will keep the order in a database and set the status to "received/processed".
The example order will received in WinOrder:

![order](https://user-images.githubusercontent.com/11274319/180404464-e10d754a-4fb6-4794-a61a-5cdd0821d4b1.PNG)


For further questions we are at your disposal! Write us an EMail to support@winorder.de, we will help you with the integration!

WinOrder Development Team
https://www.winorder.com
