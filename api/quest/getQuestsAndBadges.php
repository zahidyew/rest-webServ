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

   // query. call the function
   $quest->getQuestsAndBadges();
   echo json_encode($quest->quest_arr);