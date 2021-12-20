<?php require_once 'assets/core/init.php'; ?>
<style>
  body {
    background: url('resources/bg.jpg') no-repeat;
    background-size: 100%;
  }
</style>
<?php
  if (isset($_POST['login'])) {
    $user_id = sanitize('user_id');
    $password = trim($_POST['password']);
    $hash = hash('sha1', $password);

    if ($user_id == '' || $password == '') {
      $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
      if ($user->login($user_id, $hash)) {
        $session->message("You are now logged In");
        redirectTo('index.php');
      }
    }

  }


?>
<?php include_once 'assets/inc/_head.php';  ?>
  <div class="container">
    <div class="col-md-4 mx-auto mt-4">
      <form class="form-signin mt-4" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
          <div class="text-center mb-4">
            <img class="mb-1" src="assets/images/logo.png" style="font-size: 2em;" alt="Ambulance Dispatch System">
            <h1 class="h3 mb-2 font-weight-normal text-white">ADS - FRSC</h1>
          </div>

          <div class="form-group">
            <input type="text" id="user_id" name="user_id" class="form-control" placeholder="User ID" required autofocus>
          </div>

          <div class="form-group">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
          </div>
          <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Sign in</button>
      </form>
    </div>
  </div>
<?php //include_once 'assets/inc/_footer.php'; ?>
