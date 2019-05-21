<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Achievement.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Achievement object
$achievement = new Achievement($db);

// Achievement query. call the function
$result = $achievement-> listAchievements();
// get row count
$num = $result->rowCount();

// if Achievement(s) exist
if ($num > 0) {
   $achievement_arr = array();

   while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $achievement_item = array(
         'achievement_id' => $achievement_id,
         'achievement_name' => $achievement_name,
         'quest_id' => $quest_id,
         'level' => $level,
         'requirement' => $requirement,
         'logo' => $logo
      );
      // Push to "data"
      array_push($achievement_arr, $achievement_item);
   }
   // turn to JSON and output them.
   echo json_encode($achievement_arr);
} else {
   // No Quest
   echo json_encode(
      array('message' => 'No Achievement Found')
   );
}
