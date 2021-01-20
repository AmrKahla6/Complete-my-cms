<nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
            <a class="navbar-brand d-none d-sm-block" href="index.php">Admin Panel</a><button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i data-feather="menu"></i></button>
            <ul class="navbar-nav align-items-center ml-auto">

                <!--User Registration + New Comment Notification-->
                    <?php include_once('nav-comment.php') ?>
                <!--User Registration + New Comment Notification-->

                <!--Message Notification-->
                     <?php include_once('nav-message.php') ?>
                <!--Message Notification-->
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

                    $username  = $user['user_name'];
                    $useremail = $user['user_email'];
                    $userphoto = $user['user_photo']
                ?>

                <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="img-fluid" src="../img/users/<?php echo $userphoto ?>"/>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img" src="../img/users/<?php echo $userphoto ?>" alt="<?php echo $username ?>" />
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name">
                                    <?php echo $username ?>
                                </div>
                                <div class="dropdown-user-details-email">
                                <?php echo $useremail ?>
                                </div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="profile.php">
                            <div class="dropdown-item-icon">
                                <i data-feather="settings"></i>
                            </div>
                            Profile
                        </a>
                        <a class="dropdown-item" href="logout.php"
                            ><div class="dropdown-item-icon">
                                <i data-feather="log-out"></i>
                            </div>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
