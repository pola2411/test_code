<?php
function testMessage($concation, $message)
{
    if ($concation) {
        echo " <div class='alert alert-success col-4 mx-auto'>
   $message Done Successfuly
</div>";
    } else {
        echo " <div class='alert alert-danger col-4 mx-auto'>
        $message Falied Proccess
     </div>";
    }
}
// Connect TO Database;
$host = "localhost";
$user = "root";
$password = "";
$dbName = "odc";
$conn = mysqli_connect($host, $user, $password, $dbName);

// Create
if (isset($_POST['send'])) {
    $name =  $_POST['empName'];
    $salary =  $_POST['empSalary'];
    $phone = $_POST['empPhone'];
    $city = $_POST['empCity'];
    $inset = "INSERT INTO `employees` VALUES(NULL ,'$name' , $salary ,'$phone' ,'$city') ";
    $i = mysqli_query($conn, $inset);
    testMessage($i, "Insert To Databse");
}
// EDIT ? ID

// Read ;
$select = "SELECT * FROM `employees`";
$employees = mysqli_query($conn, $select);
###########################
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = "DELETE FROM employees where id = $id ";
    $d =   mysqli_query($conn, $delete);
    header("location:  index.php?#return ");
}

$name = "";
$salary = "";
$phone = "";
$city = "";
$update = false;
if (isset($_GET['edit'])) {
    $update = true;
    $id = $_GET['edit'];
    $select = "SELECT * FROM employees where id =$id";
    $oneEmployee = mysqli_query($conn, $select);
    $row = mysqli_fetch_assoc($oneEmployee);
    $name = $row['name'];
    $salary = $row['salary'];
    $phone = $row['phone'];
    $city = $row['city'];
    if (isset($_POST['update'])) {
        $name =  $_POST['empName'];
        $salary =  $_POST['empSalary'];
        $phone = $_POST['empPhone'];
        $city = $_POST['empCity'];
        $update = "UPDATE employees SET `name` = '$name' , salary = $salary , phone = '$phone' , city = '$city'  where id =$id";
        $u = mysqli_query($conn, $update);
        header("location:index.php?#return ");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <title>Document</title>
</head>

<body>

    <div class="container col-6">
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Employee Name</label>
                        <input type="text" class="form-control" value="<?= $name ?>" name="empName">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Employee Salary</label>
                        <input type="number" class="form-control" value="<?= $salary ?>" name="empSalary">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Employee Phone</label>
                        <input type="number" class="form-control" value="<?= $phone ?>" name="empPhone">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Employee City</label>
                        <input type="text" class="form-control" value="<?= $city ?>" name="empCity">
                    </div>
                    <?php if ($update) : ?>
                        <button name="update" class="btn btn-info"> Update Data </button>
                    <?php else : ?>
                        <button name="send" class="btn btn-primary">Insert Employee</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <div id="return" class="container col-7 mt-5">
        <div class="card">
            <div class="card-body">
                <table class="table table-dark table-striped">
                    <tr>
                        <th>#ID </th>
                        <th>Name </th>
                        <th>Salary </th>
                        <th>Phone </th>
                        <th>City </th>
                        <th colspan="2">Action </th>
                    </tr>
                    <?php foreach ($employees as $data) { ?>
                        <tr>
                            <td> <?= $data['id'] ?> </td>
                            <td> <?= $data['name'] ?> </td>
                            <td> <?= $data['salary'] ?> </td>
                            <td> <?= $data['phone'] ?> </td>
                            <td> <?= $data['city'] ?> </td>
                            <td> <a class="btn btn-primary" href="index.php?edit=<?= $data['id'] ?>"> Edit </a></td>
                            <td> <a href="index.php?delete=<?= $data['id'] ?>" class="btn btn-danger"> Remove </a> </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

</body>

</html>