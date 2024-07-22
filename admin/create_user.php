<?php
    session_start();
    if(isset($_SESSION['user_id'])) {

    
    include "../dbconnect.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        var_dump($_FILES);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $profile = "1.png";
        

        //File Upload
        $profile_array = $_FILES['profile'];
        var_dump($profile_array);
        if(isset($profile_array) && $profile_array['size'] > 0) {
            $folder_name = 'images/';
            $profile_path = $folder_name.$profile_array['name'];
            //echo $profile_path;

            $tmp_name = $profile_array['tmp_name'];
            move_uploaded_file($tmp_name, $profile_path);
        }

        $sql = "INSERT INTO users (name, email, password, profile) VALUES(:name, :email, :password, :profile)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':profile', $profile_path);
        $stmt->execute();
        //var_dump($stmt);

        header("location:users.php");

    }else {
        include "layouts/nav_sidebar.php";

    }
   
?>
    <main>
        <div class="container-fluid px-4">
            <div class="mt-3">
                <h1 class="mt-4 d-inline">Posts</h1>
                <a href="" class="btn btn-danger btn-lg float-end">Cancel</a>
            </div>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Create User
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                            <label class="" for="profile">Profile</label>
                            <input type="file" class="form-control" id="profie" name="profile" placeholder="No file chosen">
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