<?php 
	include 'includes/session.php';

	if(isset($_POST['update'])){
		$pay = $_POST['pay_id'];
		//if($id==24){
		$conn = $pdo->open();
        $qly=$conn->query('UPDATE sales SET delivery_status ="Delivered" WHERE  id ='.$pay);
         header("location:sales3.php");
		//$stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
		//$stmt->execute(['id'=>$id]);
		//$row = $stmt->fetch();
		
		$pdo->close();

		//echo json_encode($row);
	}
?>