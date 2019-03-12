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

   // Get ID
   //$user->id = isset($_GET['id']) ? $_GET['id'] : die();

   /* if(isset($_GET['name']) && isset($_GET['pass'])) {
      $user->name = $_GET['name'];
      $user->password = $_GET['pass'];
   }
   else {
      die();
   } */ 

   if(isset($_POST['name']) && isset( $_POST['pass'])) {
      $user->name = $_POST['name'];
      $user->password = $_POST['pass'];
   }
   else {
      echo 'error';
      die();
   }

   // Login
   echo json_encode($user->login());
   

   /* // Create array
   $user_arr = array(
      'name' => $user->name,
      'password' => $user->password,
   );

   // Make JSON
   print_r(json_encode($user_arr)); */
