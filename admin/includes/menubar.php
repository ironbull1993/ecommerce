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
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo (!empty($admin['photo'])) ? '../images/'.$admin['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $admin['firstname'].' '.$admin['lastname']; ?></p>
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">REPORTS</li>
      <li><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li><a href="sales3.php">
        
      <?php
                    $conn = $pdo->open();
                   
                      $stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN users ON users.id=sales.user_id ORDER BY salesid DESC");
                      $stmt->execute();
                      //$stat=$row['delivery_status'];
                      
                      
                        while($row=$stmt->fetch()):
                          $stat1='Pending';
                          $stat=$row['delivery_status'];
                          if( $stat== $stat1){
                          
                        
                        
      ?>

      <i class='fa fa-money blink_text'></i> 
      
      <?php }
      else{
        ?><i class='fa fa-money'></i>  <?php
      ;}
       break;
      ?><?php endwhile; ?>
      <span>Pending Orders</span></a></li>
      <li><a href="sales.php"><i class="fa fa-money"></i> <span>Sales</span></a></li>
      <li><a href="sales2.php"><i class="fa fa-money"></i> <span>Orders</span></a></li>
      <li class="header">MANAGE</li>
      <li><a href="users.php"><i class="fa fa-users"></i> <span>Customers</span></a></li>
      <li><a href="users1.php"><i class="fa fa-users"></i> <span>Users</span></a></li>
      <li><a href="drivers.php"><i class="fa fa-motorcycle"></i> <span>Drivers</span></a></li>
      <li><a href="payment.php"><i class="fa fa-motorcycle"></i> <span>Payments</span></a></li>
      <li><a href="trader.php"><i class="fa fa-users"></i> <span>Traders</span></a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-barcode"></i>
          <span>Products and Category</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="products.php"><i class="fa fa-circle-o"></i> Product List</a></li>
          <li><a href="category.php"><i class="fa fa-circle-o"></i> Category List</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>