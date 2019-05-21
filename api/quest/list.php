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

   // Quest query. call the function
   $result = $quest->listQuests();
   // get row count
   $num = $result->rowCount();

   // if quest(s) exist
   if ($num > 0) {
      $quest_arr = array();

      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
         extract($row);

         $quest_item = array(
            'quest_id' => $quest_id,
            'quest_name' => $quest_name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'organizer' => $organizer
         );
         // Push to "data"
         array_push($quest_arr, $quest_item);
      }
      // turn to JSON and output them.
      echo json_encode($quest_arr);
   } 
   else {
   // No Quest
   echo json_encode(
      array('message' => 'No Quest Found')
      );
   }
   
