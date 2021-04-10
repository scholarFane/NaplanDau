

<?php
                if(isset($_GET['submit-student'])){
                    $post_id = $_GET['submit-student'];
                    $get_post = "select * from post where post_id = '$post_id'";
                    $run_post = mysqli_query($conn, $get_post);
                    $row_post = mysqli_fetch_array($run_post);

                    $p_id = $row_post['post_id'];
                    $p_document = $row_post['post_file'];
                    $p_user = $row_post['user_id'];
                }
                else
                {
                    echo"something wrong";
                } 
            ?>

<body>

    <!-- Right Content -->
    <div class="content">
        <a href="StudentHome.php?Student-Table" class="btn btn-info"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
        <div class="content-stuff">
            <h2>View Your Submission:</h2>
            <a href="" style="font-size: 1.2rem;"><i class="far fa-file-alt"></i> <?php echo $p_document; ?> </a>
            <br>
            <a href="StudentHome.php" class="btn btn-primary my-2"><i class="fas fa-upload"></i> Re-upload
                Submission</a>
            <a href="submit-student.html" class="btn btn-danger my-2 ml-1"><i class="far fa-trash-alt"></i> Delete
                Submission</a>
        </div>
        <hr>
        <!-- Comment Section -->
        <div class="comment-section">
            <h2>Comment Section:</h2>
            <div class="form-group">
                <form method="post">
                <textarea name="comment" class="form-control" placeholder="Leave your comment here..." rows="3"></textarea>
                <button type="submit" value="submit-comment" name="submit-comment" id="submit-comment" class="btn btn-outline-primary my-2"><i class="fa fa-paper-plane"></i>
                    Submit</button>
                </form>
                
                <?php 
                    if(isset($_POST['submit-comment'])){
                        $comment = $_POST['comment'];
                        $comment_new = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $comment);
                        $insert_comment = "insert into comment (`user_id`, `post_id`, `comment_content`, `time`) values ('$id', '$post_id', '$comment_new', CURRENT_TIMESTAMP)";
                        mysqli_query($conn,$insert_comment);
                    }
                ?>
                <div class="card">
                    
                    <div class="card-header">Recent Comments</div>
                    <div class="comment-group">
                    <?php 
                        $get_comment = "select * from comment where post_id = '$post_id' ";
                        $run_comment = mysqli_query($conn,$get_comment);
                        while($row_comment = mysqli_fetch_array($run_comment)){
                          $user_id = $row_comment['user_id'];
                          $get_user = "select * from user where user_id = '$user_id'";
                          $run_user = mysqli_query($conn,$get_user);
                          $row_user = mysqli_fetch_array($run_user);
                          $user_name = $row_user['username'];
                          $user_role = $row_user['user_role'];
                          $comment = $row_comment['comment_content'];
                    ?>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1"><img src="http://placehold.it/80" class="rounded-circle img-fluid"
                                    alt="" /></div>
                            <div class="col-11">
                                <div class="font-weight-bold cmt-header"><?php echo $user_role, " : ", $user_name ?></div>
                                <div><?php echo $comment ?></div>
                            </div>

                        </div>
                    </div>
                    </div>
                <?php } ?>
                </div>

                    
                    
                </div>
            </div>
        </div>

</div>
</div>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>

