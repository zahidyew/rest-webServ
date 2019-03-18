<?php
   // Headers
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: application/json');
   header('Access-Control-Allow-Methods: GET');
   header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

   include_once '../../config/Database.php';
   include_once '../../models/Quest.php';

   // Instantiate DB & connect
   $database = new Database();
   $db = $database->connect();

   // Instantiate quest object
   $quest = new Quest($db);

   // check for GET variable
   if (isset($_GET['eventName']) && !empty($_GET['eventName'])) {
      $quest->eventName = $_GET['eventName'];
   } else {
      echo "An error occured. No GET variable sent.";
      die();
   }

   $result = $quest->getQuests();

   $num = $result->rowCount();

   if ($num > 0) {
      $quest_arr = array();

      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
         extract($row);
         $quest_item = array(
            'id' => $questId,
            'name' => $questName,
            'location' => $latitude . ', ' . $longitude,
            'eventName' => $eventName
         );
         // Push to "data"
         array_push($quest_arr, $quest_item);
      }
      // turn to JSON and output them.
      echo json_encode($quest_arr);
   } else {
      // No Quest
      echo json_encode(
         array('message' => 'No Event Found')
      );
   }

















