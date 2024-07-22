<?php
   session_start();
   if(isset($_SESSION['user_id'])) {

    include "../dbconnect.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        var_dump($_FILES);
        $title = $_POST['title'];
        $category_id = $_POST['category_id'];
        $user_id = $_SESSION['user_id'];
        $description = $_POST['description'];

        //File Upload
        $image_array = $_FILES['image'];
        var_dump($image_array);
        if(isset($image_array) && $image_array['size'] > 0) {
            $folder_name = 'images/';
            $image_path = $folder_name.$image_array['name'];
            //echo $image_path;

            $tmp_name = $image_array['tmp_name'];
            move_uploaded_file($tmp_name, $image_path);
        }

        $sql = "INSERT INTO posts (title, image, description, category_id, user_id) VALUES(:title, :image, 
        :description, :category_id, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':image', $image_path);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        //var_dump($stmt);

        header("location:posts.php");

    }else {
        include "layouts/nav_sidebar.php";

        $sql = "SELECT * FROM categories";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        //var_dump($stmt);
        $categories = $stmt->fetchAll();
        //var_dump($categories);
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
                <li class="breadcrumb-item active">Posts</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Create Post
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categories</label>
                            <select id="category_id" name="category_id" class="form-select">
                                <option>Choose...</option>
                                
                                <?php
                                    foreach($categories as $category) {
                                ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>    
                        </div>
                        <div class="mb-3">
                            <label class="" for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image" placeholder="No file chosen">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                         <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary form-control">Create</button>
                         </div>   
                    </form>
                        
                    <!-- <label for="category_id" class="form-label">Categories</label>
                    <select id="category_id" name="category_id" class="form-select">
                        <option>Choose...</option>
                        <?php
                            foreach($posts as $post) { 
                        ?>
                        <option value=""><?= $post['category'] ?></option>
                        <?php
                            }
                        ?>    
                    </select> -->
                    
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