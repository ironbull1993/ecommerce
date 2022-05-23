<?php include 'includes/session.php'; ?>

<?php include 'includes/header.php'; ?>
<body class="hold-transition register-page">
<div class="register-box">
  	
  	<div class="register-box-body">
    	<p class="login-box-msg">Enter tracking code</p>

    	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="name" placeholder="transaction id" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          
          <hr>
      		<div class="row">
    			<div class="col-xs-4">
          			<button type="submit" class="btn btn-primary btn-block btn-flat" name="signup"><!--i class="fa fa-pencil"></i--> Track</button>
        		</div>
      		</div>
    	</form>
      <br>
      <!--a href="login.php">I already have a membership</a--><br>
      <a href="index.php"><i class="fa fa-home"></i> Home</a>
  	</div>
    <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>Buyer Name</th>
                  <th>Transaction#</th>
                  <th>Amount</th>
                  <th>Address</th>
                  <th>Phone</th>
                  <th>Delivery status</th>
                  <th>Full Details</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();
                   // $stat="Pending";


                   if(isset($_POST['name'])){
                    $id = $_POST['name'];
                   
                    
                    try{
                      //$users = $conn->query("SELECT * FROM users order by name asc");
                      $stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN users ON users.id=sales.user_id WHERE sales.pay_id=:id1");
                      $stmt->execute(['id1'=>$id]);

                      foreach($stmt as $row){
                        $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE details.sales_id=:id");
                        $stmt->execute(['id'=>$row['salesid']]);
                        $total = 0;
                        foreach($stmt as $details){
                          $subtotal = $details['price']*$details['quantity'];
                          $total += $subtotal;
                          
                        }
                        echo "
                          <tr>
                            <td class='hidden'></td>
                            <td>".date('M d, Y', strtotime($row['sales_date']))."</td>
                            <td>".$row['firstname'].' '.$row['lastname']."</td>
                            <td>".$row['pay_id']."</td>
                            <td>Tsh &nbsp; ".number_format($total, 2)."/=</td>
                            <td>".$row['address']."</td>
                            <td>".$row['contact_info']."</td>
                            <td>".$row['delivery_status']."</td>
                            <td><button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='".$row['salesid']."'><i class='fa fa-search'></i> View</button></td>
                            
                           
                            
                           
                            
                            
                            </tr>
                        ";
                   }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }}

                    $pdo->close();
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>
   
    <?php include 'includes/profile_modal.php'; ?>
</div>
<!-- ./wrapper -->
</div>
</body>
</html>



<?php include 'includes/scripts.php'; ?>
<!-- Date Picker -->
<script>
$(function(){
  //Date picker
  $('#datepicker_add').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })
  $('#datepicker_edit').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })

  //Timepicker
  $('.timepicker').timepicker({
    showInputs: false
  })

  //Date range picker
  $('#reservation').daterangepicker()
  //Date range picker with time picker
  $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
  //Date range as a button
  $('#daterange-btn').daterangepicker(
    {
      ranges   : {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate  : moment()
    },
    function (start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    }
  )
  
});
</script>
<script>



$(document).on('click', '.edit1', function(e){
  e.preventDefault();
  //$('#edit').modal('show');
  var id = $(this).data('id');
  getRow(id);
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'delivery.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
     
    }
  });
}


$(function(){
  $(document).on('click', '.transact', function(e){
    e.preventDefault();
    $('#transaction').modal('show');
    var id = $(this).data('id');
    $.ajax({
      type: 'POST',
      url: 'transact.php',
      data: {id:id},
      dataType: 'json',
      success:function(response){
        $('#date').html(response.date);
        $('#transid').html(response.transaction);
        $('#detail').prepend(response.list);
        $('#total').html(response.total);
      }
    });
  });

  $("#transaction").on("hidden.bs.modal", function () {
      $('.prepend_items').remove();
  });
});
</script>

