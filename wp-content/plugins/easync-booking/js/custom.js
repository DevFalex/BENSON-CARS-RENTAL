var temporary_data = [];
var temp_data = [];
var tempry_data = [];
var temporaryy_data  = [];
var temp_storage = [];
var temprary_data = [];
var check_total = 0;
var check_subtotal = 0;
var error_trap1 = 0;
var with_driver = '';
var temporary_entry = [];
var temporary_entryy = [];

jQuery(function($) {
    $.noConflict();
    $('.modall').on('shown.bs.modal', function (e) {
        if($('body').hasClass('wp-admin')==false) {
            $('body').removeClass('modal-open');
            $('html').css('overflow-y', 'hidden');
            $('html').addClass('modal-open');
        }
    })

    $('.modall').on('hidden.bs.modal', function (e) {
        if($('body').hasClass('wp-admin')==false) {
            $("body").removeClass('modal-open');
            $("body").css("overflow-y", "hidden");
            $("html").css("overflow-y", "scroll");
            $('html').removeClass('modal-open');
        }
    })

    $('.sync-modal-personal-info').appendTo(document.body);
    $('.sync_price_money_format').blur();

    if($('.sync_form_wrapper').width() < 1090) {
        $('.sync_form_wrapper').addClass('div-size-1090');
    }

    if($('.sync_form_wrapper').width() < 1085) {
        $('.sync_form_wrapper').addClass('div-size-1085');
    }

    if($('.sync_form_wrapper').width() < 1070) {
        $('.sync_form_wrapper').addClass('div-size-1070');
    }

    if($('.sync_form_wrapper').width() < 1016) {
        $('.sync_form_wrapper').addClass('div-size-1016');
    }
    
    if($('.sync_form_wrapper').width() < 1015) {
        $('.sync_form_wrapper').addClass('div-size-1015');
    }

    if($('.sync_form_wrapper').width() < 985) {
        $('.sync_form_wrapper').addClass('div-size-985');
    }

    if($('.sync_form_wrapper').width() < 894) {
        $('.sync_form_wrapper').addClass('div-size-894');
    }

    if($('.sync_form_wrapper').width() < 865) {
        $('.sync_form_wrapper').addClass('div-size-865');
    }

    if($('.sync_form_wrapper').width() < 752) {
        $('.sync_form_wrapper').addClass('div-size-752');
    }

    if($('.sync_form_wrapper').width() < 740) {
        $('.sync_form_wrapper').addClass('div-size-740');
    }

    if($('.sync_form_wrapper').width() < 670) {
        $('.sync_form_wrapper').addClass('div-size-670');
    }

    if($('.sync_form_wrapper').width() < 510) {
        $('.sync_form_wrapper').addClass('div-size-510');
    }

    if($('.sync_form_wrapper').width() < 480) {
        $('.sync_form_wrapper').addClass('div-size-480');
    }

    if($('.sync_form_wrapper').width() < 353) {
        $('.sync_form_wrapper').addClass('div-size-353');
    }

    if($('.sync_form_wrapper').width() < 340) {
        $('.sync_form_wrapper').addClass('div-size-340');
    }

    $(window).on('resize', function(){
        if($('.sync_form_wrapper').width() > 340) {
            $('.sync_form_wrapper').removeClass('div-size-340');
        }
        if($('.sync_form_wrapper').width() > 353) {
            $('.sync_form_wrapper').removeClass('div-size-353');
        }
        if($('.sync_form_wrapper').width() > 480) {
            $('.sync_form_wrapper').removeClass('div-size-480');
        }
        if($('.sync_form_wrapper').width() > 510) {
            $('.sync_form_wrapper').removeClass('div-size-510');
        }
        if($('.sync_form_wrapper').width() > 670) {
            $('.sync_form_wrapper').removeClass('div-size-670');
        }
        if($('.sync_form_wrapper').width() < 1090) {
            $('.sync_form_wrapper').removeClass('div-size-1090');
        }
        if($('.sync_form_wrapper').width() > 1085) {
            $('.sync_form_wrapper').removeClass('div-size-1085');
        }
        if($('.sync_form_wrapper').width() > 1070) {
            $('.sync_form_wrapper').removeClass('div-size-1070');
        }
        if($('.sync_form_wrapper').width() > 1016) {
            $('.sync_form_wrapper').removeClass('div-size-1016');
        }
        if($('.sync_form_wrapper').width() > 1015) {
            $('.sync_form_wrapper').removeClass('div-size-1015');
        }
        if($('.sync_form_wrapper').width() > 985) {
            $('.sync_form_wrapper').removeClass('div-size-985');
        }
        if($('.sync_form_wrapper').width() > 894) {
            $('.sync_form_wrapper').removeClass('div-size-894');
        }
        if($('.sync_form_wrapper').width() > 865) {
            $('.sync_form_wrapper').removeClass('div-size-865');
        }
        if($('.sync_form_wrapper').width() > 752) {
            $('.sync_form_wrapper').removeClass('div-size-752');
        }
        if($('.sync_form_wrapper').width() > 740) {
            $('.sync_form_wrapper').removeClass('div-size-740');
        }
    });

    $("#datepicker_car_rental_return").on('keydown paste', function(e){
        e.preventDefault();
    });

    $(document).ready(function () {
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            startDate: ""
        }).on('changeDate', function(){
            $(".datepicker.datepicker-dropdown").css("display","none");
        }); 
    
        $('[data-toggle="datepicker_expiration"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            startDate: now
        }).on('changeDate', function(){
            $(".datepicker.datepicker-dropdown").css("display","none");
        }); 
    
        $('[data-toggle="car-datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            startDate: now
        }).on('changeDate', function(){
            $(".datepicker.datepicker-dropdown").css("display","none");
        }); 
    
        $('[data-toggle="datepicker-hotel"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            startDate: now
        }).on('changeDate', function(){
            $(".datepicker.datepicker-dropdown").css("display","none");
        }); 
    
        $('[data-toggle="datepicker-date"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            startDate: now
        }).on('changeDate', function(){
            $(".datepicker.datepicker-dropdown").css("display","none");
        }); 
        // end here
    
        if($('#datepicker_car_rental_pick').val()=="") {
            $('#datepicker_car_rental_pick').datepicker("setDate", now);
        }
    });

    // to be placed in main js (include the above variable now)

    var disableDates = [];
    var indexes      = [];
    var disableDays  = "";
    var now          = new Date();
    $(document).ready(function () {
        $.ajax({
            type        : 'GET',
            url         : easync_admin_ajax_directory.ajaxurl,
            data        : "action=easync_get_dates", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data) {
                    console.log('Something wrong!');
            }else{
                for (let i = 0; i < data.length-1; i++) {
                    disableDates.push(data[i]);
                }
                var days_list = data[data.length-1];
                for (j = 0; j < days_list.length; j++) {
                    if (days_list[j] == 'true') {
                        indexes.push(j);
                    }
                }
                disableDays = indexes.join();
                
                $('.docs-datepicker-container').datepicker({
                    inline: true,
                    zIndex: 2048,
                    startDate: now,
                    todayHighlight: true,
                    datesDisabled: disableDates,
                    daysOfWeekDisabled: disableDays,
                }).on('changeDate', function(e){
                    $('.docs-date').val(e.format('mm/dd/yyyy'))
                });
            }
        });
    });
    

    $('[data-toggle="car-datepicker"]').change(function(){
        
        if(new Date($('#datepicker_car_rental_pick').val()) >= new Date($('#datepicker_car_rental_return').val())) {//compare end <=, not >=
            var date_return_overrider = new Date($('#datepicker_car_rental_pick').val());
            var new_date = (date_return_overrider.getMonth() + 1) + '/' + (date_return_overrider.getDate() + 1) + '/' +  date_return_overrider.getFullYear();
            $('#datepicker_car_rental_return').val(new_date);
        }
        $('[data-toggle="car-min-datepicker"]').datepicker('destroy');
            var disabledate = $('#datepicker_car_rental_pick').val();
            var disabledate2 = new Date(disabledate);
            disabledate2.setDate(disabledate2.getDate()+1);
            $('[data-toggle="car-min-datepicker"]').datepicker({
                autoHide: true,
                zIndex: 2048,
                startDate: disabledate2
            }).on('changeDate', function(){
                $(".datepicker.datepicker-dropdown").css("display","none");
            }); 
    });

    if($('[data-toggle="car-datepicker"]').val()!="") {
        $('[data-toggle="car-min-datepicker"]').datepicker('destroy');
            var disabledate = $('#datepicker_car_rental_pick').val();
            var disabledate2 = new Date(disabledate);
            disabledate2.setDate(disabledate2.getDate()+1);
            $('[data-toggle="car-min-datepicker"]').datepicker({
                autoHide: true,
                zIndex: 2048,
                startDate: disabledate2
            }).on('changeDate', function(){
                $(".datepicker.datepicker-dropdown").css("display","none");
            }); 
    }

    function remove_error() {
        $('.personal-info.firstname .error').remove();
        $('.personal-info.lastname .error').remove();
        $('.personal-info.phone .error').remove();
        $('.personal-info.email-address .error').remove();
        $('.personal-info.driver-name .error').remove();
        $('.personal-info.driver-phone .error').remove();
        $('#filediv1 .error').remove();
        $('#filediv2 .error').remove();
        $('.address_1 .error.error-address-1').remove();
        $('.address_2 .error.error-address-2').remove();
        $('.province .error.error-province').remove();
        $('.city .error.error-city').remove();
        $('.postal-code .error.error-postal').remove();
        $('.sync_restau_holder_name .error.error-name').remove();
        $('.sync_restau_holder_email .error.error-email-address').remove();
        $('.sync_restau_holder_phone .error.error-phone').remove();
        $('.sync_restau_holder_branch .error.error-branch').remove();
        $('.table_guest .error.error-guest').remove();
        $('.sync-table .error.error-table').remove();
        $('.timeslot .error.error-timeslot').remove();
        $('.docs-datepicker-container .error.error-picked-date').remove();
        $('#restau_menu_info  .error-pick-item').remove();
    }

    // to be placed in the main js file
    $('#sync_reserved_event').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/reserved-event.php',
            data        : $(this).serialize()+"&action=easync_reserved_event", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                 console.log('Something wrong!');
            }else{
                //location.reload();
                var sync_calendar = '';
                switch(data.typee) {
                    case 'hotel':
                        sync_calendar = '#sync_hotel_calendar';
                        break;
                    case 'car':
                        sync_calendar = '#sync_car_rental_calendar';
                        break;
                    case 'restau':
                        sync_calendar = '#sync_restau_calendar';
                        break;    
                    default:
                         console.log('Something wrong!');
                }

                $.ajax({
                    type     : 'GET',
                    url      : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/calendar-query.php',
                    data     : "type="+data.typee+"&action=easync_calendar_query", 
                    dataType : 'json', 
                    encode   : true
                }).done(function(data) {
                    if (!data.success) {
                         console.log('Something wrong!');
                    }else{
                        var events = new Array();
                        for (var i = 0; i < data.count; i++) {
                            if(data.typeee =='restau') {
                                events[i] = {
                                    'title':data.event[i][0]['name'], 
                                    'start':data.event[i][0]['start'],
                                    'allDay': false,
                                    'description': data.event[i][0]['description'],
                                    'backgroundColor': data.event[i][0]['backgroundColor']
                                };
                            } else {
                                events[i] = {
                                    'title':data.event[i][0]['lastname']+', '+data.event[i][0]['firstname'], 
                                    'start':data.event[i][0]['start'],
                                    'end'  :data.event[i][0]['end'],
                                    'allDay': false,
                                    'description': data.event[i][0]['description'],
                                    'backgroundColor': data.event[i][0]['backgroundColor']
                                };
                            }
                        }
                        
                        $(sync_calendar).fullCalendar( 'removeEvents');
                        $(sync_calendar).fullCalendar('addEventSource', events);
                        $(sync_calendar).fullCalendar('refetchEvents');

                    }
                });
                $('#single_view_entry_modal .close').click();
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });
    // end here

    $('#months-tab').on('click', function() {
        // get month from the tab. Get the year from the current fullcalendar date
        var month = $(this).find(":selected").attr('data-month'),
            year = $("#sync_hotel_calendar").fullCalendar('getDate').format('YYYY');
        
        var m = moment([year, month, 1]).format('YYYY-MM-DD');
        
        $('#sync_hotel_calendar').fullCalendar('gotoDate', m );
    });

    $('#months-tab').change(function() {
        // get month from the tab. Get the year from the current fullcalendar date
        var month = $(this).find(":selected").attr('data-month'),
            year = $("#sync_hotel_calendar").fullCalendar('getDate').format('YYYY');
        
        var m = moment([year, month, 1]).format('YYYY-MM-DD');
        
        $('#sync_hotel_calendar').fullCalendar('gotoDate', m );
    });

    // go to prev year
    $("#prev-year").on('click', function() {
        $('#sync_hotel_calendar').fullCalendar( 'prevYear' );
    });

    $("#next-year").on('click', function() {
        $('#sync_hotel_calendar').fullCalendar( 'nextYear' );
    });

        // change month
    $('#months-tab2').on('click', function() {
        // get month from the tab. Get the year from the current fullcalendar date
        var month = $(this).find(":selected").attr('data-month'),
            year = $("#sync_car_rental_calendar").fullCalendar('getDate').format('YYYY');
        var m = moment([year, month, 1]).format('YYYY-MM-DD');
        
        $('#sync_car_rental_calendar').fullCalendar('gotoDate', m );
    });

    $('#months-tab2').change(function() {
        // get month from the tab. Get the year from the current fullcalendar date
        var month = $(this).find(":selected").attr('data-month'),
            year = $("#sync_car_rental_calendar").fullCalendar('getDate').format('YYYY');
        
        var m = moment([year, month, 1]).format('YYYY-MM-DD');
        
        $('#sync_car_rental_calendar').fullCalendar('gotoDate', m );
    });
    // go to prev year
    $("#prev-year2").on('click', function() {
        $('#sync_car_rental_calendar').fullCalendar( 'prevYear' );
    });

    $("#next-year2").on('click', function() {
        $('#sync_car_rental_calendar').fullCalendar( 'nextYear' );
    });
         // change month
    $('#months-tab3').on('click', function() {
        // get month from the tab. Get the year from the current fullcalendar date
        var month = $(this).find(":selected").attr('data-month'),
            year = $("#sync_restau_calendar").fullCalendar('getDate').format('YYYY');
        var m = moment([year, month, 1]).format('YYYY-MM-DD');
        
        $('#sync_restau_calendar').fullCalendar('gotoDate', m );
    });

    $('#months-tab3').change(function() {
        // get month from the tab. Get the year from the current fullcalendar date
        var month = $(this).find(":selected").attr('data-month'),
            year = $("#sync_restau_calendar").fullCalendar('getDate').format('YYYY');
        var m = moment([year, month, 1]).format('YYYY-MM-DD');
        
        $('#sync_restau_calendar').fullCalendar('gotoDate', m );
    });

    // go to prev year
    $("#prev-year3").on('click', function() {
        $('#sync_restau_calendar').fullCalendar( 'prevYear' );
    });

    $("#next-year3").on('click', function() {
        $('#sync_restau_calendar').fullCalendar( 'nextYear' );
    });
    
    //restaurant//
    $('#sync_restau_thank_u').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_restau_thanks&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_restau_privacy').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_restau_privacy&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_restau_terms').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_restau_terms&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                    console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_restau_banner_image').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_banner_image&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                    console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_restau_email_head_notify').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_restau_email_head_notify&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                    console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_restau_email_foot_notify').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_restau_email_foot_notify&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                    console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_car_email_head_notify').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_car_email_head_notify&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                    console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_car_email_foot_notify').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_car_email_foot_notify&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                    console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    if(easync_admin_check_login.login==1 && easync_admin_check_page.pageIs=='load') {
        $.ajax({
            type        : 'GET',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/calendar-query.php',
            data        : "type=restau&action=easync_calendar_query", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                console.log('Something wrong!');
            }else{
                var temp_event = new Array();
                for (var i = 0; i < data.count; i++) {
                    temp_event[i] = {
                        'title':data.event[i][0]['name'], 
                        'start':data.event[i][0]['start'],
                        'allDay': false,
                        'description': data.event[i][0]['description'],
                        'backgroundColor': data.event[i][0]['backgroundColor']
                    };
                }
                 var source = { 
                    header: {
                        left: null,
                        center: 'title',
                        right: 'prev,next today'
                    },
                    defaultDate: new Date(),
                    navLinks: false, // can click day/week names to navigate views
                    editable: false,
                    eventLimit: true, // allow "more" link when too many events
                    eventMouseover: function (data, event, view) {
                        
                        tooltip = '<div class="sync_calendar_schedule tooltiptopicevent">' 
                        + data.title
                        + '</div>';
                        $("body").append(tooltip);
                        $(this).mouseover(function (e) {
                            $(this).css('z-index', 10000);
                            $('.tooltiptopicevent').fadeIn('500');
                            $('.tooltiptopicevent').fadeTo('10', 1.9);
                        }).mousemove(function (e) {
                            $('.tooltiptopicevent').css('top', e.pageY + 10);
                            $('.tooltiptopicevent').css('left', e.pageX + 20);
                        });
                    },
                    eventMouseout: function (data, event, view) {
                        $(this).css('z-index', 8);
                        $('.tooltiptopicevent').remove();
                    },
                    eventClick: function(data, event, view) {

                        $('.sync_calendar_single_view').attr({
                            'data-values'    : data.description.split('+')[0],
                            'data-label'     : data.description.split('+')[1],
                            'data-id'        : data.description.split('+')[2],
                            'data-dismiss'   : 'modal',
                            'data-toggle'    : 'modal',
                            'data-targett'    : '#single_view_entry_modal',
                            'data-backdrop'  : 'static',
                            'data-keyboard'  : 'false' 
                        });
                        var values = $('.sync_calendar_single_view').attr('data-values').split('<>');
                        var labels = $('.sync_calendar_single_view').attr('data-label').split('<>');
                        var id = $('.sync_calendar_single_view').attr('data-id');
                        var append="";
                        $.each( values, function( key, value ) {     
                            if(labels[key]=='Driver license') {
                                var temp='';
                                $.each( value.split("|"), function( key, path ) { 
                                   temp += '<a data-fancybox="gallery" href="'+path+'"><img src="'+path+'"></a>';
                                });
                                append += '<div class="data-row row-license-image"><span>'+labels[key]+'</span>'+temp+'</div>';
                            }else if(value.length<30 && value.indexOf("qty") == -1){
                                append += '<div class="data-row"><span>'+labels[key]+'</span><span>'+value+'</span></div>';
                            }else if(value.indexOf("qty") != -1){
                                append += '<div class="data-row"><span>'+labels[key]+'</span><p style="text-align:right; font-size: 1rem;">'+value+'</p></div>';
                            }else{
                                append += '<div class="data-row"><span>'+labels[key]+'</span><p style="text-align:right; font-size: 1rem;">'+value+'</p></div>';
                            }
                            
                        });

                        // Fix passed bookings still being able to start
                        var today = moment(new Date());
                        var diff = today.diff(data.start, 'days'); // Calculate date today and start date

                        $('#sync_activator').text('');
                        var reserved_option = '';
                        $('#sync_activator').css('display', 'block');
                        $('#sync_activator').attr('disabled', false);

                        // Fix passed bookings still being able to start
                        if( diff > 0 && (reserved_option != 'trash') ) { // Hide button if days > 1
                            $('#sync_activator').hide();
                            reserved_option = 'trash';
                        }

                        if(values[0]=='Pending') {
                            $('#sync_activator').text('Start');
                            reserved_option = 'active';
                        }else if(values[0]=='Active') {
                            $('#sync_activator').text('End');
                            reserved_option = 'inactive';
                        }else if(values[0]=='Inactive'){
                            $('#sync_activator').text('Trash');
                            reserved_option = 'trash';
                        }else{
                            $('#sync_activator').text('Deleted');
                            $('#sync_activator').attr('disabled', true);
                            $('#sync_activator').css('display', 'none');
                        }    

                        $('#sync_reserved_event input[name="type"]').val('restau');
                        $('#sync_reserved_event input[name="reserve_event_id"]').val(id);
                        $('#sync_reserved_event input[name="reserve_event_option"]').val(reserved_option);
                        $('.data-container').text('');
                        $('.data-container').append(append);
                        $('.sync_calendar_single_view').click();
                    },
                    dayClick: function () {
                        //tooltip.hide();
                    },
                    eventResizeStart: function () {
                        tooltip.hide();
                    },
                    eventDragStart: function () {
                        tooltip.hide();
                    },
                    viewDisplay: function () {
                        tooltip.hide();
                    },
                    events: temp_event
            };
                $('#sync_restau_calendar').fullCalendar( source );
            }
        });
    }
    
    try {
     $('.branch_location').select2({placeholder: "",allowClear: true});
    }
    catch(err) {
      console.log('please set for configuration in restaurant modules')
    }
    $('.timeslot .timeslot-box .timeslot-item').on('click', function() {
        $('.timeslot .timeslot-box .timeslot-item').removeClass('active');
      if($(this).hasClass('active')==true) {
        $(this).removeClass('active');
      }else{
        $(this).addClass('active');
        $('.preferred-timeslot').val($(this).find('input').val());
      }
    });

    $('#restau_menu_info .fourth-row :input').change(function () {
        if(error_trap1==0) {
            var direction      = this.defaultValue < parseInt(this.value);
            this.defaultValue  = this.value;
            var val     = $(this).parent().parent().parent().find('.list-row.fourth-row p:nth-child(2) span:nth-child(2)').text();
            var new_val = $(this).parent().parent().parent().find('.list-row.fourth-row p:last-child() span').text();
            val = Number(val.replace(/[^0-9\.]+/g, ""));
            new_val = Number(new_val.replace(/[^0-9\.]+/g, ""));
            var disc_text = $('#restau_menu_info .discount_amount_restau').text();
            var disc_amount = disc_text.split(" ").splice(-1)[0];
            var currency = $('#restau_menu_info .sync_currency_code').val();

            if(direction){
                check_subtotal = (val*(this).value);
                $(this).parent().parent().parent().find('.list-row.fourth-row p:last-child() span').text(toCurrency(check_subtotal));
                check_total += val;
            }
            if(!direction) {
                if(new_val > val) {
                    check_subtotal = new_val-parseFloat(val);
                    $(this).parent().parent().parent().find('.list-row.fourth-row p:last-child() span').text(toCurrency(check_subtotal));
                    check_total -= val;
                }
            }    
            
            var d_check_total  = check_total;
            var discounted_amount = d_check_total - disc_amount;

            $('#restau_menu_info .book-summary-total p span.sync_price_money_format').text(toCurrency(d_check_total));  
            $('#restau_menu_info .book-summary-total p span.final_amount_restau').text(currency + ' ' + toCurrency(discounted_amount)); 
            if ((disc_amount == 0) || (disc_amount == "")) {
                $('#restau_menu_info .customer-info .second-row .sync_components .book-summary-payment .payment #amount_to_pay_restau').val(toCurrency(d_check_total)); 
            } else {
                $('#restau_menu_info .customer-info .second-row .sync_components .book-summary-payment .payment #amount_to_pay_restau').val(toCurrency(discounted_amount)); 
            }  
        }
        error_trap1=0;     
    });

    $('#restau_menu_info .special-request-field + label').on('click', function(){
        $('.error.error-pick-item').remove();
        error_trap1 = 1;
        var price = $(this).parent().parent().find('.list-row.fourth-row p:nth-child(2) span:nth-child(2)').text();  
        var qty   = parseInt($(this).parent().parent().find('.fourth-row p:first-child input').val());
        var currency = $('#restau_menu_info .sync_currency_code').val();
        price = Number(price.replace(/[^0-9\.]+/g, ""));

        if($(this).hasClass('active')==true) {
            var disc_text = $('#restau_menu_info .discount_amount_restau').text();
            var disc_amount = disc_text.split(" ").splice(-1)[0];
            // $('#restau_continue_payment .final_amount_restau').hide();
            $(this).parent().parent().find('.fourth-row p:first-child .quantity-nav').css('display', 'none');
            $(this).parent().find('input').prop('checked', false);
            $(this).parent().parent().find('.fourth-row p:first-child input').prop('disabled', true);
            $(this).parent().parent().find('.fourth-row p:last-child() span').text('0.00');

            check_total -= (price * qty);
            if(check_total < 0)
                check_total = 0;
        } else {
            var disc_text = $('#restau_menu_info .discount_amount_restau').text();
            var disc_amount = disc_text.split(" ").splice(-1)[0]; 
            // $('#restau_continue_payment .final_amount_restau').show();
            $(this).parent().parent().find('.fourth-row p:first-child .quantity-nav').css('display', 'block');
            $(this).parent().find('input').prop('checked', true);
            $(this).parent().parent().find('.fourth-row p:first-child input').prop('disabled', false);
            $(this).parent().parent().find('.fourth-row p:last-child() span').text(price.toFixed(2));
            check_total += (price * qty);
            
        }

        var check_totals = check_total.toFixed(2);
        var total_w_discount = check_totals - disc_amount;
        var final_amt = total_w_discount.toFixed(2);
        var d_check_total  = check_total;

        $('#restau_menu_info .book-summary-total p span.sync_price_money_format').text(toCurrency(d_check_total));
        $('#restau_menu_info .final_amount_restau').text( currency + " " + final_amt);
        $('#restau_menu_info .customer-info .second-row .sync_components .book-summary-payment .payment #amount_to_pay_restau').val(final_amt); 
        
    });

    $('.special-request .second-row img').on('click', function() {
        $(this).parent().parent().find('.first-row .special-request-field + label').click();
    });

    $('#restau_continue_payment').on('submit', function(event) { 
        event.preventDefault();
        var id = this.id;
        $('body').loading();
        $('.modall').css('z-index', '0');

        if ( id == 'restau_continue_payment') {
            $.ajax({
                type        : 'POST',
                url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/validation.php',
                data        : $(this).serialize()+ "&type=restau&action=easync_validation", 
                dataType    : 'json', 
                encode      : true
            }).done(function(data) {
                $('body').loading('stop');
                $('.modall').css('z-index', '');
                if (!data.success) {
                    remove_error();
                    if (data.errors.menu_ids) {
                        $('#restau_continue_payment #tab').append('<div class="error error-pick-item active">' + data.errors.menu_ids + '</div>'); 
                    }
                }else{
                    /*menu ids*/
                    temporary_data[0]  = data['name'];
                    temporary_data[1]  = data['email_add'];
                    temporary_data[2]  = data['phone_no'];
                    temporary_data[3]  = data['branch'];
                    temporary_data[4]  = data['guest_no'];
                    temporary_data[5]  = data['table_no'];
                    temporary_data[6]  = data['timeslot'];
                    temporary_data[7]  = data['picked_date'];
                    temporary_data[8]  = data['reserved'];
                    temporary_entry    = [];
                    temporary_entry[0] = [];
                    temporary_entry[1] = [];
                    temporary_entry[2] = [];
                    temporary_entry[3] = [];
                    temporary_entry[4] = [];
                    temporary_entry[5] = [];
                    temporary_data[14] = data['reference_num'];
                    temporary_data[15] = data['amount_to_pay'];
                    temporary_data[17] = data['paypal_dis_price'];
                    temporary_data[18] = data['paypal_dis'];
                    temporary_data[19] = data['item_qty'];
                    temporary_data[20] = data['table_ids'];

                    $.each( data.items, function( key, value ) {
                      $('.sync_payment_display').prepend('<input type="hidden" name="item_name_'+(key+1)+'" value="'+value+'">');
                      temporary_entry[0][key] = value;
                    });
                    $.each( data.item_qtys, function( key, value ) {
                      $('.sync_payment_display').prepend('<input type="hidden" name="item_number_'+(key+1)+'" value="'+value+'">');
                      temporary_entry[1][key]  = value;  
                    });
                    $.each( data.item_prices, function( key, value ) {
                      $('.sync_payment_display').prepend('<input type="hidden" name="amount_'+(key+1)+'" value="'+value+'">');
                      temporary_entry[2][key]  = (value / temporary_entry[1][key]);  
                    });
                    temporary_entry[3] = data['amount_to_pay'];
                    temporary_entry[4] = data['item_qty'];
                    item_qty = temporary_entry[4];
    
                    temporary_entry[5].push(data['amount_to_pay']);
    
                    $('.restau-continue-payment').attr({
                        'type'           : 'button',
                        'data-dismiss'   : 'modal',
                        'data-toggle'    : 'modal',
                        'data-targett'   : '#restau_customer_payment',
                        'data-backdrop'  : 'static',
                        'data-keyboard'  : 'false' 
                    });
                    $('.restau-continue-payment').click();
                    $('.restau-continue-payment').attr({
                        'type'           : 'submit'
                    });
                    $('.restau-continue-payment').removeAttr('data-dismiss');
                    $('.restau-continue-payment').removeAttr('data-toggle');
                    $('.restau-continue-payment').removeAttr('data-targett');
                    $('.restau-continue-payment').removeAttr('data-backdrop');
                    $('.restau-continue-payment').removeAttr('data-keyboard');
                } 
            });
        }
    });
    
    $('#restau_pay_now').on('submit', function(event) {
        temporary_entry[4] = 'fail';
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/validation.php',
            data        : $(this).serialize()+"&type=restau-payment&action=easync_validation",
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                $('body').loading('stop');
                $('.modall').css('z-index', '');
                remove_error();
                var genError = "This field is required.";
                if (data.errors.address_1) {
                    $('.billing-address-info .address_1').append('<div class="error error-address-1 active">' + genError + '</div>'); 
                }else{
                    $('.billing-address-info .address_1').append('<div class="error error-address-1 ok active"> OK </div>');
                }
                if (data.errors.address_2) {
                    $('.billing-address-info .address_2').append('<div class="error error-address-2 active">' + genError + '</div>'); 
                }else{
                    $('.billing-address-info .address_2').append('<div class="error error-address-2 ok active"> OK </div>');
                }
                if (data.errors.province) {
                    $('.billing-address-info .province').append('<div class="error error-province active">' + genError + '</div>'); 
                }else{
                    $('.billing-address-info .province').append('<div class="error error-province ok active"> OK </div>');
                }
                if (data.errors.city) {
                    $('.billing-address-info .city').append('<div class="error error-city active">' + genError + '</div>'); 
                }else{
                    $('.billing-address-info .city').append('<div class="error error-city ok active"> OK </div>');
                }
                if (data.errors.postal_code) {
                    $('.billing-address-info .postal-code').append('<div class="error error-postal active">' + genError + '</div>'); 
                }else{
                    $('.billing-address-info .postal-code').append('<div class="error error-postal ok active"> OK </div>');
                }

            } else {

                var temp_path = '.payment-info .billing-address .sync_components .billing-address-info';
                temporary_data[9]  = $(temp_path+' input[name="address_1"]').val();
                temporary_data[10] = $(temp_path+' input[name="address_2"]').val();
                temporary_data[11] = $(temp_path+' input[name="city"]').val();
                temporary_data[12] = $(temp_path+' input[name="province"]').val();
                temporary_data[13] = $(temp_path+' input[name="postal_code"]').val();
                
                var formData = {
                    'type'                 : 'restau',
                    'name'                 : temporary_data[0],
                    'email'                : temporary_data[1],
                    'phone_no'             : temporary_data[2],
                    'branch'               : temporary_data[3],
                    'guest_no'             : temporary_data[4],
                    'table_no'             : temporary_data[5],
                    'timeslot'             : temporary_data[6],
                    'picked_date'          : temporary_data[7],
                    'menu_ids'             : temporary_data[8],
                    'address_1'            : temporary_data[9],
                    'address_2'            : temporary_data[10],
                    'city'                 : temporary_data[11],
                    'province'             : temporary_data[12],
                    'postal_code'          : temporary_data[13],
                    'reference_number'     : temporary_data[14],
                    'amount_to_pay_restau' : temporary_data[15],
                    'item_prices'          : temporary_data[17],
                    'menu_reserved'        : temporary_data[18],
                    'item_qty_each'        : temporary_data[19],
                    'table_ids'            : temporary_data[20],
                    'action'               :'easync_session_store',
                };

                $.ajax({
                    type        : 'POST',
                    url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/session-store.php',
                    data        : formData, 
                    dataType    : 'json', 
                    encode      : true
                }).done(function(data) {
                    if (!data.success) {
                            console.log('Something wrong!');
                    }else{
                        temporary_data  = [];
                        $('.restau-pay-now').attr({
                            'type'           : 'button',
                            'data-dismiss'   : 'modal',
                            'data-toggle'    : 'modal',
                            'data-targett'    : '#restau_thank_you_modal',
                            'data-backdrop'  : 'static',
                            'data-keyboard'  : 'false' 
                        });
                        //$('.restau-pay-now').click();
                        $('.restau-pay-now').attr({
                            'type'           : 'submit'
                        });
                        $('.restau-pay-now').removeAttr('data-dismiss');
                        $('.restau-pay-now').removeAttr('data-toggle');
                        $('.restau-pay-now').removeAttr('data-targett');
                        $('.restau-pay-now').removeAttr('data-backdrop');
                        $('.restau-pay-now').removeAttr('data-keyboard');
                    }
                });
            }
        });
         event.preventDefault();
    });
    

    $('#restau_thank_you_modal .close').on('click', function(e) {
        location.reload();
    });

    if(easync_admin_check_login.login==1 && easync_admin_check_page.pageIs=='load') {
    	//car rental//
        $.ajax({
            type        : 'GET',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/calendar-query.php',
            data        : "type=car&action=easync_calendar_query", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                console.log('Something wrong!');
            }else{
                var temp_event = new Array();
                for (var i = 0; i < data.count; i++) {
                    temp_event[i] = {
                        'title':data.event[i][0]['lastname']+', '+data.event[i][0]['firstname'], 
                        'start':data.event[i][0]['start'],
                        'end'  :data.event[i][0]['end'],
                        'allDay': false,
                        'description': data.event[i][0]['description'],
                        'backgroundColor': data.event[i][0]['backgroundColor']
                    };
                }
                 var source = { 
                    header: {
                        left: null,
                        center: 'title',
                        right: 'prev,next today'
                    },
                    defaultDate: new Date(),
                    navLinks: false, // can click day/week names to navigate views
                    editable: false,
                    eventLimit: true, // allow "more" link when too many events
                    eventMouseover: function (data, event, view) {
                        
                        tooltip = '<div class="sync_calendar_schedule tooltiptopicevent">' 
                        + data.title
                        + '</div>';
                        $("body").append(tooltip);
                        $(this).mouseover(function (e) {
                            $(this).css('z-index', 10000);
                            $('.tooltiptopicevent').fadeIn('500');
                            $('.tooltiptopicevent').fadeTo('10', 1.9);
                        }).mousemove(function (e) {
                            $('.tooltiptopicevent').css('top', e.pageY + 10);
                            $('.tooltiptopicevent').css('left', e.pageX + 20);

                        });
                    },
                    eventMouseout: function (data, event, view) {
                        $(this).css('z-index', 8);
                        $('.tooltiptopicevent').remove();
                    },
                    eventClick: function(data, event, view) {

                        $('.sync_calendar_single_view').attr({
                            'data-values'    : data.description.split('+')[0],
                            'data-label'     : data.description.split('+')[1],
                            'data-id'        : data.description.split('+')[2],
                            'data-dismiss'   : 'modal',
                            'data-toggle'    : 'modal',
                            'data-targett'    : '#single_view_entry_modal',
                            'data-backdrop'  : 'static',
                            'data-keyboard'  : 'false' 
                        });
                        var values = $('.sync_calendar_single_view').attr('data-values').split('<>');
                        var labels = $('.sync_calendar_single_view').attr('data-label').split('<>'); 
                        var id     = $('.sync_calendar_single_view').attr('data-id'); 
                        var append="";
                        $.each( values, function( key, value ) {     
                            if(labels[key]=="Driver\'s License") {
                                var temp='';
                                $.each( value.split("|"), function( key, path ) { 
                                   temp += '<a data-fancybox="gallery" href="'+path+'"><img src="'+path+'"></a>';
                                });
                                append += '<div class="data-row row-license-image"><span>'+labels[key]+'</span>'+temp+'</div>';
                            }else if(value.length<30){
                                append += '<div class="data-row"><span>'+labels[key]+'</span><span>'+value+'</span></div>';
                            }else{
                                append += '<div class="data-row"><span>'+labels[key]+'</span><p>'+value+'</p></div>';
                            }
                        });

                        // Fix passed bookings still being able to start
                        var today = moment(new Date());
                        var diff = today.diff(data.start, 'days'); // Calculate date today and start date

                        $('#sync_activator').text('');
                        var reserved_option = '';
                        $('#sync_activator').css('display', 'block');
                        $('#sync_activator').attr('disabled', false);

                        // Fix passed bookings still being able to start
                        if( diff > 0 && (reserved_option != 'trash') ) { // Hide button if days > 1
                            $('#sync_activator').hide();
                            reserved_option = 'trash';
                        }

                        if(values[0].toLowerCase()=='pending') {
                            $('#sync_activator').text('Start');
                            reserved_option = 'active';
                        }else if(values[0].toLowerCase()=='active') {
                            $('#sync_activator').text('End');
                            reserved_option = 'inactive';
                        }else if(values[0].toLowerCase()=='inactive') {
                            $('#sync_activator').text('Trash');
                            reserved_option = 'trash';
                        }else{
                            $('#sync_activator').text('Deleted');
                            $('#sync_activator').css('display', 'none');
                            $('#sync_activator').attr('disabled', true);

                        }    

                        $('#sync_reserved_event input[name="type"]').val('car');
                        $('#sync_reserved_event input[name="reserve_event_id"]').val(id);
                        $('#sync_reserved_event input[name="reserve_event_option"]').val(reserved_option);
                        $('.data-container').text('');
                        $('.data-container').append(append);    
                        $('.sync_calendar_single_view').click();
                    },
                    dayClick: function () {
                        //tooltip.hide();
                    },
                    eventResizeStart: function () {
                        tooltip.hide();
                    },
                    eventDragStart: function () {
                        tooltip.hide();
                    },
                    viewDisplay: function () {
                        tooltip.hide();
                    },
                    events: temp_event
            };
                $('#sync_car_rental_calendar').fullCalendar( source );
            }
        });
    }
    
    try {
      $('#rental_pick_time').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false,format:'HH:mm'});
      $('#rental_return_time').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false,format:'HH:mm' });
      $('.rental_pick_location').select2({placeholder: "",allowClear: true});
      $('.rental_vehicle_type').select2({placeholder: "",allowClear: true});   
    }
    catch(err) {
      console.log('please set for configuration in car rental modules');
    }
    //$('.province-select').select2({placeholder: "Province",allowClear: true});
	$('.rent-driver + label').on('click', function() {
		$('.rent-driver + label').removeClass('active');
	  if($(this).hasClass('active')==true) {
	  	$(this).removeClass('active');
	  }else{
	  	$(this).addClass('active');
        $('.with_or_out_driver').val($(this).parent().find('input').val());
	  }
	});
    var car_name   = '';
    var subtotal   = '';
    var tax_value  = '';
    var fees_value = '';
    $('.book-car').on('click', function (e) {
        var car_id         =  $(this).parent().parent().parent().find('.result-item-details input.car-id').val();
        var deposit_amount =  $(this).parent().parent().parent().find('.result-item-details input.car-deposit').val();
        car_name           =  $(this).parent().parent().parent().find('.result-item-details h2').text();
        var car_type       =  $(this).parent().parent().parent().find('.result-item-details p.type span').text();
        var car_model      =  $(this).parent().parent().parent().find('.result-item-details p.model span').text();
        var car_price      =  $(this).parent().parent().parent().find('.result-image span span').text();
        var car_image      =  $(this).parent().parent().parent().find('.result-image img').prop('src');
        var rent_car_day   =  $('#car_customer_info .customer-info .first-row .sync_components .car-cost .date input').val();
        var tax            =  $(this).parent().parent().parent().find('.result-item-details input.car-tax').val();
        var fees           =  $(this).parent().parent().parent().find('.result-item-details input.car-fees').val();

        subtotal     =  (rent_car_day*Number(car_price.replace(/[^0-9\.-]+/g,"")));
        subtotal  = subtotal.toFixed(2);
        subtotal  = subtotal.toString().replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");

        total_deposit = (rent_car_day*Number(deposit_amount.replace(/[^0-9\.-]+/g,"")));
        total_deposit = total_deposit.toFixed(2);
        total_deposit = total_deposit.toString().replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");

        var tax_percent = +tax/100;
        tax_value = (subtotal*tax_percent);
        tax_value = tax_value.toFixed(2);
        tax_value = tax_value.toString().replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");

        var fees_percent = +fees/100;
        fees_value = (subtotal*fees_percent);
        fees_value = fees_value.toFixed(2);
        fees_value = fees_value.toString().replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");

        final_noDiscount = Number(subtotal);

        final_noDiscount = final_noDiscount.toFixed(2);

        var obj_facilities  =  $(this).parent().parent().parent().find('.result-item-details.car-details input.facilities-special-request').val();
        
        var specify_request =  $(this).parent().parent().parent().find('.result-item-details.car-details input.specify-special-request').val();

        var arr = obj_facilities.split(',');
        arr = arr.slice(0, -1);
        var facilities = '';
        $.each( arr, function( key, value ) {
          facilities += '<div class="personal-info">'
                     +  '<input type="checkbox" name="request_facilities[]" value="'+value+'" class="special-request-field">'
                     +  '<label>'+value+'</label></div>';
        });
        
        $('#car_customer_info .customer-info .second-row .sync_components .special-request-others label').css('display', 'none');
        $('#car_customer_info .customer-info .second-row .sync_components .special-request-others textarea').remove(); 
        if(specify_request=='Yes') {
            facilities += '<div class="personal-info">'
                       +  '<input type="checkbox" name="others" value="others" class="others-req special-request-field">'
                       +  '<label>Others</label></div>';
            var append = '<textarea placeholder=" " width="500" name="other_req"> </textarea>';   
            $('#car_customer_info .customer-info .second-row .sync_components .special-request-others label').css('display', 'block');
            $('#car_customer_info .customer-info .second-row .sync_components .special-request-others textarea').remove();  
            $(append).insertBefore('#car_customer_info .customer-info .second-row .sync_components .special-request-others label');
            // $('#car_customer_info .customer-info .second-row .sync_components .special-request-others').append(append);
        }

        var currency_code = $('.payment input[name="sync_currency_code"]').val();
        //reset temporary save//
        temporary_data     = [];
        //car id//
        temporary_data[0]  = car_id;
        if($('.with-or-without').val()=='self-driven') {
            $('.sync_with_driver_container').addClass('active');
            with_driver = 'self-driven';
        }else{
            $('.sync_with_driver_container').removeClass('active');
            with_driver = 'with driver';
        }
        $('#car_customer_info .customer-info .first-row .sync_components .car-profile .car-name h2').text(car_name);
        $('#car_customer_info .customer-info .first-row .sync_components .car-profile .car-name span.type').text('Type: '+car_type);
        $('#car_customer_info .customer-info .first-row .sync_components .car-profile .car-name span.model ').text(car_model);
        $('#car_customer_info .customer-info .first-row .sync_components .car-profile img').prop('src',car_image);
        $('#car_customer_info .customer-info .first-row .sync_components .car-cost .pricing-details p span').text(car_price);
        $('#car_customer_info .customer-info .second-row .sync_components .book-summary-subtotal p:first-child p').text(car_name);
        $('#car_customer_info .customer-info .second-row .sync_components .book-summary-subtotal p:first-child span').text(currency_code+' '+subtotal);
        $('#car_customer_info .customer-info .second-row .sync_components .book-summary-total p span.total_noDiscount_car').text(currency_code+' '+subtotal);           
        $('#car_customer_info .customer-info .second-row .sync_components .book-summary-total p .final_noDiscount_car').text(currency_code+' '+final_noDiscount);             
        $('#car_customer_info .customer-info .second-row .sync_components .book-summary-subtotal p strong').text(car_name);
        $('#car_customer_info .customer-info .second-row .sync_components .book-summary-payment .payment .amount_to_pay_car').val(final_noDiscount);
        $('#car_customer_info .customer-info .second-row .sync_components .book-summary-payment .payment .car_post_id').val(car_id);
        $('#car_customer_info .customer-info .second-row .sync_components .special-request .special-request-holder').text('');
        $('#car_customer_info .customer-info .second-row .sync_components .special-request .special-request-holder').append(facilities);
    });

    $('#car_continue_payment').on('submit', function(event) {
        event.preventDefault();
        $('body').loading();
        $('.modall').css('z-index', '0');
        var id = this.id;
        var is_require = jQuery('.payment .is_required').val();
        var data_value = "";
        var data_value_stripe = "";
        var data_value_authorize = "";
        

        if (is_require == 'on') {
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            var file1 = document.getElementById("file1").value;
            var file2 = document.getElementById("file2").value;
            var image_empty1 = '';
            var image_empty2 = '';
            if(document.getElementById("file1").files.length == 0 ) {
                image_empty1 = 'no-file';
            }
            else if(!allowedExtensions.exec(file1)){
                image_empty1 = 'invalid-file';
            }
            if(document.getElementById("file2").files.length == 0) {
                image_empty2 = 'no-file';
            }
            else if(!allowedExtensions.exec(file2) ){
                image_empty2 = 'invalid-file';
            }

            data_value = "&type=car&with_driver="+with_driver+"&file_empty1="+image_empty1+"&file_empty2="+image_empty2+"&file1="+file1+"&file2="+file2+"&is_required="+is_require+"&action=easync_validation";
            
        } else {
            data_value = "&type=car&with_driver="+with_driver+"&is_required="+is_require+"&action=easync_validation";
        }

        var formData = new FormData(this);         
        formData.append('type', 'car'); 
        formData.append('with_driver', with_driver); 

        if (id == 'car_continue_payment') {
            $.ajax({
                type        : 'POST',
                url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/validation.php',
                data        : $(this).serialize()+data_value,
                dataType    : 'json', 
                encode      : true
            }).done(function(data) {
                $('body').loading('stop');
                $('.modall').css('z-index', '');
                if (!data.success) {
                    remove_error();
                    // alert(data.errors.file);
                    if (data.errors.firstname) {
                        $('.personal-info.firstname').append('<div class="error error-firstname active">' + data.errors.firstname + '</div>'); 
                    }else{
                        $('.personal-info.firstname').append('<div class="error error-firstname ok active"> OK </div>');
                    }
                    if (data.errors.lastname) {
                        $('.personal-info.lastname').append('<div class="error error-lastname active">' + data.errors.lastname + '</div>'); 
                    }else{
                        $('.personal-info.lastname').append('<div class="error error-lastname ok active"> OK </div>');
                    }
                    if (data.errors.phone) {
                        $('.personal-info.phone').append('<div class="error error-phone active">' + data.errors.phone + '</div>'); 
                    }else{
                        $('.personal-info.phone').append('<div class="error error-phone ok active"> OK </div>');
                    }
                    if (data.errors.email) {
                        $('.personal-info.email-address').append('<div class="error error-email-address active">' + data.errors.email + '</div>'); 
                    }else{
                        $('.personal-info.email-address').append('<div class="error error-email-address ok active"> OK </div>');
                    }

                    if (is_require == "on") {
                        if (data.errors.driver_name) {
                            $('.personal-info.driver-name').append('<div class="error error-driver-name active">' + data.errors.driver_name + '</div>'); 
                        }else{
                            $('.personal-info.driver-name').append('<div class="error error-driver-name ok active"> OK </div>');
                        }
                        if (data.errors.driver_phone) {
                            $('.personal-info.driver-phone').append('<div class="error error-driver-number active">' + data.errors.driver_phone + '</div>'); 
                        }else{
                            $('.personal-info.driver-phone').append('<div class="error error-driver-number ok active"> OK </div>');
                        }
                        if (data.errors.file1 ) {
                            $('#filediv1').append('<div class="error error-driver-image active">' + data.errors.file1 + '</div>'); 
                        }else{
                            $('#filediv1').append('<div class="error error-driver-image ok active"> OK </div>');
                        }
                        if (data.errors.file2 ) {
                            $('#filediv2').append('<div class="error error-driver-image active">' + data.errors.file2 + '</div>'); 
                        }else{
                            $('#filediv2').append('<div class="error error-driver-image ok active"> OK </div>');
                        }
    
                        if (data.errors.driver_name ||  data.errors.driver_phone || data.errors.file1 || data.errors.file2 ) {
                            $('.modall').animate({scrollTop: $('.modal-bodyy .sync_with_driver_container #filediv1').offset().top}, 200);
                        }
                    }

                    if (data.errors.firstname ||  data.errors.lastname || data.errors.phone || data.errors.email ) {
                        $('.modall').animate({scrollTop: $('.modal-header').offset().top }, 200);
                    }
                    
                    // $('.modall').animate({scrollTop: $('.modal-header').offset().top}, 200);
                }else{
                    //pick date//
                    temporary_data[1]  = data.date_pick;
                    temporary_data[2]  = data.pick_time;
                    temporary_data[3]  = data.date_return;
                    temporary_data[4]  = data.return_time;
                    temporary_data[5]  = data.pick_location;
                    temporary_data[6]  = data.number_days;
                    temporary_data[7]  = data.with_or_out_driver;
                    temporary_data[8]  = data.firstname;
                    temporary_data[9]  = data.lastname;
                    temporary_data[10]  = data.phone;
                    temporary_data[11] = data.email;
                    temporary_data[12] = data.driver_name;
                    temporary_data[13] = data.driver_phone;
                    temporary_data[20] = data.amount_to_pay_car;
                    temporary_data[21]  = data.facility_request;
                    temporary_data[22] = data.other_req;
                    temporary_data[23] = data.reference_number;
                    temporary_data[24] = data.return_days;
                    temporary_data[25] = data.check_require;

                    jQuery('.sync_payment_display input:first-child').val(car_name);
                    jQuery('.sync_payment_display input:nth-child(2)').val(Number(data.amount_to_pay_car.replace(/[^0-9\.]+/g, "")));
    
                    temporary_entry    = [];
                    temporary_entry[0] = car_name;
                    temporary_entry[1] = Number(data.amount_to_pay_car.replace(/[^0-9\.]+/g, "")) / data.number_days;
                    temporary_entry[2] = data.number_days;
                    temporary_entry[3] = Number(data.amount_to_pay_car.replace(/[^0-9\.]+/g, ""));

                    remove_error();

                    $('.car-continue-payment').attr({
                        'type'           : 'button',
                        'data-dismiss'   : 'modal',
                        'data-toggle'    : 'modal',
                        'data-targett'    : '#car_customer_payment',
                        'data-backdrop'  : 'static',
                        'data-keyboard'  : 'false' 
                    });

                    $('.car-continue-payment').click();
                    $('.car-continue-payment').attr({
                        'type'           : 'submit'
                    });
                    $('.car-continue-payment').removeAttr('data-dismiss');
                    $('.car-continue-payment').removeAttr('data-toggle');
                    $('.car-continue-payment').removeAttr('data-targett');
                    $('.car-continue-payment').removeAttr('data-backdrop');
                    $('.car-continue-payment').removeAttr('data-keyboard');
                }
            });
        }

    });
    
    $('#car_pay_now').on('submit', function(event) {
        temporary_entry[4] = 'fail';
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/validation.php',
            data        : $(this).serialize()+"&type=car-payment&action=easync_validation",
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
              remove_error();
            if (!data.success) {
                $('body').loading('stop');
                $('.modall').css('z-index', '');
                var genError = "This field is required.";
                if (data.errors.address_1) {
                    $('.billing-address-info .address_1').append('<div class="error error-address-1 active">' + genError + '</div>'); 
                }else{
                    $('.billing-address-info .address_1').append('<div class="error error-address-1 ok active"> OK </div>');
                }
                if (data.errors.address_2) {
                    $('.billing-address-info .address_2').append('<div class="error error-address-2 active">' + genError + '</div>'); 
                }else{
                    $('.billing-address-info .address_2').append('<div class="error error-address-2 ok active"> OK </div>');
                }
                if (data.errors.province) {
                    $('.billing-address-info .province').append('<div class="error error-province active">' + genError + '</div>'); 
                }else{
                    $('.billing-address-info .province').append('<div class="error error-province ok active"> OK </div>');
                }
                if (data.errors.city) {
                    $('.billing-address-info .city').append('<div class="error error-city active">' + genError + '</div>'); 
                }else{
                    $('.billing-address-info .city').append('<div class="error error-city ok active"> OK </div>');
                }
                if (data.errors.postal_code) {
                    $('.billing-address-info .postal-code').append('<div class="error error-postal active">' + genError + '</div>'); 
                }else{
                    $('.billing-address-info .postal-code').append('<div class="error error-postal ok active"> OK </div>');
                }

            }else{
                var temp_path = '.payment-info .billing-address .sync_components .billing-address-info';
                temporary_data[14] = $(temp_path+' input[name="address_1"]').val();
                temporary_data[15] = $(temp_path+' input[name="address_2"]').val();
                temporary_data[16] = $(temp_path+' input[name="city"]').val();
                temporary_data[17] = $(temp_path+' input[name="province"]').val();
                temporary_data[18] = $(temp_path+' input[name="postal_code"]').val();

                var formData = new FormData();
                formData.append('type', 'car');
                formData.append('with_driver', with_driver);  
                formData.append('car_id', temporary_data[0]);
                formData.append('date_pick', temporary_data[1]);
                formData.append('pick_time', temporary_data[2]);
                formData.append('date_return', temporary_data[3]);
                formData.append('return_time', temporary_data[4]);
                formData.append('pick_location', temporary_data[5]);
                formData.append('number_days', temporary_data[6]);
                formData.append('with_or_out_driver', temporary_data[7]);
                formData.append('firstname', temporary_data[8]);
                formData.append('lastname', temporary_data[9]);
                formData.append('phone', temporary_data[10]);
                formData.append('email', temporary_data[11]);

                if (temporary_data[25] == 'on') {
                    formData.append('driver_name', temporary_data[12]);
                    formData.append('driver_phone', temporary_data[13]);//
                    formData.append('driver_license_image1', $('.sync_components #filediv1 input[type=file]').val().split('\\').pop());
                    formData.append('driver_license_image2', $('.sync_components #filediv2 input[type=file]').val().split('\\').pop());
                }
                
                formData.append('address_1', temporary_data[14]);
                formData.append('address_2', temporary_data[15]);
                formData.append('city', temporary_data[16]);
                formData.append('province', temporary_data[17]);
                formData.append('postal_code', temporary_data[18]);
                formData.append('amount_to_pay_car', temporary_data[20]);
                formData.append('facility_request', temporary_data[21]);
                formData.append('other_req', temporary_data[22]);
                formData.append('reference_number', temporary_data[23]);
                formData.append('is_required', temporary_data[25]);
                formData.append('action', 'easync_session_store');

                $.ajax({
                    type        : 'POST',
                    url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/session-store.php',
                    data        : formData, 
                    dataType    : 'json', 
                    encode      : true,
                    cache       : false,
                    processData : false,
                    contentType : false
                }).done(function(data) {
                    $('body').loading('stop');
                    $('.modall').css('z-index', '');
                    if (!data.success) {
                           // console.log('Something wrong!');
                    }else{
                        temporary_data  = [];
                        $('.car-pay-now').attr({
                            'type'           : 'button',
                            'data-dismiss'   : 'modal',
                            'data-toggle'    : 'modal',
                            'data-targett'    : '#car_thank_you_modal',
                            'data-backdrop'  : 'static',
                            'data-keyboard'  : 'false' 
                        });
                        //$('.car-pay-now').click();
                        $('.car-pay-now').attr({
                            'type'           : 'submit'
                        });
                        $('.car-pay-now').removeAttr('data-dismiss');
                        $('.car-pay-now').removeAttr('data-toggle');
                        $('.car-pay-now').removeAttr('data-targett');
                        $('.car-pay-now').removeAttr('data-backdrop');
                        $('.car-pay-now').removeAttr('data-keyboard');

                        temporary_entry[4] = 'success';
                    }
                });

            }
 
        });  
         event.preventDefault();
    });

    $('#car_thank_you_modal .close').on('click', function(e) {
        location.reload();
    });

	//backend//

    $('#sync_hotel_thank_u').on('submit', function(event){ 
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_hotel_thanks&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        }); 
        event.preventDefault();
    });

    $('#sync_hotel_privacy').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_hotel_privacy&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                    console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_hotel_terms').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_hotel_terms&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_hotel_cancellation').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&action=easync_cancellation_settings", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_car_cancellation').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&action=easync_cancellation_settings_car", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    
    $('#sync_restau_cancellation').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&action=easync_cancellation_settings_restau", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_paypal_config').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_paypal_set&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_stripe_config').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_stripe_set&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    try {
      $('#sync_default_pickup').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
      $('#sync_default_return').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
    }
    catch(err) {
      console.log('Please set configuration in car rental modules');
    }
    
    $('#sync_default_car_time').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_default_car_time&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_product_currency').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_product_currency&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    try{
        $("#sync_hotel_switch").toggleSwitch();
        $("#sync_captcha_switch").toggleSwitch();
        $("#sync_driver_switch").toggleSwitch();
        $("#sync_car_switch").toggleSwitch();
        $("#sync_restau_switch").toggleSwitch();
    }
    catch(err) {
    //    console.log('Please set configuration in car restaurant modules');
    }

    $('button[data-dismiss="modal"]').on('click', function (e) {
        $('body').css('overflow-y', 'scroll');
        if($('#'+$(this).attr('data-close')).parent().find('.NubWrapper').hasClass('Checked')) {
            $('#'+$(this).attr('data-close')).parent().find('.NubWrapper').removeClass('Checked');
        } else {
            $('#'+$(this).attr('data-close')).parent().find('.NubWrapper').addClass('Checked');
        }
    });

    $("#sync_hotel_switch").on('change', function() {
        truggerOnSwitch('sync_enable_switch_hotel', this)
    });

    $("#sync_captcha_switch").on('change', function() {
        truggerOnSwitch('sync_enable_switch_captcha', this)
    });

    $("#sync_driver_switch").on('change', function() {
        truggerOnSwitch('sync_enable_switch_driver', this)
    });

    $("#sync_car_switch").on('change', function() {
        truggerOnSwitch('sync_enable_switch_car', this)
    });

    $("#sync_restau_switch").on('change', function() {
        truggerOnSwitch('sync_enable_switch_restau', this)
    });

    $("#sync_paypal_switch").on('change', function() {
        truggerOnSwitch('sync_enable_switch_paypal', this)
    });

    var className = $('.sync_settings_enable.hotel').find('.NubWrapper').attr('class');
    var className2 = $('.sync_settings_enable.car').find('.NubWrapper').attr('class');
    var className3 = $('.sync_settings_enable.restau').find('.NubWrapper').attr('class');
    var className6 = $('.sync_settings_enable.captcha').find('.NubWrapper').attr('class');
    var className7 = $('.sync_settings_enable.paypal').find('.NubWrapper').attr('class');
    var className11 = $('.sync_settings_enable.driver').find('.NubWrapper').attr('class');
    $('.sync-cancel-switch').on('click', function(){

        if($(this).attr('data-close') == 'sync_hotel_switch') {
            if(className=$('.sync_settings_enable.hotel').find('.NubWrapper').attr('class')) {
                $('.sync_settings_enable.hotel').find('.NubWrapper').addClass('Checked');
           }else{
                $('.sync_settings_enable.hotel').find('.NubWrapper').removeClass('Checked');
           }
        }
        if($(this).attr('data-close') == 'sync_car_switch') {
           if(className2==$('.sync_settings_enable.car').find('.NubWrapper').attr('class')) {
                $('.sync_settings_enable.car').find('.NubWrapper').addClass('Checked'); 
           }else{
                $('.sync_settings_enable.hotel').find('.NubWrapper').removeClass('Checked');
           }
        }
        if($(this).attr('data-close') == 'sync_restau_switch') {
            if($('.sync_settings_enable.restau').find('.NubWrapper').hasClass('Checked')==false) {
                $('.sync_settings_enable.restau').find('.NubWrapper').addClass('Checked');
           }
        }
        if($(this).attr('data-close') == 'sync_captcha_switch') {
            if(className6=$('.sync_settings_enable.captcha').find('.NubWrapper').attr('class')) {
                $('.sync_settings_enable.captcha').find('.NubWrapper').addClass('Checked');
           }else{
                $('.sync_settings_enable.captcha').find('.NubWrapper').removeClass('Checked');
           }
        }
        if($(this).attr('data-close') == 'sync_paypal_switch') {
            if(className7=$('.sync_settings_enable.paypal').find('.NubWrapper').attr('class')) {
                $('.sync_settings_enable.paypal').find('.NubWrapper').addClass('Checked');
           }else{
                $('.sync_settings_enable.paypal').find('.NubWrapper').removeClass('Checked');
           }
        }
        if($(this).attr('data-close') == 'sync_driver_switch') {
            if(className11=$('.sync_settings_enable.driver').find('.NubWrapper').attr('class')) {
                $('.sync_settings_enable.driver').find('.NubWrapper').addClass('Checked');
           }else{
                $('.sync_settings_enable.driver').find('.NubWrapper').removeClass('Checked');
           }
        }

    });

    //NubWrapper Checked
    switching('#sync_enable_switch_hotel', 'option_switch_hotel');
    switching('#sync_enable_switch_captcha', 'option_switch_captcha');
    switching('#sync_enable_switch_driver', 'option_switch_driver');
    switching('#sync_enable_switch_car', 'option_switch_car');
    switching('#sync_enable_switch_restau', 'option_switch_restau');
    switching('#sync_enable_switch_paypal', 'option_switch_paypal');


    $('.bubbly-button').on('click', function(event){
        var values = $(this).attr('data-values').split('<>');
        var labels = $(this).attr('data-label').split('<>');
        var append="";
        $.each( values, function( key, value ) {     
            if(labels[key]=='Driver license') {
                var temp='';
                $.each( value.split("|"), function( key, path ) { 
                   temp += '<a data-fancybox="gallery" href="'+path+'"><img src="'+path+'"></a>';
                });
                append += '<div class="data-row row-license-image"><span>'+labels[key]+'</span>'+temp+'</div>';
            }else if(value.length<30){
                append += '<div class="data-row"><span>'+labels[key]+'</span><span>'+value+'</span></div>';
            }else{
                append += '<div class="data-row"><span>'+labels[key]+'</span><p>'+value+'</p></div>';
            }
        });
        $('.data-container').text('');
        $('.data-container').append(append);
    });

    $(document).on('click','.select-branch-location',function(event){
        $('.sync_branch input[name="branch_name"]').val($(this).attr('data-value'));
        var append = '<input type="submit" value="Update" name="update" class="update-btn btn btn-success"/>'
                   +'  <input type="submit" value="Delete" name="delete" class="remove-btn btn btn-danger"/>'
                   +'  <input type="button" value="New" name="option_trig" class="new-btn btn btn-primary"/>'
                   +'  <input type="hidden" name="branch_id" value="'+$(this).attr('data-id')+'">';

        $('.sync_branch .item-row input[name="branch_id"]').remove();           
        $('.sync_branch .item-row .save-btn').remove();
        $('.sync_branch .item-row .update-btn').remove();
        $('.sync_branch .item-row .remove-btn').remove();
        $('.sync_branch .item-row .new-btn').remove();
        $('.sync_branch .item-row').append(append);
        event.preventDefault();
    });

    $(document).on('click', '.sync_branch .item-row .new-btn',function(){
        var append = '<input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>';
        $('.sync_branch .item-row input[name="branch_name"]').val('');
        $('.sync_branch .item-row .update-btn').remove();
        $('.sync_branch .item-row .remove-btn').remove();
        $('.sync_branch .item-row .new-btn').remove();
        $('.sync_branch .item-row').append(append);
    });

    var trig_on = '';
    $(document).on('click', '.sync_branch .item-row .update-btn', function(){
        trig_on = 'update';
    });

    $(document).on('click', '.sync_branch .item-row .save-btn', function(){
        trig_on = 'save';
    });

    $(document).on('click', '.sync_branch .item-row .remove-btn', function(){
        trig_on = 'delete';
    });

    $('#sync_branch').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_branch&trig="+trig_on+"&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }else{
                $('#sync_branch').parent().find('.container .list-group').empty();
                var append = '';
                $.each(data.entries, function( index, value ) {
                  append += '<a href="#" class="list-group-item select-branch-location" data-id="'+value.id+'" data-value="'+value.option_value+'" >'+value.option_value+'</a>';
                });
                $('#sync_branch').parent().find('.container .list-group').append(append);
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $(document).on('click','.select-pickup-location',function(event){
        $('.sync_car_pickup input[name="location_name"]').val($(this).attr('data-value'));
        var append = '<input type="submit" value="Update" name="update" class="update-btn btn btn-success"/>'
                +'  <input type="submit" value="Delete" name="delete" class="remove-btn btn btn-danger"/>'
                +'  <input type="button" value="New" name="option_trig" class="new-btn btn btn-primary"/>'
                +'  <input type="hidden" name="pickup_id" value="'+$(this).attr('data-id')+'">';

        $('.sync_car_pickup .item-row input[name="pickup_id"]').remove();           
        $('.sync_car_pickup .item-row .save-btn').remove();
        $('.sync_car_pickup .item-row .update-btn').remove();
        $('.sync_car_pickup .item-row .remove-btn').remove();
        $('.sync_car_pickup .item-row .new-btn').remove();
        $('.sync_car_pickup .item-row').append(append);
        event.preventDefault();
    });

    $(document).on('click', '.sync_car_pickup .item-row .new-btn', function(){
        var append = '<input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>';
        $('.sync_car_pickup .item-row input[name="location_name"]').val('');
        $('.sync_car_pickup .item-row .update-btn').remove();
        $('.sync_car_pickup .item-row .remove-btn').remove();
        $('.sync_car_pickup .item-row .new-btn').remove();
        $('.sync_car_pickup .item-row').append(append);
    });

    $(document).on('click', '.sync_car_pickup .item-row .update-btn', function(){
        trig_on = 'update';
    });

    $(document).on('click', '.sync_car_pickup .item-row .save-btn', function(){
        trig_on = 'save';
    });

    $(document).on('click', '.sync_car_pickup .item-row .remove-btn', function(){
        trig_on = 'delete';
    });

    $('#sync_car_pickup').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_pickup_location&trig="+trig_on+"&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }else{
                $('#sync_car_pickup').parent().find('.container .list-group').empty();
                var append = '';
                $.each(data.entries, function( index, value ) {
                  append += '<a href="#" class="list-group-item select-pickup-location" data-id="'+value.id+'" data-value="'+value.option_value+'">'+value.option_value+'</a>';
                });
                $('#sync_car_pickup').parent().find('.list-dates').append(append);
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#table_settings').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&action=easync_table_settings", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (data.success != "Success") {
                     console.log('Something wrong!');
            }else{
                $('body').loading('stop');
                $('.modall').css('z-index', '');
                sweetfb_reload();
            }
            
        });
        event.preventDefault();
    });


    $(document).on('click','.select-car-type',function(event){
        $('.sync_car_types input[name="type_name"]').val($(this).attr('data-value'));
        var append = '<input type="submit" value="Update" name="update" class="update-btn btn btn-success"/>'
                   +'  <input type="submit" value="Delete" name="delete" class="remove-btn btn btn-danger"/>'
                   +'  <input type="button" value="New" name="option_trig" class="new-btn btn btn-primary"/>'
                   +'  <input type="hidden" name="type_id" value="'+$(this).attr('data-id')+'">';

        $('.sync_car_types .item-row input[name="type_id"]').remove();           
        $('.sync_car_types .item-row .save-btn').remove();
        $('.sync_car_types .item-row .update-btn').remove();
        $('.sync_car_types .item-row .remove-btn').remove();
        $('.sync_car_types .item-row .new-btn').remove();
        $('.sync_car_types .item-row').append(append);
        event.preventDefault();
    });

    $(document).on('click', '.sync_car_types .item-row .new-btn', function(){
        var append = '<input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>';
        $('.sync_car_types .item-row input[name="type_name"]').val('');
        $('.sync_car_types .item-row .update-btn').remove();
        $('.sync_car_types .item-row .remove-btn').remove();
        $('.sync_car_types .item-row .new-btn').remove();
        $('.sync_car_types .item-row').append(append);
    });

    $(document).on('click', '.sync_car_types .item-row .update-btn', function(){
        trig_on = 'update';
    });

    $(document).on('click', '.sync_car_types .item-row .save-btn', function(){
        trig_on = 'save';
    });

    $(document).on('click', '.sync_car_types .item-row .remove-btn', function(){
        trig_on = 'delete';
    });

    $('#sync_car_types').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_car_types&trig="+trig_on+"&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }else{
                $('#sync_car_types').parent().find('.container .list-group').empty();
                var append = '';
                $.each(data.entries, function( index, value ) {
                  append += '<a href="#" class="list-group-item select-car-type" data-id="'+value.id+'" data-value="'+value.option_value+'">'+value.option_value+'</a>';
                });
                $('#sync_car_types').parent().find('.container .list-group').append(append);
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });    

    $(document).on('click','.select-car-model',function(event){
        $('.sync_car_model input[name="model_name"]').val($(this).attr('data-value'));
        var append = '<input type="submit" value="Update" name="update" class="update-btn btn btn-success"/>'
                   +'  <input type="submit" value="Delete" name="delete" class="remove-btn btn btn-danger"/>'
                   +'  <input type="button" value="New" name="option_trig" class="new-btn btn btn-primary"/>'
                   +'  <input type="hidden" name="model_id" value="'+$(this).attr('data-id')+'">';

        $('.sync_car_model .item-row input[name="model_id"]').remove();           
        $('.sync_car_model .item-row .save-btn').remove();
        $('.sync_car_model .item-row .update-btn').remove();
        $('.sync_car_model .item-row .remove-btn').remove();
        $('.sync_car_model .item-row .new-btn').remove();
        $('.sync_car_model .item-row').append(append);
        event.preventDefault();
    });

    $(document).on('click', '.sync_car_model .item-row .new-btn', function(){
        var append = '<input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>';
        $('.sync_car_model .item-row input[name="model_name"]').val('');
        $('.sync_car_model .item-row .update-btn').remove();
        $('.sync_car_model .item-row .remove-btn').remove();
        $('.sync_car_model .item-row .new-btn').remove();
        $('.sync_car_model .item-row').append(append);
    });

    $(document).on('click', '.sync_car_model .item-row .update-btn', function(){
        trig_on = 'update';
    });

    $(document).on('click', '.sync_car_model .item-row .save-btn', function(){
        trig_on = 'save';
    });

    $(document).on('click', '.sync_car_model .item-row .remove-btn', function(){
        trig_on = 'delete';
    });

    $('#sync_car_model').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_car_model&trig="+trig_on+"&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }else{
                $('#sync_car_model').parent().find('.container .list-group').empty();
                var append = '';
                $.each(data.entries, function( index, value ) {
                  append += '<a href="#" class="list-group-item select-car-model" data-id="'+value.id+'" data-value="'+value.option_value+'">'+value.option_value+'</a>';
                });
                $('#sync_car_model').parent().find('.container .list-group').append(append);
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });    

    // to be placed in the main js file
    $(document).on('click', '.sync_currency .item-row .new-btn', function(){
        var append = '<input type="submit" value="Save" name="save" class="save-btn btn btn-success"/>';
        $('.sync_currency .item-row .update-btn').remove();
        $('.sync_currency .item-row .remove-btn').remove();
        $('.sync_currency .item-row .new-btn').remove();
        $('.sync_currency .item-row').append(append);
    });

    $(document).on('click', '.sync_currency .item-row .update-btn', function(){
        trig_on = 'update';
    });

    $(document).on('click', '.sync_currency .item-row .save-btn', function(){
        trig_on = 'save';
    });

    $(document).on('click', '.sync_currency .item-row .remove-btn', function(){
        trig_on = 'delete';
    });

    $('#sync_currency').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_currency&trig="+trig_on+"&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                    console.log('Something wrong!');
            }else{
                $('#sync_currency').parent().find('.container .list-group').empty();
                var append = '';
                $.each(data.entries, function( index, value ) {
                  append += '<a href="#" class="list-group-item select-currency-location" data-id="'+value.id+'" data-select="'+value.option_value+'">'+value.option_value+'</a>';
                });
                $('#sync_currency').parent().find('.container .list-group').append(append);
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
        });
        event.preventDefault();
    });
    // end here

    $('#sync_car_thank_u').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_car_thanks&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_car_privacy').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_car_privacy&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });

    $('#sync_car_terms').on('submit', function(event){
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_car_terms&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                    console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });
    
    $('#sync_rental_tax').on('submit', function(event){
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_rental_tax&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }else{
                location.reload();
            }
        });
        event.preventDefault();
    });

    $('#sync_hotel_tax').on('submit', function(event){
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_hotel_tax&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }else{
                location.reload();
            }
        });
        event.preventDefault();
    });

    try {
    
        $('#timeslot1').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
        $('#timeslot1_1').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
        $('#timeslot2').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
        $('#timeslot1_2').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
        $('#timeslot3').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
        $('#timeslot1_3').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
        $('#timeslot4').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
        $('#timeslot1_4').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
        $('#timeslot5').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
        $('#timeslot1_5').timeDropper({autoswitch:true,mousewheel:true,meridians:true,init_animation:'dropdown',setCurrentTime:false});
    }
    catch(err) {
        // console.log('Please set configuration in car restaurant modules');
    }

    timeslot(1);
    timeslot(2);
    timeslot(3);
    timeslot(4);
    timeslot(5);

    // to be placed in the main js file
    jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });
    // end here

    $('#spend_night_hotel').add('.holder-guest-number input').add('.holder-rooms-number input').keypress(function(e) {
        return false
    });

    $('.holder-night input').add('.holder-guest-number input').add('.holder-rooms-number input').keydown(function (e) {
      var key = e.keyCode || e.charCode;
      if (key == 8 || key == 46) {
          e.preventDefault();
          e.stopPropagation();
      }
    });  

      $('.holder-guest-number input').unbind('keyup change input paste').bind('keyup change input paste',function(e){
        var $this = $(this);
        var val = $this.val();
        var valLength = val.length;
        var maxCount = $this.attr('maxlength');
        if(valLength>maxCount){
            $this.val($this.val().substring(0,maxCount));
        }
    }); 

    $('.holder-rooms-number input').unbind('keyup change input paste').bind('keyup change input paste',function(e){
        var $this = $(this);
        var val = $this.val();
        var valLength = val.length;
        var maxCount = $this.attr('maxlength');
        if(valLength>maxCount){
            $this.val($this.val().substring(0,maxCount));
        }
    }); 

    if(easync_admin_check_login.login==1 && easync_admin_check_page.pageIs=='load') {

        $.ajax({
            type        : 'GET',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/calendar-query.php',
            data        : "type=hotel&action=easync_calendar_query", 
            dataType    : 'json',  
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                 console.log('Something wrong!');
            }else{
                var temp_event = new Array();
                for (var i = 0; i < data.count; i++) {
                    temp_event[i] = {
                        'title':data.event[i][0]['lastname']+', '+data.event[i][0]['firstname'], 
                        'start':data.event[i][0]['start'],
                        'end'  :data.event[i][0]['end'],
                        'allDay': false,
                        'description': data.event[i][0]['description'],
                        'backgroundColor': data.event[i][0]['backgroundColor']
                    };
                }
                 var source = { 
                    header: {
                        left: null,
                        center: 'title',
                        right: 'prev,next today'
                    },
                    defaultDate: new Date(),
                    navLinks: false, // can click day/week names to navigate views
                    editable: false,
                    eventLimit: true, // allow "more" link when too many events
                    eventMouseover: function (data, event, view) {
                        
                        tooltip = '<div class="sync_calendar_schedule tooltiptopicevent ">' 
                        + data.title
                        + '</div>';
                        $("body").append(tooltip);
                        $(this).mouseover(function (e) {
                            $(this).css('z-index', 10000);
                            $('.tooltiptopicevent').fadeIn('500');
                            $('.tooltiptopicevent').fadeTo('10', 1.9);
                        }).mousemove(function (e) {
                            $('.tooltiptopicevent').css('top', e.pageY + 10);
                            $('.tooltiptopicevent').css('left', e.pageX + 20);

                        });
                    },
                    eventMouseout: function (data, event, view) {
                        $(this).css('z-index', 8);
                        $('.tooltiptopicevent').remove();
                    },
                    eventClick: function(data, event, view) {

                        $('.sync_calendar_single_view').attr({
                            'data-values'    : data.description.split('+')[0],
                            'data-label'     : data.description.split('+')[1],
                            'data-id'        : data.description.split('+')[2],
                            'data-dismiss'   : 'modal',
                            'data-toggle'    : 'modal',
                            'data-targett'    : '#single_view_entry_modal',
                            'data-backdrop'  : 'static',
                            'data-keyboard'  : 'false' 
                        });
                        var values = $('.sync_calendar_single_view').attr('data-values').split('<>');
                        var labels = $('.sync_calendar_single_view').attr('data-label').split('<>'); 
                        var id = $('.sync_calendar_single_view').attr('data-id'); 
                        var append="";
                        $.each( values, function( key, value ) {     
                            if(labels[key]=='Driver license') {
                                var temp='';
                                $.each( value.split("|"), function( key, path ) { 
                                   temp += '<a data-fancybox="gallery" href="'+path+'"><img src="'+path+'"></a>';
                                });
                                append += '<div class="data-row row-license-image"><span>'+labels[key]+'</span>'+temp+'</div>';
                            }else if(value.length<30){
                                append += '<div class="data-row"><span>'+labels[key]+'</span><span>'+value+'</span></div>';
                            }else{
                                append += '<div class="data-row"><span>'+labels[key]+'</span><p style="text-align:right;">'+value+'</p></div>';
                            }
                        });

                        // Fix passed bookings still being able to start
                        var today = moment(new Date());
                        var diff = today.diff(data.start, 'days'); // Calculate date today and start date
                        var end_diff = today.diff(data.end, 'days');

                        $('#sync_activator').text('');
                        var reserved_option = '';
                        $('#sync_activator').css('display', 'block');
                        $('#sync_activator').attr('disabled', false);

                        // Fix passed bookings still being able to start
                        if( diff > 0 && (reserved_option != 'trash') ) { // Hide button if days > 1
                            $('#sync_activator').hide();
                            reserved_option = 'trash';
                        }

                        if(values[0]=='Pending') {
                            $('#sync_activator').text('Start');
                            reserved_option = 'active';
                        }else if(values[0]=='Active') {
                            $('#sync_activator').text('End');
                            reserved_option = 'inactive';
                        }else if(values[0]=='Inactive') {
                            $('#sync_activator').text('Trash');
                            reserved_option = 'trash';
                        }else{
                            $('#sync_activator').text('Deleted');
                            $('#sync_activator').css('display', 'none');
                            $('#sync_activator').attr('disabled', true);
                        }    

                        $('#sync_reserved_event input[name="type"]').val('hotel');
                        $('#sync_reserved_event input[name="reserve_event_id"]').val(id);
                        $('#sync_reserved_event input[name="reserve_event_option"]').val(reserved_option);
                        $('.data-container').text('');
                        $('.data-container').append(append);    
                        $('.sync_calendar_single_view').click();
                    },
                    dayClick: function () {
                        //tooltip.hide();
                    },
                    eventResizeStart: function () {
                        tooltip.hide();
                    },
                    eventDragStart: function () {
                        tooltip.hide();
                    },
                    viewDisplay: function () {
                        tooltip.hide();
                    },
                    events: temp_event
            };
                $('#sync_hotel_calendar').fullCalendar( source );
            }
        });
    }

	Date.prototype.addDays = function(days) {
	  var dat = new Date($('#datepicker_hotel').val());
	  dat.setDate(dat.getDate() + days);
	  return (dat.getMonth() + 1) + '/' + dat.getDate() + '/' +  dat.getFullYear();
	}

    var now = new Date();
    now.setDate(now.getDate());
    if($('#datepicker_hotel').val()=="") {
        $('#datepicker_hotel').datepicker("setDate", now);
    }

    // Fix date calculation on change
    $('#datepicker_hotel').change(function() {
        check_out_stat();
    })

	$(document).on('click', '.quantity-up', function () {
		check_out_stat();
	});

    $('.quantity-down').on('click', function () {
        check_out_stat();
    });

    check_out_stat();

    function check_out_stat() {
        var dat = new Date();
        $('.date_departure').text('');
        $('#date_departure_num').text('');
        $('.date_departure').append(dat.addDays(parseInt($('#spend_night_hotel').val())));
        $('#date_departure').val(dat.addDays(parseInt($('#spend_night_hotel').val())));
        $('#date_departure_num').append('<i class="fa fa-moon-o fa-1x"></i> '+$('#spend_night_hotel').val()+' night(s) only');
    }

	$('.modall').on('show.bs.modal', function (e) {
	    $('body').css('overflow-y', 'hidden');
	})
	$('.close').on('click', function (e) {
	  $('body').css('overflow-y', 'scroll');
      $('.modall.sync-transform').css('overflow-y', 'scroll');   
	})
	$('.find-room').on('click', function(e) {
		var arrive_date    = $(this).parent().parent().parent().parent().find('.sync_components .holder-calendar input#datepicker_hotel ').val();
		var departure_date = $(this).parent().parent().parent().parent().find('.sync_components .holder-check-out label.date_departure ').text();
		var night_number   = $(this).parent().parent().parent().parent().find('.sync_components .holder-night input#spend_night_hotel ').val();
		var guest_number   = $(this).parent().parent().parent().parent().find('.sync_components .holder-guest-number input').val();
		var room_number    = $(this).parent().parent().parent().parent().find('.sync_components .holder-rooms-number input').val();		
		var room_bed       = $(this).parent().parent().parent().parent().find('.sync_components .holder-beds-number input').val();		
		$('.error-check-in').removeClass('active');
		$('.error-night-number').removeClass('active');
		$('.error-guest-number').removeClass('active');
		$('.error-room-number').removeClass('active');		
		$('.error-bed-number').removeClass('active');		
		var required = false;
		if(arrive_date=='') {
			$('.error-check-in').addClass('active');
			required = true;
		}
		if(night_number=='') {
			$('.error-night-number').addClass('active');
			required = true;
		}
		if(guest_number=='') {
			$('.error-guest-number').addClass('active');	
			required = true;		
		}
		if(room_number=='') {
			$('.error-room-number').addClass('active');	
			required = true;		
		}
		if(room_bed=='') {
			$('.error-bed-number').addClass('active');	
			required = true;		
		}
		if(required==false){
			$('#search_hotel_room').submit();	
		}
        
	});

    var room_title = '';
    var subtotal = '';
    var final_total = '';
	$(document).on('click', '.book-save', function (e) {
		var room_id         =  $(this).parent().parent().find('.result-item-details input.room-id').val();
		room_title          =  $(this).parent().parent().find('.result-item-details h2').text();
		var room_desc       =  $(this).parent().parent().find('.result-item-details p').text();
		var room_price      =  $(this).parent().parent().find('.result-image span .sync_price_money_format').text();
		var night_number    =  $('.customer-info .first-row .sync_components .room-cost .date span span').text();
		var number_room     =  $('#customer_info .customer-info .first-row .sync_components .room-cost .rooms p span').text();
		// var number_bed      =  $('#customer_info .customer-info .first-row .sync_components .room-cost .beds p span').text();
		var room_image      =  $(this).parent().parent().find('.result-image img').prop('src');
		var obj_amenities   =  $(this).parent().parent().find('.result-item-details input.amenities').val();
        var obj_facilities  =  $(this).parent().parent().find('.result-item-details input.facilities-special-request').val();
        
        var specify_request =  $(this).parent().parent().find('.result-item-details input.specify-special-request').val();
        var arr = obj_amenities.split(',');
        arr = arr.slice(0, -1);
        var amenities = '';
        $.each( arr, function( key, value ) {
          amenities += '  <span><i class="fas fa-dot-circle"></i> '+value+'</span>';
        });
        var arr = obj_facilities.split(',');
        arr = arr.slice(0, -1);
        var facilities = '';
        $.each( arr, function( key, value ) {
          facilities += '<div class="personal-info">'
                     +  '<input type="checkbox" name="request_facilities[]" value="'+value+'" class="special-request-field">'
                     +  '<label>'+value+'</label></div>';
        });
        
        $('#customer_info .customer-info .second-row .sync_components .special-request-others label').css('display', 'none');
        $('#customer_info .customer-info .second-row .sync_components .special-request-others textarea').remove(); 
        if(specify_request=='Yes') {
            facilities += '<div class="personal-info">'
                       +  '<input type="checkbox" name="others" value="others" class="others-req special-request-field">'
                       +  '<label>Others</label></div>';
            var append = '<textarea placeholder=" " width="500" name="other_req"> </textarea>';   
            $('#customer_info .customer-info .second-row .sync_components .special-request-others label').css('display', 'block');
            $('#customer_info .customer-info .second-row .sync_components .special-request-others textarea').remove();
            $(append).insertBefore('#customer_info .customer-info .second-row .sync_components .special-request-others label');       
        }

        var currency_code = $('.payment input[name="sync_currency_code"]').val();
		subtotal          =  (night_number*(number_room*Number(room_price.replace(/[^0-9\.-]+/g,""))));
        subtotal          = subtotal.toFixed(2);
        subtotal          = subtotal.toString().replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
		temporary_data    = [];
		temporary_data[0] = room_id;
        temp_data[0]      = room_id;
        tempry_data[0]    = room_id;

		$('#customer_info .customer-info .first-row .sync_components .room-profile h2').text(room_title);
        $('#customer_info .customer-info .first-row .sync_components .room-profile .amenities').text('');
		$('#customer_info .customer-info .first-row .sync_components .room-profile .amenities').append(amenities);
        $('#customer_info .customer-info .second-row .sync_components .special-request .special-request-holder').text('');
        $('#customer_info .customer-info .second-row .sync_components .special-request .special-request-holder').append(facilities);
		$('#customer_info .customer-info .first-row .sync_components .room-profile img').prop('src',room_image);
		$('#customer_info .customer-info .first-row .sync_components .room-cost .pricing-details p span').text(currency_code+' '+room_price);
		$('#customer_info .customer-info .second-row .sync_components .book-summary-subtotal p:first-child span').text(currency_code+' '+subtotal);
        $('#customer_info .customer-info .second-row .sync_components .book-summary-subtotal p strong').text(room_title);
		$('#customer_info .customer-info .second-row .sync_components .book-summary-total p span').text(currency_code+' '+subtotal);
        $('#customer_info .customer-info .second-row .sync_components .book-summary-payment .payment .amount_to_pay').val(subtotal);
        $('#customer_info .customer-info .second-row .sync_components .add_coupon .initial_amount').val(subtotal);
        $('#coupon_list .modal-content .content_list .coupon_container .discount_value h4 span').text(currency_code);			  
        $('#coupon_list .modal-content .content_list .coupon_container .discount_details p span').text(currency_code);
        
    });

    $(document).on('click', '.special-request-others textarea', function() {
        $('.special-request-others textarea').prop('readonly', false);
        $('.others-req + label').addClass('active');
        $('.others-req + label').parent().find('input').prop('checked', true);
    });
    $(document).on('click', '.special-request-field + label', function() {
      if($(this).hasClass('active')==true) {
        $(this).removeClass('active');
        $(this).parent().find('input').prop('checked', false);
      }else{
        $(this).addClass('active');
        $(this).parent().find('input').prop('checked', true);
      }
    });
	$(document).on('click', '.others-req + label', function (e) {
		if($('.special-request-others textarea').is(':disabled')) {
			$('.special-request-others textarea').prop('readonly', false);
		}else{
			$('.special-request-others textarea').prop('readonly', false);
			$('.special-request-others textarea').val("");
		}
	});
     
	$('#continue_payment').on('submit', function(event) {
        $('body').loading();
        $('.modall').css('z-index', '0');

        var id = this.id;

        if ( id == 'continue_payment') {
            $.ajax({
                type        : 'POST',
                url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/validation.php',
                data        : $(this).serialize()+"&type=hotel&action=easync_validation",
                dataType    : 'json', 
                encode      : true
            }).done(function(data) {
                $('body').loading('stop');
                $('.modall').css('z-index', '');
                if (!data.success) {
                    remove_error();
                        if (data.errors.firstname) {
                            $('.personal-info.firstname').append('<div class="error error-firstname active">' + data.errors.firstname + '</div>'); 
                        }else{
                            $('.personal-info.firstname').append('<div class="error error-firstname ok active"> OK </div>');
                        }
                        if (data.errors.lastname) {
                            $('.personal-info.lastname').append('<div class="error error-lastname active">' + data.errors.lastname + '</div>'); 
                        }else{
                            $('.personal-info.lastname').append('<div class="error error-lastname ok active"> OK </div>'); 
                        }
                        if (data.errors.phone) {
                            $('.personal-info.phone').append('<div class="error error-phone active">' + data.errors.phone + '</div>'); 
                        }else{
                            $('.personal-info.phone').append('<div class="error error-phone ok active"> OK </div>'); 
                        }
                        if (data.errors.email) {
                            $('.personal-info.email-address').append('<div class="error error-email-address active">' + data.errors.email + '</div>'); 
                        }else{
                            $('.personal-info.email-address').append('<div class="error error-email-address ok active"> OK </div>'); 
                        }
                        $('.modall').animate({scrollTop: $('.modal-header').offset().top}, 200);
                }else{
                    //arrival date//
                    temporary_data[1]   = data.date_arrive;
                    temporary_data[2]   = data.date_departure;
                    temporary_data[3]   = data.night_number;
                    temporary_data[4]   = data.number_guest;
                    temporary_data[5]   = data.number_room;
                    temporary_data[6]   = data.firstname;
                    temporary_data[7]   = data.lastname;
                    temporary_data[8]   = data.phone;
                    temporary_data[9]   = data.email;
                    temporary_data[10] = data.facility_request;
                    temporary_data[11]  = data.other_req;
                    temporary_data[19] = data.amount_to_pay;
                    temporary_data[20] = data.reference_number;

                    jQuery('.sync_payment_display input:first-child').val(room_title);
                    jQuery('.sync_payment_display input:nth-child(2)').val(Number(data.amount_to_pay.replace(/[^0-9\.]+/g, "")));
                    
                    temporary_entry    = [];
                    temporary_entry[0] = room_title;
                    temporary_entry[1] = Number(data.amount_to_pay.replace(/[^0-9\.]+/g, "")) / data.night_number;
                    temporary_entry[2] = data.night_number;
                    temporary_entry[3] = Number(data.amount_to_pay.replace(/[^0-9\.]+/g, ""));
                    
                    remove_error();

                    $('.continue-payment').attr({
                        'type'           : 'button',
                        'data-dismiss'   : 'modal',
                        'data-toggle'    : 'modal',
                        'data-targett'   : '#customer_payment',
                        'data-backdrop'  : 'static',
                        'data-keyboard'  : 'false' 
                    });
                    $('.continue-payment').click();
                    $('.continue-payment').attr({
                        'type'           : 'submit'
                    });
                    $('.continue-payment').removeAttr('data-dismiss');
                    $('.continue-payment').removeAttr('data-toggle');
                    $('.continue-payment').removeAttr('data-targett');
                    $('.continue-payment').removeAttr('data-backdrop');
                    $('.continue-payment').removeAttr('data-keyboard');
                }
            });
        }
        event.preventDefault();
    });
    
    $('#pay_now').on('submit', function(event) {
        temporary_entry[4] = 'fail';
        $('body').loading();
        $('.modall').css('z-index', '1');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/validation.php',
            data        : $(this).serialize()+"&type=hotel-payment&action=easync_validation",
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                $('body').loading('stop');
                $('.modall').css('z-index', '');
                  remove_error();
                  var genError = "This field is required.";
                    if (data.errors.address_1) {
                        $('.billing-address-info .address_1').append('<div class="error error-address-1 active">' + genError + '</div>'); 
                    }else{
                        $('.billing-address-info .address_1').append('<div class="error error-address-1 ok active"> OK </div>');
                    }
                    if (data.errors.address_2) {
                        $('.billing-address-info .address_2').append('<div class="error error-address-2 active">' + genError + '</div>'); 
                    }else{
                         $('.billing-address-info .address_2').append('<div class="error error-address-2 ok active"> OK </div>');
                    }
                    if (data.errors.province) {
                        $('.billing-address-info .province').append('<div class="error error-province active">' + genError + '</div>'); 
                    }else{
                         $('.billing-address-info .province').append('<div class="error error-province ok active"> OK </div>');
                    }
                    if (data.errors.city) {
                        $('.billing-address-info .city').append('<div class="error error-city active">' + genError + '</div>'); 
                    }else{
                         $('.billing-address-info .city').append('<div class="error error-city ok active"> OK </div>');
                    }
                    if (data.errors.postal_code) {
                        $('.billing-address-info .postal-code').append('<div class="error error-postal active">' + genError + '</div>'); 
                    }else{
                         $('.billing-address-info .postal-code').append('<div class="error error-postal ok active"> OK </div>');
                    }

            }else{

                var temp_path = '.payment-info .billing-address .sync_components .billing-address-info';
                temporary_data[12] = $(temp_path+' input[name="address_1"]').val();
                temporary_data[13] = $(temp_path+' input[name="address_2"]').val();
                temporary_data[14] = $(temp_path+' input[name="city"]').val();
                temporary_data[15] = $(temp_path+' input[name="province"]').val();
                temporary_data[16] = $(temp_path+' input[name="postal_code"]').val();
                temporary_data[17] = $(temp_path+' input[name="easync_payment_nonce"]').val();
                

                var formData = {
                    'type'                  : 'hotel',
                    'room_id'               : temporary_data[0],
                    'arrival_date'          : temporary_data[1],
                    'departure_date'        : temporary_data[2],
                    'night_number'          : temporary_data[3],
                    'guest_number'          : temporary_data[4],
                    'room_number'           : temporary_data[5],
                    'firstname'             : temporary_data[6],
                    'lastname'              : temporary_data[7],
                    'phone'                 : temporary_data[8],
                    'email'                 : temporary_data[9],
                    'facility_request'      : temporary_data[10],
                    'other_req'             : temporary_data[11],
                    'address_1'             : temporary_data[12],
                    'address_2'             : temporary_data[13],
                    'city'                  : temporary_data[14],
                    'province'              : temporary_data[15],
                    'postal_code'           : temporary_data[16],
                    'easync_payment_nonce'  : temporary_data[17],
                    'amount_to_pay'         : temporary_data[19],
                    'reference_number'      : temporary_data[20],
                    'action'                :'easync_session_store',
                };

                $.ajax({
                    type        : 'POST',
                    url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/session-store.php',
                    data        : formData, 
                    dataType    : 'json', 
                    encode      : true
                }).done(function(data) {
                    $('body').loading('stop');
                    $('.modall').css('z-index', '');
                    if (!data.success) {
                             console.log('Something wrong!');
                    }else{
                        temporary_data  = [];
                        $('.pay-now').attr({
                            'type'           : 'button',
                            'data-dismiss'   : 'modal',
                            'data-toggle'    : 'modal',
                            'data-targett'    : '#hotel_thank_you_modal',
                            'data-backdrop'  : 'static',
                            'data-keyboard'  : 'false' 
                        });
                        //$('.pay-now').click();
                        $('.pay-now').attr({
                            'type'           : 'submit'
                        });
                        $('.pay-now').removeAttr('data-dismiss');
                        $('.pay-now').removeAttr('data-toggle');
                        $('.pay-now').removeAttr('data-targett');
                        $('.pay-now').removeAttr('data-backdrop');
                        $('.pay-now').removeAttr('data-keyboard');

                        //$('#sync_payment_hotel_trig').submit();
                        temporary_entry[4] = 'success';
                    }
                });

            }
        });

        event.preventDefault();
    });

    $('#hotel_thank_you_modal .close').on('click', function(e) {
    	location.reload();
    });

   /* timeslot */
