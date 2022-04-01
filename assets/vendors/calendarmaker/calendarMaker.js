/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

(function( $ ) {

    $.fn.calendarMaker = function(opt) {

        String.prototype.fileExists = function() {
            filename = this.trim();
            return ((jQuery.ajax({url: filename, type: 'HEAD', async: false}).status) !== 200) ? false : true;
        };

        function stripslashes (str) {
            return (str + '').replace(/\\(.?)/g, function (s, n1) {
                switch (n1) {
                    case '\\':
                        return '\\';
                    case '0':
                        return '\u0000';
                    case '':
                        return '';
                    default:
                        return n1;
                }
            });
        }

        function loadI18n(lang){

            $.ajax({
                url : pathRel + "/resources/locales/"+lang+".json",
                async: false,
                dataType: 'json',
                success : function(data) {
                    if(!data){
                        alert("Error loading JSON file");
                    }else{
                        i18n = data;
                    }
                },
                error: function (jqXHR, exception) {
                    alert( checkException(jqXHR, exception) );
                    i18n = null;
                }
            });
            
        }
        
        function setCategories(categories){

            if( jQuery.trim(categories) !== ""){
        
                try {

                    var valCategory = i18n.custom.categories.none ? i18n.custom.categories.none : 'Select category';
                    var yy = '<button type="button" id="btnCustomCategories" class="fc-button fc-button-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;'+valCategory+'&nbsp;&nbsp;<span class="caret"></span></button>';
                    yy += '<ul class="dropdown-menu" id="listCategories">';
                    yy += '<li><a href="#" id="selectCatOpt" title="Select category">'+valCategory+'</a></li>';
                    var itemCat = categories.split(",");
                    $.each( itemCat, function( key, value ) { yy += '<li><a href="#" title="'+value+'">'+(i18n.custom.categories[value] ? i18n.custom.categories[value] : value)+'</a></li>'; });
                    yy += '</ul>';

                } catch (e) { 

                    var yy = '<button type="button" id="btnCustomCategories" class="fc-button fc-button-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;Select category&nbsp;&nbsp;<span class="caret"></span></button>';
                    yy += '<ul class="dropdown-menu" id="listCategories">';
                    yy += '<li><a href="#" id="selectCatOpt" title="Select category">Select category</a></li>';
                    var itemCat = categories.split(",");
                    $.each( itemCat, function( key, value ) { yy += '<li><a href="#" title="'+value+'">'+value+'</a></li>'; });
                    yy += '</ul>';

                }
                
                if ($('#btnCustomCategories').length > 0) {
                    $("#listCategories").remove();
                    $('#btnCustomCategories').replaceWith(yy);
                }else{
                    $( ".fc-categories-button" ).first().replaceWith(yy);
                }
                

                $("#listCategories li a").click(function(){
                    $("#btnCustomCategories").html('<span style="float: left"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;'+$(this).text()+'&nbsp;&nbsp;</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                    var ss = calendar.getEventSourceById(1); if(ss){ ss.remove();}
                    try { $('#'+defs_.barSearch.btnReset).click(); } catch (e) {};
                    calendar.addEventSource({
                        id: '1',
                        url : pathRel + "/ajax/loadEvents.php",
                        backgroundColor: defs_.bgColor,
                        textColor: defs_.txColor,                
                        extraParams: {
                            lang: defs_.selectedLocaleCode,
                            uuid: defs_.uuidCalendar,
                            category: $(this).attr('title'),
                            t: new Date().getTime()
                        }
                    });
                });

                /* Select the first option */
                $("#selectCatOpt").click();
                
            }

        }
        
        function loadSettings(uuid){

            $.ajax({
                url : pathRel + "ajax/getSettings.php",
                async: false,
                type: 'POST',
                cache: false,
                data: { uuid: uuid },
                dataType: 'json',
                success: function(data){
                    if(data.status){
                        defs_.txColor = data.calendar.textColor;
                        defs_.bgColor = data.calendar.bgColor;
                        defs_.selectedLocaleCode = data.calendar.language;
                        defs_.optCategories = data.calendar.categories;
                        
                        /* Check if selected language exist */
                        var f1 = pathRel + "resources/locales/"+defs_.selectedLocaleCode+".json";
                        var f2 = pathRel + "resources/locales/en.json";

                        if( f1.fileExists() === false ){
                            if(defs_.selectedLocaleCode === "en") { alert("Please check if exist the default language files (en) for this calendar :\r\n\r\n"+f1+"\r\n\r\n"); return; }
                            if( f2.fileExists() === false ){
                                alert("Please check if exist the language files ("+defs_.selectedLocaleCode+" and en) for this calendar :\r\n\r\n"+f1+"\r\n"+f2+"\r\n\r\n"); return;
                            }else{
                                alert("Your selected language file ("+defs_.selectedLocaleCode+") does'n exist, default english language was selected");
                                defs_.selectedLocaleCode = 'en';
                            }
                        }

                        defs_.initCal = true;

                    }else{
                        alert('Error getting calendar settings from database');
                        defs_.initCal = false;
                    }
                },
                error: function (jqXHR, exception) {
                    alert( checkException(jqXHR, exception) );
                }
            });

        }

        function checkException(obj, exc) {

            if (obj.status === 0) {
                return 'Not connected.\nPlease verify your network connection';
            } else if (obj.status === 404) {
                return 'The requested page not found. [404]';
            } else if (obj.status === 500) {
                return 'Internal Server Error [500]';
            } else if (exc === 'parsererror') {
                return 'Requested JSON parse failed';
            } else if (exc === 'timeout') {
                return 'Time out error';
            } else if (exc === 'abort') {
                return 'Ajax request aborted';
            } else {
                return 'Uncaught Error';
            }

        }

        var methods = {
            
            setLanguage: function(lang){

                calendar.setOption('locale', lang);
                defs_.selectedLocaleCode = lang;
                loadI18n(defs_.selectedLocaleCode);                            
                return this;

            },
            getLanguage: function(){

                var curLang = calendar.getOption('locale');
                return curLang;

            },
            getLocaleCodes: function(){
                
                calendar = new FullCalendar.Calendar();
                return calendar.getAvailableLocaleCodes();
                
            },
            init: function(){

                calendar = new FullCalendar.Calendar(document.getElementById(defs_.divCal), {
                    aspectRatio: 1.2,
                    handleWindowResize: true,
                    themeSystem: 'standard',
                    timeZone: defs_.initialTimeZone,
                    locale: defs_.selectedLocaleCode,
                    navLinks: true,
                    editable: true,
                    selectable: true,
                    dayMaxEvents: true,
                    businessHours: true,
                    nowIndicator: true,          
                    headerToolbar: {
                        left: 'title',
                        center: '',
                        right: 'categories,prevYear,prev,next,nextYear'
                    },
                    footerToolbar: {
                        left: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                        center: '',
                        right: 'today'
                    },            
                    eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false }, 
                    views: {               
                        dayGrid: {},
                        timeGrid: {},
                        week: {},
                        day: {}
                    },
                    customButtons: {
                        prev: {
                            click: function() {
                                try { $('#'+defs_.barSearch.btnReset).click(); } catch (e) {};
                                calendar.prev();
                            }
                        },
                        next: {
                            click: function() {
                                try { $('#'+defs_.barSearch.btnReset).click(); } catch (e) {};
                                calendar.next();
                            }
                        },
                        categories: {
                            text: ''
                        }  
                    },            
                    eventSources: {
                        failure: function() {
                            document.getElementById('script-warning').style.display = 'inline';
                        }
                    },
                    events: {
                        id: '1',
                        url : pathRel + "/ajax/loadEvents.php",
                        backgroundColor: defs_.bgColor,
                        textColor: defs_.txColor,                
                        extraParams: {
                            lang: defs_.selectedLocaleCode,
                            uuid: defs_.uuidCalendar,
                            t: new Date().getTime()
                        },
                        failure: function(response) {
                            if(response.status === false){
                                document.getElementById('script-warning').innerHTML = response.msg;
                                document.getElementById('script-warning').style.display = 'inline';
                            }
                        },
                        success: function(response) {
                            if(response.status === false){
                                document.getElementById('script-warning').innerHTML = response.msg;
                                document.getElementById('script-warning').style.display = 'inline';
                            }
                        }
                    },           
                    loading: function(bool) {
                        if(document.getElementById(defs_.divLoad) !== null){
                            if (bool) {
                                document.getElementById(defs_.divLoad).style.display = 'inline'; } else { document.getElementById(defs_.divLoad).style.display = 'none'; 
                            }
                        }
                    },
                    eventResize: function(info){

                        if(defs_.readOnly){ info.revert(); return; };
                        var tz = (calendar.getOption('timeZone') === "local") ? Intl.DateTimeFormat().resolvedOptions().timeZone : calendar.getOption('timeZone');
                        var updateEvent = [];
                        var obj1 = {};

                        obj1.idEvent = info.event.id;
                        obj1.eventType = "resize";
                        obj1.startDelta = info.startDelta;
                        obj1.endDelta = info.endDelta;
                        obj1.start = moment.tz(info.event.start, tz).format();
                        obj1.end = moment.tz(info.event.end, tz).format();
                        updateEvent.push(obj1);

                        $.ajax({
                            url : pathRel + "/php/update.php",
                            type: 'POST',
                            cache: false,
                            contentType: "application/json; charset=utf-8",
                            data: JSON.stringify({ param: updateEvent, lang: defs_.selectedLocaleCode, uuid: defs_.uuidCalendar }),
                            dataType: 'json',
                            success: function(data){
                                if(data.status){
                                    calendar.refetchEvents();
                                }else{
                                    alert(data.msg);
                                    info.revert();
                                }
                            },
                            error: function (jqXHR, exception) {
                                alert( checkException(jqXHR, exception) );
                            }
                        });

                    },
                    eventDrop: function(info){
                        
                        if(defs_.readOnly){ info.revert(); return; };
                        var tz = (calendar.getOption('timeZone') === "local") ? Intl.DateTimeFormat().resolvedOptions().timeZone : calendar.getOption('timeZone');
                        var newEnd;

                        if((info.oldEvent.allDay === true) && (info.event.allDay === false)){
                            newEnd = moment.tz(moment(info.event.start).add(30, 'm'), tz).format();
                        }else if((info.oldEvent.allDay === false) && (info.event.allDay === true)){
                            newEnd = moment.tz(moment(info.event.start).add(1, 'days'), tz).format();
                        }else{
                            newEnd = moment.tz(info.event.end, tz).format();
                        }


                        var updateEvent = [];
                        var obj1 = {};

                        obj1.idEvent = info.event.id;
                        obj1.delta = info.delta;
                        obj1.eventType = "drop";
                        obj1.oldAllDay = info.oldEvent.allDay;
                        obj1.oldStart = moment.tz(info.oldEvent.start, tz).format();
                        obj1.oldEnd = moment.tz(info.oldEvent.end, tz).format();                
                        obj1.newAllDay = info.event.allDay;
                        obj1.newStart = moment.tz(info.event.start, tz).format();
                        obj1.newEnd = newEnd;
                        updateEvent.push(obj1);

                        $.ajax({
                            url : pathRel + "/php/update.php",
                            type: 'POST',
                            cache: false,
                            contentType: "application/json; charset=utf-8",
                            data: JSON.stringify({ param: updateEvent, lang: defs_.selectedLocaleCode, uuid: defs_.uuidCalendar }),
                            dataType: 'json',
                            success: function(data){
                                if(data.status){
                                    calendar.refetchEvents();
                                }else{
                                    alert(data.msg);
                                    info.revert();
                                }
                            },
                            error: function (jqXHR, exception) {
                                alert( checkException(jqXHR, exception) );
                            }
                        });

                    },
                    eventClick:function(info) {

                        info.jsEvent.preventDefault();
                        
                        $.ajax({
                            url : pathRel + "/ajax/getEvent.php",
                            type: 'post',
                            data: { id: info.event.id, uuid: defs_.uuidCalendar },
                            cache : false, 
                            dataType: 'json',
                            success: function(response){

                                if(response.status){
                                    if(response.import === 1){
                                        response.event = info.event;
                                        $('#showEvent').remove();
                                        $('<div id="showEvent" class="modal modCal fade col-xs-12 col-sm-12 col-md-12"></div>').appendTo('body');
                                        var deleteType = ( response.event.recurring ) ? "recurring" : "single";
                                        $('#showEvent').load(pathRel + "/ajax/showEventImported.php", { deleteType: deleteType, lang: defs_.selectedLocaleCode }, function(){
                                            var title = $('<textarea/>').html( response.event.title ).val();
                                            $('#showTitle').val(title);
                                            $("#bgColorBullet").css("color", (response.event.color ? response.event.color : defs_.bgColorImported));
                                            $("#showDescription").html( response.event.extendedProps.description );
                                            $("#showStartAt").val( moment( response.event.start ) );
                                            $("#showEndAt").val( moment( response.event.end ) );
                                            $('#showEvent').modal({ show: true });
                                        });    
                                    }else{

                                        $('#showEvent').remove();
                                        $('<div id="showEvent" class="modal modCal fade col-xs-12 col-sm-12 col-md-12"></div>').appendTo('body');
                                        var deleteType = ( response.event.recurring ) ? "recurring" : "single";
                                        $('#showEvent').load(pathRel + "/ajax/showEvent.php", { id: info.event.id, uuid: defs_.uuidCalendar, deleteType: deleteType, lang: defs_.selectedLocaleCode, readOnly: defs_.readOnly }, function(){

                                            var title = $('<textarea/>').html( response.event.title ).val();
                                            var allDay = ( response.event.allDay ) ? 1 : 0;
                                            $('#showTitle').val(title);
                                            $('#showDescription').html( stripslashes(response.event.description) );
                                            $('#showUrl').val( response.event.url );
                                            if( response.event.url ){ $('#goUrl').prop('href', response.event.url);  }

                                            $("#bgColorBullet").css("color", (response.event.color ? response.event.color : defs_.bgColor));
                                            $("#textColorBullet").css("color", (response.event.text_color ? response.event.text_color : defs_.txColor));
                                            $("#showStartAt").val( moment( response.event.start_event ) );
                                            $("#showEndAt").val( moment( response.event.end_event ) );
                                            $("#showRange").html( (allDay === 1) ? "All day" : "Custom date");

                                            $('#showEvent').modal({ show: true }); 

                                            $('#btnEditEvent').on("click", function(){

                                                $.ajax({
                                                    url : pathRel + "/ajax/editEvent.php",
                                                    type: 'POST',
                                                    cache: false,
                                                    contentType: "application/json; charset=utf-8",
                                                    data: JSON.stringify({ param: response, lang: defs_.selectedLocaleCode, uuid: defs_.uuidCalendar }),
                                                    success: function(streamHTML){

                                                        $('#showEvent').slideUp('fast', function(){ $('#showEvent').html(""); });
                                                        $('#showEvent').slideDown('fast', function(){ 
                                                            $('#showEvent').html(streamHTML);

                                                            $('#editCP1').colorpicker({color: (response.event.color ? response.event.color : defs_.bgColor), format: 'hex', align: 'left'});                                     
                                                            $('#editCP2').colorpicker({color: (response.event.text_color ? response.event.text_color : defs_.txColor), format: 'hex', align: 'left'});
                                                            $("#editdp1").datetimepicker({ format: 'YYYY-MM-DD', locale: defs_.selectedLocaleCode });
                                                            $("#editdp2").datetimepicker({ format: 'YYYY-MM-DD', locale: defs_.selectedLocaleCode });
                                                            $("#editdtp1").datetimepicker({ format: 'YYYY-MM-DD HH:mm', locale: defs_.selectedLocaleCode });
                                                            $("#editdtp2").datetimepicker({ format: 'YYYY-MM-DD HH:mm', locale: defs_.selectedLocaleCode });
                                                            $("#editenddp1").datetimepicker({ format: 'YYYY-MM-DD HH:mm', locale: defs_.selectedLocaleCode });
                                                            $("#editdp1").on("dp.change", function (e) {
                                                                var sDate = moment(response.event.start_event);
                                                                var eDate = moment(response.event.end_event);
                                                                var gDiff = eDate.diff(sDate, 'days');
                                                                if (e.date){ e.date.add(gDiff, 'days'); }
                                                                $('#editdp2').data("DateTimePicker").minDate(e.date.add(1-gDiff, 'days'));
                                                                $('#editdp2').data("DateTimePicker").date(e.date);
                                                                var dSel = (getDataPicker('edit') === "allday") ? moment($('#editdp1').data("DateTimePicker").date()).format('d') : moment($('#editdtp1').data("DateTimePicker").date()).format('d');
                                                                $('input[name="editDayOfWeek[]"]').each(function() {
                                                                    $(this).parent().removeClass('active');
                                                                    this.checked = false;
                                                                    if(this.value === dSel) { this.checked = true; $(this).parent().addClass('active') };
                                                                });
                                                                if(getDataPicker('edit') === "allday") {
                                                                    $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdp1').data("DateTimePicker").date()).format('D') );
                                                                    $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdp1').data("DateTimePicker").date()) + " " + moment($('#editdp1').data("DateTimePicker").date()).format('dddd') );
                                                                    $('#editChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#editdp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepYear0').text( i18n.core.yearly_on+" " + moment($('#editdp1').data("DateTimePicker").date()).format('D MMMM') );
                                                                    $('#editRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#editdp1').data("DateTimePicker").date()) + " " + moment($('#editdp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#editdp1').data("DateTimePicker").date()).format('MMMM'));                                                       
                                                                }else{
                                                                    $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdtp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdtp1').data("DateTimePicker").date()).format('D') );
                                                                    $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdtp1').data("DateTimePicker").date()) + " " + moment($('#editdtp1').data("DateTimePicker").date()).format('dddd') );
                                                                    $('#editChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#editdtp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepYear0').text( i18n.core.yearly_on+" " + moment($('#editdtp1').data("DateTimePicker").date()).format('D MMMM') );
                                                                    $('#editRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#editdtp1').data("DateTimePicker").date()) + " " + moment($('#editdtp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#editdtp1').data("DateTimePicker").date()).format('MMMM'));                                                        
                                                                }
                                                                $("#editMonthTimeRecurring").val($('#editRepMonth0').text());
                                                                $("#editYearTimeRecurring").val($('#editRepYear0').text()); 
                                                            });      
                                                            $("#editdp2").on("dp.change", function (e) {
                                                                $('#editenddp1').data("DateTimePicker").date(  $('#editdp2').data("DateTimePicker").date()  );
                                                            });
                                                            $("#editenddp1").on("dp.change", function (e) {
                                                                if(getDataPicker('edit') === "allday") {
                                                                    $('#editdp2').data("DateTimePicker").date(  moment($('#editenddp1').data("DateTimePicker").date()).format('YYYY-MM-DD')   );
                                                                }else{
                                                                    $('#editdtp2').data("DateTimePicker").date(  moment($('#editenddp1').data("DateTimePicker").date()).format('YYYY-MM-DD HH:mm')   );
                                                                }
                                                            });                                                
                                                            $("#editdtp1").on("dp.change", function (e) {
                                                                var sDate = moment(response.event.start_event);
                                                                var eDate = moment(response.event.end_event);
                                                                var gDiff = eDate.diff(sDate, 'm');
                                                                if (e.date){ e.date.add(gDiff, 'm'); }
                                                                $('#editdtp2').data("DateTimePicker").date(e.date);
                                                                $('#editdtp2').data("DateTimePicker").minDate(e.date.add(30-gDiff, 'm'));
                                                                var dSel = (getDataPicker('edit') === "allday") ? moment($('#editdp1').data("DateTimePicker").date()).format('d') : moment($('#editdtp1').data("DateTimePicker").date()).format('d');
                                                                $('input[name="editDayOfWeek[]"]').each(function() {
                                                                    $(this).parent().removeClass('active');
                                                                    this.checked = false;
                                                                    if(this.value === dSel) { this.checked = true; $(this).parent().addClass('active') };
                                                                });
                                                                if(getDataPicker('edit') === "allday") {
                                                                    $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdp1').data("DateTimePicker").date()).format('D') );
                                                                    $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdp1').data("DateTimePicker").date()) + " " + moment($('#editdp1').data("DateTimePicker").date()).format('dddd') );
                                                                    $('#editChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#editdp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepYear0').text( i18n.core.yearly_on+" " + moment($('#editdp1').data("DateTimePicker").date()).format('D MMMM') );
                                                                    $('#editRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#editdp1').data("DateTimePicker").date()) + " " + moment($('#editdp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#editdp1').data("DateTimePicker").date()).format('MMMM'));                                                        
                                                                }else{
                                                                    $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdtp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdtp1').data("DateTimePicker").date()).format('D') );
                                                                    $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdtp1').data("DateTimePicker").date()) + " " + moment($('#editdtp1').data("DateTimePicker").date()).format('dddd') );
                                                                    $('#editChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#editdtp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepYear0').text( i18n.core.yearly_on+" " + moment($('#editdtp1').data("DateTimePicker").date()).format('D MMMM') );
                                                                    $('#editRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#editdtp1').data("DateTimePicker").date()) + " " + moment($('#editdtp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#editdtp1').data("DateTimePicker").date()).format('MMMM'));                                                        
                                                                }
                                                                $("#editMonthTimeRecurring").val($('#editRepMonth0').text());
                                                                $("#editYearTimeRecurring").val($('#editRepYear0').text());    

                                                            });
                                                            $("#editdtp2").on("dp.change", function (e) {
                                                                $('#editenddp1').data("DateTimePicker").date(  $('#editdtp2').data("DateTimePicker").date()  );
                                                            });
                                                            $("#editdp1").data("DateTimePicker").date(moment(response.event.start_event).format('YYYY-MM-DD'));
                                                            $("#editdp2").data("DateTimePicker").date(moment(response.event.end_event).format('YYYY-MM-DD'));
                                                            $("#editdtp1").data("DateTimePicker").date(moment(response.event.start_event).format('YYYY-MM-DD HH:mm'));
                                                            $("#editdtp2").data("DateTimePicker").date(moment(response.event.end_event).format('YYYY-MM-DD HH:mm'));


                                                            $("#editChooseCategory li a").click(function(){
                                                                $(this).parents(".dropdown").find('.btn').html('<span style="float: left">'+$(this).text()+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                $("#editCalendarCategory").val( $(this).attr('title') );
                                                            });

                                                            if((response.event.category !== null) && (response.event.category !== ''))  {
                                                                try {
                                                                    var valCategory = ( typeof i18n.custom.categories[response.event.category] !== "undefined" ) ? i18n.custom.categories[response.event.category] : response.event.category;
                                                                    arrCats = defs_.optCategories.split(',');
                                                                    if(arrCats.indexOf(response.event.category) != -1) {
                                                                        $('#editCategory').html('<span style="float: left">'+valCategory+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    }
                                                                } catch (e) {
                                                                    var valCategory = response.event.category;
                                                                    arrCats = defs_.optCategories.split(',');
                                                                    if(arrCats.indexOf(response.event.category) != -1) {
                                                                        $('#editCategory').html('<span style="float: left">'+valCategory+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    }                                                                
                                                                }                                                           
                                                            }


                                                            $("#editChooseRecurring li a").click(function(){

                                                                $('#divEditRecurring').css('display', 'block');
                                                                $(this).parents(".dropdown").find('.btn').html('<span style="float: left">'+$(this).text()+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                $("#editRecurring").val($(this).text());

                                                                resetRecurringValues('edit');

                                                                switch( $(this).text() ) {
                                                                    case i18n.editEvent.body.daily_recurring:
                                                                        $("#editDivDaysRecurring").css('display', 'block');
                                                                        break;
                                                                    case i18n.editEvent.body.weekly_recurring:
                                                                        $("#editDivWeeksRecurring").css('display', 'block');
                                                                        var dSel = (getDataPicker('edit') === "allday") ? moment($('#editdp1').data("DateTimePicker").date()).format('d') : moment($('#editdtp1').data("DateTimePicker").date()).format('d');
                                                                        $('input[name="editDayOfWeek[]"]').each(function() {
                                                                           $(this).parent().removeClass('active');
                                                                           this.checked = false;
                                                                           if(this.value === dSel) { this.checked = true; $(this).parent().addClass('active') };
                                                                        });
                                                                        break;
                                                                    case i18n.editEvent.body.monthly_recurring:
                                                                        $("#editDivMonthsRecurring").css('display', 'block');
                                                                        if(getDataPicker('edit') === "allday") {
                                                                            $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                            $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdp1').data("DateTimePicker").date()).format('D') );
                                                                            $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdp1').data("DateTimePicker").date()) + " " + moment($('#editdp1').data("DateTimePicker").date()).format('dddd') );
                                                                        }else{
                                                                            $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdtp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                            $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdtp1').data("DateTimePicker").date()).format('D') );
                                                                            $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdtp1').data("DateTimePicker").date()) + " " + moment($('#editdtp1').data("DateTimePicker").date()).format('dddd') );
                                                                        }
                                                                        $("#editMonthTimeRecurring").val($('#editRepMonth0').text());
                                                                        break;
                                                                    case i18n.editEvent.body.yearly_recurring:
                                                                        $("#editDivYearsRecurring").css('display', 'block');
                                                                        if(getDataPicker('edit') === "allday") {
                                                                            $('#editChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#editdp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                            $('#editRepYear0').text( i18n.core.yearly_on+" " + moment($('#editdp1').data("DateTimePicker").date()).format('D MMMM') );
                                                                            $('#editRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#editdp1').data("DateTimePicker").date()) + " " + moment($('#editdp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#editdp1').data("DateTimePicker").date()).format('MMMM'));
                                                                        }else{
                                                                            $('#editChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#editdtp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                            $('#editRepYear0').text( i18n.core.yearly_on+" " + moment($('#editdtp1').data("DateTimePicker").date()).format('D MMMM') );
                                                                            $('#editRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#editdtp1').data("DateTimePicker").date()) + " " + moment($('#editdtp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#editdtp1').data("DateTimePicker").date()).format('MMMM'));
                                                                        }
                                                                        $("#editYearTimeRecurring").val($('#editRepYear0').text());
                                                                        break;
                                                                    default:
                                                                        $('#divEditRecurring').css('display', 'none');
                                                                }

                                                            });
                                                            $("#editChooseTypeRecurring li a").click(function(){

                                                                $("#editChooseTime").html( $(this).text()+'&nbsp;<span class="caret"></span>' );

                                                                if( $(this).text() === "weeks" ) {
                                                                    $("#editDivWeeksRecurring").css('display', 'block');
                                                                    var dSel = (getDataPicker('edit') === "allday") ? moment($('#editdp1').data("DateTimePicker").date()).format('d') : moment($('#editdtp1').data("DateTimePicker").date()).format('d');
                                                                    $('input[name="editDayOfWeek[]"]').each(function() {
                                                                        $(this).parent().removeClass('active');
                                                                        this.checked = false;
                                                                        if(this.value === dSel) { this.checked = true; $(this).parent().addClass('active') };
                                                                    });
                                                                }else{
                                                                    $("#editDivWeeksRecurring").css('display', 'none');
                                                                }

                                                                if( $(this).text() === "months" ) {
                                                                    $("#editDivMonthsRecurring").css('display', 'block');
                                                                    if(getDataPicker('edit') === "allday") {
                                                                        $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                        $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdp1').data("DateTimePicker").date()).format('D') );
                                                                        $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdp1').data("DateTimePicker").date()) + " " + moment($('#editdp1').data("DateTimePicker").date()).format('dddd') );
                                                                    }else{
                                                                        $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdtp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                        $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdtp1').data("DateTimePicker").date()).format('D') );
                                                                        $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdtp1').data("DateTimePicker").date()) + " " + moment($('#editdtp1').data("DateTimePicker").date()).format('dddd') );
                                                                    }
                                                                    $("#editMonthTimeRecurring").val($('#editRepMonth0').text());
                                                                }else{
                                                                    $("#editDivMonthsRecurring").css('display', 'none');
                                                                }

                                                                $("#editTypeRecurring").val($(this).text());

                                                            });
                                                            $("#editChooseMonthTimeRecurring li a").click(function(){
                                                                $(this).parents(".dropdown").find('.btn').html('<span style="float: left">'+$(this).text()+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                $("#editMonthTimeRecurring").val($(this).text());
                                                            });
                                                            $("#editChooseYearTimeRecurring li a").click(function(){
                                                                $(this).parents(".dropdown").find('.btn').html('<span style="float: left">'+$(this).text()+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                $("#editYearTimeRecurring").val($(this).text());
                                                            });                                                
                                                            $("#editEndRecurring li a").click(function(){
                                                                $("#editEndRecurring").val($(this).text());
                                                            });

                                                            $('input[name="editDateType"]').on("change", function(){

                                                                var dSel = (getDataPicker('edit') === "allday") ? moment($('#editdp1').data("DateTimePicker").date()).format('d') : moment($('#editdtp1').data("DateTimePicker").date()).format('d');
                                                                $('input[name="editDayOfWeek[]"]').each(function() {
                                                                    $(this).parent().removeClass('active');
                                                                    this.checked = false;
                                                                    if(this.value === dSel) { this.checked = true; $(this).parent().addClass('active') };
                                                                });
                                                                if(getDataPicker('edit') === "allday") {
                                                                    $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdp1').data("DateTimePicker").date()).format('D') );
                                                                    $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdp1').data("DateTimePicker").date()) + " " + moment($('#editdp1').data("DateTimePicker").date()).format('dddd') );
                                                                    $('#editChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#editdp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepYear0').text( i18n.core.yearly_on+" " + moment($('#editdp1').data("DateTimePicker").date()).format('D MMMM') );
                                                                    $('#editRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#editdp1').data("DateTimePicker").date()) + " " + moment($('#editdp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#editdp1').data("DateTimePicker").date()).format('MMMM'));                
                                                                }else{
                                                                    $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdtp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdtp1').data("DateTimePicker").date()).format('D') );
                                                                    $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdtp1').data("DateTimePicker").date()) + " " + moment($('#editdtp1').data("DateTimePicker").date()).format('dddd') );
                                                                    $('#editChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#editdtp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                    $('#editRepYear0').text( i18n.core.yearly_on+" " + moment($('#editdtp1').data("DateTimePicker").date()).format('D MMMM') );
                                                                    $('#editRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#editdtp1').data("DateTimePicker").date()) + " " + moment($('#editdtp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#editdtp1').data("DateTimePicker").date()).format('MMMM'));                
                                                                }
                                                                $("#editMonthTimeRecurring").val($('#editRepMonth0').text());
                                                                $("#editYearTimeRecurring").val($('#editRepYear0').text());

                                                                if(getDataPicker('edit') === "allday"){
                                                                    if($('#divEditDateAllday').css('display') === 'none'){ $('.divEditDateAllday, .divEditDateCustom').slideToggle( "fast" ); }
                                                                    $('#editenddp1').data("DateTimePicker").date(  $('#editdp2').data("DateTimePicker").date()  );
                                                                }
                                                                if(getDataPicker('edit') === "custom"){
                                                                    if($('#divEditDateCustom').css('display') === 'none'){ $('.divEditDateAllday, .divEditDateCustom').slideToggle( "fast" ); }
                                                                    $('#editenddp1').data("DateTimePicker").date(  $('#editdtp2').data("DateTimePicker").date()  );
                                                                }                                                    

                                                            });   

                                                            /* Forced to choose at least one */
                                                            $('.btn-group input[name="editDayOfWeek[]"]').change(function(){
                                                                if ($('input[type="checkbox"]:checked').length === 0) {
                                                                    $(this).prop("checked", true).parent().addClass('active');
                                                                }else{
                                                                    var arrEditDays = $('input[type="checkbox"]:checked').map(function(){return parseInt($(this).val())}).get(); var selEditDay;
                                                                    if(getDataPicker('edit') === "allday") {
                                                                        selEditDay = arrEditDays.indexOf(parseInt(moment($('#editdp1').data("DateTimePicker").date()).day(), 0));
                                                                    }else{
                                                                        selEditDay = arrEditDays.indexOf(parseInt(moment($('#editdtp1').data("DateTimePicker").date()).day(), 0));
                                                                    }
                                                                    if(selEditDay === -1){ $(this).prop("checked", true).parent().addClass('active'); }
                                                                }                                                      
                                                            });

                                                            /* Customize RRule */
                                                            if( response.event.recurring !== null ){

                                                                switch( response.event.recurring ) {
                                                                    case 'daily': var recSel = i18n.editEvent.body.daily_recurring; break;
                                                                    case 'weekly': var recSel = i18n.editEvent.body.weekly_recurring; break;
                                                                    case 'monthly': var recSel = i18n.editEvent.body.monthly_recurring; break;
                                                                    case 'yearly': var recSel = i18n.editEvent.body.yearly_recurring; break;
                                                                    default: var recSel = "";                                                       
                                                                }                                                    

                                                                $("#editChooseRecurring li a").each(function() {
                                                                    $(this).parents(".dropdown").find('.btn').html('<span style="float: left">'+recSel+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                });
                                                                $("#editRecurring").val(recSel);

                                                                resetRecurringValues('edit');

                                                                var strRRULE = response.event.rrule.toUpperCase().split(';');
                                                                var strParam = [];

                                                                $.each( strRRULE, function( key, value ) {
                                                                    var y = value.split('=');
                                                                    strParam[y[0]] = y[1];
                                                                });

                                                                switch( strParam['FREQ'] ) {
                                                                    case 'DAILY':
                                                                        $("#editDivDaysRecurring").css('display', 'block');
                                                                        if( strParam['INTERVAL'] ){
                                                                            $("#editEachNumberDays").val( strParam['INTERVAL'] );
                                                                        }
                                                                        break;
                                                                    case 'WEEKLY':

                                                                        $("#editDivWeeksRecurring").css('display', 'block');
                                                                        $("#editChooseTime").html( 'weeks&nbsp;<span class="caret"></span>' );

                                                                        var daysSelected = [];
                                                                        if( strParam['BYDAY'].indexOf( 'SU' ) > -1 ) { daysSelected.push('0') }
                                                                        if( strParam['BYDAY'].indexOf( 'MO' ) > -1 ) { daysSelected.push('1') }
                                                                        if( strParam['BYDAY'].indexOf( 'TU' ) > -1 ) { daysSelected.push('2') }
                                                                        if( strParam['BYDAY'].indexOf( 'WE' ) > -1 ) { daysSelected.push('3') }
                                                                        if( strParam['BYDAY'].indexOf( 'TH' ) > -1 ) { daysSelected.push('4') }
                                                                        if( strParam['BYDAY'].indexOf( 'FR' ) > -1 ) { daysSelected.push('5') }
                                                                        if( strParam['BYDAY'].indexOf( 'SA' ) > -1 ) { daysSelected.push('6') }                                                            
                                                                        var strDays = daysSelected.join(',');

                                                                        $('input[name="editDayOfWeek[]"]').each(function() {
                                                                            $(this).parent().removeClass('active');
                                                                            this.checked = false;
                                                                            if( strDays.indexOf( this.value ) > -1 ) {
                                                                                this.checked = true; 
                                                                                $(this).parent().addClass('active')
                                                                            };
                                                                        });

                                                                        if( strParam['INTERVAL'] ){
                                                                            $("#editEachNumberWeeks").val( strParam['INTERVAL'] );
                                                                        }                                                            
                                                                        break;
                                                                    case 'MONTHLY':

                                                                        $("#editDivWeeksRecurring").css('display', 'none');
                                                                        $("#editChooseTime").html( 'months&nbsp;<span class="caret"></span>' );

                                                                        $("#editDivMonthsRecurring").css('display', 'block');
                                                                        if(getDataPicker('edit') === "allday") {
                                                                            $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                            $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdp1').data("DateTimePicker").date()).format('D') );
                                                                            $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdp1').data("DateTimePicker").date()) + " " + moment($('#editdp1').data("DateTimePicker").date()).format('dddd') );
                                                                        }else{
                                                                            $('#editChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#editdtp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                            $('#editRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#editdtp1').data("DateTimePicker").date()).format('D') );
                                                                            $('#editRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#editdtp1').data("DateTimePicker").date()) + " " + moment($('#editdtp1').data("DateTimePicker").date()).format('dddd') );
                                                                        }

                                                                        var valMonthTimeRecurring = (strParam['BYMONTHDAY']) ? $('#editRepMonth0').text() : $('#editRepMonth1').text();
                                                                        $('#editChooseMonthTime').html('<span style="float: left">'+valMonthTimeRecurring+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                        $("#editMonthTimeRecurring").val( valMonthTimeRecurring );

                                                                        if( strParam['INTERVAL'] ){
                                                                            $("#editEachNumberMonths").val( strParam['INTERVAL'] );
                                                                        }
                                                                        break;
                                                                    case 'YEARLY':

                                                                        $("#editDivYearsRecurring").css('display', 'block');
                                                                        var valYearTimeRecurring = (strParam['BYMONTHDAY']) ? $('#editRepYear0').text() : $('#editRepYear1').text();
                                                                        $('#editChooseYearTime').html('<span style="float: left">'+valYearTimeRecurring+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                                        $("#editYearTimeRecurring").val( valYearTimeRecurring );
                                                                        break;
                                                                    default:

                                                                }

                                                                if( strParam['COUNT'] ){
                                                                    $("#editEndOccurrences").val( strParam['COUNT'] );
                                                                    $("#editEndRecurring li a").each(function() {
                                                                        if( $(this).text() === i18n.editEvent.body.after ){ $(this).click(); }
                                                                    });
                                                                    $("#editEndRecurring").val(i18n.editEvent.body.after);
                                                                }

                                                                if( strParam['UNTIL'] ){
                                                                    $("#editEndRecurring li a").each(function() {
                                                                        if( $(this).text() === i18n.editEvent.body.date ){ $(this).click(); }
                                                                    });
                                                                }

                                                                $('#divEditRecurring').css('display', 'block');

                                                            }

                                                            /* Update Event*/
                                                            $('#formEditEvent').on("submit", function(event){

                                                                event.preventDefault();
                                                                $("#editDescription2").val( $("#editDescription").html() );

                                                                $.ajax({
                                                                    url: pathRel + '/php/update.php', data : $('#formEditEvent').serialize(), cache : false, type : 'post', dataType: 'json',
                                                                    success : function (data) {
                                                                        if(data.status){
                                                                            $('#showEvent').modal('hide');
                                                                            calendar.refetchEvents();
                                                                        }else{
                                                                            alert("error : "+data.msg);
                                                                        }
                                                                    },
                                                                    error: function (jqXHR, exception) {
                                                                        alert( checkException(jqXHR, exception) );
                                                                    }
                                                                });
                                                                return false;
                                                            }); 

                                                        });
                                                    }
                                               });
                                            });

                                            /* Export Single Event */
                                            $('#btnExportEvent').on("click", function(){
                                                location.href = pathRel + "/php/export.php?id="+response.event.id+"&uuid="+defs_.uuidCalendar;
                                            });

                                            /* Delete Event */
                                            $('#bntDeleteEvent').on("click", function(){

                                                $.ajax({
                                                    url: pathRel + '/php/delete.php', data : { id: response.event.id, lang: defs_.selectedLocaleCode, uuid: defs_.uuidCalendar }, cache : false, type : 'post', dataType: 'json',
                                                    success : function (data) {
                                                        if(data.status){
                                                            $('#showEvent').modal('hide');
                                                            $('#'+defs_.barSearch.btnReset).click();
                                                            calendar.refetchEvents(); 
                                                        }else{
                                                            alert("error : "+data.msg);
                                                        }
                                                    },
                                                    error: function (jqXHR, exception) {
                                                        alert( checkException(jqXHR, exception) );
                                                    }
                                                });

                                            });

                                            /* Delete Single Event */
                                            $('#btnDeleteSingleEvent').on("click", function(){

                                                $.ajax({
                                                    url: pathRel + '/php/delete.php', data : {id: response.event.id, eventDate: moment(info.event.start).format('YYYYMMDD'), lang: defs_.selectedLocaleCode, uuid: defs_.uuidCalendar }, cache : false, type : 'post', dataType: 'json',
                                                    success : function (data) {
                                                        if(data.status){
                                                            $('#showEvent').modal('hide');
                                                            $('#'+defs_.barSearch.btnReset).click();
                                                            calendar.refetchEvents(); 
                                                        }else{
                                                            alert("error : "+data.msg);
                                                        }
                                                    },
                                                    error: function (jqXHR, exception) {
                                                        alert( checkException(jqXHR, exception) );
                                                    }
                                                });

                                            });                                

                                        });

                                    }

                                }else{
                                    alert("error : " + response.msg);
                                }

                            }
                       });

                    },         
                    eventDidMount: function (info) {

                        var start = info.event.start;
                        var end = info.event.end;
                        var startTime;
                        var endTime;

                        if (!start) {
                            startTime = '';
                        } else {
                            startTime = start;
                        }

                        if (!end) {
                            endDate = '';
                        } else {
                            endTime = end;
                        }

                        var title = info.event.title;
                        var location = "at " + info.event.extendedProps.location;
                        if (!info.event.extendedProps.location) {
                            location = '';
                        }

                        var view = calendar.view;
                        $(".popover").remove();
                        if((defs_.popOver === true) && (view.type === 'dayGridMonth')){
                            var label1 = info.event.extendedProps.category ? 'categogy : '+info.event.extendedProps.category+'<br>' : 'categogy : none<br>';
                            var label2 = info.event.url ? info.event.url+'<br>' : '';
                            var label3 = info.event.extendedProps.description ? info.event.extendedProps.description : '';
                            var breakLine = (label3.length > 0) ? '<center>------------</center>' : '';
                            $(info.el).popover({
                                title: title,
                                content: label1 + label2 + breakLine + label3,
                                trigger: 'hover',
                                placement: 'top',
                                container: 'body',
                                live: true,
                                html: true
                            });
                        }

                    },
                    select: function(info) {

                        if(defs_.readOnly){ return; };
                        $.ajax({
                            url: pathRel + '/ajax/newEvent.php',
                            type: 'post',
                            data: { lang: defs_.selectedLocaleCode, uuid: defs_.uuidCalendar},
                            success: function(response){

                                $('<div id="cal_newModal" class="modal modCal fade col-xs-12 col-sm-12 col-md-12"></div>').appendTo('body');
                                $('#cal_newModal').html(response);
                                $('#saveNew').replaceWith('<button id="saveNew" type="submit" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-save"></i>&nbsp;'+i18n.newEvent.footer.save+'</button>');

                                $("#newdp1").datetimepicker({ format: 'YYYY-MM-DD', locale: defs_.selectedLocaleCode });
                                $("#newdp2").datetimepicker({ format: 'YYYY-MM-DD', locale: defs_.selectedLocaleCode });
                                $("#newdtp1").datetimepicker({ format: 'YYYY-MM-DD HH:mm', locale: defs_.selectedLocaleCode });
                                $("#newdtp2").datetimepicker({ format: 'YYYY-MM-DD HH:mm', locale: defs_.selectedLocaleCode });                        
                                $("#newenddp1").datetimepicker({ format: 'YYYY-MM-DD HH:mm', locale: defs_.selectedLocaleCode });
                                $("#newdp1").on("dp.change", function (e) {
                                    var sDate = moment(info.startStr);
                                    var eDate = moment(info.endStr);
                                    var gDiff = eDate.diff(sDate, 'days');
                                    if (e.date){ e.date.add(gDiff, 'days'); }
                                    $('#newdp2').data("DateTimePicker").date(e.date);
                                    $('#newdp2').data("DateTimePicker").minDate(e.date.add(1-gDiff, 'days'));
                                    var dSel = (getDataPicker('new') === "allday") ? moment($('#newdp1').data("DateTimePicker").date()).format('d') : moment($('#newdtp1').data("DateTimePicker").date()).format('d');
                                    $('input[name="newDayOfWeek[]"]').each(function() {
                                        $(this).parent().removeClass('active');
                                        this.checked = false;
                                        if(this.value === dSel) { this.checked = true; $(this).parent().addClass('active') };
                                    });
                                    if(getDataPicker('new') === "allday") {
                                        $('#newChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#newdp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#newdp1').data("DateTimePicker").date()).format('D') );
                                        $('#newRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#newdp1').data("DateTimePicker").date()) + " " + moment($('#newdp1').data("DateTimePicker").date()).format('dddd') );
                                        $('#newChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#newdp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepYear0').text( i18n.core.yearly_on+" " + moment($('#newdp1').data("DateTimePicker").date()).format('D MMMM') );
                                        $('#newRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#newdp1').data("DateTimePicker").date()) + " " + moment($('#newdp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#newdp1').data("DateTimePicker").date()).format('MMMM'));                                
                                    }else{
                                        $('#newChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#newdtp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#newdtp1').data("DateTimePicker").date()).format('D') );
                                        $('#newRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#newdtp1').data("DateTimePicker").date()) + " " + moment($('#newdtp1').data("DateTimePicker").date()).format('dddd') );
                                        $('#newChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#newdtp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepYear0').text( i18n.core.yearly_on+" " + moment($('#newdtp1').data("DateTimePicker").date()).format('D MMMM') );
                                        $('#newRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#newdtp1').data("DateTimePicker").date()) + " " + moment($('#newdtp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#newdtp1').data("DateTimePicker").date()).format('MMMM'));                                
                                    }
                                    $("#newMonthTimeRecurring").val($('#newRepMonth0').text());
                                    $("#newYearTimeRecurring").val($('#newRepYear0').text());                          

                                });
                                $("#newdp2").on("dp.change", function (e) {
                                    $('#newenddp1').data("DateTimePicker").date(  $('#newdp2').data("DateTimePicker").date()  );
                                });
                                $("#newenddp1").on("dp.change", function (e) {
                                    if(getDataPicker('new') === "allday") {
                                        $('#newdp2').data("DateTimePicker").date(  moment($('#newenddp1').data("DateTimePicker").date()).format('YYYY-MM-DD')   );
                                    }else{
                                        $('#newdtp2').data("DateTimePicker").date(  moment($('#newenddp1').data("DateTimePicker").date()).format('YYYY-MM-DD HH:mm')   );
                                    }
                                });
                                $("#newdtp1").on("dp.change", function (e) {
                                    var sDate = moment(info.startStr);
                                    var eDate = moment(info.startStr).add(1, 'hours');
                                    var gDiff = eDate.diff(sDate, 'm');
                                    if (e.date){ e.date.add(gDiff, 'm'); }
                                    $('#newdtp2').data("DateTimePicker").date(e.date);
                                    $('#newdtp2').data("DateTimePicker").minDate(e.date.add(30-gDiff, 'm'));                            
                                    var dSel = (getDataPicker('new') === "allday") ? moment($('#newdp1').data("DateTimePicker").date()).format('d') : moment($('#newdtp1').data("DateTimePicker").date()).format('d');
                                    $('input[name="newDayOfWeek[]"]').each(function() {
                                        $(this).parent().removeClass('active');
                                        this.checked = false;
                                        if(this.value === dSel) { this.checked = true; $(this).parent().addClass('active') };
                                    });
                                    if(getDataPicker('new') === "allday") {
                                        $('#newChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#newdp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#newdp1').data("DateTimePicker").date()).format('D') );
                                        $('#newRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#newdp1').data("DateTimePicker").date()) + " " + moment($('#newdp1').data("DateTimePicker").date()).format('dddd') );
                                        $('#newChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#newdp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepYear0').text( i18n.core.yearly_on+" " + moment($('#newdp1').data("DateTimePicker").date()).format('D MMMM') );
                                        $('#newRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#newdp1').data("DateTimePicker").date()) + " " + moment($('#newdp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#newdp1').data("DateTimePicker").date()).format('MMMM'));                                
                                    }else{
                                        $('#newChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#newdtp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#newdtp1').data("DateTimePicker").date()).format('D') );
                                        $('#newRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#newdtp1').data("DateTimePicker").date()) + " " + moment($('#newdtp1').data("DateTimePicker").date()).format('dddd') );
                                        $('#newChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#newdtp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepYear0').text( i18n.core.yearly_on+" " + moment($('#newdtp1').data("DateTimePicker").date()).format('D MMMM') );
                                        $('#newRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#newdtp1').data("DateTimePicker").date()) + " " + moment($('#newdtp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#newdtp1').data("DateTimePicker").date()).format('MMMM'));                                
                                    }
                                    $("#newMonthTimeRecurring").val($('#newRepMonth0').text());
                                    $("#newYearTimeRecurring").val($('#newRepYear0').text());                         

                                });
                                $("#newdtp2").on("dp.change", function (e) {
                                    $('#newenddp1').data("DateTimePicker").date(  $('#newdtp2').data("DateTimePicker").date()  );
                                });
                                $("#newdp1").data("DateTimePicker").date(moment(info.startStr).format('YYYY-MM-DD'));
                                $("#newdp2").data("DateTimePicker").date(moment(info.endStr).format('YYYY-MM-DD'));                        
                                $("#newdtp1").data("DateTimePicker").date(moment(info.startStr).format('YYYY-MM-DD HH:mm'));
                                $("#newdtp2").data("DateTimePicker").date(moment(info.endStr).format('YYYY-MM-DD HH:mm'));

                                $('#cp1').colorpicker({color: defs_.bgColor, format: 'hex', align: 'left'});       
                                $('#cp2').colorpicker({color: defs_.txColor, format: 'hex', align: 'left'}); 

                                $("#newChooseCategory li a").click(function(){
                                    $(this).parents(".dropdown").find('.btn').html('<span style="float: left">'+$(this).text()+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                    $("#newCalendarCategory").val( $(this).attr('title') );                                    
                                });
                                
                                $("#newChooseRecurring li a").click(function(){
                                    $('#divNewRecurring').css('display', 'block');
                                    $(this).parents(".dropdown").find('.btn').html('<span style="float: left">'+$(this).text()+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                    $("#newRecurring").val($(this).text());

                                    resetRecurringValues('new');

                                    switch( $(this).text() ) {
                                        case i18n.newEvent.body.daily_recurring:
                                            $("#newDivDaysRecurring").css('display', 'block');
                                            break;

                                        case i18n.newEvent.body.weekly_recurring:
                                            $("#newDivWeeksRecurring").css('display', 'block');
                                            var dSel = (getDataPicker('new') === "allday") ? moment($('#newdp1').data("DateTimePicker").date()).format('d') : moment($('#newdtp1').data("DateTimePicker").date()).format('d');
                                            $('input[name="newDayOfWeek[]"]').each(function() {
                                               $(this).parent().removeClass('active');
                                               this.checked = false;
                                               if(this.value === dSel) { this.checked = true; $(this).parent().addClass('active') };
                                            });
                                            break;
                                        case i18n.newEvent.body.monthly_recurring:
                                            $("#newDivMonthsRecurring").css('display', 'block');
                                            if(getDataPicker('new') === "allday") {
                                                $('#newChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#newdp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                $('#newRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#newdp1').data("DateTimePicker").date()).format('D') );
                                                $('#newRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#newdp1').data("DateTimePicker").date()) + " " + moment($('#newdp1').data("DateTimePicker").date()).format('dddd') );
                                            }else{
                                                $('#newChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#newdtp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                $('#newRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#newdtp1').data("DateTimePicker").date()).format('D') );
                                                $('#newRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#newdtp1').data("DateTimePicker").date()) + " " + moment($('#newdtp1').data("DateTimePicker").date()).format('dddd') );
                                            }
                                            $("#newMonthTimeRecurring").val($('#newRepMonth0').text());
                                            break;
                                        case i18n.newEvent.body.yearly_recurring:
                                            $("#newDivYearsRecurring").css('display', 'block');
                                            if(getDataPicker('new') === "allday") {
                                                $('#newChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#newdp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                $('#newRepYear0').text( i18n.core.yearly_on+" " + moment($('#newdp1').data("DateTimePicker").date()).format('D MMMM') );
                                                $('#newRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#newdp1').data("DateTimePicker").date()) + " " + moment($('#newdp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#newdp1').data("DateTimePicker").date()).format('MMMM'));
                                            }else{
                                                $('#newChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#newdtp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                                $('#newRepYear0').text( i18n.core.yearly_on+" " + moment($('#newdtp1').data("DateTimePicker").date()).format('D MMMM') );
                                                $('#newRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#newdtp1').data("DateTimePicker").date()) + " " + moment($('#newdtp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#newdtp1').data("DateTimePicker").date()).format('MMMM'));
                                            }
                                            $("#newYearTimeRecurring").val($('#newRepYear0').text());
                                            break;
                                        default:
                                            $('#divNewRecurring').css('display', 'none');
                                    }

                                });
                                $("#newChooseMonthTimeRecurring li a").click(function(){
                                    $(this).parents(".dropdown").find('.btn').html('<span style="float: left">'+$(this).text()+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                    $("#newMonthTimeRecurring").val($(this).text());
                                });                    
                                $("#newChooseYearTimeRecurring li a").click(function(){
                                    $(this).parents(".dropdown").find('.btn').html('<span style="float: left">'+$(this).text()+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                    $("#newYearTimeRecurring").val($(this).text());
                                });
                                $("#newEndRecurring li a").click(function(){
                                    $("#newEndRecurring").val($(this).text());
                                });

                                /* Forced to choose at least one */
                                $('.btn-group input[name="newDayOfWeek[]"]').change(function(){
                                    if ($('input[type="checkbox"]:checked').length === 0) {
                                        $(this).prop("checked", true).parent().addClass('active');
                                    }else{
                                        var arrNewDays = $('input[type="checkbox"]:checked').map(function(){return parseInt($(this).val())}).get(); var selNewDay;
                                        if(getDataPicker('new') === "allday") {
                                            selNewDay = arrNewDays.indexOf(parseInt(moment($('#newdp1').data("DateTimePicker").date()).day(), 0));
                                        }else{
                                            selNewDay = arrNewDays.indexOf(parseInt(moment($('#newdtp1').data("DateTimePicker").date()).day(), 0));
                                        }
                                        if(selNewDay === -1){ $(this).prop("checked", true).parent().addClass('active'); }
                                    }  
                                });                            


                                $('input[name="newDateType"]').on("change", function(){

                                    var dSel = (getDataPicker('new') === "allday") ? moment($('#newdp1').data("DateTimePicker").date()).format('d') : moment($('#newdtp1').data("DateTimePicker").date()).format('d');
                                    $('input[name="newDayOfWeek[]"]').each(function() {
                                        $(this).parent().removeClass('active');
                                        this.checked = false;
                                        if(this.value === dSel) { this.checked = true; $(this).parent().addClass('active') };
                                    });
                                    if(getDataPicker('new') === "allday") {
                                        $('#newChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#newdp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#newdp1').data("DateTimePicker").date()).format('D') );
                                        $('#newRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#newdp1').data("DateTimePicker").date()) + " " + moment($('#newdp1').data("DateTimePicker").date()).format('dddd') );
                                        $('#newChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#newdp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepYear0').text( i18n.core.yearly_on+" " + moment($('#newdp1').data("DateTimePicker").date()).format('D MMMM') );
                                        $('#newRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#newdp1').data("DateTimePicker").date()) + " " + moment($('#newdp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#newdp1').data("DateTimePicker").date()).format('MMMM'));                
                                    }else{
                                        $('#newChooseMonthTime').html('<span style="float: left">'+i18n.core.every_month_on_day+' '+moment($('#newdtp1').data("DateTimePicker").date()).format('D')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepMonth0').text( i18n.core.every_month_on_day+" " + moment($('#newdtp1').data("DateTimePicker").date()).format('D') );
                                        $('#newRepMonth1').text( i18n.core.monthly_on_the+" " + getWeekOfMonth($('#newdtp1').data("DateTimePicker").date()) + " " + moment($('#newdtp1').data("DateTimePicker").date()).format('dddd') );
                                        $('#newChooseYearTime').html('<span style="float: left">'+i18n.core.yearly_on+' '+moment($('#newdtp1').data("DateTimePicker").date()).format('D MMMM')+'</span><span class="caret" style="margin-top: 8px; float: right"></span>');
                                        $('#newRepYear0').text( i18n.core.yearly_on+" " + moment($('#newdtp1').data("DateTimePicker").date()).format('D MMMM') );
                                        $('#newRepYear1').text( i18n.core.every+" " + getWeekOfMonth($('#newdtp1').data("DateTimePicker").date()) + " " + moment($('#newdtp1').data("DateTimePicker").date()).format('dddd')+ " "+i18n.core.of+" " +moment($('#newdtp1').data("DateTimePicker").date()).format('MMMM'));                
                                    }
                                    $("#newMonthTimeRecurring").val($('#newRepMonth0').text());
                                    $("#newYearTimeRecurring").val($('#newRepYear0').text());

                                    if(getDataPicker('new') === "allday"){
                                        if($('#divNewDateAllday').css('display') === 'none'){ $('.divNewDateAllday, .divNewDateCustom').slideToggle( "fast" ); }
                                        $('#newenddp1').data("DateTimePicker").date(  $('#newdp2').data("DateTimePicker").date()  );                
                                    }
                                    if(getDataPicker('new') === "custom"){
                                        if($('#divNewDateCustom').css('display') === 'none'){ $('.divNewDateAllday, .divNewDateCustom').slideToggle( "fast" ); }
                                        $('#newenddp1').data("DateTimePicker").date(  $('#newdtp2').data("DateTimePicker").date()  );            
                                    }

                                });    

                                $('#cal_newModal').modal('show');

                                $('#formNewEvent').on("submit", function(event){
                                    event.preventDefault();

                                    $("#newDescription2").val( $("#newDescription").html() );

                                    $.ajax({
                                        url: pathRel + '/php/insert.php', data : $('#formNewEvent').serialize(), cache : false, type : 'post', dataType: 'json',
                                        success : function (data) {
                                            if(data.status){
                                                $('#cal_newModal').modal('hide');
                                                calendar.refetchEvents();
                                            }else{
                                                alert("error : "+data.msg);
                                            }
                                        },
                                        error: function (jqXHR, exception) {
                                            alert( checkException(jqXHR, exception) );
                                        }
                                    });
                                    return false;
                                });
                            }
                        });

                    }
                });
                
                loadI18n(defs_.selectedLocaleCode);
                calendar.render();
                setCategories(defs_.optCategories);
                
                /* Build the locale options (if exists) */
                try {
                    if(document.getElementById(defs_.barLanguage.selector) !== null){

                        calendar.getAvailableLocaleCodes().forEach(function(localeCode) {
                            if((jQuery.inArray( localeCode, Object.keys(defs_.barLanguage.enabled) ) > -1) || (jQuery.inArray( 'all', Object.keys(defs_.barLanguage.enabled) ) > -1) || (localeCode === defs_.selectedLocaleCode)){
                                var optionEl = document.createElement('option');
                                optionEl.value = localeCode;
                                optionEl.selected = localeCode === defs_.initialLocaleCode;
                                //optionEl.innerText = defs_.barLanguage.enabled[localeCode]; //localeCode;
                                optionEl.innerText = (jQuery.inArray( 'all', Object.keys(defs_.barLanguage.enabled) ) > -1) ? localeCode :defs_.barLanguage.enabled[localeCode];
                                document.getElementById(defs_.barLanguage.selector).appendChild(optionEl);
                            }
                        });

                        /* When the selected option changes, dynamically change the calendar option */
                        document.getElementById(defs_.barLanguage.selector).addEventListener('change', function() {
                            if (this.value) {

                                var selLang = this.value;

                                /* Check if selected language exist */
                                var f1 = pathRel + "resources/locales/"+selLang+".json";
                                var f2 = pathRel + "resources/locales/en.json";
                                if( f1.fileExists() === false ){
                                    if(selLang === "en") { alert("Please check if exist the default language files (en) for this calendar :\r\n\r\n"+f1+"\r\n\r\n"); return; }
                                    if( f2.fileExists() === false ){
                                        alert("Please check if exist the language files ("+selLang+" and en) for this calendar :\r\n\r\n"+f1+"\r\n"+f2+"\r\n\r\n"); return;
                                    }else{
                                        alert("Your selected language file ("+selLang+") does'n exist, default english language was selected (only for GUI)");
                                        selLang = 'en';
                                    }
                                }                            

                                calendar.setOption('locale', this.value);
                                defs_.selectedLocaleCode = selLang;
                                loadI18n(defs_.selectedLocaleCode);
                                setCategories(defs_.optCategories);

                            }
                        });
                    }
                } catch (e) {};
                
                
                $('.div-cal').bind('refreshCalendar',function() { calendar.refetchEvents(); });

                /* Bind search button (if exists) */
                try {
                    $('#'+defs_.barSearch.btnSearch).on("click", function(){
                        calendar.batchRendering(function() {
                            var allEvents = calendar.getEvents()
                            for (var i = 0; i < allEvents.length; i++) {
                                var sEvent = allEvents[i]
                                if ((sEvent.title.toLowerCase().indexOf( $("#"+defs_.barSearch.txtSearch).val().toLowerCase() ) > -1) || (sEvent.extendedProps.description.toLowerCase().indexOf( $("#"+defs_.barSearch.txtSearch).val() ) > -1)){
                                    sEvent.setProp('display', 'auto')
                                }else{
                                    sEvent.setProp('display', 'none')
                                }
                            }
                        });
                    });
                } catch (e) {};

                /* Bind reset search button (if exists) */
                try {
                    $('#'+defs_.barSearch.btnReset).on("click", function(){
                        $("#"+defs_.barSearch.txtSearch).val('');
                        $('#'+defs_.barSearch.btnSearch).click();
                    });
                } catch (e) {};
                
                /* Export Calendar Events */
                if((defs_.barImport) && (document.getElementById(defs_.barImport.btnExport) !== null)){
                    $('#'+defs_.barImport.btnExport).on("click", function(){
                        location.href = pathRel + 'php/exportAll.php?uuid='+defs_.uuidCalendar;
                    });
                };

                /* Import Calendar Events */
                if((defs_.barImport) && (document.getElementById(defs_.barImport.btnImport) !== null)){
                    $('#'+defs_.barImport.btnImport).on("click", function(){

                        $.ajax({
                            url: pathRel + '/ajax/import.php',
                            type: 'post',
                            data: { lang: defs_.selectedLocaleCode },
                            success: function(response){

                                $('#importModal').remove();
                                $('<div id="importModal" class="modal fade col-xs-12 col-sm-12 col-md-12"></div>').appendTo('body');
                                $('#importModal').html(response);
                                $('#importModal').modal('show');

                                $('#btn_upload').click(function(){

                                    var fd = new FormData();
                                    var files = $('#file')[0].files[0];
                                    fd.append('file',files);
                                    fd.append('lang', defs_.selectedLocaleCode);

                                    $('#btn_upload').replaceWith('<button id="btn_upload" type="button" class="btn btn-warning btn-block disabled">Loading...</button>');

                                    $.ajax({

                                        url: pathRel + '/php/import.php', data : fd, cache : false, type : 'post', dataType: 'json', contentType: false, processData: false,
                                        success : function (data) {
                                            if(data.status){

                                                $('#btn_upload').replaceWith('<button id="btn_upload" type="button" class="btn btn-warning btn-block disabled">'+data.importedEvents.length+' events loaded</button>');

                                                $('#fileContent').val(data.contentFile);
                                                setTimeout(function() { $('#importModal').modal('hide'); }, 3000);
                                                var eventSource = calendar.getEventSources();
                                                if(eventSource.length > 1){ var ss = calendar.getEventSourceById(99999); if(ss){ ss.remove();} };
                                                calendar.addEventSource({ id: 99999, events: data.importedEvents, failure: function() { alert('Error loading events'); } });
                                                calendar.refetchEvents();

                                                $('#'+defs_.barImport.btnReset).prop('disabled', false);
                                                $('#'+defs_.barImport.btnReset).on("click", function(){
                                                    var eventSource = calendar.getEventSources();
                                                    if(eventSource.length > 1){ var ss = calendar.getEventSourceById(99999); if(ss){ ss.remove();} };
                                                    calendar.refetchEvents();
                                                    $('#'+defs_.barImport.btnReset).prop('disabled', true);
                                                });

                                            }else{
                                                $('#fileContent').val(data.msg);
                                                $('#btn_upload').replaceWith('<button id="btn_upload" type="submit" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-upload"></i>&nbsp;Upload</button>');
                                            }

                                        },
                                        error: function (jqXHR, exception) {
                                            $('#btn_upload').replaceWith('<button id="btn_upload" type="submit" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-upload"></i>&nbsp;Upload</button>');                                        
                                            $('#fileContent').val(checkException(jqXHR, exception));
                                        }

                                    });
                                });

                                $('#formLoadURL').on("submit", function(event){

                                    event.preventDefault();
                                    $('#btn_upload_from_URL').replaceWith('<button id="btn_upload_from_URL" type="button" class="btn btn-warning btn-block disabled">Loading...</button>');

                                    $.ajax({
                                        url: pathRel + '/php/import.php', data : $('#formLoadURL').serialize(), cache : false, type : 'post', dataType: 'json',
                                        success : function (data) {
                                            if(data.status){

                                                $('#btn_upload_from_URL').replaceWith('<button id="btn_upload_from_URL" type="button" class="btn btn-warning btn-block disabled">'+data.importedEvents.length+' events loaded</button>');

                                                setTimeout(function() { $('#importModal').modal('hide'); }, 3000);

                                                var eventSource = calendar.getEventSources();
                                                if(eventSource.length > 1){ var ss = calendar.getEventSourceById(99999); if(ss){ ss.remove();} };
                                                calendar.addEventSource({ id: 99999, events: data.importedEvents, failure: function() { alert('Error loading events'); } });
                                                calendar.refetchEvents();

                                                $('#'+defs_.barImport.btnReset).prop('disabled', false);
                                                $('#'+defs_.barImport.btnReset).on("click", function(){
                                                    var eventSource = calendar.getEventSources();
                                                    if(eventSource.length > 1){ var ss = calendar.getEventSourceById(99999); if(ss){ ss.remove();} };
                                                    calendar.refetchEvents();
                                                    $('#'+defs_.barImport.btnReset).prop('disabled', true);
                                                });                                    

                                            }else{
                                                alert(data.msg);
                                            }

                                        },
                                        error: function (jqXHR, exception) {
                                            alert( checkException(jqXHR, exception) );
                                        }
                                    });
                                    return false;
                                });                    

                            }

                        });

                    });
                };

                function getDataPicker(action){
                    if(action === 'new'){
                        return $('input[name="newDateType"]:checked').val();
                    }
                    if(action === 'edit'){
                        return $('input[name="editDateType"]:checked').val();
                    }
                }

                function resetRecurringValues(action){

                    $("#"+action+"DivDaysRecurring").css('display', 'none');
                    $("#"+action+"DivWeeksRecurring").css('display', 'none');
                    $("#"+action+"DivMonthsRecurring").css('display', 'none');
                    $("#"+action+"DivYearsRecurring").css('display', 'none');
                    $('input[name="'+action+'DayOfWeek"]').each(function() { $(this).parent().removeClass('active'); this.checked = false; });
                    $("#"+action+"-pills-never-tab").removeClass('active');
                    $("#"+action+"-pills-date-tab").removeClass('active');
                    $("#"+action+"-pills-after-tab").removeClass('active');
                    $("#"+action+"-pills-never-tab").parent().removeClass('active');
                    $("#"+action+"-pills-date-tab").parent().removeClass('active');
                    $("#"+action+"-pills-after-tab").parent().removeClass('active');
                    $("#"+action+"-pills-date").removeClass('show active');
                    $("#"+action+"-pills-after").removeClass('show active');
                    $("#"+action+"EndOccurrences").val("1");
                    $("#"+action+"-pills-never-tab").addClass('active');
                    $("#"+action+"-pills-never-tab").parent().addClass('active');

                    if(getDataPicker(action) === "allday") {
                        $("#"+action+"enddp1").data("DateTimePicker").date( $("#"+action+"dp2").data("DateTimePicker").date() );
                        $("#"+action+"enddp1").data("DateTimePicker").minDate( $("#"+action+"dp1").data("DateTimePicker").date() );
                    }else{
                        $("#"+action+"enddp1").data("DateTimePicker").date( $("#"+action+"dtp2").data("DateTimePicker").date() );
                        $("#"+action+"enddp1").data("DateTimePicker").minDate( $("#"+action+"dtp1").data("DateTimePicker").date() );
                    }

                }

                function getWeekOfMonth(date) {

                    var arr = i18n.core.week_of_month;
                    prefixes = [arr.first, arr.second, arr.third, arr.fourth, arr.last ];

                    var m = moment(date), weekDay = m.day(), yearDay = m.dayOfYear(), count = 0;
                    m.startOf('month');
                    while (m.dayOfYear() <= yearDay) { 
                        if (m.day() === weekDay) { count++; }
                        m.add(1, 'days'); 
                    }
                    return prefixes[count-1];

                }

                return this;
            }
        };

        if( typeof opt !== "undefined" ){

            var calendar, i18n = "";
            var defs_ = {
                initCal: false,
                uuidCalendar: '',
                selectedLocaleCode: 'en',
                barLanguage: null,
                barSearch: null,
                barImport: null,
                divLoad: '',
                divCal: '',
                popOver: false,
                readOnly: false,
                txColor: '#ffffff',
                bgColor: '#000000',
                bgColorImported: '#fff000',
                optCategories: '',
                initialTimeZone: 'UTC'
            };
            
            opt = $.extend(defs_, opt);

            /* Check if DIV calendar exist */
            if(document.getElementById(defs_.divCal) === null){
                alert("Please, specifies a div to render the calendar"); return;
            }
          
            /* Check if calendarmaker.js SCRIPT has caljs ID */
            if(document.getElementById('caljs') === null){
                alert("Please assign id='caljs' to calendarmaker.js"); return;
            }            
            var pathJS = $('<a>', { href: document.getElementById('caljs').src });
            var pathRel = pathJS.prop('protocol') + "//" + pathJS.prop('hostname') + "/" + pathJS.prop('pathname').substring(0, pathJS.prop('pathname').lastIndexOf('/') + 1);

            /* Load calendar settings */
            loadSettings(defs_.uuidCalendar);
            if( defs_.initCal === false ) return;
            
            methods.init(opt);
            return methods;
        }else{
            /* Return all available locales codes */
            methods.getLocaleCodes();
            return methods;
        }

    };

}( jQuery ));