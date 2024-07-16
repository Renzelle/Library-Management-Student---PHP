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
            // Select/Deselect checkboxes
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
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Requisition</span>
            </div>
            <div class="profile-details">
                <img src="../Image/profile original.png" alt="">
                <span class="admin_name"><?php echo $_SESSION['Student_Name'] ?></span>
                <i class='bx bx-chevron-down' ></i>
            </div>
        </nav>
        <!--CANCEL-->
            <?php
            require_once "config.php";
            if(isset($_POST['btnSubmit']))
            {
                $sql = "DELETE FROM tblbookrequest WHERE Id = ?";
                $id = $_POST['txtUsername'];
                if($stmt = mysqli_prepare($link, $sql)){
                    mysqli_stmt_bind_param($stmt, "s", $id);
                    if(mysqli_stmt_execute($stmt))
                    {
                        if(mysqli_stmt_execute($stmt))
                        {
                            echo "<script>
                                    swal({
                                    icon: 'success',
                                    title: 'Success...',
                                    text: 'Request Cancelled!',
                                 }).then(() => {
                                    location.reload();
                                 });
                                </script>";
                        }
                    }
                    else
                    {
                        echo "Error on delete statement";
                    }
                }
            }
            ?>
            <!--CANCEL CHECKBOX-->
            <?php
            require_once "config.php";
            if(isset($_POST['chk_id']))
            {
                $arr = $_POST['chk_id'];
                foreach ($arr as $id) 
                {
                    $sql = "DELETE FROM tblbookrequest WHERE Id = ?";
                    if($stmt = mysqli_prepare($link, $sql))
                    {
                        mysqli_stmt_bind_param($stmt, "s", $id);
                        if(mysqli_stmt_execute($stmt))
                        {
                            echo "<script>
                                    swal({
                                        icon: 'success',
                                        title: 'Success...',
                                        text: 'Request Cancelled!',
                                    }).then(() => {
                                    location.reload();
                                 });
                                </script>";
                        }
                        else
                        {
                            echo "Error on update statement";
                        }
                    }
                }
            }
            ?>
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
                                        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal" style="background-color: #C82333; color:#FFFFFF"><i class="material-icons">&#xE15C;</i><span>Cancel</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-filter">
                                <div class="row">
                                    <div class="col-sm-3">
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
                                    </div>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary" name="btnSearch"><i class="fa fa-search"></i></button>
                                        <div class="filter-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Search.." name="txtSearch">
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
                                                echo "<th>#</th>";
                                                echo "<th>Accession</th>";
                                                echo "<th>Requested By</th>";                                
                                                echo "<th>Date Pickup</th>";
                                                echo "<th>Status</th>";
                                               
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
                                                        <input type="checkbox" id="checkbox2" name="chk_id[]" value="<?php echo $row['Id'];?>">
                                                        <label for="checkbox2"></label>
                                                    </span>
                                                </td>
                                                <td><?php echo $row['Id']; ?></td>
                                                <td><?php echo $row['Accession']; ?></td>
                                                <td><?php echo $row['requestedBy']; ?></td>
                                                <td><?php echo $row['dateRequest']; ?></td>
                                                <td><?php echo $row['statusRequest']; ?></td>                                                

                                                <td>
                                                <?php
                                                    echo "<a class='btn btn-success' data-id='$Primary_key' data-toggle='modal' style='font-weight: bold; background-color: #C82333; color:#FFFFFF' href='#Delete$Primary_key'>Cancel</a>";
                                                ?>
                                                </td>
                                            <?php
                                            echo "</tr>";
                                                ?>
                                            <!-- DELETE -->
                                            <div id="Delete<?php echo $Primary_key?>" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
                                                            <input type="hidden" name="txtUsername" value="<?php echo $ID; ?>">
                                                            <div class="modal-header">                      
                                                                <h4 class="modal-title">Cancel Request</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">                    
                                                                <p>Are you sure you want to cancel these Records?</p>
                                                                <p class="text-warning"><small>This action cannot be undone.</small></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                                                <input type="submit" class="btn btn-danger" name="btnSubmit" style='font-weight: bold; background-color: #C82333; color:#FFFFFF' value="Delete">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>   
                                            
                                            <!-- DELETE -->
                                            <div id="deleteEmployeeModal" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">                      
                                                            <h4 class="modal-title">Cancel Request</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        </div>
                                                        <div class="modal-body">                    
                                                            <p>Are you sure you want to cancel these Records?</p>
                                                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                                            <input type="submit" class="btn btn-danger" id="submit" name="submit" style='font-weight: bold; background-color: #C82333; color:#FFFFFF' value="Delete">
                                                        </div>
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
                                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                                // Number of records to display per page
                                $recordsPerPage = 5;

                                // Calculate the start record based on the current page number and the number of records per page
                                $startRecord = ($page - 1) * $recordsPerPage;

                                // Initialize the search value
                                $searchValue = '';

                                // If the search button is clicked, use the search value to filter the results
                                if (isset($_POST['btnSearch'])) 
                                {
                                    // Get the search value and format it with wildcards
                                    $searchValue = '%' . $_POST['txtSearch'] . '%';
                                    
                                    // Prepare the SQL statement with the search value and pagination parameters
                                    $sql = "SELECT * FROM tblbookrequest WHERE requestedBy = ? AND (Accession LIKE ? OR Status LIKE ?) ORDER BY Id LIMIT ? OFFSET ?";
                                    $stmt = mysqli_prepare($link, $sql);
                                    mysqli_stmt_bind_param($stmt, "sssii", $_SESSION['Student_Name'], $searchValue, $searchValue, $recordsPerPage, $startRecord);
                                } 
                                // Otherwise, display all the records for the current page
                                else 
                                {
                                    // Prepare the SQL statement with the pagination parameters
                                    $sql = "SELECT * FROM tblbookrequest WHERE requestedBy = ?  ORDER BY Id LIMIT ? OFFSET ?";
                                    $stmt = mysqli_prepare($link, $sql);
                                    mysqli_stmt_bind_param($stmt, "sii", $_SESSION['Student_Name'], $recordsPerPage, $startRecord);
                                }

                                // Execute the prepared statement and build the table
                                if (mysqli_stmt_execute($stmt)) 
                                {
                                    $result = mysqli_stmt_get_result($stmt);
                                    build_table($result);
                                }

                                // Get the total number of records for the search query or all records for the current user
                                if (isset($_POST['txtSearch'])) 
                                {
                                    $countSql = "SELECT COUNT(*) FROM tblbookrequest WHERE requestedBy = ? AND (Accession LIKE ? OR statusRequest LIKE ?)";
                                    $countStmt = mysqli_prepare($link, $countSql);
                                    mysqli_stmt_bind_param($countStmt, "sss", $_SESSION['Student_Name'], $searchValue, $searchValue);
                                } 
                                else 
                                {
                                    $countSql = "SELECT COUNT(*) FROM tblbookrequest WHERE requestedBy = ?";
                                    $countStmt = mysqli_prepare($link, $countSql);
                                    mysqli_stmt_bind_param($countStmt, "s", $_SESSION['Student_Name']);
                                }

                                // Execute the prepared statement and get the total number of records
                                if (mysqli_stmt_execute($countStmt)) 
                                {
                                    $totalCount = mysqli_stmt_get_result($countStmt)->fetch_row()[0];
                                }

                                // Calculate the total number of pages based on the number of records per page and the total number of records
                                $totalPages = ceil($totalCount / $recordsPerPage);

                                // Display the pagination links
                                echo '<div class="clearfix">';
                                    echo '<div class="hint-text">Showing ' . ($startRecord + 1) . ' to ' . min(($startRecord + $recordsPerPage), $totalCount) . ' of ' . $totalCount . ' entries</div>';
                                    echo '<ul class="pagination">';
                                        if ($page > 1) 
                                        {
                                            echo '<li class="page-item"><a href="?page=' . ($page - 1) . '" class="page-link"><i class="fa fa-angle-double-left"></i></a></li>';
                                        } 
                                        else 
                                        {
                                            echo '<li class="page-item disabled"><a href="#" class="page-link"><i class="fa fa-angle-double-left"></i></a></li>';
                                        }
                                        for ($i = 1; $i <= $totalPages; $i++) 
                                        {
                                            if ($i == $page) 
                                            {
                                                echo '<li class="page-item active"><a href="#" class="page-link">' . $i . '</a></li>';
                                            } 
                                            else 
                                            {
                                                echo '<li class="page-item"><a href="?page=' . $i . '" class="page-link">' . $i . '</a></li>';
                                            }
                                        }
                                        if ($page < $totalPages) 
                                        {
                                            echo '<li class="page-item"><a href="?page=' . ($page + 1) . '" class="page-link"><i class="fa fa-angle-double-right"></i></a></li>';
                                        } 
                                        else 
                                        {
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
    </script>
</body>
</html>