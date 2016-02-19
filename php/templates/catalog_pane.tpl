<!-- 分类框 -->
<ul class="list-group">
    <li class="list-group-item">
        <span class="list-group-item-heading">Catalogs<a href="#"><span class="glyphicon glyphicon-edit pull-right">new</span></a></span>
    </li>
    {foreach $catalog_items as $item}
        <li class="list-group-item">
            <span class="badge">{$item["count"]}</span><a href="{$item["url"]}">{$item["name"]}</a>
        </li>
    {/foreach}
</ul>
<!-- 分类框 -->