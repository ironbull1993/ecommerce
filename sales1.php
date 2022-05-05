<?php
include 'includes/session.php';
$date = date('Y-m-d');
$set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$code=substr(str_shuffle($set), 0, 12);

    $conn = $pdo->open();

    try{
       
        $stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date) VALUES (:user_id, :pay_id, :sales_date)");
        $stmt->execute(['user_id'=>$user['id'], 'pay_id'=>$code, 'sales_date'=>$date]);
        $salesid = $conn->lastInsertId();
        $qly=$conn->query('UPDATE sales SET delivery_status ="Pending" WHERE  id ='.$salesid);
        
        try{
            $stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
            $stmt->execute(['user_id'=>$user['id']]);

            foreach($stmt as $row){
                $stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
                $stmt->execute(['sales_id'=>$salesid, 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity']]);
            }

            $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
            $stmt->execute(['user_id'=>$user['id']]);

            $_SESSION['success'] = 'Transaction successful. Thank you.';

        }
        catch(PDOException $e){
            $_SESSION['error'] = $e->getMessage();
        }

    }
    catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
    }

    $pdo->close();


header('location: profile.php');

?>