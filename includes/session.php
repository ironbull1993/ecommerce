<?php
	include 'includes/conn.php';
    //session_cache_limiter('private, must-revalidate');
//session_cache_expire(60);
	session_start();
    /*
if(isset($_SESSION['user'])){
 $now = time(); // Checking the time now when home page starts.

 if ($now > $_SESSION['expire']) {
	$conn = $pdo->open();
	$iid = $_SESSION['user'];
	$stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id1");
	$stmt->execute(['user_id1'=>$iid]);
	
	$stmt = $conn->prepare("DELETE FROM users WHERE id=:user_id");
	$stmt->execute(['user_id'=>$iid]);
	 session_destroy();
	 $pdo->close();
	 Header("Location: index.php");
 }}
 */
	if(isset($_SESSION['admin'])){
		header('location: admin/home.php');
	}



	if(isset($_SESSION['user'])){
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
			$stmt->execute(['id'=>$_SESSION['user']]);
			$user = $stmt->fetch();
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

		$pdo->close();
	}

	
?>