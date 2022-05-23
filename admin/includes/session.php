<?php
	include '../includes/conn.php';
	//if( empty(session_id()) && !headers_sent()){
    session_start();
//}

	if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
		header('location: ../index.php');
		exit();
	}

	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
	$stmt->execute(['id'=>$_SESSION['admin']]);
	$admin = $stmt->fetch();
   // $type=$admin['type'];
	$pdo->close();

?>