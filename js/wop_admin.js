jQuery(document).ready(function(jQuery) {

    jQuery(".jscolor").spectrum({
        showInput: true,
        showInitial: true,
        allowEmpty: true,
        showAlpha: true,
        lat: true,
        preferredFormat: "rgb",
        cancelText: "Cancelar",
        chooseText: "Elegir"
    });


    jQuery("#button_law_page").click(function() {

        var address = "";
        var cif = "";
        var register = "";

        if (jQuery("#address_empresa").val() != "")
            address = jQuery("#pre_address_empresa").val() + jQuery("#address_empresa").val();

        if (jQuery("#cif_empresa").val() != "")
            cif = jQuery("#pre_cif_empresa").val() + jQuery("#cif_empresa").val();

        if (jQuery("#register_empresa").val() != "")
            register = jQuery("#pre_register_empresa").val() + jQuery("#register_empresa").val()

        var request = jQuery.ajax({
            url: jQuery("#url_base").val() + "pages.php",
            method: "POST",
            data: {
                name_empresa: jQuery("#name_empresa").val(),
                address_empresa: address,
                cif_empresa: cif,
                register_empresa: register,
                domain_empresa: jQuery("#domain_empresa").val(),
                email_empresa: jQuery("#email_empresa").val(),
                title_aviso_legal: jQuery("#title_aviso_legal").val(),
                slug_aviso_legal: jQuery("#slug_aviso_legal").val()
            }
        });

        request.done(function(msg) {
            view_messages(msg);
        });
    });

    jQuery("#button_cookies_pages").click(function() {

        var request = jQuery.ajax({
            url: jQuery("#url_base").val() + "pages.php",
            method: "POST",
            data: {
                slug_mas_informacion: jQuery("#slug_mas_informacion").val(),
                slug_politica_cookies: jQuery("#slug_politica_cookies").val(),
                title_politica_cookies: jQuery("#title_politica_cookies").val(),
                title_mas_informacion: jQuery("#title_mas_informacion").val()
            }
        });

        request.done(function(msg) {
            view_messages(msg);
        });
    });

    function view_messages(msg) {
        jQuery("#messages_plugin").empty();
        jQuery("#messages_plugin").html(msg);
        jQuery("#messages_plugin").fadeIn(400);
        jQuery("#messages_plugin").fadeOut(6000);
    }

    jQuery(".tab_links").click(function() {
        jQuery(".tab_content").css("display", "none");

        jQuery(jQuery(this).attr("title")).css("display", "block");

        jQuery(".tab_links").removeClass("active_tab");

        jQuery(this).addClass("active_tab");
    });

    jQuery("#remove_login_logo_button").click(function() {
        jQuery("#login_logo_image").val("");
        jQuery(".image_login_page").attr("src", "");

    });

    jQuery("#remove_login_background_button").click(function() {
        jQuery("#login_background_image").val("");
        jQuery(".image_background_page").attr("src", "");
    });


    jQuery(jQuery("#list_options li").first().attr("title")).css("display", "block");

    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html);
    });

    jQuery("#cookies_container .js-switch").change(function() {

        if (jQuery("#cookies_container .js-switch").is(':checked')) {
            jQuery("#cookies_container input, #cookies_container select").prop('disabled', false);
        } else {
            jQuery("#cookies_container input, #cookies_container select").prop('disabled', 'disabled');
            jQuery("#cookies_container .js-switch").prop('disabled', false);
        }

    });

    if (!jQuery("#cookies_container .js-switch").is(':checked')) {
        jQuery("#cookies_container input, #cookies_container select").prop('disabled', 'disabled');
        jQuery("#cookies_container .js-switch").prop('disabled', false);
    }

    jQuery("#footer_container .js-switch").change(function() {

        if (jQuery("#footer_container .js-switch").is(':checked')) {
            jQuery("#footer_container input, #footer_container select").prop('disabled', false);
        } else {
            jQuery("#footer_container input, #footer_container select").prop('disabled', 'disabled');
            jQuery("#footer_container .js-switch").prop('disabled', false);
        }

    });

    if (!jQuery("#footer_container .js-switch").is(':checked')) {
        jQuery("#footer_container input, #footer_container select").prop('disabled', 'disabled');
        jQuery("#footer_container .js-switch").prop('disabled', false);
    }

    jQuery("#floating_widget_container .js-switch").change(function() {

        if (jQuery("#floating_widget_container .js-switch").is(':checked')) {
            jQuery("#floating_widget_container input, #floating_widget_container select").prop('disabled', false);
        } else {
            jQuery("#floating_widget_container input, #floating_widget_container select").prop('disabled', 'disabled');
            jQuery("#floating_widget_container .js-switch").prop('disabled', false);
        }

    });

    if (!jQuery("#floating_widget_container .js-switch").is(':checked')) {
        jQuery("#floating_widget_container input, #floating_widget_container select").prop('disabled', 'disabled');
        jQuery("#floating_widget_container .js-switch").prop('disabled', false);
    }

    if (jQuery('.set_custom_logo').length > 0) {
        if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            jQuery(document).on('click', '.set_custom_logo', function(e) {
                e.preventDefault();
                var button = jQuery(this);
                var id = button.prev();
                wp.media.editor.send.attachment = function(props, attachment) {
                    id.val(attachment.id);
                };
                wp.media.editor.open(button);
                return false;
            });
        }
    }

    if (jQuery('.set_custom_background').length > 0) {
        if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            jQuery(document).on('click', '.set_custom_background', function(e) {
                e.preventDefault();
                var button = jQuery(this);
                var id = button.prev();
                wp.media.editor.send.attachment = function(props, attachment) {
                    id.val(attachment.id);
                };
                wp.media.editor.open(button);
                return false;
            });
        }
    }

    jQuery("#contact_form_generator").click(function() {

        var request = jQuery.ajax({
            url: jQuery("#url_base").val() + "forms.php",
            method: "POST",
            data: {
                form_name: jQuery("#contact_form_name").val(),
                receiver_email: jQuery("#contact_form_receiver_email").val(),
                form_type: jQuery("#contact_form_type").val(),
                legal_notice_url: jQuery("#slug_aviso_legal").val(),
                form_columns: jQuery("#contact_form_columns").val(),
                include_legal_notice: jQuery("#contact_form_include_legal_notice").val(),
                include_message: jQuery("#contact_form_include_message").val(),
                contact_form_fields: jQuery("#contact_form_fields").val(),
                contact_form_subject: jQuery("#contact_form_subject").val(),
                contact_form_required_fields: jQuery("#contact_form_required_fields").val()
            }
        });

        request.done(function(msg) {

            view_messages(msg);
        });
    });

    jQuery('.wrap_wop_form .select2').select2({ tags: true });
});