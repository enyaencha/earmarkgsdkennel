<!-- Modal -->
<div class="modal fade" id="updateModal<?php echo $id;?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> UPDATE ITEM</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form id="updateForm<?php echo $id;?>" enctype="multipart/form-data">
        <div class="modal-body">

          <input type="hidden" name="fdid" value="<?php echo $id; ?>">

          <div class="form-group">
            <label>Name*</label>
            <textarea name="name" class="form-control" required><?php echo $name; ?></textarea>
          </div>

          <div class="form-group">
            <label>Description*</label>
            <textarea name="des" class="form-control" required><?php echo $des; ?></textarea>
          </div>

          <div class="form-group">
            <label>Amount*</label>
            <input type="number" name="prize" class="form-control" value="<?php echo $prize; ?>" required>
          </div>

          <div class="form-group">
            <label>Status*</label>
            <select name="stat" class="form-control" required>
              <option value="<?php echo $stat; ?>"><?php echo $stat; ?></option>
              <option value="Available">Available</option>
              <option value="Homed">Homed</option>
              <option value="dead">Dead</option>
              <option value="stud">Stud</option>
              <option value="on-offer">On-offer</option>
              <option value="Pending">Our-dog</option>
            </select>
          </div>

          <div class="form-group">
            <label>Role*</label>
            <select name="role" class="form-control" required>
              <option value="<?php echo $role; ?>"><?php echo ucfirst($role); ?></option>
              <option value="stud">Stud</option>
              <option value="bitch">Bitch</option>
              <option value="puppy">Puppy</option>
              <option value="Senior-dog">Senior-dog</option>
              <option value="For-sale">For-sale</option>
            </select>
          </div>

          <div class="form-group">
            <label>Image</label><br>
            <?php if (!empty($image)) { ?>
              <img src="<?php echo $image; ?>" width="120px" class="img-thumbnail mb-2"><br>
            <?php } ?>
            <input type="file" name="image" class="form-control">
          </div>

          <div class="form-group">
            <label>Video</label><br>
            <?php
              $videoPath = "video/$id.mp4"; // or $video if full path is stored
              if (file_exists($videoPath)) {
                  echo "<video width='100%' controls><source src='$videoPath' type='video/mp4'>Your browser does not support video.</video><br>";
              }
            ?>
            <input type="file" name="video" class="form-control">
          </div>

          <!-- Progress Bar -->
          <div class="form-group">
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width:0%">0%</div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-info">Save changes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- AJAX Script -->
<script>
document.getElementById('updateForm<?php echo $id;?>').addEventListener('submit', function(e) {
  e.preventDefault();

  var form = this;
  var formData = new FormData(form);
  var xhr = new XMLHttpRequest();

  xhr.open('POST', 'update_item_handler.php', true);

  xhr.upload.onprogress = function(e) {
    if (e.lengthComputable) {
      var percent = Math.round((e.loaded / e.total) * 100);
      var bar = form.querySelector('.progress-bar');
      bar.style.width = percent + '%';
      bar.innerText = percent + '%';
    }
  };

  xhr.onload = function () {
    if (xhr.status === 200) {
      alert('Item updated successfully!');
      window.location.reload();
    } else {
      alert('Upload failed.');
    }
  };

  xhr.send(formData);
});
</script>
