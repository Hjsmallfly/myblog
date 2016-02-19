<!-- 分类框 -->
<ul class="list-group">
    <li class="list-group-item">
        <span class="list-group-item-heading">Catalogs<a href="#"><span class="glyphicon glyphicon-edit pull-right">new</span></a></span>
    </li>
    {foreach $catalog_items as $item}
        <li class="list-group-item">
            <span class="badge">{$item["post_count"]}</span><a href="viewtag.php?={$post["id"]}">
                {$item["catalog_tag"]}
            </a>
        </li>
    {/foreach}
</ul>
<!-- 分类框 -->