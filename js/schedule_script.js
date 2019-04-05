jQuery(document).ready(function(){
  jQuery('.schedule_main').find('a').on('click',function(){
    // Post id
    var post_id = jQuery(this).attr('data-id');
    var trainer_id = jQuery(this).attr('data-trainer');

    jQuery('.vividmodal-body').html('');
    jQuery('.vividmodal-body').html('<div class="loader"><img src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/img/ajax-loader.gif" class="hide_loader"></div>');
    var schedule_id = jQuery(this).attr("data-id");
    console.log(schedule_id);
    // jQuery('#popup_trigger').trigger('click');
    var ajaxurl = treadfit.ajax_url;
    jQuery.post(
      ajaxurl,
        {
            'action'        :   'schedule_popup_data',
            'schedule_id'   :   schedule_id,
            'post_id'       :   post_id,
            'trainer_id'    :   trainer_id,
        },
        function(response){
            var response = jQuery.parseJSON(response);
            if(response.error == true)
            {
                window.location.replace(response.redirect);
            }
            else
            {
               jQuery('.hide_loader').hide();
               //console.log(response);
               jQuery('.vividmodal-body').html(response.html);
               // jQuery('#vividModal').modal('show');
               jQuery('#vividModal').css('display', 'block');
               rotate_chevron_down();
               close_model();
               setTimeout(function()
               {
                 jQuery('.schedule-popup-heading').text("Great! You're in.");
                 jQuery('.schedule-popup-book-class').addClass('schedule-popup-btn-added-to-calender');
                 jQuery('.schedule-popup-btn-added-to-calender').removeClass('schedule-popup-book-class');
                 googleCalender();
                 RemoveHiddenClassGoogleCalendarLinks();
               }, 2000);
            }
        }
    );


  });
});

function close_model()
{
  jQuery('.vividclose').click(function()
    {
      jQuery('#vividModal').css('display', 'none');
    });
}


function RemoveHiddenClassGoogleCalendarLinks()
{
  jQuery('.schedule-popup-btn-added-to-calender').click(function()
  {
    jQuery(this).parent().find('.link-add-to-my-calendar').css('display', 'flex');
  });
}


function googleCalender()
{
  jQuery('.schedule-popup-btn-added-to-calender').click(function()
  {
    var adminUrl = treadfit.ajax_url;
    var fd = "action=add_event_to_google_calender";
    jQuery.ajax({
     type: "POST",
     url: adminUrl,
     dataType: "html",
     data: fd,
     success: function(response)
     {
     }
   });
  });
}

function rotate_chevron_down()
{
  jQuery('.schedule-popup-title').click(function()
  {
    jQuery(this).find('svg').toggleClass('spin-me-180-deg');
    jQuery('.schedule-popup-description-toggle').slideToggle();
  });
}

