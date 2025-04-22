<div class="container wow fadeInDown" style=" height:500px;">
    <div class="col-md-12" style="border: solid #D9D9D9 1px; padding: 10px; padding-top: 5px; box-shadow: #9F9F9F 2px 3px 5px; margin-top: 10px;">
        <div class="panel panel-success">
            <div class="panel-heading panel-title" >
                <span style="font-weight:bold; font-family:verdana;"><i class="glyphicon glyphicon-cog"></i> Product </span>
            </div>
            <div class="panel-body" style="background-color:#fff;">

 			
            <div class="col-lg-3">
            <em style="color:red;">Note: Fields with (*) are required</em></div>
            <div class="col-lg-6">
            	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                	<table>
                    	<tr>
                        	<td style="text-align:right; font-weight:bold;">Product name* : &emsp;</td>
                            <td style="text-align:center;">&emsp; <textarea class="form-control" name="cnpname" required></textarea></td>
                        </tr>
                        <tr>
                        	<td style="text-align:right; font-weight:bold;">Sex* : &emsp;</td>
                            <td style="text-align:center;">&emsp; <select name="sex" class="form-control">
                            					<option></option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                            </select></td>
                        </tr>
                        <td style="text-align:right; font-weight:bold;">Date Of Birth* : &emsp;</td>
    <td style="text-align:center;">&emsp; 
        <input type="date" class="form-control" name="dob" required>
    </td>
</tr>
                        <tr>
                        	<td style="text-align:right; font-weight:bold;">Sire* : &emsp;</td>
                            <td style="text-align:center;">&emsp; <select name="sire" class="form-control">
                                
                                					<option></option>
                                                <option>Simba</option>
                                                <option>Tursker</option>
                                                <option>Tiger</option>
                            				
                                                
                            </select></td>
                        </tr>
                        <tr>
                        	<td style="text-align:right; font-weight:bold;">Bitch* : &emsp;</td>
                            <td style="text-align:center;">&emsp; <select name="bitch" class="form-control">
                                                   <option></option>
                                                   <option>Juno</option>
                                                   <option>Nice</option>
                                                   <option>Betty</option>
                                                
                            </select></td>
                        </tr>
                        <tr>
                        	<td style="text-align:right;font-weight:bold;">Amount(KSH.)* : &emsp;</td>
                            <td style="text-align:center;">&emsp; <input type="number" step="any" class="form-control" name="prize" placeholder="0.00" required /></td>
                        </tr>
                        <tr>
                        	<td style="text-align:right;font-weight:bold;">Description* : &emsp;</td>
                            <td style="text-align:center;">&emsp; <textarea class="form-control" name="des" required></textarea></td>
                        </tr>
                         <tr>
                        	<td style="text-align:right;font-weight:bold;">Image* : &emsp;</td>
                            <td style="text-align:center;">&emsp; <input type="file" name="image" required /></td>
                        </tr>
                         <tr>
                        	<td style="text-align:right;font-weight:bold;">Status* : &emsp;</td>
                            <td style="text-align:center;">&emsp; <select name="stat" class="form-control">
                            					<option></option>
                                                <option value="available">Available</option>
                                                <option value="Homed">Homed</option>
                                                <option value="Our-dog">Our-Dog</option>
                            </select></td>
                        </tr>
                         <tr style="margin-top:20px;">
                        	<td style="text-align:right;font-weight:bold;" colspan="2"><br /><p></p>
                            <button class="btn btn-default" type="clear">Clear</button>
                            <button class="btn btn-success" type="submit" name="save">Save</button></td>
                            
                        </tr>
                    
                    </table>
                </form>
            </div>
            <div class="col-lg-3"></div>

            </div>
        </div>
    </div>
</div>
<?php 
// Include database connection
include('includes/dbconn.php');
if(isset($_POST['save'])){
    $name = $_POST['cnpname'];
    $sex = $_POST['sex'];
    $dob = $_POST['dob'];
    // $age = $_POST['age'];
    $sire = $_POST['sire'];
    $bitch = $_POST['bitch'];
    $prize = $_POST['prize'];
    $des = $_POST['des'];
    $stat = $_POST['stat'];
    
    // Image handling
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $image_name = addslashes($_FILES['image']['name']);
    $image_size = getimagesize($_FILES['image']['tmp_name']);
    move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $_FILES["image"]["name"]);
    $location = "images/" . $_FILES["image"]["name"];

    if(empty($name) || empty($sex) || empty($dob) || empty($prize) || empty($des) || empty($stat)){
        echo '<script>alert("Fields must not be empty.");
        window.location.href="addcnp.php";
        </script>';
    } else {
        $sql = "INSERT INTO tblcnp (name, sex, dob, sire, bitch, prize, description, image, status, voided) 
                VALUES ('$name', '$sex', '$dob', '$sire', '$bitch', '$prize', '$des', '$location', '$stat', 0)";
        $result = mysqli_query($con, $sql);
        if($result == true){
            echo '<script>alert("Save Successfully!");
            window.location.href="addcnp.php";</script>';
        } else {
            echo '<script>alert("Sorry, unable to process your request!");
            window.location.href="addcnp.php";</script>';
        }
    }
}
?>