<?php

use ReCaptcha\RequestMethod\Post;

 include 'includes/session.php'; 


//session_destroy();
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
	        		<?php
	        			if(isset($_SESSION['error'])){
	        				echo "
	        					<div class='alert alert-danger'>
	        						".$_SESSION['error']."
	        					</div>
	        				";
	        				unset($_SESSION['error']);
	        			}
	        		?>
	        		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		                <ol class="carousel-indicators">
		                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
		                </ol>
		                <div class="carousel-inner">
		                  <div class="item active">
		                    <img src="images/banner1.png" alt="First slide">
		                  </div>
		                  <div class="item">
		                    <img src="images/banner2.png" alt="Second slide">
		                  </div>
		                  <div class="item">
		                    <img src="images/banner3.png" alt="Third slide">
		                  </div>
		                </div>
		                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
		                  <span class="fa fa-angle-left"></span>
		                </a>
		                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
		                  <span class="fa fa-angle-right"></span>
		                </a>
		            </div>

		            <!--h2>Monthly Top Sellers</h2-->
					<h2>Products</h2>
		       		<?php
		       			$month = date('m');
		       			$conn = $pdo->open();

		       			try{
		       			 	$inc = 3;	
						    //$stmt = $conn->prepare("SELECT *, SUM(quantity) AS total_qty FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date) = '$month' GROUP BY details.product_id ORDER BY total_qty DESC LIMIT 6");
						    $stmt = $conn->prepare("SELECT * FROM products");
							$stmt->execute();
							//$row = $stmt->fetch();
		                    //if($row['numrows'] > 0){
						    //foreach ($stmt as $row) {
								while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
									$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
									?>
								
									<form method="post" action="<?php echo$_SERVER['PHP_SELF']; ?>?id=<?php echo $row["id"]; ?>" >
									<div class='col-sm-3' id="taken" >
	       								<div class='box box-solid'>
		       								<div class='box-body prod-body' >
                          
											<img src="<?php echo $image; ?>" width='100%' height='150px' class='thumbnail' />
					                     <?php
                                          if($row['stock']<=0){
											echo"<h5>".$row['name']."</h5>";
										  } 
										  else{
					                  
									echo"		<h5><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h5>";} ?>
					                        </div>
											<div class='box-footer' style="margin-top:0%;">
											
											
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
										</div>
										</div>

									</form>
								
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
<script>
$(document).ready(function(){
	//$('.checkbox').prop('checked', true);
    $("#productForm").on("change", "input:checkbox", function(){
        $("#productForm").submit();
    });
});
</script>
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

