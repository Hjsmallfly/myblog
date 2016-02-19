{*$pages 变量的结构*}
{*$pages = [*}
{*1 => "https://github.com/Hjsmallfly",*}
{*2 => "https://github.com/Hjsmallfly"*}
{*];*}

<div id="pagination_div" class="row text-center">
    <ul class="pagination pagination-lg">
        <li><a href="#">&lt;&lt;</a></li>
        {foreach $pages as $page_num}
            <li><a href="index.php?p={$page_num}">{$page_num}</a></li>
        {foreachelse}
            <li><a href="#">1</a></li>
        {/foreach}
        <li><a href="#">&gt;&gt;</a></li>
    </ul>
</div>