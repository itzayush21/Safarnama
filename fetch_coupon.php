<?php
include("connection.php");

// Assuming you have a coupons table with columns state, description, and credit_required
$sql = "SELECT state, description, credit_required FROM coupons";
$result = $conn->query($sql);

$coupons = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $coupons[] = $row;
    }
}

$conn->close();

// Encode the coupons as JSON and send them as a response
echo json_encode($coupons);
?>
