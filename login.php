<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
// ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the login form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Sanitize the data to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // ...
}
?>

<?php
// ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ...

    // Query the database for the user
    $sql = "SELECT * FROM users WHERE (username = '$username' OR email = '$username') LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row["password"])) {
            // The password is correct. Start a session and redirect the user to the dashboard or homepage.
            session_start();
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $row["email"];

            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid username/email or password.";
        }
    } else {
        // User does not exist
        echo "Invalid username/email or password.";
    }

    // ...
}
?>

<?php
// ...

// Close the database connection
$conn->close();
?>
