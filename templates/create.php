<?php
    require_once 'app/Model/Customer.php';
    $errors = [];
    if($_POST){
        $customer = new Customer();
        $customer->create([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
        ]);
        $errors = $customer->errors;
        if(empty($errors)){
            $_SESSION['update_success'] = 'Added Successfully';
            header('location: index.php?page=home');
        }
    }
?>
<div class="container">
    <p class="border-bottom mt-5 text-primary">Add Customer</p>
    <form name="create" method="post" action="?page=create">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="<?php if($_POST){ echo $_POST['name']; } ?>" >
            <?php
            if(isset($errors['name'])){
                ?>
                <small class="text-danger"><?php echo  $errors['name']; ?></small>
                <?php
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php if($_POST){ echo $_POST['email']; } ?>" >
            <?php
            if(isset($errors['email'])){
                ?>
                <small class="text-danger"><?php echo  $errors['email']; ?></small>
                <?php
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp" value="<?php if($_POST){ echo $_POST['phone']; } ?>" >
            <?php
            if(isset($errors['phone'])){
                ?>
                <small class="text-danger"><?php echo  $errors['phone']; ?></small>
                <?php
            }
            ?>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>

    </form>
</div>
