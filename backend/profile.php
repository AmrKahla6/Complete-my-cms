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
                                    <div class="page-header-icon"><i data-feather="user"></i></div>
                                    <span>Your Profile</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <?php
                        if(isset($_COOKIE['_uid_'])){
                            $userid = base64_decode($_COOKIE['_uid_']);
                        }else if(isset($_SESSION['user_id'])){
                            $userid = $_SESSION['user_id'];
                        } else {
                            $userid = -1;
                        }

                        $sql  = "SELECT user_name, user_email, user_photo FROM users WHERE user_id = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':id' => $userid,
                        ]);

                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        // $userid    = $user['user_id'];
                        $username  = $user['user_name'];
                        $useremail = $user['user_email'];
                        $userphoto = $user['user_photo']
                ?>

                <?php
                    if(isset($_POST['update_profile'])){
                        $username  = $_POST['username'];
                        $useremail = $_POST['useremail'];
                        $userphoto = $_FILES['userphoto']['name'];
                        $userphoto_temp = $_FILES['userphoto']['tmp_name'];

                        $uid = $_SESSION['user_id'];
                        $fdir= $uid.".jpg";

                        move_uploaded_file("{$userphoto_temp}", "../img/users/{$fdir}");

                        if(empty($userphoto)){
                            $sql  = "SELECT user_photo FROM users WHERE user_id = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                ':id' => $userid,
                            ]);

                            $u = $stmt->fetch(PDO::FETCH_ASSOC);
                            $userphoto = $u['user_photo'];
                        }

                        $sql  = "UPDATE users SET user_name = :name, user_email = :email, user_photo = :photo WHERE user_id = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':name'  => $username,
                            ':email' => $useremail,
                            ':photo' => $fdir,
                            ':id'    => $userid,
                        ]);

                        header("Location: profile.php");
                    }
                ?>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Profile</div>
                            <div class="card-body">
                                <form action="profile.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="user-name">User Name:</label>
                                        <input value="<?php echo $username ?>" name="username" class="form-control" id="user-name" type="text" placeholder="User Name..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="user-email">User Email:</label>
                                        <input value="<?php echo $useremail ?>" name="useremail" class="form-control" id="user-email" type="email" placeholder="User Email..." />
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                        <label for="post-title">Choose photo:</label>
                                        <input name="userphoto" class="form-control-file" id="post-title" type="file" /> <br>
                                        <img src="../img/users/<?php echo $userphoto ?>" alt="<?php echo $username ?>" width="100" height="100" class="img-thumbnail">
                                    </div>
                                    </div>
                                    <button name="update_profile" class="btn btn-primary mr-2 my-1" type="submit">Update now!</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->
                </main>

<?php require_once('./inc/footer.php'); ?>
