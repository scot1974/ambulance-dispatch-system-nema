<?php require_once 'assets/core/init.php'; ?>
<?php
// $user->logout();
    if (!loggedIn()) {
        redirectTo('login.php');
    }
    if (!isAdmin()) {
        redirectTo('index.php');
    }

    if (isset($_POST['addDispatcher'])) {
        $userId = sanitize('userid');
        $password = trim($_POST['password']);
        $confirm = trim($_POST['confirm']);
        $name = ucwords(sanitize('name'), ' ');

        if ($userId == '' || $password == '' || $confirm == '' || $name == '') {
            $errors[] = "All fields are required.";
        }

        if ($password != $confirm) {
            $errors[] = "Password confirmation failed";
        }

        if (empty($errors)) {
            if ($profile->createProfile($name)) {
                $profileId = (int)$profile->id;
                $usergroup = 321;
                $password = hash('sha1', $password);
                if ($system->addDispatcher($userId, $password, $usergroup, $profileId)) {
                    $session->message("Created Successfully");
                    redirectTo('dispatch.php');
                }
            }
        }
    }


?>
<?php include_once 'assets/inc/_head.php';  ?>
<?php include_once 'assets/inc/_admin_nav.php'; ?>
<style scope="dispatch.php">

</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h4 class="mt-2 text-center">Dispatchers Management</h4>
            <?php echo success($session->message); ?>
            <div class="card">
                <div class="card-header">
                    <button id="cancelBtn" class="btn btn-sm btn-danger">cancel</button>
                    <button class="btn btn-sm btn-outline-success pull-right" onclick="addDispatcher()">Add Dispatcher</button>
                </div>
                <table class="table" id="dispatchTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Date Joined</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $n = 1; foreach ($system->getDispatchers() as $dist) : ?>
                            <tr>
                                <td scope="row"><?=$n++;?></td>
                                <td><?=$dist['user_id'];?></td>
                                <td><?=$profile->getName($dist['profileid'])['name'];?></td>
                                <td><?=datetime_to_text($dist['created_at']);?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div id="addDispatcher" class="col-md-8 mx-auto">
                    <h4 class="text-success mt-2 mb-2 text-uppercase text-center">Add Dispatcher</h4>
                    <?php echo error($errors); ?>
                    <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
                        <div class="form-group">
                            <label for="userid">User ID: </label>
                            <input type="text" class="form-control form-control-sm" id="userid" name="userid">
                        </div>
                        <div class="form-group">
                            <label for="password">Password: </label>
                            <input type="password" name="password" id="password" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="confirm">Confirm Password: </label>
                            <input type="password" name="confirm" id="confirm" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="name">Full Name: </label>
                            <input type="text" id="name" name="name" class="form-control form-control-sm">
                        </div>
                        <button type="submit" name="addDispatcher" class="btn btn-outline-primary pull-right mb-2">Save <i class="fas fa-save"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#addDispatcher").hide();
        $("#cancelBtn").hide();
    });
    function addDispatcher() {
        $("#dispatchTable").hide();
        $("#addDispatcher").show();
        $("#cancelBtn").show();
    }
    $("#cancelBtn").on('click', function () {
        $("#dispatchTable").show();
        $("#addDispatcher").hide();
        $("#cancelBtn").hide();
    });
</script>
