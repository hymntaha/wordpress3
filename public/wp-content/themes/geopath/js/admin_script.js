jQuery(document).ready(function($) {
   //Run select2 for custom library tag
    $('#audience_terms, #industries_terms, #content_type_terms, #member_terms, #board_terms').each(function(){
        var placehilderValue = $(this).attr('data-placeholder');

        $(this).select2({
            minimumResultsForSearch: Infinity,
            placeholder: placehilderValue
        });

    });
});