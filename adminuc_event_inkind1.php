<?php
session_start ();
$thispage = "myuc";

require_once ('login_auth.php');

if (! $_SESSION ['SESS_USER_TYPE'] == 'A') {
	header ( "Location: login_failed" );
}

include ('prod_conn.php');
mysql_connect ( "$dbhost", "$dbuser", "$dbpass" );
mysql_select_db ( "$dbdatabase" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/tabs.css">

		<script src="scripts/jquery.min.js"></script>
		<script src="scripts/jquery.blockUI.js"></script>
		<script type="text/javascript">
		$(function() {
		$("#category").change(function(){
			$("#item option").show();
			if($(this).data('itemoptions') == undefined){
			/*Taking an array of all options-2 and kind of embedding it on the select1*/
			$(this).data('itemoptions',$('#item option').clone());
			}	
		var id = $(this).val();
		var itemoptions = $(this).data('itemoptions').filter('[name=' + id + ']');
		$('#item').html(itemoptions);
		$('#item').prepend('<option value="" selected="selected" >--Select--</option>');
		});
	});
</script>	
<?php
// ////////category data
$result = mysql_query ( 'SELECT category,category_id FROM item_category' );
$categoryIDs = array ();
$categoryData = array ();
while ( $row = mysql_fetch_assoc ( $result ) ) {
	$categoryData [] = $row ['category'];
	$categoryIDs [] = $row ['category_id'];
}

// //////////Item Data
$donationItems = array ();
$catagories = array ();
$itemIDs = array ();
$itemcategoryIDs = array ();
$sql = mysql_query ( "SELECT * from items JOIN item_category ON items.category_id=item_category.category_id" );

while ( $row = mysql_fetch_array ( $sql ) ) {
	$donationItems [] = $row ['donationitem'];
	$catagories [] = $row ['category'];
	$itemIDs [] = $row ['item_id'];
	$itemcategoryIDs [] = $row ['category_id'];
}

?>

<script type="text/javascript"> 

$(function()
		{

			var i=0;
			$("#addButton").click(function()
			{
			    var categoryData = "<tr id='itemRow"+i+"'><td align='right'>Category</td><td><select style='max-width: 120px;' type='text' id='category"+i+"' name='category[]' required> <option value=''>--SELECT--</option>";
			    <?php
							
							for($i = 0; $i < count ( $categoryIDs ); $i ++) {
								echo "categoryData+=\"<option value='$categoryIDs[$i]'>$categoryData[$i]</option>\";";
							}
							?>
			    categoryData +="</select></td>";
			    
				var itemData = " <td align='right'>Item</td> <td><select style='max-width: 120px;' type='text' name='item[]' id='item"+i+"' required > <option value='' >--SELECT--</option>";
				<?php
				for($i = 0; $i < count ( $itemIDs ); $i ++) {
					
					echo "itemData+= \"<option value='$itemIDs[$i]' name='$itemcategoryIDs[$i]' hidden>$donationItems[$i]</option>\"; ";
				}
				
				?>
				
				itemData +="</select></td>";


			     var unitsType = "<td align='right'>Units Type</td>	<td><select name='units_type[]' required>";
			         unitsType += "<option value='' selected='selected'>---SELECT---</option>";
			         unitsType += "<option value='Kgs'>Kgs</option>";
			         unitsType += "<option value='Litres'>Litres</option>";
			         unitsType += "<option value='Pieces'>Pieces</option>";
			         unitsType += "<option value='Boxes'>Boxes</option>";
			         unitsType += "<option value='Packets'>Packets</option></td>";
			         unitsType += "</td>";

			     var requestQuntity = "<td align='right'>Request Quantity</td>";
			         requestQuntity +="<td><input type='text' name='request_quantity[]' size='5'";
			         requestQuntity +="		maxlength='5' required></td>";
			         requestQuntity +="	</td>";
			         
			     var removeButton = "<td align='right'><input type='button' id='removeButton"+i+"' value='x' /></td></tr>";
			     	
			         $(categoryData+itemData+unitsType+requestQuntity+removeButton).clone().appendTo($("#items"));
		         var category = "category"+i;
	             var item = "item"+i;
				var removeButtonId="removeButton"+i;
	             var itemRowId = "itemRow"+i;
	     		$("#"+category).change(function(){
	         			
	     			$("#"+item+" option").show();
	     			if($(this).data('itemoptions') == undefined){
	     			/*Taking an array of all options-2 and kind of embedding it on the select1*/
	     			$(this).data('itemoptions',$("#"+item+" option").clone());
	     			}	
	     		var id = $(this).val();
	     		var itemoptions = $(this).data('itemoptions').filter('[name=' + id + ']');
	     		$('#'+item).html(itemoptions);
	     		$('#'+item).prepend('<option value="" selected="selected" >--Select--</option>');
	     		});
				$("#"+removeButtonId).click(function(){
					
					$("#"+itemRowId).remove();
				});
				i++;
				
			});
		});

</script>
		<title>My UC | Events - Inkind donations</title>

</head>
<body>
	<div id="wrapper">
<?php include("header_navbar.php"); ?>
<div id="content-main">
			<table>
				<tr>
					<td valign="top">
<?php include 'adminUcTabs.php';?>
</td>
					<td>
						<div class="right_div"
							style="float: left; width: 750px; overflow: auto;">
							<form name="requestForm" method="post"
								action="adminuc_event_inkind1.php">
								<table class="table-request"
									style="float: left; border-right: 1px solid #ccc;">
									<th colspan="2" align="left"><h3>Update an In-Kind Donation</h3></th>
									<tr>
										<td align="right">NPO</td>
										<td colspan="4"><select style="max-width: 700px;" type="text"
											id="partner" name="partner_id" required>
												<option value="">--SELECT--</option>
					    <?php
									
									$result = mysql_query ( 'SELECT name,project_partners.partner_id FROM project_partners JOIN users ON project_partners.user_id = users.user_id WHERE registration_status="A" ORDER BY LOWER(name) ASC' );
									while ( $row = mysql_fetch_assoc ( $result ) ) {
										$data = $row ['name'];
										$partner_id = $row ['partner_id'];
										if (isset ( $_POST ['partner_id'] ) && $_POST ['partner_id'] == $partner_id) {
											echo '<option value="' . $partner_id . '" selected>' . $data . '</option>';
										}
										echo '<option value="' . $partner_id . '">' . $data . '</option>';
									}
									?>
			</select></td>
									</tr>
									<tbody id="items">
										<tr id="itemRow">
											<td align="right">Category</td>
											<td><select style="max-width: 120px;" type="text"
												id="category" name="category[]" required>
													<option value="">--SELECT--</option>
					    <?php
									
									for($i = 0; $i < count ( $categoryIDs ); $i ++) {
										echo "categoryData+=\"<option value='$categoryIDs[$i]'>$categoryData[$i]</option>\";";
									}
									?>
			</select></td>
											<td align="right">Item</td>
											<td><select style="max-width: 120px;" type="text"
												name="item[]" id="item" required />
												<option value="">--SELECT--</option>
			<?php
			
			for($i = 0; $i < count ( $itemIDs ); $i ++) {
				
				echo "itemData+= \"<option value='$itemIDs[$i]' name='$itemcategoryIDs[$i]' hidden>$donationItems[$i]</option>\"; ";
			}
			?>
        </select></td>
											</td>
											<td align="right">Units Type</td>
											<td><select name="units_type[]" required>
													<option value="" selected="selected">---SELECT---</option>
													<option value="Kgs">Kgs</option>
													<option value="Litres">Litres</option>
													<option value="Pieces">Pieces</option>
													<option value="Boxes">Boxes</option>
													<option value="Packets">Packets</option></td>
											</td>
											<td align="right">Request Quantity</td>
											<td><input type="text" name="request_quantity[]" size="5"
												maxlength="5" required></td>
											</td>
										</tr>
									</tbody>
									<tr>
										<td align="right" colspan="8"><input type="button"
											value="+add" id="addButton" /></td>
									</tr>
									<tr>
										<td align="right">Request City</td>
										<td colspan="4"><input type="text" name="request_city"
											value="Hyderabad" required /></td>
									</tr>
									<tr>
										<td align="right">Request Address</td>
										<td colspan="4"><textarea rows="3" value=""
												name="request_address" required></textarea></td>
									</tr>
									<tr hidden>
										<td align="right">Request Expiry Date <span class="link"><a
												href="javascript: void(0)"><font
													face=verdana,arial,helvetica size=2>[?]</font><span>The
														default Request Expiry Date is set to 90 days from Current
														Date. An Earlier date can be set by the NGO.</span></a></span></td>
										<td colspan="4"><input type="text" placeholder="YYYY/MM/DD"
											name="req_exp_date" id="req_exp_date" size="10"
											value='<?php
											
											date_default_timezone_set ( 'Asia/Kolkata' );
											$end = date ( "d-M-Y", strtotime ( "+3 months" ) );
											echo $end;
											?>'
											required /></td>
									</tr>
									<tr>
										<td colspan="2" align="center"><input type="submit"
											name="request_submit" value="Submit" /></td>
									</tr>
								</table>
							</form>
<?php
if (isset ( $_POST ['request_submit'] )) {
	echo "<script>alert('set');</script>";
	// connect to database
	include_once ("prod_conn.php");
	$partnerquery = "SELECT partner_id,name,partner_email from project_partners WHERE partner_id=" . $_POST ['partner_id'];
	$partner = mysql_fetch_array ( mysql_query ( $partnerquery ) );
	$categoryArray = $_POST ['category'];
	$itemIDArray = $_POST ['item'];
	$unitsTypeArray = $_POST ['units_type'];
	$reqQuntityArray = $_POST ['request_quantity'];
	$tables = array ();
	$itemCount = count ( $categoryArray );
	
	for($j = 0; $j < $itemCount; $j ++) {
		echo "<script>alert('fdshf');</script>";
		$insert_inkind = "INSERT INTO kind_donations(initiative_type,partner_id,donor_id,item_id,units_type,request_quantity,offer_quantity,request_city,offer_city ,request_address,offer_address, request_date,offer_date, request_expiry_date,delivery_date, transport,note,status)
			  VALUES ('0','$partner[partner_id]',138,'$itemIDArray[$j]','$unitsTypeArray[$j]', '$reqQuntityArray[$j]','$reqQuntityArray[$j]', '$_POST[request_city]','$_POST[request_city]', '$_POST[request_address]','$_POST[request_address]', CURDATE() , CURDATE() , '" . date ( "Y-m-d", strtotime ( $_POST ['req_exp_date'] ) ) . "',CURDATE(), '0','Donation Camps, Individual Donations.','Delivered')";
		$registration = mysql_query ( $insert_inkind );
		$subid = mysql_insert_id ();
		$update = mysql_query ( "UPDATE kind_donations set sub_id=$subid WHERE donation_id=$subid" );
		$item = mysql_fetch_array ( mysql_query ( "SELECT donationitem,request_quantity from items INNER JOIN item_category on items.category_id=item_category.category_id INNER JOIN kind_donations ON items.item_id=kind_donations.item_id  WHERE kind_donations.donation_id=$subid" ) );
		$tables [] = "
  <table style='border-collapse:collapse;float:right;' border='1'>
  <tr>
  <th colspan=\"2\" align=\"center\" height=\"20\" valign=\"top\">Request Details</th>
  </tr>
  <tr>
  <td>Partner</td>
  <td>" . $partner ['name'] . "</td>
  </tr>
  <tr>
  <tr>
  <td>Item </td>
  <td>" . $item ['donationitem'] . "</td>
  </tr>
  <tr>
  <td>Quantity </td>
  <td>" . $item ['request_quantity'] . "</td>
  </tr>
  </table>
  <br />";
	}
	
	$partnerEmail = $partner ['partner_email'];
	$parnterName = $partner ['name'];
	$emailSubject = "";
	$emailBody = "";
	// sendEmail ( $partnerEmail, $parnterName, $emailSubject, emailBody );
	
	?>

	<h3 align="center">Update succesful.</h3>
<?php
}
?>	

</div>

						<div>
<?php

if (isset ( $_POST ['request_submit'] )) {
	echo "<h2>Recent In-Kind Updates</h2>";
	$noOfTables = count ( $tables );
	for($x = 0; x < $noOfTables; $x ++) {
		echo $tables [$x];
	}
	exit ();
}
?>
						</div>
					</td>

				</tr>
			</table>

		</div>
		<!--footer-->
		<br />
<?php include 'footer.php' ; ?>
<!--#footer-->
	</div>
</body>
</html>

<?php
function sendEmail($email, $displayName, $subject, $mailBody) {
	// global $string, $mailText;
	require_once ("Email/class.phpmailer.php");
	require_once 'Email/config.php';
	try {
		$to = $email;
		$mail->AddAddress ( $to );
		$mail->AddBCC ( "contact@yousee.in" );
		
		$body = "Dear  " . $displayName . ",<br><br>";
		$body .= $mailBody;
		$body .= "<br><br><br> From YouSee  (+91-8008-884422) <br /> <a href=\"www.yousee.in\">www.yousee.in</a>";
		$mail->Subject = $subject;
		$mail->Body = $body;
		if ($mail->Send ()) {
			;
		} else {
			echo "<script>alert('email failed');</script>";
			$mail->ErrorInfo;
			showError ();
		}
	} catch ( phpmailerException $e ) {
		echo $e->errorMessage ();
		echo "<script>alert('Message failed');</script>";
		// showError();
	}
}
?>
