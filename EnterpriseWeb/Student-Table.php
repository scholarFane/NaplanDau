


<!-- Content -->
 <?php
  if(isset($_GET['submit-student'])){
    include("submit-student.php");
  }else{
 ?>
<div class="content">
  <div class="content-stuff">
    <h2>Student Works:</h2> 
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Student's id</th>
                <th>Picture</th>
                <th>Document</th>
                <th>Term</th>
                <th>Comment</th>
                <th>For publication</th>
            </tr>
        </thead>
        <tbody>
          <?php
            $get_post = "select * from post where user_id = '$id' ";
            $run_post = mysqli_query($conn,$get_post);
            while($row_post = mysqli_fetch_array($run_post)){
              $post_id = $row_post['post_id'];
              $term_id=$row_post['term_id'];
              $student_id = $row_post['user_id'];
              $post_image = $row_post['post_image'];
              $post_file = $row_post['post_file'];
              $post_status = $row_post['selected'];
          ?>
          <tr>
            <td><?php echo $student_id ?></td>
            <td><?php echo "<img src='img/". $post_image . "' height='160' width='160'>" ?></td>
            <td><?php echo "<a href='img/".$post_file." 'target='_blank'>".$post_file."</a>" ?></td>
            <td><?php echo $term_id; ?></td>
            <td> <a href="StudentHome.php?submit-student=<?php echo $post_id; ?>" class="btn btn-outline-dark btn-sm"><i class="fas fa-edit"></i></a></td>
            <td><form id="selected" action="selectedPost.php" method="POST">
                    <input type="hidden" name="postId" value="<?php echo $row_post['post_id'] ?>" />
                    <input type="checkbox" name="checkSelected" v onclick="document.getElementById('selected').submit()"
                      <?php 
                    if($post_status=="1"){
                        echo "checked";
                    }
                    ?>     
                    >Selected
                </form>
                <form id="notselected" action="unselectPost.php" method="POST">
                <input type="hidden" name="postId" value="<?php echo $row_post['post_id'] ?>" />
                <input type="checkbox" name="checkSelected" v onclick="document.getElementById('notselected').submit()"
                         <?php 
                    if($post_status=="0"){
                        echo "checked";
                    }
                    ?>
                >Not selected
                </form>
            </td>
          </tr>
          <?php } ?>
          
        </tbody>
    </table>
  </div>
</div>
  
<?php } ?>
 