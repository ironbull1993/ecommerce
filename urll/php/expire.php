<?php
include 'config.php';
$sql= mysqli_query($conn,"SELECT * FROM url");
foreach($sql as $row){
      $id=$row['id'];
      //$time=$row['date'];
      $time=date('Y-m-d');
      $datenow=$row['exp_date'];
      //$datenow=date('Y-m-d');
      if($time==$datenow){
        $sql = mysqli_query($conn, "DELETE FROM url WHERE id = ".$id);

        	//Load phpmailer
            //require 'vendor/phpmailer';
            require 'vendor/autoload.php';

            $mail = new PHPMailer(true);                             
            try {
                //Server settings
                $mail->isSMTP();                                     
                $mail->Host = 'smtp.gmail.com';                      
                $mail->SMTPAuth = true;                               
                $mail->Username = 'senderemailhere';     
                $mail->Password = 'youremailpassword';                    
                $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );                         
                $mail->SMTPSecure = 'ssl';                           
                $mail->Port = 465;                                   

                $mail->setFrom('sender emailhere');
                
                //Recipients
                $mail->addAddress('the email to receive notification');              
                $mail->addReplyTo('yoursenderemailhere');
               
                //Content
                $mail->isHTML(true);                                  
                $mail->Subject = 'Link expiration';
                $mail->Body    = "The link has expired";

                $mail->send();

            } 
            catch (Exception $e) {
               echo $mail->ErrorInfo;
                
            }

        if($sql){
            echo "success";

        }else{
            echo "error";
        }
      }

}

?>