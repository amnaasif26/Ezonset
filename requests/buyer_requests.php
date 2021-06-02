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

$login_seller_offers = $row_login_seller['seller_offers'];


$request_child_ids = array();

$select_proposals = "select DISTINCT proposal_child_id from proposals where proposal_seller_id='$login_seller_id'";

$run_proposals = mysqli_query($con,$select_proposals);

while($row_proposals = mysqli_fetch_array($run_proposals)){
	
	$proposal_child_id = $row_proposals['proposal_child_id'];
	
	array_push($request_child_ids, $proposal_child_id);
	
}

$where_child_id = array();

foreach($request_child_ids as $child_id){
	
	$where_child_id[] = "child_id=" . $child_id; 
	
}

if(count($where_child_id) > 0){
	
	$requests_query = " and (" . implode(" or ", $where_child_id) . ")";
	
	$child_cats_query = "(" . implode(" or ", $where_child_id) . ")";
	
}

?>

<!DOCTYPE html>

<html>

<head>

<title> ezonset / Recent Buyer Requests </title>

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


<div class="container-fluid"><!-- container-fluid Starts -->

<div class="row buyer-requests"><!-- row buyer-requests Starts -->

<div class="col-md-12 mt-5"><!-- col-md-12 mt-5 Starts -->

<h1 class="col-md-9 float-left"> Recent Buyer Requests <h1>

<div class="col-md-3 float-right"><!-- col-md-3 float-right Starts -->

<div class="input-group"><!-- input-group Starts -->

<input type="text" id="search-input"  placeholder="Search Buyer Requests" class="form-control" >

<span class="input-group-btn">

<button class="btn btn-primary"> <i class="fa fa-search"></i> </button>

</span>


</div><!-- input-group Ends -->

</div><!-- col-md-3 float-right Ends -->

</div><!-- col-md-12 mt-5 Ends -->

<div class="col-md-12 mt-4"><!-- col-md-12 mt-4 Starts -->

<h5 class="text-right mr-3"><!-- text-right mr-3 Starts -->

<i class="fa fa-list-alt"></i> <?php echo $login_seller_offers; ?> Offers Left Today

</h5><!-- text-right mr-3 Ends -->

<div class="clearfix"></div>

<ul class="nav nav-tabs"><!-- nav nav-tabs Starts -->

<li class="nav-item">

<a href="#active-requests" data-toggle="tab" class="nav-link active">

Active <span class="badge badge-success"> 

<?php 

$i_requests = 0;

$i_send_offers = 0;

if(!empty($requests_query)){
	
$get_requests = "select * from buyer_requests where request_status='active'" . $requests_query . " AND NOT seller_id='$login_seller_id' order by request_id DESC";
	
$run_requests = mysqli_query($con,$get_requests);
	
while($row_requets = mysqli_fetch_array($run_requests)){
	
$request_id = $row_requets['request_id'];
	
$select_offers = "select * from send_offers where request_id='$request_id' AND sender_id='$login_seller_id'";

$run_offers = mysqli_query($con,$select_offers);

$count_offers = mysqli_num_rows($run_offers);

if($count_offers == 1){
	
$i_send_offers++;
	
}

$i_requests++;
	
}
	
	
}

?>

<?php echo $i_requests-$i_send_offers; ?>

 </span>

</a>

</li>

<?php 

$select_offers = "select * from send_offers where sender_id='$login_seller_id'";

$run_offers = mysqli_query($con,$select_offers);

$count_offers = mysqli_num_rows($run_offers);

?>

<li class="nav-item">

<a href="#sent-offers" data-toggle="tab" class="nav-link">

Sent Offers <span class="badge badge-success"> <?php echo $count_offers; ?> </span>

</a>

</li>

</ul><!-- nav nav-tabs Ends -->

<div class="tab-content mt-4"><!-- tab-content mt-4 Starts -->

<div id="active-requests" class="tab-pane fade show active"><!-- active-requests tab-pane fade show active Starts -->

<div class="table-responsive box-table"><!-- table-responsive box-table Starts -->

<h3 class="float-left ml-2 mt-3 mb-3"> Buyer Requests </h3>

