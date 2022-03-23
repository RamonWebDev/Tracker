<?php 
session_name('tracker');
session_start();
require("cfd.php");

if(isset($_POST['submit'])) {
    if($_POST['password'] == $_POST['password']){
        $username = $_POST['username'];
        $password = $_POST['password'];

        //creating the salt
        $salt = hash('256', uniqid(mt_rand(), true) . 'ek2lszn456i0qtkgha' . strtolower($username));
        
        //add hash to password
        $hash = $salt . $password;
        
        //mix the salted password a lot
        for($i = 0; $i < 100000; $i++){
            $hash = hash('sha256', $hash);
        }//end for

        $hash = $salt . $hash;
        $isql = "INSERT into login(username, password) values('".$username."','".$hash."')";
        if(mysqli_query($db, $isql)){
            header("Location: login.php?new=true");
        }//end if
    }//end if
}//end if post submit

if(isset($_SESSION['USERNAME'])){
    require('header.php');
    echo "Welcome, " . $_SESSION['USERNAME'] . ", you are logged into our system.";
}else{
    require('header.php');
}
?>

<form action="<?php echo $file;?>" method='post' id='otherlogin'>

    <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="username" require="">

    <label for="password">Password</label>
    <input type="text" id="password" name="password" placeholder="password" require="">

    <input type="submit" id="submit" name="submit" value="Register">



</form>