<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con,$select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

?>

<!DOCTYPE html>

<html>

<head>

<title> ezonset / Manage Requests </title>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="author" content="Mohammed Tahir Ahmed">

<link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet" >

<link href="../styles/bootstrap.min.css" rel="stylesheet">

<link href="../styles/style.css" rel="stylesheet">

<link href="../styles/user_nav_style.css" rel="stylesheet">

<!--- stylesheet width modifications --->

<link href="../styles/custom.css" rel="stylesheet">

<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">

<script src="../js/jquery.min.js"></script>

</head>

<body>

<?php include("../includes/user_header.php"); ?>

<div class="container-fluid mt-5"><!-- container-fluid mt-5 Starts -->

<div class="row"><!-- row Starts -->

<div class="col-md-12 mb-4"><!-- col-md-12 mb-4 Starts -->

<h1 class="pull-left"> Manage Requests </h1>

<a href="post_request.php" class="btn btn-success pull-right">
Post New Request
</a>

</div><!-- col-md-12 mb-4 Ends -->

<div class="col-md-12"><!-- col-md-12 Starts -->

<ul class="nav nav-tabs mt-3"><!-- nav nav-tabs mt-3 Starts -->

<?php

$get_requests = "select * from buyer_requests where seller_id='$login_seller_id' AND request_status='active'";

$run_requests = mysqli_query($con,$get_requests);

$count_requests = mysqli_num_rows($run_requests);

?>

<li class="nav-item">

<a href="#active" data-toggle="tab" class="nav-link active">

Active <span class="badge badge-success"><?php echo $count_requests; ?></span>

</a>

</li>

<?php

$get_requests = "select * from buyer_requests where seller_id='$login_seller_id' AND request_status='pause'";

$run_requests = mysqli_query($con,$get_requests);

$count_requests = mysqli_num_rows($run_requests);

?>

<li class="nav-item">

<a href="#pause" data-toggle="tab" class="nav-link">

Paused <span class="badge badge-success"><?php echo $count_requests; ?></span>

</a>

</li>

<?php

$get_requests = "select * from buyer_requests where seller_id='$login_seller_id' AND request_status='pending'";

$run_requests = mysqli_query($con,$get_requests);

$count_requests = mysqli_num_rows($run_requests);

?>

<li class="nav-item">

<a href="#pending" data-toggle="tab" class="nav-link">

Pending <span class="badge badge-success"><?php echo $count_requests; ?></span>

</a>

</li>

<?php

$get_requests = "select * from buyer_requests where seller_id='$login_seller_id' AND request_status='unapproved'";

$run_requests = mysqli_query($con,$get_requests);

$count_requests = mysqli_num_rows($run_requests);

?>

<li class="nav-item">

<a href="#unapproved" data-toggle="tab" class="nav-link">

Unapproved <span class="badge badge-success"><?php echo $count_requests; ?></span>

</a>

</li>

</ul><!-- nav nav-tabs mt-3 Ends -->

<div class="tab-content mt-4"><!-- tab-content mt-4 Starts -->

<div id="active" class="tab-pane fade show active"><!-- active tab-pane fade show active Starts -->

<div class="table-responsive box-table"><!-- table-responsive box-table Starts -->

<table class="table table-hover"><!-- table table-hover Starts -->

<thead>

<tr>

<th>Title</th>

<th>Description</th>

<th>Date</th>

<th>Offers</th>

<th>Budget</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

$get_requests = "select * from buyer_requests where seller_id='$login_seller_id' AND request_status='active' order by 1 DESC";

$run_requests = mysqli_query($con,$get_requests);

while($row_requests = mysqli_fetch_array($run_requests)){

$request_id = $row_requests['request_id'];

$request_title = $row_requests['request_title'];

$request_description = $row_requests['request_description'];

$request_date = $row_requests['request_date'];

$request_budget = $row_requests['request_budget'];

$select_offers = "select * from send_offers where request_id='$request_id' AND status='active'";

$run_offers = mysqli_query($con,$select_offers);

$count_offers = mysqli_num_rows($run_offers);

?>

<tr>

<td> <?php echo $request_title; ?> </td>

<td>
<?php echo $request_description; ?>
</td>

<td> <?php echo $request_date; ?> </td>

<td> <?php echo $count_offers; ?> </td>

<td class="text-success"> $<?php echo $request_budget; ?> </td>

<td>

<div class="dropdown"><!-- dropdown Starts -->

<button data-toggle="dropdown" class="btn btn-success dropdown-toggle">
</button>

<div class="dropdown-menu"><!-- dropdown-menu Starts -->

<a href="view_offers.php?request_id=<?php echo $request_id; ?>" target="blank" class="dropdown-item">
View Offers
</a>

<a href="pause_request.php?request_id=<?php echo $request_id; ?>" class="dropdown-item">
Pause
</a>

<a href="delete_request.php?request_id=<?php echo $request_id; ?>" class="dropdown-item">
Delete
</a>

</div><!-- dropdown-menu Ends -->

</div><!-- dropdown Ends -->

</td>

</tr>

<?php } ?>

</tbody>

</table><!-- table table-hover Ends -->

</div><!-- table-responsive box-table Ends -->

