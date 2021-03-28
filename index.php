<?php

include 'templates/header.php';

session_start();

$page = isset($_GET['page']) ? $_GET['page']:'home';

if($page == 'home'){
    include 'templates/home.php';
}elseif ($page == 'create') {
    include 'templates/create.php';
}elseif ($page == 'edit'){
    include 'templates/edit.php';
}elseif ($page == 'delete'){
    include 'templates/delete.php';
} else {
    header('location: index.php?page=home');
}

?>


<?php

include 'templates/footer.php';
?>
