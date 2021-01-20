

    <?php 
            $sql  = "SELECT * FROM messages WHERE ms_state = :state";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':state' => 0
            ]);
            $count = $stmt->rowCount();
        ?>


<li class="nav-item dropdown no-caret mr-3 dropdown-notifications">
    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i data-feather="mail"></i>
        <span class="badge badge-red"><?php echo $count ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownMessages">
        <h6 class="dropdown-header dropdown-notifications-header">
            <i class="mr-2" data-feather="mail"></i>
            Message Notification
        </h6>

        <?php 
            while($messages = $stmt->fetch(PDO::FETCH_ASSOC)){
                $ms_detail   = $messages['ms_detail'];
                $ms_username = $messages['ms_username'];
                $ms_date     = $messages['ms_date']; ?>


                    <a class="dropdown-item dropdown-notifications-item" href="messages.php">
                        <div class="dropdown-notifications-item-content">
                            <div class="dropdown-notifications-item-content-text">
                                <?php echo  $ms_detail ?>
                            </div>
                            <div class="dropdown-notifications-item-content-details">
                                <?php echo $ms_username ?> &#xB7; <?php echo $ms_date ?>
                            </div>
                        </div>
                    </a>

           <?php }
        ?>
        <a class="dropdown-item dropdown-notifications-footer" href="messages.php">
            Read All Messages
        </a>
    </div>
</li>