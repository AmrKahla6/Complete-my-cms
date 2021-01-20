<?php session_start(); ?>
<?php require_once("../inc/db.php"); ?>
<?php

    if(isset($_SESSION['login']) || isset($_COOKIE['_uid_']) || isset($_COOKIE['_uiid_']))
    {
        header("Location: ../index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Password recovery || Admin Panel</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="js/all.min.js"></script>
        <script src="js/feather.min.js"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center"><h3 class="font-weight-light my-4">Password Recovery</h3></div>
                                    <div class="card-body">
                                        <?php
                                            if(isset($_POST['reset'])) {
                                                $nickname = trim($_POST['nickname']);
                                                $email = trim($_POST['email']);

                                                $sql = "SELECT * FROM users WHERE user_nickname = :nickname AND user_email = :email";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute([
                                                    ':nickname' => $nickname,
                                                    ':email' => $email
                                                ]);
                                                $count = $stmt->rowCount();
                                                if($count == 1) {
                                                    $user     = $stmt->fetch(PDO::FETCH_ASSOC);
                                                    $user_id  = $user['user_id'];
                                                    $show = "new password";
                                                } else {
                                                    echo "<p class='alert alert-danger text-center'>Wrong Email Or Password!</p>";
                                                }
                                            }

                                            if(isset($_POST['update'])){
                                                $password  = trim($_POST['password']);
                                                $conf_pass = trim($_POST['confirm-password']);
                                                $user_id   = $_POST['id'];
                                                $show      = "new password";

                                                if($password == $conf_pass){
                                                    $reg="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
                                                    if(!preg_match($reg,$password)){
                                                        echo "<div class='alert alert-danger text-center'>This password is weak , Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character</div>";
                                                }else {
                                                        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost'=>10]);
                                                        $sql  = "UPDATE users SET user_password = :password WHERE user_id = :id";
                                                        $stmt = $pdo->prepare($sql);
                                                        $stmt->execute([
                                                            ':password' => $hash,
                                                            ':id'       => $user_id,
                                                        ]);
                                                        echo "<div class='alert alert-success text-center'>Password updated successfuly <a href='signin.php'>login now</a></div>";
                                                    }
                                            }else{
                                                    echo "<div class='alert alert-danger text-center'>Password doesn't match!</div>";
                                                }
                                            }
                                        ?>
                                        <?php
                                            if(!isset($show)) { ?>
                                                <form action="forgot-password.php" method="POST">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="Nickname">Username</label>
                                                        <input name="nickname" class="form-control py-4" id="Nickname" type="text" placeholder="Enter Nickname..." />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                        <input name="email" class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address..." />
                                                    </div>
                                                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                        <a class="small" href="signin.php">Return to signin</a>
                                                        <button name="reset" class="btn btn-primary" type="submit">Reset Password</button>
                                                    </div>
                                                </form>
                                           <?php } else { ?>
                                                <form action="forgot-password.php" method="POST">
                                                    <div class="form-group">
                                                    <input type="hidden" name="id" value="<?php echo $user_id ?>">
                                                        <label class="small mb-1" for="passowrd">Passowrd</label>
                                                        <input name="password" class="form-control py-4" id="passowrd" type="password" placeholder="Password" required="true" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="confirmpassword">Confirm Password</label>
                                                        <input name="confirm-password" class="form-control py-4" type="password" placeholder="Confirm password" required="true" />
                                                    </div>
                                                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                        <button name="update" class="btn btn-primary" type="submit">Update Password</button>
                                                    </div>
                                                </form>
                                           <?php }
                                        ?>

                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="signup.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!--Script JS-->
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
