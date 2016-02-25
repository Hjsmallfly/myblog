/**
 * Created by smallfly on 16-2-25.
 */

// 用于选择文件以后显示文件名
function display_file_info(fileInputId, display_id){
    var fileInput = $("#" + fileInputId),
//                    numFiles = fileInput.get(0).files ? fileInput.get(0).files.length : 1,
        label = fileInput.val().replace(/\\/g, '/').replace(/.*\//, '');
    // 替换文字信息
    $("#" + display_id).val(label);
}

