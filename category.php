<?php include 'includes/session.php'; ?>
<?php
	$slug = $_GET['category'];

	$conn = $pdo->open();

	try{
		$stmt = $conn->prepare("SELECT * FROM category WHERE cat_slug = :slug");
		$stmt->execute(['slug' => $slug]);
		$cat = $stmt->fetch();
		$catid = $cat['id'];
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
	}

	$pdo->close();

?>
<?php include 'includes/header.php'; ?>
<style>.main {
  positive:relative;
  
  height:auto;
  width:200px;
  margin-bottom:2px;
  margin-left:10px;
  margin-top:1px;
}

button {
	border: none;
	background: #3c8dbc;
	color: #f2f2f2;
	padding-left: 25px;
	padding-top: 1px;
	font-size: 18px;
	border-radius: 5px;
	position: relative;
	box-sizing: border-box;
	transition: all 500ms ease; 
  overflow:hidden
}

button:before {
	font-family: FontAwesome;
	content:"\f217";
	position: absolute;
	top: 1px;
	left: -30px;
	transition: all 200ms ease;
}

button:hover:before {
	left: 5px;
}

button:hover {
  box-shadow: 1px 3px 8px #000;
}
	</style>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
		            <h1 class="page-header"><?php echo $cat['name']; ?></h1>
		       		<?php
		       			
		       			$conn = $pdo->open();

		       			try{
		       			 	$inc = 3;	
						    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = :catid");
						    $stmt->execute(['catid' => $catid]);
						    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
								$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
								?>
							<div class="col-md-4">
								<form method="post" action="<?php echo$_SERVER['PHP_SELF']; ?>?id=<?php echo $row["id"]; ?>" >
									<div style="border:3px solid #5cb85c; background-color:whitesmoke; border-radius:5px; padding:16px;" align="center">
										<img src="<?php echo $image; ?>" class="img-responsive" /><br />
										<?php
                                          if($row['stock']<=0){
											echo"<h5>".$row['name']."</h5>";
										  } 
										  else{
					                  
									echo"		<h5><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h5>";} ?>
					                        </div>
											<div class='box-footer' >
											
											
											<?php
                                            if($row['stock']<=0){
												?><div class='box-footer' style="background-color: lightgreen;border-radius: 25px;text-align: center;height: 30px;padding-top: 6px; margin-top:23px; ">
                                              <label>Out of Stock </label>
											  </div>
											  <?php
											;}else{
                                              ?><div style="text-align: center;" >
											  <b >Tsh <?php echo $row["price"]; ?></b></div>
											  <input type="hidden" name="quantity" id="quantity" class="form-control input-lg" value="1">
														
											  <input type="hidden" name="id" value="<?php echo $row["id"]; ?>" /><div class="main">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class=""> Add to Cart</button></div>
											<?php
											;}
                                              ?>
									</div>
								</form>
							</div>
							<?php
									}
						}
						catch(PDOException $e){
							echo "There is some problem in connection: " . $e->getMessage();
						}

						$pdo->close();

		       		?> 
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>

<?php
//	include 'includes/session.php';

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
					$_SESSION['user']=$userid;}
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
				$slug = $_GET['category'];
				echo $slug;
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

