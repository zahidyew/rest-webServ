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

   // query. call the function
   $event->listEvents();
   echo json_encode($event->event_arr);