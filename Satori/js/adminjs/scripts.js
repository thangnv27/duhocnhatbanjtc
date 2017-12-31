/* 
 * @Author: Ngo Van Thang
 * @Email: ngothangit@gmail.com
 */

var CustomJS = function(){
    return {
        uploadFavicon: function($){
            var custom_uploader;
            $('#upload_favicon_button').click(function(e) {
                e.preventDefault();
 
                //If the uploader object has already been created, reopen the dialog
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
 
                //Extend the wp.media object
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });
 
                //When a file is selected, grab the URL and set it as the text field's value
                custom_uploader.on('select', function() {
                    attachment = custom_uploader.state().get('selection').first().toJSON();
                    $('#favicon').val(attachment.url);
                });
 
                //Open the uploader dialog
                custom_uploader.open();
            });
        },
        uploadLogoSite: function($){
            var custom_uploader;
            $('#upload_sitelogo_button').click(function(e) {
                e.preventDefault();
 
                //If the uploader object has already been created, reopen the dialog
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
 
                //Extend the wp.media object
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });
 
                //When a file is selected, grab the URL and set it as the text field's value
                custom_uploader.on('select', function() {
                    attachment = custom_uploader.state().get('selection').first().toJSON();
                    $('#sitelogo').val(attachment.url);
                });
 
                //Open the uploader dialog
                custom_uploader.open();
            });
        },
        uploadSlider: function($){
            var custom_uploader;
            $('#upload_slide_img_button').click(function(e) {
                e.preventDefault();
 
                //If the uploader object has already been created, reopen the dialog
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
 
                //Extend the wp.media object
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });
 
                //When a file is selected, grab the URL and set it as the text field's value
                custom_uploader.on('select', function() {
                    attachment = custom_uploader.state().get('selection').first().toJSON();
                    $('#slide_img').val(attachment.url);
                });
 
                //Open the uploader dialog
                custom_uploader.open();
            });
            
            $("#publish").click(function(event){
                var valid = true;
                if($("#slide_img").length > 0 && $("#slide_img").val().length == 0){
                    $("#slide_img").css('border', '1px solid red');
                    valid = false;
                }
                if($("#slide_order").length > 0 && !$.isNumeric($("#slide_order").val())){
                    $("#slide_order").css('border', '1px solid red');
                    valid = false;
                }
                if(valid == false){
                    event.stopImmediatePropagation();
                    return false;
                }
            });
        },
        uploadPartner: function($){
            var custom_uploader;
            $('#upload_partner_image_button').click(function(e) {
                e.preventDefault();
 
                //If the uploader object has already been created, reopen the dialog
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
 
                //Extend the wp.media object
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });
 
                //When a file is selected, grab the URL and set it as the text field's value
                custom_uploader.on('select', function() {
                    attachment = custom_uploader.state().get('selection').first().toJSON();
                    $('#partner_image').val(attachment.url);
                });
 
                //Open the uploader dialog
                custom_uploader.open();
            });
            
            $("#publish").click(function(event){
                var valid = true;
                if($("#slide_img").length > 0 && $("#slide_img").val().length == 0){
                    $("#slide_img").css('border', '1px solid red');
                    valid = false;
                }
                if($("#slide_order").length > 0 && !$.isNumeric($("#slide_order").val())){
                    $("#slide_order").css('border', '1px solid red');
                    valid = false;
                }
                if(valid == false){
                    event.stopImmediatePropagation();
                    return false;
                }
            });
        },
        uploadBanners: function($){
            var custom_uploader;
            $('#upload_post_banner_button').click(function(e) {
                e.preventDefault();
 
                //If the uploader object has already been created, reopen the dialog
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
 
                //Extend the wp.media object
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });
 
                //When a file is selected, grab the URL and set it as the text field's value
                custom_uploader.on('select', function() {
                    attachment = custom_uploader.state().get('selection').first().toJSON();
                    $('#post_banner').val(attachment.url);
                });
 
                //Open the uploader dialog
                custom_uploader.open();
            });
        },
        uploadBackgrounds: function($){
            var fields = new Array("bg_banner","bg_header");
            
            $.each(fields, function(index, field){
                var custom_uploader;
                $('#upload_' + field + '_button').click(function(e) {
                    e.preventDefault();

                    //If the uploader object has already been created, reopen the dialog
                    if (custom_uploader) {
                        custom_uploader.open();
                        return;
                    }

                    //Extend the wp.media object
                    custom_uploader = wp.media.frames.file_frame = wp.media({
                        title: 'Choose Image',
                        button: {
                            text: 'Choose Image'
                        },
                        multiple: false
                    });

                    //When a file is selected, grab the URL and set it as the text field's value
                    custom_uploader.on('select', function() {
                        attachment = custom_uploader.state().get('selection').first().toJSON();
                        $('#' + field).val(attachment.url);
                    });

                    //Open the uploader dialog
                    custom_uploader.open();
                });
            });
        }
    }
}();

// Run
jQuery(document).ready(function($){
    CustomJS.uploadFavicon($);
    CustomJS.uploadLogoSite($);
    CustomJS.uploadSlider($);
    CustomJS.uploadPartner($);
    CustomJS.uploadBanners($);
    CustomJS.uploadBackgrounds($);
});