<?php
   class Quest {
      // DB stuff
      private $conn;
      private $table = 'quest';

      // Quest's properties 
      public $questId;
      public $questName;
      public $location;
      public $eventName;

      // Constructor with DB
      public function __construct($db)
      {
         $this->conn = $db;
      }

      // fetch all the quests the event has
      public function getQuests() {
         $query = 'SELECT * FROM 
                     ' . $this->table . ' q, 
                     event e
                     WHERE e.name = :eventName
                     AND e.name = q.eventName';

         // Prepare statement
         $stmt = $this->conn->prepare($query);

         // Bind params
         $stmt->bindParam(':eventName', $this->eventName);

         // Execute statement
         $stmt->execute();

         return $stmt;
      }
   }