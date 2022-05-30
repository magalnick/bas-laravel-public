<script>
    const newsletters = {!! json_encode($newsletters['data']) !!};

    const displayNewsletter = function(filename, useGoogle) {
        filename = cleanFilename(filename);
        if (typeof newsletters['newsletters'][filename] === 'undefined') {
            return;
        }
        if ( typeof useGoogle === "undefined" ) {
            useGoogle = false;
        }
        useGoogle = !!useGoogle;

        let newsletter = newsletters['newsletters'][filename];
        let aTag = $("#newsletter-display p a")[0];
        let iframeHeight = window.innerHeight - 200;
        $("#newsletter-display p.h5").text(newsletter.month + ', ' + newsletter.year);
        $("#newsletter-display p a span.size").text(newsletter.sizef);
        if (useGoogle) {
            aTag.href   = newsletter.url;
            aTag.target = '_blank';
            $("#newsletter-display div.pdf").html('<iframe class="rounded" src="https://docs.google.com/viewerng/viewer?embedded=true&url=' + encodeURIComponent(newsletter.url) + '" title="Newsletter PDF" style="width: 100%; height: ' + iframeHeight + 'px; border: 0;"></iframe>');
        } else {
            //aTag.href   = 'javascript:displayNewsletter("' + newsletter.filename + '", true);';
            //aTag.target = '';
            aTag.href   = newsletter.url;
            aTag.target = '_blank';
            $("#newsletter-display div.pdf").html('<iframe class="rounded" src="' + newsletter.url + '" style="width: 100%; height: ' + iframeHeight + 'px; border: 0;"></iframe>');
        }

        // force the page to scroll to the content area for user display
        $('html, body').animate({
            scrollTop: parseInt($("#main-content").offset().top)
        }, 500);
    };

    // special case for page load since a valid page-level hash like main-content is still valid
    // but won't trigger the file load since it's not a newsletter file name
    const displayNewsletterOnPageLoad = function(filename) {
        filename = cleanFilename(filename);
        if (typeof newsletters['newsletters'][filename] === 'undefined') {
            filename = '';
        }

        displayNewsletter(filename);
    };

    const cleanFilename = function(filename) {
        if (typeof filename !== 'string') {
            return '';
        }
        filename = $.trim(filename);
        if (filename === '') {
            return newsletters.current;
        }

        return filename;
    };

    $(document).ready(function() {
        displayNewsletterOnPageLoad(
            document.location.hash.replace('#', '')
        );

        /********************  DO THIS LAST  ********************/
        $(window).bind("hashchange", function(e) {
            displayNewsletter(
                document.location.hash.replace('#', '')
            );
        });
        /********************  DO THIS LAST  ********************/
    });
</script>
