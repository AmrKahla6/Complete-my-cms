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
                                    <div class="page-header-icon"><i data-feather="package"></i></div>
                                    <span>All Comments</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">All Comments</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>In response to</th>
                                                <th>Details</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Approve</th>
                                                <th>Unapproved</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                            $sql  = "SELECT * FROM comments ORDER BY com_id DESC";
                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute();
                                            $x = 1;

                                            while($comments = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                $com_id        = $comments['com_id'];
                                                $com_post_id   = $comments['com_post_id'];
                                                $com_detail    = $comments['com_detail'];
                                                $com_user_id   = $comments['com_user_id'];
                                                $com_user_name = $comments['com_user_name'];
                                                $com_date      = $comments['com_date'];
                                                $com_status    = $comments['com_status'];

                                                //user name & user email from user table
                                                $sql1  = "SELECT * FROM users WHERE user_id = :id";
                                                $stmt1 = $pdo->prepare($sql1);
                                                $stmt1->execute([
                                                    ':id' => $com_user_id
                                                ]);
                                                    $user       = $stmt1->fetch(PDO::FETCH_ASSOC);
                                                    $user_name  = $user['user_name'];
                                                    $user_email = $user['user_email'];

                                                //post_id & user post_title from posts table

                                                 $sql2  = "SELECT * FROM posts WHERE post_id = :id";
                                                 $stmt2 = $pdo->prepare($sql2);
                                                 $stmt2->execute([
                                                     ':id' => $com_post_id
                                                 ]);

                                                 $post       = $stmt2->fetch(PDO::FETCH_ASSOC);
                                                 $post_id    = $post['post_id'];
                                                 $post_title = $post['post_title'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $x++ ?></td>
                                                    <td><?php echo $com_id ?></td>
                                                    <td>
                                                        <?php echo $user_name ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $user_email ?>
                                                    </td>

                                                    <td>
                                                        <a href="../single.php?post_id=<?php echo $post_id ?>" target="_blank">
                                                            <?php echo $post_title ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $com_detail ?></td>
                                                    <td><?php echo $com_date ?></td>
                                                    <td>
                                                        <?php
                                                            if($com_status == "approved"){ ?>
                                                                <div class="badge badge-success">
                                                                    <?php echo $com_status ?>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="badge badge-warning">
                                                                    <?php echo $com_status ?>
                                                                </div>
                                                            <?php }
                                                        ?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                        if(isset($_POST['approve'])){
                                                            $comment_id = $_POST['comment_id'];

                                                            $sql  = "UPDATE comments SET com_status = :status WHERE com_id = :id";
                                                            $stmt = $pdo->prepare($sql);
                                                            $stmt->execute([
                                                                ':status' => 'approved',
                                                                ':id'     => $comment_id
                                                            ]);
                                                            header("Location: comments.php");
                                                        }
                                                    ?>
                                                    <?php
                                                        if($com_status == "approved"){?>
                                                            <button title="The status already approved" class="btn btn-success btn-icon"><i data-feather="check"></i></button>
                                                        <?php } else { ?>
                                                            <form action="comments.php" method="post">
                                                                <input type="hidden" name="comment_id" value="<?php echo $com_id ?>">
                                                                <button type="submit" name="approve" class="btn btn-success btn-icon"><i data-feather="check"></i></button>
                                                            </form>
                                                       <?php }
                                                    ?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                        if(isset($_POST['unapprove'])){
                                                        $comment_id = $_POST['comment_id'];

                                                        $sql  = "UPDATE comments SET com_status = :status WHERE com_id = :id";
                                                        $stmt = $pdo->prepare($sql);
                                                        $stmt->execute([
                                                            ':status' => 'unapproved',
                                                            ':id'     => $comment_id
                                                        ]);
                                                        header("Location: comments.php");
                                                    }
                                                    ?>
                                                    <?php
                                                        if($com_status != "approved"){?>
                                                             <button title="The status already unapproved"  class="btn btn-red btn-icon"><i data-feather="delete"></i></button>
                                                        <?php } else { ?>
                                                            <form action="comments.php" method="post">
                                                                <input type="hidden"  name="comment_id" value="<?php echo $com_id ?>">
                                                                <button type="submit" name="unapprove" class="btn btn-red btn-icon"><i data-feather="delete"></i></button>
                                                            </form>
                                                       <?php }
                                                    ?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                        if(isset($_POST['delete'])){
                                                            $com_id = $_POST['comment_id'];

                                                            $sql  = "DELETE FROM comments WHERE com_id =:id";
                                                            $stmt = $pdo->prepare($sql);
                                                            $stmt->execute([
                                                                ':id' => $com_id,
                                                            ]);

                                                            header("Location: comments.php");
                                                        }
                                                    ?>
                                                        <form action="comments.php" method="post">
                                                            <input type="hidden"  name="comment_id" value="<?php echo $com_id ?>">
                                                            <button type="submit" name="delete" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                        </form>
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
                    <!--End Table-->

                </main>

<?php require_once('./inc/footer.php'); ?>
