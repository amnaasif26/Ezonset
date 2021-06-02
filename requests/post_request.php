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

<title> ezonset / Post A New Request </title>

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

<div class="container-fluid mt-5 mb-5"><!-- container-fluid mt-5 mb-5 Starts -->

<div class="row"><!-- row Starts -->

<div class="col-lg-9 col-md-11"><!-- col-lg-9 col-md-11 Starts -->

<h1 class="mb-4"> Post A New Request To The Seller Community </h1>

<div class="card rounded-0"><!-- card rounded-0 Starts -->

<div class="card-body"><!-- card-body Starts -->

<form method="post" enctype="multipart/form-data"><!-- form Starts -->

<div class="row"><!-- row Starts -->

<div class="col-md-2 d-md-block d-none">

<i class="fa fa-pencil-square-o fa-4x"></i>

</div>

<div class="col-md-10 col-sm-12"><!-- col-md-10 col-sm-12 Starts -->

<div class="row"><!-- row Starts -->

<div class="col-lg-8"><!-- col-lg-8 Starts -->

<div class="form-group"><!-- form-group Starts -->

<input type="text" name="request_title" placeholder="Request Title" class="form-control input-lg" required>

</div><!-- form-group Ends -->

<div class="form-group"><!-- form-group Starts -->

<textarea name="request_description" id="textarea" rows="5" cols="73" maxlength="380" class="form-control" placeholder="Request Description" required></textarea>

</div><!-- form-group Ends -->

<div class="form-group"><!-- form-group Starts -->

<input type="file" name="request_file" id="file" >

<div class="font-weight-bold pull-right">

<span class="count"> 0 </span> / 380 Max

</div>

</div><!-- form-group Ends -->

</div><!-- col-lg-8 Ends -->

</div><!-- row Ends -->

</div><!-- col-md-10 col-sm-12 Ends -->

</div><!-- row Ends -->

<hr class="card-hr">

<h5> Chose A Category </h5>


<div class="row mb-2"><!-- row mb-2 Starts -->

<div class="col-md-2 d-md-block d-none"><!-- col-md-2 d-md-block d-none Starts -->

<i class="fa fa-folder-open fa-4x"></i>

</div><!-- col-md-2 d-md-block d-none Ends -->

<div class="col-md-10 col-sm-12"><!-- col-md-10 col-sm-12 Starts -->

<div class="row"><!-- row Starts -->

<div class="col-md-4 mb-2"><!-- col-md-4 mb-2 Starts -->

<select class="form-control" name="cat_id" id="category" required>

<option value="" class="hidden"> Select A Category </option>

<?php 

$get_cats = "select * from categories";

$run_cats = mysqli_query($con,$get_cats);

while($row_cats = mysqli_fetch_array($run_cats)){

$cat_id = $row_cats['cat_id'];

$cat_title = $row_cats['cat_title'];

?>

<option value="<?php echo $cat_id; ?>"> <?php echo $cat_title; ?> </option>

<?php } ?>

</select>

</div><!-- col-md-4 mb-2 Ends -->

<div class="col-md-4 mb-2"><!-- col-md-4 mb-2 Starts -->

<select class="form-control" name="child_id" id="sub-category" required>

<option value="" class="hidden"> Select A Sub Category </option>

</select>

</div><!-- col-md-4 mb-2 Ends -->

</div><!-- row Ends -->

</div><!-- col-md-10 col-sm-12 Ends -->

</div><!-- row mb-2 Ends -->

<hr class="card-hr">

<h5> Once you place your order, when would you like your service delivered? </h5>

<div class="row mb-4"><!-- row mb-4 Starts -->

<div class="col-md-1 d-md-block d-none"><!-- col-md-1 d-md-block d-none Starts -->

<i class="fa fa-clock-o fa-4x"></i>

</div><!-- col-md-1 d-md-block d-none Ends -->

<div class="col-md-11 col-sm-12 mt-3"><!-- col-md-11 col-sm-12 mt-3 Starts -->

<?php

$get_delivery_times = "select * from delivery_times";

$run_delivery_times = mysqli_query($con,$get_delivery_times);

while($row_delivery_times = mysqli_fetch_array($run_delivery_times)){

$delivery_proposal_title = $row_delivery_times['delivery_proposal_title'];

?>

<label class="custom-control custom-radio"><!-- custom-control custom-radio Starts -->

<input type="radio" value="<?php echo $delivery_proposal_title; ?>" name="delivery_time" class="custom-control-input" required >

<span class="custom-control-indicator"></span>

<span class="custom-control-description"> <?php echo $delivery_proposal_title; ?> </span>

</label><!-- custom-control custom-radio Ends -->

<?php } ?>

</div><!-- col-md-11 col-sm-12 mt-3 Ends -->

</div><!-- row mb-4 Ends -->

<hr class="card-hr">

<h5> What is your budget for this service? </h5>

<div class="col-md-4 mb-2"><!-- col-md-4 mb-2 Starts -->

<div class="input-group"><!-- input-group Starts -->

<span class="input-group-addon font-weight-bold" > $ </span>

<input type="number" name="request_budget" min="5" placeholder="5 Minimum" class="form-control input-lg" >

</div><!-- input-group Ends -->

</div><!-- col-md-4 mb-2 Ends -->

<input type="submit" name="submit" value="Post Request" class="btn btn-outline-success btn-lg pull-right" >

</form><!-- form Ends -->

</div><!-- card-body Ends -->

</div><!-- card rounded-0 Ends -->

</div><!-- col-lg-9 col-md-11 Ends -->

</div><!-- row Ends -->


</div><!-- container-fluid mt-5 mb-5 Ends -->

<script>

$(document).ready(function(){
	
$("#textarea").keydown(function(){
	
var textarea = $("#textarea").val();

$(".count").text(textarea.length);	
	
});	

$("#sub-category").hide();

$("#category").change(function(){
	
$("#sub-category").show();	
	

var category_id = $(this).val();
	
$.ajax({
	
url:"fetch_subcategory.php",
	
method:"POST",

data:{category_id:category_id},

success:function(data){
	
$("#sub-category").html(data);
	
}
	
});
	
	
});
	
});


</script>

<?php

if(isset($_POST['submit'])){
	
$request_title = mysqli_real_escape_string($con,$_POST['request_title']);
	
$request_description = mysqli_real_escape_string($con,$_POST['request_description']);
	
$cat_id = mysqli_real_escape_string($con,$_POST['cat_id']);
	
$child_id = mysqli_real_escape_string($con,$_POST['child_id']);
	
$request_budget = mysqli_real_escape_string($con,$_POST['request_budget']);
	
$delivery_time = mysqli_real_escape_string($con,$_POST['delivery_time']);
	

$request_file = $_FILES['request_file']['name'];

$request_file_tmp = $_FILES['request_file']['tmp_name'];

$request_date = date("F d, Y");
	
move_uploaded_file($request_file_tmp,"request_files/$request_file");
	
$insert_request = "insert into buyer_requests (seller_id,cat_id,child_id,request_title,request_description,request_file,delivery_time,request_budget,request_date,request_status) values ('$login_seller_id','$cat_id','$child_id','$request_title','$request_description','$request_file','$delivery_time','$request_budget','$request_date','pending')";	

$run_request = mysqli_query($con,$insert_request);


if($run_request){
	
echo "<script>alert('Request has been inserted successfully.');</script>";
	
echo "<script>window.open('manage_requests.php','_self')</script>";
	
}


	
}

?>

<?php include("../includes/footer.php"); ?>

</body>

</html>