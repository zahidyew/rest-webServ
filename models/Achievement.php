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
   public $achievement_arr = array();

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

   public function testGetAchiv() {
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

   // function to get the User's Achievements based on what he/she has scanned.
   public function getUserAchivs() {
      $query = 'SELECT DISTINCT quest_id FROM scanned
                  WHERE user_id = :userId
                  ORDER BY quest_id ASC';

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':userId', $this->user_id);
      $stmt->execute();

      $numOfQuests = 0;

      // saves the questId to an array 
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
         $questId[$numOfQuests] = $row['quest_id'];
         $numOfQuests++;
      }

      /* for($i = 0; $i < $numOfQuests; $i++) {
         echo json_encode($questId[$i]);
         echo ", ";
      } */

      // loop to go through each distinct questId
      for ($i = 0; $i < $numOfQuests; $i++) {
         // get the number of times a quest is scanned by the user
         $query2 = 'SELECT COUNT(quest_id) FROM scanned 
                     WHERE user_id = :userId
                     AND quest_id = :questId';

         $stmt2 = $this->conn->prepare($query2);
         $stmt2->bindParam(':userId', $this->user_id);
         $stmt2->bindParam(':questId', $questId[$i]);
         $stmt2->execute();

         $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
         $countScans[$i] = $row2['COUNT(quest_id)'];
         /* echo json_encode($countScans[$i]);
         echo ", ";  */

         // get all the achievements a user has achieved
         $query3 = 'SELECT DISTINCT achievement_id, 
                     achievement_name, level, requirement,
                     logo, a.quest_id 
                     FROM achievement a, scanned s 
                     WHERE s.user_id = :userId 
                     AND a.quest_id = :questId 
                     AND a.requirement <= :countScans';

         $stmt3 = $this->conn->prepare($query3);
         $stmt3->bindParam(':userId', $this->user_id);
         $stmt3->bindParam(':questId', $questId[$i]);
         $stmt3->bindParam(':countScans', $countScans[$i]);
         $stmt3->execute();

         while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
            extract($row3);
            $achievement_item = array(
               'achievement_id' => $achievement_id,
               'achievement_name' => $achievement_name,
               'level' => $level,
               'requirement' => $requirement,
               'logo' => $logo,
               'quest_id' => $quest_id
            );
            array_push($this->achievement_arr, $achievement_item);
         }
      }
   }

   //SELECT COUNT(quest_id) FROM scanned WHERE user_id = 2 AND quest_id = 1

   //SELECT DISTINCT achievement_id,logo,achievement_name,level,requirement,a.quest_id FROM achievement a, scanned s WHERE s.user_id = 2 AND a.quest_id = 2 AND a.requirement <= 5

   //SELECT DISTINCT logo,achievement_id FROM achievement a, scanned s WHERE s.user_id = 2 AND a.quest_id = 2 AND a.requirement >= 5


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