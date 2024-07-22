<?php
    session_start();
    if(isset($_SESSION['user_id'])) {

    
    include "layouts/nav_sidebar.php";

    include "../dbconnect.php";

    $sql = "SELECT * FROM users";
    //$stmt = $conn->query($sql);
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    //var_dump($stmt);
    $users = $stmt->fetchAll();
    //var_dump($users);
?>
    <main>
        <div class="container-fluid px-4">
            <div class="mt-3">
            <h1 class="mt-4 d-inline">Users</h1>
            <a href="create_user.php" class="btn btn-primary btn-lg float-end">Create User</a>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Users
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                foreach($users as $user) {
                            ?>
                            <tr>
                                <td><?= $user['name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td>
                                    <a href="detail.php?id=<?= $user['id'] ?>" class="btn btn-outline-info ms-5">Detail</a>
                                    <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-outline-warning">Edit</a>
                                    <a href="delete.php?id=<?= $user['id'] ?>" class="btn btn-outline-danger">Delete</a>
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
                
