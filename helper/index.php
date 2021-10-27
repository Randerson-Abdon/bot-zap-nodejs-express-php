<?php
include_once('function.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Activator</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.8.2/css/bulma.min.css" crossorigin="anonymous"/>
    <style type="text/css">
      body, html {
        background: #F4F5F7;
      }
    </style>
  </head>
  <body>
    <div class="container" style="padding-top: 20px;"> 
      <div class="section">
        <div class="columns is-centered">
          <div class="column is-two-fifths">
            <center>
              <h1 class="title" style="padding-top: 20px">WA-BOT Activator</h1><br>
            </center>
            <div class="box">
             <?php
              if (!empty(validate())) {redirect("../auth/login.php"); exit;}
              $license = null;
              if(!empty($_POST['license'])){
                $license = strip_tags(trim($_POST["license"]));
                $response = activate($license);
                if(empty($response['success'])){ 
                  $msg = 'Activation Failed! Invalid License Code!<br><br>Please login to <a href="https://visimisi.net/my-account" target="_blank" rel="noopener noreferrer">MY ACCOUNT</a><br><br>Click on LICENSE KEYS.<br>If activation limit reached, click Deactivate button,<br>then Activate on this server!'; ?>
                  <form action="index.php" method="POST">
                    <div class="notification is-danger is-light"><?php echo ucfirst($msg); ?></div>
                    <div class="field">
                      <label class="label">License code</label>
                      <div class="control">
                        <input class="input" type="text" placeholder="Enter your purchase/license code" name="license" required>
                      </div>
                    </div>
                    <div style='text-align: right;'>
                      <button type="submit" class="button is-link is-rounded">Activate</button>
                    </div>
                  </form><?php
                }else{
                  $msg = 'Activation Success!<br><br>Please wait, getting things ready...<br><br><a href="../auth/login.php">click HERE</a> if it is not redirecting after 5 seconds'; ?>
                  <div class="notification is-success is-light"><?php echo ucfirst($msg); ?></div>
                  <script>setTimeout(function () {window.location.href = "../auth/login.php";}, 4000);</script>
          <?php }
              }else{ ?>
                <form action="index.php" method="POST">
                  <div class="field">
                    <label class="label">License code</label>
                    <div class="control">
                      <input class="input" type="text" placeholder="Enter your purchase/license code" name="license" required>
                    </div>
                  </div>
                  <div style='text-align: right;'>
                    <button type="submit" class="button is-link is-rounded">Activate</button>
                  </div>
                </form><?php 
              } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="content has-text-centered">
      <p>Copyright <?php echo date('Y'); ?> Arrocy, All rights reserved.</p><br>
    </div>
  </body>
</html>