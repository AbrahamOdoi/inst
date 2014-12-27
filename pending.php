<?php
session_start();
date_default_timezone_set('GMT');

if (isset($_SESSION['user'])) {
	$user_sess = $_SESSION['user'];
} else {
	header('Location: index.php');
}
require_once ('core/connection.php');
require_once ('core/functions.php');

// $con = mysqli_connect("localhost", "root", "", "dlr");

if (isset($_POST['save'])) {
	$appointment = $_POST['appdate'];
	$id = $_POST['id'];
	$name = $_POST['aname'];
	$number = $_POST['amobile'];

$firstletter = $number[0];
	$secondletter = $number[1];
	$numcode = $firstletter . $secondletter;
	if ($firstletter == '+') {
		$number = substr($number, 1);
	} elseif ($numcode == 00) {
		$number = substr($number, 2);
	} elseif ($firstletter == 0 && $secondletter !== 0) {
		$remove = substr($number, 1);
		$number = '233' . $remove;
	}
	
	$message= "Hello $name, your Appointment has been scheduled for $appointment.";
	
	$msg=urlencode($message);
	
	$url="curl 'api.nalosolutions.com/bulksms/?username=instania&password=nalosol&type=0&dlr=1&destination=$number&source=IHS&message=$msg'";
// file_get_contents($url);

$out=shell_exec($url);
echo "out: ".$out;
exit;
	$query1 = "UPDATE appointments SET appdate='$appointment', status='scheduled' WHERE id='$id'";
	//includes pass
	if (mysqli_query($con, $query1)) {
		?>
		<script>
			alert('Appointment date set successfully');
		</script>
<?php
$msisdn = msisdn_prep($mobile);
$network = which_network($msisdn);
$msgs = "Dear $n_username,
		$url=api.nalosolutions.com/bulksms/?username=sam&password=nalosol&type=0&dlr=1&destination=233249430715&source=UBA&message=TESTING
		
Your password has been successfully updated. Your new password is $password, Kindly install our mobile application for booking appointments";
}
}
?>
<html>
<head>
	<title>Instania Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/dashboard.css" rel="stylesheet">
	<link type="text/css" href="css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
	<link type="text/css" href="DataTables/media/css/jquery.dataTables.css" rel="stylesheet" />


	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
		<link href="js/datetimepicker/jquery.datetimepicker.css" rel="stylesheet">
<style type="text/css">
	/* css for timepicker */
	.ui-timepicker-div .ui-widget-header {
		margin-bottom: 8px;
	}
	.ui-timepicker-div dl {
		text-align: left;
	}
	.ui-timepicker-div dl dt {
		float: left;
		clear: left;
		padding: 0 0 0 5px;
	}
	.ui-timepicker-div dl dd {
		margin: 0 10px 10px 45%;
	}
	.ui-timepicker-div td {
		font-size: 90%;
	}
	.ui-tpicker-grid-label {
		background: none;
		border: none;
		margin: 0;
		padding: 0;
	}

	.ui-timepicker-rtl {
		direction: rtl;
	}
	.ui-timepicker-rtl dl {
		text-align: right;
		padding: 0 5px 0 0;
	}
	.ui-timepicker-rtl dl dt {
		float: right;
		clear: right;
	}
	.ui-timepicker-rtl dl dd {
		margin: 0 45% 10px 10px;
	}
		</style>
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top" style="top:0px;width:100%;" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- <a class="navbar-brand" href="#">User Management</a> -->
				<div>
					<h1 style="color:#178FE5;">Instania Health</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid" style="margin-top:50px;">
		<div class="row">			
			<div class="col-sm-3 col-md-2 sidebar" style="margin-top:40px;">
				<ul class="nav nav-sidebar">
					<li class="mfold">
						<a href="home.php">Manage Patients</a>
					</li>
					<li class="mfold active">
						<a href="">Pending Requests</a>
					</li>
					<li class="mfold">
						<a href="upcoming.php">Upcoming Appointments</a>
					</li>
				</ul>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<div class="pull-right" style="margin-right:35px;">
					<a class="inverse" style="text-decoration: none;"><i class='glyphicon glyphicon-user' style="color: green;"></i> <?php echo $user_sess; ?></a> |  <a type="button" href="logout.php" style="text-decoration: none;"><i class="glyphicon glyphicon-off" style="color: red;"></i> logout</a>
				</div>
				<div class="pull-left" style="margin-left:35px;">
					<a class="btn btn-info" href="adminlanding.php"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
					<a class="btn btn-info" href="#example"><i class="glyphicon glyphicon-list"></i> Users</a>
				</div><br /><br /><br />


				<div class="container-fluid">
