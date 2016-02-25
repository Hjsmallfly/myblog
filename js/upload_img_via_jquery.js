/**
 * Created by smallfly on 16-2-25.
 */
// http://abandon.ie/notebook/simple-file-uploads-using-jquery-ajax
// fileInputId 为 input type=file 的控件的id
const MAX_SIZE = 5 * 1024 * 1024;   // 5MB
function uploadPicture(fileInputId) {
    var fileDOM = $("#" + fileInputId)[0];    // $("#id") is NOT EQUAL TO getElementById("id")
    if (fileDOM.files.length == 0) {
        alert("please choose file");
        return;
    }
    var fileObj = fileDOM.files[0];
    //alert(fileObj.size);
    if (fileObj.size > MAX_SIZE){
        alert("file too large(MAX - " + MAX_SIZE + ")");
        return;
    }
    var action_url = "/php/helpers/uploadIMG.php";
    var form = new FormData();
    //form.append("img_name", "testing");
    form.append("fileToUpload", fileObj);                           // 文件对象
    form.append("submit", "submit");
    $.ajax({
        url: action_url,
        type: 'POST',
        data: form,
        cache: false,
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function (data, textStatus, jqXHR) {
            alert(data);
        }
    });
}