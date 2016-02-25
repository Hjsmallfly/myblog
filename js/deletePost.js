/**
 * Created by smallfly on 16-2-25.
 */
function delete_post(id){
    // 使用AJAX删除该文章
//            alert("deleting " + id);
    var sure = confirm("Are You Sure To Delete This Post?");
    if (sure == true) {
        $.get("/php/admin/delete_post.php?id=" + id, function (data, status) {
//                    alert(data);
            var result = JSON.parse(data);
            if (!("ERROR" in result)){
//                        alert("DELETED!");
                // 跳转
                window.location = "/index.php";
            }else{
                alert("FAILED TO DELETE: " + result["ERROR"]);
            }
        });
    }
}
