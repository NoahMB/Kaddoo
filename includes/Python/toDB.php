<?php
include_once '../conn.php';

$path = "output.json";
$json = file_get_contents($path, true);
$data = json_decode($json, true);

foreach ($data['products'] as $products){
    $interest = str_replace("https://www.amazon.com/s?k=","",$products['search_url']);
    $price = str_replace(",","",$products['price']);
    $price = str_replace("$","",$price);
    $sql = "INSERT INTO products (Title, Img, URL, Rating, Reviews, Price, Search_Url) Values ('".$products['title']."','".$products['image']."','".$products['url']."','".$products['rating']."','".$products['reviews']."','".$price."','".$interest."');";
    mysqli_query($conn , $sql);      
}

