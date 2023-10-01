<?php
include_once('views/partials/header.php');
define('BASEPATH', true); //access connection script if you omit this line file will be blank
include './controllers/database/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    // try {
    $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //ensure fields are not empty
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;

    //Retrieve the user account information for the given username.
    $sql = "SELECT id, username, password FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);

    //Bind value.
    $stmt->bindValue(':username', $username);

    //Execute.
    $stmt->execute();

    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //If $row is FALSE.
    if ($user === false) {
        echo '<script>alert("invalid username or password")</script>';
    } else {

        //Compare and decrypt passwords.
        $validPassword = password_verify($passwordAttempt, $user['password']);

        //If $validPassword is TRUE, the login has been successful.
        if ($validPassword) {
            //Provide the user with a login session.
            $_SESSION['user'] = $username;
            $_SESSION['user_id'] = $user['id'];
            echo '<script>window.location.replace("dashboard.php");</script>';
            exit;
        } else {
            //$validPassword was FALSE. Passwords do not match.
            echo '<script>alert("invalid username or password")</script>';
        }
    }
}
?>
<main class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-semibold mb-4">Sign In</h2>
        <form action="login.php" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" id="username" class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:border-blue-500" placeholder="Username" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:border-blue-500" placeholder="Password" required>
            </div>
            <button name="submit" type="submit" class="bg-blue-500 text-white rounded-lg px-4 py-2 w-full hover:bg-blue-600 transition duration-200">Sign In</button>
        </form>
    </div>
</main>

<?php
include_once('views/partials/footer.php');
?>