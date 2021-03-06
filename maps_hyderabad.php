<?php session_start();?>
<?php $thispage = ""; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<HTML>
 <HEAD>
  <TITLE>Contact UC | UC is a new initiative to channel investments to Education, Health and Energy & Environmental services sectors</TITLE>
  <meta http-equiv="content-type" content="text/ html;charset=utf-8">
  <META NAME="Description" CONTENT="UC is a new initiative to channel investments to Education, Health and Energy&Environmental services sectors, in order to improve access to these services especially for the poor. These sectors need a much larger infusion of capital of various kinds including Financial, Intellectual and Social Capital.">
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/ajaxtabs.css">
  <SCRIPT type="text/javascript" src="css/ajaxtabs.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="scripts/jquery.min.js"><\/script>')</script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
  google.load("visualization", "1", {packages:["map"]});
  $(document).ready(function() {
    $(".tabLink").each(function(){
      $(this).click(function(){
        tabeId = $(this).attr('id');
        $(".tabLink").removeClass("activeLink");
        $(this).addClass("activeLink");
        $(".tabcontent").addClass("hide");
        $("#"+tabeId+"-1").removeClass("hide");
	var index = tabeId.substring(tabeId.length-1);
	window["drawMap"+index]();
	return false;	  
      });
    });  
  });
</script>
  </HEAD>
 <BODY>
 
<!--wrapper-->
<div id="wrapper">
 
<!--header and navbar -->
<?php include 'header_navbar.php';?>

<!--maincontentarea-->
<div id="uccertificate-main">
<?php $city = "Hyderabad"; ?>
<h2>Service Opportunities at <?php echo $city;?></h2>
<p>The maps below gives location of various homes providing shelter and other services to young and old, the disabled and the destitute. These homes are managed with the support of several social work organisations. You are welcome to contact us to know about volunteering opportunities and other ways to support these homes. The Donations Camps tab points to places and timing of monthly donations camps held, where people can donate old or new  books, clothes, electronic items etc and also dry waste items like paper, plastics, glass e-waste etc. We are currently working to release maps for other cities too.</p>

  <div class="tab-box">
    <a href="javascript:;" class="tabLink activeLink" id="cont-1">Children Homes</a>
    <a href="javascript:;" class="tabLink " id="cont-2">Shelter Homes</a>
    <a href="javascript:;" class="tabLink " id="cont-3">All Homes</a>
    <a href="javascript:;" class="tabLink " id="cont-4">Donation Camps</a>
  </div>

  <div class="tabcontent paddingAll" id="cont-1-1" align="center">
  <br><?php include 'report_map_children_homes_city.php';?>
  </div>

  <div class="tabcontent paddingAll hide" id="cont-2-1" align="center" >
  <br><?php include 'report_map_shelter_homes_city.php';?>
  </div>

  <div class="tabcontent paddingAll hide" id="cont-3-1" align="center" >
  <br><?php include 'report_map_all_homes_city.php';?>
  </div>

  <div class="tabcontent paddingAll hide" id="cont-4-1" align="center" >
  <br><?php include 'report_map_donation_camps_city.php';?>
  </div>

</div>

 <!--#maincontentarea-->


<!--footer-->
<?php include 'footer.php' ; ?>
<!--#footer-->

 </div>
 <!--#wrapper-->

 </BODY>
</HTML>
