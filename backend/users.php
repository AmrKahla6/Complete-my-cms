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
                                    <div class="page-header-icon"><i data-feather="users"></i></div>
                                    <span>All Users</span>
                                </h1>
                                <a href="new-user.php" title="Add new category" class="btn btn-white">
                                    <div class="page-header-icon"><i data-feather="plus"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">All Users</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Photo</th>
                                                <th>Registered on</th>
                                                <th>Role</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $sql  = "SELECT * FROM users ORDER BY user_id DESC";
                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute();
                                            $x = 1;

                                            while($users = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                $user_id       = $users['user_id'];
                                                $user_name     = $users['user_name'];
                                                $user_email    = $users['user_email'];
                                                $user_photo    = $users['user_photo'];
                                                $registered_on = $users['registered_on'];
                                                $user_role     = $users['user_role'];
                                                ?>
                                            <tr>
                                                <td><?php echo $x++ ?></td>
                                                <td><?php echo $user_id ?></td>
                                                <td>
                                                    <?php echo $user_name ?>
                                                </td>
                                                <td>
                                                    <?php echo $user_email ?>
                                                </td>
                                                <td>
                                                    <img class="img-thumbnail" src="../img/users/<?php echo $user_photo ?>" alt="<?php echo $user_photo ?>" width="50px" hieght="50px" srcset="">
                                                </td>
                                                <td><?php echo $registered_on ?></td>
                                                <td>
                                                    <div class="badge badge-<?php echo $user_role == "admin" ? "red" : "success" ?>">
                                                        <?php echo $user_role ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                       if(isset($_COOKIE['_uid_'])){
                                                        $u_id = base64_decode($_COOKIE['_uid_']);
                                                    }else if(isset($_SESSION['user_id'])){
                                                        $u_id = $_SESSION['user_id'];
                                                    } else {
                                                        $u_id = -1;
                                                    }
                                                    ?>

                                                    <?php
                                                      if($user_id == $u_id){ ?>
                                                         <button title="You can not edit yourself" class="btn btn-primary btn-icon"><i data-feather="edit"></i></button>
                                                    <?php } else { ?>
                                                        <form action="user-update.php" method="post">
                                                            <input type="hidden" name="user-id" value="<?php echo $user_id ?>">
                                                            <button name="edit_user" type="submit" class="btn btn-primary btn-icon"><i data-feather="edit"></i></button>
                                                        </form>
                                                    <?php }
                                                    ?>

                                                </td>
                                                <td>
                                                <?php
                                                    if(isset($_POST['del_user'])){
                                                        $u_id = $_POST['user_id'];
                                                        $sql  = "DELETE FROM users WHERE user_id = :id";
                                                        $stmt = $pdo->prepare($sql);
                                                        $stmt->execute([
                                                            ':id' => $u_id,
                                                        ]);
                                                        header("Location: users.php");
                                                    }
                                                ?>

                                                <?php
                                                    if(isset($_COOKIE['_uid_'])){
                                                        $u_id = base64_decode($_COOKIE['_uid_']);
                                                    }else if(isset($_SESSION['user_id'])){
                                                        $u_id = $_SESSION['user_id'];
                                                    } else {
                                                        $u_id = -1;
                                                    }
                                                ?>

                                                <?php
                                                    if($user_id == $u_id){
                                                        echo '<button title="You can not delete yourself" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>';
                                                    } else { ?>
                                                        <form action="users.php" method="post">
                                                            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                                                            <button name="del_user" type="submit" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
                                                        </form>
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
                    <!--End Table-->
                </main>

<?php require_once('./inc/footer.php'); ?>
