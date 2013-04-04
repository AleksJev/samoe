<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>Самое самое</title>
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>css/style.css"/>
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>css/overcast/jquery-ui-1.8.18.custom.css"/>
    <script type="text/javascript" src="<?=base_url();?>js/jquery-1.7.1.js"></script>
     <script type="text/javascript" src="<?=base_url();?>js/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>js/my.js"></script>
    <link rel="stylesheet" type="text/css" media="print" href="/css/print.css" />
    <script type="text/javascript" src="/smt2/core/js/smt-aux.min.js"></script>  
  <script type="text/javascript" src="/smt2/core/js/smt-record.min.js"></script>
    <link rel="icon" type="image/ico" href="/favicon.ico" />

  <script type="text/javascript">
  try {
    smt2.record({
      recTime: 300,
      disabled: Math.round(Math.random()),
      warn: true, 
      warnText: "We are going to record your mouse movements for a remote usability study."
    });
  } catch(err) {}

  $(document).ready(function(){
      /*
      $('.in_main').masonry({
          itemSelector: '.latest_art',
          singleMode: true,
          isResizable: true,
          isAnimated: false,
          animationOptions: {
              queue: false,
              duration: 500
          }
      });*/
  });
  </script>
  
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 100% }
    </style>
    <script type="text/javascript"
      src="https://maps.google.com/maps/api/js?v=3.4&sensor=false">
    </script>
    <script type="text/javascript">
	function initialize() {
    var latlng = new google.maps.LatLng(56.948579,24.133873);
    var myOptions = {
      zoom: 16,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.HYBRID
    };
	
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);
		var marker = new google.maps.Marker({

		  position: latlng,
			title:"Web skola!"
		});
		marker.setMap(map);
  }
      /*function initialize() {
        var myOptions = {
          center: new google.maps.LatLng(56.948579,24.133873),  
          zoom:15,
		  position:google.maps.LatLng,
		  mapTypeId: google.maps.MapTypeId.HYBRID
        };
		var marker = new google.maps.Marker({

		  position: google.maps.LatLng,

		});
        var map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);
      }// 56.95018,23.99863   // (-34.397, 150.644),*/
    </script>

</head>
<body>
    <div id="container">
        <div id="header">
           <!-- <div id="logo"><a href="/">Самое Самое</a></div>-->
           <div class="logo">
        <a href="/"><p class="skew" title="Самое Самое">Самое Самое</p></a>
        </div>
        <?if($logged_in == 'logged'){?>
            <div id="enter_site">
                <p>Приветствуем тебя <?=$name;?><br />
                    <a href="/users/cabinet">Кабинет</a>
                </p>
                <a href="/users/logout">Выйти</a><br />
            </div>
        <? }else {?>
             <div id="enter_site">
            <form action="/users/enter" method="post">
                <fieldset>
                    <legend>Вступить в сообщество</legend>
                     <input type="text" name="user" placeholder="Login" size="9"/>
                     <input type="password" name="password" placeholder="Password" size="9"/>
                     <input type="submit" name="enter" value="Вход" /><br />
                     <a id="reg_link" href="/users/register">Регистрация</a> ||
                     <a id="reg_link" href="/users/forgot_password">Забыл пароль</a>
                </fieldset>
            </form>
        </div>
        <? }?>
        <div id="search">
            <form action="/articles/search" method="post">
                <input type="text" name="search"/>
                <input class="search" type="submit" value="search"/>
            </form>
        </div>
    </div>