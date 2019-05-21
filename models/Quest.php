<?php
   class Quest {
      // DB stuff
      private $conn;
      private $table = 'quest';

      // Quest's properties 
      public $quest_id;
      public $quest_name;
      public $start_date;
      public $end_date;
      public $organizer;

      // Constructor with DB
      public function __construct($db) {
         $this->conn = $db;
      }

      // Fetch all the quests.
      public function listQuests() {
         // create query
         $query = 'SELECT * FROM ' . $this->table;

         // prepare statement
         $stmt = $this->conn->prepare($query);

         // execute stmt
         $stmt->execute();

         return $stmt;
      }

      // fetch one quest
      public function listSingleQuest() {
         $query = 'SELECT * FROM ' . $this->table .
            ' WHERE quest_id = :id';

         // Prepare statement
         $stmt = $this->conn->prepare($query);

         // Bind params
         $stmt->bindParam(':id', $this->quest_id);

         // Execute statement
         $stmt->execute();
         $num = $stmt->rowCount();

         if ($num > 0) {
            // fetch the single row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties
            $this->quest_id = $row['quest_id'];
            $this->quest_name = $row['quest_name'];
            $this->start_date = $row['start_date'];
            $this->end_date = $row['end_date'];
            $this->organizer = $row['organizer'];

            return true;
         }
         else {
            return false;
         }
      }
   }



/* // for getting the event and the quests it contains 
public function EventAndQuests()
{
   $query = 'SELECT * FROM ' . $this->table .
            ' WHERE id = :id';

   $query = 'SELECT * FROM 
                        ' . $this->table . ' e, 
                        quest q
                        WHERE e.id = :id 
                        AND e.name = q.eventName';

   // Prepare statement
   $stmt = $this->conn->prepare($query);

   // Bind params
   $stmt->bindParam(':id', $this->id);

   // Execute statement
   $stmt->execute();

   return $stmt;
} */