<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" type="text/css" href="assets/css/main.css">
        <title>Auth Boilerplate</title>
    </head>
    <body>
        <div class="login">
            <form action="" method="POST" class="main-form">
                <div class="header">
                    <img src="assets/images/logo.png" class="logo-img" />
                </div>
                <div class="content">

                    <?php echo (isset($errorMessage) && !empty($errorMessage) ? "<div class=\"form-group\"><div class=\"message failure\">{$errorMessage}</div></div>" : ""); ?>
                    
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Käyttäjänimi">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label>Type your password again</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="do_action" value="register" />
                        <button type="submit" class="primary-button btn-block">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>