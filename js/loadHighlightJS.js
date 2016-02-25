/**
 * Created by smallfly on 16-2-25.
 */
$(document).ready(function() {
    // choose tag to render the code
    $('pre').each(function(i, block) {
        hljs.highlightBlock(block);
    });
    $('code').each(function(i, block) {
        hljs.highlightBlock(block);
    });
});
