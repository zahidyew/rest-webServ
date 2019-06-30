<?php 
   class Station {
      private $conn;
      private $table = 'station';

      public $station_id;
      public $event_id;
      public $user_id;
      public $station_arr = [];

      // Constructor with DB
      public function __construct($db)
      {
         $this->conn = $db;
      }

      public function listStations() {
         $query = 'SELECT DISTINCT s.station_id 
                     FROM ' .$this->table. ' s, 
                     scanned_stations ss
                     WHERE ss.user_id = :userId 
                     AND s.event_id = :eventId 
                     AND s.station_id = ss.station_id';

         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':userId', $this->user_id);
         $stmt->bindParam(':eventId', $this->event_id);
         $stmt->execute();

         $i = 0;
         while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id[$i] = $row['station_id'];
            $i++;
         }

         $flag = "";
         $query2 = 'SELECT * FROM ' . $this->table . ' 
                     WHERE event_id = :eventId';

         $stmt2 = $this->conn->prepare($query2);
         $stmt2->bindParam(':eventId', $this->event_id);
         $stmt2->execute();

         while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            // extract() saves the value of data under its column name
            extract($row2);

            for($x = 0; $x < $i; $x++) {
               // when matched, exit the for loop
               // $station_id here refers to the one fetch from DB bcuz we use extract().
               if($id[$x] == $station_id) {
                  $flag = "Scanned";
                  break;
               }
               else {
                  $flag = "";
               }
            }

            $station_item = array(
               'station_id' => $station_id,
               'station_name' => $station_name,
               'place_name' => $place_name,
               'location' => $location,
               'latitude' => $latitude,
               'longitude' => $longitude,
               'description' => $description,
               'image' => $image,
               'sequence' => $sequence,
               'event_id' => $event_id,
               'scanned_status' => $flag
            );
            array_push($this->station_arr, $station_item);
         }
         return $this->station_arr;
      }
   }


   /* public function listStation() {
         $query = 'SELECT * FROM ' .$this->table. ' 
                     WHERE event_id = :eventId';

         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':eventId', $this->event_id);
         $stmt->execute();      

         $num = $stmt->rowCount();

         if($num > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               extract($row);

               $station_item = array(
                  'station_id' => $station_id,
                  'station_name' => $station_name,
                  'place_name' => $place_name,
                  'location' => $location,
                  'latitude' => $latitude,
                  'longitude' => $longitude,
                  'description' => $description,
                  'image' => $image,
                  'sequence' => $sequence,
                  'event_id' => $event_id
               );

               array_push($this->station_arr, $station_item);
            }
            return $this->station_arr;
         }
         else {
            return false;
         }
      } */
