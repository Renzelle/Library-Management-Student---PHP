<?php
    include("session-checker.php");
?>
<!DOCTYPE html>
<!-- Designined by CodingLab | www.youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title>Library Management Student</title>
        <link rel="stylesheet" href="../CSS/Book.css">
        <link rel="stylesheet" href="../CSS/table1.css">
        <link rel="stylesheet" href="../CSS/Detail.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            var checkbox = $('table tbody input[type="checkbox"]');

            $("#chk_all").click(function(){
                if(this.checked){
                    checkbox.each(function(){
                        this.checked = true;                        
                    });
                } else{
                    checkbox.each(function(){
                        this.checked = false;                        
                    });
                } 
            });

            checkbox.click(function(){
                if(!this.checked){
                    $("#chk_all").prop("checked", false);
                }
            });
        });
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        </script>
        <!-- Boxicons CDN Link -->
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus'></i>
            <span class="logo_name">Group 6</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="SearchBook.php">
                    <i class='bx bx-box' ></i>
                    <span class="links_name">Book</span>
                </a>
            </li>
            <li>
                <a href="IssuedBook.php">
                    <i class='bx bx-list-ul' ></i>
                    <span class="links_name">Issued Books</span>
                </a>
            </li>
            <li>
                <a href="RequestBook.php">
                    <i class='bx bx-pie-chart-alt-2' ></i>
                    <span class="links_name">Requisition</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-message' ></i>
                    <span class="links_name">Messages</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-heart' ></i>
                    <span class="links_name">Favrorites</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-cog' ></i>
                    <span class="links_name">Setting</span>
                </a>
            </li>
            <li class="log_out">
                <a href="logout.php">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
    </div>
    <?php
        require_once "config.php";
        date_default_timezone_set('Asia/Manila');

        if(isset($_POST['btnSave']))
        {   
            $date = $_POST['txtDate'];

            // Check if the Pick up Date field is empty
            if(empty($date)) {
                $errors[] = "Pick up Date is required";
            }

            // If there are no errors, process the form data
            if(empty($errors)) {
                $user = $_SESSION['Student_Name'];
                $accession = $_POST['txtAccession'];

                // check if record with given accession exists
                $sql = "SELECT * FROM tblbookrequest WHERE Accession = ? AND User = ?";
                if($stmt = mysqli_prepare($link, $sql))
                {
                    mysqli_stmt_bind_param($stmt, "ss", $accession, $user);
                    if(mysqli_stmt_execute($stmt))
                    {
                        $result = mysqli_stmt_get_result($stmt);
                        if(mysqli_num_rows($result) != 1)
                        {
                            // record not found, insert new record
                            $insertSql = "INSERT INTO tblbookrequest (Accession, Title, Author, Department, Status, Date_Pickup, User, Library_ID) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
                            if($insertStmt = mysqli_prepare($link, $insertSql))
                            {

                                $status = 'WAITING FOR APPROVAL';
                                mysqli_stmt_bind_param($insertStmt, "ssssssss", $accession, $_POST['txtTitle'], $_POST['txtAuthor'], $_POST['txtDepartment'], $status, $_POST['txtDate'], $_POST['txtUser'], $_POST['txtLibraryID']);
                                if(mysqli_stmt_execute($insertStmt))
                                {
                                    echo "<script>
                                        swal({
                                            title:'Wait for Approval',
                                            text: 'Wait three to five days while your account is on verification.',
                                            icon: 'warning',
                                        }).then(() => {
                                            location.reload();
                                         });
                                    </script>";
                                }
                                else
                                {
                                    echo "<script>
                                        swal({
                                            icon: 'error',
                                            title: 'Error...',
                                            text: 'Error On Insert Statement!',
                                        }).then(() => {
                                            location.reload();
                                         });
                                    </script>";
                                }
                            }
                            else
                            {
                                echo "<script>
                                    swal({
                                        icon: 'error',
                                        title: 'Error...',
                                        text: 'Error On Prepare Insert Statement!',
                                    }).then(() => {
                                        location.reload();
                                     });
                                </script>";
                            }
                        }
                        else
                        {
                            echo "<script>
                                    swal({
                                        icon: 'error',
                                        title: 'Error...',
                                        text: 'Book is already on request!',
                                    }).then(() => {
                                        location.reload();
                                     });
                                </script>";
                        }
                    }
                    else
                    {
                        echo "<script>
                                swal({
                                    icon: 'error',
                                    title: 'Error...',
                                    text: 'Error On Select Statement!',
                                    }).then(() => {
                                        location.reload();
                                     });
                            </script>";
                    }
                }
            }
        }
        //REQUEST CHECKBOX
        require_once "config.php";
        if(isset($_POST['chk_id']))
        {
            $date = $_POST['txtDate1'];
            // Check if the Pick up Date field is empty
            if(empty($date)) {
                $errors[] = "Pick up Date is required";
            }
            // If there are no errors, process the form data
            if(empty($errors)) 
            {
                $user = $_SESSION['Student_Name'];
                $arr = $_POST['chk_id'];
                foreach ($arr as $id) 
                {
                    $user = $_SESSION['Student_Name'];

                    $sql = "SELECT * FROM tblbooksinformation WHERE Accession = ? AND Status = ?";
                    if($stmt = mysqli_prepare($link, $sql))
                    {   
                        $status1 = "Available";
                        mysqli_stmt_bind_param($stmt, "ss", $id, $status1);
                        if(mysqli_stmt_execute($stmt))
                        {
                            $result = mysqli_stmt_get_result($stmt);
                            if(mysqli_num_rows($result) > 0)
                            {     
                                $row = mysqli_fetch_assoc($result);
                                if($row['Type'] == 'Books') {
                                    $insertSql = "UPDATE tblbooksinformation SET StatusRequest = ?, requestedBy = ?, dateRequest = ? WHERE Accession = ?";
                                    if($insertStmt = mysqli_prepare($link, $insertSql))
                                    {
                                        $status = 'WAITING FOR APPROVAL';
                                        mysqli_stmt_bind_param($insertStmt, "ssss", $status, $user, $date, $id);
                                        if(mysqli_stmt_execute($insertStmt))
                                        {
                                            echo "<script>
                                                swal({
                                                    title:'Wait for Approval',
                                                    text: 'Wait three to five days while your request is on verification.',
                                                    icon: 'warning',
                                                }).then(() => {
                                                    location.reload();
                                                 });
                                            </script>";
                                        }
                                        else
                                        {
                                            echo "<script>
                                                swal({
                                                    icon: 'error',
                                                    title: 'Error...',
                                                    text: 'Error On Insert Statement!',
                                                }).then(() => {
                                                    location.reload();
                                                 });
                                            </script>";
                                        }
                                    }
                                    else
                                    {
                                        echo "<script>
                                            swal({
                                                icon: 'error',
                                                title: 'Error...',
                                                text: 'Error On Prepare Insert Statement!',
                                            }).then(() => {
                                                location.reload();
                                             });
                                        </script>";
                                    }
                                }
                                else {
                                    echo "<script>
                                            swal({
                                                icon: 'error',
                                                title: 'Error...',
                                                text: 'The Category must be Books Only',
                                            }).then(() => {
                                                location.reload();
                                             });
                                        </script>";
                                }
                            }
                            else
                            {
                                echo "<script>
                                        swal({
                                            icon: 'error',
                                            title: 'Error...',
                                            text: 'The selected book is not available.',
                                        }).then(() => {
                                            location.reload();
                                         });
                                    </script>";
                            }
                        }
                        else
                        {
                            echo "<script>
                                    swal({
                                        icon: 'error',
                                        title: 'Error...',
                                        text: 'Error On Select Statement!',
                                        }).then(() => {
                                            location.reload();
                                         });
                                </script>";
                        }
                    }
                }
            }
        }
    ?>
    <!-- Display any error messages -->
    <script>
        <?php if(!empty($errors)): ?>
            // Create an empty error message string
            var errorMessage = "";

            <?php foreach($errors as $error): ?>
                // Add each error message to the string
                errorMessage += "<?php echo $error ?>\n";
            <?php endforeach; ?>

            // Display the error message using SweetAlert
            swal({
                title: "Error",
                text: errorMessage,
                icon: "error",
            });
        <?php endif; ?>
    </script>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Book</span>
            </div>
            <div class="profile-details">
                <img src="../Image/profile original.png" alt="">
                <span class="admin_name"><?php echo $_SESSION['Student_Name'] ?></span>
                <i class='bx bx-chevron-down' ></i>
            </div>
        </nav>
        <!--MAIN PAGE-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
            <div class="home-content">
                <div class="container-xl">
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h2>Library <b>Management</b></h2>
                                    </div>
                                    <div class="col-sm-8">                      
                                        <a href="#" class="btn btn-primary"><i class="material-icons">&#xE863;</i> <span>Refresh List</span></a>
                                        <a href="#requestBook" class="btn btn-success" data-toggle="modal" style="background-color: #218838; color:#FFFFFF"><i class="material-icons">&#xE147;</i><span>Request</span></a>
                                    </div>  
                                </div>
                            </div>
                            <div class="table-filter">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="filter-group">
                                            <label>category</label>
                                            <select class="form-control">
                                                <?php
                                                    $sql = "SELECT * FROM category WHERE Category <> ? ORDER BY Category";
                                                    if($stmt = mysqli_prepare($link, $sql))
                                                    {
                                                        mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                                                        if(mysqli_stmt_execute($stmt))
                                                        {
                                                            $result = mysqli_stmt_get_result($stmt);
                                                            build_table1($result);   
                                                        }
                                                    }
                                                    function build_table1($result)
                                                    {
                                                        if(mysqli_num_rows($result) > 0)
                                                        {
                                                            while($row = mysqli_fetch_array($result))
                                                            {
                                                                ?>
                                                                <option value = "<?php echo $row['Category']?>"><?php echo $row['Category'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                ?>                             
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary" name="btnSearch"><i class="fa fa-search"></i></button>
                                        <div class="filter-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Search.." name="txtSearch">
                                        </div>
                                        <div class="filter-group">
                                            <label>Status</label>
                                            <select class="form-control">
                                                <option>Any</option>
                                                <option>Delivered</option>
                                                <option>Shipped</option>
                                                <option>Pending</option>
                                                <option>Cancelled</option>
                                            </select>
                                        </div>
                                        <span class="filter-icon"><i class="fa fa-filter"></i></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                                function build_table($result)
                                {
                                    if(mysqli_num_rows($result) > 0)
                                    {
                                        echo "<table class='table table-striped table-hover'>";
                                            echo "<tr>";
                                                echo "<th>
                                                        <span class='custom-checkbox'>
                                                            <input type='checkbox' id='chk_all'>
                                                            <label for='selectAll' name = 'chk_all'></label>
                                                        </span>
                                                    </th>";
                                                echo "<th>Accession</th>";
                                                echo "<th>Title</th>";
                                                echo "<th>Author</th>";
                                                echo "<th>Subject</th>";
                                                echo "<th>Department</th>";
                                                echo "<th>Category</th>";
                                                echo "<th>Action</th>";
                                            echo "</tr>";    
                                            echo "<br>";
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            $Primary_key = $row['Accession'];
                                            $ID = $row['Id'];
                                            echo "<tr>";
                                                ?>
                                                <td>
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="checkbox2" name="chk_id[]" value="<?php echo $row['Accession'];?>">
                                                        <label for="checkbox2"></label>
                                                    </span>
                                                </td>
                                                <td><?php echo $row['Accession']; ?></td>
                                                <td><?php echo $row['Title']; ?></td>
                                                <td><?php echo $row['Author']; ?></td>
                                                <td><?php echo $row['Subject']; ?></td>
                                                <td><?php echo $row['Department']; ?></td>
                                                <td><?php echo $row['Type']; ?></td>

                                                <td>
                                                <?php
                                                    echo "<a class='btn btn-primary' data-id='$Primary_key' data-toggle='modal' style='font-weight: bold; width: 100%; background-color: #03A9F4; color:#FFFFFF' href='#Details$Primary_key'> Details </a>";

                                                    echo "<a class='btn btn-primary' data-id='$Primary_key' data-toggle='modal' style='font-weight: bold; width: 100%; background-color: #218838; color: #ffffff;' href='#Request$Primary_key'>Request</a>";
                                                ?>
                                                </td>
                                            <?php
                                            echo "</tr>";
                                                ?> 
                                            <!--REQUEST MULTIPLE-->
                                            <div id="requestBook" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">                      
                                                            <h4 class="modal-title">Cancel Request</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        </div>
                                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST" onsubmit="return validateForm()">   
                                                            <div class="modal-body">                    
                                                                <div class="form-group">
                                                                    <span class="details">Pick up Date</span>
                                                                    <input type="date" class="form-control" name="txtDate1" id="txtDate">   
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                                                <input type="submit" class="btn btn-danger" id="submit" name="submit" style='font-weight: bold; background-color: #C82333; color:#FFFFFF' value="Delete">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> 
                                            <!--REQUEST-->
                                            <div id="Request<?php echo $Primary_key;?>" class="modal fade">
                                                <div class="modal-dialog modal-login">
                                                    <div class="modal-content">
                                                        <div class="modal-header">          
                                                            <h4 class="modal-title">Request Book</h4>   
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        </div>
                                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST" onsubmit="return validateForm()">   
                                                            <div class="modal-body">      
                                                                <div class="form-group">
                                                                    <span class="details">Accession</span>
                                                                    <input type="text" class="form-control" name="txtAccession" value="<?php echo $Primary_key ?>" id=""  readonly="readonly"> 
                                                                </div>
                                                                <div class="form-group">
                                                                    <span class="details">Title</span>
                                                                    <input type="text" class="form-control" name="txtTitle" value="<?php echo $row['Title'] ?>" id=""  readonly="readonly">     
                                                                </div> 
                                                                <div class="form-group">
                                                                    <span class="details">Publisher</span>
                                                                    <input type="text" class="form-control" name="txtPublisher" value="<?php echo $row['Publisher'] ?>" id=""  readonly="readonly">     
                                                                </div>
                                                                <div class="form-group">
                                                                    <span class="details">Author</span>
                                                                    <input type="text" class="form-control" name="txtAuthor" value="<?php echo $row['Author'] ?>" id=""  readonly="readonly">     
                                                                </div>   
                                                                <div class="form-group">
                                                                    <span class="details">Department</span>
                                                                    <input type="text" class="form-control" name="txtDepartment" value="<?php echo $row['Department'] ?>" id=""  readonly="readonly">
                                                                </div> 
                                                                <hr>
                                                                <div class="form-group">
                                                                    <span class="details">User</span>
                                                                    <input type="text" class="form-control" name="txtUser" value="<?php echo $_SESSION['Student_Name'] ?>" id=""  readonly="readonly">     
                                                                </div> 
                                                                <div class="form-group">
                                                                    <span class="details">Library ID</span>
                                                                    <input type="text" class="form-control" name="txtLibraryID" value="<?php echo $_SESSION['username'] ?>" id="" readonly="readonly">
                                                                </div>
                                                                <div class="form-group">
                                                                    <span class="details">Pick up Date</span>
                                                                    <input type="date" class="form-control" name="txtDate" id="txtDate">   
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                                                <input type="submit" style="background-color: #218838;color: #FFFFFF" class="btn btn-info" name = "btnSave" value="Save">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>  
                                            <!--DETAILS-->
                                            <div id="Details<?php echo $Primary_key;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl ">
                                                    <div class="modal-content"> 
                                                        <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">      
                                                            <div class="container">
                                                                <div class="modal-header">                      
                                                                    <h4 class="modal-title">Book Details</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                </div>
                                                                <div class="content">
                                                                    <form action="#">
                                                                        <div class="user-details">
                                                                            <div class="input-box">
                                                                                <span class="details">Accession</span>
                                                                                <input type="text"  value="<?php echo $Primary_key ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Title</span>
                                                                                <input type="text" value="<?php echo $row['Title'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Author</span>
                                                                                <input type="text" value="<?php echo $row['Author'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Publisher</span>
                                                                                <input type="text" value="<?php echo $row['Publisher'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Subject</span>
                                                                                <input type="text" value="<?php echo $row['Subject'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Department</span>
                                                                                <input type="text" value="<?php echo $row['Department'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Quantity</span>
                                                                                <input type="text" value="<?php echo $row['Quantity'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Date Publish</span>
                                                                                <input type="text" value="<?php echo $row['DatePublish'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Type</span>
                                                                                <input type="text" value="<?php echo $row['Type'] ?>"  id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Location</span>
                                                                                <input type="text" value="<?php echo $row['Location'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Status</span>
                                                                                <input type="text" value="<?php echo $row['Status'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Page Number</span>
                                                                                <input type="text" value="<?php echo $row['PageNumber'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Item Weight</span>
                                                                                <input type="text" value="<?php echo $row['Location'] ?>" id="" disabled>
                                                                            </div>
                                                                            <div class="input-box">
                                                                                <span class="details">Language</span>
                                                                                <input type="text" value="<?php echo $row['Language'] ?>" id="" disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                                                            <input type="submit" style="background-color: #218838;color: #FFFFFF" class="btn btn-info" data-dismiss="modal" value="Okay">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div> 
                                                </div>
                                            </div>     
                                                <?php
                                        }
                                        echo "</table>";
                                    }
                                    else
                                    {
                                        echo "No data found";
                                    }
                                }

                                require_once "config.php";
                                // Determine the current page number
                                if (isset($_GET['page'])) {
                                    $page = intval($_GET['page']);
                                } else {
                                    $page = 1;
                                }

                                // Determine the number of records to display per page
                                $recordsPerPage = 10;

                                // Calculate the starting record number for the current page
                                $startRecord = ($page - 1) * $recordsPerPage;

                                // Construct the SQL query with LIMIT and OFFSET clauses
                                if (isset($_POST['btnSearch'])) {
                                    $sql = "SELECT * FROM tblbooksinformation WHERE Accession <> ? AND (Accession LIKE ? OR Title LIKE ? OR Author LIKE ? OR Subject LIKE ? OR Department LIKE ?) ORDER BY Accession LIMIT ? OFFSET ?";
                                    if ($stmt = mysqli_prepare($link, $sql)) {
                                        $searchValue = '%' . $_POST['txtSearch'] . '%';
                                        mysqli_stmt_bind_param($stmt, "ssssssii", $_SESSION['username'], $searchValue, $searchValue, $searchValue, $searchValue, $searchValue, $recordsPerPage, $startRecord);
                                        if (mysqli_stmt_execute($stmt)) {
                                            $result = mysqli_stmt_get_result($stmt);
                                            build_table($result);
                                        }
                                    } else {
                                        echo "Error on search";
                                    }
                                } else {
                                    $sql = "SELECT * FROM tblbooksinformation WHERE Accession <> ?  ORDER BY Accession LIMIT ? OFFSET ?";
                                    if ($stmt = mysqli_prepare($link, $sql)) {
                                        mysqli_stmt_bind_param($stmt, "sii", $_SESSION['username'], $recordsPerPage, $startRecord);
                                        if (mysqli_stmt_execute($stmt)) {
                                            $result = mysqli_stmt_get_result($stmt);
                                            build_table($result);
                                        }
                                    } else {
                                        echo "Error on accounts load";
                                    }
                                }

                                // Count the total number of records
                                if (isset($_POST['txtSearch'])) {
                                    $countSql = "SELECT COUNT(*) FROM tblbooksinformation WHERE Accession <> ? AND (Accession LIKE ? OR Title LIKE ? OR Author LIKE ? OR Subject LIKE ? OR Department LIKE ?)";
                                    if ($countStmt = mysqli_prepare($link, $countSql)) {
                                        mysqli_stmt_bind_param($countStmt, "ssssss", $_SESSION['username'], $searchValue, $searchValue, $searchValue, $searchValue, $searchValue);
                                        if (mysqli_stmt_execute($countStmt)) {
                                            $totalCount = mysqli_stmt_get_result($countStmt)->fetch_row()[0];
                                        }
                                    }
                                } else {
                                    $countSql = "SELECT COUNT(*) FROM tblbooksinformation WHERE Accession <> ?";
                                    if ($countStmt = mysqli_prepare($link, $countSql)) {
                                        mysqli_stmt_bind_param($countStmt, "s", $_SESSION['username']);
                                        if (mysqli_stmt_execute($countStmt)) {
                                            $totalCount = mysqli_stmt_get_result($countStmt)->fetch_row()[0];
                                        }
                                    }
                                }

                                // Calculate the total number of pages
                                $totalPages = ceil($totalCount /$recordsPerPage);

                                // Display pagination links
                                echo '<div class="clearfix">';
                                echo '<div class="hint-text">Showing ' . ($startRecord + 1) . ' to ' . min(($startRecord + $recordsPerPage), $totalCount) . ' of ' . $totalCount . ' entries</div>';
                                echo '<ul class="pagination">';
                                if ($page > 1) {
                                echo '<li class="page-item"><a href="?page=' . ($page - 1) . '" class="page-link"><i class="fa fa-angle-double-left"></i></a></li>';
                                } else {
                                echo '<li class="page-item disabled"><a href="#" class="page-link"><i class="fa fa-angle-double-left"></i></a></li>';
                                }
                                for ($i = 1; $i <= $totalPages; $i++) {
                                if ($i == $page) {
                                echo '<li class="page-item active"><a href="#" class="page-link">' . $i . '</a></li>';
                                } else {
                                echo '<li class="page-item"><a href="?page=' . $i . '" class="page-link">' . $i . '</a></li>';
                                }
                                }
                                if ($page < $totalPages) {
                                echo '<li class="page-item"><a href="?page=' . ($page + 1) . '" class="page-link"><i class="fa fa-angle-double-right"></i></a></li>';
                                } else {
                                echo '<li class="page-item disabled"><a href="#" class="page-link"><i class="fa fa-angle-double-right"></i></a></li>';
                                }
                                echo '</ul>';
                                echo '</div>';
                            ?>
                        </div>
                    </div>  
                </div> 
            </div>
        </form>
    </section>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if(sidebar.classList.contains("active")){
            sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
        }else
            sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }

        function showModal(id) {
            var modal = document.getElementById('myModal');
            var span = document.getElementsByClassName("close")[0];

            // Pass the ID to the PHP script
            $.post('get_data.php', { id: id }, function(data) {
                // Display the data inside the modal
                $('#name').html(data.name);
                $('#email').html(data.email);
                modal.style.display = "block";
            });

            span.onclick = function() {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>