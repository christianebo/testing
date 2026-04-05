<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    <div>
    <div class="container my-5"> 
        <h2>List of Clients</h2>
                </div?>
<div class="row">
    <div class="card-body">
        <div class="col-md-4">  
            <form action="index.php" method="GET">
                <!-- Search bar -->
                <div class="mb-3">
                    <input type="text" name="search" 
                           value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>"  
                           class="form-control" placeholder="Search User">
                </div>

                <!-- Buttons below -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="index.php" class="btn btn-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>
</div>

            <div class="com-md-12">
                <div class="card mt-4">
                    <div class="cardbody">
                        <table class="table">
                            <thead>
                                <tr>
                                   <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","root","","myshop");

                                    if(isset($_GET['search']))
                                    {
                                        $filtervalues = $_GET['search'];
                                        $query = "SELECT * FROM clients WHERE CONCAT(name, email, phone, address) LIKE '%$filtervalues%' ";
                                        $query_run = mysqli_query($con, $query);
                                        $sql = "SELECT *, (quantity * price) AS total FROM clients";

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $items)
                                            {
                                                ?>
                                                    <tr>
                                                        <td><?= $items['id'] ?></td>
                                                        <td><?= $items['name'] ?></td>
                                                        <td><?= $items['email'] ?></td>
                                                        <td><?= $items['phone'] ?></td>
                                                        <td><?= $items['address'] ?></td>
                                                        <td><?= $items['quantity'] ?></td>
                                                        <td><?= $items['price'] ?></td>
                                                        <td><?= $items['quantity'] * $items['price'] ?></td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <table class="table">
                                <tr>
                                    <td colspan="4">No Record Found</td>
                                </tr>
                                </table>
                                            <?php 
                                        }
                                    }
                                ?>
                         

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <br>
        <a class="btn btn-primary" href= "/myshop/create.php" role="button">New Client</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Amount</th>
                <th>Create At</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "myshop";

                // Create connection
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($connection->connect_error){
                    die("Connection Failed: " . $connection->connect_error);
                }

                // read all row from database table
                $sql = "SELECT * FROM clients";
                $result = $connection->query($sql);

                if(!$result){
                    die("Invalid Query: . $connection->error");
                }

                // read data of each row
                while($row = $result->fetch_assoc()){
                    $total = $row['quantity'] * $row['price'];
                    echo "
                    <tr>
                    <td>$row[id]</td>
                    <td>$row[name]</td>
                    <td>$row[email]</td>
                    <td>$row[phone]</td>
                    <td>$row[address]</td>
                    <td>$row[quantity]</td>
                    <td>$row[price]</td>
                    <td>$total</td>
                    <td>$row[created_at]</td>
                    <td>
                        <a class='btn btn-primary bts-sm' href='/myshop/edit.php?id=$row[id]'>Edit</a>
                        <a class='btn btn-danger bts-sm' href='/myshop/delete.php?id=$row[id]'>Delete</a>
                    </td>
                </tr>
                    ";
                }
                ?>

                
            </tbody>
        </table>
    </div>
</body>
</html>




CREATE DATABASE myshop;

CREATE TABLE clients (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    phone VARCHAR(20) NULL,
    address VARCHAR(200) NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
