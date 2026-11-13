<?php

session_start(); // creates a session

$db = new SQLite3("database.db"); // Connect to SQLite database

$error = ""; // error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  ///Checks if the form  has been submitted
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username"); //to ensure the data is there and it is
    $stmt->bindValue(':username', $username);

    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);


    if ( $user ) {

        if (password_verify($password , $user["password"] ) ) {       //while this is to test if it is valid and catches errors if successful it goes to the next page etc


            $_SESSION['user'] = $user;

            header("Location: inventory.php");  //Links to the next page if sucessful
            exit();

          } else {

          $error = "Invalid username or password";

          }

          } else {

            $error = "Invalid username or password";  //Shows user if their username/password is wrong.
        }
    }

      ?>

      <!doctype html>
      <html lang="en">
        <head>
        <title>Login</title>
        <link rel="stylesheet" href="style.css">
        </head>
        <body>
          <header>
          <h1>Sign In</h1>
          </header>

          <hr />

          <?php
          if ($error != "") {
            echo "<p>$error</p>";  //display error page
          }
      
          ?>

          <form id="loginForm" method="POST"> 
          <label for="username">Username</label><br />
            <input
            type="text"
            id="username"
            name="username"
            placeholder="username"
            />

            <br />

          <label for="password">Password</label><br />
            <input
            type="password"
            id="password"
            name="password"
            placeholder="••••••••••••"
            />

            <br />

          <button type="submit" name="submit">Sign In</button>
          </form>
          <hr />
          <footer>
          <p>COMP5008 - Web Development Assignment 2 - Login: {}</p>
          </footer>
        </body>
      </html>

      