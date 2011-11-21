/**
 * Navigation
 */
$(document).ready(function() {
     $('a#show-nav').click(function(event) {
       event.preventDefault();
       $('nav#primary-nav').slideToggle('fast');
     });
});