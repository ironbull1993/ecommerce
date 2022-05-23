<?php include 'includes/session.php'; ?>
<?php
  if(isset($_SESSION['user'])){
  
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition register-page">
<div class="register-box">
  
  	<div class="register-box-body">
    	<p class="login-box-msg">Enter contact details</p>

    	<form action="register.php" method="POST">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="fnme" name="firstname" placeholder="Firstname" value="<?php echo (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '' ?>" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="lnme" name="lastname" placeholder="Lastname" value="<?php echo (isset($_SESSION['lastname'])) ? $_SESSION['lastname'] : '' ?>"  required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
      		
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="phon" name="phone" placeholder="phone number" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="adr" name="address" placeholder="e.g Tabata bima" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <!--div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="repassword" placeholder="Retype password" required>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div-->
          <?php
          /* 
            if(!isset($_SESSION['captcha'])){
              echo '
                <di class="form-group" style="width:100%;">
                  <div class="g-recaptcha" data-sitekey="6LevO1IUAAAAAFX5PpmtEoCxwae-I8cCQrbhTfM6"></div>
                </di>
              ';
            }
            */
          ?>
          <hr>
      		<div class="row">
    			<div class="col-xs-4">
          			<button type="submit" id="" class="btn btn-primary btn-block btn-flat" name="signup"><i class="fa fa-pencil"></i> Pay</button>
        		</div>
      		</div>
    	</form>
      <br>
      <!--a href="login.php">I already have a membership</a--><br>
      <a href="index.php"><i class="fa fa-home"></i> Home</a>
  	</div>
</div>
	
<?php include 'includes/scripts.php' ?>
</body>
</html>
<?php
}else{
    header('location: index.php');
  }
  ?>
  
  <script>
  	$(document).on('click', '#pay', function(e){
		e.preventDefault();
		var firstname = $('#fnme).val();
		var lastname = $('#lnme).val();
		var phone = $('#phon).val();
		var address = $('#adr).val();
		
		$.ajax({
			type: 'POST',
			url: 'cart_update.php',
			data: {
				id: id,
				qty: qty,
			},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});
  </script>