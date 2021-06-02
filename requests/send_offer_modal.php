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

$request_id = $_POST["request_id"];


$get_requests = "select * from buyer_requests where request_id='$request_id'";

$run_requests = mysqli_query($con,$get_requests);

$row_requets = mysqli_fetch_array($run_requests);

$request_title = $row_requets['request_title'];

$request_description = $row_requets['request_description'];

$child_id = $row_requets['child_id'];

$request_seller_id = $row_requets['seller_id'];


$select_request_seller = "select * from sellers where seller_id='$request_seller_id'";

$run_requets_seller = mysqli_query($con,$select_request_seller);

$row_requets_seller = mysqli_fetch_array($run_requets_seller);

$request_seller_image = $row_requets_seller['seller_image'];

?>

<div id="send-offer-modal" class="modal fade"><!--- modal fade Starts --->

<div class="modal-dialog"><!--- modal-dialog Starts --->

<div class="modal-content"><!--- modal-content Starts --->

<div class="modal-header"><!--- modal-header Starts --->

<h5 class="modal-title"> Select A Proposal To Offer </h5>

<button class="close" data-dismiss="modal" > <span>&times;</span> </button>

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

<div class="request-proposals-list"><!--- request-proposals-list Starts --->

<?php

$get_proposals = "select * from proposals where proposal_status='active' AND proposal_child_id='$child_id' AND proposal_seller_id='$login_seller_id'";

$run_proposals = mysqli_query($con,$get_proposals);

while($row_proposals = mysqli_fetch_array($run_proposals)){

$proposal_id = $row_proposals['proposal_id'];

$proposal_title = $row_proposals['proposal_title'];

$proposal_img1 = $row_proposals['proposal_img1'];

?>

<div class="proposal-picture"><!--- proposal-picture Starts --->

<input type="radio" id="radio-<?php echo $proposal_id; ?>" class="radio-custom" name="proposal_id" value="<?php echo $proposal_id; ?>" required>

<label for="radio-<?php echo $proposal_id; ?>" class="radio-custom-label"> </label>

<img src="<?php echo $site_url; ?>/proposals/proposal_files/<?php echo $proposal_img1; ?>" width="50" height="50">

</div><!--- proposal-picture Ends --->

<div class="proposal-title"><!--- proposal-title Starts --->

<p><?php echo $proposal_title; ?></p>

</div><!--- proposal-title Ends --->

<hr>

<?php } ?>

</div><!--- request-proposals-list Ends --->

</div><!--- modal-body p-0 Ends --->

<div class="modal-footer"><!--- modal-footer Starts --->

<button class="btn btn-secondary" data-dismiss="modal"> Close </button>

<button id="submit-proposal" class="btn btn-info" data-toggle="modal" data-dismiss="modal" data-target="#submit-proposal-details">

Go Next

</button>

</div><!--- modal-footer Ends --->

</div><!--- modal-content Ends --->

</div><!--- modal-dialog Ends --->

</div><!--- modal fade Ends --->

<div id="submit-proposal-details" class="modal fade"><!--- modal fade Starts --->

<div class="modal-dialog"><!--- modal-dialog Starts --->


</div><!--- modal-dialog Ends --->

</div><!--- modal fade Ends --->

<script>

$(document).ready(function(){
	
	$("#send-offer-modal").modal("show");
	
	$("#submit-proposal").attr("disabled", "disabled");
	
	$(".radio-custom-label").click(function(){
		
		$("#submit-proposal").removeAttr("disabled");
		
	});
	
 
   $("#submit-proposal").click(function(){
	   
   proposal_id = document.querySelector('input[name="proposal_id"]:checked').value;	   
	
   request_id = "<?php echo $request_id; ?>";
   
   $.ajax({
	   
	method: "POST",   
	
	url: "<?php echo $site_url; ?>/requests/submit_proposal_details.php",
	
	data: { proposal_id: proposal_id, request_id: request_id }
	   
   })
   
   .done(function(data){
	   
	   $("#submit-proposal-details .modal-dialog").html(data);
	   
   });
	
	
   });
	
	
	
});

</script>