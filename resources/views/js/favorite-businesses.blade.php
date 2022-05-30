<script>
    const favoriteBusinessCategories = {!! json_encode(array_keys($favorite_businesses)) !!};

    const showFavoriteBusiness = function(category) {
        category = cleanFavoriteBusinessCategory(category);
        if ($.inArray(category, favoriteBusinessCategories) === -1) {
            return;
        }

        $.each(
            favoriteBusinessCategories,
            function(i, category) {
                $("#favorite-business-" + category).hide();
                $("#favorite-business-tab-" + category).removeClass('important');
            }
        );

        $("#favorite-business-" + category).show();
        $("#favorite-business-tab-" + category).addClass('important');
    };

    // special case for page load since a valid page-level hash like main-content is still valid
    // but won't trigger the proper load state since it's not a favorite business category
    const showFavoriteBusinessOnPageLoad = function(category) {
        category = cleanFavoriteBusinessCategory(category);
        if ($.inArray(category, favoriteBusinessCategories) === -1) {
            category = '';
        }

        showFavoriteBusiness(category);
    };

    const cleanFavoriteBusinessCategory = function(category) {
        if (typeof category !== 'string') {
            return '';
        }
        category = $.trim(category);
        if (category === '') {
            return favoriteBusinessCategories[0];
        }

        return category;
    };

    $(document).ready(function() {
        showFavoriteBusinessOnPageLoad(
            document.location.hash.replace('#', '')
        );

        /********************  DO THIS LAST  ********************/
        $(window).bind("hashchange", function(e) {
            showFavoriteBusiness(
                document.location.hash.replace('#', '')
            );
        });
        /********************  DO THIS LAST  ********************/
    });
</script>
