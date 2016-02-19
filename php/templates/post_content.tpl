{*// OUTPUT:*}
{*/**}
{** 'id' => string '2' (length=1)*}
{*'title' => string 'First Post' (length=10)*}
{*'keywords' => string 'hello;world' (length=11)*}
{*'moment' => string '2016-02-19 17:25:23' (length=19)*}
{*'viewed_times' => string '0' (length=1)*}
{*'content' => string 'Hello world' (length=11)*}
{*'author' => string 'smallfly' (length=8)*}
{*'catalog_tag' => string 'test' (length=4)*}
{*'catalog_id' => string '1' (length=1)*}
{*'author_id' => string '1' (length=1)*}

{**/*}
<!-- One Post -->
<div class="post_title text-center">
    <a href="viewpost.php?id={$post["id"]}"><h1 >{$post["title"]}</h1></a>
</div>
<div class="post_info text-center">
    <span class="post_author">
        <small style="font-size: xx-small">POST BY</small>
        <a href="viewauthor.php?id={$post["author_id"]}" class="text-warning">{$post["author"]}</a>
        <br />
    </span>
    <span class="tags">
        <span class="label label-danger glyphicon glyphicon-time">{$post["moment"]}</span>
        <a href="viewtag.php?id={$post["catalog_id"]}"><span class="label label-primary"> {$post["catalog_tag"]}</span></a>
        {*貌似变量名称不能是tag*}
        {foreach $post["keywords"] as $keyword}
            <a href="#"><span class="label label-primary"> {$keyword}</span></a>
        {/foreach}
    <!-- viewed times -->
        <span  class="label label-success"><span class="glyphicon glyphicon-eye-open"></span> {$post["viewed_times"]}</span>
    </span>
</div>

{*<div class="spacing_after_title">*}
    {*<br />*}
{*</div>*}

<div class="row">
    <div class="post_body col-md-offset-2 col-md-8">
        <hr />
        {$post["content"]}
    </div>
    <div class="col-md-2">

    </div>
</div>


{*<span class="pull-right">*}
    {*<a href="{$post["url"]}">Read More</a>*}
{*</span>*}

{*<div class="spacing_per_post">*}
    {*<br />*}
    {*<hr />*}
{*</div>*}
<!-- One Post -->