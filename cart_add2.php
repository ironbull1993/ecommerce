
<?php
	include 'includes/session.php';

	$conn = $pdo->open();

	$output = array('error'=>false);

	$id = $_POST['id1'];
if(isset($_POST['id1'])){
			try{
				$stmt = $conn->prepare("DELETE FROM cart WHERE id=:id");
				$stmt->execute(['id'=>$id]);
				$output['message'] = 'Deleted';
				
			}
			catch(PDOException $e){
				$output['message'] = $e->getMessage();
			}
		}



        $pdo->close();
        echo json_encode($output);
    
?>