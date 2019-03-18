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

   // check for GET variable
   if(isset($_GET['id']) && !empty($_GET['id'])) {
      $event->id = $_GET['id']; 
   }
   else {
      echo "An error occured. No GET variable sent.";
      die();
   }

   // call the funct to get the event with the passed ID if it exists
   if($event->listSingleEvent()) {
      // create array
      $event_item = array(
         'id' => $event->id,
         'name' => $event->name,
         'date' => $event->date,
         'organizer' => $event->organizer
      );
      print_r(json_encode($event_item));
   }
   else {
      echo 'Event not found.';
   }