function timeslot(number) {
    $('#sync_timeslot'+number).on('submit', function(event){//diri
        $('body').loading();
        $('.modall').css('z-index', '0');
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type=option_timeslot"+number+"&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                    console.log('Something wrong!');
            }
            $('body').loading('stop');
            $('.modall').css('z-index', '');
            sweetfb();
        });
        event.preventDefault();
    });
}

function switching(id, type) {
    $(document).on('submit', id, function(event){
        $.ajax({
            type        : 'POST',
            url         : easync_admin_ajax_directory.ajaxurl,//sync_plugin_directory.pluginsUrl +'/easync/settings-save.php',
            data        : $(this).serialize()+ "&type="+type+"&action=easync_setting_save", 
            dataType    : 'json', 
            encode      : true
        }).done(function(data) {
            if (!data.success) {
                     console.log('Something wrong!');
            }else{
                location.reload();
            }
        });
        event.preventDefault();
    });
}

function truggerOnSwitch(id, thiss) {
    var pr = $(thiss).parent();
    var temp_val = 'off';
    if(pr.find('.NubWrapper').hasClass('Checked', false) === true) {
        temp_val = 'on';
    }else{
        temp_val = 'off';
    }
   
    $('#sync_switch_toggle .modal-footer form').removeAttr('id');
    $('#sync_switch_toggle .modal-footer form').attr('id', id);
    $('#sync_switch_toggle .modal-footer form input').val(temp_val);
    $('#sync_switch_toggle').modal('show');
    $('#'+id+' button[type="button"]').attr('data-close', thiss.id);
    $('#'+id+' button[type="button"]').attr('data-onoff', temp_val);
}

