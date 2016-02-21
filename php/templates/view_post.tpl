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
    {literal}
    <script>
        function delete_post(id){
            // 使用AJAX删除该文章
//            alert("deleting " + id);
            var sure = confirm("Are You Sure To Delete This Post?");
            if (sure == true) {
                $.get("delete_post.php?id=" + id, function (data, status) {
//                    alert(data);
                    var result = JSON.parse(data);
                    if (!("ERROR" in result)){
//                        alert("DELETED!");
                        // 跳转
                        window.location = "index.php";
                    }else{
                        alert("FAILED TO DELETE: " + result["ERROR"]);
                    }
                });
            }
        }
    </script>
    {/literal}
    <title>Post - view page</title>
</head>
<body>
    <div id="myNav">
        {include file="navbar.tpl"}
    </div>

    <div class="container-fluid">
        {include file="post_content.tpl" post=$post}
    </div>
    {*编辑区域*}
    <div id="edit_area" class="col-md-offset-2 col-md-8">
    {if isset($smarty.session["logged"])}
        <div id="edit_buttons" class="pull-right">
            <a class="btn btn-primary" href="addPost.php?id={$post['id']}">
                <span class="glyphicon glyphicon-edit">Edit</span>
            </a>
            <button type="button" class="btn btn-danger" onclick="delete_post({$post['id']})">
                <span class=>Delete</span>
            </button>
        </div>
    {/if}
    </div>
    {*编辑区域*}
</body>
</html>