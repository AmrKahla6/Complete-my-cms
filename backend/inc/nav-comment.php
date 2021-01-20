 <?php 
    $sql  = "SELECT * FROM comments WHERE com_state = :state";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':state' => 0
    ]);
    $count = $stmt->rowCount();
 ?>
 
 <!--User Registration + New Comment Notification-->
 <li class="nav-item dropdown no-caret mr-3 dropdown-notifications">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="comments.php" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="bell"></i>
                        <?php 
                            if($count != 0) { ?>
                                <span class="badge badge-red"> <?php echo $count ?> </span>
                           <?php }
                        ?>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                        <h6 class="dropdown-header dropdown-notifications-header">
                            <i class="mr-2" data-feather="bell"></i>
                            Notification
                        </h6>

                        <?php 
                            $sql  = "SELECT * FROM comments WHERE com_state = :state";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                ':state' => 0
                            ]);
                            while($comments = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $com_date        = $comments['com_date'];
                                $com_detail      = substr($comments['com_detail'], 0, 20); 
                                $com_user_name   = $comments['com_user_name'];?>

                                <a class="dropdown-item dropdown-notifications-item" href="comments.php">
                                    <div class="dropdown-notifications-item-icon bg-warning"><i data-feather="activity"></i></div>
                                    <div class="dropdown-notifications-item-content">

                                        <div class="dropdown-notifications-item-content-details">
                                           <?php echo $com_date ?>
                                        </div>
                                        <div class="dropdown-notifications-item-content-text">
                                            <?php echo $com_detail ?>
                                        </div>
                                        <div class="dropdown-notifications-item-content-details">
                                            <?php echo $com_user_name  ?>
                                        </div>
                                    </div>
                                </a>
                          <?php  }
                        ?>

                       

                        <a class="dropdown-item dropdown-notifications-footer" href="comments.php">
                            View All Comments
                        </a>
                    </div>
                </li>
                <!--User Registration + New Comment Notification-->