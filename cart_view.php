<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<style>
	.blink_text {



animation:1s blinker linear infinite;

-webkit-animation:1s blinker linear infinite;

-moz-animation:1s blinker linear infinite;



 color: red;

}



@-moz-keyframes blinker {  

 0% { opacity: 1.0; }

 50% { opacity: 0.0; }

 100% { opacity: 1.0; }

 }



@-webkit-keyframes blinker {  

 0% { opacity: 1.0; }

 50% { opacity: 0.0; }

 100% { opacity: 1.0; }

 }



@keyframes blinker {  

 0% { opacity: 1.0; }

 50% { opacity: 0.0; }

 100% { opacity: 1.0; }

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
                <div class="callout" id="callout" style="display:none;">
	        			<button type="button" class="close"><span aria-hidden="true">&times;</span></button>
	        			<span class="message"></span>
	        		</div>
	        		<h1 class="page-header">YOUR CART</h1>
	        		<div class="box box-solid">
	        			<div class="box-body">
							
		        		<table class="table table-bordered">
		        			<thead>
		        				<th>Product</th>
		        				
		        				<th>Price &<br> Quantity</th>
		        				
		        				
		        			</thead>
		        			<tbody id="tbody">
		        			</tbody>
							
		        		</table>
						
                            
	        			</div>
	        		</div>
	        		<?php
	        			
	        				echo "
	        					<!--div id='paypal-button'></div-->
								<div>
								<button id='check' style='border-radius:25px;'><a>Checkout</a></button>
								<button style='border-radius:25px; float:right;'><a href='index.php'>Back to products</a></button></div>
	        				";
	        			
						
	        			
	        		?>
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  	<?php $pdo->close(); ?>
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
var total = 0;
$(function(){
	$(document).on('click', '.cart_delete', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: 'cart_delete.php',
			data: {id:id},
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
	
	$(document).on('click', '.minus', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = $('#qty_'+id).val();
		if(qty>1){
			qty--;
		}
		$('#qty_'+id).val(qty);
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


$(document).on('click', '#check', function(e){
		e.preventDefault();
			getTotal();
			if(total==0){
				$('#callout').show();
  			$('.message').html('Your cart is empty please add items.');
			$('#callout').removeClass('callout-danger').addClass('callout-danger');$('#callout').delay(2000).fadeOut();
			}
			else{
			
		   $.ajax({
		type: 'POST',
		url: 'check_products.php',
		dataType: 'json',
		success:function(response){
			output = response;
			if(output==0){
			$('#callout').show();
  			$('.message').html('some items have just been sold out.');
			$('#callout').removeClass('callout-danger').addClass('callout-danger');
			$('#callout').delay(2000).fadeOut();
			getDetails();
			getCart();
			getTotal();
			}else{
		    window.location= 'signup.php'; 
		    }
		}
	});
}
		});
	



	$(document).on('click', '.add', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = $('#qty_'+id).val();
		qty++;
		$('#qty_'+id).val(qty);
		$.ajax({
		type: 'POST',
		url: 'stock_check.php',
		data: {
				id: id,
				qty: qty,
			},
		dataType: 'json',
		success:function(response){
		output = response;
		if(output==qty){
		$('#callout').show();
  		$('.message').html('Sorry..This is the remaining quantity in stock.');
		$('#callout').removeClass('callout-danger').addClass('callout-danger');
		$('#callout').delay(2000).fadeOut();
			       getDetails();
				   //getCart();
				   getTotal();
		}else{
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
		
	}}
	});
});

	getDetails();
	getTotal();

});

function getDetails(){
	$.ajax({
		type: 'POST',
		url: 'cart_details.php',
		dataType: 'json',
		success: function(response){
			$('#tbody').html(response);
			getCart();
		}
	});
}

function getTotal(){
	$.ajax({
		type: 'POST',
		url: 'cart_total.php',
		dataType: 'json',
		success:function(response){
			total = response;
		}
	});
}
</script>
<!-- Paypal Express -->
<script>
paypal.Button.render({
    env: 'sandbox', // change for production if app is live,

	client: {
        sandbox:    'ASb1ZbVxG5ZFzCWLdYLi_d1-k5rmSjvBZhxP2etCxBKXaJHxPba13JJD_D3dTNriRbAv3Kp_72cgDvaZ',
        //production: 'AaBHKJFEej4V6yaArjzSx9cuf-UYesQYKqynQVCdBlKuZKawDDzFyuQdidPOBSGEhWaNQnnvfzuFB9SM'
    },

    commit: true, // Show a 'Pay Now' button

    style: {
    	color: 'gold',
    	size: 'small'
    },

    payment: function(data, actions) {
        return actions.payment.create({
            payment: {
                transactions: [
                    {
                    	//total purchase
                        amount: { 
                        	total: total, 
                        	currency: 'TSH' 
                        }
                    }
                ]
            }
        });
    },

    onAuthorize: function(data, actions) {
        return actions.payment.execute().then(function(payment) {
			window.location = 'sales.php?pay='+payment.id;
        });
    },

}, '#paypal-button');




</script>
</body>
</html>






