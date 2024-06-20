<?php
session_start();
session_destroy();
session_unset();

session_start();

require_once 'inc/dbconn.php';
require_once 'inc/auth.php';

$database = new database();
$auth = new auth($database);

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Gudang') {
        header('Location: gudang/index.php');
    } elseif ($_SESSION['role'] == 'Sales') {
        header('Location: sales/index.php');
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->authenticate($username, $password)) {
        $_SESSION['role'] = $auth->getRole($username);
        $_SESSION['nama'] = $auth->getNama($username);
        $_SESSION['userid'] = $auth->getUserId($username);

        header('Location: ' . strtolower($_SESSION['role']) . '/index.php');
        exit();
    } else {
        $error_message = 'Username atau password salah.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            margin-top: 50px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Login</h1>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message)) { ?>
                            <p class="text-danger"><?php echo $error_message; ?></p>
                        <?php } ?>
                        <form action="index.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
