<?php
	include 'includes/session.php';

	$conn = $pdo->open();

	$output = array('error'=>false);

	$id = $_POST['id'];
	$qty = $_POST['qty'];

	if(isset($_SESSION['user'])){
		try{
			$stmt = $conn->prepare("SELECT * FROM cart WHERE id=:ids");
			$stmt->execute(['ids'=>$id]);
            $row=$stmt->fetch();
            $s=$row['product_id'];
            $stmt = $conn->prepare("SELECT * FROM products WHERE id=:idpr");
            $stmt->execute(['idpr'=>$s]);
            $row1=$stmt->fetch();
            $s1=$row1['stock']+1;
			if($s1>$qty){
			$stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE id=:id");
			$stmt->execute(['quantity'=>$qty, 'id'=>$id]);
			}else{
			$output['message'] = 'no more items in stock';}
		}
		catch(PDOException $e){
			$output['message'] = $e->getMessage();
		}
	}
	else{
		foreach($_SESSION['cart'] as $key => $row){
			if($row['productid'] == $id){
				$_SESSION['cart'][$key]['quantity'] = $qty;
				$output['message'] = 'Updated';
			}
		}
	}

	$pdo->close();
	echo json_encode($output);

?>