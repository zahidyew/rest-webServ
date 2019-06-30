<?php
   // Headers
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: application/json');
   header('Access-Control-Allow-Methods: POST');
   header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

   include_once '../../config/Database.php';
   include_once '../../models/Scanned_Stations.php';

   // Instantiate DB & connect
   $database = new Database();
   $db = $database->connect();

   // Instantiate object
   $scanned_stations = new Scanned_Stations($db);

   // check if the all the POST variables are sent to server
   if (isset($_POST['userId']) && isset($_POST['eventId']) && isset($_POST['stationId']) && isset($_POST['sequence'])) {
      // set the User's attributes to the POST values
      $scanned_stations->user_id = $_POST['userId'];
      $scanned_stations->event_id = $_POST['eventId'];
      $scanned_stations->station_id = $_POST['stationId'];
      $scanned_stations->sequence = $_POST['sequence'];
   } 
   else {
      echo 'error';
      die();
   }

   // call the function
   $scanned_stations->success_scan_st();

   //echo json_encode($scanned_stations->success_scan());
