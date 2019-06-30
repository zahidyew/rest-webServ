<?php
   class Scanned_Stations {
      private $conn;
      private $table = 'scanned_stations';

      public $user_id;
      public $event_id;
      public $station_id;
      public $sequence;

      //Constructor with DB
      public function __construct($db) {
         $this->conn = $db;
      }

      public function success_scan_st() {
         $query = 'SELECT * FROM ' .$this->table. ' 
                     WHERE user_id = :userId  
                     AND event_id = :eventId 
                     AND station_id = :stationId 
                     AND sequence = :sequence';

         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':userId', $this->user_id);
         $stmt->bindParam(':eventId', $this->event_id);
         $stmt->bindParam(':stationId', $this->station_id);
         $stmt->bindParam(':sequence', $this->sequence);
         $stmt->execute();

         $num = $stmt->rowCount();
         // if rowCount > 0, then the scan is a duplicate.
         if($num > 0) {
            echo "true";
         }
         else {
            // if the sequence is 1, then its the first station, thus directly insert into table
            if($this->sequence == 1) {
               $this->insertIntoTable();
            }
            // else if sequence > 1, then need to check if seq - 1 has been scanned or not.
            else {
               //if checkForSequence return true, then insert into table
               if($this->checkForSequence()) {
                  $this->insertIntoTable();
               }
               else {
                  // else it returns false, alert user they need to scan the Station before first.
                  echo "Early";
               }
            }
         }
      }
      
      private function insertIntoTable() {
         $query = 'INSERT INTO ' .$this->table.
                  ' SET user_id = :userId, 
                  event_id = :eventId,
                  station_id = :stationId,
                  sequence = :sequence';

         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':userId', $this->user_id);
         $stmt->bindParam(':eventId', $this->event_id);
         $stmt->bindParam(':stationId', $this->station_id);
         $stmt->bindParam(':sequence', $this->sequence);

         if ($stmt->execute()) {
            echo json_encode("Done");
         } else {
            //printf("Error: %s.\n", $stmt->error);
            echo json_encode("error"); //.$stmt->error);
         }
      }

      private function checkForSequence() {
         $query = 'SELECT id FROM ' . $this->table . ' 
                        WHERE user_id = :userId  
                        AND event_id = :eventId 
                        AND sequence = :minusOne';

         // we want to know if seq - 1 (the Station before this) has been scanned by the User or not
         $minusOne = $this->sequence - 1;

         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':userId', $this->user_id);
         $stmt->bindParam(':eventId', $this->event_id);
         $stmt->bindParam(':minusOne', $minusOne);
         $stmt->execute();

         $num = $stmt->rowCount();
         // if rowCount > 0, then the user has scanned the Station before and are following the sequence
         if ($num > 0) {
            return true;
         } 
         else {
            return false;
         }
      }
   }