<?php include_once 'includes/header.php';?> 
    <title>Webshop</title>

    <link rel="shortcut icon" type="icon" href ="Image/favicon.ico">
</head>
<body>
<?php include_once 'includes/nav.php';?>
<div class="AllContent">
<div class="SearchEnginePart">
<br>
<div id="WebshopHeader">
    <p>WEBSHOP</p> 
</div>
<br>
<br>
<div class="filters">

<form id="myFunction" method="POST">

<div class="FilterContent">
    <div class="pricefilter">
        <p>Maximum Price:</p>
        <input type="number" name="max" id="max" min="0" max="10000" value="<?php echo $_POST["max"] ?>">
        
        </div>
        <div class="ratingfilter">
        <p>Rating:</p>
        <input type="number" name="min" id="min" min="0" max="5" value="<?php echo $_POST["min"] ?>">
    
    </div>
</div>
<br>
<br>
    <div class="orderbyfilter">
        <p>Price:</p>
        <select name="order" id="order">
            <?php 
                if ($_POST["order"] == "DESC") {
                    echo "<option value='DESC' name='descending' id='descending' selected>High to low</option>
                        <option value='ASC' name='ascending' id='ascending'>Low to high</option>";
                }
                else {
                    echo "<option value='DESC' name='descending' id='descending'>High to low</option>
                    <option value='ASC' name='ascending' id='ascending' selected>Low to high</option>";
                }
            ?>
        </select>
    </div>
</div>
<br>
<br>
<br>
<br>
    <div class="submit">
        <input type="submit" value="Submit" name="submit">
    </div>
</form>
</div>

<div class="CardContent">
<?php
/* $path = "includes/Python/output.json";
$json = file_get_contents($path, true);
$data = json_decode($json, true);
$pricelist = [];
if (isset($_GET["order"])) {
    $order = $_GET['order'];
    foreach ($data['products'] as $address)
        {
            $price = str_replace(",","",$address['price']);
            $price = str_replace("$","",$price);
            $price = (int)$price;
            array_push($pricelist, $price);
        
        }
    if($order == "descending"){
        rsort($pricelist);
    }
    else{
        sort($pricelist);
    }

}
foreach ($data['products'] as $address)
{
    $price = str_replace(",","",$address['price']);
    $price = str_replace("$","",$price);
    $price = (int)$price;
    $rating = $address['rating'];
    
        if($price != null){
            if($rating != null){
                
                $rating = $rating[0];
                $rating = (int)$rating;

                if (isset($_GET["max"])) {

                    $maxprice = $_GET['max'];

                    if (isset($_GET["min"])) {
                        $minrating = $_GET['min'];
                        
                        if($price <= $maxprice){

                            if($rating >= $minrating){

                                echo "<div class='card'>";
                                echo "<img src='". $address['image'] ." 'style='height:300px'>";
                                echo  "<p title='".$address['title']."'>".substr($address['title'] , 0 , 30)."...</p>";
                                echo "<p>". $address['rating']."</p>";
                                echo "<p>". $address['reviews']."</p>";
                                echo  "<p class='price'>".$address['price'] ."</p> ";
                                echo"<p><a href='https://www.amazon.com" . $address['url']. "' target = '_blank'><button>Buy
                                </button></a></p></div></br>";
                                
                            }

                        }

                    }
                }
                    
            
            
        
        else{
            echo "<div class='card'>";
                echo "<img src='". $address['image'] ." 'style='height:300px'>";
                echo  "<p  title='".$address['title']."'>".substr($address['title'] , 0 , 30)."...</p>";
                echo "<p>". $address['rating']."</p>";
                echo "<p>". $address['reviews']."</p>";
                echo  "<p class='price'>".$address['price'] ."</p> ";
                
                echo"<p><a href='https://www.amazon.com" . $address['url']. "' target = '_blank'><button>Buy</button></a></p></div></br>";
        }
    }
    }

}; */

$sql    = "SELECT * FROM `products` WHERE `Search_Url` IN 
(SELECT `Interests` FROM `interests` WHERE `InterestsID` IN (SELECT `InterestsID` FROM `friendsinterests` WHERE `FriendsID` IN 
(SELECT `FriendsID` FROM `events` WHERE `EventsID` = " . $_GET["id"] . "))) AND Price >= 1";

if (isset($_POST["submit"])) {
    if (!empty($_POST["max"])) { 
        $sql = $sql . " AND Price <= " . $_POST["max"];
    }
    if (!empty($_POST["min"])) {
        $sql = $sql . " AND Rating >= " . $_POST["min"];
    }
    if (!empty($_POST["order"])) {
        $sql = $sql . " Order By Price " . $_POST["order"];
    }
}

$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
                echo "<img src='". $row['Img'] ." 'style='height:300px'>";
                echo  "<p  title='".$row['Title']."'>".substr($row['Title'] , 0 , 25)."...</p>";

                if(empty($row['Rating'])) {
                    echo "No Data Available..."; echo '<br>'; echo '<br>';
                  }
                  else{
                    echo "<p>". $row['Rating']."</p>";
                  }

                  if(empty($row['Reviews'])) {
                    echo "No Data Available...";echo '<br>';echo '<br>';
                  }
                  else{
                    echo "<p>". $row['Reviews']."</p>"; 
                  }
                echo  "<p class='price'>$".$row['Price'] ."</p> ";
                
                echo"<p><a href='https://www.amazon.com" . $row['URL']. "' target = '_blank'><button>Buy</button></a></p></div></br>";
    }
} 
?>

</div>


</div>

<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>

<?php include_once 'includes/footer.php';?> 
