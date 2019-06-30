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

   // Instantiate object
   $event = new Event($db);

   // check for GET variable
   if(isset($_GET['eventId']) && !empty($_GET['eventId'])) {
      $event->event_id = $_GET['eventId']; 
   }
   else {
      echo "An error occured. No GET variable sent.";
      die();
   }

   // call the funct to get the event with the passed ID if it exists
   echo json_encode($event->selectedEvent());