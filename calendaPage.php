<?php include_once 'includes/header.php'; ?>
<title>Kaddoo For Birthdays</title>
</head>
<body>

  <style>
    .calendarContent {
      display: flex;
      justify-content: space-around;
    }

    .Upcoming {
      width: 25%;
      padding-left: 2%;
      padding-right: 2%;
      max-height: 1112px;
    }

    .List {
      overflow-y: auto;
      max-height: calc(1112px - 38.39px - 51px);
    }

    .Event {
      padding: 5%;
      border: solid;
      border-width: thin;
    }

    .Title {
      text-align: center;
      margin-bottom: 36px;
      margin-top: 15px;
    }
  </style>
 
  <?php include_once 'includes/nav.php';
  ?>
  <br>

  <div class="calendarContent">

  <?php
  include 'includes/calendar.php';
 
  $calendar = new Calendar();
 
  echo $calendar->show();?>

  <div class="Upcoming">
    <div class="Title">
      <h2>Upcoming Events</h2>
    </div>
    <div class="List">
      <?php 
        $sql    = "SELECT * FROM `events` WHERE `FriendsID` IN 
        (SELECT `FriendsID` FROM `friends` WHERE `AccountsID` = " . $_SESSION["AccountsID"] . ") ORDER BY `Date` ASC";

        $result = mysqli_query($conn, $sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='Event'>";
                echo    "<p> ".$row['Date'] ."</p> ";
                echo    "<a href='webshopRedirect.php?id=" . $row["EventsID"] . "&me=" . $_SESSION["AccountsID"] . "'><h5>". $row['Name']."</h5></a>";
                echo "</div>";
            }
        } 
      ?>
    </div>

  </div>
  </div>
  <br>
<button class="open-button" onclick="openForm()">Add friends</button>

<div class="form-popup" id="myForm">
  <form action="includes/friends.php"  method="POST" class="form-container">
    <h1>Add Friend</h1>

    <label for="Firstname" >
     First Name
    </label>
    <br>
    <input type="text" name="Firstname" id="Firstname" placeholder="Insert Your First Name" >
<br>
<label for="LastName" >
     Last Name
    </label>
    <br>
    <input type="text" name="LastName" id="LastName" placeholder="Insert Your Last Name" >
<br>
    <label for="Bday">
    Your Birthdate
    </label>
    <br>
    <input type="date" id="Bday" name="Bday"value="">
    <br>
    <label for="interest">
                    Interest
                </label>
                <br>
                <select name="interest" id="interest">
                <?php
$sql    = "SELECT * FROM interests";

$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo  "<option value='".$row['InterestsID']."'>".$row['Interests']."
        
    </option>";
    }
}

?>
                </select>
<br>
    <button type="submit" name="submit" id="submit" class="btn">ADD</button>
    <br>
    <br>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>
<!-- 








add event








-->
<button class="open-button" onclick="openForm1()">Add event</button>

<div class="form-popup" id="eventform">
  <form action="includes/events.php"  method="POST" class="form-container">
    <h1>Add event</h1>

    <label for="friends">
                    Select friends
                </label>
                <br>
                <select name="friends" id="friends">
<?php
$sql    = "SELECT * FROM friends WHERE AccountsID = " .$_SESSION["AccountsID"];

$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo  "<option value='".$row['FriendsID']."'>".$row['Firstname']." ".$row['Lastname']."
        
    </option>";
    }
}

?>
</select>
<br>
    <label for="eventname">
     Event name
    </label>
    <br>
    <input type="text" name="eventname" id="eventname" placeholder="event name" >
<br>
    <label for="eventdate">
    Event date
    </label>
    <br>
    <input type="date" id="eventdate" name="eventdate"value="">
   
<br>
    <button type="submit" name="submit" id="submit" class="btn">ADD</button>
    <br>
    <br>
    <button type="button" class="btn cancel" onclick="closeForm1()">Close</button>
  </form>
</div>

<script>
  window.onload = function () {
    document.getElementById("myForm").style.display = "none";
    document.getElementById("eventform").style.display = "none";
};

function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}

function openForm1() {
  document.getElementById("eventform").style.display = "block";
}
function closeForm1() {
  document.getElementById("eventform").style.display = "none";
}
</script>
<br>
<br>
<br>
<br>

<?include_once 'includes/footer.php';?> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>
    
</body>
</html>