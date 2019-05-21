<?php
   class Place {
      // DB stuff
      private $conn;
      private $table = 'place';
      //private $prim_table = 'place';
      //private $scondry_table = 'quest_place';

      // Place's properties 
      public $place_id;
      public $place_name;
      public $description;
      public $latitude;
      public $longitude;
      public $quest_id;

      // Constructor with DB
      public function __construct($db)
      {
         $this->conn = $db;
      }

      // fetch all the places the quest has
      public function getPlaces() {
         $query = 'SELECT * FROM 
                     ' . $this->table . ' p, 
                     quest_place e
                     WHERE e.quest_id = :questId
                     AND e.place_id = p.place_id';

         // Prepare statement
         $stmt = $this->conn->prepare($query);

         // Bind params
         $stmt->bindParam(':questId', $this->quest_id);

         // Execute statement
         $stmt->execute();

         return $stmt;
      }
   }