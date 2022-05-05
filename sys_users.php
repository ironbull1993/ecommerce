


<?php
  if(!isset($_SESSION['login_id']))
    header('location:login.php');
// include('./header.php'); 
 // include('./auth.php'); 
 ?>

<div class="container-fluid">

	

	<div class="row">

	<div class="col-lg-12">

			<button class="btn btn-primary float-right btn-sm" id="" onclick="openForm()"><i class="fa fa-plus"></i> New user</button>

	</div>

	</div>

	<br>

	<div class="row">

		<div class="card col-lg-12">

			<div class="card-body">

				<table class="table-striped table-bordered col-md-12">

			<thead>

				<tr>

					<th class="text-center">#</th>

					<th class="text-center">Name</th>

					<th class="text-center">Username</th>
					<th class="text-center">Contact</th>


					<th class="text-center">Type</th>

					<th class="text-center">Action</th>

				</tr>

			</thead>

			<tbody>

				<?php

 					include 'db_connect.php';

 					$type = array("","Admin","Staff","Owner");

 					$users = $conn->query("SELECT * FROM users order by name asc");

 					$i = 1;

 					while($row= $users->fetch_assoc()):

				 ?>

				 <tr>

				 	<td class="text-center">

				 		<?php echo $i++ ?>

				 	</td>

				 	<td>

				 		<?php echo ucwords($row['name']) ?>

				 	</td>

				 	

				 	<td>

				 		<?php echo $row['username'] ?>

				 	</td>
                    <td>
					 <?php echo $row['phone'] ?>
				 	</td>
					 <td>

				 		<?php echo $type[$row['type']] ?>

				 	</td>

				 	<td>

				 		<center>

								<div class="btn-group">

								  <button type="button" class="btn btn-primary">Action</button>

								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

								    <span class="sr-only">Toggle Dropdown</span>

								  </button>

								  <div class="dropdown-menu">

								    <!--a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a-->

								    <div class="dropdown-divider"></div>

								    <a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>

								  </div>

								</div>

								</center>

				 	</td>

				 </tr>

				<?php endwhile; ?>

			</tbody>

		</table>

			</div>

		</div>

	</div>



</div>

<script>

	$('table').dataTable();

$('#new_user').click(function(){

	uni_modal('New User','manage_user.php')

})

$('.edit_user').click(function(){

	uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))

})

$('.delete_user').click(function(){

		_conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])

	})

	function delete_user($id){

		start_load()

		$.ajax({

			url:'ajax.php?action=delete_user',

			method:'POST',

			data:{id:$id},

			success:function(resp){

				if(resp==1){

					alert_toast("Data successfully deleted",'success')

					setTimeout(function(){

						location.reload()

					},1500)



				}

			}

		})

	}

</script>







<!DOCTYPE html>

<html>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

body {font-family: Arial, Helvetica, sans-serif;}

* {box-sizing: border-box;}



/* Button used to open the contact form - fixed at the bottom of the page */

.open-button {

  background-color: #555;

  color: white;

  padding: 16px 20px;

  border: none;

  cursor: pointer;

  opacity: 0.8;

  position: fixed;

  bottom: 23px;

  right: 28px;

  width: 280px;

}



/* The popup form - hidden by default */

.form-popup {

  display: none;

  position: fixed;

  bottom: 0;

  right: 15px;

  border: 3px solid #f1f1f1;

  z-index: 9;

}



/* Add styles to the form container */

.form-container {

  max-width: 300px;

  padding: 10px;

  background-color: white;

}



/* Full-width input fields */

.form-container input[type=text], .form-container input[type=password] {

  width: 100%;

  padding: 15px;

  margin: 5px 0 22px 0;

  border: none;

  background: #f1f1f1;

}



/* When the inputs get focus, do something */

.form-container input[type=text]:focus, .form-container input[type=password]:focus {

  background-color: #ddd;

  outline: none;

}



/* Set a style for the submit/login button */

.form-container .btn {

  background-color: #4CAF50;

  color: white;

  padding: 16px 20px;

  border: none;

  cursor: pointer;

  width: 100%;

  margin-bottom:10px;

  opacity: 0.8;

}



/* Add a red background color to the cancel button */

.form-container .cancel {

  background-color: gray;

}



/* Add some hover effects to buttons */

.form-container .btn:hover, .open-button:hover {

  opacity: 1;

}

</style>

</head>

<body>







<div class="form-popup" id="myForm">

  <form action="save_user.php" method="POST" class="form-container">

    <h1>User Details</h1>





	<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">

		<div class="form-group">

			<label for="name">Name</label>

			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>

		</div>

		<div class="form-group">

			<label for="username">Username</label>

			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">

		</div>

		<div class="form-group">

			<label for="username">Phone</label>

			<input type="text" name="phone" id="username" placeholder="e.g 255*********" class="form-control" value="<?php echo isset($meta['phone']) ? $meta['phone']: '' ?>" required  autocomplete="off">

		</div>

		<div class="form-group">

			<label for="password">Password</label>

			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">

			<?php if(isset($meta['id'])): ?>

			<small><i>Leave this blank if you dont want to change the password.</i></small>

		<?php endif; ?>

		</div>

		<?php if(isset($meta['type']) && $meta['type'] == 3): ?>

			<input type="hidden" name="type" value="3">

		<?php else: ?>

		<?php if(!isset($_GET['mtype'])): ?>

		<div class="form-group">

			<label for="type">User Type</label>

			<select name="type" id="type" class="custom-select">

                <option value="3" <?php echo isset($meta['type']) && $meta['type'] == 3 ? 'selected': '' ?>>Owner</option>

				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Staff</option>

				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>

			</select>

		</div>

		<?php endif; ?>

		<?php endif; ?>













   



    <button type="submit" class="btn">Save</button>

    <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>

  </form>

</div>



<script>

function openForm() {

  document.getElementById("myForm").style.display = "block";

}



function closeForm() {

  document.getElementById("myForm").style.display = "none";

}

</script>



</body>

</html>