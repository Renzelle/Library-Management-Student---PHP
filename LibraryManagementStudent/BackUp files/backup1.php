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
        <link rel="stylesheet" href="../CSS/style.css">
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
        });
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
            $user = $_SESSION['Student_Name'];
            $accession = $_POST['txtAccession'];
            $quantity = $_POST['txtQuantity'];

            if ($_SESSION['UserType'] == "College Student") 
            {
                // set a maximum limit
                $maxQuantity = 3; // maximum allowed quantity
            } 
            else 
            {
                // set a maximum limit
                $maxQuantity = 7; // maximum allowed quantity
            }

            // check if user has reached their limit or if record with given accession exists
            $countSql = "SELECT COUNT(*) AS count FROM tblbookrequest WHERE User = ? OR (Accession = ? AND User = ?)";
            if ($countStmt = mysqli_prepare($link, $countSql)) 
            {
                mysqli_stmt_bind_param($countStmt, "sss", $user, $accession, $user);
                if (mysqli_stmt_execute($countStmt)) 
                {
                    $countResult = mysqli_stmt_get_result($countStmt);
                    $countRow = mysqli_fetch_assoc($countResult);
                    $currentCount = $countRow['count'];

                    if ($currentCount >= $maxQuantity) 
                    {
                        echo "<script>
                                        swal({
                                            icon: 'error',
                                            title: 'Error...',
                                            text: 'Data limit reached!',
                                        })
                                    </script>";
                        exit; // exit the script if data limit is reached
                    } 
                    else 
                    {
                        // check if record with given accession exists
                        $sql = "SELECT * FROM tblbookrequest WHERE Accession = ? AND User = ?";
                        if ($stmt = mysqli_prepare($link, $sql)) 
                        {
                            mysqli_stmt_bind_param($stmt, "ss", $accession, $user);
                            if (mysqli_stmt_execute($stmt)) 
                            {
                                $result = mysqli_stmt_get_result($stmt);
                                if (mysqli_num_rows($result) == 1) 
                                {
                                    $row = mysqli_fetch_array($result);
                                    $currentQuantity = $row['Quantity'];
                                    $newQuantity = $currentQuantity + $quantity;

                                    if ($newQuantity > $maxQuantity) 
                                    {
                                        echo "<script>
                                            swal({
                                                icon: 'error',
                                                title: 'Error...',
                                                text: 'Quantity limit exceeded!',
                                            })
                                        </script>";
                                    } 
                                    else 
                                    {
                                        $updateSql = "UPDATE tblbookrequest SET Quantity = ? WHERE Accession = ? AND User = ?";
                                        if ($updateStmt = mysqli_prepare($link, $updateSql)) 
                                        {
                                            mysqli_stmt_bind_param($updateStmt, "iss", $newQuantity, $accession, $user);
                                            if (mysqli_stmt_execute($updateStmt)) 
                                            {
                                                echo "<script>
                                                    swal({
                                                        icon: 'success',
                                                        title: 'Success...',
                                                        text: 'Quantity Added!',
                                                    })
                                                </script>";
                                            } 
                                            else 
                                            {
                                                echo "<script>
                                                    swal({
                                                        icon: 'error',
                                                        title: 'Error...',
                                                        text: 'Error On Update Statement!',
                                                    })
                                                </script>";
                                            }
                                        } 
                                        else 
                                        {
                                            echo "<script>
                                                swal({
                                                    icon: 'error',
                                                    title: 'Error...',
                                                    text: 'Error On Prepare Update Statement!',
                                                })
                                            </script>";
                                        }
                                    }
                                } 
                                else 
                                {
                                    // record not found, insert new record
                                    $insertSql = "INSERT INTO tblbookrequest (Accession, Title, Author, Department, Quantity, Status, Date_Pickup, User, Library_ID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                    if($insertStmt = mysqli_prepare($link, $insertSql))
                                    {
                                        if ($quantity > 3) 
                                        {
                                            echo "<script>
                                                swal({
                                                    icon: 'error',
                                                    title: 'Error...',
                                                    text: 'Quantity limit exceeded!',
                                                })
                                            </script>";
                                        }

                                        $status = 'WAITING FOR APPROVAL';
                                        mysqli_stmt_bind_param($insertStmt, "sssssssss", $accession, $_POST['txtTitle'], $_POST['txtAuthor'], $_POST['txtDepartment'], $quantity, $status, $_POST['txtDate'], $_POST['txtUser'], $_POST['txtLibraryID']);
                                        if(mysqli_stmt_execute($insertStmt))
                                        {
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
                                                    icon: 'error',
                                                    title: 'Error...',
                                                    text: 'Error On Insert Statement!',
                                                })
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
                                            })
                                        </script>";
                                    }
                                }
                            }
                            else
                            {
                                echo "<script>
                                    swal({
                                        icon: 'error',
                                        title: 'Error...',
                                        text: 'Error On Select Statement!',
                                                })
                                            </script>";
                            }
                        }
                    }
                }
            }
        }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu sidebarBtn'></i>
                    <span class="dashboard">Book</span>
                </div>
                <div class="search-box">
                    <input type="text" placeholder="Search..." name="txtSearch">
                </div>
                <div class="profile-details">
                    <img src="../Image/profile original.png" alt="">
                    <span class="admin_name"><?php echo $_SESSION['Student_Name'] ?></span>
                    <i class='bx bx-chevron-down' ></i>
                </div>
            </nav>
            <!--MAIN PAGE-->
            <div class="home-content">
                <div class="container-xl">
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-8"><h2>Library Management <b>System</b></h2></div>
                                </div>
                            </div>
                            <?php
                                function build_table($result)
                                {
                                    if(mysqli_num_rows($result) > 0)
                                    {
                                        echo "<table class='table table-striped table-hover table-bordered'>";
                                            echo "<tr>";
                                                echo "<th>Accession</th>";
                                                echo "<th>Title</th>";
                                                echo "<th>Author</th>";
                                                echo "<th>Publisher by</th>";
                                                echo "<th>Subject</th>";
                                                echo "<th>Department</th>";
                                                echo "<th>Quantity</th>";
                                                echo "<th>Action</th>";
                                            echo "</tr>";    
                                            echo "<br>";
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            $Primary_key = $row['Accession'];
                                            echo "<tr>";
                                                ?>

                                                <td><?php echo $row['Accession']; ?></td>
                                                <td><?php echo $row['Title']; ?></td>
                                                <td><?php echo $row['Author']; ?></td>
                                                <td><?php echo $row['Publisher']; ?></td>
                                                <td><?php echo $row['Subject']; ?></td>
                                                <td><?php echo $row['Department']; ?></td>
                                                <td><?php echo $row['Quantity']; ?></td>

                                                <td>
                                                <?php
                                                    echo "<a class='btn btn-success edit' data-id='$Primary_key' data-toggle='modal' style='font-weight: bold; width: 100%; color: #ffffff;' href='#request$Primary_key'> Request </a>";
                                                    echo "<a class='btn btn-primary' data-id='$Primary_key' data-toggle='modal' style='font-weight: bold; width: 100%; color: #ffffff;' href='#edit$Primary_key'>Details</a>";
                                                ?>
                                                </td>
                                            <?php
                                            echo "</tr>";
                                                ?>
                                            <!--REQUEST-->
                                            <div id="request<?php echo $Primary_key;?>" class="modal fade">
                                                <div class="modal-dialog modal-login">
                                                    <div class="modal-content">
                                                        <div class="modal-header">          
                                                            <h4 class="modal-title">Requisition</h4>   
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        </div>
                                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">   
                                                            <div class="modal-body">      
                                                                <div class="form-group">
                                                                    <span class="details">Accession</span>
                                                                    <input type="text" class="form-control" name="txtAccession" value="<?php echo $row['Accession'] ?>" readonly="readonly">     
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
                                                                <?php
                                                                    if($_SESSION['UserType'] == "College Student")
                                                                    {
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <span class="details">Quantity</span>
                                                                            <input type="number" class="form-control" name="txtQuantity" value = "0" min="1" max="3" id="" required>     
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                       ?>
                                                                        <div class="form-group">
                                                                            <span class="details">Quantity</span>
                                                                            <input type="number" class="form-control" name="txtQuantity" value = "0" min="1" max="7" id="" required>     
                                                                        </div>
                                                                        <?php 
                                                                    }
                                                                ?>
                                                                
                                                                <hr>
                                                                <div class="form-group">
                                                                    <span class="details">User</span>
                                                                    <input type="text" class="form-control" name="txtUser" value="<?php echo $_SESSION['Student_Name'] ?>" id=""  readonly="readonly">     
                                                                </div>  
                                                                <div class="form-group">
                                                                    <span class="details">Library ID</span>
                                                                    <input type="text" class="form-control" name="txtLibraryID" value="<?php echo $_SESSION['username'] ?>" id=""  readonly="readonly">     
                                                                </div> 
                                                                <div class="form-group">
                                                                    <span class="details">Pick up Date</span>
                                                                    <input type="date" class="form-control" name="txtDate" id="" required="required">     
                                                                </div> 
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                                                <input type="submit" class="btn btn-info" name = "btnSave" value="Save">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>  
                                            <!--DETAILS-->
                                            <div id="edit<?php echo $Primary_key;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                                            <input type="submit" class="btn btn-info" data-dismiss="modal" value="Okay">
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

                                if(isset($_POST['txtSearch']))
                                {
                                    $sql = "SELECT * FROM tblbooksinformation WHERE Accession <> ? AND (Accession LIKE ? OR Title LIKE ? OR Author LIKE ? OR Subject LIKE ? OR Department LIKE ?) ORDER BY Accession";
                                    if($stmt = mysqli_prepare($link, $sql))
                                    {
                                        $searchValue = '%' . $_POST['txtSearch'] . '%';
                                        mysqli_stmt_bind_param($stmt, "ssssss", $_SESSION['username'], $searchValue, $searchValue,$searchValue, $searchValue, $searchValue);
                                        if(mysqli_stmt_execute($stmt))
                                        {
                                            $result = mysqli_stmt_get_result($stmt);
                                            build_table($result);
                                        }
                                    }
                                    else
                                    {
                                        echo "Error on search";
                                    }
                                }
                                else
                                {
                                    $sql = "SELECT * FROM tblbooksinformation WHERE Accession <> ?  ORDER BY Accession";
                                    if($stmt = mysqli_prepare($link, $sql))
                                    {
                                        mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                                        if(mysqli_stmt_execute($stmt))
                                        {
                                            $result = mysqli_stmt_get_result($stmt);
                                            build_table($result);   
                                        }
                                    }
                                    else
                                    {
                                        echo "Error on accounts load";
                                    }
                                }
                            ?>
                            <div class="clearfix">
                                <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                                <ul class="pagination">
                                    <li class="page-item disabled"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                                    <li class="page-item active"><a href="#" class="page-link">3</a></li>
                                    <li class="page-item"><a href="#" class="page-link">4</a></li>
                                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                                    <li class="page-item"><a href="#" class="page-link"><i class="fa fa-angle-double-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>  
                </div> 
            </div>
        </section>
    </form>

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
    </script>
</body>
</html>