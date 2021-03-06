<?php require_once('login_auth.php');?>
<?php $thispage = "ngoHomescreen"; 
$activetab="summaryTab";

if (!$_SESSION['SESS_USER_TYPE']=="N")
{
	header(header("Location: login_failed"));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<HTML>
 <HEAD>
  <TITLE>My UC | Donation Summary</TITLE>
  <meta http-equiv="content-type" content="text/ html;charset=utf-8">
  <META NAME="Description" CONTENT="UC is an exchange platform to channel Philanthropic Resources to Education, Health and Environmental services sectors, in order to improve access to these services especially for the poor. These sectors need a much larger infusion of capital of various kinds including Financial, Intellectual and Social Capital.">
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/tabs.css">
</HEAD>
<BODY>

<!--wrapper begin-->
<div id="wrapper" style="background:white; margin-bottom:20px;">

<!--header and navbar -->
<?php include 'header_navbar.php';?>

<!--maincontentarea begin-->
<div id="content-main">
<table>
<tr>
<td valign="top">
<div class="left_div" style=" float:left" >
	<?php include 'ngo_uc_tabs.php'; ?>
</div>
</td>
<td>
<div class="right_div"  style=" float:left; width: 750px; overflow: auto;" >

<table cellpadding="3%"  width="600px">
<tr>
<td>
<?php include ("ngo/chart_ngo_funding_received.php");?>
</td>
<td>
<?php include ("ngo/chart_ngo_postpaid_received.php");?>
</td>
</tr>	
</table>


</div>
</td>
</tr>
</table>
<!--footer-->
</div>
<?php include 'footer.php' ; ?>

</div>
<!--wrapper end-->

 </BODY>
</HTML>
