<?php
	include 'includes/session.php';
	$conn = $pdo->open();
// $id=4;
    //$output = array('error'=>false);
	$id = $_POST['id'];
	//$qty = $_POST['qty'];

	if(isset($_SESSION['user'])){
		try{
           // $output=0;
           $stmt = $conn->prepare("SELECT * FROM cart WHERE id=:ids");
			$stmt->execute(['ids'=>$id]);
            $row=$stmt->fetch();
            $s=$row['product_id'];
            $stmt = $conn->prepare("SELECT * FROM products WHERE id=:idpr");
            $stmt->execute(['idpr'=>$s]);
            $row1=$stmt->fetch();
            $s1=$row1['stock'];
           // if($s1==$qty){
             //   $output['message'] = 'no more';
           // }
            //if($row['numrows'] > 0){
			//foreach($stmt as $row){
                $output=$s1+1;
  //       echo $output;
            //}
		//}
    
    }
		catch(PDOException $e){
			$output['message'] = $e->getMessage();
		}
	}

	$pdo->close();
	echo json_encode($output);
    ?>