function toCurrency(amount) {
    amount = amount.toFixed(2);
    amount = amount.toString().replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
    return amount;
}
});

function sweetfb() {
    swal(
      'Done',
      'Success!',
      'success'
    )
}

function sweetfb_reload() {
    swal(
      'Done',
      'Success!',
      'success'
    ).then(function() {
        location.reload();
    });
}

jQuery(document).ready(function(){
    jQuery('#reserved_table .table_guest .sync-guest.quantity .quantity-nav').css('display', 'block');
    jQuery('#reserved_table .table_guest .sync-table.quantity .quantity-nav').css('display', 'block');
    jQuery('#file-input').on('change', function(event){ 
        if (window.File && window.FileReader && window.FileList && window.Blob) {//check File API supported browser

            var data = jQuery('#upload_car_images #file-input')[0].files; //this file data
            var fileUpload = jQuery("input[type='file']");
            var size = 2024;
            var length = 10;
            var accept_ext =  /(\.jpg|\.jpeg|\.png)$/i;
            var name = fileUpload.val();

            for (var i = 0; i < data.length; i++ ) {
                if ( !accept_ext.exec(data[i].name) ) {
                    alert("Invalid image type, image must be .JPEG, .JPG or .PNG" );
                    this.value = "";
                }
            }

            if (parseInt(fileUpload.get(0).files.length)>length){
                alert("You can only upload a maximum of " +length+ " files.");
                this.value = "";
            }
            else if(this.files[0].size > 2097152){
                alert("File is too big. Maximum size per image should only be " +size+ "KB." );
                this.value = "";
            }
            else {
                jQuery.each(data, function(index, file){ 
                    var fRead = new FileReader(); 
                    fRead.onload = (function(file){ 
                    return function(e) {
                        var img = jQuery('<img/>').addClass('thumb').attr('src', e.target.result); 
                        jQuery('#thumb-output').append(img); 
                    };
                    })(file);
                    fRead.readAsDataURL(file); 
                    
                });
                jQuery('#upload_car_image .remove.btn.btn-danger').show();
            }
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });
  
    jQuery("#upload_car_images .remove").click(function (e) {
        e.preventDefault();
        jQuery('#upload_car_images #thumb-output').empty();
        jQuery('#upload_car_images #file-input').val('');
    });
});

jQuery(document).on('click', '.get_reference .search_ref', function () {
    var ref_number = jQuery(".get_reference .ref_number").val();
    var now = new Date();
    var format_date = String(now.getMonth() + 1).padStart(2, '0') + '/' + String(now.getDate()).padStart(2, '0') + '/' + now.getFullYear();
    
    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "get_booking_details", ref: ref_number },
        success: function(data){

            if (data == 'No Record') {
                jQuery('.alert.alert-danger').remove();
                jQuery('#booking_notFound').modal('show');
            } else {
                current_date = new Date(format_date);
                start_date = new Date(data[0].arrival_date);
                var subt = start_date - current_date;
                var days = subt /(1000 * 3600 * 24);
                day = Math.round(days);
                var price = data[3];
                jQuery('.alert.alert-danger').remove();
                jQuery(".booking-details .cust_name").empty();
                jQuery(".booking-details .book_head").empty();
                jQuery(".booking-details .person_info .person_labels").empty();
                jQuery(".booking-details .person_info .person_data").empty();
                jQuery(".booking-details .booking_details .booking_labels").empty();
                jQuery(".booking-details .booking_details .booking_data").empty();
                
                jQuery(".booking-details .cancel_section .cancel_booking").attr('id', data[0].id);
                jQuery(".booking-details .cust_name").append("<span class='name'><strong>" +data[0].firstname+" " +data[0].lastname+ "</strong></span>");
                jQuery(".booking-details .person_info .person_labels").append("<span><strong>Email: </strong></span>");
                jQuery(".booking-details .person_info .person_labels").append("<span><strong>Mobile Number: </strong></span>");
                jQuery(".booking-details .person_info .person_data").append("<span>" +data[0].email+"</span>");
                jQuery(".booking-details .person_info .person_data").append("<span>" +data[0].phone+"</span><br>");

                jQuery(".booking-details .book_head").append("<span class='dtls'><strong>Booking Details</strong></span>");

                jQuery(".booking-details .booking_details .booking_labels").append("<span><strong>Room Number:</strong></span>");
                jQuery(".booking-details .booking_details .booking_labels").append("<span><strong>Guest/s: </strong></span>");
                jQuery(".booking-details .booking_details .booking_labels").append("<span><strong>Arrival: </strong></span>");
                jQuery(".booking-details .booking_details .booking_labels").append("<span><strong>Departure: </strong></span>");
                jQuery(".booking-details .booking_details .booking_labels").append("<span><strong>Number of Nights: </strong></span>");
                if (data[0].facility_request != "") {
                    jQuery(".booking-details .booking_details .booking_labels").append("<span><strong>Facility Requests: </strong></span>");
                }
                if (data[0].other_req != "") {
                    jQuery(".booking-details .booking_details .booking_labels").append("<span><strong>Other Requests: </strong></span>");
                }
                jQuery(".booking-details .booking_details .booking_labels").append("<span><strong>Checkin Price: </strong></span>");

                jQuery(".booking-details .booking_details .booking_data").append("<span>" +data[0].room_number+ "</span>");
                jQuery(".booking-details .booking_details .booking_data").append("<span>" +data[0].guest_number+ "</span>");
                jQuery(".booking-details .booking_details .booking_data").append("<span>" +data[0].arrival_date+ "</span>");
                jQuery(".booking-details .booking_details .booking_data").append("<span>" +data[0].departure_date+ "</span>");
                jQuery(".booking-details .booking_details .booking_data").append("<span>" +data[0].night_number+ "</span>");
                if (data[0].facility_request != "") {
                    jQuery(".booking-details .booking_details .booking_data").append("<span>" +data[0].facility_request+ "</span>");
                }
                if (data[0].other_req != "") {
                    jQuery(".booking-details .booking_details .booking_data").append("<span>" +data[0].other_req+ "</span>");
                }
                jQuery(".booking-details .booking_details .booking_data").append("<span>" +data[4]+ " " +price+ "</span>");

                if ( (day < data[1]) || (data[2] == 'cancelled') || (data[0].status != 'pending') ) {
                    jQuery('.cancel_section .cancel_booking').prop('disabled', true);
                    jQuery('.cancel_section .cancel_booking').css('cursor', 'not-allowed');
                    jQuery('.cancel_section .cancel_booking').css('background', 'gray');
                }
                
                jQuery('body').loading();
                jQuery('#booking_info').modal('show');
            }
        }
    });
});

