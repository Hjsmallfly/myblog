<!-- 分类框 -->
<ul class="list-group">
    <li class="list-group-item">
        <span class="list-group-item-heading">Catalogs</span>
    </li>
    {foreach $catalog_items as $item}
        {if $item["post_count"] > 0}
            <li class="list-group-item">
                <span class="badge">{$item["post_count"]}</span><a href="/php/views/viewtag.php?tag_id={$item["id"]}">
                    {$item["catalog_tag"]}
                </a>
        </li>
        {/if}
    {/foreach}
</ul>
<!-- 分类框 -->