<!-- signin.php -->
<?php
session_start();

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

if (!empty($username) && !empty($password)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "jewel";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect error('.mysqli_connect_errno().')'.mysqli_connect_error());
    } else {
        $stmt = $conn->prepare("SELECT * FROM rigestration WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Password is correct, redirect to ShopNow.html
                header("Location: ShopNow.html");
                exit;
            } else {
                echo "Incorrect password.";
            }
        } else {
            header('Location: index.html');

        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required.";
}
?>
