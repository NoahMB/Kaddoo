<?php include_once 'includes/header.php'; ?>
<title>Kaddoo For Birthdays</title>
</head>
<body>

<style>
  .calendarContent {
    display: flex;
    justify-content: space-around;
    align-items: flex-start;
  }

  .Upcoming {
    width: 25%;
    padding-left: 2%;
    padding-right: 2%;
  }

  .List {
    overflow-y: auto;
    height: calc(100% - 86px);
  }

  .Event {
    padding: 5%;
    border: solid;
    border-width: thin;
  }

  .Title {
    text-align: center;
    display: flex;
    height: 86px;
    justify-content: center;
    align-items: center;
  }

    /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  /* Modal Content */
  .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }

  /* The Close Button */
  .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
  }

  .addButtons {
    padding: 30px;
    display: flex;
    justify-content: space-evenly;
  }

  .addForms {
    padding: 30px;
    display: flex;
    justify-content: space-evenly;
  }

  .datecell p:not(:first-child) {
    text-decoration: none;
  }

  .day {
    align-self: flex-start;
    padding-left: 5px;
    padding-top: 5px;
    font-weight: bold;
  }

  .dayContent {
    align-self: flex-start;
    padding-left: 10px;
    padding-top: 5px;
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

  <div class="Upcoming" id="Upcoming">
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

  <div id="myModal" class="modal">

  <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
      <div class="addButtons">
<button class="open-button" onclick="openForm()">Add friends</button>
<button class="open-button" onclick="openForm1()">Add event</button>
</div>
<div class="addForms">
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
</div>
</div>
</div>

<script>
  window.onload = function () {
    document.getElementById("myForm").style.display = "none";
    document.getElementById("eventform").style.display = "none";
    var offsetHeight = document.getElementById("calendar").offsetHeight;
    document.getElementById("Upcoming").style.height = offsetHeight + 'px';
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

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


</script>

<?include_once 'includes/footer.php';?> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>
    
</body>
</html>