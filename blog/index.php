<?php

    // // Define the number of posts per page
    // $posts_per_page = 9;

    // // Get the current page number from the URL, default to 1 if not set
    // $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // // Calculate the OFFSET for the SQL query
    // $offset = ($current_page - 1) * $posts_per_page;

    // // Get the total number of posts
    // $total_posts_query = "SELECT COUNT(*) FROM posts";
    // $total_posts_result = mysqli_query($conn, $total_posts_query);
    // $total_posts = mysqli_fetch_row($total_posts_result)[0];

    // // Calculate the total number of pages
    // $total_pages = ceil($total_posts / $posts_per_page);

    // // Get the posts for the current page
    // $query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT $posts_per_page OFFSET $offset";
    // $posts = mysqli_query($conn, $query);

?>
<?php

    include 'partials/header.php';

    $featured_query = "SELECT * FROM posts WHERE is_featured=1";
    $featured_result = mysqli_query($conn, $featured_query);

    $featured = mysqli_fetch_assoc($featured_result);
    
    $query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
    $posts = mysqli_query($conn, $query);

?>

    <?php if(mysqli_num_rows($featured_result) == 1) : ?>
        <section class="featured">
            <div class="container featured_container">
                <div class="post_thumbnail featured">
                    <img src="./images/<?= $featured['thumbnail'] ?>" alt="">
                </div>
                <div class="post_info">
                    <?php
                        $category_id = $featured['category_id'];
                        $category_query = "SELECT * FROM categories WHERE ID=$category_id";
                        $category_result = mysqli_query($conn, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                    ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?ID=<?= $category['ID'] ?>" class="category_button"><?= $category['title'] ?></a>
                    <h2 class="post_title"><a href="<?= ROOT_URL ?>post.php?ID=<?= $featured['ID'] ?>"><?= $featured['title'] ?></a></h2>
                    <p class="post_body">
                        <?= substr($featured['body'], 0, 300) ?>...
                    </p>
                    <div class="post_author">
                        <?php 
                            $author_id = $featured['author_id'];
                            $author_query = "SELECT * FROM users WHERE ID=$author_id";
                            $author_result = mysqli_query($conn, $author_query);
                            $author = mysqli_fetch_assoc($author_result);
                        ?>
                        <div class="post_author-avatar">
                            <img src="./images/<?= $author['avatar'] ?>" alt="">
                        </div>
                        <div class="post_author-info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small>
                                <?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif ?>

    <section class="posts <?= $featured ? '' : 'section_extra-margin' ?>">
        <div class="container posts_container">
            <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                <article class="post">
                    <div class="post_thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>" alt="">
                    </div>
                    <div class="post_info">
                        <?php
                            $category_id = $post['category_id'];
                            $category_query = "SELECT * FROM categories WHERE ID=$category_id";
                            $category_result = mysqli_query($conn, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <a href="<?= ROOT_URL ?>category-posts.php?ID=<?= $category['ID'] ?>" class="category_button"><?= $category['title'] ?></a>
                        <h3 class="post_title"><a href="<?= ROOT_URL ?>post.php?ID=<?= $post['ID'] ?>"><?= $post['title'] ?></a></h3>
                        <p class="post_body"><?= substr($post['body'], 0, 50) ?>...</p>
                        <div class="post_author">
                            <?php 
                                $author_id = $post['author_id'];
                                $author_query = "SELECT * FROM users WHERE ID=$author_id";
                                $author_result = mysqli_query($conn, $author_query);
                                $author = mysqli_fetch_assoc($author_result);
                            ?>
                            <div class="post_author-avatar">
                                <img src="./images/<?= $author['avatar'] ?>" alt="">
                            </div>
                            <div class="post_author-info">
                                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile ?>
        </div>
    </section>

    <!-- <section class="pagination">
    <div class="container">
        <div class="pagination_links">
            <?php if ($current_page > 1): ?>
                <a href="?page=<?= $current_page - 1 ?>" class="prev_page">Previous</a>
            <?php endif; ?>

            <?php
                // Display page numbers with an offset around the current page
                $start_page = max(1, $current_page - 5); // Start 5 pages before current
                $end_page = min($total_pages, $current_page + 5); // End 5 pages after current

                for ($page = $start_page; $page <= $end_page; $page++) :
                    if ($page == $current_page) :
            ?>
                        <span class="current_page"><?= $page ?></span>
            <?php
                    else :
            ?>
                        <a href="?page=<?= $page ?>" class="page_number"><?= $page ?></a>
            <?php
                    endif;
                endfor;
            ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?= $current_page + 1 ?>" class="next_page">Next</a>
            <?php endif; ?>
        </div>
    </div>
</section> -->

    <section class="category_buttons">
        <div class="container category_buttons-container">
            <?php
                $all_categories_query = "SELECT * FROM categories";
                $all_categories = mysqli_query($conn, $all_categories_query);
            ?>
            <?php while($category = mysqli_fetch_assoc($all_categories)) : ?>
                <a href="<?= ROOT_URL ?>category-posts.php?ID=<?= $category['ID'] ?>" class="category_button"><?= $category['title'] ?></a>
            <?php endwhile ?>
        </div>
    </section>

<?php

    include 'partials/footer.php';

?>