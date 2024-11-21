<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$uid=$_SESSION['id'];
$category=$_POST['category'];
$subcat=$_POST['subcategory'];
$complaintype=$_POST['complaintype'];
$state=$_POST['state'];
$noc=$_POST['noc'];
$complaintdetials=$_POST['complaindetails'];
$compfile=$_FILES["compfile"]["name"];

move_uploaded_file($_FILES["compfile"]["tmp_name"],"complaintdocs/".$_FILES["compfile"]["name"]);
$query=mysqli_query($bd, "insert into tblcomplaints(userId,category,subcategory,complaintType,state,noc,complaintDetails,complaintFile) values('$uid','$category','$subcat','$complaintype','$state','$noc','$complaintdetials','$compfile')");

$sql=mysqli_query($bd, "select complaintNumber from tblcomplaints order by complaintNumber desc limit 1");
while($row=mysqli_fetch_array($sql))
{
 $cmpn=$row['complaintNumber'];
}
$complainno=$cmpn;
echo '<script> alert("Your complaint has been successfully filed and your complaint number is '.$complainno.'")</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>CMS | User Register Complaint</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    
    <!-- Added script for subcategory dynamic loading -->
    <script>
      function getSubcategories() {
        var category = document.getElementById("category").value;
        var subcategory = document.getElementById("subcategory");

        subcategory.innerHTML = ""; // Clear previous options

        if(category == "Fashion") {
          var options = ['Clothes', 'Footwear', 'Accessories'];
        } else if(category == "Electronics") {
          var options = ['Mobiles', 'Laptops', 'Cameras'];
        } else if(category == "Automobiles") {
          var options = ['Cars', 'Bikes', 'Scooters'];
        } else if(category == "Food") {
          var options = ['Groceries', 'Restaurants', 'Snacks'];
        } else {
          var options = [];
        }

        // Add new options dynamically
        for(var i = 0; i < options.length; i++) {
          var opt = document.createElement("option");
          opt.value = options[i];
          opt.innerHTML = options[i];
          subcategory.appendChild(opt);
        }
      }
    </script>

  </head>

  <body>

  <section id="container" >
     <?php include("includes/header.php");?>
      <?php include("includes/sidebar.php");?>
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Register Complaint</h3>
          	
          	<!-- BASIC FORM ELEMENTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                  	

                      <?php if($successmsg)
                      { ?>
                      <div class="alert alert-success alert-dismissable">
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <b>Well done!</b> <?php echo htmlentities($successmsg);?></div>
                      <?php } ?>

                      <?php if($errormsg)
                      { ?>
                      <div class="alert alert-danger alert-dismissable">
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <b>Oh snap!</b> <?php echo htmlentities($errormsg);?></div>
                      <?php } ?>

                      <form class="form-horizontal style-form" method="post" name="complaint" enctype="multipart/form-data" >

                        <!-- Category and Subcategory -->
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Category</label>
                          <div class="col-sm-4">
                            <select name="category" id="category" class="form-control" onChange="getSubcategories();" required>
                              <option value="">Select Category</option>
                              <option value="Fashion">Fashion</option>
                              <option value="Electronics">Electronics</option>
                              <option value="Automobiles">Automobiles</option>
                              <option value="Food">Food</option>
                            </select>
                          </div>

                          <label class="col-sm-2 col-sm-2 control-label">Sub Category</label>
                          <div class="col-sm-4">
                            <select name="subcategory" id="subcategory" class="form-control">
                              <option value="">Select Subcategory</option>
                            </select>
                          </div>
                        </div>

                        <!-- Complaint Type and State -->
                        <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Complaint Type</label>
                          <div class="col-sm-4">
                            <select name="complaintype" class="form-control" required>
                              <option value="Complaint">Complaint</option>
                              <option value="General Query">General Query</option>
                            </select>
                          </div>

                          <label class="col-sm-2 col-sm-2 control-label">State</label>
                          <div class="col-sm-4">
                            <select name="state" required="required" class="form-control">
                              <option value="">Select State</option>
                              <option value="Uttar Pradesh">Uttar Pradesh</option>
                              <option value="Maharashtra">Maharashtra</option>
                              <option value="Delhi">Delhi</option>
                              <option value="Bihar">Bihar</option>
                              <?php 
                              $sql=mysqli_query($bd, "select stateName from state ");
                              while ($rw=mysqli_fetch_array($sql)) {
                              ?>
                              <option value="<?php echo htmlentities($rw['stateName']);?>"><?php echo htmlentities($rw['stateName']);?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <!-- Other Fields -->
                        <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Nature of Complaint</label>
                          <div class="col-sm-4">
                            <input type="text" name="noc" required="required" class="form-control">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Complaint Details (max 2000 words)</label>
                          <div class="col-sm-6">
                            <textarea name="complaindetails" required="required" cols="10" rows="10" class="form-control" maxlength="2000"></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Complaint Related Doc (if any)</label>
                          <div class="col-sm-6">
                            <input type="file" name="compfile" class="form-control">
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-10" style="padding-left:25%">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>

                      </form>
                    </div>
                  </div>
                </div>
          </section>
        </section>
      <?php include("includes/footer.php");?>
  </section>
  <!-- JS Scripts -->
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
  <script src="assets/js/jquery.scrollTo.min.js"></script>
  <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="assets/js/common-scripts.js"></script>
  <script src="assets/js/form-component.js"></script>

  </body>
</html>
<?php } ?>
