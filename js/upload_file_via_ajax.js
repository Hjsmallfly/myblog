/**
 * Created by smallfly on 16-2-25.
 */
// from http://www.cnblogs.com/hooyes/archive/2012/08/01/ajax_upload_file.html
function uploadFile() {
    var fileObj = document.getElementById("file").files[0]; // 获取文件对象
    var FileController = "uploadIMG.php";                    // 接收上传文件的后台地址
    // FormData 对象
    var form = new FormData();
    form .append("img_name", "testing");
    form.append("fileToUpload", fileObj);                           // 文件对象
    form.append("submit", "submit");
    // XMLHttpRequest 对象
    var xhr = new XMLHttpRequest();
    xhr.open("POST", FileController, true);
    xhr.onreadystatechange = function(){
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            alert(xhr.responseText);
        }
    };
    xhr.send(form);
}

