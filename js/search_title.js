/**
 * Created by smallfly on 16-2-27.
 */

function search_title(title){
    //alert("You are searching " + title);
    if (title.trim() != "")
        window.location = "/php/views/search.php?keyword=" + title;
}