<select id="sub-category" class="form-control float-right sort-by mt-3 mb-3 mr-3">

<option value="all"> All Subcategories </option>

<?php

$get_c_cats = "select * from categories_childs where " . $child_cats_query;

$run_c_cats = mysqli_query($con,$get_c_cats);

while($row_c_cats = mysqli_fetch_array($run_c_cats)){
	
$child_id = $row_c_cats['child_id'];

$child_title = $row_c_cats['child_title'];

echo "<option value='$child_id'> $child_title </option>";
	
}

?>

</select>

<table class="table table-hover"><!-- table table-hover Starts -->

<thead>

<tr>

<th>Request</th>

<th>Offers</th>

<th>Date</th>

<th>Duration</th>

<th>Budget</th>

</tr>

</thead>

<tbody id="load-data">

<?php 

if(!empty($requests_query)){
	
$select_requests = "select * from buyer_requests where request_status='active'" . $requests_query . " AND NOT seller_id='$login_seller_id' order by 1 DESC";

$run_requests = mysqli_query($con,$select_requests);

while($row_requests = mysqli_fetch_array($run_requests)){
	
$request_id = $row_requests['request_id'];

$seller_id = $row_requests['seller_id'];

$cat_id = $row_requests['cat_id'];

$child_id = $row_requests['child_id'];

$request_title = $row_requests['request_title'];

$request_description = $row_requests['request_description'];

$delivery_time = $row_requests['delivery_time'];

$request_budget = $row_requests['request_budget'];

$request_file = $row_requests['request_file'];

$request_date = $row_requests['request_date'];


$get_cats = "select * from categories where cat_id='$cat_id'";

$run_cats = mysqli_query($con,$get_cats);

$row_cats = mysqli_fetch_array($run_cats);

$cat_title = $row_cats['cat_title'];


$get_c_cats = "select * from categories_childs where child_id='$child_id'";

$run_c_cats = mysqli_query($con,$get_c_cats);

$row_c_cats = mysqli_fetch_array($run_c_cats);

$child_title = $row_c_cats['child_title'];


$select_request_seller = "select * from sellers where seller_id='$seller_id'";

$run_request_seller = mysqli_query($con,$select_request_seller);

$row_request_seller = mysqli_fetch_array($run_request_seller);

$request_seller_user_name = $row_request_seller['seller_user_name'];

$request_seller_image = $row_request_seller['seller_image'];

$select_send_offers = "select * from send_offers where request_id='$request_id'";

$run_send_offers = mysqli_query($con,$select_send_offers);

$count_send_offers = mysqli_num_rows($run_send_offers);

$select_offers = "select * from send_offers where request_id='$request_id' AND sender_id='$login_seller_id'";

$run_offers = mysqli_query($con,$select_offers);

$count_offers = mysqli_num_rows($run_offers);

if($count_offers == 0){


?>

<tr id="request_tr_<?php echo $request_id; ?>">

<td>

<?php if(!empty($request_seller_image)){ ?>

<img src="../user_images/<?php echo $request_seller_image; ?>" class="request-img rounded-circle" >

<?php }else{ ?>

<img src="../user_images/empty-image.png" class="request-img rounded-circle" >

<?php } ?>

<div class="request-description"><!-- request-description Starts -->

<h6> <?php echo $request_seller_user_name; ?> </h6>

<h5 class="text-primary"> <?php echo $request_title; ?> </h5>

<p class="lead mb-2"> <?php echo $request_description; ?> </p>

<?php if(!empty($request_file)){ ?>

<a href="request_files/ <?php echo $request_file; ?>" download>

<i class="fa fa-arrow-circle-down"></i>  <?php echo $request_file; ?>

</a>

<?php } ?>

<ul class="request-category">

<li> <?php echo $cat_title; ?> </li>

<li> <?php echo $child_title; ?> </li>

</ul>

</div><!-- request-description Ends -->

</td>

<td><?php echo $count_send_offers; ?></td>

<td> <?php echo $request_date; ?> </td>

<td> 

<?php echo $delivery_time; ?> <a href="#" class="remove-link remove_request_<?php echo $request_id; ?>"> Remove Request </a>

</td>

<td class="text-success font-weight-bold">

$<?php if(!empty($request_budget)){ ?> 

<?php echo $request_budget; ?>

<?php }else{ ?>

---

<?php } ?>

<br>

<?php if($login_seller_offers == "0"){ ?>

<button class="btn btn-success btn-sm mt-4 send_button_<?php echo $request_id; ?>" data-toggle="modal" data-target="#quota-finish">
Send Offer
</button>

<?php }else{ ?>

<button class="btn btn-success btn-sm mt-4 send_button_<?php echo $request_id; ?>">
Send Offer
</button>

<?php } ?>

</td>


<script>

$(".send_button_<?php echo $request_id; ?>").css("visibility","hidden");

$(".remove_request_<?php echo $request_id; ?>").css("visibility","hidden");


$(document).on("mouseenter", "#request_tr_<?php echo $request_id; ?>", function(){
	
	$(".send_button_<?php echo $request_id; ?>").css("visibility","visible");
	
	$(".remove_request_<?php echo $request_id; ?>").css("visibility","visible");
	
});

$(document).on("mouseleave", "#request_tr_<?php echo $request_id; ?>", function(){
	
	$(".send_button_<?php echo $request_id; ?>").css("visibility","hidden");
	
	$(".remove_request_<?php echo $request_id; ?>").css("visibility","hidden");
	
});

$(".remove_request_<?php echo $request_id; ?>").click(function(event){
	
	event.preventDefault();
	
	$("#request_tr_<?php echo $request_id; ?>").fadeOut().remove();
	
});


<?php if($login_seller_offers == "0"){ ?>


<?php }else{ ?>

$(".send_button_<?php echo $request_id; ?>").click(function(){
	
request_id = "<?php echo $request_id; ?>";
	
$.ajax({
	
method: "POST",
url: "send_offer_modal.php",
data: {request_id: request_id}
})
.done(function(data){
	
$(".append-modal").html(data);
	
});
	
});

<?php } ?>

</script>

</tr>

<?php 

}

}

}