</div><!-- active tab-pane fade show active Ends -->

<div id="pause" class="tab-pane fade"><!-- pause tab-pane fade Starts -->

<div class="table-responsive box-table"><!-- table-responsive box-table Starts -->

<table class="table table-hover"><!-- table table-hover Starts -->

<thead>

<tr>

<th>Title</th>

<th>Description</th>

<th>Date</th>

<th>Offers</th>

<th>Budget</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

$get_requests = "select * from buyer_requests where seller_id='$login_seller_id' AND request_status='pause' order by 1 DESC";

$run_requests = mysqli_query($con,$get_requests);

while($row_requests = mysqli_fetch_array($run_requests)){

$request_id = $row_requests['request_id'];

$request_title = $row_requests['request_title'];

$request_description = $row_requests['request_description'];

$request_date = $row_requests['request_date'];

$request_budget = $row_requests['request_budget'];

$select_offers = "select * from send_offers where request_id='$request_id' AND status='active'";

$run_offers = mysqli_query($con,$select_offers);

$count_offers = mysqli_num_rows($run_offers);

?>


<tr>

<td> <?php echo $request_title; ?> </td>

<td>
<?php echo $request_description; ?>
</td>

<td> <?php echo $request_date; ?> </td>

<td> <?php echo $count_offers; ?> </td>

<td class="text-success"> $<?php echo $request_budget; ?> </td>

<td>

<div class="dropdown"><!-- dropdown Starts -->

<button data-toggle="dropdown" class="btn btn-success dropdown-toggle">
</button>

<div class="dropdown-menu"><!-- dropdown-menu Starts -->

<a href="active_request.php?request_id=<?php echo $request_id; ?>" class="dropdown-item">
Activate
</a>

<a href="delete_request.php?request_id=<?php echo $request_id; ?>" class="dropdown-item">
Delete
</a>

</div><!-- dropdown-menu Ends -->

</div><!-- dropdown Ends -->

</td>

</tr>

<?php } ?>

</tbody>

</table><!-- table table-hover Ends -->

</div><!-- table-responsive box-table Ends -->

</div><!-- pause tab-pane fade Ends -->

<div id="pending" class="tab-pane fade"><!-- pending tab-pane fade Starts -->

<div class="table-responsive box-table"><!-- table-responsive box-table Starts -->

<table class="table table-hover"><!-- table table-hover Starts -->

<thead>

<tr>

<th>Title</th>

<th>Description</th>

<th>Date</th>

<th>Offers</th>

<th>Budget</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

$get_requests = "select * from buyer_requests where seller_id='$login_seller_id' AND request_status='pending' order by 1 DESC";

$run_requests = mysqli_query($con,$get_requests);

while($row_requests = mysqli_fetch_array($run_requests)){

$request_id = $row_requests['request_id'];

$request_title = $row_requests['request_title'];

$request_description = $row_requests['request_description'];

$request_date = $row_requests['request_date'];

$request_budget = $row_requests['request_budget'];

?>


<tr>

<td> <?php echo $request_title; ?> </td>

<td>
<?php echo $request_description; ?> 
</td>

<td> <?php echo $request_date; ?>  </td>

<td> 0 </td>

<td class="text-success"> $<?php echo $request_budget; ?>  </td>

<td>

<a href="delete_request.php?request_id=<?php echo $request_id; ?>" class="btn btn-danger">
Delete
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table><!-- table table-hover Ends -->

</div><!-- table-responsive box-table Ends -->

</div><!-- pending tab-pane fade Ends -->

<div id="unapproved" class="tab-pane fade"><!-- unapproved tab-pane fade Starts -->

<div class="table-responsive box-table"><!-- table-responsive box-table Starts -->

<table class="table table-hover"><!-- table table-hover Starts -->

<thead>

<tr>

<th>Title</th>

<th>Description</th>

<th>Date</th>

<th>Offers</th>

<th>Budget</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

$get_requests = "select * from buyer_requests where seller_id='$login_seller_id' AND request_status='unapproved' order by 1 DESC";

$run_requests = mysqli_query($con,$get_requests);

while($row_requests = mysqli_fetch_array($run_requests)){

$request_id = $row_requests['request_id'];

$request_title = $row_requests['request_title'];

$request_description = $row_requests['request_description'];

$request_date = $row_requests['request_date'];

$request_budget = $row_requests['request_budget'];

?>

<tr>

<td> <?php echo $request_title; ?> </td>

<td>
<?php echo $request_description; ?>
</td>

<td> <?php echo $request_date; ?> </td>

<td> 0 </td>

<td class="text-success"> $<?php echo $request_budget; ?> </td>

<td>

<a href="delete_request.php?request_id=<?php echo $request_id; ?>" class="btn btn-danger">
Delete
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table><!-- table table-hover Ends -->

</div><!-- table-responsive box-table Ends -->

</div><!-- unapproved tab-pane fade Ends -->

</div><!-- tab-content mt-4 Ends -->

</div><!-- col-md-12 Ends -->

</div><!-- row Ends -->

</div><!-- container-fluid mt-5 Ends -->


<?php include("../includes/footer.php"); ?>

</body>

</html>