<?php
/**
* Plugin Name: WP Tweetable Quotes
* Author: TJ Webb & Justin Bellefontaine
* Author URI: http://sitebynorex.com/
* Version: 0.1
* Description: Adds Tweeting functionality to blockquotes within content. The contents of the blockquote
* becomes the text of your Tweet, coupled a modern design an UX, your users will want to share your content.
*/

/**
 * Filter The Content
 */
add_filter('the_content', 'tweetable_quote_filter');
function tweetable_quote_filter($content){

    $dom = new DOMDocument;
    @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
    foreach($dom->getElementsByTagName('blockquote') as $blockquote){
        $blockquote->setAttribute('class', $blockquote->getAttribute('class') . ' tweetable');
        $domP = $blockquote->getElementsByTagName('p');
        for($i = $domP->length - 1; $i > -1; $i--){
            $p = $domP->item($i);
            $h2 = $dom->createElement("h2", $p->nodeValue);
            $blockquote->replaceChild($h2, $p);
        }
    }
    $content = $dom->saveHTML();

    $content =  preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $content);

    return $content;
}

/**
 * Enqueue Javascript & CSS
 */
add_action('wp_enqueue_scripts', 'tweetable_quote_add_assets');

function tweetable_quote_add_assets(){
    wp_enqueue_script('wp-tweetable-quotes-js', plugins_url('wp-tweetable-quotes') . '/wp-tweetable-quotes.js', array('jquery'));
    wp_enqueue_style('wp-tweetable-quotes-css', plugins_url('wp-tweetable-quotes') . '/wp-tweetable-quotes.css');
}