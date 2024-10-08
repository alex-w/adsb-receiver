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

    $titleExists = FALSE;
    if ($common->postBack()) {
        // Check if title already exists.
        $titleExists = $blog->titleExists($_POST['title']);

        if (!$titleExists) {
            // Update the contents of the blog post.
            $blog->addPost($_SESSION['login'], $_POST['title'], $_POST['contents']);

            // Forward the user to the blog management index page.
            header ("Location: /admin/blog/");
        }
    }

    ////////////////
    // BEGIN HTML

    require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."header.inc.php");
?>
            <h1>Blog Management</h1>
            <hr />
            <h2>Add Blog Post</h2>
            <form id="add-blog-post" method="post" action="add.php">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control"<?php echo (isset($_POST['title']) ? ' value="'.$_POST['title'].'"' : '')?> required>
<?php
    if ($titleExists) {
?>
                    <div class="alert alert-danger" role="alert" id="failure-alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Title already exists.
                    </div>
<?php
    }
?>
                </div>
                <div class="form-group">
                    <textarea id="contents" name="contents"><?php echo (isset($_POST['contents']) ? $_POST['contents'] : '')?></textarea>
                </div>
                <input type="submit" class="btn btn-default" value="Publish">
            </form>
            <script src='https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js'></script>
            <script>
                ClassicEditor
                    .create( document.querySelector( '#contents' ) )
                    .catch( error => {
                        console.error( error );
                    } );
            </script>
            <style>
                .ck-editor__editable_inline {
                min-height: 350px;
            }
<?php
    require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."footer.inc.php");
?>
