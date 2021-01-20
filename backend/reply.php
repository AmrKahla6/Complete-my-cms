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
                    <?php 
                        if(isset($_POST['response'])){
                            $reply_id = $_POST['id'];
                            $referer  = $_SERVER['HTTP_REFERER'];
                            $replace  = str_replace('messages.php' , 'reply.php' , $referer);

                            $url      = $replace . '?id='. $reply_id ;
                            header("Location: {$url}");
                        }
                    
                    ?>
          

            <div id="layoutSidenav_content">
            <main>
                    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
                        <div class="container-fluid">
                            <div class="page-header-content">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="mail"></i></div>
                                    <span>Reply</span>
                                </h1>
                            </div>
                        </div>
                    </div>

                    <?php 
                        if(isset($_POST['send-reply'])) {
                            $reply = trim($_POST['reply']);
                            $sql = "UPDATE messages SET ms_status = :status, ms_state = :state, ms_reply = :reply WHERE ms_id = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                ':status' => 'Processed',
                                ':state' => 1,
                                ':reply'=>$reply,                                 
                                ':id'=>$_GET['id']
                            ]);
                            $success = true;
                            header("Refresh:2;url=messages.php");
                        }
                    ?>

                    <!--Start Form-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Reponse Area:</div>
                            <div class="card-body">
                                <?php 
                                    $sql = "SELECT * FROM messages WHERE ms_id = :id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([':id'=>$_GET['id']]);
                                    $ms = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $ms_detail   = $ms['ms_detail'];
                                    $ms_username = $ms['ms_username'];
                                ?>
                                <?php 
                                    if(isset($_COOKIE['_uid_'])) {
                                        $user_id = base64_decode($_COOKIE['_uid_']);
                                    } else if(isset($_SESSION['user_id'])) {
                                        $user_id = $_SESSION['user_id'];
                                    } else {
                                        $user_id = -1;
                                    }
                                    $sql = "SELECT * FROM users WHERE user_id = :id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([
                                        ':id' => $user_id
                                    ]);
                                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $user_name = $user['user_name'];
                                ?>

                                <?php
                                    if(isset($success)){
                                        echo '<div class="alert alert-success"> Reply sent successfuly </div>';
                                    }
                                ?>
                                <form action="reply.php?id=<?php echo $_GET['id']; ?>" method="POST">
                                    <div class="form-group">
                                        <label for="post-content">Message:</label>
                                        <textarea class="form-control" placeholder="Type here..." id="post-content" rows="9" readonly="true"><?php echo $ms_detail; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="user-name">User name:</label>
                                        <input name="user-name" value="<?php echo $ms_username; ?>" class="form-control" id="user-name" type="text" placeholder="User name ..." readonly="true" value="Md. A. Barik" />
                                    </div>                               

                                    <div class="form-group">
                                        <label for="post-tags">Reply:</label>
                                        <textarea name="reply" class="form-control" placeholder="Type your reply here..." id="post-tags" rows="9"></textarea>
                                    </div>

                                    <button name="send-reply" class="btn btn-primary mr-2 my-1" type="submit">Send my respose</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Form-->

                </main>

<?php require_once('./inc/footer.php'); ?>
