<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Dashboard</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
		<link href="assets/css/style.css" rel="stylesheet" />

     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><img src="assets/images/logo.png" alt="logo"></a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"><a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				
                    <li>
                        <a  href="view_profile_S.php"><i class="fa fa-user fa-2x"></i> Profile</a>
                    </li>
				    <li>
                        <a   href="welcome_student.php"><i class="fa fa-home fa-2x"></i> Welcome Page</a>
                    </li>
					
                    <li>
                        <a  href="student_study_material_download.php"><i class="fa fa-download fa-2x"></i> Study Material Download</a>
                    </li>	
                      <li  >
                        <a  href="student_assignment_upload.php"><i class="fa fa-upload fa-2x"></i> Assignment Upload</a>
                    </li>
                    <li  >
                        <a  href="student_view_assignment.php"><i class="fa fa-download fa-2x"></i> Assignment Download </a>
                    </li>				
					
					
                  <li>
                        <a  href="Exam_fees_check.php"><i class="fa fa-pencil-square-o fa-2x"></i> Giving Exams</a>
                    </li>	
					<li>
                        <a class="active-menu" href="#"><i class="fa fa-users fa-2x"></i> Discussion Forum</a>
                    </li>	
					<li>
                        <a  href="notice_board.php"><i class="fa fa-bell-o fa-2x"></i> Notice Board</a>
                    </li>		
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
					<center>
					<img src="assets/images/logo1.png" alt="logo">
					<p> <br> </p>
                      <h2><u>Discussion Forum</u></h2>   
                        </center>
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
				 
				 
				 
				 <div id="templatemo_content_wrapper" >
				 <center>
        <div id="templatemo_content"  >
        
            <div class="content_box" >
            
                <h2><center><u><b><font color="blue">Index</font></b></u></center></h2>
                
               

                  <form action="/action_page.php">
                    <div class="imgcontainer" style=" margin-right: 10px; margin-left: 10px">
					<center>
                    <table class="table table-responsive table-striped table-hover table-bordered" style="overflow-y: hidden; width: 100%; margin-left: 0px;">
                      <tr>
                        <th style="text-align: left; width: 20px;">
                          <h4>Sl. No.</h4>
                        </th>
                        <th style="text-align: center; width: 50px;">
                          <h4>Discussion Topic </h4> 
                        </th>
                        <th style="text-align: center; width: 40px;">
                          <h4>Date </h4>  
                        </th>
                        
                      </tr>
					<tr> <td> </td> <td> </td> <td> </td> </tr>
					  
                    </table> </center>
                  </form>

<button type="button" onclick="asd(1)" style="background-color:#D6DBDC; color:black; margin:0px; padding:0px;" text-align="left">Start New Discussion</button>
<p> <br></p>
	<div id="demo">
    <center>
    <form id="asd" action="">
    <textarea class="input" rows="3" columns="10" placeholder="Topic" name="topic"></textarea>
    <center><h5 text-align="center"><b>Audience:</b><br></h5></center>
    <input type="radio" name="all teacher" value="all teacher"> All teachers <br><br>
    <input type="radio" name="student" value="student"> Two Students <br><br>
    <input type="radio" name="all"value="all"> All teachers and students <br><br>
    <textarea class="input" rows="10" columns="10" placeholder="Details" name="details"></textarea>
</center>
    </div>

                <div class="cleaner"></div>
            </div>
            </div> <!-- end of content -->
        
        <div class="cleaner"></div>

    </div>
</center>
    
    </div>
	
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
                 <hr />
               
    </div>
            
            </div>
       
        </div>
    
	
	
	
	
	<script type="text/javascript" src="jsfile/discussion_forum_S/s1.js">

</script>

	
	
	
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>