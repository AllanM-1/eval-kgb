<?php
$host = (isset($_POST['host'])) ? $_POST['host'] : '';
$username = (isset($_POST['username'])) ? $_POST['username'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$database = (isset($_POST['database'])) ? $_POST['database'] : '';
$submit = (isset($_POST['submit'])) ? $_POST['submit'] : false;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="py-5 text-center">
                    <i class="fas fa-database h1"></i>
                    <h2>Database setup</h2>
                    <p class="lead">Please fill in the fields your information and follow the instructions.</p>
                </div>
            </div>
        </div>
    </div>

    <?php if(!$submit): ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1>Configuration</h1>
                <form method="post" action="setup.php">
                    <div class="form-group">
                        <label for="host">Host</label>
                        <input type="text" class="form-control" id="host" name="host" value="localhost">
                        <small class="form-text text-muted">The host of your database server</small>
                    </div>
                    <div class="form-group">
                        <label for="username">Host</label>
                        <input type="text" class="form-control" id="username" name="username" value="root">
                        <small class="form-text text-muted">The user of your database</small>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="">
                        <small class="form-text text-muted">The password of your database</small>
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="database">Database name</label>
                        <input type="text" class="form-control" id="database" name="database" value="testkgb">
                        <small class="form-text text-muted">The name of your database</small>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit" value="1">Start the install to create</button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($submit): ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1>Install</h1>
                <?php
                $mysqlDsn = 'mysql:host='.$host;

                // Create the DB
                try {
                    $pdo = new PDO($mysqlDsn, $username, $password);
                    if ($pdo->exec('CREATE DATABASE '.$database) !== false) {
                        echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Database created</div>';
                    } else {
                        echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Failed to create the database, already exist</div>';
                    }
                } catch (PDOException $PDOException) {
                    echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Unable to connect to the database</div>';
                }

                // Import the file
                $mysqlDsn = 'mysql:host='.$host.';dbname='.$database;
                try {
                    $pdo = new PDO($mysqlDsn, $username, $password);
                    // Import the dump
                    $sql = file_get_contents('kgb.sql');
                    if($pdo->exec($sql) !== false) {
                        echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Successful import</div>';
                    } else {
                        echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Error during the import</div>';
                    }
                } catch (PDOException $PDOException) {
                    echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Unable to connect to the database</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>