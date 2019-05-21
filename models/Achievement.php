<?php
class Achievement {
   // DB stuff
   private $conn;
   private $table = 'achievement';

   // Achievement's properties 
   public $achievement_id;
   public $achievement_name;
   public $quest_id;
   public $level;
   public $requirement;
   public $logo;

   public $user_id;

   // Constructor with DB
   public function __construct($db) {
      $this->conn = $db;
   }

   // Fetch all the Achievements.
   public function listAchievements() {
      // create query
      $query = 'SELECT * FROM ' . $this->table;

      // prepare statement
      $stmt = $this->conn->prepare($query);

      // execute stmt
      $stmt->execute();

      return $stmt;
   }

   public function getUserAchievements()
   {
      $query = 'SELECT * FROM 
                     ' . $this->table . ' a,
                     scanned s
                     WHERE s.user_id = :userId
                     AND s.quest_id = a.quest_id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind params
      $stmt->bindParam(':userId', $this->user_id);

      // Execute statement
      $stmt->execute();

      return $stmt;
   }

   //SELECT DISTINCT quest_id FROM scanned

  /* // fetch one quest
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
      } else {
         return false;
      }
   } */
}