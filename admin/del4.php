<?php
include 'includes/session.php';

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
            header("location:location.php");
           // $row = $stmt->fetch();
            
            //$user=$row['user_id'];
            //$stmt = $conn->prepare("SELECT * FROM users WHERE id=:idd");
            //$stmt->execute(['idd'=>$user]);
            //$roww = $stmt->fetch();
    
           // $address = $roww['address'];
           
    
           
    }
    else { 


        echo '<script type="text/javascript">  window.onload = function(){
            alert("Code is incorrect");
          }</script>';

            //header("location:location.php");
            
          }
    $pdo->close();
    //header("location:location.php");
        } 
        ?>
