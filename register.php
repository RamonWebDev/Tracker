<?php 
session_start();
require("cfd.php");
require_once 'header.php';

if(isset($_SESSION['user'])){
    header("location: index.php");
}//end if

if(isset($_REQUEST['register_btn'])){//checks if form has been filled
    $username = filter_var(strtolower($_REQUEST['username']), FILTER_SANITIZE_STRING); //sanatizes user info
    $email = filter_var(strtolower($_REQUEST['email']), FILTER_SANITIZE_EMAIL);
    $password = strip_tags($_REQUEST['password']);

    if(empty($username)){//checks if it's empty
        $errorMsg[0][] = 'Name required';
    }//end if

    if(empty($email)){
        $errorMsg[1][] = 'Email required';
    }//end if

    if(empty($password)){
        $errorMsg[2][] = 'Passowrd required';
    }//end if
    
    if(strlen($password) < 6){
        $errorMsg[2][] = 'Passowrd is to short';
    }//end if

    if(empty($errorMsg)){

        try{
            $select_stmt = $db->prepare("SELECT username, email FROM user WHERE email = :email"); //setting up sql statement
            $select_stmt->execute([':email' => $email]);//checks if email is already in database
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            
            if(isset($row['email']) == $email){
                $errorMsg[1] = "Email address already exists. Please log in or make an account.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);//hash password
                $created = new DateTime();//gets current time
                $created = $created->format('Y-m-d H:i:s');//formatting time 

                $insert_stmt = $db->prepare("INSERT into user(username, email, password,datecreated) VALUES (:username, :email, :password, :datecreated)");// insert query

                if(
                    $insert_stmt->execute(
                        [
                            ':username' => $username,
                            ':email' => $email,
                            ':password' => $hashed_password,
                            ':datecreated' => $created
                        ]
                    )
                ){//if true send user to different page
                    header("location: index.php");
                }
            }//end else
        }//end try
        catch(PDOExecption $e){//Gets error if something is wrong with query
            $pdoError = $e->getMessage();
        }
    }//end if
}//end if

?>


<form action="register.php" method='post'>

    <?php
    if(isset($errorMsg[0])){//echo out message if email is wrong
        foreach($errorMsg[0] as $nameErrors){
            echo "<p>".$nameErrors."<p>";
        }
    }
    ?>
    <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="username" require="">


    <?php
    if(isset($errorMsg[1])){////echo out message if something is wrong with the email
        foreach($errorMsg[1] as $emailErrors){
            echo "<p>".$emailErrors."<p>";
        }
    }
    ?>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Enter Email" require="">

    <?php
    if(isset($errorMsg[2])){//echo out message if something is wrong with the password
        foreach($errorMsg[2] as $passwordErrors){
            echo "<p>".$passwordErrors."<p>";
        }
    }
    ?>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="password" require="">

    <input type="submit" id="submit" name="register_btn" value="Register">



</form>