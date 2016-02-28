/**
 *
 * Created by smallfly on 16-2-25.
 */
tinyMCE.init({
    fontsize_formats: "10pt 12pt 14pt 18pt 24pt 36pt",
    selector: '#content',
    theme: 'modern',
    br_in_pre: false,
    preformatted : true,
    width: "100%",
    height: 260,
    init_instance_callback: "setContentCallback",   // 设置回调函数，它会传这个instance作为参数
                                                    //
    plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'save table contextmenu directionality emoticons template paste textcolor'
    ],
    style_formats : [
        {title : 'pre', block : 'pre'},
        {title : 'code', block : 'code'},
    ],
    convert_newlines_to_brs : false,    // 对于代码高亮插件来说非常重要
    style_formats_merge: true, // won't override default style_formats
    content_css: 'css/content.css',
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media| forecolor backcolor emoticons | sizeselect | bold italic | fontselect |  fontsizeselect'
});
