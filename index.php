<?php 
require 'User.php';
require 'db.php';
require 'imageArray.php';

$user = new User();
$username = $user->getSession();

if($user->getSession()){ 
    
    $stmt2 = $conn->prepare("SELECT * FROM users");     
    $stmt2->execute();
    $result2 = $stmt2->fetchAll();
    $user_id = $user->getCurrentUserId();
    $sql1 = $conn->prepare("SELECT * from users INNER JOIN friends ON (users.id = friends.friended_by)  WHERE friends.friended_to = :user_id");
    $sql1->bindValue(':user_id',$user_id);
    $sql1->execute();
    $result1 = $sql1->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
<title>Chat Application</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="style.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/1e803d693b.js"></script>
<script src="ban.js"></script>
<script src="addFriend.js"></script>
<script src="image.js"></script>



</head>
<body>
    <div class="container">
        <center><h1>Welcome, <?php echo $username; ?>!</h1><a href="logout.php?username=<?php echo $username; ?>">(Logout)</a></center>
        <div class="row">
            <div class="col-md-4 " >
                <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title">Start Chatting</h3>
                </div>
                    <div class="panel-body" style="max-height: 400px; overflow-y: scroll;">
                        <div class="form-group">
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="message" name="message" placeholder="type...">
                                <input type="hidden" id="lastMessageId" value="0">
                                <input type="hidden" id="username" value="<?php echo $username; ?>">
                                <?php foreach ($my_smilies as $key => $value) {
                                    ?>
                                    <img onclick="addImage('<?php echo $key; ?>')" src="images/<?php echo $value; ?>">
                                    <?php
                                }?>
                            </div>
                            <div class="col-md-4">
                                 <button class="btn btn-md btn-success" id="sendMessage" 
                                 name="sendMessage">Send</button>
                            </div><br><br><br>
                            <div id="bodyMessage">
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            <div class="panel panel-default user_panel">
                <div class="panel-heading">
                <h3 class="panel-title">Users</h3>
                </div>
            <div class="panel-body" style="max-height: 400px; overflow-y: scroll;">
                <div class="table-container">
                    <table class="table-users table" border="0">
                        <tbody id="userBody">
                        <?php 
                            foreach ($result2 as $result2) {
                        ?>
                            <tr>
                                <td width="10" align="center">
                                    <i class="fa fa-2x fa-user fw"></i>
                                </td>
                                <td>
                                     <?php echo $result2['username']; ?><br><!-- <small class="text-muted"><?php echo $result2['email']; ?></small> -->
                                </td>
                                <td align="right">
                                     <?php 
                                     $check_id = $result2['id'];
                                     $current_user_id = $user->getCurrentUserId();
                                     $sql = $conn->prepare("SELECT * FROM blocks WHERE block_by = :block_by and block_to = :block_to");
                                     $sql->bindValue(':block_by', $current_user_id);
                                     $sql->bindValue(':block_to', $check_id);
                                    $sql->execute();
                                    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    if (count($result)>0) {
                                        ?>
                                        <button disabled="true" id="friend<?php echo $result2['id']; ?>" name="friend" value="<?php echo $result2['id']; ?>" class="btn btn-md btn-primary" data-toggle="friend" title="Add Friend">
                                        <i class="fa fa-1x fa-user-plus"></i></button>
                                        <button disabled="true" id="block" value="<?php echo $result2['id']; ?>"  class="btn btn-md btn-danger" data-toggle="block" title="Block"><i class="fa fa-1x fa-ban "></i></button>
                                     <button id="unblock" value="<?php echo $result2['id']; ?>"  class="btn btn-md btn-success" data-toggle="unblock" title="unblock"><i class="fa fa-1x fa-unlock-alt "></i></button>
                                        <?php
                                    }else{
                                        ?>
                                        <button id="friend<?php echo $result2['id']; ?>" value="<?php echo $result2['id']; ?>" name="friend" class="btn btn-md btn-primary" data-toggle="friend" title="Add Friend">
                                        <i class="fa fa-1x fa-user-plus"></i></button>
                                        <button id="block" value="<?php echo $result2['id']; ?>"  class="btn btn-md btn-danger" data-toggle="block" title="Block"><i class="fa fa-1x fa-ban "></i></button>
                                     <button disabled="true" id="unblock" value="<?php echo $result2['id']; ?>"  class="btn btn-md btn-success" data-toggle="unblock" title="unblock"><i class="fa fa-1x fa-unlock-alt "></i></button>
                                    <?php
                                    }
                                     ?>
                                    
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            </div>
            <div class="col-md-4" >
                <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title">Friend Requests</h3>
                </div>
                    <div class="panel-body" style="max-height: 400px; overflow-y: scroll;">
                        <div class="table-container">
                    <table class="table-users table" border="0">
                        <tbody id="userBody">
                        <?php 
                        foreach ($result1 as $key) {
                            if($key['isApproved']==false){
                        ?>
                            <tr>
                                <td width="10" align="center">
                                    <i class="fa fa-2x fa-user fw"></i>
                                </td>
                                <td>
                                <?php echo $key['username']; ?>
                                </td>
                                <td align="right">
                                    <a href="acceptRequest.php?id=<?php echo $key['id']; ?>" class="btn btn-md btn-primary" id="acceptRequest">Accept</a>
                                    <a href="declineRequest.php?id=<?php echo $key['id']; ?>" class="btn btn-md btn-danger" id="declineRequest">Decline</a>
                                </td>
                                
                            </tr>

                            <?php }else{ ?>
                           
                                <tr>
                                <td width="10" align="center">
                                    <i class="fa fa-2x fa-user fw"></i>
                                </td>
                                <td>
                                <?php echo $key['username'] ?>
                                </td>
                                <td align="right">
                                    <a href="unfriend.php?id=<?php echo $key['id']; ?>" class="btn btn-md btn-success" id="acceptRequest">Friends</a>
                                </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="ajax.js">

</script>
</html>
<?php
}else{
header('Location: login.html');
}
?>