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
                                    <span>Create New Category</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <?php
                        if(isset($_POST['button'])){
                            $category_name   = trim($_POST['category_name']);
                            $category_status = $_POST['category_status'];

                            if(isset($_COOKIE['_uid_'])){
                                $user_id = base64_decode($_COOKIE['_uid_']);

                                $sql  = "SELECT * FROM users WHERE user_id = :id";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([
                                    ':id' => $user_id
                                ]);
                                $user       = $stmt->fetch(PDO::FETCH_ASSOC);
                                $user_name  = $user['user_name'];

                            } elseif($_SESSION['user_name']){
                                $user_name = $_SESSION['user_name'];
                            }

                            $sql  = "INSERT INTO categories (category_name, category_total_posts, total_post_views, category_status, created_on, created_by)
                                     VALUES (:cat_name, :total_post, :total_views, :cat_status, :created_on, :created_by )";

                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                ':cat_name'     => $category_name,
                                ':total_post'   => 0,
                                ':total_views'  => 0,
                                ':cat_status'   => $category_status,
                                ':created_on'   => date("M n, Y") . ' at ' . date("h:i A"),
                                ':created_by'   => $user_name
                            ]);

                            header("Location: categories.php");
                        }
                    ?>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Create New Category</div>
                            <div class="card-body">
                                <form action="new-category.php" method="post">
                                    <div class="form-group">
                                        <label for="post-title">Category Name:</label>
                                        <input class="form-control" name="category_name"  value="<?php echo isset($_POST['category_name'])?$_POST['category_name']:'' ?>"
                                                id="post-title" type="text" placeholder="Category Name..." required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="post-status">Status:</label>
                                        <select class="form-control" name="category_status" id="post-status">
                                            <option class="disabled">Choose Status</option>
                                            <option value="published" <?php if(isset($_POST["category_status"]) && $_POST["category_status"] == 'published') { echo 'selected' ;} ?>>Published</option>
                                            <option value="pendding"  <?php if(isset($_POST["category_status"]) && $_POST["category_status"] == 'pendding') { echo 'selected' ;} ?>>Pendding</option>
                                        </select>
                                    </div>
                                    <button name="button" type="submit" class="btn btn-primary mr-2 my-1">Submit now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->
                </main>

 <?php require_once('./inc/footer.php'); ?>
