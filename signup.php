<?php
include_once('views/partials/header.php');
define('BASEPATH', true); //access connection script if you omit this line file will be blank
include './controllers/database/db.php';

if (isset($_POST['submit'])) {
    try {
        $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $user = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $pass = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));

        //Check if username exists
        $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':username', $user);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['num'] > 0) {
            echo '<script>alert("Username already exists")</script>';
        } else {

            $stmt = $dsn->prepare("INSERT INTO users (username, email, password) 
            VALUES (:username,:email, :password)");
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $pass);



            if ($stmt->execute()) {
                // echo '<script>alert("New account created.")</script>';
                //redirect to another page
                echo '<script>window.location.replace("index.php")</script>';
            } else {
                echo '<script>alert("An error occurred")</script>';
            }
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
        echo '<script type="text/javascript">alert("' . $error . '");</script>';
    }
}
?>

<main class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-semibold mb-4">Register</h2>
        <form action="signup.php" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" id="username" class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:border-blue-500" placeholder="Username" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:border-blue-500" placeholder="Email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:border-blue-500" placeholder="Password" required>
            </div>
            <button name="submit" type="submit" class="bg-blue-500 text-white rounded-lg px-4 py-2 w-full hover:bg-blue-600 transition duration-200">Register</button>
        </form>
    </div>
</main>

<?php
include_once('views/partials/footer.php');
?>