?>

</tbody>

</table><!-- table table-hover Ends -->

</div><!-- table-responsive box-table Ends -->

</div><!-- active-requests tab-pane fade show active Ends -->



<div id="sent-offers" class="tab-pane fade"><!-- sent-offers tab-pane fade Starts -->

<div class="table-responsive box-table"><!-- table-responsive box-table Starts -->

<h3 class="ml-2 mt-3 mb-3"> OFFERS SUBMITTED FOR BUYER REQUESTS </h3>

<table class="table table-hover"><!-- table table-hover Starts -->

<thead>

<tr>

<th>Offer</th>

<th>Duration</th>

<th>Price</th>

<th>Request</th>

</tr>

</thead>

<tbody>

<?php

$select_offers = "select * from send_offers where sender_id='$login_seller_id' order by 1 DESC";

$run_offers = mysqli_query($con,$select_offers);

while($row_offers = mysqli_fetch_array($run_offers)){

$request_id = $row_offers['request_id'];

$proposal_id = $row_offers['proposal_id'];

$description = $row_offers['description'];

$delivery_time = $row_offers['delivery_time'];

$amount = $row_offers['amount'];

$select_proposals = "select * from proposals where proposal_id='$proposal_id'";

$run_proposals = mysqli_query($con, $select_proposals);

$row_proposals = mysqli_fetch_array($run_proposals);

$proposal_title = $row_proposals['proposal_title'];


$select_requests = "select * from buyer_requests where request_id='$request_id' ";

$run_requests = mysqli_query($con,$select_requests);

$row_requests = mysqli_fetch_array($run_requests);

$request_id = $row_requests['request_id'];

$seller_id = $row_requests['seller_id'];

$cat_id = $row_requests['cat_id'];

$child_id = $row_requests['child_id'];

$request_title = $row_requests['request_title'];

$request_description = $row_requests['request_description'];



$get_cats = "select * from categories where cat_id='$cat_id'";

$run_cats = mysqli_query($con,$get_cats);

$row_cats = mysqli_fetch_array($run_cats);

$cat_title = $row_cats['cat_title'];


$get_c_cats = "select * from categories_childs where child_id='$child_id'";

$run_c_cats = mysqli_query($con,$get_c_cats);

$row_c_cats = mysqli_fetch_array($run_c_cats);

$child_title = $row_c_cats['child_title'];


$select_request_seller = "select * from sellers where seller_id='$seller_id'";

$run_request_seller = mysqli_query($con,$select_request_seller);

$row_request_seller = mysqli_fetch_array($run_request_seller);

$request_seller_user_name = $row_request_seller['seller_user_name'];

$request_seller_image = $row_request_seller['seller_image'];


?>

<tr>

<td>

<strong> <?php echo $proposal_title; ?> </strong>

<p>

<?php echo $description; ?>

</p>

</td>

<td> <?php echo $delivery_time; ?> </td>

<td> $<?php echo $amount; ?> </td>

<td>

<?php if(!empty($request_seller_image)){ ?>

<img src="../user_images/<?php echo $request_seller_image; ?>" class="request-img rounded-circle mt-0" >

<?php }else{ ?>

<img src="../user_images/empty-image.png" class="request-img rounded-circle mt-0" >

<?php } ?>

<div class="request-description"><!-- request-description Starts -->

<h6> <?php echo $request_seller_user_name; ?> </h6>

<h5 class="text-primary"> <?php echo $request_title; ?> </h5>

<p class="lead mb-2"> <?php echo $request_description; ?> </p>

<?php if(!empty($request_file)){ ?>

<a href="request_files/<?php echo $request_file; ?>" download>

<i class="fa fa-arrow-circle-down"></i> <?php echo $request_file; ?>

</a>

<?php } ?>

<ul class="request-category">

<li> <?php echo $cat_title; ?> </li>

<li> <?php echo $child_title; ?> </li>

</ul>

</div><!-- request-description Ends -->

</td>

</tr>

<?php } ?>

