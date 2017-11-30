/**
 * Created by QuispeRoque on 21/08/17.
 */

var rootURL = location.origin + '/', path = location.pathname.split('/'), csrf_token = {}, $elem;

require.config({
    paths: {
        'jquery': '../node_modules/jquery/dist/jquery.min',//v2.2.4|v3.2.1
        'bootstrap': '../node_modules/bootstrap/dist/js/bootstrap.min',
        'metisMenu': '../node_modules/metisMenu/dist/metisMenu',
        'raphael': '../node_modules/eve-raphael/eve'
    },
    shim: {
        'bootstrap': ['jquery'],
        'metisMenu': ['jquery', 'bootstrap', 'raphael']
    }
});

require([
    'jquery',
    'bootstrap',
    'metisMenu',
    'js/sb-admin-2'
], function ($) {

    // CSRF_TOKEN
    $.extend(csrf_token, {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')});

    // Link Active
    $elem = $('.nav a.active');
    if (path[1] === '') {
        $elem.addClass('active');
        $elem.attr('href', 'javascript:;');
    } else {
        if ($elem.attr('href') == location.href) {
            $elem.closest('.href').addClass('active');
            $elem.attr('href', 'javascript:;');
        }
    }

    // $('#chkConyuge,#chkHijo').on('click', function () {
    //     if ($(this).attr('checked')) {
    //         $(this).closest('.alert').find(':input').not(this).prop('disabled', true);
    //         $(this).attr('checked',false);
    //     } else {
    //         $(this).closest('.alert').find(':input').not(this).prop('disabled', false);
    //         $(this).attr('checked',true);
    //     }
    // });

    // $('.multipleSelect').fastselect();
    // $('.multipleSelect').fastselect();

    // var countries = [
    //     {value: 'Andorra', data: 'AD'},
    //     {value: 'Zimbabwe', data: 'ZZ'},
    //     {value: 'Zimbabwe', data: 'ZZ'},
    //     {value: 'Zimbabwe', data: 'ZZ'},
    //     {value: 'Zimbabwe', data: 'ZZ'}
    // ];
    // $('#autocomplete').autocomplete({
    //     lookup: countries,
    //     tabDisabled: true,
    //     triggerSelectOnValidInput: false,
    //     onSelect: function (suggestion) {
    //         // $(element).prop('disabled', true);
    //         // $.extend(Useful.obj, suggestion.data);
    //         // $(second).closest('div').removeClass('not-visible');
    //         console.log(suggestion);
    //     }
    // });

});