<?php
session_name('tracker');
session_start();
require("cfd.php");

if($_POST['submit'] && $_POST['submit'] == "Login"){
	//get the username and password from the form
	$username = $_POST['username'];
	$password = $_POST['password'];
	//get the details related to the account in the query
	$sql = 'SELECT password, username, ulvl FROM login WHERE username = "' . mysqli_real_escape_string($db, $username) . '" LIMIT 1;';
	//run the query
	$r = mysqli_fetch_assoc(mysqli_query($db, $sql));
    //get salted and hash password from database
	$salt = substr($r['password'], 0, 64);
	// add the salt to the provided password
	$hash = $salt . $password;
	// Hash the password as we did before
	for($i = 0; $i < 100000; $i ++ ) {
		$hash = hash('sha256', $hash);
	} // end for
	// add the salt back to the hashed password
	$hash = $salt . $hash;
	//making sure passwords matched
	if($hash == $r['password'] ){
		// Ok! we have a match
		// move the username into the session username
		$_SESSION['USERNAME'] = $r['username'];
		if($r['ulvl'] == 1) {
			$_SESSION['ADMINSTATUS'] = 1;
		}else if($r['ulvl'] == 2){
			$_SESSION['ADMINSTATUS'] = 2;
		}else{
			$_SESSION['ADMINSTATUS'] = 0;
		} //end if admin checkdate
		if(isset($_GET['url'])){
			header("Location: " . $_GET['url']);
		} else{
			if($_SESSION['ADMINSTATUS'] >= 1){
				header("Location: admin.php");
			}else{
				header("Location: userhome.php");
			} //end if
		}//end if
	}else{
		header("Location: login.php?error=1");
	} //end if
} else { //this display if it is not a login attempt
	if(isset($_GET['error'])){ //if there is an error in the login process
		$msg = "<h2 class='alert alert-danger'>Incorret login, please try again!</h2>";
	} //end if isset new
require('header.php');
// after a success login.
if(isset($_GET['url'])){
	$file = "login.php?url=" . $_GET['url'];
}else{
	$file = "login.php";
} // end if
?>

<form action="<?php echo $file;?>" method="POST" id="otherlogin">

<label for="username">Username</label>
<input type="text" name="username" id="username" require="">

<label for="password">Password</label>
<input type="password" name="password" id="password" placeholder="password">

<input type="submit" value="submit" name="submit">

</form>

<?php
}
?>