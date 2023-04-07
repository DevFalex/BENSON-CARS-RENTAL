  jQuery(function($) {
    $.noConflict();
    var tooltip = $('<div class="tooltipp" />');
    $(".slider-range").each(function() {
      var mins     = $(this).attr('data-date-min');
      var maxs     = $(this).attr('data-date-max');
      var remain   = $(this).attr('data-date-deff'); 
      var show_tip = $(this).attr('data-show-tip');
      var start_date = maxs, end_date =  mins;
      var min_display = mins;
      var max_display = maxs;
      var current_date = new Date().getTime();
      if(getTime(start_date) <= getTime(end_date)) {
        min_display  = '09.09.2018';
        max_display  = '10.09.2018';
        current_date = new Date('10.09.2018').getTime();      
      }
        $(this).slider({
          range: true,
          disabled: true,
          min: new Date(min_display).getTime() / 1000,
          max: new Date(max_display).getTime() / 1000,
          step: 86400,
          values: [current_date / 1000, new Date(max_display).getTime() / 1000 ],
          slide: function( event, ui ) {
            $(this).parent().find("p input.car-expected-return").val( (new Date(ui.values[ 0 ] *1000).toDateString() ) + " - " + (new Date(ui.values[ 1 ] *1000)).toDateString() );
            $(this).parent().find("p input.label-expected-return").val( (new Date(mins).toDateString() ) + " - " + (new Date(ui.values[ 1 ] *1000)).toDateString() );
          }
          })
          if(show_tip=='true') {
            var date = new Date();
            $(this).find(".ui-slider-handle").append(tooltip);
            $(this).find(".ui-slider-handle .tooltipp").text((date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear() + ' | ' +remain);
          }
          $(this).parent().find("p input.car-expected-return").val( (new Date($(this).slider( "values", 0 )*1000).toDateString()) +
            " - " + (new Date($( this ).slider( "values", 1 )*1000)).toDateString());
          $(this).parent().find("p input.label-expected-return").val( (new Date(mins).toDateString()) +
            " - " + (new Date($( this ).slider( "values", 1 )*1000)).toDateString());
          $(this).find(".ui-slider-handle:last-child() div").remove();
        });

    $(".ui-slider-handle.ui-corner-all.ui-state-default").each(function() {
      var left = $(this).css("left");
      if(parseInt(left, 10) <= 250) {
        $(this).find('.tooltipp').addClass('override');
      }
      });
    });

  function getTime(d) {
    return new Date(d.split("-").reverse().join("-")).getTime();
  }  





// $(document).ready(function() {
//     guageBar('intensityGuage', 'intensity');
// });
// function guageBar(guageId, inputId) {
//     $("#" + guageId).slider({
//         value: 1,
//         min: 1,
//         max: 10,
//         step: 1,
//         slide: function(event, ui) {
//             $("#" + inputId).val(ui.value);
//         }
//     });
//     $("#" + inputId).val($("#" + guageId).slider("value"));
// }​