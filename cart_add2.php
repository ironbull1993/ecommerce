<?php
	include 'includes/session.php';

	$conn = $pdo->open();

	$output = array('error'=>false);
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$quantity = $_POST['quantity'];
	$now = date('Y-m-d');
	if(!isset($_SESSION['user'])){
	$stmt = $conn->prepare("INSERT INTO users (type, status, created_on) VALUES (0, 1, :now)");
					$stmt->execute(['now'=>$now]);
					$userid = $conn->lastInsertId();
					$_SESSION['user']=$userid;
					//$_SESSION['start'] = time(); // Taking now logged in time.
					// Ending a session in 30 minutes from the starting time.
					//$_SESSION['expire'] = $_SESSION['start'] + (30*60);
				
				}
	if(isset($_SESSION['user'])){


		
		//if(isset($userid)){
		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
		$stmt->execute(['user_id'=>$_SESSION['user'], 'product_id'=>$id]);
		//$stmt->execute(['user_id'=>$userid, 'product_id'=>$id]);
		$row = $stmt->fetch();
		if($row['numrows'] < 1){
			try{
				$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
				$stmt->execute(['user_id'=>$_SESSION['user'], 'product_id'=>$id, 'quantity'=>$quantity]);
			//	$stmt->execute(['user_id'=>$userid, 'product_id'=>$id, 'quantity'=>$quantity]);
			
			$output['message'] = 'Item added to cart';

			//	$date = date('Y-m-d');
			//	$stmt = $conn->prepare("INSERT INTO sales (user_id, sales_date) VALUES (:user_id, :sales_date)");
			//	$stmt->execute(['user_id'=>$_SESSION['user'], 'sales_date'=>$date]);
			//	$salesid = $conn->lastInsertId();
				//$qly=$conn->query('UPDATE sales SET delivery_status ="Pending" WHERE  id ='.$salesid);

				
			}
			catch(PDOException $e){
				$output['error'] = true;
				$output['message'] = $e->getMessage();
			}

		}
		else{
			$output['error'] = true;
			$output['message'] = 'Product already in cart';
		}

			

	}
	else{
		if(!isset($_SESSION['cart'])){
			$_SESSION['cart'] = array();
		}
	
		$exist = array();

		foreach($_SESSION['cart'] as $row){
			array_push($exist, $row['productid']);
		}

		if(in_array($id, $exist)){
			$output['error'] = true;
			$output['message'] = 'Product already in cart';
		}
		else{
			$data['productid'] = $id;
			$data['quantity'] = $quantity;

			if(array_push($_SESSION['cart'], $data)){
				$output['message'] = 'Item added to cart';
			}
			else{
				$output['error'] = true;
				$output['message'] = 'Cannot add item to cart';
			}
		}

	}
	}
	
	if(isset($_POST['id1'])){
		$id = $_POST['id1'];
				try{
					$stmt = $conn->prepare("DELETE FROM cart WHERE id=:id");
					$stmt->execute(['id'=>$id]);
					$output['message'] = 'Deleted';
					
				}
				catch(PDOException $e){
					$output['message'] = $e->getMessage();
				}
			}
	

	$pdo->close();
	echo json_encode($output);

?>