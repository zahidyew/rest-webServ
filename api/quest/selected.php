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
   if(isset($_GET['id']) && !empty($_GET['id'])) {
      $quest->quest_id = $_GET['id']; 
   }
   else {
      echo "An error occured. No GET variable sent.";
      die();
   }

   // call the funct to get the quest with the passed ID if it exists
   if($quest->listSingleQuest()) {
      // create array
      $quest_item = array(
         'quest_id' => $quest->quest_id,
         'quest_name' => $quest->quest_name,
         'start_date' => $quest->start_date,
         'end_date' => $quest->end_date,
         'organizer' => $quest->organizer
      );
      print_r(json_encode($quest_item));
   }
   else {
      echo 'Quest not found.';
   }