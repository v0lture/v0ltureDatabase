<?php

    // Working directory of first executing file
    $cwd = dirname(__FILE__);

    require_once $cwd."/assets/php/session.php";
    $error = "";

    if(isset($_GET["confirm"])) {
        $confirm = $_GET["confirm"];
    } else {
        $confirm = "login";
    }

    if($confirm == "reauth") {
        $error = '<div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>You have to reauthenticate in order to continue.</strong> The credentials that were saved in your session are invalid.
                  </div>';
    }

    if(isset($_POST["auth_username"]) && isset($_POST["auth_password"]) && isset($_POST["auth_host"])) {
        $u = $_POST["auth_username"];
        $p = $_POST["auth_password"];
        $h = $_POST["auth_host"];
        if($u == "" || $p == "" || $h == "") {
            $error = '<div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Fields cannot be blank.</strong> Check all of the fields and try submitting again.
                      </div>';
        } else {
            $db = connectDB($u, $p, $h);

            if($db != "true") {
                $error = '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Failed to connect to database</strong> <br />Check your credentials for any typos or capitalization errors.<br />'.$db.'
                      </div>';
            } 

        }
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <title>v0ltureDB</title>
        <meta charset="UTF-8">

        <!-- Bootstrap Rscs -->
        <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet">
        <script src="assets/bootstrap/jquery-2.2.4.min.js"></script>
        <script src="assets/bootstrap/bootstrap.min.js"></script>

    </head>

    <body>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="auth.php">v0ltureDB</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="https://github.com/v0lture/v0ltureDB">GitHub</a></li>
                        <li><a href="info.php">v1.0</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">

                <div class="col-md-6 col-md-offset-3" style="padding-top: 40px;">

                    <?php echo $error; ?>

                    <?php if($confirm == "login" || $confirm == "reauth"): ?>
                        <div class="panel panel-primary">

                            <div class="panel-heading">
                                <h3 class="panel-title">Login to a database</h3>
                            </div>

                            <div class="panel-body">

                                <form class="form-horizontal" method="POST" action="auth.php">

                                    <fieldset>

                                        <div class="form-group">

                                            <label for="auth_username" class="col-lg-2 control-label" value="<?php echo $_SESSION["username"]; ?>">Username</label>
                                            
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" name="auth_username" id="auth_username" placeholder="" required>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label for="auth_password" class="col-lg-2 control-label">Password</label>
                                            
                                            <div class="col-lg-10">
                                                <input type="password" class="form-control" name="auth_password" id="auth_password" placeholder="" required>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label for="auth_host" class="col-lg-2 control-label" value="<?php echo $_SESSION["host"]; ?>">Host</label>
                                            
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" name="auth_host" id="auth_host" placeholder="localhost" required>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-lg-10 col-lg-offset-2">
                                            
                                                <button type="submit" class="btn btn-primary">Log In</button>
                                            
                                            </div>
                                        
                                        </div>

                                    </fieldset>

                                </form>

                            </div>

                        </div>

                    <?php elseif($confirm == "switch_user"): ?>
                        <div class="panel panel-success">

                            <div class="panel-heading">
                                <h3 class="panel-title">Switching users</h3>
                            </div>

                            <div class="panel-body">

                                <form class="form-horizontal" method="POST" action="auth.php">

                                    <fieldset>
                                        <legend>Relogin as:</legend>
                                        <div class="form-group">

                                            <label for="switch_username" class="col-lg-2 control-label">Username</label>
                                            
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" name="switch_username" id="switch_username" placeholder="" required>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label for="switch_password" class="col-lg-2 control-label">Password</label>
                                            
                                            <div class="col-lg-10">
                                                <input type="password" class="form-control" name="switch_password" id="switch_password" placeholder="" required>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-lg-10 col-lg-offset-2">

                                                <a href="auth.php?confirm=logout" class="btn btn-default">Log Out</a>
                                                <button type="submit" class="btn btn-success">Switch</button>
                                            
                                            </div>
                                        
                                        </div>

                                    </fieldset>

                                </form>

                            </div>

                        </div>

                    <?php elseif($confirm == "switch_host"): ?>
                        <div class="panel panel-success">

                            <div class="panel-heading">
                                <h3 class="panel-title">Switching hosts</h3>
                            </div>

                            <div class="panel-body">

                                <form class="form-horizontal" method="POST" action="auth.php">

                                    <fieldset>
                                        <legend>Relogin at:</legend>
                                        <div class="form-group">

                                            <label for="switch_host" class="col-lg-2 control-label">Host</label>
                                            
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" name="switch_host" id="switch_host" placeholder="" required>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="col-lg-10 col-lg-offset-2">

                                                <a href="auth.php?confirm=logout" class="btn btn-default">Log Out</a>
                                                <button type="submit" class="btn btn-success">Switch</button>
                                            
                                            </div>
                                        
                                        </div>

                                    </fieldset>

                                </form>

                            </div>

                        </div>
                    <?php elseif($confirm == "logout"): ?>
                        <div class="panel panel-danger">

                            <div class="panel-heading">
                                <h3 class="panel-title">Confirm log out</h3>
                            </div>

                            <div class="panel-body">

                                <form class="form-horizontal" method="POST" action="auth.php">

                                    <fieldset>
                                        <legend>Are you sure you want to log out?<br /><small>You will not be able to modify the database until you log back in.</small></legend>

                                        <div class="form-group">
                                            
                                            <div class="col-lg-10 col-lg-offset-2">

                                                <a href="index.php" class="btn btn-default">Cancel</a>
                                                <button name="confirm_logout" value="true" type="submit" class="btn btn-danger">Log Out</button>
                                            
                                            </div>
                                        
                                        </div>

                                    </fieldset>

                                </form>

                            </div>

                        </div>
                        <?php endif; ?>

                </div>

            </div>
        </div>

    </body>
</html>