<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$firstname = $_POST['firstname'];
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$contact = $_POST['contact'];

		$conn = $pdo->open();

		
			$password = password_hash($password, PASSWORD_DEFAULT);
			$filename = $_FILES['photo']['name'];
			$now = date('Y-m-d');
			if(!empty($filename)){
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
			}
			try{
				$stmt = $conn->prepare("INSERT INTO users (email, password, type, firstname, contact_info, photo, status, created_on) VALUES (:email, :password,3, :firstname, :contact_info, :photo, :status, :created_on)");
				$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'contact_info'=>$contact, 'photo'=>$filename, 'status'=>1, 'created_on'=>$now]);
				$_SESSION['success'] = 'Driver added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up Driver form first';
	}

	header('location: drivers.php');

?>