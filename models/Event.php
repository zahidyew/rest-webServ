<?php
   class Event {
      // DB stuff
      private $conn;
      private $table = 'event';

      // Event's properties 
      public $id;
      public $name;
      public $date;
      public $organizer;

      // Constructor with DB
      public function __construct($db)
      {
         $this->conn = $db;
      }

      // Fetch all the events.
      public function listEvents() {
         // create query
         $query = 'SELECT * FROM ' . $this->table;

         // prepare statement
         $stmt = $this->conn->prepare($query);

         // execute stmt
         $stmt->execute();

         return $stmt;
      }

      // fetch one event
      public function listSingleEvent() {
         $query = 'SELECT * FROM ' . $this->table .
            ' WHERE id = :id';

         // Prepare statement
         $stmt = $this->conn->prepare($query);

         // Bind params
         $stmt->bindParam(':id', $this->id);

         // Execute statement
         $stmt->execute();
         $num = $stmt->rowCount();

         if ($num > 0) {
            // fetch the single row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->date = $row['date'];
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