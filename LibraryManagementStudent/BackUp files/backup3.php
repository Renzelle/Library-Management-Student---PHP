$user = $_SESSION['Student_Name'];
$accession = $_POST['txtAccession'];
$quantity = $_POST['txtQuantity'];

if($_SESSION['UserType'] == "College Student")
{
    // set a maximum limit
    $maxQuantity = 3; // maximum allowed quantity
}
else
{
    // set a maximum limit
    $maxQuantity = 7; // maximum allowed quantity
} 

// check if record with given accession exists
$sql = "SELECT * FROM tblbookrequest WHERE Accession = ? AND User = ?";
if($stmt = mysqli_prepare($link, $sql))
{
    mysqli_stmt_bind_param($stmt, "ss", $accession, $user);
    if(mysqli_stmt_execute($stmt))
    {
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) == 1)
        {
            $row = mysqli_fetch_array($result);
            $currentQuantity = $row['Quantity'];
            $newQuantity = $currentQuantity + $quantity;

            if($newQuantity > $maxQuantity)
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
                if($updateStmt = mysqli_prepare($link, $updateSql))
                {
                    mysqli_stmt_bind_param($updateStmt, "iss", $newQuantity, $accession, $user);
                    if(mysqli_stmt_execute($updateStmt))
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
        else // record not found
        {
            // check if quantity exceeds limit
            if ($quantity > $maxQuantity) {
                echo "<script>
                    swal({
                        icon: 'error',
                        title: 'Error...',
                        text: 'Quantity limit exceeded!',
                    })
                </script>";
            }
            else {
                // insert new record
                $insertSql = "INSERT INTO tblbookrequest (Accession, Title, Author, Department, Quantity, Status, Date_Pickup, User, Library_ID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
                if($insertStmt = mysqli_prepare($link, $insertSql))
                {
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