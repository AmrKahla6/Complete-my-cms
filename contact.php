<?php session_start(); ?>
<?php $page_title = "Contact us" ?>
<?php require_once("./inc/header.php"); ?>

                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
                        <div class="page-header-content pt-10">
                            <div class="container text-center">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <h1 class="page-header-title mb-3">Contact Us</h1>
                                        <p class="page-header-text">We will back to you in a week!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-rounded text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0" /></svg>
                        </div>
                    </header>
                    <section class="bg-white py-10">
                        <div class="container">
                        <?php 
                            if(isset($_COOKIE['_uid_']) || isset($_COOKIE['_uiid_']) || isset($_SESSION['login'])){ ?>
                                <form action="contact.php" method="post">
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
                                ?>
                                <?php 
                                    if(isset($_POST['send'])){
                                        $message = trim($_POST['message']);
                                        $sql     = "INSERT INTO messages SET ms_username = :username, ms_useremail = :useremail, ms_detail = :detail, ms_date = :date";
                                        $stmt    = $pdo->prepare($sql);
                                        $stmt->execute([
                                            ':username'  => $username,
                                            ':useremail' => $useremail,
                                            ':detail'    => $message,
                                            ':date'      => date("M n, Y") . ' at ' . date("h:i A"),
                                        ]);
                                        echo "<div class='alert alert-success'>Message sent successfuly</div>";
                                    }
                                ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="text-dark" for="inputName">Full name</label>
                                            <input value="<?php echo $username ?>" readonly="true" class="form-control py-4" id="inputName" type="text" placeholder="Full name" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="text-dark" for="inputEmail">Email</label>
                                            <input value="<?php echo $useremail ?>" readonly="true" class="form-control py-4" id="inputEmail" type="email" placeholder="name@example.com" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-dark" for="inputMessage">Message</label>
                                        <textarea name="message" class="form-control py-3" id="inputMessage" type="text" placeholder="Enter your message..." rows="4"></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button name="send" class="btn btn-primary btn-marketing mt-4" type="submit">Submit Request</button>
                                    </div>
                                </form>
                            <?php } else { ?>
                                        <a href="./backend/signin.php">Sing in to contact us</a>
                           <?php }
                        ?>
                         

                        </div>

                        <div class="svg-border-rounded text-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0" /></svg>
                        </div>
                    </section>
                </main>
            </div>
<?php require_once("./inc/footer.php"); ?>
