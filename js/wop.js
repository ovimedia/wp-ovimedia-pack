jQuery(document).ready(function($) {

    jQuery("#btn_cookies").click(function() {
        setcookie();

        jQuery(".wop_cookies").fadeOut(600);
    });


    function setcookie() {
        localStorage.controlcookie = (localStorage.controlcookie || 0);

        localStorage.controlcookie++;
    }

    if (!localStorage.controlcookie) {
        jQuery(".wop_cookies").fadeIn(600);
    }


    if (jQuery("#cookie_mode").val() == "auto")
        setcookie();

    jQuery("#btn_cancel_cookies").click(function() {
        parent.history.back();
        return false;
    });

    jQuery("#floating_widget_button_right").click(function() {
        if (!jQuery("#floating_widget_button_right").hasClass("floating_button_url")) {
            if (jQuery("#floating_widget_right").hasClass("right_show")) {
                jQuery("#floating_widget_right").removeClass("right_show");
                jQuery("#floating_widget_right").addClass("right_hide");
            } else {
                jQuery("#floating_widget_right").removeClass("right_hide");
                jQuery("#floating_widget_right").addClass("right_show");
            }

            if (jQuery("#floating_widget_button_right").hasClass("right_button_show")) {
                jQuery("#floating_widget_button_right").removeClass("right_button_show");
                jQuery("#floating_widget_button_right").addClass("right_button_hide");
            } else {
                jQuery("#floating_widget_button_right").removeClass("right_button_hide");
                jQuery("#floating_widget_button_right").addClass("right_button_show");
            }
        }
    });

    jQuery("#floating_widget_button_left").click(function() {
        if (!jQuery("#floating_widget_button_left").hasClass("floating_button_url")) {
            if (jQuery("#floating_widget_left").hasClass("left_show")) {
                jQuery("#floating_widget_left").removeClass("left_show");
                jQuery("#floating_widget_left").addClass("left_hide");
            } else {
                jQuery("#floating_widget_left").removeClass("left_hide");
                jQuery("#floating_widget_left").addClass("left_show");
            }

            if (jQuery("#floating_widget_button_left").hasClass("left_button_show")) {
                jQuery("#floating_widget_button_left").removeClass("left_button_show");
                jQuery("#floating_widget_button_left").addClass("left_button_hide");
            } else {
                jQuery("#floating_widget_button_left").removeClass("left_button_hide");
                jQuery("#floating_widget_button_left").addClass("left_button_show");
            }
        }
    });

    jQuery("#floating_widget_button_bottom").click(function() {
        if (!jQuery("#floating_widget_button_bottom").hasClass("floating_button_url")) {
            if (jQuery("#floating_widget_bottom").hasClass("bottom_show")) {
                jQuery("#floating_widget_bottom").removeClass("bottom_show");
                jQuery("#floating_widget_bottom").addClass("bottom_hide");
            } else {
                jQuery("#floating_widget_bottom").removeClass("bottom_hide");
                jQuery("#floating_widget_bottom").addClass("bottom_show");
            }

            if (jQuery("#floating_widget_button_bottom").hasClass("bottom_button_show")) {
                jQuery("#floating_widget_button_bottom").removeClass("bottom_button_show");
                jQuery("#floating_widget_button_bottom").addClass("bottom_button_hide");
            } else {
                jQuery("#floating_widget_button_bottom").removeClass("bottom_button_hide");
                jQuery("#floating_widget_button_bottom").addClass("bottom_button_show");
            }
        }
    });

    jQuery("#floating_widget_button_top").click(function() {
        if (!jQuery("#floating_widget_button_top").hasClass("floating_button_url")) {
            if (jQuery("#floating_widget_top").hasClass("top_show")) {
                jQuery("#floating_widget_top").removeClass("top_show");
                jQuery("#floating_widget_top").addClass("top_hide");
            } else {
                jQuery("#floating_widget_top").removeClass("top_hide");
                jQuery("#floating_widget_top").addClass("top_show");
            }

            if (jQuery("#floating_widget_button_top").hasClass("top_button_show")) {
                jQuery("#floating_widget_button_top").removeClass("top_button_show");
                jQuery("#floating_widget_button_top").addClass("top_button_hide");
            } else {
                jQuery("#floating_widget_button_top").removeClass("top_button_hide");
                jQuery("#floating_widget_button_top").addClass("top_button_show");
            }
        }
    });
});