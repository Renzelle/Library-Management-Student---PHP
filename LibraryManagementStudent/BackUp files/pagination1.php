$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$recordsPerPage = 5;
$startRecord = ($page - 1) * $recordsPerPage;

$searchValue = '';
if (isset($_POST['btnSearch'])) {
    $searchValue = '%' . $_POST['txtSearch'] . '%';
    $sql = "SELECT * FROM tblbookrequest WHERE User = ? AND (Accession LIKE ? OR Title LIKE ? OR Author LIKE ? OR Department LIKE ? OR Status LIKE ?) ORDER BY Id LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssii", $_SESSION['Student_Name'], $searchValue, $searchValue, $searchValue, $searchValue, $searchValue, $recordsPerPage, $startRecord);
} else {
    $sql = "SELECT * FROM tblbookrequest WHERE User = ?  ORDER BY Id LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "sii", $_SESSION['Student_Name'], $recordsPerPage, $startRecord);
}
if (mysqli_stmt_execute($stmt)) {
    $result = mysqli_stmt_get_result($stmt);
    build_table($result);
}

if (isset($_POST['txtSearch'])) {
    $countSql = "SELECT COUNT(*) FROM tblbookrequest WHERE User = ? AND (Accession LIKE ? OR Title LIKE ? OR Author LIKE ? OR Department LIKE ? OR Status LIKE ?)";
    $countStmt = mysqli_prepare($link, $countSql);
    mysqli_stmt_bind_param($countStmt, "ssssss", $_SESSION['Student_Name'], $searchValue, $searchValue, $searchValue, $searchValue, $searchValue);
} else {
    $countSql = "SELECT COUNT(*) FROM tblbookrequest WHERE User = ?";
    $countStmt = mysqli_prepare($link, $countSql);
    mysqli_stmt_bind_param($countStmt, "s", $_SESSION['Student_Name']);
}
if (mysqli_stmt_execute($countStmt)) {
    $totalCount = mysqli_stmt_get_result($countStmt)->fetch_row()[0];
}

$totalPages = ceil($totalCount / $recordsPerPage);

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