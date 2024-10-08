<?php
    session_start();

    // Load the require PHP classes.
    require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."common.class.php");
    require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."account.class.php");
    require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."blog.class.php");

    $common = new common();
    $account = new account();
    $blog = new blog();

    // Check if the user is logged in.
    if (!$account->isAuthenticated()) {
        // The user is not logged in so forward them to the login page.
        header ("Location: login.php");
    }

    // Get titles and dates for all blog posts.
    $allPosts = $blog->getAllPosts();

    // Pagination.
    $itemsPerPage = 10;
    $page = (isset($_GET['page']) ? $_GET['page'] : 1);
    $posts = $common->paginateArray($allPosts, $page, $itemsPerPage - 1);

    ////////////////
    // BEGIN HTML

    require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."header.inc.php");
?>

            <h1>Blog Management</h1>
            <hr />
            <h2>Blog Posts</h2>
            <a href="/admin/blog/add.php" class="btn btn-info" style="margin-bottom:  10px;" role="button">Add Post</a>
            <div class="table-responsive">
                <table class="table table-striped table-condensed">
                    <tr>
                        <th></th>
                        <th>Title</th>
                        <th>Date</th>
                    </tr>
<?php
    foreach ($posts as $post) {
?>
                    <tr>
                        <td><a href="edit.php?title=<?php echo urlencode($post['title']); ?>">edit</a> <a href="delete.php?title=<?php echo urlencode($post['title']); ?>">delete</a></td>
                        <td><?php echo $post['title']; ?></td>
                        <td>
<?php 
    // Properly format the date and convert to slected time zone.
    $date = new DateTime($post['date'], new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone($common->getSetting('timeZone')));
    echo $date->format($common->getSetting('dateFormat'));
?>
                        </td>
                    </tr>
<?php
    }
?>
                </table>
            </div>
<?php
    $count = 0;
    foreach ($allPosts as $post) {
        $count++;
    }
    $pageLinks = $count / $itemsPerPage;
?>
            <!-- This is a placeholder for pagination which is not implemented at this time. -->
            <ul class="pagination">
<?php
    $i = 1;
    while ($i <= $pageLinks) {
?>
                <li><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
<?php
        $i++;
    }
?>
            </ul>
<?php
    require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."footer.inc.php");
?>
