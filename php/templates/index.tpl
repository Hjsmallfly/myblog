<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../lib/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <script src="../lib/jquery-2.2.0.min.js"></script>
    <script src="../lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <title>xiaofud - HOME</title>
</head>
<body>
<!-- 导航栏不要放到 container 里面去 -->
<!-- 导航栏 -->
    {include file="navbar.tpl"}
<!-- 导航栏 -->
<div id="content_div" class="container-fluid">
    <!-- 整体内容 -->
    <div class="row">
        <!-- 左边的最近的posts -->
        <div id="contents" class="col-md-7 col-md-offset-1">
            <div id="myPage_header">
                <!-- 根据不同的页面生成不同的内容 -->
                <h6 ><small>RECENT POSTS PREVIEW</small></h6>
                <hr />
            </div>
            <div id="content_preview">
                {*当页的post的预览*}
                {include file="post_preview.tpl" post_previews=$post_previews}
            </div>  <!-- 内容的预览 -->
        </div>
        <!-- 左边的最近的posts -->

        <!-- 右边内容 -->
        <div id="right_part" class="col-md-3" style="margin-top: 5%">

            <!-- 搜索框 -->
            {*http://v4-alpha.getbootstrap.com/components/input-group/*}
            <div id="custom-search-input">
                <div class="input-group col-md-offset-2">
                    <input type="text" class="  search-query form-control" placeholder="Search" />
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="button">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                </div>
            </div>
            <br />
            <!-- 搜索框 -->


            <!-- 分类框 -->
            <div id="catalog" class="col-md-offset-2">
                {include file="catalog_pane.tpl" catalog_items=$catalog_items}
            </div>
            <!-- 分类框 -->
        </div>
        <!-- 右边内容 -->
        <div class="col-md-1">
            <!-- EMPTY -->
        </div>
    </div> <!-- row -->
    {include file="pagination.tpl" page_info=$page_info}
</div> <!-- container -->

</body>
</html>