jQuery(document).on('click', '.cancel_section .cancel_booking', function () {

    var book_id = this.id;

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "cancel_booking", id: book_id },
        success: function(data){
   
            jQuery(".cancel_details .breakdown_details .breakdown_labels").empty();
            jQuery(".cancel_details .return_details .return_label").empty();
            jQuery(".cancel_details .breakdown_details .breakdown_calculation").empty();
            jQuery(".cancel_details .return_details .return_amount").empty();
            
            jQuery(".cancel_details .breakdown_details .breakdown_labels").append("<span>Amount Paid:</span>");
            jQuery(".cancel_details .breakdown_details .breakdown_labels").append("<span>Cancellation Cost/Fee:</span>");
            jQuery(".cancel_details .return_details .return_label").append("<span>Refund Amount:</span>");
            
            jQuery(".cancel_details .breakdown_details .breakdown_calculation").append("<span>" +data[3]+ " " +data[0]+ "</span>");
            jQuery(".cancel_details .breakdown_details .breakdown_calculation").append("<span>" +data[3]+ " " +data[1]+ "</span>");
            jQuery(".cancel_details .return_details .return_amount").append("<span>" +data[3]+ " " +data[2]+ "</span>");
            jQuery(".confirm_cancel").attr('id', data[4]);

            jQuery("#booking_info").hide();
            jQuery("#show_cancel").modal('show');

        }
    });
});

