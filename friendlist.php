<?php include_once 'includes/header.php';
include_once 'includes/nav.php';
require_once 'includes/conn.php';
?> 
<title>friend List</title>
<link rel="shortcut icon" type="icon" href ="Image/FriendList.ico">
</head>
<body>
    <div class="FriendlistSection">
        <div class="FriendContent">
            <br>
            <br>
                <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birthday</th>
                    <th>Profile Picture</th>
                    <th>friend intrest</th>
                    <th>edit</th>
                    <th>Delete friend</th>
                </tr>
                    <?php 
                    $sql = "SELECT * FROM friends WHERE AccountsID = ".$_SESSION["AccountsID"];
                    $result = mysqli_query($conn , $sql);
                    while ($row = $result->fetch_assoc()) {
                        
                    echo "<tr>";
                    echo    "<td>" . $row['Firstname'] . "</td>";
                    echo    "<td>" . $row['Lastname'] . "</td>";
                    echo   "<td>" . $row['Birthdate'] . "</td>";
                    echo   "<td>" . $row['PfP'] . "</td>";

                            $sql2 = "SELECT * FROM interests WHERE InterestsID in (SELECT InterestsID from friendsinterests where FriendsID=".$row["FriendsID"].")";
                            $result2= mysqli_query($conn , $sql2);
                            echo   "<td>";
                            while ($row2 = $result2->fetch_assoc()) {
                                 echo $row2['Interests'] ; echo '<br>';echo '<br>';
                            }
                    echo"<td><a href='friendlistedit.php?id=".$row['FriendsID']."'><svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
                    <path stroke-linecap='round' stroke-linejoin='round' d='M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z' />
                    </svg></a></td>";
                    echo"<td><a href='friendsdelete.php?id=".$row['FriendsID']."'><svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
                    <path stroke-linecap='round' stroke-linejoin='round' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />
                    </svg></td>";
                    echo"</tr>";
                    }


                    ?>


                        
                    </table>

    </div>

</div>
        
<?php include_once 'includes/footer.php';?> 
</body>