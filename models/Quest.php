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

      public $quest_arr = [];

      // Constructor with DB
      public function __construct($db) {
         $this->conn = $db;
      }

      // Fetch all the quests.
      public function listQuests() {
         $query = 'SELECT * FROM ' . $this->table;
         $stmt = $this->conn->prepare($query);
         $stmt->execute();

         return $stmt;
      }

      // fetch one clicked quest. list all its details
      public function selected() {
         $query = 'SELECT * FROM ' . $this->table .
            ' WHERE quest_id = :id';

         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':id', $this->quest_id);
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

      // get all quests details and the achievements badges. used in homepage
      public function getQuestsAndBadges() {
         $numOfQuests = 0;
         $logo_arr = [];

         $query = 'SELECT DISTINCT quest_id FROM quest
                     ORDER BY quest_id ASC';

         //SELECT DISTINCT q.quest_id FROM quest q, user_quest uq WHERE uq.user_id = 2 AND uq.quest_id = q.quest_id

         $stmt = $this->conn->prepare($query);
         $stmt->execute();

         // saves the questId to an array 
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $questId[$numOfQuests] = $row['quest_id'];
            $numOfQuests++;
         }

         // loop to go through each distinct questId
         for ($i = 0; $i < $numOfQuests; $i++) {
            $query2 = 'SELECT logo 
                        FROM achievement a 
                        WHERE a.quest_id = :id';

            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(':id', $questId[$i]);
            $stmt2->execute();

            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
               $achievement_item = $row2['logo'];
               array_push($logo_arr, $achievement_item);
            }
           
            $query3 = 'SELECT * FROM quest
                        WHERE quest_id = :id';
            
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(':id', $questId[$i]);
            $stmt3->execute();

            while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
               extract($row3);
               $quest_item = array(
                  'quest_id' => $quest_id,
                  'quest_name' => $quest_name,
                  'start_date' => $start_date,
                  'end_date' => $end_date,
                  'organizer' => $organizer,
                  'category' => $category,
                  'image' => $image,
                  'logo' => $logo_arr
               );
               array_push($this->quest_arr, $quest_item);
            }
            // emptied out the array for the next quest's logo
            $logo_arr = [];
         }
      }
   }

   //SELECT a.achievement_name, logo, q.quest_name FROM achievement a , quest q WHERE a.quest_id = 2 AND q.quest_id = 2
