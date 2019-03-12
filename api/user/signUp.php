<?php 
   // Headers
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: application/json');
   header('Access-Control-Allow-Methods: POST');
   header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

   include_once '../../config/Database.php';
   include_once '../../models/User.php';

   // Instantiate DB & connect
   $database = new Database();
   $db = $database->connect();

   // Instantiate user object
   $user = new User($db);

   // check if the all the POST variables are sent to server
   if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pass'])) {
      // set the User's attributes to the POST values
      $user->name = $_POST['name'];
      $user->email = $_POST['email'];
      $user->password = $_POST['pass'];
   } 
   else {
      echo 'error';
      die();
   }

   // call the signUp func in the User class and echo out the response back to the App.
   echo json_encode($user->signUp());