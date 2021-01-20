<?php require_once('./inc/header.php'); ?>

    <body class="nav-fixed">
        <?php
            require_once("./inc/navbar.php");
        ?>
        <!--Side Nav-->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php
                    $curr_page = basename(__FILE__);
                    require_once("./inc/sidebar.php");
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                                    <span>Edit Category</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <?php
                        if(isset($_POST['edit-category'])){
                            $cat_id   = $_POST['edit-id'];
                            $referer  = $_SERVER['HTTP_REFERER'];
                            $url      = parse_url($referer);
                            $scheme   = $url['scheme'];
                            $host     = $url['host'];
                            $path     = $url['path'] ;
                            $replace  = str_replace('/my-cms/backend/categories.php' , '/my-cms/backend/edit-category.php' , $path);
                            $url = $scheme.'://' . $host . $replace . '?id='.$cat_id ;
                            // echo $url;
                            // $url     = "http://localhost/my-cms/backend/edit-category.php?id=".$cat_id ;
                            header("Location: {$url}");
                        }
                    ?>


                    <!-- Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Edit Category</div>
                            <?php
                                $sql  = "SELECT * FROM categories WHERE category_id = :id";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([
                                    ':id' => $_GET['id']
                                ]);

                                $category = $stmt->fetch(PDO::FETCH_ASSOC);

                                $category_title  = $category['category_name'];
                                $category_status = $category['category_status'];
                            ?>
                            <div class="card-body">
                            <?php
                                    if(isset($_POST['update-category'])) {
                                        $cat_title = trim($_POST['cat-title']);
                                        $category_status = $_POST['cat-status'];
                                        $sql = "UPDATE categories SET category_name = :title, category_status = :status WHERE category_id = :id";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute([
                                            ':title'  => $cat_title,
                                            ':status' => $category_status,
                                            ':id'     => $_GET['id']
                                        ]);
                                        header("Location: categories.php");
                                    }
                                ?>
                                <form action="edit-category.php?id=<?php echo $_GET['id']; ?>" method="post">
                                    <div class="form-group">
                                        <label for="category-title">Category Name:</label>
                                        <input value="<?php echo $category_title ?>" name="cat-title" class="form-control" id="post-title" type="text" placeholder="Category Name..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="category-status">Status:</label>
                                        <select name="cat-status" class="form-control" id="post-status">
                                            <option value="published"     <?php echo $category_status == 'published' ? 'selected' : '' ?> >Published</option>
                                            <option value="pendding"      <?php echo $category_status == 'pendding'  ? 'selected' : '' ?> >Pendding</option>
                                        </select>
                                    </div>
                                    <button name="update-category" class="btn btn-primary mr-2 my-1" type="submit">Submit now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Table -->
                </main>

 <?php require_once('./inc/footer.php'); ?>
