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
                                    <div class="page-header-icon"><i data-feather="mail"></i></div>
                                    <span>Messages</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <!--Start Table-->
                    <div class="container-fluid mt-n10">
                        <div class="card mb-4">
                        <?php 
                            if(isset($sccess)){
                                echo "<div class='alert alert-success'> Message deleted successfuly</div>";
                            }
                        ?>
                            <div class="card-header">All Messages</div>
                            <div class="card-body">
                                <div class="datatable table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Message</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Response</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php 
                                            $sql  = "SELECT * FROM messages ORDER BY ms_id DESC";
                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute();
                                            $x = 1;
                                            while($messages = $stmt->fetch(PDO::FETCH_ASSOC)){ 
                                                $ms_id          = $messages['ms_id'];
                                                $ms_username    = $messages['ms_username'];
                                                $ms_useremail   = $messages['ms_useremail'];
                                                $ms_detail      = substr( $messages['ms_detail'], 0, 20);
                                                $ms_date        = $messages['ms_date'];
                                                $ms_status      = $messages['ms_status'];
                                                $ms_state       = $messages['ms_state'];
                                                
                                                ?>
                                                        <tr>
                                                            <td><?php echo $x; ?></td>
                                                            <td><?php echo $ms_id; ?></td>
                                                            <td>
                                                                <?php echo $ms_username; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $ms_useremail; ?>
                                                            </td>
                                                            <td><?php echo $ms_detail ?></td>
                                                            <td><?php echo $ms_date; ?></td>
                                                            <td>
                                                                <div class="badge badge-<?php echo $ms_status == "pendding" ? "warning" : "success" ?>">
                                                                    <?php echo $ms_status; ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                            <?php 
                                                                if($ms_state == 0){ ?>
                                                                    <form action="reply.php" method="POST">
                                                                        <input type="hidden" name="id" value="<?php echo $ms_id ?>">
                                                                        <button name="response" type="submit" class="btn btn-success btn-icon"><i data-feather="mail"></i></button>
                                                                    </form>
                                                               <?php } else { ?>
                                                                        <button title="Already responded!" class="btn btn-success btn-icon"><i data-feather="check"></i></button>
                                                             <?php  }
                                                            ?>
                                                            </td>
                                                            <td>
                                                            <?php 
                                                                if(isset($_POST['del_msg'])){
                                                                    $id      = $_POST['id'];

                                                                    $sql  = "DELETE FROM messages WHERE ms_id = :id";
                                                                    $stmt = $pdo->prepare($sql);
                                                                    $stmt->execute([
                                                                        ':id' => $id,
                                                                    ]);
                                                                    $sccess = true;
                                                                    header("Location: messages.php");
                                                                }
                                                            ?>
                                                                <form action="messages.php" method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $ms_id; ?>">
                                                                    <button name="del_msg" type="submit" class="btn btn-red btn-icon"><i data-feather="trash-2"></i></button>
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
