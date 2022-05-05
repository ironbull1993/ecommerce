<?php
include 'includes/session.php';

?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


  <?php include 'includes/navbar.php'; ?>

  
  <?php include 'includes/menubar1.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        My Orders
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">My Orders</li>
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
                  <th>Pay code</th>
                  <!--th>Transaction#</th-->
                  <!--th>Amount</th-->
                  <th>Delivered to</th>
                  <th>Phone</th>
                  <th>Pay status</th>
                  
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();
                
                    try{
                        $stmt = $conn->prepare("SELECT * FROM drivers WHERE user_id=:idd");
                        $stmt->execute(['idd'=>$_SESSION['admin']]);
                       // $roww = $stmt->fetch();
                // $trans=$roww['pay_id'];
                foreach($stmt as $roww){
                     

                     
                        echo "
                          <tr>
                            <td class='hidden'></td>
                            <td>".date('M d, Y', strtotime($roww['created_on']))."</td>
                            <td>".$roww['code']."</td>
                            
                            <td>".$roww['del_name']."</td>
                            <td>".$roww['phone']."</td>
                            <td>".$roww['pay_status']."</td>
                           
                            </tr>
                        ";
                      
                    }}
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
            if($del==$trans){

            

            $stmt = $conn->prepare("UPDATE sales SET delivery_status='Delivered' WHERE id=:id");
            $stmt->execute(['id'=>$pay]);
           // header("location:location.php");
           // $row = $stmt->fetch();
            
            //$user=$row['user_id'];
            //$stmt = $conn->prepare("SELECT * FROM users WHERE id=:idd");
            //$stmt->execute(['idd'=>$user]);
            //$roww = $stmt->fetch();
    
           // $address = $roww['address'];
           
           header('Location: '.$_SERVER['PHP_SELF']);
           
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
