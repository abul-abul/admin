<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
        <meta name="author" content="GeeksLabs">
        <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
        <link rel="shortcut icon" href="img/favicon.png">

        <title>Fan4.life</title>

            <!-- js files to admin -->
        {!! Html::script( asset('assets/js/bootstrap-filestyle.js')) !!}  
        <!-- Bootstrap CSS -->    
        {!! Html::style( asset('assets/admin/css/bootstrap.min.css')) !!}
        <!-- bootstrap theme -->
        {!! Html::style( asset('assets/admin/css/bootstrap-theme.css')) !!}
        <!--external css-->
        <!-- font icon -->
        {!! Html::style( asset('assets/admin/css/elegant-icons-style.css')) !!}
        {!! Html::style( asset('assets/admin/css/font-awesome.min.css')) !!}
      
        <!-- full calendar css-->
        {!! Html::style( asset('assets/admin/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css')) !!}
        {!! Html::style( asset('assets/admin/assets/fullcalendar/fullcalendar/fullcalendar.css')) !!}

        <!-- easy pie chart-->
        {!! Html::style( asset('assets/admin/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')) !!}
        <!-- owl carousel -->
        {!! Html::style( asset('assets/admin/css/owl.carousel.css')) !!}
        {!! Html::style( asset('assets/admin/css/jquery-jvectormap-1.2.2.css')) !!}

        <!-- Custom styles -->
        {!! Html::style( asset('assets/admin/css/fullcalendar.css')) !!}
        {!! Html::style( asset('assets/admin/css/widgets.css')) !!}
        {!! Html::style( asset('assets/admin/css/style.css')) !!}
        {!! Html::style( asset('assets/admin/css/style-responsive.css')) !!}
        {!! Html::style( asset('assets/admin/css/xcharts.min.css')) !!}
        {!! Html::style( asset('assets/admin/css/jquery-ui-1.10.4.min.css')) !!}
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Admin Fan4.live</title>

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        
        <!-- {!! Html::style( asset('css/admin-main.css')) !!} -->
        <!-- js files to admin -->
        {!! Html::script( asset('assets/js/bootstrap-filestyle.js')) !!}    
        <!--// js files to admin -->    
    </head>
    <body>
        <section id="container" class="">
            <header class="header dark-bg" style="position:relative;margin:0;padding:0">
                <div class="toggle-nav">
                    <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"></div>
                </div>

                <!--logo start-->
                <a href="{{action('AdminController@getDashboard')}}" class="logo">Fan <span class="lite">Admin</span></a>
                <!--logo end-->

                <div class="top-nav notification-row">                
                       
                </div>
                <span class='navbar-nav' style='display:block;float:right;color:#fff;padding:13px'>
                    <a href = "{{action('AdminController@getLogout')}}">LogOut</a>
                </span>
            </header>
        </section>  
              <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse" style="position:relative;float:left">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" style="margin:0">                
                  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="icon_document_alt"></i>
                          <span>Domain</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="{{action('AdminController@getDomainList')}}">Domain List</a></li>                          
                          <li><a class="" href="{{action('AdminController@getAddDomain')}}">Add Domain</a></li>
                      </ul>
                  </li>       
                  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="icon_desktop"></i>
                          <span>Language</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="{{action('AdminController@getLanguageList')}}">Language List</a></li>
                          <li><a class="" href="{{action('AdminController@getAddLanguage')}}">Add language</a></li>
                      </ul>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          </div>
          <!--sidebar end-->
        <section id="main-content" style="margin:0;float:left;position:relative">
            <section class="wrapper" style="margin:0">            
              <!--overview start-->
              <div class="row" style="position:absolute">
                  @yield('content')
              </div>    
                <!--/.row-->
            </section>
        </section>
      </aside>
      
<!-- container section start -->

    <!-- javascripts -->
    {!! Html::script( asset('assets/admin/js/jquery.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery-ui-1.10.4.min.js'))!!}  
    {!! Html::script( asset('assets/admin/js/jquery-1.8.3.min.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery-ui-1.9.2.custom.min.js')) !!}  
    {!! Html::script( asset('assets/admin/js/bootstrap.min.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery.nicescroll.js')) !!}  
    {!! Html::script( asset('assets/admin/assets/jquery-knob/js/jquery.knob.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery.sparkline.js')) !!}  
    {!! Html::script( asset('assets/admin/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js')) !!}  
    {!! Html::script( asset('assets/admin/js/owl.carousel.js')) !!}  
    {!! Html::script( asset('assets/admin/assets/fullcalendar/fullcalendar/fullcalendar.min.js')) !!}  
    {!! Html::script( asset('assets/admin/assets/fullcalendar/fullcalendar/fullcalendar.js')) !!}   
    {!! Html::script( asset('assets/admin/js/calendar-custom.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery.rateit.min.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery.customSelect.min.js')) !!}  
    {!! Html::script( asset('assets/admin/assets/chart-master/docs/Chart.js')) !!}  
    {!! Html::script( asset('assets/admin/js/scripts.js')) !!}  
    {!! Html::script( asset('assets/admin/js/sparkline-chart.js')) !!}  
    {!! Html::script( asset('assets/admin/js/easy-pie-chart.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery-jvectormap-1.2.2.min.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery-jvectormap-world-mill-en.js')) !!}  
    {!! Html::script( asset('assets/admin/js/xcharts.min.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery.autosize.min.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery.placeholder.min.js')) !!}  
    {!! Html::script( asset('assets/admin/js/gdp-data.js')) !!}  
    {!! Html::script( asset('assets/admin/js/morris.min.js')) !!}  
    {!! Html::script( asset('assets/admin/js/sparklines.js')) !!}  
    {!! Html::script( asset('assets/admin/js/charts.js')) !!}  
    {!! Html::script( asset('assets/admin/js/jquery.slimscroll.min.js')) !!}  
    

   
  <script>

  //knob
  $(function() {
    $(".knob").knob({
      'draw' : function () { 
        $(this.i).val(this.cv + '%')
      }
    })
  });
  //carousel
  $(document).ready(function() {
      $("#owl-slider").owlCarousel({
          navigation : true,
          slideSpeed : 300,
          paginationSpeed : 400,
          singleItem : true
      });
  });
  //custom select box
  $(function(){
      $('select.styled').customSelect();
  });
  
  /* ---------- Map ---------- */
$(function(){
  $('#map').vectorMap({
    map: 'world_mill_en',
    series: {
      regions: [{
        values: gdpData,
        scale: ['#000', '#000'],
        normalizeFunction: 'polynomial'
      }]
    },
    backgroundColor: '#eef3f7',
    onLabelShow: function(e, el, code){
      el.html(el.html()+' (GDP - '+gdpData[code]+')');
    }
  });
});



  </script>

  </body>
</html>



