<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Place.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate place object
$place = new Place($db);

// check for GET variable
if (isset($_GET['questId']) && !empty($_GET['questId'])) {
   $place->quest_id = $_GET['questId'];
} else {
   echo "An error occured. No GET variable sent.";
   die();
}

$result = $place->getPlaces();

$num = $result->rowCount();

if ($num > 0) {
   $place_arr = array();

   while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $place_item = array(
         'place_id' => $place_id,
         'place_name' => $place_name,
         'description' => $description,
         'latitude' => $latitude,
         'longitude' => $longitude,
         'quest_id' => $quest_id
      );
      // Push to "data"
      array_push($place_arr, $place_item);
   }
   // turn to JSON and output them.
   echo json_encode($place_arr);
} else {
   // No Quest
   echo json_encode(
      array('message' => 'No Place Found')
   );
}
