<?php

require_once 'app/Model/Customer.php';
$customers = new Customer();
?>
<div class="container">
    <div class="border-bottom row">
        <div class="col-6 mt-5 ">
            <p class="text-primary ">All Customers</p>
        </div>
        <div class="col-6 mt-5 " >
            <a class="btn btn-primary mb-1 " style="margin-left: 80%"  href="?page=create">Add</a>
        </div>
    </div>

    <?php
        if(isset($_SESSION['update_success'])){
            ?>
            <p class="alert alert-success my-2"><?php echo $_SESSION['update_success']; ?></p>
            <?php

        }elseif (isset($_SESSION['add_success'])){
            ?>
            <p class="alert alert-success my-2"><?php echo $_SESSION['add_success']; ?></p>
            <?php
        }elseif (isset($_SESSION['delete_success'])){
            ?>
            <p class="alert alert-success my-2"><?php echo $_SESSION['delete_success']; ?></p>
            <?php
        }
        session_destroy();
    ?>

    <table class="table table-striped mt-5">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email Address</th>
            <th scope="col">Phone</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($customers->all() as $customer){
                ?>
                <tr>
                    <th scope="row"><?php echo $customer['id']; ?></th>
                    <td><?php echo $customer['name']; ?></td>
                    <td><?php echo $customer['email']; ?></td>
                    <td><?php echo $customer['phone']; ?></td>
                    <td>
                        <a class="btn btn-success" href="?page=edit&id=<?php echo $customer['id']; ?>">Edit</a>
                        <a class="btn btn-danger" href="?page=delete&id=<?php echo $customer['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>
