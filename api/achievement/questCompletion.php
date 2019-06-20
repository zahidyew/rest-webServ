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

   // Instantiate object
   $achievement = new Achievement($db);

   // check for GET variable
   if (isset($_GET['userId'])) {
      $achievement->user_id = $_GET['userId'];
   } else {
      echo "An error occured. No GET variable sent.";
      die();
   }

   // query. call the function
   $achievement->questCompletion();
   //echo json_encode($achievement->achievement_arr);