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
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Issued Book</span>
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
                                </div>
                            </div>
                            <div class="table-filter">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="filter-group">
                                            <label>Location</label>
                                            <select class="form-control">
                                                <option>All</option>
                                                <option>Berlin</option>
                                                <option>London</option>
                                                <option>Madrid</option>
                                                <option>New York</option>
                                                <option>Paris</option>                              
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
                                                echo "<th>#</th>";
                                                echo "<th>Accession</th>";
                                                echo "<th>Title</th>";
                                                echo "<th>Issue Date</th>";
                                                echo "<th>Expected Return</th>";
                                                echo "<th>Status</th>";
                                                echo "<th>Action</th>";
                                            echo "</tr>";    
                                            echo "<br>";
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            $Primary_key = $row['Accession'];
                                            echo "<tr>";
                                                ?>

                                                <td><?php echo $row['Id']; ?></td>
                                                <td><?php echo $row['Accession']; ?></td>
                                                <td><?php echo $row['Title']; ?></td>
                                                <td><?php echo $row['Issue_Date']; ?></td>
                                                <td><?php echo $row['Expected_Return']; ?></td>
                                                <td><?php echo $row['Status']; ?></td>
                                                <td>
                                                <?php
                                                    echo "<a class='btn btn-success' data-id='$Primary_key' data-toggle='modal' style='font-weight: bold; background-color: #218838; color:#FFFFFF' href='#edit$Primary_key'> Details </a>";
                                                ?>
                                                </td>
                                            <?php
                                            echo "</tr>";
                                            ?>
                                            <!--REQUEST-->
                                            <div id="edit<?php echo $Primary_key;?>" class="modal fade">
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
                                                                    <input type="text" class="form-control" name="txtTitle" value="<?php echo $Primary_key ?>" id=""  readonly="readonly"> 
                                                                </div>
                                                                <div class="form-group">
                                                                    <span class="details">Title</span>
                                                                    <input type="text" class="form-control" name="txtTitle" value="<?php echo $row['Title'] ?>" id=""  readonly="readonly">     
                                                                </div> 
                                                                <div class="form-group">
                                                                    <span class="details">Issue Date</span>
                                                                    <input type="text" class="form-control" name="txtPublisher" value="<?php echo $row['Expected_Return'] ?>" id=""  readonly="readonly">     
                                                                </div>
                                                                <div class="form-group">
                                                                    <span class="details">Expected Return</span>
                                                                    <input type="text" class="form-control" name="txtAuthor" value="<?php echo $row['Expected_Return'] ?>" id=""  readonly="readonly">
                                                                </div> 
                                                                <div class="form-group">
                                                                    <span class="details">Date Return</span>
                                                                    <input type="text" class="form-control" name="txtAuthor" value="<?php echo $row['Date_Return'] ?>" id=""  readonly="readonly">
                                                                </div>   
                                                                <div class="form-group">
                                                                    <span class="details">Status</span>
                                                                    <input type="text" class="form-control" name="txtUser" value="<?php echo $row['Status'] ?>" id=""  readonly="readonly">     
                                                                </div> 
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                                                <input type="submit" style="background-color: #218838;color: #FFFFFF" class="btn btn-info" data-dismiss="modal" value="Okay">
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
                                $recordsPerPage = 2;

                                // Calculate the starting record number for the current page
                                $startRecord = ($page - 1) * $recordsPerPage;

                                // Construct the SQL query with LIMIT and OFFSET clauses
                                if (isset($_POST['btnSearch'])) {
                                    $sql = "SELECT * FROM tblbookassign WHERE User = ? AND (Accession LIKE ? OR Title LIKE ? OR  Status LIKE ?) ORDER BY Id LIMIT ? OFFSET ?";
                                    if ($stmt = mysqli_prepare($link, $sql)) {
                                        $searchValue = '%' . $_POST['txtSearch'] . '%';
                                        mysqli_stmt_bind_param($stmt, "ssssii", $_SESSION['Student_Name'], $searchValue, $searchValue, $searchValue, $recordsPerPage, $startRecord);
                                        if (mysqli_stmt_execute($stmt)) {
                                            $result = mysqli_stmt_get_result($stmt);
                                            build_table($result);
                                        }
                                    } else {
                                        echo "Error on search";
                                    }
                                } else {
                                    $sql = "SELECT * FROM tblbookassign WHERE User = ?  ORDER BY Id LIMIT ? OFFSET ?";
                                    if ($stmt = mysqli_prepare($link, $sql)) {
                                        mysqli_stmt_bind_param($stmt, "sii", $_SESSION['Student_Name'], $recordsPerPage, $startRecord);
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
                                    $countSql = "SELECT COUNT(*) FROM tblbookassign WHERE User = ? AND (Accession LIKE ? OR Title LIKE ? OR Status LIKE ?)";
                                    if ($countStmt = mysqli_prepare($link, $countSql)) {
                                        mysqli_stmt_bind_param($countStmt, "ssss", $_SESSION['Student_Name'], $searchValue, $searchValue, $searchValue);
                                        if (mysqli_stmt_execute($countStmt)) {
                                            $totalCount = mysqli_stmt_get_result($countStmt)->fetch_row()[0];
                                        }
                                    }
                                } else {
                                    $countSql = "SELECT COUNT(*) FROM tblbookassign WHERE User = ?";
                                    if ($countStmt = mysqli_prepare($link, $countSql)) {
                                        mysqli_stmt_bind_param($countStmt, "s", $_SESSION['Student_Name']);
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

        function validateForm() 
        {
            var quantity = document.getElementById("txtQuantity").value;
            var date = document.getElementById("txtDate").value;

            if (quantity == "") {
              alert("Please enter a quantity.");
              return false;
            }

            if (date == "") {
              alert("Please select a pick up date.");
              return false;
            }

            return true;
        }
    </script>
</body>
</html>