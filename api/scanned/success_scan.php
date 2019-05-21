<?php
   // Headers
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: application/json');
   header('Access-Control-Allow-Methods: POST');
   header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

   include_once '../../config/Database.php';
   include_once '../../models/Scanned.php';

   // Instantiate DB & connect
   $database = new Database();
   $db = $database->connect();

   // Instantiate user object
   $scanned = new Scanned($db);

   // check if the all the POST variables are sent to server
   if (isset($_POST['userId']) && isset($_POST['questId'])) {
      // set the User's attributes to the POST values
      $scanned->user_id = $_POST['userId'];
      $scanned->quest_id = $_POST['questId'];
   } else {
      echo 'error';
      die();
   }

   // call the signUp func in the User class and echo out the response back to the App.
   echo json_encode($scanned->success_scan());
