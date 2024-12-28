<?php
$errorMsg = "";
$fnameValue = "";
$lnameValue = "";
$telephoneValue = "";
$villeValue = "";
$emailValue = "";
$successMsg = "";

include ("connection.php");
$connection = new Connection();
include ("clients.php");


$connection->selectDatabase("pharmacie");

if (isset($_POST['registration'])) {
   $fnameValue = $_POST['firstName'];
   $lnameValue = $_POST['lastName'];
   $telephoneValue = $_POST['telephone'];
   $villeValue = $_POST['ville'];
   $emailValue = $_POST['email'];
   $passValue = $_POST['password'];

   if (empty($fnameValue) || empty($lnameValue) || empty($emailValue) || empty($passValue)) {
       $errorMsg = "All fields must be filled in";
   } else if (strlen($passValue) < 8) {
       $errorMsg = "Password must contain at least 8 characters";
   } else if (preg_match('/[A-Z]+/', $passValue) == 0) {
       $errorMsg = "Password must contain at least one capital letter";
   } else {
       $clients = new Clients($fnameValue, $lnameValue, $telephoneValue, $villeValue, $emailValue, $passValue);
       $clients->insertClient("clients", $connection->conn);
       $errorMsg = Clients::$errorMsg;
       $successMsg = Clients::$successMsg;
       header("location:login.php");
   }

}
?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Sign Up Form</title>
    <!-- Font Awesome for social media icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body, html {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .background {
            background-image: url('img/carousel-1.jpg'); /* Replace with your own background image */
            background-size: cover;
            background-position: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            filter: brightness(0.6);
        }

        .signup-container {
            background-color: rgba(51, 51, 51, 0.9);
            padding: 50px;
            border-radius: 12px;
            width: 600px; /* Increase the width */
            text-align: center;
            color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1s ease-in-out;
        }

        .signup-container h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #ffffff;
            font-weight: bold;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .name-fields {
            display: flex;
            gap: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 15px; /* Increase padding */
            border: 1px solid #444;
            border-radius: 6px;
            background-color: #555;
            color: #ffffff;
            transition: background-color 0.3s, box-shadow 0.3s;
            width: 100%;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            background-color: #666;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
            outline: none;
        }

        input::placeholder {
            color: #ccc;
        }

        .checkbox {
            display: flex;
            align-items: center;
            font-size: 0.9em;
            color: #bbbbbb;
            gap: 10px;
        }

        .checkbox input {
            margin: 0;
            width: 16px;
            height: 16px;
        }

        button {
            padding: 15px;
            border: none;
            border-radius: 6px;
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        p {
            margin: 20px 0 10px;
            color: #aaa;
            font-size: 0.9em;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
        }

        .social-icons a {
            color: #ccc;
            font-size: 1.5em;
            transition: color 0.3s, transform 0.2s;
        }

        .social-icons a:hover {
            color: #ffffff;
            transform: scale(1.1);
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="background"></div>
    <div class="signup-container">
        <h2>Sign up</h2>
        <form action="" method="post">
        <?php
        if(!empty ($errorMssg)){ 
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong> $errorMssg </strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        }
        ?>
            <div class="name-fields">
                <input name="firstName" value="" type="text" placeholder="First name" >
                
                <input name="lastName" value="" type="text" placeholder="Last name" >
                
            </div>
            <div class="name-fields">
                <input name="telephone" value="" type="text" placeholder="Telephone" >
                <input name="ville" value="" type="text" placeholder="ville" >
            </div>
            <input type="email" value="" name="email" placeholder="Email address" >
            <input type="password" value="" name="password" placeholder="Password" >
            <input type="password" value="" name="confpassword" placeholder="Confirm Password" >
            <button name="registration" value="registration" >SIGN UP</button>
            <div>
                <a href="login.php" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border: none; border-radius: 5px; transition: background-color 0.3s, transform 0.2s">Log In</a>    
            </div>
            <?php
            if(!empty ($succesMsg)){
                echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong> $succesMsg </strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            } 
            ?>
        </form>

        <p>or sign up with:</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-google"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-github"></i></a>
        </div>
    </div>
    
</body>

</html>