/* Date slider + Popup */


  jQuery('.today_dt').click(function(event) {

  });


  function generate_week_next($date){
  var curr = new Date($date); // get current date
  console.log('Next BTN ==='+$date);
  var first = curr.getDate();
  var firstday = (new Date(curr.setDate(first))).toString();
  var weekday = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
  var datesel = [];
  var d_og = [];
  var yy, dn,d,m,cdn,cd,cm;
  cdn =curr.getDay();
  cd = curr.getDate();
  cm = curr.getMonth()+1;
  cy = curr.getFullYear();
  //datesel.push(weekday[cdn]+' '+cd+'/'+cm);
  //d_og.push(cy+'-'+cm+'-'+cd);
  for(var i = 1;i<=7;i++){
     var next = new Date(curr.getTime());
     next.setDate(first+i);
    //yy =next.getFullYear().toString().substr(-2);
    yy =next.getFullYear();
    m = next.getMonth()+1;
    dn = next.getDay();
    d= next.getDate();
    datesel.push(weekday[dn]+' '+d+'/'+m);
    d_og.push(yy+'-'+m+'-'+d);

  }
  //console.log(datesel);
  var main = [];
  main['print'] = datesel;
  main['og'] = d_og;
  return main;
}
function generate_week_prev($date){
  var curr = new Date($date); // get current date
  //console.log(curr);
  console.log('prev BTN ==='+$date);
  var first = curr.getDate();
  var firstday = (new Date(curr.setDate(first))).toString();
  var weekday = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
  var datesel = [];
  var d_og = [];
  var yy, dn,d,m,cdn,cd,cm;
  cdn =curr.getDay();
  cd = curr.getDate();
  cm = curr.getMonth()+1;
  cy = curr.getFullYear();
  //datesel.push(weekday[cdn]+' '+cd+'/'+cm);
  //d_og.push(cy+'-'+cm+'-'+cd);
  for(var i = 1;i<=7;i++){
     var next = new Date(curr.getTime());
     next.setDate(first-i);
    //yy =next.getFullYear().toString().substr(-2);
    yy =next.getFullYear();
    m = next.getMonth()+1;
    dn = next.getDay();
    d= next.getDate();
    datesel.push(weekday[dn]+' '+d+'/'+m);
    d_og.push(yy+'-'+m+'-'+d);

  }
  //console.log(datesel);
  var main = [];
  main['print'] = datesel.reverse();
  main['og'] = d_og.reverse();
  return main;
}
function generate_week_next_click(){
  var current_date_check = new Date();
  var current_date = current_date_check.getDate();
  var current_month = (current_date_check.getMonth()+1);
  var check_today_date = current_date+"/"+current_month;

  var last_weekdate = jQuery('.date_ul li:last-child').attr('data-date');
  var first_weekdate = jQuery('.date_ul li:first-child').attr('data-date');
  var date_results = generate_week_next(last_weekdate);

  var html = '';
  for(var i = 0;i<date_results['print'].length;++i){
    var day = date_results['print'][i].split(" ");
    var month = day[0];
    var date = day[1];
  date = date.split("/");
  date = date[0];
  if(date.length < 2)
  {
    date = "0"+date;
  }
  else
  {
    date = date;
  }
    // html +='<li data-date="'+date_results['og'][i]+'"><a href="javascript:void(0);" id="'+date_results['og'][i]+'" onclick="filter_date(this.id);">'+date_results['print'][i]+'</a></li>';
  if(check_today_date == day[1])
  {
    html += '<li data-date="'+date_results['og'][i]+'"><a class="day_active" href="javascript:void(0);" id="'+date_results['og'][i]+'" onclick="filter_date(this.id);"><div class="abcd"><div class="week">'+month+'</div><div class="day">'+date+'</div></div></a> </li>';
  }
  else
  {
    html += '<li data-date="'+date_results['og'][i]+'"><a href="javascript:void(0);" id="'+date_results['og'][i]+'" onclick="filter_date(this.id);"><div class="abcd"><div class="week">'+month+'</div><div class="day">'+date+'</div></div></a> </li>';
  }
  }
  jQuery('.date_ul').html(html);
  week_first_date_data(date_results['og'][0]);

  jQuery('.date_week').find('.date-prev').removeClass('disable');
  jQuery('.date_week').find('.date-next').addClass('disable');
}
function generate_week_prev_click(){
  var current_date_check = new Date();
  var current_date = current_date_check.getDate();
  var current_month = (current_date_check.getMonth()+1);
  var check_today_date = current_date+"/"+current_month;
  var last_weekdate = jQuery('.date_ul li:last-child').attr('data-date');
  var first_weekdate = jQuery('.date_ul li:first-child').attr('data-date');
  var date_results = generate_week_prev(first_weekdate);

  var html = '';
  for(var i = 0;i<date_results['print'].length;++i){
  var day = date_results['print'][i].split(" ");
    var month = day[0];
    var date = day[1];
  date = date.split("/");
  date = date[0];
  if(date.length < 2)
  {
    date = "0"+date;
  }
  else
  {
    date = date;
  }
    // html +='<li data-date="'+date_results['og'][i]+'"><a href="javascript:void(0);" id="'+date_results['og'][i]+'" onclick="filter_date(this.id);">'+date_results['print'][i]+'</a></li>';
  if(check_today_date == day[1])
  {
    html += '<li data-date="'+date_results['og'][i]+'"><a class="day_active" href="javascript:void(0);" id="'+date_results['og'][i]+'" onclick="filter_date(this.id);"><div class="abcd"><div class="week">'+month+'</div><div class="day">'+date+'</div></div></a> </li>';
  }
  else
  {
    html += '<li data-date="'+date_results['og'][i]+'"><a href="javascript:void(0);" id="'+date_results['og'][i]+'" onclick="filter_date(this.id);"><div class="abcd"><div class="week">'+month+'</div><div class="day">'+date+'</div></div></a> </li>';
  }
  }

  jQuery('.date_ul').html(html);
  week_first_date_data(date_results['og'][0]);

  jQuery('.date_week').find('.date-prev').addClass('disable');
  jQuery('.date_week').find('.date-next').removeClass('disable');

}
function week_first_date_data($date){
  var firstdate = new Date($date);
  var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
  var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];
  var dn,m,d;
  dn = firstdate.getDay();
  m = firstdate.getMonth();
  d = firstdate.getDate();
  var formatted_date = weekday[dn]+', '+monthNames[m]+' '+d+nth(d);

  jQuery('#current_date').html(formatted_date);
}
function nth(d) {
  if(d>3 && d<21) return 'th'; // thanks kennebec
  switch (d % 10) {
        case 1:  return "st";
        case 2:  return "nd";
        case 3:  return "rd";
        default: return "th";
    }
}
function filter_date($date){
  week_first_date_data($date);
  //console.log($date);
  jQuery('html, body').animate({
        scrollTop: jQuery("#div-"+$date).offset().top-120
    }, 2000);

    jQuery('.date_ul li a').each(function(){
    jQuery(this).removeClass('day_active');
  });

  jQuery('#'+$date).addClass('day_active');
}

jQuery(document).ready(function()
{
  jQuery('.btn-count-me-out').mouseenter(function()
  {
    jQuery(this).text("Cancel");
  });

  jQuery('.btn-count-me-out').mouseleave(function()
  {
    jQuery(this).text("You're in");
  });

  jQuery('.btn-count-me-out').click(function()
  {
    jQuery('.schedule_main').find('a').unbind('click');

    var post_id  = jQuery(this).attr('id');
    var trainer_id = jQuery(this).attr('data-trainer-id');
    var ajaxurl = treadfit.ajax_url;

    if(post_id != '' && trainer_id != '')
    {
      jQuery.post(
        ajaxurl,
          {
              'action'        :   'vivid_count_me_out',
              'post_id'       :   post_id,
              'trainer_id'    :   trainer_id,
          },
          function(response)
          {
            if(response != '')
            {
              var JsonDecode = jQuery.parseJSON(response);
              if(JsonDecode.msg == "success")
              {
                location.reload(1);
              }
            }
          });
    }

  });
});
