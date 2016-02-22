
{foreach $post_previews as $post}
    <!-- One Post -->
    <div class="post_title">
        <a href="/php/views/viewpost.php?id={$post["id"]}"><h3 >{$post["title"]}</h3></a>
    </div>
    <div class="post_info">
        <span class="post_author">
            <small style="font-size: xx-small">POST BY</small>
            <a href="viewauthor.php?={$post["author_id"]}" class="text-warning">{$post["author"]}</a>
            <br />
        </span>
        <span class="tags">
            <span class="label label-danger glyphicon glyphicon-time">{$post["moment"]}</span>
            <a href="/php/views/viewtag.php?tag_id={$post["catalog_id"]}"><span class="label label-primary"> {$post["catalog_tag"]}</span></a>
            {*貌似变量名称不能是tag*}
            {foreach $post["keywords"] as $keyword}
                {if $keyword != ""}
                    <a href="#"><span class="label label-primary"> {$keyword}</span></a>
                {/if}
            {/foreach}
            <!-- viewed times -->
            <span  class="label label-success"><span class="glyphicon glyphicon-eye-open"></span> {$post["viewed_times"]}</span>
        </span>
    </div>

    <div class="spacing_after_title">
        <br />
    </div>

    <div class="post_preview">
        {$post["content"]}
    </div>

    <span class="pull-right">
        <a href="/php/views/viewpost.php?id={$post["id"]}">Read More</a>
    </span>

    <div class="spacing_per_post">
        <br />
        <hr />
    </div>
    <!-- One Post -->
{/foreach}