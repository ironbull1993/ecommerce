<?php
	include 'includes/session.php';
	$conn = $pdo->open();
	if(isset($_SESSION['user'])){
		try{
      $stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user AND products.stock=0");
			$stmt->execute(['user'=>$_SESSION['user']]);  
          $row=$stmt->fetch();
          $s=$row['stock'];
          $output=$s;
       }
		catch(PDOException $e){
			$output['message'] = $e->getMessage();
		}
	}

	$pdo->close();
	echo json_encode($output);
    ?>