<!DOCTYPE html>
<html>
<head>
    {*default*}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/lib/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <script src="/lib/jquery-2.2.0.min.js"></script>
    <script src="/lib/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    {*default*}

    <link rel="stylesheet" href="/css/custom_file_input_button.css">
    <script src="/js/upload_img_via_jquery.js"></script>
    <script src="/js/photo_upload.js"></script>
    <title>xiaofud | Photos</title>

</head>
<body>
    <div id="navbar">
        {include file="navbar.tpl"}
    </div>

    <div class="container-fluid">
        {foreach $picture_chunks as $pictures}
            <div class="row">
                {foreach $pictures as $picture}
                    <div class="col-md-3 ">
                        <a href="/img/{$picture}" target="_blank">
                        <img class="img-responsive img-rounded center-block" src="/img/{$picture}" alt="{$picture}">
                        </a>
                    </div>
                {/foreach}
            </div>
            <hr/>
        {/foreach}

        <div>
            <br/>
        </div>
        {if isset($smarty.session["logged"]) && $smarty.session["logged"] == true}
            <div id="upload_section" class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="input-group">
                    <span class="input-group-btn">
                        {*http://www.abeautifulsite.net/whipping-file-inputs-into-shape-with-bootstrap-3/*}
                        <span class="btn btn-secondary btn-info btn-file">
                            <span class="button_title">Choose</span>
                            <input type="file"
                                   id="img_file"
                                   name="img_file"
                                   accept="image/gif, image/jpeg, image/png"
                                   onchange="display_file_info('img_file', 'filename')"
                            >
                        </span>
                    </span>
                        <input disabled id="filename" type="text" class="form-control" placeholder="file selected">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <button class="btn btn-primary btn-block"
                            id="jquery_ajax_upload_button"
                            onclick="uploadPicture('img_file');">
                        upload
                    </button>
                </div>

            </div>
        {/if}

    </div>


</body>
</html>