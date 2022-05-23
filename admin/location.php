<?php
include 'includes/session.php';

?>
<?php include 'includes/header.php'; ?>
<meta http-equiv="refresh" content="8" >
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


  <?php include 'includes/navbar.php'; ?>

  
  <?php include 'includes/menubar1.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Orders
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Orders</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="pull-right">
                <form method="POST" class="form-inline" action="sales_print.php">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range">
                  </div>
                  <button type="submit" class="btn btn-success btn-sm btn-flat" name="print"><span class="glyphicon glyphicon-print"></span> Print</button>
                </form>
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>Buyer Name</th>
                  <!--th>Transaction#</th-->
                  <!--th>Amount</th-->
                  <th>Address</th>
                  <th>Phone</th>
                  <!--th>Delivery status</th-->
                  <th>Full Details</th>
                  <th>Get direction</th>
                  <!--th>Confirm order delivery<br><small>Enter transaction code</small></th-->
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();
                   // $stat="Pending";
                    try{
                      //$users = $conn->query("SELECT * FROM users order by name asc");
                      $stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN users ON users.id=sales.user_id ORDER BY salesid DESC");
                      $stmt->execute();

                     

                      foreach($stmt as $row){
                        $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE details.sales_id=:id");
                        $stmt->execute(['id'=>$row['salesid']]);
                        $total = 0;

                        $stat=$row['delivery_status'];
                        $stat1='Pending';
                        $stat2='On progress...';

                        if( $stat== $stat1 || $stat== $stat2){
                        foreach($stmt as $details){
                          $subtotal = $details['price']*$details['quantity'];
                          $total += $subtotal;
                          
                        }
                        echo "
                          <tr>
                            <td class='hidden'></td>
                            <td>".date('M d, Y', strtotime($row['sales_date']))."</td>
                            <td>".$row['firstname'].' '.$row['lastname']."</td>
                            
                            
                            <td>".$row['address']."</td>
                            <td>".$row['contact_info']."</td>
                            
                            <td><button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='".$row['salesid']."'><i class='fa fa-search'></i> View</button></td>
                            
                            
                              
                            <form method='POST'  action='del3.php'>  
                            <input type='hidden' name='pay_id' value='".$row['address']."'>
                            <input type='hidden' name='pay_id1' value='".$row['salesid']."'>
                            <td><button type='submit' name='update' class='btn btn-info btn-sm btn-flat ' > Get direction</button></td>
                            </form>
                            
                            
                            </tr>
                        ";
                      }}
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

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
    <?php include '../includes/profile_modal.php'; ?>

</div>
<!-- ./wrapper -->

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
        //$('#transid').html(response.transaction);
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
</body>
</html>



<form method="POST">
    <p>
        <input type="text" name="address" placeholder="Enter address">
    </p>
 
    <input type="submit" name="submit_address">
</form>


<?php
    if (isset($_POST["submit_address"]))
    {
        $address = $_POST["address"];
        $address = str_replace(" ", "+", $address);
        ?>
 
        <iframe width="100%" height="500" src="https://maps.google.com/maps?q=<?php echo $address; ?>&output=embed"></iframe>
 
        <?php
    }
?>






<?php


    if(isset($_POST['update'])){
		$del = $_POST['transc'];
        $pay = $_POST['pay_id'];
        
       
          
            $conn = $pdo->open();
          

            $stmt = $conn->prepare("SELECT * FROM sales WHERE id=:idd");
            $stmt->execute(['idd'=>$pay]);
            $roww = $stmt->fetch();
            $trans=$roww['pay_id'];
            $userr=$roww['user_id'];
            if($del==$trans){

              $stmt = $conn->prepare("SELECT * FROM users WHERE id=:idi");
              $stmt->execute(['idi'=>$userr]);       
              $roww1 = $stmt->fetch();
              $user=$roww1['firstname'];
              $phone1=$roww1['contact_info'];
            $stmt = $conn->prepare("UPDATE sales SET delivery_status='Delivered' WHERE id=:id");
            $stmt->execute(['id'=>$pay]);
           // $driver=$_SESSION['admin'];
           // $stmt1 =mysqli_query("UPDATE blogEntry SET content ='".$udcontent."', title = '".$udtitle."' WHERE id = '".$id."' ");
            //$stmt1 = $conn->prepare("UPDATE sales SET driver_id=".$driver." WHERE id=:id");
          //$stmt1->execute(['id'=>$pay]);
            //$stmt1 = $conn->prepare("UPDATE sales SET driver_id=:id1 WHERE id=:id");
            //$stmt1->execute(['id'=>$pay, 'id1'=>$_SESSION['admin']]);
            $pay1="Pending";
            $date = date('Y-m-d');
            $set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code=substr(str_shuffle($set), 0, 6);   

           // $stmt = $conn->prepare("INSERT INTO drivers (user_id, del_name, phone, code, pay_status, created_on) VALUES (:user, :delname, :phone, :code, :pay, :datee)");
            //$stmt->execute(['user'=>$_SESSION['admin'], 'delname'=>$user, 'phone'=>$phone, 'code'=>$code, 'pay'=>$pay1, 'datee'=>$date]);
           
            $stmt = $conn->prepare("INSERT INTO drivers (user_id, del_name, phone, code, pay_status, created_on) VALUES (:user, :delname, :phone, :code, :pay, :datee)");
            $stmt->execute(['user'=>$_SESSION['admin'], 'delname'=>$user, 'phone'=>$phone1, 'code'=>$code, 'pay'=>$pay1, 'datee'=>$date]);
          // header('Location: '.$_SERVER['PHP_SELF']);
         // $stmt = $conn->prepare("UPDATE sales SET driver_id=:driver WHERE id=:id");
          //$stmt->execute(['driver'=>$_SESSION['admin'], 'id'=>$pay]);
    }
    else { 


        echo '<script type="text/javascript">  window.onload = function(){
            alert("Transaction code is incorrect");
          }</script>';

            //header("location:location.php");
            
          }
    $pdo->close();
    //header("location:location.php");
        } 
        ?>
