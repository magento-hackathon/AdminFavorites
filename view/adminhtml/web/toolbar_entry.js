define([
    "jquery",
    "jquery/ui",
    "domReady!"
], function ($) {
    'use strict';

    $(document).ready(function () {
        // ajax call to grab values above and send to the hackathon_admin_favorites/checkurl
        // returns json or 3 arrays  - favs, popular, recent
        $.ajax({
            type: "GET",
            url: getFavesUrl,
            data: getFavesData,
            success: function () {
            }
        }).done(function (result) {
            //updateFavoriteMegaMenu(result.items);
            //$('#hackathon_admin_favorites_heart').show();
        });
        // ajax call to toggle fav //no fav
        $('#hackathon_admin_favorites_heart').click(function (event) {
            event.stopPropagation();
            $.ajax({
                type: "POST",
                url: toggleFaveUrl,
                data: toggleFaveData,
                success: function () {
                }
            }).done(function () {
                //$('#hackathon_admin_favorites_heart').addClass(result.is_favorite);
                //updateFavoriteMegaMenu(result.items);
            });
        });
    });

    function updateFavoriteMegaMenu(items) {
        for (var i = 0; i < items.length; i++) {
            // add urls for each column
            // foreach input box, on change, update label
        }
    }
});