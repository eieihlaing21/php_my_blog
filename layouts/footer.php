<?php
    include "dbconnect.php";

    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    //var_dump($stmt);
    $categories = $stmt->fetchAll();
    //var_dump($categories);
?>

<!-- Side widgets-->
<div class="col-lg-4">
    <!-- Categories widget-->
    <div class="card mb-4">
        <div class="card-header">Categories</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                        foreach($categories as $category) {

                    ?>
                        <ul class="list-unstyled mb-0">    
                            <li><a href="index.php?category_id=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                        </ul>
                    <?php
                        }
                    ?>    
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>
