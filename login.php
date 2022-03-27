<?php
session_start();
require_once 'cfd.php';

if(isset($_SESSION['user'])){//redirects user if they are loggin already
	header("location: index.php");
}

if(isset($_REQUEST['login']))
	$email = filter_var(strtolower($_REQUEST['email']), FILTER_SANITIZE_EMAIL);//sanatizes user info
	$password = strip_tags($_REQUEST['password']);

	if(empty($email)){
		$errorMsg[] = 'Email is required';
	} else if (empty($password)){
		$errorMsg[] = 'Password is required';
	} else {
		try {
			$select_stmt = $db->prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
			$select_stmt->execute([
			':email' => $email
		]);

		$row = $select_stmt->fetch(PDO::FETCH_ASSOC);

		if($select_stmt->rowCount() > 0){

			if(password_verify($password,$row["password"])){

				$_SESSION['user']['name'] = $row["name"];
				$_SESSION['user']['email'] = $row["email"];
				$_SESSION['user']['id'] = $row["id"];

				header("location: index.php");
			}

		}else {
			$errorMsg[] = 'Wrong Email or Password';
		}//end else 
	}//end try
	catch(PDOException $e){
		echo $e->getMessage();
	}//end catch
		
	}//end else
?>

<form action="login.php" method="post">
<?php 
	if(isset($errorMsg)){
		foreach($errorMsg as $loginError){
			echo "<p>".$loginError."<p>";
		}
		
	}
?>
<label for="email">Email</label>
<input type="email" name="email" id="email" require="">

<label for="password">Password</label>
<input type="password" name="password" id="password" placeholder="password">

<input type="submit" value="submit" name="login">

</form>

