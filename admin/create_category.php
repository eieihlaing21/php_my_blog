<?php
    session_start();

    if(isset($_SESSION['user_id'])) {

     include "../dbconnect.php";
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         var_dump($_POST);
         $name = $_POST['name'];

     $sql = "INSERT INTO categories (name) VALUES(:name)";
     $stmt = $conn->prepare($sql);
     $stmt->bindParam(':name', $name);
     $stmt->execute();
     //var_dump($stmt);
 
     header("location:categories.php");
 
     }else {
         include "layouts/nav_sidebar.php";
     }
?>
    <main>
        <div class="container-fluid px-4">
            <div class="mt-3">
                <h1 class="mt-4 d-inline">Categories</h1>
                <a href="" class="btn btn-danger btn-lg float-end">Cancel</a>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Create Category
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary form-control">Create</button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </main>
<?php
    include "layouts/footer.php";
    }else {
    header('location: ../index.php');
    }
?>