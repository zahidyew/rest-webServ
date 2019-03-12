<?php 
   class User {
      // DB stuff
      private $conn;
      private $table = 'user';

      //User properties/ attributes
      #public $id;
      public $name;
      public $email;
      public $password;

      //Constructor with DB
      public function __construct($db)
      {
         $this->conn = $db;
      }

      // For login functionality.
      public function login()
      {
         //Create query
         $query = 'SELECT name, password FROM ' . $this->table .
            ' WHERE name = :name';

         // Prepare statement
         $stmt = $this->conn->prepare($query);

         // Bind params
         $stmt->bindParam(':name', $this->name);

         // Execute statement
         $stmt->execute();

         $num = $stmt->rowCount();

         // if username exists in database, then fetch the password to verify.
         if($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC); // return associative array.
            // verify the input password, whether it matched the hashed password in db or not
            if (password_verify($this->password, $row['password'])) {
               return true;
            }
            else { // Wrong Password
               return 9;
            }      
         } 
         else { // User does not exists
            return 19;
         }
      }


      // For sign up functionality
      function signUp() {
         // create query
         $query = 'INSERT INTO ' . $this->table . 
         ' SET 
            name = :name, 
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
         $stmt->bindParam(':name', $this->name);
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
   }