<?php
    session_start();
    if(isset($_SESSION['user_id'])) {

    
    include "../dbconnect.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_FILES);
        $id =$_POST['postID'];
        $title = $_POST['title'];
        $category_id = $_POST['category_id'];
        $user_id = $_SESSION['user_id'];
        $description = $_POST['description'];
        $old_photo = $_POST['old_photo'];

        //echo "$id and  $title and $category_id and $description and $old_photo";

        //File Upload
        $image_array = $_FILES['image'];
        //var_dump($image_array);
        if(isset($image_array) && $image_array['size'] > 0) {
            $folder_name = 'images/';
            $image_path = $folder_name.$image_array['name'];
            //echo $image_path;

            $tmp_name = $image_array['tmp_name'];
            move_uploaded_file($tmp_name, $image_path);
        }else {
            $image_path = $old_photo;
        }

        $sql = "UPDATE posts SET title=:title, image=:image, description=:description, category_id=:category_id, user_id=:user_id WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':title',$title);
        $stmt->bindParam(':image',$image_path);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':category_id',$category_id);
        $stmt->bindParam(':user_id',$user_id);
        $stmt->execute();
        //var_dump($stmt);

        header("location:posts.php");

    }else {
        include "layouts/nav_sidebar.php";

        $post_id = $_GET['id'];
        //echo $post_id;

        $sql = "SELECT * FROM posts WHERE id = :post_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':post_id',$post_id);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($post);

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
                      <input type="hidden" name="postID" id="" value="<?= $post['id'] ?>">  
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= $post['title'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categories</label>
                            <select id="category_id" name="category_id" class="form-select">
                                <option>Choose...</option>
                                
                                <?php
                                    foreach($categories as $category) {
                                        //Tenary Condition
                                        //(condition) ? statement 1 : statement 2;
                                ?>
                                    <option value="<?= $category['id'] ?>" <?= ($post['category_id'] == $category['id']) ? 'selected' : '' ?>><?= $category['name'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>    
                        </div>
                        <div class="mb-3">
                            <label class="" for="image">Image</label>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="true">Image</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="new_image-tab" data-bs-toggle="tab" data-bs-target="#new_image-tab-pane" type="button" role="tab" aria-controls="new_image-tab-pane" aria-selected="false">New Image</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                                    <img src="<?= $post['image'] ?>" alt="" width="300" height="200" class="py-3">
                                    <input type="hidden" name="old_photo" id="" value="<?= $post['image'] ?>">
                                </div>
                                <div class="tab-pane fade" id="new_image-tab-pane" role="tabpanel" aria-labelledby="new_image-tab" tabindex="0">
                                    <input type="file" class="form-control my-3" id="image" name="image" placeholder="No file chosen">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description"><?= $post['description'] ?></textarea>
                        </div>
                         <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary form-control">Update</button>
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