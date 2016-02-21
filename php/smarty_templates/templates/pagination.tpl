{*参数:*}
{*current_page,*}
{*previous_page,*}
{*next_page*}
<div id="pagination_div" class="row text-center">
    <ul class="pagination pagination-lg">
        <li><a href="index.php?p={$page_info['previous_page']}">&lt;&lt;</a></li>
        {foreach $page_info["nums"] as $page_num}
            {if $page_num@index == $page_info["current_page"]}
                <li class="active"><a href="index.php?p={$page_num}">{$page_num}</a></li>
            {else}
                <li><a href="index.php?p={$page_num}">{$page_num}</a></li>
            {/if}
        {foreachelse}
            <li><a href="#">1</a></li>
        {/foreach}
        <li><a href="index.php?p={$page_info['next_page']}">&gt;&gt;</a></li>
    </ul>
</div>