jQuery(document).on('click', '.cancel_section .cancel_reservation', function () {

    var reserve_id = this.id;

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "cancel_reservation", id: reserve_id },
        success: function(data){
                jQuery(".cancel_details .breakdown_details .breakdown_labels").empty();
                jQuery(".cancel_details .return_details .return_label").empty();
                jQuery(".cancel_details .breakdown_details .breakdown_calculation").empty();
                jQuery(".cancel_details .return_details .return_amount").empty();
                
                jQuery(".cancel_details .breakdown_details .breakdown_labels").append("<span>Amount Paid:</span>");
                jQuery(".cancel_details .breakdown_details .breakdown_labels").append("<span>Cancellation Cost/Fee:</span>");
                jQuery(".cancel_details .return_details .return_label").append("<span>Refund Amount:</span>");
                
                jQuery(".cancel_details .breakdown_details .breakdown_calculation").append("<span>" +data[3]+ " " +data[0]+ "</span>");
                jQuery(".cancel_details .breakdown_details .breakdown_calculation").append("<span>" +data[3]+ " " +data[1]+ "</span>");
                jQuery(".cancel_details .return_details .return_amount").append("<span>" +data[3]+ " " +data[2]+ "</span>");
                jQuery(".confirm_cancel_restau").attr('id', data[4]);

                jQuery("#reservation_info_restau").removeClass('show_modal');
                jQuery("#reservation_info_restau").addClass('hide_modal');
                jQuery("#show_cancel").modal('show');

        }
    });
});

