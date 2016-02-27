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
    <link rel="stylesheet" href="/lib/highlight/styles/agate.css">
    <script src="/lib/highlight/highlight.pack.js"></script>
    {*语法高亮*}
    <script src="/js/loadHighlightJS.js"></script>
    {*发送删除文章的请求*}
    <script src="/js/deletePost.js"></script>
    <title>xiaofud - View Post</title>
</head>
<body>
    <div id="myNav">
        {include file="navbar.tpl"}
    </div>

    <div class="container-fluid">
        {include file="post_content.tpl" post=$post}

        {*编辑区域*}
        <div id="edit_area" class="col-md-offset-2 col-md-8">
        {if isset($smarty.session["logged"])}
            <div id="edit_buttons" class="pull-right">
                <a class="btn btn-primary" href="/php/admin/addPost.php?id={$post['id']}">
                    <span class="glyphicon glyphicon-edit">Edit</span>
                </a>
                <button type="button" class="btn btn-danger" onclick="delete_post({$post['id']})">
                    <span class=>Delete</span>
                </button>
            </div>
        {/if}
        </div>
        {*编辑区域*}
    </div>
</body>
</html>