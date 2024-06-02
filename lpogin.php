
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 800px;
        }
        form {
            width: 400px;
        }
    </style>
</head>
<body>
    <form class="border border-2 border-primary p-3 rounded rounded-3" action="lpogin.php" method="post">
        <h3>User Login</h3>
        <div class="mb-2">
            <label for="UserName" class="form-label">User Name</label>
            <div>
               <input type="text" class="form-control" name="UserName" required>
            </div>
        </div>
        <div class="mb-2">
            <label for="Email" class="form-label">Email</label>
            <div>
               <input type="email" class="form-control" name="Email" required>
            </div>
        </div>
        
        <div class="mb-2">
           <label for="Password" class="form-label">Password</label>
           <div>
               <input type="password" class="form-control" name="Password" required>
           </div>
        </div>
        <div class="mb-2">
           <label for="SignIn" class="form-label">Keep me signed in</label>
           <div class="form-switch">
               <input type="checkbox" class="form-check-input" name="SignIn">
               <label class="form-label">Yes</label>
           </div>
        </div>
        
        <div class="mb-2">
           <button class="btn btn-primary w-100" type="submit">Login</button>
        </div>
    </form>
</body>
</html>
<?php
// Include your database connection file here
include("connection.php");
error_reporting(0); 
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST["UserName"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $signIn = isset($_POST["SignIn"]) ? 1 : 0; // 1 if checked, 0 if not

    // Hash the password (for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query
    $sql = "INSERT INTO user (user_name, email, password, remember) VALUES ('$username','$email','$password','$signIn')";
    $stmt = $conn->prepare($sql);

    // Check if prepare was successful
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sssi",$username, $email, $hashedPassword, $signIn);

        // Execute the query
        if ($stmt->execute()) {
            // Registration successful
            echo "Registration successful!";
        } else {
            // Registration failed
            echo "Error executing query: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error in preparing the statement
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
