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
    <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>

    {*You should enclose your JS code using the {literal}{/literal} tag if you haven't.
    This prevents Smarty from parsing what's in between
    so that the JS code is not being mistaken for PHP code.*}
    {literal}
        <script type="text/javascript">
            tinyMCE.init({
                fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                selector: '#content',
                theme: 'modern',
                width: "100%",
                height: 260,
                init_instance_callback: "setContentCallback",   // 设置回调函数，它会传这个instance作为参数
                                                                //
                plugins: [
                    'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                    'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                    'save table contextmenu directionality emoticons template paste textcolor'
                ],
                style_formats : [
                    {title : 'pre prettyprint linenums', block : 'pre', classes: "prettyprint linenums"},
                    {title : 'pre prettyprint', block : 'pre', classes: "prettyprint"},
                    {title : 'code prettyprint linenums', block : 'code', classes: "prettyprint linenums"},
                    {title : 'code prettyprint', block : 'code', classes: "prettyprint"},
                ],
                style_formats_merge: true, // won't override default style_formats
                content_css: 'css/content.css',
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons | sizeselect | bold italic | fontselect |  fontsizeselect'
            });
        </script>
    {/literal}

    {*一些初始化操作*}
    {literal}
        <script>
            $(function () {
                $("#title").focus();
            });
        </script>
    {/literal}

    {literal}
        <script>
            // 用来设置tinyMCE初始值的回调函数
            function setContentCallback(instance){
                var content = $("#post_content").html().trim();
                instance.setContent(content);
            }
        </script>
    {/literal}

    <title>xiaofud - POST</title>
</head>
<body>
    <!-- 导航栏不要放到 container 里面去 -->
    <!-- 导航栏 -->
    {include file="navbar.tpl"}
    <!-- 导航栏 -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <form action="addPost.php" method="POST" role="form">

                    {*用于判断是否是修改内容*}
                    {if isset($post)}
                        <input name="post_id" id="post_id" type="hidden" value="{$post["id"]}">
                    {/if}

                    {*标题*}
                    <div class="form-group">
                        <label class="sr-only" for="title">Title</label>
                        {if isset($post)}
                            <input class="form-control" id="title" type="text"
                                   name="title" placeholder="Title" required value="{$post["title"]}">
                        {else}
                            <input class="form-control" id="title" type="text"
                                   name="title" placeholder="Title" required>
                        {/if}


                    </div>
                    {*标题*}

                    {*用于增加分类和修改作者*}
                    <div class="row">
                        <div class="col-md-6">
                            {*新建分类*}
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button data-toggle="collapse" data-target="#new_catalog"
                                                class="btn btn-secondary glyphicon" type="button">
                                            +catalog
                                        </button>
                                    </span>
                                    <input name="new_catalog" id="new_catalog" type="text" class="form-control fade" placeholder="type your new catalog">
                                </div>
                            </div>
                            {*新建分类*}
                        </div>

                        <div class="col-md-6">
                            {*修改作者*}
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button data-toggle="collapse" data-target="#edit_author"
                                                class="btn btn-secondary glyphicon glyphicon-edit" type="button">
                                            EditAuthor
                                        </button>
                                    </span>
                                    {if isset($post)}
                                        <input value="{$post["author"]}" name="username" id="edit_author" type="text" class="form-control fade" placeholder="type author name">
                                    {else}
                                        <input value="{$smarty.session['username']}" name="username" id="edit_author" type="text" class="form-control fade" placeholder="type author name">
                                    {/if}

                                </div>
                            </div>
                            {*修改作者*}
                        </div>
                    </div>
                    {*用于增加分类和修改作者*}

                    <div class="row">
                        <div class="col-md-6">
                            {*分类*}
                            <div class="form-group">
                                <label for="catalog" class="sr-only" ><small>Catalog</small></label>
                                <select name="catalog" id="catalog" class="form-control" >
                                    {foreach $catalogs as $catlog}
                                        {if isset($post) && $post["catalog_tag"] == $catlog["catalog_tag"] }
                                            <option selected>{$catlog["catalog_tag"]}</option>
                                        {else}
                                            <option>{$catlog["catalog_tag"]}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                            {*分类*}
                        </div>
                        <div class="col-md-6">
                            {*关键字*}
                            <div class="form-group">
                                <label for="keywords" class="sr-only">keywords</label>
                                {if isset($post)}
                                    <input value="{$post['keywords']}" type="text" class="form-control" id="keywords" name="keywords" placeholder="keyword1;keyword2">
                                {else}
                                    <input type="text" class="form-control" id="keywords" name="keywords" placeholder="keyword1;keyword2">
                                {/if}

                            </div>
                            {*关键字*}
                        </div>
                    </div>

                    {*内容*}
                    <div class="form-group" >
                        <label  class="sr-only" for="content">Body</label>
                        <textarea class="form-control" id="content" name="content">
                        </textarea>
                    </div>
                    {*内容*}

                    <div class="form-group">
                        <label class="sr-only" for="submit">Submit</label>
                        <input class="pull-right btn btn-primary" type="submit" id="submit" value="POST">
                    </div>
                </form>
            </div>
            <div class="col-md-2">
                {*Leave Blank*}
            </div>
        </div>
        {*用于初始化tinyMCE的内容*}
        <div id="post_content" style="display: none">
            {if isset($post)}
                {$post["content"]}
            {/if}
        </div>
    </div>
</body>
</html>
