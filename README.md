## RESTful API for Scan Adventure - Android App

This RESTful API is developed to allow the app to access the MySQL database. It has endpoints for login/signup, listing all the events, quests, stations, items & achievements that the admins has added into the system. It also allows user to save their records of scans, checking for duplicate scans, validating the order of scans and listing the achievements that the user has unlocked. Below are some of the examples of responses. 

#### 1) Get all available events 
Endpoint: ../api/event/listEvent.php <br>
Response: 
```
[
    {
        "event_id": 1,
        "event_name": "eat local fruit",
        "start_date": "16/6/2019",
        "end_date": "23/6/2019",
        "organizer": "Sarawak Tourismmm",
        "category": "food",
        "image": "32.png"
    },
    {
        "event_id": 2,
        "event_name": "eat local fruit",
        "start_date": "15/6/2019",
        "end_date": "20/6/2019",
        "organizer": "Sarawak Tourism",
        "category": "food",
        "image": "41.png"
    },
    ...
```

#### 2) Get all the achievable achievements inside the app 
Endpoint: ../api/achievement/list.php <br>
Example of response:
```
[
    {
        "achievement_id": 1,
        "achievement_name": "Food Beginner",
        "quest_id": 1,
        "quest_name": "Eat Local Foods",
        "level": 1,
        "requirement": 3,
        "logo": "1.jpg"
    },
    {
        "achievement_id": 2,
        "achievement_name": "Travel Amateur",
        "quest_id": 2,
        "quest_name": "Visit Historical Places",
        "level": 2,
        "requirement": 3,
        "logo": "2.jpg"
    },
    ...
```

#### 3) Get all the achievements unlocked by the user
Endpoint: ../api/achievement/getUserAchivs.php?userId=2 <br>
Example of response: 
```
[
    {
        "achievement_id": 4,
        "achievement_name": "Travel Beginner",
        "level": 1,
        "requirement": 2,
        "logo": "4.jpg",
        "quest_id": 2,
        "quest_name": "Visit Historical Places"
    },
    {
        "achievement_id": 14,
        "achievement_name": "Newbie",
        "level": 1,
        "requirement": 2,
        "logo": "8.jpg",
        "quest_id": 5,
        "quest_name": "Visit Mosques"
    },
    ...
```

#### 4) Get all the items a quest has and showed whether an item has been scanned by the user.
Endpoint: ../api/item/listItems.php?questId=2&userId=2 <br>
Example of response: 
```
[
    {
        "item_id": 1,
        "item_name": "Mosque",
        "place_name": "Kuching City Mosque",
        "location": "Kuching, Sarawak",
        "description": "Historical Mosque",
        "latitude": "1.558719",
        "longitude": "110.340600",
        "image": "kuching_city_mosque.jpg",
        "quest_id": 2,
        "scanned_status": "Scanned"
    },
    {
        "item_id": 2,
        "item_name": "University",
        "place_name": "UNIMAS",
        "location": "Kota Samarahan, Sarawak",
        "description": "A university",
        "latitude": "1.467094",
        "longitude": "110.428819",
        "image": "unimas.jpg",
        "quest_id": 2,
        "scanned_status": "Scanned"
    },
    ...
```
