<?php session_start(); ?>
<?php $page_title = $_GET['category_name'] .' '. "Category" ?>
<?php require_once("./inc/header.php"); ?>
                    <header class="page-header page-header-dark bg-secondary">
                        <div class="page-header-content">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-xl-8 col-lg-10 text-center">

                                        <h1 class="page-header-title">Welcome to <?php echo $_GET['category_name'] ?> Category</h1>
                                        <p class="page-header-text mb-5">Are you searching for some content that you haven't found yet? Try searching in the search box below!</p>
                                        <form class="page-header-signup mb-2 mb-md-0" action="category-search.php" method="post">
                                            <div class="form-row justify-content-center">
                                                <div class="col-lg-6 col-md-8">
                                                    <div class="form-group mr-0 mr-lg-2">
                                                        <input class="form-control form-control-solid rounded-pill" name="search" type="text" placeholder="Search keyword..."/>
                                                        <input name="category_id" value="<?php echo $_GET['category_id'] ?>" type="hidden"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4"><button class="btn btn-teal btn-block btn-marketing rounded-pill" type="submit">Search</button></div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-waves text-white">
                            <svg class="wave" style="pointer-events: none" fill="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
                                <defs>
                                    <style>
                                        .a {
                                            fill: none;
                                        }
                                        .b {
                                            clip-path: url(#a);
                                        }
                                        .d {
                                            opacity: 0.5;
                                            isolation: isolate;
                                        }
                                    </style>
                                    <clipPath id="a"><rect class="a" width="1920" height="75" /></clipPath>
                                </defs>
                                <title>wave</title>
                                <g class="b"><path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48" /></g>
                                <g class="b"><path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10" /></g>
                                <g class="b"><path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24" /></g>
                                <g class="b"><path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150" /></g>
                            </svg>
                        </div>
                    </header>
                    <section class="bg-white py-10">
                        <!--Start-->
                        <div class="container">
                        <h1>Most popular post:</h1>
                        <hr />
                        <?php
                           $sql3 = "SELECT * FROM posts WHERE post_category_id = :id ORDER BY post_views DESC LIMIT 0 , 1";
                           $stmt = $pdo->prepare($sql3);
                           $stmt->execute([
                               ':id' => $_GET['category_id']
                           ]);
                           $post = $stmt->fetch(PDO::FETCH_ASSOC);

                            $post_id       = isset($post["post_id"])          ? $post["post_id"]          : ''       ;
                            $post_title    = isset($post["post_title"])       ? $post["post_title"]       : ''       ;
                            $post_detail   = isset($post['post_detail'])      ?  $post['post_detail']     : ''       ;
                            $post_category = isset($post['post_category_id']) ? $post['post_category_id'] : ''       ;
                            $post_image    = isset($post['post_image'])       ? $post['post_image']       : ''       ;
                            $post_date     = isset($post['post_date'])        ?  $post['post_date']       : ''       ;
                            $post_author   = isset($post['post_author'])      ? $post['post_author']      : ''       ;
                            $post_view     = isset($post['post_views'])       ? $post['post_views']       : ''       ;

                        ?>
                            <a class="card post-preview post-preview-featured lift mb-5" href="single.php?post_id=<?php echo $post_id ?>">
                                <div class="row no-gutters">
                                    <div class="col-lg-5"><div class="post-preview-featured-img" style='background-image: url("./img/<?php echo $post_image ?>")'></div></div>
                                    <div class="col-lg-7">
                                        <div class="card-body">
                                            <div class="py-5">
                                                <h5 class="card-title"><?php
                                                    if($post_title){
                                                        echo $post_title ;
                                                    } else {
                                                        echo "No posts in this category";
                                                    }
                                                ?></h5>
                                                <p class="card-text">
                                                    <?php echo substr($post_detail , 0 , 140) ?>
                                                </p>
                                            </div>
                                            <hr />
                                            <div class="post-preview-meta">
                                                <img class="post-preview-meta-img" src="./img/pic.jpg" />
                                                <div class="post-preview-meta-details">
                                                    <div class="post-preview-meta-details-name"><?php echo $post_author ?></div>
                                                    <div class="post-preview-meta-details-date"><?php echo $post_date ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <?php
                                $sql = "SELECT * FROM posts WHERE post_status = :status AND post_category_id = :id";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([
                                    ':status' => 'Published',
                                    ':id' => $_GET['category_id']
                                ]);
                                $post_count = $stmt->rowCount();
                                $post_per_page = 3;
                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                    if($page == 1) {
                                        $page_id = 0;
                                    } else {
                                        $page_id = ($page * $post_per_page) - $post_per_page;
                                    }
                                } else {
                                    $page = 1;
                                    $page_id = 0;
                                }
                                $total_pager = ceil($post_count / $post_per_page);
                            ?>


                            <h1>Recent posting:</h1>
                            <hr />
                            <div class="row">
                            <?php

                                $sql  = "SELECT * FROM posts WHERE post_status = :status AND post_category_id = :id ORDER BY post_id DESC LIMIT $page_id, $post_per_page";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([
                                    ":status" => "published",
                                    ':id'     => $_GET['category_id']
                                ]);

                                while($posts = $stmt->fetch(PDO::FETCH_ASSOC))
                                {
                                    $post_id       = $posts['post_id']       ;
                                    $post_title    = $posts['post_title']    ;
                                    $post_detail   = $posts['post_detail']   ;
                                    $post_category = $posts['post_category_id'] ;
                                    $post_image    = $posts['post_image']    ;
                                    $post_date     = $posts['post_date']     ;
                                    $post_author   = $posts['post_author']   ;
                                    $post_view     = $posts['post_views']    ;
                                    ?>

                                    <div class="col-md-6 col-xl-4 mb-5">
                                        <a class="card post-preview lift h-100" href="single.php?post_id=<?php echo $post_id; ?>"
                                            ><img class="card-img-top" style="height: 250px; width=100%" src="./img/<?php echo $post_image ?>" alt="<?php echo $post_image ?>" />
                                            <div class="card-body">
                                                <h5 class="card-title"> <?php echo $post_title ?>  </h5>
                                                <p class="card-text">   <?php echo substr($post_detail , 0 , 140) ?>  </p>
                                            </div>
                                            <div class="card-footer d-flex align-items-center justify-content-between">
                                                <div class="post-preview-meta">
                                                    <img class="post-preview-meta-img" src="./img/pic.jpg" />
                                                    <div class="post-preview-meta-details">
                                                        <div class="post-preview-meta-details-name"><?php echo $post_author ?></div>
                                                        <div class="post-preview-meta-details-date"><?php echo $post_date ?> </div>
                                                    </div>
                                                </div>
                                                <div class="post-preview-meta">
                                                    <?php echo $post_view  ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <?php
                                if($post_count > $post_per_page){?>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination pagination-blog justify-content-center">
                                        <?php
                                            if(isset($_GET['page']))
                                            {
                                                $prev = $_GET['page'] - 1;
                                            } else {
                                                $prev = 0;
                                            }

                                            if($prev + 1 <= 1){
                                                echo    '<li class="page-item disabled">
                                                            <a class="page-link" href="#!" aria-label="Previous"><span aria-hidden="true">&#xAB;</span></a>
                                                        </li>';
                                            } else {
                                                echo    '<li class="page-item">
                                                            <a class="page-link" href="categories.php?category_id='. $_GET['category_id'] .'&category_name='. $_GET['category_name'] .'&page='. $prev .'" aria-label="Previous"><span aria-hidden="true">&#xAB;</span></a>
                                                        </li>';
                                            }
                                        ?>
                                        <?php
                                            if(isset($_GET['page'])){
                                                $active = $_GET['page'];
                                            }else {
                                                $active = 1;
                                            }
                                                for ($i = 1; $i <= $total_pager ; $i++) {
                                                    if ($i == $active) {
                                                        echo '<li class="page-item active"><a class="page-link" href="categories.php?category_id='.$_GET['category_id'].'&category_name='.$_GET['category_name'].'&page='. $i .'">' . $i . '</a></li>';
                                                    } else {
                                                        echo '<li class="page-item"><a class="page-link" href="categories.php?category_id='.$_GET['category_id'].'&category_name='.$_GET['category_name'].'&page='. $i .'">' . $i . '</a></li>';
                                                    }
                                                }
                                            ?>

                                            <?php
                                                if(isset($_GET['page'])){
                                                    $next = $_GET['page'] + 1 ;
                                                } else {
                                                    $next = 2;
                                                }

                                                if($next - 1 >= $total_pager){
                                                    echo '<li class="page-item disabled">
                                                            <a class="page-link" href="#!" aria-label="Next">
                                                                <span aria-hidden="true">&#xBB;</span>
                                                            </a>
                                                          </li>';
                                                } else {
                                                    echo '<li class="page-item">
                                                            <a class="page-link" href="categories.php?category_id='.$_GET['category_id'].'&category_name='.$_GET['category_name'].'&page=' . $next . '" aria-label="Next">
                                                                 <span aria-hidden="true">&#xBB;</span>
                                                            </a>
                                                        </li>';
                                                }
                                            ?>

                                        </ul>
                                    </nav>
                                <?php }
                            ?>


                            <h1 class="pt-5">Most viewed posts:</h1>
                            <hr />
                            <div class="row">
                            <?php
                                    $sql2 = "SELECT * FROM posts WHERE post_status = :status AND post_category_id = :id ORDER BY post_views DESC LIMIT 0 , 3";
                                    $stmt = $pdo->prepare($sql2);
                                    $stmt->execute([
                                        ':status' => "published",
                                        ':id'     => $_GET['category_id']
                                    ]);
                                    while($posts = $stmt->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $post_id       = $posts['post_id']       ;
                                        $post_title    = $posts['post_title']    ;
                                        $post_detail   = $posts['post_detail']   ;
                                        $post_category = $posts['post_category_id'] ;
                                        $post_image    = $posts['post_image']    ;
                                        $post_date     = $posts['post_date']     ;
                                        $post_author   = $posts['post_author']   ;
                                        $post_view     = $posts['post_views']    ;
                                        ?>

                                        <div class="col-md-6 col-xl-4 mb-5">
                                            <a class="card post-preview lift h-100" href="single.php?post_id=<?php echo $post_id; ?>"
                                                ><img class="card-img-top" style="height: 250px; width=100%" src="./img/<?php echo $post_image ?>" alt="<?php echo $post_image ?>" />
                                                <div class="card-body">
                                                    <h5 class="card-title"> <?php echo $post_title ?>  </h5>
                                                    <p class="card-text">   <?php echo substr($post_detail , 0 , 140) ?>  </p>
                                                </div>
                                                <div class="card-footer d-flex align-items-center justify-content-between">
                                                    <div class="post-preview-meta">
                                                        <img class="post-preview-meta-img" src="./img/pic.jpg" />
                                                        <div class="post-preview-meta-details">
                                                            <div class="post-preview-meta-details-name"><?php echo $post_author ?></div>
                                                            <div class="post-preview-meta-details-date"><?php echo $post_date ?> </div>
                                                        </div>
                                                    </div>
                                                    <div class="post-preview-meta">
                                                         <?php echo $post_view  ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <?php

                                    }
                                ?>
                            </div>

                        </div>
                        <!--End-->
                        <!--Waves-->
                        <div class="svg-border-waves text-dark">
                            <svg class="wave" style="pointer-events: none" fill="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
                                <defs>
                                    <style>
                                        .a {
                                            fill: none;
                                        }
                                        .b {
                                            clip-path: url(#a);
                                        }
                                        .d {
                                            opacity: 0.5;
                                            isolation: isolate;
                                        }
                                    </style>
                                    <clipPath id="a"><rect class="a" width="1920" height="75" /></clipPath>
                                </defs>
                                <title>wave</title>
                                <g class="b"><path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48" /></g>
                                <g class="b"><path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10" /></g>
                                <g class="b"><path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24" /></g>
                                <g class="b"><path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150" /></g>
                            </svg>
                        </div>
                        <!--End Waves-->

                </main>
            </div>
<?php require_once("./inc/footer.php"); ?>
