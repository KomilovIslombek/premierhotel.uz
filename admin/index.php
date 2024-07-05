<?
$is_config = true;
if (empty($load_defined)) include '../load.php';

if (isAuth() === false) {
    header("Location: /login");
    exit;
}

header("Location: /admin/$permissions[0]");
// header("Location: /admin/employeesList");
exit;

include "head.php";
?>



<?
include "scripts.php";
?>

<?
include "end.php";
?>