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
                            <div class="page-header-content d-flex align-items-center justify-content-between text-white">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="chevrons-up"></i></div>
                                    <span>Categories</span>
                                </h1>
                                <a href="new-category.php" title="Add new category" class="btn btn-white">
                                    <div class="page-header-icon"><i data-feather="plus"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--Table-->
                    <div class="container-fluid mt-n10">

                        <div class="card mb-4">
                            <div class="card-header">All Categories</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Category Name</th>
                                                <th>Total Posts</th>
                                                <th>Created By</th>
                                                <th>Status</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $sql  = "SELECT * FROM categories ORDER BY category_total_posts DESC";
                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute();
                                            $x = 1;
                                            while($categoris = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                $category_id     = $categoris['category_id'];
                                                $category_name   = $categoris['category_name'];
                                                $total_posts     = $categoris['category_total_posts'];
                                                $category_status = $categoris['category_status'];
                                                $created_by      = $categoris['created_by']; ?>

                                                    <tr>
                                                        <td><?php echo $x++ ?></td>
                                                        <td><?php echo $category_id ?></td>
                                                        <td>
                                                            <?php
                                                                if($total_posts == 0){?>
                                                                        <?php echo $category_name ?>
                                                                <?php } else { ?>
                                                                    <a href="../categories.php?category_id=<?php echo $category_id ?>&category_name=<?php echo $category_name ?>" target="_blank">
                                                                        <?php echo $category_name ?>
                                                                    </a>
                                                               <?php }
                                                            ?>

                                                        </td>
                                                        <td><?php echo $total_posts ?></td>
                                                        <td><?php echo $created_by ?></td>
                                                        <td>
                                                            <?php
                                                                if($category_status == "published"){?>
                                                                    <div class="badge badge-success"><?php echo $category_status ?>
                                                                <?php } else { ?>
                                                                    <div class="badge badge-warning"><?php echo $category_status ?>
                                                               <?php }
                                                            ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <form action="edit-category.php" method="post">
                                                            <input type="hidden" name="edit-id" value="<?php echo $category_id ?>">
                                                                <button name="edit-category" type="submit" class="btn btn-blue btn-icon"><i data-feather="edit"></i></button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                        <?php
                                                            if(isset($_POST['delete-category'])){
                                                                $sql  = "DELETE FROM categories WHERE category_id = :id";
                                                                $stmt = $pdo->prepare($sql);
                                                                $stmt->execute([
                                                                    ':id' => $_POST['id'],
                                                                ]);
                                                                    header("Location: categories.php");
                                                            }
                                                        ?>

                                                        <?php
                                                            if($total_posts == 0){ ?>
                                                                <form action="categories.php" method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $category_id ?>">
                                                                    <button name="delete-category" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                                </form>
                                                            <?php } else{ ?>
                                                                <button title="You can not delete category having a posts!" name="delete-category" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                            <?php }
                                                        ?>
                                                        </td>
                                                    </tr>

                                            <?php }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>

<?php require_once('./inc/footer.php'); ?>
