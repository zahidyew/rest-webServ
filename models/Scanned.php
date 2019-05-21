<?php 
   class Scanned {
      // DB stuff
      private $conn;
      private $table = 'scanned';

      //User properties/ attributes
      #public $id;
      public $id;
      public $user_id;
      public $quest_id;

      //Constructor with DB
      public function __construct($db) {
         $this->conn = $db;
      }

      // For sign up functionality
      function success_scan() {
         // create query
         $query = 'INSERT INTO ' . $this->table .
         ' SET 
            user_id = :userId,
            quest_id = :questId';

         // prepare statement
         $stmt = $this->conn->prepare($query);

         // bind params
         $stmt->bindParam(':userId', $this->user_id);
         $stmt->bindParam(':questId', $this->quest_id);

         if ($stmt->execute()) {
            return true;
         }
         else {
            //printf("Error: %s.\n", $stmt->error);
            return false;
         }
      }
   }