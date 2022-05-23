<?php
	include 'includes/session.php';
	
	$conn = $pdo->open();
	$output = '';

	if(isset($_SESSION['user'])){
		
		if(isset($_SESSION['cart'])){
			foreach($_SESSION['cart'] as $row){
				$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
				$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$row['productid']]);
				$crow = $stmt->fetch();
				if($crow['numrows'] < 1){
					$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
					$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$row['productid'], 'quantity'=>$row['quantity']]);
				}
				else{
					$stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE user_id=:user_id AND product_id=:product_id");
					$stmt->execute(['quantity'=>$row['quantity'], 'user_id'=>$user['id'], 'product_id'=>$row['productid']]);
				}
			}
			unset($_SESSION['cart']);
		}

		try{
			

			
			$total = 0;
			$sub1=0;
			$stmt2 = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user AND products.stock=0");
			$stmt2->execute(['user'=>$user['id']]);
			foreach($stmt2 as $rws){
				$sub2=$rws['price']*$rws['quantity'];
				$sub1+=$sub2;
			}
			$stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user");
			$stmt->execute(['user'=>$user['id']]);
			foreach($stmt as $row){
				
			
					if($row['stock']<=0){ 
	
				
				
				$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
				$subtotal = $row['price']*$row['quantity'];
				$total += $subtotal;
				$output .= "
					<tr>

						<td><img src='".$image."' width='30px' height='30px'>".$row['name']."
						<label  class='blink_text'>Sold Out</label>
						<button type='button' data-id='".$row['cartid']."' style='border-radius: 30px;border-style:hidden;background-color:white; float:right;' class='btn btn-danger btn-flat cart_delete'><i style='color:red;' class='fa fa-trash'></i></button></td>
						
						<td>Tsh &nbsp; ".number_format($row['price'], 2)."/=<!--span class='input-group-btn'>
						<button type='button' id='minus' style='border-radius: 30px; border-style:hidden;background-color:white;float:left;' class='btn btn-default btn-flat minus' data-id='".$row['cartid']."'><i class='fa fa-minus'></i></button>
					
					
					
						<button type='button' id='add' style='border-radius: 30px; ' class='btn btn-default btn-flat add' data-id='".$row['cartid']."'><i class='fa fa-plus'></i>
						</button><input type='text' style='width: 35px; border-radius: 30px; text-align:center;'  class='form-control' value='".$row['quantity']."' id='qty_".$row['cartid']."'>
					</span-->
				</td>
						
						<!--td>Tsh &nbsp; ".number_format($subtotal, 2)."/=</td-->
					</tr>
					
				";
			}else{
				$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
				$subtotal = $row['price']*$row['quantity'];
				$total += $subtotal;
				$output .= "
					<tr>

						<td><img src='".$image."' width='30px' height='30px'>".$row['name']."<button type='button' data-id='".$row['cartid']."' style='border-radius: 30px;border-style:hidden;background-color:white; float:right;' class='btn btn-danger btn-flat cart_delete'><i style='color:red;' class='fa fa-trash'></i></button></td>
						
						<td>Tsh &nbsp; ".number_format($subtotal, 2)."/=<span class='input-group-btn'>
						<button type='button' id='minus'style='border-radius: 30px; border-style:hidden;background-color:white;float:left;' class='btn btn-default btn-flat minus' data-id='".$row['cartid']."'><i class='fa fa-minus'></i></button>
					
					
					
						<button type='button' id='add' style='border-radius: 30px; border-style:hidden;background-color:white;float:left;' class='btn btn-default btn-flat add' data-id='".$row['cartid']."'><i class='fa fa-plus'></i>
						</button><input type='text'style='border-radius: 30px; border-style:hidden;background-color:white;float:right;'  class='form-control' value='".$row['quantity']."' id='qty_".$row['cartid']."'>
					</span></td>
						
						<!--td>Tsh &nbsp; ".number_format($subtotal, 2)."/=</td-->
					</tr>
					
				";
		}
				
			}
			$output .= "
				<tr>
					<td colspan='5' align='center'><b>Total</b>&nbsp;<b>Tsh &nbsp; ".number_format($total-$sub1, 2)."/=</b></td>
					
				<tr>
			";

		}
		catch(PDOException $e){
			$output .= $e->getMessage();
		}

	}
	else{
		if(count($_SESSION['cart']) != 0){
			$total = 0;
			foreach($_SESSION['cart'] as $row){
				$stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
				$stmt->execute(['id'=>$row['productid']]);
				$product = $stmt->fetch();
				$image = (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg';
				$subtotal = $product['price']*$row['quantity'];
				$total += $subtotal;
				$output .= "
					<tr>
						<td><button type='button' data-id='".$row['productid']."' class='btn btn-danger btn-flat cart_delete'><i class='fa fa-remove'></i></button></td>
						<td><img src='".$image."' width='30px' height='30px'></td>
						<td>".$product['name']."</td>
						<td>Tsh &nbsp; ".number_format($product['price'], 2)."/=</td>
						<td class='input-group'>
							<span class='input-group-btn'>
            					<button type='button' id='minus' class='btn btn-default btn-flat minus' data-id='".$row['productid']."'><i class='fa fa-minus'></i></button>
            				</span>
            				<input type='text' class='form-control' value='".$row['quantity']."' id='qty_".$row['productid']."'>
				            <span class='input-group-btn'>
				                <button type='button' id='add' class='btn btn-default btn-flat add' data-id='".$row['productid']."'><i class='fa fa-plus'></i>
				                </button>
				            </span>
						</td>
						<td>Tsh &nbsp; ".number_format($subtotal, 2)."/=</td>
					
					</tr>
					

				";
				
			}

			$output .= "
				<tr> <span class='input-group-btn'>
	
					<td colspan='5' align='right'><b>Total</b></td>
					<td><b>Tsh &nbsp; ".number_format($total, 2)."/=</b></td>
				<tr>
			";
		}

		else{
			$output .= "
				<tr>
					<td colspan='6' align='center'>Shopping cart empty</td>
				<tr>
			";
		}
		
	}

	$pdo->close();
	echo json_encode($output);

?>