jQuery(document).on('click', '.confirm_cancel', function () {
    var id = this.id

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "confirm_cancel", id: id },
        success: function(data){
            jQuery("#show_cancel").hide();
            jQuery("#cancel_success").modal('show');
        }
    });
});

jQuery(document).on('click', '.confirm_cancel_restau', function () {
    var id = this.id

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "confirm_cancel_restau", id: id },
        success: function(data){
            jQuery("#show_cancel").hide();
            jQuery("#cancel_success").modal('show');
        }
    });
});

jQuery(document).on('submit', '#sync_hotel_emails', function(event){
    jQuery('body').loading();
    jQuery('.modall').css('z-index', '0');
    var type = jQuery("#email_type").val();
    var head_text = jQuery("#email-header-text").val();
    var body_text = jQuery("#email-body-text").val();
    var footer_text = jQuery("#email-footer-text").val();
    var check1 = jQuery("#7days").is(":checked"); 
    var check3 = jQuery("#3days").is(":checked");
    var check7 = jQuery("#1days").is(":checked");

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "save_request_cancel_content", type: type, head_text: head_text, body_text: body_text, footer_text: footer_text, check1: check1, check3: check3, check7: check7 },
        success: function(data){
            jQuery('body').loading('stop');
            jQuery('.modall').css('z-index', '');
            sweetfb();
        }
    });
    
    event.preventDefault();
});

