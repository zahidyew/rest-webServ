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
      public $place_id;

      //Constructor with DB
      public function __construct($db) {
         $this->conn = $db;
      }

      public function success_scan() {
         // check for duplicate first
         $query = 'SELECT * FROM ' . $this->table . 
                     ' WHERE user_id = :userId 
                     AND quest_id = :questId
                     AND place_id = :placeId';

         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':userId', $this->user_id);
         $stmt->bindParam(':questId', $this->quest_id);
         $stmt->bindParam(':placeId', $this->place_id);

         $stmt->execute();
         $num = $stmt->rowCount();

         // if rowCount > 0 then, the QR code has already been scanned by the User
         if($num > 0) {
            echo json_encode("true");
         }
         // else, save the Scan into the DB, since its not a duplicate.
         else {
            $query2 = 'INSERT INTO ' . $this->table .
               ' SET user_id = :userId, 
               quest_id = :questId,
               place_id = :placeId';

            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':userId', $this->user_id);
            $stmt2->bindParam(':questId', $this->quest_id);
            $stmt2->bindParam(':placeId', $this->place_id);

            if ($stmt2->execute()) {
               //echo json_encode("Done");
               $this->checkForNewAchiv();
            } 
            else {
               //printf("Error: %s.\n", $stmt->error);
               echo json_encode("error"); //.$stmt2->error);
            }
         }
      }

      public function checkForNewAchiv() {
         $query3 = 'SELECT COUNT(quest_id) FROM scanned 
                     WHERE user_id = :userId
                     AND quest_id = :questId';

         $stmt3 = $this->conn->prepare($query3);
         $stmt3->bindParam(':userId', $this->user_id);
         $stmt3->bindParam(':questId', $this->quest_id);
         $stmt3->execute();

         $row = $stmt3->fetch(PDO::FETCH_ASSOC);
         $scansCount = $row['COUNT(quest_id)'];

         $query4 = 'SELECT DISTINCT achievement_name
                     FROM achievement a, scanned s 
                     WHERE a.quest_id = :questId 
                     AND a.requirement = :scansCount';

         $stmt4 = $this->conn->prepare($query4);
         $stmt4->bindParam(':questId', $this->quest_id);
         $stmt4->bindParam(':scansCount', $scansCount);
         $stmt4->execute();

         $num = $stmt4->rowCount();

         if ($num > 0) {
            $row2 = $stmt4->fetch(PDO::FETCH_ASSOC);
            $newAchiv = $row2['achievement_name'];

            echo json_encode($newAchiv);
         } else {
            echo json_encode("done");
         }
      }
   }