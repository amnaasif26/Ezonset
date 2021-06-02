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

$proposal_id = $_POST['proposal_id'];

$request_id = $_POST['request_id'];


$get_requests = "select * from buyer_requests where request_id='$request_id'";

$run_requests = mysqli_query($con,$get_requests);

$row_requets = mysqli_fetch_array($run_requests);

$request_title = $row_requets['request_title'];

$request_description = $row_requets['request_description'];

$request_seller_id = $row_requets['seller_id'];


$select_request_seller = "select * from sellers where seller_id='$request_seller_id'";

$run_requets_seller = mysqli_query($con,$select_request_seller);

$row_requets_seller = mysqli_fetch_array($run_requets_seller);

$request_seller_image = $row_requets_seller['seller_image'];


$get_proposals = "select * from proposals where proposal_status='active' AND proposal_seller_id='$login_seller_id' AND proposal_id='$proposal_id'";

$run_proposals = mysqli_query($con,$get_proposals);

$row_proposals = mysqli_fetch_array($run_proposals);

$proposal_title = $row_proposals['proposal_title'];

?>


<div class="modal-content"><!--- modal-content Starts --->

<div class="modal-header"><!--- modal-header Starts --->

<h5 class="modal-title h5"> Specify Your Proposal Details </h5>

<button class="close" data-dismiss="modal"> &times; </button>

</div><!--- modal-header Ends --->

<div class="modal-body p-0"><!--- modal-body p-0 Starts --->

<div class="request-summary"><!--- request-summary Starts --->

<?php if(!empty($request_seller_image)){ ?>

<img src="<?php echo $site_url; ?>/user_images/<?php echo $request_seller_image; ?>" width="50" height="50" class="rounded-circle">

<?php }else{ ?>

<img src="<?php echo $site_url; ?>/user_images/empty-image.png" width="50" height="50" class="rounded-circle">

<?php } ?>

<div id="request-description"><!--- request-description Starts --->

<h6 class="text-primary mb-1"> <?php echo $request_title; ?> </h6>

<p> <?php echo $request_description; ?> </p>

</div><!--- request-description Ends --->

</div><!--- request-summary Ends --->

<form id="proposal-details-form"><!--- proposal-details-form Starts --->

<div class="selected-proposal p-3"><!--- selected-proposal p-3 Starts --->

<h5> <?php echo $proposal_title; ?> </h5>

<hr>

<input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

<input type="hidden" name="request_id" value="<?php echo $request_id; ?>">

<div class="form-group"><!--- form-group Starts --->

<label class="font-weight-bold"> Description :  </label>

<textarea name="description" class="form-control" required></textarea>

</div><!--- form-group Ends --->

<hr>

<div class="form-group"><!--- form-group Starts --->

<label class="font-weight-bold"> Delivery Time :  </label>

<select class="form-control float-right" name="delivery_time">

<?php 

$get_delivery_times = "select * from delivery_times";

$run_delivery_times = mysqli_query($con,$get_delivery_times);

while($row_delivery_times = mysqli_fetch_array($run_delivery_times)){
	
$delivery_proposal_title = $row_delivery_times['delivery_proposal_title'];
	
echo "<option value='$delivery_proposal_title'> $delivery_proposal_title </option>";
	
}

?>

</select>

</div><!--- form-group Ends --->

<hr>


<div class="form-group"><!--- form-group Starts --->

<label class="font-weight-bold"> Total Offer Amount :  </label>

<div class="input-group float-right">

<span class="input-group-addon font-weight-bold"> $ </span>

<input type="number" name="amount" class="form-control" min="5" placeholder="5 Minimum">

</div>

</div><!--- form-group Ends --->


</div><!--- selected-proposal p-3 Ends --->

<div class="modal-footer"><!--- modal-footer Starts --->

<button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#send-offer-modal">

Back

</button>

<button type="submit" class="btn btn-success">

Submit Offer

</button>

</div><!--- modal-footer Ends --->

</form><!--- proposal-details-form Ends --->

</div><!--- modal-body p-0 Ends --->

</div><!--- modal-content Ends --->

<div id="insert_offer"></div>


<script>

$(document).ready(function(){
	
$("#proposal-details-form").submit(function(event){
	
event.preventDefault();
	
$.ajax({
	
method: "POST",
url: "<?php echo $site_url; ?>/requests/insert_offer.php",
data: $('#proposal-details-form').serialize()

})

.done(function(data){
	
$("#submit-proposal-details").modal('hide');

$("#insert_offer").html(data);
	
	
});
	
});
	
	
	
});


</script>

