<?php 
   class Event {
      // DB stuff
      private $conn;
      private $table = 'event';

      public $event_id;
      public $event_arr = [];

      // Constructor with DB
      public function __construct($db) {
         $this->conn = $db;
      }

      public function listEvents() {
         $query = 'SELECT * FROM ' . $this->table;
         
         $stmt = $this->conn->prepare($query);
         $stmt->execute();

         while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $event_item = array(
                  'event_id' => $event_id,
                  'event_name' => $event_name,
                  'start_date' => $start_date,
                  'end_date' => $end_date,
                  'organizer' => $organizer,
                  'category' => $category,
                  'image' => $image
               );
               array_push($this->event_arr, $event_item);
         }
      }

      public function selectedEvent() {
         $query = 'SELECT * FROM ' .$this->table. ' 
                     WHERE event_id = :eventId';

         $stmt = $this->conn->prepare($query);
         $stmt->bindParam('eventId', $this->event_id);
         $stmt->execute();

         $num = $stmt->rowCount();

         if($num >0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            $event_item = array(
               'event_id' => $event_id,
               'event_name' => $event_name,
               'start_date' => $start_date,
               'end_date' => $end_date,
               'organizer' => $organizer,
               'category' => $category,
               'image' => $image
            );

            return $event_item;
         }
         else {
            return false;
         }
      }
   }