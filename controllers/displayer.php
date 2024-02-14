<?php

function displaySideBarChannelButtons($isCreator)
{

   if ($isCreator == 1) {
      echo '<li class="nav-item">
                <a class="nav-link" href="single-channel.php">
                 <i class="fas fa-fw fa-user-alt"></i>
                 <span>Your channel</span>
                </a>
             </li> 
             <li class="nav-item">
                <a class="nav-link" href="upload-video.php">
                   <i class="fas fa-fw fa-cloud-upload-alt"></i>
                   <span>Upload Video</span>
                 </a>
             </li>';
   } else {
      echo '<li class="nav-item">
          <a class="nav-link" href="create-channel.php">
             <i class="fas fa-fw fa-video"></i>
             <span>Create a channel</span>
          </a>
       </li>';
   }
}





function displayNavBarUploadButton($isCreator)
{

   if ($isCreator == 1) {

      echo '<li class="nav-item mx-1">
        <a class="nav-link" href="upload-video.php">
         <i class="fas fa-plus-circle fa-fw"></i>
           Upload Video
        </a>
     </li>';
   }
}






function displayVideos($query)
{
   while ($row = mysqli_fetch_assoc($query)) {
      $name = $row['name'];
      $location = $row['location'];
      $videoID = $row['videoID'];
      echo "
           
              <form  action='' method='get'>
                    <input  type='number' value='$videoID'  name='videoIndex'   style='display: none;'>
                       
                    <a href='video-page.php?videoIndex=" . $videoID . "'><video class='img-fluid' style='height:200px; width: 350px;padding-right:10px;' src='" . $location . "'
                       ></video></a><br>
                       <a style='text-decoration: none; color: black;' href='video-page.php?videoIndex=" . $videoID . "'><p  style='display:inline;'>" . $name . "</p></a>


              </form>
        ";
   }
}





function displayPlaylists($user_ID, $con)
{

   $fetchPlaylist = mysqli_query($con, "SELECT * FROM playlist WHERE userID='$user_ID' ORDER BY playlistID ASC ");

   while ($row = mysqli_fetch_assoc($fetchPlaylist)) {
      $title = $row['title'];
      $playlistID = $row['playlistID'];

      $fetchVideos = mysqli_query($con, "SELECT * FROM playlistvideoids where playlistID =  $playlistID");
      $row1 = mysqli_fetch_assoc($fetchVideos);
      $videoID = $row1['videoID'];
      echo '<div class="col-xl-3 col-sm-6 mb-3">
      <div class="channels-card">
         <div class="channels-card-image">
            <form action="" method="get">
               <input  type="number" value="' . $playlistID . '"  name="playlistIndex"   style="display: none;">
               <a href="#"><i class="fa fa-fast-forward fa-3x" aria-hidden="true"></i></a>
               <div class="channels-card-image-btn"><button type="submit" name="playlistGetter" class="btn btn-info btn-sm border-none">Add video
            </form>
            <form action="" method="get">
               <input  type="number" value="' . $playlistID . '"  name="playlistIndex"   style="display: none;">
               <button type="submit" name="playlistGetterRemove" class="btn btn-warning btn-sm border-none">Remove video
            </form>
         </div>
               
               <input  type="number" value="' . $playlistID . '"  name="playlistIndex"   style="display: none;">
               <div class="channels-card-image-btn">
               <a style="text-decoration:none; color:black;" href="video-pageForplaylist.php?playlistIndex=' . $playlistID . '&&videoID=' . $videoID . '"><button type="button" name="playlistGetterWathc" class="btn btn-primary btn-sm border-none">Watch</a>
               </div>
            
            </div>
         <div class="channels-card-body">
            <div class="channels-title">
               <a href="#">' . $title . '</a>
            </div>
         </div>
         <form action="" method="get">
         <input  type="number" value="' . $playlistID . '"  name="playlistIndex"   style="display: none;">
         <div class="channels-card-image-btn">
         <button name="removePlaylist" type="submit" class="btn btn-secondary btn-sm border-none">Delete playlist
         </div>
         
         </div>
      </form>
   </div>';
   }
}




function displayPlaylistAddVideos($query, $playlistIndex, $con)
{

   while ($row = mysqli_fetch_assoc($query)) {
      $name = $row['name'];
      $location = $row['location'];
      $videoID = $row['videoID'];

      $result = mysqli_query($con, "SELECT * FROM playlistvideoids WHERE playlistID='$playlistIndex' AND videoID='$videoID'");
      if (!$result->num_rows > 0) {

         echo "
                              
                                 <form  action='' method='get'>
                                       <input  type='number' value='$videoID'  name='videoIndex'   style='display: none;'>
                                          
                                          <video class='img-fluid' style='height:200px; width: 350px;padding-right:10px;' src='" . $location . "'
                                          ></video><br>
                                          <p>" . $name . "</p>
                                          <input class='btn btn-primary border-none'type='submit' name='videoGetter' value='add' >
                                 </form>
                           ";
      }
   }
}



function displayPlaylistRemoveVideos($query, $playlistIndex, $con)
{
   while ($row = mysqli_fetch_assoc($query)) {
      $name = $row['name'];
      $location = $row['location'];
      $videoID = $row['videoID'];

      $result = mysqli_query($con, "SELECT * FROM playlistvideoids WHERE playlistID='$playlistIndex' AND videoID='$videoID'");
      if ($result->num_rows > 0) {

         echo "
                              
                                 <form  action='' method='get'>
                                       <input  type='number' value='$videoID'  name='videoIndex'   style='display: none;'>
                                          
                                          <video class='img-fluid' style='height:200px; width: 350px;padding-right:10px;' src='" . $location . "'
                                          ></video><br>
                                          <p>" . $name . "</p>
                                          <input class='btn btn-primary border-none' ' type='submit' name='videoGetter' value='Remove' >
                                 </form>
                           ";
      }
   }
}

function displayChannelAbout($query)
{

   $row = mysqli_fetch_assoc($query);
   $about = $row['about'];

   echo '<div style="color: black; font-size:medium;">' . $about . '</div>';
}
