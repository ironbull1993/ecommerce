<?php
	
	include 'includes/session.php';

	if(isset($_POST['signup'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		//$email = $_POST['email'];
		//$password = $_POST['password'];
		//$repassword = $_POST['repassword'];

		$_SESSION['firstname'] = $firstname;
		$_SESSION['lastname'] = $lastname;
		//$_SESSION['email'] = $email;
/*
		if(!isset($_SESSION['captcha'])){
			require('recaptcha/src/autoload.php');		
			$recaptcha = new \ReCaptcha\ReCaptcha('6LevO1IUAAAAAFCCiOHERRXjh3VrHa5oywciMKcw', new \ReCaptcha\RequestMethod\SocketPost());
			$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

			if (!$resp->isSuccess()){
		  		$_SESSION['error'] = 'Please answer recaptcha correctly';
		  		header('location: signup.php');	
		  		exit();	
		  	}	
		  	else{
		  		$_SESSION['captcha'] = time() + (10*60);
		  	}

		}
*/
	//	if($password != $repassword){
		//	$_SESSION['error'] = 'Passwords did not match';
		//	header('location: signup.php');
	//	}
	//	else{
			$conn = $pdo->open();

		//	$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE email=:email");
		//	$stmt->execute(['email'=>$email]);
		//	$row = $stmt->fetch();
		//	if($row['numrows'] > 0){
		//		$_SESSION['error'] = 'Email already taken';
		//		header('location: signup.php');
		//	}
			//else{
				$now = date('Y-m-d');
			//	$password = password_hash($password, PASSWORD_DEFAULT);

				//generate code
				$set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$code=substr(str_shuffle($set), 0, 12);

/*
				$stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, activate_code, created_on) VALUES (:email, :password, :firstname, :lastname, :code, :now)");
				$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'code'=>$code, 'now'=>$now]);
				$userid = $conn->lastInsertId();

				$message = "
					<h2>Thank you for Registering.</h2>
					<p>Your Account:</p>
					<p>Email: ".$email."</p>
					<p>Password: ".$_POST['password']."</p>";
					header('location: login.php');
				}
			}
*/
				try{
				//	$stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, activate_code, created_on) VALUES (:email, :password, :firstname, :lastname, :code, :now)");
				//	$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'code'=>$code, 'now'=>$now]);
				//	$userid = $conn->lastInsertId();




				$iid = $_SESSION['user'];
				$stmt = $conn->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, address = :address, contact_info= :contact, activate_code= :code WHERE id=".$iid);
					//$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, address, contact_info,  activate_code) VALUES (firstname, :lastname, :address, :contact, :code)");
					$stmt->execute(['firstname'=>$firstname, 'lastname'=>$lastname, 'address'=>$address, 'contact'=>$phone, 'code'=>$code]);
					//$iid = $_SESSION['user'];




					
					$date = date('Y-m-d');
					$set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
									$code=substr(str_shuffle($set), 0, 12);
					
					//	$conn = $pdo->open();
					
						try{
							$iid = $_SESSION['user'];
							$stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date) VALUES (:user_id, :pay_id, :sales_date)");
							$stmt->execute(['user_id'=>$iid, 'pay_id'=>$code, 'sales_date'=>$date]);
							$salesid = $conn->lastInsertId();
							$qly=$conn->query('UPDATE sales SET delivery_status ="Pending" WHERE  id ='.$salesid);
							
							
							$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
							$stmt->execute(['user_id'=>$iid, 'product_id'=>$id]);
							//$stmt->execute(['user_id'=>$userid, 'product_id'=>$id]);
							$row = $stmt->fetch();
						

							try{$iid = $_SESSION['user'];
								$stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
								$stmt->execute(['user_id'=>$iid]);
					
								foreach($stmt as $row){
									
									$stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
									$stmt->execute(['sales_id'=>$salesid, 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity']]);
								$proid=$row['product_id'];
								$qntty=$row['quantity'];
								
								
								$stmt1= $conn->prepare("SELECT * FROM products WHERE id=:id1");
								$stmt1->execute(['id1'=>$proid]);
								$row4 = $stmt1->fetch();
								
								$tot=$qntty*$row4['price'];
								
								
								         try{
									$stmt = $conn->prepare("INSERT INTO sales_perday (product_id, qnty_sold, amount, date) VALUES (:product_id, :quantity, :amt, :dt)");
									$stmt->execute(['product_id'=>$row['product_id'], 'quantity'=>$qntty, 'amt'=>$tot, 'dt'=>$date]);
								}catch(PDOException $e){
									$_SESSION['error'] = $e->getMessage();
								}

								
								
								
								
								
								$stmt1= $conn->prepare("SELECT stock FROM products WHERE id=:id1");
								$stmt1->execute(['id1'=>$proid]);
								foreach($stmt1 as $rw){
									$stck=$rw['stock'];
									$remain=$stck-$qntty;
                                    $qly=$conn->query('UPDATE products SET stock ='.$remain.' WHERE  id ='.$proid); 

								}
								
								}
								$iid = $_SESSION['user'];
								$stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
								$stmt->execute(['user_id'=>$iid]);
					
								session_start();
	                            session_destroy();
								//echo '<script type="text/javascript">  window.onload = function(){
								//	alert("Transaction successful");
							//	  }</script>';
	                            header('location: index.php');
							//	$_SESSION['success'] = 'Transaction successful. Thank you.';
					
							}
							catch(PDOException $e){
								$_SESSION['error'] = $e->getMessage();
							}
					
						}
						catch(PDOException $e){
							$_SESSION['error'] = $e->getMessage();
						}
					
						$pdo->close();
					
					
					//header('location: profile.php');
					
					




				//	echo '<script type="text/javascript">  window.onload = function(){
				//		alert("Transaction successful");
				//	  }</script>';
				
		/*		
				// SEND SMS
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'https://sms.arkesel.com/api/v2/sms/send',
    CURLOPT_HTTPHEADER => ['api-key: c1R0bldlVFZ6emdaREdNWmtHZEU'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => http_build_query([
        'sender' => 'VESSEL TZ',
        'message' => 'YOU HAVE NEW ORDERS',
        'recipients' => ['255743997716', '255769559466']
    ]),
]);

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
				*/
					  header('location: index.php');

						$pdo->close();
				//	}

				}
				catch(PDOException $e){
					$_SESSION['error'] = $e->getMessage();
					//if(isset($_SESSION['user'])){
					//	header('location: cart_view.php');
					 // }
				}

				$pdo->close();

			//}}

		

//$pdo->close();
	}
	
	else{
		$_SESSION['error'] = 'Fill up signup again theres problem';
		header('location: signup.php');
	}

?>