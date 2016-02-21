<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/lib/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
    <script src="/lib/jquery-2.2.0.min.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>-->
    <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
    <script src="/lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

    {literal}
        <script>
            $(function () {
                $("#username").focus();
            })
        </script>
    {/literal}

    <title>Login</title>
</head>
<body>
    <!-- 导航栏不要放到 container 里面去 -->
    <!-- 导航栏 -->
    {include file="navbar.tpl"}
    <!-- 导航栏 -->
    <div class="container-fluid">
        <div class="row" style="margin-top: 9%; margin-bottom: 40%">
            <div class="col-md-offset-5 col-md-2">
                {if isset($smarty.session["failed"])}
                    <div class="alert alert-warning fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p>login failed</p>
                    </div>
                {/if}

                <form action="/php/admin/login.php" method="POST" role="form">
                    <div class="form-group form-group-sm">
                        <label for="username" class="sr-only">Username</label>
                        <input required placeholder="username" id="username" name="username" type="text" class="form-control">
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="password" class="sr-only">Password</label>
                        <input required placeholder="password" id="password" name="password" type="password" class="form-control">
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="submit" class="sr-only">Login</label>
                        <input  value="Login" name="submit" id="submit" type="submit" class="btn btn-primary form-control">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            {*leave blank*}
        </div>
    </div>
</body>
</html>
