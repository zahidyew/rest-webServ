<?php
   // Headers
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: application/json');
   header('Access-Control-Allow-Methods: GET');
   header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

   include_once '../../config/Database.php';
   include_once '../../models/Station.php';

   // Instantiate DB & connect
   $database = new Database();
   $db = $database->connect();

   // Instantiate object
   $station = new Station($db);

   // check for GET variable
   if (isset($_GET['eventId']) && isset($_GET['userId'])) {
      $station->event_id = $_GET['eventId'];
      $station->user_id = $_GET['userId'];
   } else {
      echo "An error occured. No GET variable sent.";
      die();
   }

   //$station->listStation();
   echo json_encode($station->listStations());

