<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$id = $_POST['id'];
		$product = $_POST['product'];
		$quantity = $_POST['quantity'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE product_id=:id AND user_id=:usr");
		$stmt->execute(['id'=>$product, 'usr'=>$id]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Product exist in cart';
		}
		else{
			try{
			    $stmt1=$conn->prepare("SELECT * FROM products WHERE id=:pid");
			    $stmt1->execute(['pid'=>$product]);
			    $r=$stmt1->fetch();
			    $p=$r['stock'];
			    if($p<$quantity){
			        $_SESSION['error'] = 'The selected quantity is not available';
			    }else{
				$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user, :product, :quantity)");
				$stmt->execute(['user'=>$id, 'product'=>$product, 'quantity'=>$quantity]);

				$_SESSION['success'] = 'Product added to cart';
			
			}
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();

		header('location: cart.php?user='.$id);
	}

?>