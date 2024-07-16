<!--LOGIN-->
<?php
	if(isset($_POST['btnLogin']))
	{
		require_once "config.php";

		$sql = "SELECT * FROM tbluseraccount WHERE Library_Access_ID = ? AND Password = ? AND Status = 'Approved'";

		if($stmt = mysqli_prepare($link, $sql))
		{
			mysqli_stmt_bind_param($stmt, "ss", $_POST['txtUsername'], $_POST['txtPassword']);

			if(mysqli_stmt_execute($stmt))
			{
				$result = mysqli_stmt_get_result($stmt);
				if(mysqli_num_rows($result) > 0)
				{
					$account = mysqli_fetch_array($result, MYSQLI_ASSOC);

					session_start();
					$_SESSION['username'] = $_POST['txtUsername'];
					$_SESSION['Student_Name'] = $account['Student_Name'];
					$_SESSION['UserType'] = $account['userType'];
					header("location: SearchBook.php");
				}
				else
				{
					echo "Incorrect Login or Status is not yet Approved";
				
				}
			}
		}
		else
		{
			echo "Error on select statement";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="UTF-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	    <title>Arellano Library Management</title>
	    <link rel="icon" type="image/x-icon" href="../Image/online-library.png">
	    <link rel="stylesheet" href="../CSS/bootstrap.min.css" />

	    <link rel="stylesheet" href="../CSS/backtotop.css" />
	    <link rel="stylesheet" href="../CSS/meetTheTeam.css" />
	    <link rel="stylesheet" href="../CSS/footer.css" />
	    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../CSS/comboboxShit.css">
		<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
		<script src="../JS/jquery-3.6.3.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	    <script>
	   $(document).ready(function(){
	      $('[data-toggle="tooltip"]').tooltip();
	   });
	   </script>
	    <style>
	    	html {
				scroll-behavior: smooth;
			}
	      	.banner-image {
		        background-image: url('../Image/BG.jpeg');
		        background-size: cover;
	      	}
	      	#example1 {
				height: 1000px;
				padding-top: 200px;
			}
			#example2 {
			  	padding: 80px;
			  	background: url(../Image/bg2.jpeg);
			  	background-position: center;
			  	background-repeat: no-repeat;
			  	background-size: cover;
			}
			#section2 {
			  	height: 600px;
			  	background-color: yellow;
			}
			#button {
				 color:black; 
			     width: 250px;
			     height: 50px;
			     border:none;
			     border:solid 2px black;
			     border-radius: 5px;
			     background: rgba(250,250,250,0.5);
			     font-size: 25px;
			     border-radius: 75px;
			}

			#button:hover {
			     background:black;
			     color:white; 
			}
			.box1 {
			  width: 470px;
			  padding: 10px;
			  border: 5px solid black;
			  margin: 0;
			}
	    </style>
  	</head>
  	<body>
	  	<button type="button" class="btn btn-danger btn-floating btn-lg" id="btn-back-to-top">Top </button>
	    <!-- Navbar  -->
	    <nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3">
	      <div class="container">
	        <a class="navbar-brand" href="#">Arellano Library Management</a>
	        <button
	          class="navbar-toggler"
	          type="button"
	          data-bs-toggle="collapse"
	          data-bs-target="#navbarNav"
	          aria-controls="navbarNav"
	          aria-expanded="false"
	          aria-label="Toggle navigation"
	        >
	          <span class="navbar-toggler-icon"></span>
	        </button>

	        <div class="collapse navbar-collapse" id="navbarNav">
	          <div class="mx-auto"></div>
	          <ul class="navbar-nav">
	            <li class="nav-item">
	              <a class="nav-link text-white" href="mainpage.php">Home</a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link text-white" href="#example1">About Us</a>
	            </li>	            
	            <li class="nav-item">
	              <a class="nav-link text-white" href="#example2">Contact</a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link text-white" href="#myModal" class="trigger-btn" data-toggle="modal">Login</a>
	            </li>
	          </ul>
	        </div>
	      </div>
	    </nav>

	    <!-- Banner Image  -->
	    <div class="banner-image w-100 vh-100 d-flex justify-content-center align-items-center">
	    	<div class="content text-center">
		    	<h1 class="text-white">
		    		<form action="#">
		    			<button id="button">Get Started</button>
		    		</form>
		    	</h1>
		    </div>
	    </div>	
	    <div id="example1">
			<div class="container">
	      		<div class="section-title">
		            <h1>Our Team Page</h1>
		        </div>
			    <div class="row">
			        <div class="col-md-3 col-sm-6">
			            <div class="our-team">
			                <img src="../Image/gab.jpg" alt="">
			                <div class="team-content">
			                    <h3 class="title">Edmarc Camacho</h3>
			                    <span class="post">Maingay</span>
			                    <ul class="social-links">
			                        <li><a href="#"><i class="fab fa-facebook"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-google-plus"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-twitter"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-linkedin"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-pinterest-p"></i> </a></li>
			                    </ul>
			                </div>
			            </div>
			        </div>	
			        <div class="col-md-3 col-sm-6">
			            <div class="our-team">
			                <img src="../Image/renzelle.jpg" alt="">
			                <div class="team-content">
			                    <h3 class="title">Renzelle Apolinario</h3>
			                    <span class="post">Taga luto ng pancit canton</span>
			                    <ul class="social-links">
			                        <li><a href="#"><i class="fab fa-facebook"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-google-plus"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-twitter"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-linkedin"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-pinterest-p"></i> </a></li>
			                    </ul>
			                </div>
			            </div>
			        </div>
			        <div class="col-md-3 col-sm-6">
			            <div class="our-team">
			                <img src="../Image/charlie.jpg" alt="">
			                <div class="team-content">
			                    <h3 class="title">Charlie Gutierrez</h3>
			                    <span class="post">Leader na Malupet</span>
			                    <ul class="social-links">
			                        <li><a href="#"><i class="fab fa-facebook"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-google-plus"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-twitter"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-linkedin"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-pinterest-p"></i> </a></li>
			                    </ul>
			                </div>
			            </div>
			        </div>
			        <div class="col-md-3 col-sm-6">
			            <div class="our-team">
			                <img src="../Image/jam.jpg" alt="">
			                <div class="team-content">
			                    <h3 class="title">Jemille Galarosa</h3>
			                    <span class="post">Taga timpla ng kape</span>
			                    <ul class="social-links">
			                        <li><a href="#"><i class="fab fa-facebook"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-google-plus"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-twitter"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-linkedin"></i> </a></li>
			                        <li><a href="#"><i class="fab fa-pinterest-p"></i> </a></li>
			                    </ul>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
		<div>
			<img src="Reg.GIF" width="100%">
		</div>
		<!--MODAL Login-->
		<div id="myModal" class="modal fade">
			<div class="modal-dialog modal-login">
				<div class="modal-content">
					<div class="modal-header">			
						<h4 class="modal-title">User Login</h4>	
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
							<div class="form-group">
								<input type="text" class="form-control" name="txtUsername" placeholder="Library Access ID" required="required">		
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="txtPassword" placeholder="Password " required="required">	
							</div>        
							<div class="form-group">
								<button type="submit" name = "btnLogin" class="btn btn-primary btn-lg btn-block login-btn" value="Login">Login</button>
							</div>
						</form>
						<div>
                            <div class="checkbox">
                                    <input type="checkbox" name="remember"> Remember Me
                                    <a href="#">Forgot Password?</a>
                            </div>
                        </div>
					</div>
					<div class="modal-footer text-xs-center">
		                Don't have an account? <a href="#myModalsignup" class="trigger-btn" data-toggle="modal" data-dismiss="modal">Sign up »</a>
		            </div>
				</div>
			</div>
		</div>
		<!--SIGNUP-->
		<?php
			require_once "config.php";
			date_default_timezone_set('Asia/Manila');
			if(isset($_POST['btnSignUp']))
			{
				$img = $_FILES['txtImage']['name'];
				$folderLocation ='C:/Users/charl/Desktop/LibraryManagementSystem/LibraryManagementSystem/LibraryManagementSystem/bin/Debug/ImageStudent';
				$sql = "SELECT * FROM tbluseraccount WHERE ID_Number = ?";
				if($stmt = mysqli_prepare($link, $sql))
				{
					mysqli_stmt_bind_param($stmt, "s", $_POST['txtIDNumber']);
					if(mysqli_stmt_execute($stmt))
					{
						$result = mysqli_stmt_get_result($stmt);
						if(mysqli_num_rows($result) != 1)
						{
							$sql = "INSERT INTO tbluseraccount (Image, ID_Number, Password, Student_Name, Course, Email_ID, userType, Mobile_Number, Reg_Date, Status) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
							if($stmt = mysqli_prepare($link, $sql))
							{
								$status = 'WAITING FOR APPROVAL';
								$Date = date('Y-m-d');
								mysqli_stmt_bind_param($stmt, "ssssssssss", $img, $_POST['txtIDNumber'], $_POST['txtPassword'], $_POST['txtName'], $_POST['txtCourse'], $_POST['txtEmail'], $_POST['txtuserType'], $_POST['txtMobile'], $Date, $status);
								if(mysqli_stmt_execute($stmt))
		                        {
									move_uploaded_file($_FILES['txtImage']['tmp_name'], "$folderLocation/$img");
		                            echo "<script>
											swal({
											  title:'Wait for Approval',
											  text: 'Wait three to five days while your account is on verification.',
											  icon: 'warning',
											});
										</script>";
		                        }
		                        else
		                        {
		                            echo "<script>
											swal({
											  title:'Error...',
											  text: 'Error On Insert Statement!',
											  icon: 'error',
											});
										</script>";
		                        }
							}
						}
						else
						{
							echo "<script>
									swal({
									  title:'Error...',
									  text: 'ID Number is already existing!',
									  icon: 'error',
									});
								</script>";
						}
					}
					else
					{
						echo "<script>
								swal({
								  title:'Error...',
								  text: 'Error on select statement',
								  icon: 'error',
								});
							</script>";
					}
				}
			}
		?>
		<!--MODAL signup-->
		<div id="myModalsignup" class="modal fade">
			<div class="modal-dialog modal-login">
				<div class="modal-content">
					<div class="modal-header">			
						<h4 class="modal-title">Register Account</h4>	
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST" enctype="multipart/form-data">
							<div class="form-group">
								<input type="text" class="form-control" name="txtIDNumber" placeholder="LRN No. / Student No. / Registration Form No. / Faculty ID No. / Employee ID No.:" required="required">		
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="txtName" placeholder="Name" required="required">	
							</div> 
							<div class="form-group">
								<input type="password" class="form-control" name="txtPassword" placeholder="Password " required="required">	
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="txtCourse" placeholder="Course" required="required">	
							</div> 
							<div class="form-group">
								<input type="text" class="form-control" name="txtEmail" placeholder="Email" required="required">	
							</div>
							<div class="form-group">
								<div class="select" style="width:auto">
								  <select id="standard-select" name = "txtuserType" class = "box" required>
								  	<option value="">Type of Library User:</option>
								  	<option value="College Student">College Student</option>
								    <option value="Faculty">Faculty</option>
								  </select>
								  <span class="focus"></span>
								</div>	
							</div>
							<div class="form-group">
								<div class ="box1">
									Attach any of the following: For Student (Registration Form) / For Faculty (Faculty ID) / For Employee (Employee ID) / For SHS Faculty (Topserve ID)  
									<input type="file" multiple accept="image/*" name="txtImage" required="required">
								</div>									
							</div> 
							<div class="form-group">
								<input type="text" class="form-control" name="txtMobile" placeholder="Mobile Number" required="required">	
							</div>        
							<div class="form-group">
								<button type="submit" name = "btnSignUp" class="btn btn-primary btn-lg btn-block login-btn" value="SignUp">SignUp</button>
							</div>
						</form>
						<div>
                            By signing up, you agree to the Terms of Service and Privacy Policy, including Cookie Use.
                        </div>
					</div>
					<div class="modal-footer text-xs-center">
		                Have an account already?<a href="#myModal" class="trigger-btn" data-toggle="modal" data-dismiss="modal">Log in »</a>
		            </div>
				</div>
			</div>
		</div> 
	    <div class="footer-dark">
	        <footer>
	            <div class="container">
	                <div class="row">
	                    <div class="col-sm-6 col-md-3 item">
	                        <h3>Services</h3>
	                        <ul>
	                            <li><a href="#">Web design</a></li>
	                            <li><a href="#">Development</a></li>
	                            <li><a href="#">Hosting</a></li>
	                        </ul>
	                    </div>
	                    <div class="col-sm-6 col-md-3 item">
	                        <h3>About</h3>
	                        <ul>
	                            <li><a href="#">Company</a></li>
	                            <li><a href="#">Team</a></li>
	                            <li><a href="#">Careers</a></li>
	                        </ul>
	                    </div>
	                    <div class="col-md-6 item text">
	                        <h3>Company Name</h3>
	                        <p>Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus. Aliquam in arcu eget velit pulvinar dictum vel in justo.</p>
	                    </div>
	                    <div class="col item social"><a href="#"><i class="fab fa-facebook"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-snapchat"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div>
	                </div>
	                <p class="copyright">© Arellano Library 2023</p>
	            </div>
	        </footer>
	    </div>
	</body>
</html>
<script src="bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
      var nav = document.querySelector('nav');

      window.addEventListener('scroll', function () {
        if (window.pageYOffset > 100) {
          nav.classList.add('bg-dark', 'shadow');
        } else {
          nav.classList.remove('bg-dark', 'shadow');
        }
      });
		      //Get the button
		let mybutton = document.getElementById("btn-back-to-top");

		// When the user scrolls down 20px from the top of the document, show the button
		window.onscroll = function () {
		  scrollFunction();
		};

		function scrollFunction() {
		  if (
		    document.body.scrollTop > 20 ||
		    document.documentElement.scrollTop > 20
		  ) {
		    mybutton.style.display = "block";
		  } else {
		    mybutton.style.display = "none";
		  }
		}
		// When the user clicks on the button, scroll to the top of the document
		mybutton.addEventListener("click", backToTop);

		function backToTop() {
		  document.body.scrollTop = 0;
		  document.documentElement.scrollTop = 0;
		}
    </script>