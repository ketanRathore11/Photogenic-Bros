<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
	$msg ='';
	$msgClass ='';
	//Check for submit
	if(filter_has_var(INPUT_POST,'submit')){
	//Get Data//
		$email    = htmlspecialchars($_POST['email']);
		$password = $_POST['password'];
		$checkbox = $_POST['checkbox'];

		//Check required fields
		if(!empty($email) && !empty($password) && !empty($checkbox)){
			//passed
			//Check email
			if(filter_var($email,FILTER_VALIDATE_EMAIL) === false){
				//Failed
				$msg = 'Please fill valid email';
				$msgClass ='alert-danger';

			} else{
				//email passed

				$host = 'localhost';
				$dbUsername = 'id9088363_pg';
				$dbPassword = 'wecreateillusions';
				$dbName = 'id9088363_pgbros';
				//create connection
				$connection = new mysqli($host,$dbUsername,$dbPassword,$dbName);

					if(mysqli_connect_error() ){
						die('Connection Error('.mysqli_connect_errno().')'.mysqli_connect_error() );
					} else{
						$select = "SELECT email From signup Where email = ? Limit 1 ";
						$insert = "INSERT Into signup (email,password) values(?,?)";
					
						//Prepare Statement 
						$stmt = $connection->prepare($select);
						$stmt->bind_param("s",$email);
						$stmt->execute();
						$stmt->bind_result($email);
						$stmt->store_result();
						$rnum = $stmt->num_rows;

						if($rnum==0){
							$stmt->close();
							$stmt = $connection->prepare($insert);
							$stmt->bind_param("ss",$email,$password);
							$stmt->execute();
							$msg = 'Sign-up Successfull';
							$msgClass ='alert-success';
						} else{
							$msg = 'Someone already register using this email !';
							$msgClass ='alert-danger';
						}
						$stmt->close();
						$connection->close();
					}

					//$msg = 'Sign-up Successfull';
					//$msgClass ='alert-success';
			}

		} else{
			$msg = 'Please fill all fields';
			$msgClass ='alert-danger';
		}

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign-Up</title>
	 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/signup.css">
    <style >
        .bg{
          background-image: url('images/bokeh.jpg');
          background-size: cover;
          width: 100%;
          height: 100vh;
          :no-repeat;
         }      
    </style>
   
</head>
<body class="bg">

	<!--Navbar-->
            <nav class="navbar navbar-inverse ">
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" target="blank" href="index.html">Home</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a target="blank" href="gallery.html">Gallery</a></li>
                <li><a target="blank" href="signup.php">Sign Up</a></li>
                 <li><a target="blank" href="contact.html">Contact</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a target="blank" href="about.html">About Us</a></li>
                    <li><a target="blank" href="https://www.instagram.com/photogenic_bros/?utm_source=ig_profile_share&igshid=i0ja1ko8xd7w">Our Instagram</a></li> 
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>

        <!--Form-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12"></div>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <!--Form Start-->
              <?php if($msg !=''): ?>
              	<div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
              <?php endif; ?>
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form">
                <h3 class="typo">Sign-Up</h3>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" 
                    value="<?php echo isset($_POST['email']) ? $email : '' ; ?> ">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="checkbox">
                    <label>
                      <input name="checkbox" type="checkbox"> Check me out
                    </label>
                  </div>
                  <button type="submit" name="submit" class="btn btn-success btn-block">Submit</button>
              </form>

              <!--Form End-->
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12"></div>
          </div>
        </div>

        <footer class="footer">
     
      <p>
        Copyright &copy; 2019 By &ensp;Ketan Rathore 
        <a target="blank" href="https://www.instagram.com/photogenic_bros/?utm_source=ig_profile_share&igshid=i0ja1ko8xd7w">
          <img class="insta" src="images/insta.jpg">
        </a> 
       <a target="blank" href="https://www.Facebook.com">
          <img class="facebook" src="images/fb.jpg">
        </a>
      </p>

    </footer>
</body>
</html>