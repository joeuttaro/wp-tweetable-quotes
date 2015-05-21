
/* ============================================================================================== */
/* WP Tweetable Quotes v0.1 ===================================================================== */
/* Authored by TJ Webb and Justin Bellefontaine ================================================= */
/* ============================================================================================== */

(function ($) {
    $(document).ready(function () {
        if($('blockquote.tweetable').length > 0) {
            $('blockquote.tweetable').append('<a href="#" class="tweetable-icon"><i class="fa fa-twitter"></i></a>');
        }
        $(document).on('click', '.tweetable-icon', function(e){
            var quote = '';
            $('h2', $(this).parent()).each(function(){
                if(quote.length)
                    quote += ' ';
                quote += $(this).text();
            });
            var url = encodeURIComponent(window.location);
            var gutter_length = 28; //twitter shortens all urls to 22 chars, add 1 for space,
                                    //2 for quotes, 2 for attribution, 1 for elipsis
            var max_tweet_length = 140;

            var trimmed_quote = quote.substr(0, max_tweet_length - gutter_length);

            if(trimmed_quote.length < quote.length)
                trimmed_quote = trimmed_quote.substr(0, Math.min(trimmed_quote.length, trimmed_quote.lastIndexOf(" ")));

            if(trimmed_quote.length < quote.length)
                trimmed_quote += '…';

            quote = '"' + trimmed_quote + '" — ' + url;

            var tweet_url = 'https://twitter.com/intent/tweet?text=' + quote;
            window.open(tweet_url, 'twitter', 'height=250,width=600');

            e.preventDefault();
        });
    });
})(jQuery);