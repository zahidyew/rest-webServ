<?php 
   class User {
      // DB stuff
      private $conn;
      private $table = 'user';

      //User properties/ attributes
      public $id;
      public $username;
      public $email;
      public $password;
      public $quest_id;

      //Constructor with DB
      public function __construct($db) {
         $this->conn = $db;
      }

      // For login functionality.
      public function login() {
         //Create query
         $query = 'SELECT * FROM ' . $this->table .
            ' WHERE username = :name';

         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':name', $this->username);
         $stmt->execute();

         $num = $stmt->rowCount();

         // if username exists in database, then fetch the password to verify.
         if($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC); // return associative array.
            // verify the input password, whether it matched the hashed password in db or not
            if (password_verify($this->password, $row['password'])) {
               $this->id = $row['user_id'];
               $this->username = $row['username'];
               $this->email = $row['email'];

               return true;
            }
            else { // Wrong Password
               return false;
            }      
         } 
         /* else { // User does not exists
            return 19;
         } */
      }

      // For sign up functionality
      function signUp() {
         // create query
         $query = 'INSERT INTO ' . $this->table . 
         ' SET 
            username = :name, 
            email = :email,
            password = :pass';

         // prepare statement
         $stmt = $this->conn->prepare($query);

         /* // clean data
         $this->name = htmlspecialchars(strip_tags(this->name));
         $this->email = htmlspecialchars(strip_tags(this->name));
         $this->password = htmlspecialchars(strip_tags(this->password)); */

         // hash password
         $hashedPass = password_hash($this->password, PASSWORD_DEFAULT);

         // bind params
         $stmt->bindParam(':name', $this->username);
         $stmt->bindParam(':email', $this->email);
         $stmt->bindParam(':pass', $hashedPass);

         if ($stmt->execute()) {
            return true;
         }
         else {
            //printf("Error: %s.\n", $stmt->error);
            return false;
         }
      }

      // used when user clicked the button to join a Quest. Insert the data into user_quest table.
      public function joinQuest() {
         $query1 = 'SELECT * FROM user_quest 
                     WHERE user_id = :userId 
                     AND quest_id = :questId';

         $stmt1 = $this->conn->prepare($query1);
         $stmt1->bindParam(':userId', $this->id);
         $stmt1->bindParam(':questId', $this->quest_id);
         $stmt1->execute();

         if($stmt1->rowCount() > 0) {
            return "Duplicate";
         }
         else {
            $query2 = 'INSERT INTO user_quest 
                        SET user_id = :userId, quest_id = :questId';

            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':userId', $this->id);
            $stmt2->bindParam(':questId', $this->quest_id);

            if ($stmt2->execute()) {
               return true;
            } else {
               return false;
            }
         }
      } 
   }