</div>
<hr />

<?php
if (isset($_SESSION['alert'])) {
	echo '<br />';
	$type = $_SESSION['type'];
	$msg = $_SESSION['alert'];
	echo show_alert($type, $msg);
	unset($_SESSION['type']);
	unset($_SESSION['alert']);
}
?>
<!-- <table class="table table-striped table-bordered table-hover table-condensed"> -->
<table id="example" class="display" cellspacing="0" width="100%" style="font-size:13px;">
	<thead>
		<tr style="font-size:0.8em;">
			<th>Full Name</th>
			<th>Action</th>
			<th>Mobile Number</th>
			<th>Requested Date</th>
		</tr>
	</thead>
	<tbody id="tbody" style="font-size:0.9em;">

		<?php

		$sql = "SELECT * FROM appointments where status='Pending' order by requestdate ASC;";


		$result = mysqli_query($con,$sql);
		while($row=mysqli_fetch_assoc($result))
		{ 
			$id = $row['id'];
			$name = $row['name'];
			$mobile = $row['mobile'];
			$requested = $row['requestdate'];

				?>
				<tr>
					<td><?php echo $name; ?></td>
					<td><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" 
						onclick="conf_edit('<?php echo $name; ?>','<?php echo $mobile; ?>','<?php echo $id; ?>')">
						<i class="glyphicon glyphicon-pencil"></i></button>
					</td>
					<td><?php echo $mobile; ?></td>
					<td><?php echo $requested; ?></td>
						
					</td>
				</tr>
				<?php
				}
		?>

	</tbody>
</table>
</div>
</div>
</div>
		<div class="modal fade bs-example-modal-sm" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
					</div>
					<div class="modal-body">
						Are you sure you want to delete <strong><span id="del_span"></span></strong>?
					</div>
					<div class="modal-footer">
						<form action="" method="post" class="form-inline" role="form"> 
							<button type="button" class="btn btn-success" data-dismiss="modal">No</button>
							<input type="hidden" id="id_hidden" name="id_hidden">
							<button type="submit" name="conf_del" class="btn btn-danger">Yes</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myLargeModalLabel">
							SET APPOINTMENT DATE
						</h4>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<form class="form-horizontal" action="" role="form" method="post">
									<div class="col-md-6">
										<div class="form-group">
											<label for="sender_single" class="col-sm-4 control-label">DATE</label>
											<div class="col-sm-8">
												<input type="hidden" class="form-control" name="id" id="appid" >
												<input type="hidden" class="form-control" name="aname" id="aname" >
												<input type="hidden" class="form-control" name="amobile" id="amobile" >
												<input type="text" class="form-control" name="appdate" id="txtappdatt" >
											</div>
										</div>
									</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="submit" class="btn btn-primary" name="save">Save Changes</button>
</form>
</div>
</div>
</div>
</div>


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="js/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script>
<script type="text/javascript" src="DataTables/media/js/jquery.dataTables.js"></script>
		<script src="js/datetimepicker/jquery.datetimepicker.js" type="text/javascript"></script>


<script>
	$(function() {
		$.datepicker.setDefaults({
			dateFormat : "yy-mm-dd"
		});
		$('#txtappdatt').datetimepicker({

			hours12 : false,
			format : 'Y-m-d H:i:s',
			step : 1,
			opened : false,
			validateOnBlur : false,
			closeOnDateSelect : false,
			closeOnTimeSelect : false,
			minDate : 0,
			minTime : 0
		});
	}); 
</script>

<script>
	$(function() {
		$(".btnsavenew").click(function() {
			var classs = $(this).attr('id');
			var dates = $('#txtappdate').val();
			alert(classs);
			alert(dates);
		});
	}); 
</script>

<!-- <script>
	$(function() {
		$("#txtappdat").datepicker();
	});
</script> -->

<script>
	$(document).ready(function() {
		// $('#example').dataTable( { "Dom ": 'T<"clear ">lfrtip', "TableTools ": { "aButtons ": [ "csv " ] } } );
		$('#example').DataTable({

		});
	});
</script>

<script type="text/javascript">
	function conf_edit(name, mobile, id) {
		$('#appid').val(id);
		$('#aname').val(name);
		$('#amobile').val(mobile);
	}
		</script>

		<script>
			function conf_delete(id, name) {
				$('#id_hidden').val(id);
				$('#del_span').text(name);
			}
		</script>
	</body>
	</html>