</tbody>

</table><!-- table table-hover Ends -->

</div><!-- table-responsive box-table Ends -->

</div><!-- sent-offers tab-pane fade Ends -->



</div><!-- tab-content mt-4 Ends -->

</div><!-- col-md-12 mt-4 Ends -->

</div><!-- row buyer-requests Ends -->

</div><!-- container-fluid Ends -->

<div class="append-modal"></div>

<div id="quota-finish" class="modal fade"><!--- quota-finish modal fade Starts --->

<div class="modal-dialog"><!--- modal-dialog Starts --->

<div class="modal-content"><!--- modal-content Starts --->

<div class="modal-header"><!--- modal-header Starts --->

<h5 class="modal-title h5"> Request Quota Finished </h5>

<button class="close" data-dismiss="modal"> &times; </button>

</div><!--- modal-header Ends --->

<div class="modal-body"><!--- modal-body Starts --->

<center>

<h3> You Have Already Sent 10 Offers Today, Quota Finish </h3>

</center>

</div><!--- modal-body Ends --->

<div class="modal-footer"><!--- modal-footer Starts --->

<button class="btn btn-secondary" data-dismiss="modal">

Close

</button>

</div><!--- modal-footer Ends --->

</div><!--- modal-content Ends --->

</div><!--- modal-dialog Ends --->

</div><!--- quota-finish modal fade Ends --->


<script>

$(document).ready(function(){
	
$('#search-input').keyup(function(){
	
var search = $(this).val();
	
var requests_query = "<?php echo $requests_query; ?>";
	
$('#load-data').html("");
	
$.ajax({
	
url:"load_search_data.php",

method:"POST",

data:{search:search,requests_query:requests_query},
	
success:function(data){
	
$('#load-data').html(data);
	
}
	
});
	
	
});
	


$('#sub-category').change(function(){
	
var child_id = $(this).val();
	
var requests_query = "<?php echo $requests_query; ?>";
	
$('#load-data').html("");
	
$.ajax({
	
url:"load_category_data.php",

method:"POST",

data:{child_id:child_id,requests_query:requests_query},
	
success:function(data){
	
$('#load-data').html(data);
	
}
	
});
	
	
});
	

	
	
});

</script>


<?php include("../includes/footer.php"); ?>

</body>

</html>