<?php
   class Item {
      // DB stuff
      private $conn;
      private $table = 'item';
      //private $prim_table = 'item';

      // Item's properties 
      public $item_id;
      public $item_name;
      public $place_name;
      public $location;
      public $description;
      public $latitude;
      public $longitude;
      public $image;
      public $quest_id;

      public $user_id;
      public $item_arr = [];

      // Constructor with DB
      public function __construct($db)
      {
         $this->conn = $db;
      }

      // fetch all the items the quest has
      public function getItems() {
         $query = 'SELECT * FROM 
                     ' . $this->table . ' 
                     WHERE quest_id = :questId';

         // Prepare statement
         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':questId', $this->quest_id);
         $stmt->execute();

         return $stmt;
      }

      // fetch all the items a Quest has and showed whether an Item has been scanned by the user.
      public function listItems() {
         $i = 0;
         // get all the itemIDs the user has scanned for a particular Quest
         $query = 'SELECT i.item_id 
                     FROM item i, scanned s 
                     WHERE s.user_id = :userId 
                     AND i.quest_id = :questId 
                     AND i.item_id = s.item_id';

         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':questId', $this->quest_id);
         $stmt->bindParam(':userId', $this->user_id);
         $stmt->execute();

         while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id[$i] = $row['item_id'];
            $i++;
         }

         $query2 = 'SELECT * 
                     FROM ' . $this->table . ' 
                     WHERE quest_id = :questId';
         $flag = "";

         $stmt2 = $this->conn->prepare($query2);
         $stmt2->bindParam(':questId', $this->quest_id);
         $stmt2->execute();

         while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            // extract() saves the value of data under its column name
            extract($row2);

            for($x = 0; $x < $i; $x++) {
               // when matched, exit the for loop
               // $item_id here refers to the one fetch from DB bcuz we use extract().
               if($id[$x] == $item_id) {
                  $flag = "Scanned";
                  break;
               }
               else {
                  $flag = "";
               }
            }
            $items_item = array(
               'item_id' => $item_id,
               'item_name' => $item_name,
               'place_name' => $place_name,
               'location' => $location,
               'description' => $description,
               'latitude' => $latitude,
               'longitude' => $longitude,
               'image' => $image,
               'quest_id' => $quest_id,
               'scanned_status' => $flag
            );
            // Push to "data"
            array_push($this->item_arr, $items_item);
         }
      }
   }

   //SELECT * FROM item i, scanned s WHERE s.user_id = 4 AND i.item_id = s.item_id AND i.quest_id = 2