jQuery(document).on('change', '#sync_hotel_emails #email_type', function () {

    var value = jQuery(this).val();
    jQuery('#save_email_cntnt').removeAttr('disabled');
    if (value == "1") {

        jQuery("#email-body-text").show();
        jQuery("#body_label").show();
        jQuery("#br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "request_cancel"},
            success: function(data){
                jQuery("#email-header-text").empty();
                jQuery("#email-body-text").empty();
                jQuery("#email-footer-text").empty();
                
                jQuery("#email-header-text").val(data[0]);
                jQuery("#email-body-text").val(data[1]);
                jQuery("#email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "2") {

        jQuery("#email-body-text").show();
        jQuery("#body_label").show();
        jQuery("#br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "request_cancel_admin"},
            success: function(data){
                jQuery("#email-header-text").empty();
                jQuery("#email-body-text").empty();
                jQuery("#email-footer-text").empty();

                jQuery("#email-header-text").val(data[0]);
                jQuery("#email-body-text").val(data[1]);
                jQuery("#email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "3") {

        jQuery("#email-body-text").show();
        jQuery("#body_label").show();
        jQuery("#br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "request_cancel_declined"},
            success: function(data){
                jQuery("#email-header-text").empty();
                jQuery("#email-body-text").empty();
                jQuery("#email-footer-text").empty();

                jQuery("#email-header-text").val(data[0]);
                jQuery("#email-body-text").val(data[1]);
                jQuery("#email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "4") {

        jQuery("#email-body-text").show();
        jQuery("#body_label").show();
        jQuery("#br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "request_cancel_approved"},
            success: function(data){
                jQuery("#email-header-text").empty();
                jQuery("#email-body-text").empty();
                jQuery("#email-footer-text").empty();

                jQuery("#email-header-text").val(data[0]);
                jQuery("#email-body-text").val(data[1]);
                jQuery("#email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "5") {

        jQuery("#email-body-text").show();
        jQuery("#body_label").show();
        jQuery("#br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "email_reminder7"},
            success: function(data){
                jQuery("#email-header-text").empty();
                jQuery("#email-body-text").empty();
                jQuery("#email-footer-text").empty();

                jQuery("#email-header-text").val(data[0]);
                jQuery("#email-body-text").val(data[1]);
                jQuery("#email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "6") {

        jQuery("#email-body-text").show();
        jQuery("#body_label").show();
        jQuery("#br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "email_reminder3"},
            success: function(data){
                jQuery("#email-header-text").empty();
                jQuery("#email-body-text").empty();
                jQuery("#email-footer-text").empty();

                jQuery("#email-header-text").val(data[0]);
                jQuery("#email-body-text").val(data[1]);
                jQuery("#email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "7") {

        jQuery("#email-body-text").show();
        jQuery("#body_label").show();
        jQuery("#br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "email_reminder1"},
            success: function(data){
                jQuery("#email-header-text").empty();
                jQuery("#email-body-text").empty();
                jQuery("#email-footer-text").empty();

                jQuery("#email-header-text").val(data[0]);
                jQuery("#email-body-text").val(data[1]);
                jQuery("#email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "8") {

        jQuery("#email-body-text").hide();
        jQuery("#body_label").hide();
        jQuery("#br_body").remove();
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "option_hotel_email_notify"},
            success: function(data){
                jQuery("#email-header-text").empty();
                jQuery("#email-footer-text").empty();

                jQuery("#email-header-text").val(data[0]);
                jQuery("#email-footer-text").val(data[1]);
            }
        });
    }
    
});

jQuery(document).on('submit', '#sync_car_emails', function(event){
    jQuery('body').loading();
    jQuery('.modall').css('z-index', '0');
    jQuery('#save_email_cntnt').removeAttr('disabled');
    var type = jQuery("#car_email_type").val();
    var head_text = jQuery("#email-text-header").val();
    var body_text = jQuery("#email-text-body").val();
    var footer_text = jQuery("#email-text-footer").val();
    var check1 = jQuery("#7days").is(':checked'); 
    var check3 = jQuery("#3days").is(':checked');
    var check7 = jQuery("#1days").is(':checked');

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "save_request_cancel_content_car", type: type, head_text: head_text, body_text: body_text, footer_text: footer_text, check1: check1, check3: check3, check7: check7  },
        success: function(data){
            jQuery('body').loading('stop');
            jQuery('.modall').css('z-index', '');
            sweetfb();
        }
    });
    
    event.preventDefault();
});

jQuery(document).on('submit', '#sync_restau_emails', function(event){
    jQuery('body').loading();
    jQuery('.modall').css('z-index', '0');
    
    var type = jQuery("#sync_restau_emails #email_type").val();
    var head_text = jQuery("#sync_restau_emails #email-header-text").val();
    var body_text = jQuery("#sync_restau_emails #email-body-text").val();
    var footer_text = jQuery("#sync_restau_emails #email-footer-text").val();
    var check1 = jQuery("#sync_restau_emails #7days").is(':checked'); 
    var check3 = jQuery("#sync_restau_emails #3days").is(':checked');
    var check7 = jQuery("#sync_restau_emails #1days").is(':checked');

    jQuery.ajax({
        type: "POST",
        dataType: "json",     
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "save_request_cancel_content_restau", type: type, head_text: head_text, body_text: body_text, footer_text: footer_text, check1: check1, check3: check3, check7: check7  },
        success: function(data){
            jQuery('body').loading('stop');
            jQuery('.modall').css('z-index', '');
            sweetfb();
        }
    });
    
    event.preventDefault();
});


jQuery(document).on('change', '#sync_car_emails #car_email_type', function () {

    jQuery('#sync_car_emails #save_email_cntnt').removeAttr('disabled');
    var value = jQuery(this).val();
    if (value == "1") {

        jQuery("#email-text-body").show();
        jQuery("#body_label").show();
        jQuery("#br_car_body").remove();
        jQuery("<br id='br_car_body'>").insertAfter("#email-text-body");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "car_request_cancel"},
            success: function(data){
                jQuery("#email-text-header").empty();
                jQuery("#email-text-body").empty();
                jQuery("#email-text-footer").empty();
                
                jQuery("#email-text-header").val(data[0]);
                jQuery("#email-text-body").val(data[1]);
                jQuery("#email-text-footer").val(data[2]);
            }
        });
    }

    if (value == "2") {

        jQuery("#email-text-body").show();
        jQuery("#body_label").show();
        jQuery("#br_car_body").remove();
        jQuery("<br id='br_car_body'>").insertAfter("#email-text-body");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "car_request_cancel_admin"},
            success: function(data){
                jQuery("#email-text-header").empty();
                jQuery("#email-text-body").empty();
                jQuery("#email-text-footer").empty();

                jQuery("#email-text-header").val(data[0]);
                jQuery("#email-text-body").val(data[1]);
                jQuery("#email-text-footer").val(data[2]);
            }
        });
    }

    if (value == "3") {

        jQuery("#email-text-body").show();
        jQuery("#body_label").show();
        jQuery("#br_car_body").remove();
        jQuery("<br id='br_car_body'>").insertAfter("#email-text-body");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "car_request_cancel_declined"},
            success: function(data){
                jQuery("#email-text-header").empty();
                jQuery("#email-text-body").empty();
                jQuery("#email-text-footer").empty();

                jQuery("#email-text-header").val(data[0]);
                jQuery("#email-text-body").val(data[1]);
                jQuery("#email-text-footer").val(data[2]);
            }
        });
    }

    if (value == "4") {

        jQuery("#email-text-body").show();
        jQuery("#body_label").show();
        jQuery("#br_car_body").remove();
        jQuery("<br id='br_car_body'>").insertAfter("#email-text-body");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "car_request_cancel_approved"},
            success: function(data){
                jQuery("#email-text-header").empty();
                jQuery("#email-text-body").empty();
                jQuery("#email-text-footer").empty();

                jQuery("#email-text-header").val(data[0]);
                jQuery("#email-text-body").val(data[1]);
                jQuery("#email-text-footer").val(data[2]);
            }
        });
    }

    if (value == "5") {

        jQuery("#email-text-body").show();
        jQuery("#body_label").show();
        jQuery("#br_car_body").remove();
        jQuery("<br id='br_car_body'>").insertAfter("#email-text-body");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "car_email_reminder7"},
            success: function(data){
                jQuery("#email-text-header").empty();
                jQuery("#email-text-body").empty();
                jQuery("#email-text-footer").empty();

                jQuery("#email-text-header").val(data[0]);
                jQuery("#email-text-body").val(data[1]);
                jQuery("#email-text-footer").val(data[2]);
            }
        });
    }

    if (value == "6") {

        jQuery("#email-text-body").show();
        jQuery("#body_label").show();
        jQuery("#br_car_body").remove();
        jQuery("<br id='br_car_body'>").insertAfter("#email-text-body");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "car_email_reminder3"},
            success: function(data){
                jQuery("#email-text-header").empty();
                jQuery("#email-text-body").empty();
                jQuery("#email-text-footer").empty();

                jQuery("#email-text-header").val(data[0]);
                jQuery("#email-text-body").val(data[1]);
                jQuery("#email-text-footer").val(data[2]);
            }
        });
    }

    if (value == "7") {

        jQuery("#email-text-body").show();
        jQuery("#body_label").show();
        jQuery("#br_car_body").remove();
        jQuery("<br id='br_car_body'>").insertAfter("#email-text-body");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "car_email_reminder1"},
            success: function(data){
                jQuery("#email-text-header").empty();
                jQuery("#email-text-body").empty();
                jQuery("#email-text-footer").empty();

                jQuery("#email-text-header").val(data[0]);
                jQuery("#email-text-body").val(data[1]);
                jQuery("#email-text-footer").val(data[2]);
            }
        });
    }

    if (value == "8") {

        jQuery("#email-text-body").hide();
        jQuery("#body_label").hide();
        jQuery("#br_car_body").remove();
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "option_car_email_notify"},
            success: function(data){
                jQuery("#email-text-header").empty();
                jQuery("#email-text-footer").empty();

                jQuery("#email-text-header").val(data[0]);
                jQuery("#email-text-footer").val(data[1]);
            }
        });
    }
});

jQuery(document).on('change', '#sync_restau_emails #email_type', function () {

    jQuery('#sync_restau_emails #save_email_cntnt').removeAttr('disabled');
    var value = jQuery(this).val();
    if (value == "1") {

        jQuery("#sync_restau_emails #email-body-text").show();
        jQuery("#sync_restau_emails #body_label").show();
        jQuery("#sync_restau_emails #br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#sync_restau_emails #email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "restau_request_cancel"},
            success: function(data){
                jQuery("#sync_restau_emails #email-header-text").empty();
                jQuery("#sync_restau_emails #email-body-text").empty();
                jQuery("#sync_restau_emails #email-footer-text").empty();
                
                jQuery("#sync_restau_emails #email-header-text").val(data[0]);
                jQuery("#sync_restau_emails #email-body-text").val(data[1]);
                jQuery("#sync_restau_emails #email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "2") {

        jQuery("#sync_restau_emails #email-body-text").show();
        jQuery("#sync_restau_emails #body_label").show();
        jQuery("#sync_restau_emails #br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#sync_restau_emails #email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "restau_request_cancel_admin"},
            success: function(data){
                jQuery("#sync_restau_emails #email-header-text").empty();
                jQuery("#sync_restau_emails #email-body-text").empty();
                jQuery("#sync_restau_emails #email-footer-text").empty();
                
                jQuery("#sync_restau_emails #email-header-text").val(data[0]);
                jQuery("#sync_restau_emails #email-body-text").val(data[1]);
                jQuery("#sync_restau_emails #email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "3") {

        jQuery("#sync_restau_emails #email-body-text").show();
        jQuery("#sync_restau_emails #body_label").show();
        jQuery("#sync_restau_emails #br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#sync_restau_emails #email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "restau_request_cancel_declined"},
            success: function(data){
                jQuery("#sync_restau_emails #email-header-text").empty();
                jQuery("#sync_restau_emails #email-body-text").empty();
                jQuery("#sync_restau_emails #email-footer-text").empty();
                
                jQuery("#sync_restau_emails #email-header-text").val(data[0]);
                jQuery("#sync_restau_emails #email-body-text").val(data[1]);
                jQuery("#sync_restau_emails #email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "4") {

        jQuery("#sync_restau_emails #email-body-text").show();
        jQuery("#sync_restau_emails #body_label").show();
        jQuery("#sync_restau_emails #br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#sync_restau_emails #email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "restau_request_cancel_approved"},
            success: function(data){
                jQuery("#sync_restau_emails #email-header-text").empty();
                jQuery("#sync_restau_emails #email-body-text").empty();
                jQuery("#sync_restau_emails #email-footer-text").empty();
                
                jQuery("#sync_restau_emails #email-header-text").val(data[0]);
                jQuery("#sync_restau_emails #email-body-text").val(data[1]);
                jQuery("#sync_restau_emails #email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "5") {

        jQuery("#sync_restau_emails #email-body-text").show();
        jQuery("#sync_restau_emails #body_label").show();
        jQuery("#sync_restau_emails #br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#sync_restau_emails #email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "restau_email_reminder7"},
            success: function(data){
                jQuery("#sync_restau_emails #email-header-text").empty();
                jQuery("#sync_restau_emails #email-body-text").empty();
                jQuery("#sync_restau_emails #email-footer-text").empty();
                
                jQuery("#sync_restau_emails #email-header-text").val(data[0]);
                jQuery("#sync_restau_emails #email-body-text").val(data[1]);
                jQuery("#sync_restau_emails #email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "6") {

        jQuery("#sync_restau_emails #email-body-text").show();
        jQuery("#sync_restau_emails #body_label").show();
        jQuery("#sync_restau_emails #br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#sync_restau_emails #email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "restau_email_reminder3"},
            success: function(data){
                jQuery("#sync_restau_emails #email-header-text").empty();
                jQuery("#sync_restau_emails #email-body-text").empty();
                jQuery("#sync_restau_emails #email-footer-text").empty();
                
                jQuery("#sync_restau_emails #email-header-text").val(data[0]);
                jQuery("#sync_restau_emails #email-body-text").val(data[1]);
                jQuery("#sync_restau_emails #email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "7") {

        jQuery("#sync_restau_emails #email-body-text").show();
        jQuery("#sync_restau_emails #body_label").show();
        jQuery("#sync_restau_emails #br_body").remove();
        jQuery("<br id='br_body'>").insertAfter("#sync_restau_emails #email-body-text");
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "restau_email_reminder1"},
            success: function(data){
                jQuery("#sync_restau_emails #email-header-text").empty();
                jQuery("#sync_restau_emails #email-body-text").empty();
                jQuery("#sync_restau_emails #email-footer-text").empty();
                
                jQuery("#sync_restau_emails #email-header-text").val(data[0]);
                jQuery("#sync_restau_emails #email-body-text").val(data[1]);
                jQuery("#sync_restau_emails #email-footer-text").val(data[2]);
            }
        });
    }

    if (value == "8") {

        jQuery("#sync_restau_emails #email-body-text").hide();
        jQuery("#sync_restau_emails #body_label").hide();
        jQuery("#sync_restau_emails #br_body").remove();
        jQuery.ajax({
            type: "POST",
            dataType: "json",    
            url: easync_admin_ajax_directory.ajaxurl,
            data: { action: "option_restau_email_notify"},
            success: function(data){
                jQuery("#sync_restau_emails #email-header-text").empty();
                jQuery("#sync_restau_emails #email-footer-text").empty();
                
                jQuery("#sync_restau_emails #email-header-text").val(data[0]);
                jQuery("#sync_restau_emails #email-footer-text").val(data[1]);
            }
        });
    }
});

jQuery(document).on('click', '#sync_view_request_hotel .sync-approve-request', function() {
    var id = this.id;

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "approve_cancel_request", id: id},
        success: function(data){
            jQuery('#request_approved').modal('show');
            jQuery('#sync_view_request_hotel').modal('hide');
        }
    });
})

jQuery(document).on('click', '#sync_view_request_hotel .sync-decline-request', function() {
    var id = this.id;

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "decline_cancel_request", id: id},
        success: function(data){
            jQuery('#request_declined').modal('show');
            jQuery('#sync_view_request_hotel').modal('hide');


        }
    });
})


jQuery(document).on('click', '.get_reference .search_ref_car', function () {
    var ref_number = jQuery(".get_reference .ref_number").val();
    var now = new Date();
    var format_date = String(now.getMonth() + 1).padStart(2, '0') + '/' + String(now.getDate()).padStart(2, '0') + '/' + now.getFullYear();
    
    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "get_booking_details_car", ref: ref_number },
        success: function(data){

            if (data == 'No Record') {
                jQuery('.alert.alert-danger').remove();
                // jQuery('.get_reference .search_ref_car').after('<div class="alert alert-danger">Reference Number not found.</div>');
                jQuery('#rental_notFound').modal('show');

            } else {
                current_date = new Date(format_date);
                start_date = new Date(data[0].pick_date);
                var subt = start_date - current_date;
                var days = subt /(1000 * 3600 * 24);
                day = Math.round(days);
                var price = data[3];

                jQuery('.alert.alert-danger').remove();
                jQuery(".rental-details .cust_name").empty();
                jQuery(".rental-details .book_head").empty();
                jQuery(".rental-details .person_info .person_labels").empty();
                jQuery(".rental-details .person_info .person_data").empty();
                jQuery(".rental-details .rental_details .rental_labels").empty();
                jQuery(".rental-details .rental_details .rental_data").empty();
                
                jQuery(".rental-details .cancel_section .cancel_rental").attr('id', data[0].id);
                jQuery(".rental-details .cust_name").append("<span class='name'><strong>" +data[0].firstname+" " +data[0].lastname+ "</strong></span>");
                jQuery(".rental-details .person_info .person_labels").append("<span><strong>Email: </strong></span>");
                jQuery(".rental-details .person_info .person_labels").append("<span><strong>Mobile Number: </strong></span>");
                jQuery(".rental-details .person_info .person_data").append("<span>" +data[0].email+"</span>");
                jQuery(".rental-details .person_info .person_data").append("<span>" +data[0].phone+"</span><br>");

                jQuery(".rental-details .book_head").append("<span class='dtls'><strong>Rental Details</strong></span>");

                jQuery(".rental-details .rental_details .rental_labels").append("<span><strong>Car:</strong></span>");
                jQuery(".rental-details .rental_details .rental_labels").append("<span><strong>Pick Date: </strong></span>");
                jQuery(".rental-details .rental_details .rental_labels").append("<span><strong>Pick Time: </strong></span>");
                jQuery(".rental-details .rental_details .rental_labels").append("<span><strong>Return Date: </strong></span>");
                jQuery(".rental-details .rental_details .rental_labels").append("<span><strong>Return Time: </strong></span>");
                jQuery(".rental-details .rental_details .rental_labels").append("<span><strong>Number of Days: </strong></span>");
                if (data[0].facility_request != "") {
                    jQuery(".rental-details .rental_details .rental_labels").append("<span><strong>Facility Requests: </strong></span>");
                }
                if (data[0].other_req != "") {
                    jQuery(".rental-details .rental_details .rental_labels").append("<span><strong>Other Requests: </strong></span>");
                }
                jQuery(".rental-details .rental_details .rental_labels").append("<span><strong>Price: </strong></span>");

                jQuery(".rental-details .rental_details .rental_data").append("<span>" +data[5]+ "</span>");
                jQuery(".rental-details .rental_details .rental_data").append("<span>" +data[0].pick_date+"</span>");
                jQuery(".rental-details .rental_details .rental_data").append("<span>" +data[0].pick_time+ "</span>");
                jQuery(".rental-details .rental_details .rental_data").append("<span>" +data[0].return_date+"</span>");
                jQuery(".rental-details .rental_details .rental_data").append("<span>" +data[0].return_time+ "</span>");
                jQuery(".rental-details .rental_details .rental_data").append("<span>" +data[0].number_days+ "</span>");
                if (data[0].facility_request != "") {
                    jQuery(".rental-details .rental_details .rental_data").append("<span>" +data[0].facility_request+ "</span>");
                }
                if (data[0].other_req != "") {
                    jQuery(".rental-details .rental_details .rental_data").append("<span>" +data[0].other_req+ "</span>");
                }
                jQuery(".rental-details .rental_details .rental_data").append("<span>" +data[4]+ " " +price+ "</span>");

                if ( (day < data[1]) || (data[2] == 'cancelled') || (data[0].status != 'pending') ) {
                    jQuery('.cancel_section .cancel_rental').prop('disabled', true);
                    jQuery('.cancel_section .cancel_rental').css('cursor', 'not-allowed');
                    jQuery('.cancel_section .cancel_rental').css('background', 'gray');
                }
                
                jQuery('#rental_info').modal('show');
            }

            
        }
    });
});

jQuery(document).on('click', '.cancel_section .cancel_rental', function () {

    var rent_id = this.id;

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "cancel_rental", id: rent_id },
        success: function(data){
   
            jQuery(".cancel_details .breakdown_details .breakdown_labels").empty();
            jQuery(".cancel_details .return_details .return_label").empty();
            jQuery(".cancel_details .breakdown_details .breakdown_calculation").empty();
            jQuery(".cancel_details .return_details .return_amount").empty();
            
            jQuery(".cancel_details .breakdown_details .breakdown_labels").append("<span>Amount Paid:</span>");
            jQuery(".cancel_details .breakdown_details .breakdown_labels").append("<span>Cancellation Cost/Fee:</span>");
            jQuery(".cancel_details .return_details .return_label").append("<span>Refund Amount:</span>");
            
            jQuery(".cancel_details .breakdown_details .breakdown_calculation").append("<span>" +data[3]+ " " +data[0]+ "</span>");
            jQuery(".cancel_details .breakdown_details .breakdown_calculation").append("<span>" +data[3]+ " " +data[1]+ "</span>");
            jQuery(".cancel_details .return_details .return_amount").append("<span>" +data[3]+ " " +data[2]+ "</span>");
            jQuery(".confirm_cancel_car").attr('id', data[4]);

            jQuery("#rental_info").hide();
            jQuery("#show_cancel_car").modal('show');

        }
    });
});

jQuery(document).on('click', '.confirm_cancel_car', function () {
    var id = this.id

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "confirm_cancel_car", id: id },
        success: function(data){
            jQuery("#show_cancel_car").hide();
            jQuery("#cancel_success_car").modal('show');
        }
    });
});

