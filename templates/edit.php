<?php
require_once 'app/Model/Customer.php';

$customer = new Customer();
$customer = $customer->get($_GET['id']);
if($customer){

    if($_POST){
        $updated_customer = new Customer();
        $updated_customer->update($_GET['id'],[
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
        ]);
        $errors = $updated_customer->errors;
        if(empty($errors)){
            $_SESSION['update_success'] = 'Updated Successfully';
            header('location: index.php?page=home');
        }
    }

    ?>
    <div class="container">
        <p class="border-bottom mt-5 text-primary">Edit Customer <?php echo $customer['name']; ?> </p>
        <form name="edit" method="post" action="?page=edit&id=<?php echo $customer['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="hidden"  name="id"  value="<?php echo $customer['id']; ?>" >
                <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="<?php if($_POST){  echo $_POST['name']; } else{echo $customer['name'];} ?>" >
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
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php if($_POST){  echo $_POST['email']; } else{echo $customer['email'];} ?>" >
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
                <input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp" value="<?php if($_POST){  echo $_POST['phone']; } else{echo $customer['phone'];}  ?>" >
                <?php
                if(isset($errors['phone'])){
                    ?>
                    <small class="text-danger"><?php echo  $errors['phone']; ?></small>
                    <?php
                }
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>

        </form>
    </div>
    <?php
} else {
    header("location: index.php?page=home");
}
?>