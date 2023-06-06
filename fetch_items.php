<?php
include('db.php');

$query = "SELECT * FROM items";
$result = mysqli_query($connection, $query);

$items = array();
while ($row = mysqli_fetch_assoc($result)) {
  $items[] = $row;
}

header('Content-Type: application/json');
echo json_encode($items);
?>
