<?php

use ReCaptcha\RequestMethod\Post;

 include 'includes/session.php'; 
ob_start();

//session_destroy();
?>
<?php include 'includes/header.php'; ?>


<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 

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
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        		        	<div class="col-sm-9">
				<div class="callout" id="callout" style="display:none">
	        			<button type="button" class="close"><span aria-hidden="true">&times;</span></button>
	        			<span class="message"></span>
	        		</div>
	        		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		                <ol class="carousel-indicators">
		                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
		                </ol>
		                <div class="carousel-inner">
		                  <div class="item active">
		                    <img src="images/banner1.png" alt="First slide" >
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
						    
						    $stmt = $conn->prepare("SELECT * FROM products");
							$stmt->execute();
						
								while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
									$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
									?>
								
									<form>
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
												?><div class='box-footer' style="background-color: lightgreen;border-radius: 25px;text-align: center;height: 27px;padding-top: 6px; margin-top:23px; ">
                                              <label>Out of Stock </label>
											  </div>
											  <?php
											;}else{
                                              ?><div style="text-align: center;" >
											  <b >Tsh <?php echo $row["price"]; ?></b></div>
											  <input type="hidden" name="quantity" id="qty" class="form-control input-lg" value="1">
														
											  <div class="main">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" id="btn" class="" data-id="<?php echo $row['id'];?>" style="border-radius: 25px;"> Add to Cart</button></div>
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

ob_end_flush();
?>

