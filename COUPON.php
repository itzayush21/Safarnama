<?php
// Include your database connection file here
include("connection.php");

// Start a PHP session if not already started
session_start();

// Initialize userCredits to 0
$userCredits = 0;

// Check if the user is logged in
if (isset($_SESSION["username"])) {
    $user_name = $_SESSION["username"];

    // Prepare and execute a SQL query to fetch the user's credit points
    $sql = "SELECT credit FROM credit WHERE user_name = '$user_name'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$user_name);
    $stmt->execute();
    $stmt->bind_result($userCredits);

    // Fetch the user's credit points
    if ($stmt->fetch()) {
        // User's credit points were fetched successfully
    } else {
        // User not found in the credit table, initialize with 0 credits
        $userCredits = 0;
    }

    // Close the prepared statement
    $stmt->close();
}

// Check if a coupon has been redeemed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["coupon-credit"])) {
    $couponCredit = 20;
    
    // Check if the user has enough credits to redeem the coupon
    if ($userCredits >= $couponCredit) {
        // Deduct the coupon credit from the user's total credits
        $userCredits -= $couponCredit;

        // Update the user's credit in the database
        $updateSql = "UPDATE credit SET credit = '$userCredits' WHERE user_name ='$user_name'";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si",$user_name,$userCredits);
        $updateStmt->execute();

        // Close the update statement
        $updateStmt->close();

        // Provide a success message
        $redeemMessage = "You have successfully redeemed the coupon! Your remaining credits: " . $userCredits;
    } else {
        // Provide an error message for insufficient credits
        $redeemMessage = "Insufficient credits to redeem this coupon.";
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourist Coupons</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0ecec;
        }

        header {
            background-color: #000000;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        h1 {
            font-size: 36px;
        }

        main {
            width: 100%;
            height:auto;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .coupon-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .coupon {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: calc(33.33% - 20px);
            text-align: center;
        }

        .coupon img {
            max-width: 100%;
            height: 100px;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 16px;
            margin-bottom: 10px;
            font-weight:bold;
            
        }

        p {
            font-size: 12px;
            margin-bottom: 10px;
            font-weight:bold;
        }

        .redeem-btn {
            background-color: #007acc;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .redeem-btn:hover {
            background-color: #005b99;
        }

        .user-info {
            margin-top: 20px;
            text-align: center;
        }

        .user-info h2 {
            font-size: 20px;
        }

        .user-info #user-credits {
            font-weight: bold;
            font-size: 24px;
            color: #007acc;
        }
    </style>
</head>
<body>
    <header>
        <h1>Tourist Coupons</h1>
    </header>
    <main>
        <section class="coupon-container">
            <div class="coupon">
                <img src="logo.jpeg" alt="Coupon 1">
                <h2>Assam Coupon</h2>
                <p>Credit Points: 20</p>
                <form method="POST" action="COUPON.php">
                    <input type="hidden" name="coupon-credit" value="20">
                    <button type="submit" class="redeem-btn"><a href="coupancode1.html">Redeem</a></button>
                </form>
            </div>
        </section>
        <section class="user-info">
            <h2>Your Credits: <span id="user-credits"><?php echo $userCredits; ?></span></h2>
        </section>
        <section class="redeem-message">
            <?php if (isset($redeemMessage)) { echo $redeemMessage; } ?>
        </section>
    </main>
    <!--<script>
        const redeemButtons = document.querySelectorAll('.redeem-btn');
        const userCreditsSpan = document.getElementById('user-credits');

        let userCredits = 0;

        redeemButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const creditPoints = parseInt(button.getAttribute('data-credit'));
                if (userCredits >= creditPoints) {
                    userCredits -= creditPoints;
                    updateUserCredits();
                    alert(`You have successfully redeemed the coupon! Your remaining credits: ${userCredits}`);
                } else {
                    alert('Insufficient credits to redeem this coupon.');
                }
            });
        });

        function updateUserCredits() {
            userCreditsSpan.textContent = userCredits;
        }

        updateUserCredits(); 
    </script>-->
</body>
</html>
