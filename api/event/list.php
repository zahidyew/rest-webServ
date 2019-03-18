<?php
   // Headers
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: application/json');
   header('Access-Control-Allow-Methods: GET');
   header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

   include_once '../../config/Database.php';
   include_once '../../models/Event.php';

   // Instantiate DB & connect
   $database = new Database();
   $db = $database->connect();

   // Instantiate event object
   $event = new Event($db);

   // Event query. call the function
   $result = $event->listEvents();
   // get row count
   $num = $result->rowCount();

   // if event(s) exist
   if ($num > 0) {
      $event_arr = array();

      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
         extract($row);

         $event_item = array(
            'id' => $id,
            'name' => $name,
            'date' => $date,
            'organizer' => $organizer
         );
         // Push to "data"
         array_push($event_arr, $event_item);
      }
      // turn to JSON and output them.
      echo json_encode($event_arr);
   } 
   else {
   // No Event
   echo json_encode(
      array('message' => 'No Event Found')
      );
   }
   
