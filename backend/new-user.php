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
                                    <span>Create New User</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <?php
                        if(isset($_POST['user_create'])){
                            $errors     = array();
                            $name       = trim( $_POST['name']);
                            $user_name  = trim($_POST['user-name']);
                            $user_email = trim($_POST['user-email']);
                            $user_pass  = trim($_POST['user-pass']);
                            $user_role  = trim($_POST['user-role']);

                            $sql  = "SELECT * FROM users WHERE user_nickname = :username";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                ':username' => $user_name,
                            ]);

                            $username_count = $stmt->rowCount();
                            if($username_count >= 1){
                                $errors[] = "Username exist!";
                            }

                            $sql1  = "SELECT * FROM users WHERE user_email = :email";
                            $stmt1 = $pdo->prepare($sql1);
                            $stmt1->execute([
                                ':email' => $user_email,
                            ]);

                            $email_count = $stmt1->rowCount();
                            if($email_count >= 1){
                                $errors[] = "Email exist!";
                            } else {
                                // Upload pic
                                $pass_hash  = password_hash($user_pass, PASSWORD_BCRYPT, ['cost' => 10]);
                                $user_photo = $_FILES['user-photo']['name'];
                                $photo_temp = $_FILES['user-photo']['tmp_name'];

                                move_uploaded_file("{$photo_temp}", "../img/users/{$user_photo}");

                                $sql  = "INSERT INTO users (user_name, user_nickname, user_email, user_password, user_photo, registered_on, user_role)
                                         VALUES (:name, :user_name, :user_email, :user_pass, :user_photo, :reg_in, :user_role)";

                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([
                                    ':name'        => $name,
                                    ':user_name'   => $user_name,
                                    ':user_email'  => $user_email,
                                    ':user_pass'   => $pass_hash,
                                    ':user_photo'  => $user_photo,
                                    ':reg_in'      => date("M n, Y") . ' at ' . date("h:i A"),
                                    ':user_role'   => $user_role,
                                ]);
                                $sucess = "User Added successfuly!";
                                // header("Location: new-user.php");
                            }
                        }
                    ?>

                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Create New User</div>
                            <div class="card-body">
                                <form action="new-user.php" method="POST" enctype="multipart/form-data">
                                    <?php
                                        if(isset($errors)) {
                                            foreach($errors as $error):
                                                echo "<div class='alert alert-danger text-center'>{$error}</div><br>";
                                            endforeach;
                                        }if(isset($sucess)) {
                                            echo "<div class='alert alert-success text-center'>
                                                    {$sucess}
                                                    </div>";
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input name="name" class="form-control" id="name" type="text" placeholder="User Full Name..."
                                               value="<?php echo isset($_POST['name'])?$_POST['name']:'' ?>" required="true" />
                                    </div>
                                    <div class="form-group">
                                        <label for="user-name">User Name:</label>
                                        <input name="user-name" class="form-control" id="user-name" type="text" placeholder="User Name..."
                                               value="<?php echo isset($_POST['user-name'])?$_POST['user-name']:'' ?>" required="true" />
                                    </div>
                                    <div class="form-group">
                                        <label for="user-email">User Email:</label>
                                        <input name="user-email" class="form-control" id="user-email" type="email" placeholder="User Email..."
                                              value="<?php echo isset($_POST['user-email'])?$_POST['user-email']:'' ?>" required="true"  />
                                    </div>
                                    <div class="form-group">
                                        <label for="user-password">User Password:</label>
                                        <input name="user-pass" class="form-control" id="user-password" type="password" placeholder="User Password..."
                                               value="<?php echo isset($_POST['user-pass'])?$_POST['user-pass']:'' ?>" required="true" />
                                    </div>
                                    <div class="form-group">
                                        <label for="user-role">Role:</label>
                                        <select name="user-role" class="form-control" id="user-role">
                                            <option class="disabled">Choose User Role</option>
                                            <option value="admin"      <?php if(isset($_POST["user-role"]) && $_POST["user-role"] == 'admin') { echo 'selected' ;}?> >Admin</option>
                                            <option value="subscriber" <?php if(isset($_POST["user-role"]) && $_POST["user-role"] == 'subscriber') { echo 'selected' ;}?> >subscriber</option>
                                        </select>
                                        <div class="form-group">
                                        <label for="user-photo">Choose photo:</label>
                                        <input name="user-photo" class="form-control-file" id="user-photo" type="file" />
                                    </div>
                                    </div>
                                    <button name="user_create" class="btn btn-primary mr-2 my-1" type="submit">Create now!</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Table-->
                </main>

<?php require_once('./inc/footer.php'); ?>
