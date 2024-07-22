<?php
    session_start();

    if(isset($_SESSION['user_id'])) {

    include "layouts/nav_sidebar.php";

    include "../dbconnect.php";

    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    //var_dump($stmt);
    $categories = $stmt->fetchAll();
    //var_dump($categories);
    
 ?>
    <main>
        <div class="container-fluid px-4">
            <div class="mt-3">
                <h1 class="mt-4 d-inline">Categories</h1>
                <a href="create_category.php" class="btn btn-primary btn-lg float-end">Create Category</a>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Categories
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                foreach($categories as $category) {

                            ?>
                            <tr>
                                <td>
                                    <?= $category['name'] ?>
                                </td>
                                <td>
                                    <a href="../detail.php" class="btn btn-outline-info btn-sm ms-5">Detail</a>
                                    <a href="edit.php" class="btn btn-outline-warning btn-sm">Edit</a>
                                    <a href="delete.php" class="btn btn-outline-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>                           
                    </table>
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