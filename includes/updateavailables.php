<div class="col-md-12" style="background-color:#fff; border: solid #D9D9D9 1px; padding: 10px; padding-top: 5px; box-shadow: #9F9F9F 2px 3px 5px; margin-top: 10px; height:700px;">
    <div class="panel panel-primary">
        <div class="panel-heading panel-title text-center wow fadeInDown">
            <span style="font-weight:bold; font-family:verdana;">
                <i class="glyphicon glyphicon-list-alt"></i> Product List
            </span>
        </div>
        <div class="panel-body" style="background-color:#fff;">
            <!--   Basic Table  -->
            <table class="table table-responsive table-hover table-bordered table-condensed table-striped wow fadeInDown" width="100%">
                <thead>
                    <tr style="background-color:#000; color:#FFF;">
                        <td style="text-align:center;">NAME</td>
                        <td style="text-align:center;">DESCRIPTION</td>
                        <td style="text-align:center;">PRIZE</td>
                        <td style="text-align:center;">STATUS</td>
                        <td style="text-align:center;">ROLE</td>
                        <td style="text-align:center;">IMAGE</td>
                        <td style="text-align:center;">VIDEO</td>
                        <td style="text-align:center;">ACTION</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('includes/dbconn.php');
                    $sql = "SELECT * FROM tblcnp  ORDER BY id DESC";
                    $result = mysqli_query($con, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];
                            $des = $row['description'];
                            $prize = $row['prize'];
                            $stat = $row['status'];
                            $role = $row['role'];
                            $image = $row['image'];
                            $video = $row['video'];
                    ?>
                            <tr style="font-size:16px; cursor:pointer;">
                                <td class="wow fadeInDown">
                                    <center><strong><?php echo $name; ?></strong></center>
                                </td>
                                <td class="wow fadeInDown">
                                    <center><strong><?php echo $des; ?></strong></center>
                                </td>
                                <td class="wow fadeInDown">
                                    <center><strong><?php echo 'P' . $prize; ?></strong></center>
                                </td>
                                <td class="wow fadeInDown">
                                    <center><strong><?php echo $stat; ?></strong></center>
                                </td>
                                <td class="wow fadeInDown">
                                    <center><strong><?php echo $role; ?></strong></center>
                                </td>
                                <td class="wow fadeInDown">
                                    <center>
                                        <?php if (!empty($image)) { ?>
                                            <img src="<?php echo $image; ?>" width="150px;" height="200px;" class="img-responsive img-rounded" />
                                        <?php } else { ?>
                                            <em>No image</em>
                                        <?php } ?>
                                    </center>
                                </td>
                                <td class="wow fadeInDown">
                                    <center>
                                        <?php if (!empty($video)) { ?>
                                            <video width="300" height="200" controls>
                                                <source src="<?php echo $video; ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php } else { ?>
                                            <em>No video</em>
                                        <?php } ?>
                                    </center>
                                </td>
                                <td class="wow fadeInDown">
                                    <center>
                                        <a href="#updateModal<?php echo $id; ?>" data-toggle="modal" data-target="#updateModal<?php echo $id; ?>" class="btn btn-default">Update</a> |
                                        <a href="#deleteModal<?php echo $id; ?>" data-toggle="modal" data-target="#deleteModal<?php echo $id; ?>" class="btn btn-danger">Delete</a>
                                    </center>
                                </td>
                            </tr>
                            <?php include('updateModal.php'); ?>
                            <?php include('deleteModal.php'); ?>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <!-- End Basic Table -->
        </div>
    </div>
</div>
