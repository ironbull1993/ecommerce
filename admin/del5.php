


<?php
include 'includes/session.php';

    if(isset($_POST['update'])){
		//$pay = $_POST['pay_id'];
        $pay = $_POST["pay_id1"];
       // $stmt = $conn->prepare("UPDATE sales SET delivery_status='On progress...' WHERE id=:id");
        //$stmt->execute(['id'=>$pay]);
           // $conn = $pdo->open();
          
           // $stmt = $conn->prepare("SELECT * FROM sales WHERE pay_id=:id");
           // $stmt->execute(['id'=>$pay]);
           // $row = $stmt->fetch();
            
            //$user=$row['user_id'];
            //$stmt = $conn->prepare("SELECT * FROM users WHERE id=:idd");
            //$stmt->execute(['idd'=>$user]);
            //$roww = $stmt->fetch();
    
           // $address = $roww['address'];
           $address = $_POST["pay_id"];
        $address = str_replace(' ', '+', $address);
    
           
    
        
        
        ?>
 
        <iframe width="100%" height="500" src="https://maps.google.com/maps?q=<?php echo $address; ?>&output=embed"></iframe>
 
        <?php
    } $pdo->close();
?>