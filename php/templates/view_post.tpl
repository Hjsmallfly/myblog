<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../lib/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
    <script src="../lib/jquery-2.2.0.min.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>-->
    <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
    <script src="../lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <title>Post - view page</title>
</head>
<body>
    <div id="myNav">
        {include file="navbar.tpl"}
    </div>

    <div class="container-fluid">
        {include file="post_content.tpl" post=$post}
    </div>
</body>
</html>