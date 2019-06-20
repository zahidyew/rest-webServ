<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Item.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate item object
$item = new Item($db);

// check for GET variable
if (isset($_GET['questId']) && !empty($_GET['questId'])) {
   $item->quest_id = $_GET['questId'];
} else {
   echo "An error occured. No GET variable sent.";
   die();
}

$result = $item->getItems();

$num = $result->rowCount();

if ($num > 0) {
   $items_arr = array();

   while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $items_item = array(
         'item_id' => $item_id,
         'item_name' => $item_name,
         'place_name' => $place_name,
         'location' => $location,
         'description' => $description,
         'latitude' => $latitude,
         'longitude' => $longitude,
         'image' => $image,
         'quest_id' => $quest_id
      );
      // Push to "data"
      array_push($items_arr, $items_item);
   }
   // turn to JSON and output them.
   echo json_encode($items_arr);
} else {
   // No Quest
   echo json_encode(
      array('message' => 'No Items Found')
   );
}