jQuery(document).on('click', '#sync_view_request_car .sync-approve-request', function() {
    var id = this.id;

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "approve_cancel_request_car", id: id},
        success: function(data){
            jQuery('#request_approved_car').modal('show');
            jQuery('#sync_view_request_car').modal('hide');


        }
    });
})

jQuery(document).on('click', '#sync_view_request_car .sync-decline-request', function() {
    var id = this.id;

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "decline_cancel_request_car", id: id},
        success: function(data){
            jQuery('#request_declined_car').modal('show');
            jQuery('#sync_view_request_car').modal('hide');

        }
    });
});

jQuery(document).on('click', '.get_reference .search_ref_restau', function () {
    var ref_number = jQuery(".get_reference .ref_number").val();
    var now = new Date();
    var format_date = String(now.getMonth() + 1).padStart(2, '0') + '/' + String(now.getDate()).padStart(2, '0') + '/' + now.getFullYear();
    
    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "get_booking_details_restau", ref: ref_number },
        success: function(data){

            if (data == 'No Record') {
                jQuery('.alert.alert-danger').remove();
                jQuery('#reserve_notFound').modal('show');
                // jQuery('.get_reference .search_ref_restau').after('<div class="alert alert-danger">Reference Number not found.</div>');
            } else {
                current_date = new Date(format_date);
                start_date = new Date(data[0].pick_date);
                var subt = start_date - current_date;
                var days = subt /(1000 * 3600 * 24);
                day = Math.round(days);
                var price = data[3];
                var menus = "";

                jQuery('.alert.alert-danger').remove();
                jQuery(".reservation-details .cust_name").empty();
                jQuery(".reservation-details .book_head").empty();
                jQuery(".reservation-details .reservation_details .person_email").empty();
                jQuery(".reservation-details .reservation_details .person_phone").empty();
                jQuery(".reservation-details .reservation_details .reservation_date").empty();
                jQuery(".reservation-details .reservation_details .reservation_time").empty();
                jQuery(".reservation-details .reservation_details .reservation_branch").empty();
                jQuery(".reservation-details .reservation_details .reservation_table").empty();
                jQuery(".reservation-details .reservation_details .reservation_guests").empty();
                jQuery(".reservation-details .reservation_details .reservation_paid").empty();
                jQuery(".reservation-details .reservation_details .menu_name").empty();
                
                jQuery("#reservation_info_restau .cancel_section .cancel_reservation").attr('id', data[0].id);
                jQuery(".reservation-details .cust_name").append("<span class='name'><strong>" +data[0].name+ "</strong></span>");
                jQuery(".reservation-details .reservation_details .person_email").append("<span><strong>Email: </strong></span>");
                jQuery(".reservation-details .reservation_details .person_phone").append("<span><strong>Mobile Number: </strong></span>");
                jQuery(".reservation-details .reservation_details .person_email").append("<span>" +data[0].email+"</span>");
                jQuery(".reservation-details .reservation_details .person_phone").append("<span>" +data[0].phone+"</span><br>");

                jQuery(".reservation-details .book_head").append("<span class='dtls'><strong>Reservation Details</strong></span>");

                jQuery(".reservation-details .reservation_details .menu_name").append("<span><strong>Menu Reserved: </strong></span>");
                for (let i = 0; i < data[5].length; i++) {
                    menus += data[5][i] + " - QTY (" + data[6][i] + ") <br>";
                }
                menus = menus.replace(/,\s*$/, "");
                jQuery(".reservation-details .reservation_details .menu_name").append("<span>" + menus + "</span>");

                jQuery(".reservation-details .reservation_details .reservation_date").append("<span><strong>Reservation Date: </strong></span>");
                jQuery(".reservation-details .reservation_details .reservation_time").append("<span><strong>Timeslot: </strong></span>");
                jQuery(".reservation-details .reservation_details .reservation_branch").append("<span><strong>Branch: </strong></span>");
                jQuery(".reservation-details .reservation_details .reservation_table").append("<span><strong>Number of Tables: </strong></span>");
                jQuery(".reservation-details .reservation_details .reservation_guests").append("<span><strong>Number of Guests: </strong></span>");
                jQuery(".reservation-details .reservation_details .reservation_paid").append("<span><strong>Amount Paid: </strong></span>");

                jQuery(".reservation-details .reservation_details .reservation_date").append("<span>" +data[0].pick_date+"</span>");
                jQuery(".reservation-details .reservation_details .reservation_time").append("<span>" +data[0].timeslot+ "</span>");
                jQuery(".reservation-details .reservation_details .reservation_branch").append("<span>" +data[0].branch+"</span>");
                jQuery(".reservation-details .reservation_details .reservation_table").append("<span>" +data[0].table_no+ "</span>");
                jQuery(".reservation-details .reservation_details .reservation_guests").append("<span>" +data[0].guest_no+ "</span>");
                jQuery(".reservation-details .reservation_details .reservation_paid").append("<span>" +data[4]+ " " +price+ "</span>");

                if ( (day < data[1]) || (data[2] == 'cancelled') || (data[0].status != 'pending') ) {
                    jQuery('.cancel_section .cancel_reservation').prop('disabled', true);
                    jQuery('.cancel_section .cancel_reservation').css('cursor', 'not-allowed');
                    jQuery('.cancel_section .cancel_reservation').css('background', 'gray');
                }
                
                jQuery('#reservation_info_restau').modal('show');
            }

            
        }
    });
});

jQuery(document).on('click', '#sync_view_request_restau .sync-approve-request', function() {
    var id = this.id;

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "approve_cancel_request_restau", id: id},
        success: function(data){
            jQuery('#request_approved_restau').modal('show');
            jQuery('#sync_view_request_restau').modal('hide');


        }
    });
})

jQuery(document).on('click', '#sync_view_request_restau .sync-decline-request', function() {
    var id = this.id;

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: { action: "decline_cancel_request_restau", id: id},
        success: function(data){
            jQuery('#request_declined_restau').modal('show');
            jQuery('#sync_view_request_restau').modal('hide');

        }
    });
});

jQuery(document).ready(function () {
    
    const fname_initial = jQuery("#fname_require").is(':checked');
    const lname_initial = jQuery("#lname_require").is(':checked');
    const phone_initial = jQuery("#phone_require").is(':checked');
    const email_initial = jQuery("#email_require").is(':checked');

    jQuery('#fname_display').on('change', function () {

        var check = jQuery("#fname_display").is(':checked');
        
        if (check) {
            jQuery('#fname_require').prop('disabled', 'true');
            if (jQuery('#fname_require').is(':checked')) {
                jQuery('#fname_require').removeAttr('checked');
                
            }  
        }
        else {
            jQuery('#fname_require').removeAttr('disabled');
            if (fname_initial == true ) {
                jQuery('#fname_require').prop('checked', 'true');
            }
        }
    })

    jQuery('#lname_display').on('change', function () {

        var check = jQuery("#lname_display").is(':checked');
        
        if (check) {
            jQuery('#lname_require').prop('disabled', 'true');
            if (jQuery('#lname_require').is(':checked')) {
                jQuery('#lname_require').removeAttr('checked');
                
            }  
        }
        else {
            jQuery('#lname_require').removeAttr('disabled');
            if (lname_initial == true ) {
                jQuery('#lname_require').prop('checked', 'true');
            }
        }
    })

    jQuery('#phone_display').on('change', function () {

        var check = jQuery("#phone_display").is(':checked');
        
        if (check) {
            jQuery('#phone_require').prop('disabled', 'true');
            if (jQuery('#phone_require').is(':checked')) {
                jQuery('#phone_require').removeAttr('checked');
                
            }  
        }
        else {
            jQuery('#phone_require').removeAttr('disabled');
            if (phone_initial == true ) {
                jQuery('#phone_require').prop('checked', 'true');
            }
        }
    })

    jQuery('#email_display').on('change', function () {

        var check = jQuery("#email_display").is(':checked');
        
        if (check) {
            jQuery('#email_require').prop('disabled', 'true');
            if (jQuery('#email_require').is(':checked')) {
                jQuery('#email_require').removeAttr('checked');
                
            }  
        }
        else {
            jQuery('#email_require').removeAttr('disabled');
            if (email_initial == true ) {
                jQuery('#email_require').prop('checked', 'true');
            }
        }
    })
});


jQuery(document).ready(function () {
    
    const fname_initial_car = jQuery("#fname_require_car").is(':checked');
    const lname_initial_car = jQuery("#lname_require_car").is(':checked');
    const phone_initial_car = jQuery("#phone_require_car").is(':checked');
    const email_initial_car = jQuery("#email_require_car").is(':checked');

    jQuery('#fname_display_car').on('change', function () {

        var check_car = jQuery("#fname_display_car").is(':checked');
        
        if (check_car) {
            jQuery('#fname_require_car').prop('disabled', 'true');
            if (jQuery('#fname_require_car').is(':checked')) {
                jQuery('#fname_require_car').removeAttr('checked');
                
            }  
        }
        else {
            jQuery('#fname_require_car').removeAttr('disabled');
            if (fname_initial_car == true ) {
                jQuery('#fname_require_car').prop('checked', 'true');
            }
        }
    })

    jQuery('#lname_display_car').on('change', function () {

        var check = jQuery("#lname_display_car").is(':checked');
        
        if (check) {
            jQuery('#lname_require_car').prop('disabled', 'true');
            if (jQuery('#lname_require_car').is(':checked')) {
                jQuery('#lname_require_car').removeAttr('checked');
                
            }  
        }
        else {
            jQuery('#lname_require_car').removeAttr('disabled');
            if (lname_initial_car == true ) {
                jQuery('#lname_require_car').prop('checked', 'true');
            }
        }
    })

    jQuery('#phone_display_car').on('change', function () {

        var check = jQuery("#phone_display_car").is(':checked');
        
        if (check) {
            jQuery('#phone_require_car').prop('disabled', 'true');
            if (jQuery('#phone_require_car').is(':checked')) {
                jQuery('#phone_require_car').removeAttr('checked');
                
            }  
        }
        else {
            jQuery('#phone_require_car').removeAttr('disabled');
            if (phone_initial_car == true ) {
                jQuery('#phone_require_car').prop('checked', 'true');
            }
        }
    })

    jQuery('#email_display_car').on('change', function () {

        var check = jQuery("#email_display_car").is(':checked');
        
        if (check) {
            jQuery('#email_require_car').prop('disabled', 'true');
            if (jQuery('#email_require_car').is(':checked')) {
                jQuery('#email_require_car').removeAttr('checked');
                
            }  
        }
        else {
            jQuery('#email_require_car').removeAttr('disabled');
            if (email_initial_car == true ) {
                jQuery('#email_require_car').prop('checked', 'true');
            }
        }
    })
});

jQuery(document).ready(function () {
    // to be placed in the main js file
    (function() {
        jQuery.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
            });
        };
    }(jQuery));  

    jQuery("#car_continue_payment #phone").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });

    jQuery("#continue_payment #phone").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });

    jQuery("#continue_payment #firstname").inputFilter(function(value) {
        return /^[A-Za-z ]*$/.test(value); });

    jQuery("#continue_payment #lastname").inputFilter(function(value) {
        return /^[A-Za-z ]*$/.test(value); });

    jQuery("#car_continue_payment #firstname").inputFilter(function(value) {
        return /^[A-Za-z ]*$/.test(value); });

    jQuery("#car_continue_payment #lastname").inputFilter(function(value) {
        return /^[A-Za-z ]*$/.test(value); });

    jQuery("#authorize-payment #NameOnCard").inputFilter(function(value) {
        return /^[A-Za-z ]*$/.test(value); });

    jQuery("#authorize-payment #expiryDate").inputFilter(function(value) {
        return /^[0-9-]*$/.test(value); });

    jQuery("#authorize-payment #CreditCardNumber").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });

    jQuery("#authorize-payment #SecurityCode").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });

    jQuery("#authorize-payment #ZIPCode").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });

    jQuery("#authorize-payment-car #NameOnCard").inputFilter(function(value) {
        return /^[A-Za-z ]*$/.test(value); });

    jQuery("#authorize-payment-car #expiryDate").inputFilter(function(value) {
        return /^[0-9-]*$/.test(value); });

    jQuery("#authorize-payment-car #CreditCardNumber").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });

    jQuery("#authorize-payment-car #SecurityCode").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });

    jQuery("#authorize-payment-car #ZIPCode").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });

    jQuery(".sync_restau_holder_name #full_name").inputFilter(function(value) {
        return /^[A-Za-z ]*$/.test(value); });

    jQuery(".sync_restau_holder_phone #phone_no").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });

    // end here

});


jQuery(document).on('submit', '#sync_form_captcha', function (e) {
    e.preventDefault();
    var captcha_key = jQuery('#captcha_key').val();
    var captcha_key_secret = jQuery('#captcha_key_secret').val();

    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: {action: 'save_captcha_key', captcha_key: captcha_key, captcha_key_secret: captcha_key_secret },
        success: function(data){
            if (data[0] != 'Success') {
                console.log('Something wrong!');
            }
            jQuery('body').loading('stop');
            jQuery('.modall').css('z-index', '');
            sweetfb();
        }
    });
    
});

jQuery(document).on('click', '#delete_timeslot1', function () {
    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: {action: 'delete_timeslot1'},
        success: function(data){
            if (data[0] != 'Success') {
                console.log('Something wrong!');
            }
            jQuery('body').loading('stop');
            jQuery('.modall').css('z-index', '');
            sweetfb();
        } 
    });
});

jQuery(document).on('click', '#delete_timeslot2', function () {
    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: {action: 'delete_timeslot2'},
        success: function(data){
            if (data[0] != 'Success') {
                console.log('Something wrong!');
            }
            jQuery('body').loading('stop');
            jQuery('.modall').css('z-index', '');
            sweetfb();
        }
    });
});

jQuery(document).on('click', '#delete_timeslot3', function () {
    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: {action: 'delete_timeslot3'},
        success: function(data){
            if (data[0] != 'Success') {
                console.log('Something wrong!');
            }
            jQuery('body').loading('stop');
            jQuery('.modall').css('z-index', '');
            sweetfb();
        }
    });
});

jQuery(document).on('click', '#delete_timeslot4', function () {
    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: {action: 'delete_timeslot4'},
        success: function(data){
            if (data[0] != 'Success') {
                console.log('Something wrong!');
            }
            jQuery('body').loading('stop');
            jQuery('.modall').css('z-index', '');
            sweetfb();
        }
    });
});

jQuery(document).on('click', '#delete_timeslot5', function () {
    jQuery.ajax({
        type: "POST",
        dataType: "json",    
        url: easync_admin_ajax_directory.ajaxurl,
        data: {action: 'delete_timeslot5'},
        success: function(data){
            if (data[0] != 'Success') {
                console.log('Something wrong!');
            }
            jQuery('body').loading('stop');
            jQuery('.modall').css('z-index', '');
            sweetfb();
        }
    });
});
