<html>
	<head>
		<title>Chat Client</title>
		<script src="jquery-2.1.4.min.js"></script>
		<script>
			var repeat='';
			var irri=0;
			var groep='';

			$(document).ready(function(){
				groepnummer();
				lees_emos();
				doe_init();
				begin_Interval();
				$("#ding").click(doe_ding);
			});

			function groepnummer(){
				<?php
					$groep = isset( $_GET['groep'] ) ? $_GET['groep'] : '1';
					date_default_timezone_set('Europe/Amsterdam');
					$caller=basename($_SERVER['SCRIPT_FILENAME']);
					$ip = $_SERVER['REMOTE_ADDR'];
					$bro = $_SERVER['HTTP_USER_AGENT'];
					$regel = date('Y-m-d H:i:s') . ' | ' . $ip . ' | ' . $caller . ' | ' . $bro . PHP_EOL;
					$file=fopen('logs/ip_log.txt','a');
					fputs($file,$regel);
					fclose($file);
				 ?>
				 groep="groep_<?php echo $groep;?>";
			};
			
			function doe_ding(){
				irri++;
				if (irri>3) {
				 $("#phoneglare").css("background-image","url('images/kepodt.png')");
				}
				if (irri>10) {
				 $("#phoneglare").css("background-image","url('images/iphone4_glare.png')");
				 irri=0;
				}
			};
			
			function begin_Interval(){
				repeat=setInterval(zoek, 2000);
			};

			function lees_emos(){
				$("#emoji").html('');
				for (i=1;i<218;i++) {
					$("#emoji").append('<div class="midden_emoji"><img src="emoji/emoji_'+pad(i,5)+'.png" onclick="terugemo('+i+')"/></div>');
				};	
			};
			
			function doe_init(){
				$.post("leerling_init.php",{
					'groep' : groep					
				}, function(data){

					var lines = data.split('\n');
					tg=lines[0][0];
					tn=lines[0].substr(1);
					lg=lines[1][0];
					ln=lines[1].substr(1);

					$(".h_who").text(tn);

					if (tg == 'v') {$("#chat_icon").prop("src","images/girl.png")}
					else {$("#chat_icon").prop("src","images/boy.png")};

					if(  $("#plaatje img").attr("src") != "images/l"+lg+"1.jpg"  ) { 
						$("#plaatje").html('');
						for (i=1;i<10;i++) {
							$("#plaatje").append('<div class="midden"><img src="images/l'+lg+i+'.jpg" width="200px" onclick="terug('+i+')"/></div>');
						};
					};
				});
			};


			function zoek(){
				ide=$('#chat div').eq(-2).attr('id');	
			    $.post("read.php",{
				    'groep': groep,
				    'ide': ide,
				    'naam': ln
			    }, function(data){
				    if (data=='leeg') {
					    $("#chat").html('');
						doe_init();
				    } else {
						$("#chat").append(data);
						if (data) {
							$("#chat").animate({scrollTop: $('#chat').prop("scrollHeight")+500}, 600);
						}
					};
				});
				$(".chat_input").focus();
			};

			function pad (str, max) {
			  str = str.toString();
			  return str.length < max ? pad("0" + str, max) : str;
			};

			function escapeHtml(text) {
			  var map = {
			    '&': '&amp;',
			    '<': '&lt;',
			    '>': '&gt;',
			    '"': '&quot;',
			    "'": '&#039;'
			  };
			  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
			}
						
			$(document).keypress(function(e) {
				gg=$(".chat_input").val();
			    if ((e.which == 13) && (gg!='') && (gg[0]!='<') && (gg[0]!='/') && (gg[0]!='@') ) {
				    var d = new Date();
				    var ms = pad(d.getMilliseconds(),3);
				    var dh=pad(d.getHours(),2);
				    var dm=pad(d.getMinutes(),2);

				    var tijd = dh+':'+dm;
					var tijd_id = dh + '' + dm + '' + ms + '';
				    var bericht = $(".chat_input").val();
 
				    var regel = '<div id="' + tijd_id + '" class="rechts">' + escapeHtml(bericht) + '<div class="time">' + tijd + '<img src="images/check.png" width="20px"/></div></div>';
				    $("#chat").append(regel);
				    $(".chat_input").val("");
				    
				    $.post("commit.php",{
					    'groep': groep,
					    'datum': tijd_id,
					    'naam': ln,
					    'bericht': bericht,
					    'tijd': tijd
				    });
				    
					$("#chat").animate({scrollTop: $('#chat').prop("scrollHeight")}, 600);
			    }
			});
			
			function plaatje(nummer){
			    var d = new Date();
			    var ms = pad(d.getMilliseconds(),3);
			    var dh=pad(d.getHours(),2);
			    var dm=pad(d.getMinutes(),2);

			    var tijd = dh+':'+dm;
				var tijd_id = dh + '' + dm + '' + ms + '';
			    var regel = '<div id="' + tijd_id + '" class="rechts">' + '<img src="images/l' + lg + nummer + '.jpg" width="200px"/>' + '<div class="time">' + tijd + '<img src="images/check.png" width="20px"/></div></div>';
			    $("#chat").append(regel);
			    $.post("commit.php",{
				    'groep': groep,
				    'datum': tijd_id,
				    'naam': ln,
				    'bericht': '/l' + lg + nummer,
				    'tijd': tijd
			    });
				$("#chat").animate({scrollTop: $('#chat').prop("scrollHeight")}, 600);
				
			};

			function emoji(nummer){
			    var d = new Date();
			    var ms = pad(d.getMilliseconds(),3);
			    var dh=pad(d.getHours(),2);
			    var dm=pad(d.getMinutes(),2);
			    var num=pad(nummer,5);

			    var tijd = dh+':'+dm;
				var tijd_id = dh + '' + dm + '' + ms + '';
			    var regel = '<div id="' + tijd_id + '" class="rechts">' + '<img src="emoji/emoji_' + num + '.png"/>' + '<div class="time">' + tijd + '<img src="images/check.png" width="20px"/></div></div>';
			    $("#chat").append(regel);
			    $.post("commit.php",{
				    'groep': groep,
				    'datum': tijd_id,
				    'naam': ln,
				    'bericht': '@' + num,
				    'tijd': tijd
			    });
				$("#chat").animate({scrollTop: $('#chat').prop("scrollHeight")}, 600);
				
			};

			function kies_plaatje(){
				$("#container_chat_l").animate({
					left: '-320'
				},500);
				$("#container_plaatje").animate({
					left: '0'
				},500);
			};

			function kies_emoji(){
				$("#container_chat_l").animate({
					left: '-320'
				},500);
				$("#container_emoji").animate({
					left: '0'
				},500);
			};

			function terug(nummer){
				$("#container_chat_l").animate({
					left: '0'
				},500);
				$("#container_plaatje").animate({
					left: '320'
				},500);
				if (! nummer==0){plaatje(nummer);}
			};

			function terugemo(nummer){
				$("#container_chat_l").animate({
					left: '0'
				},500);
				$("#container_emoji").animate({
					left: '320'
				},500);
				if (! nummer==0){emoji(nummer);}
			};


 		</script>
 		<link href='http://fonts.googleapis.com/css?family=Roboto:500' rel='stylesheet' type='text/css'>
 		<link href='style.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
	<div id="phone">
	<div id="container_screen">
	 <div id="container_chat_l">
		<div id="cheader">
			<div class="h_chats_1">je chat nu met:</div>
			<div class="h_who">...</div>
			<div class="h_icon"><img id="chat_icon" src="images/boy.png"></div>
		</div>
		<div id="chat">
		</div>
		<div id="cfooter">
			<img id="upl" src="images/upload.png" height="40px" onclick="kies_plaatje()"><input class="chat_input" value=""/><img id="emo" src="images/emoticon.png" height="40px" onclick="kies_emoji()">
		</div>
	 </div>	

	 <div id="container_plaatje">
		<div id="cheader">
			<div class="h_chats" onclick="terug(0)">< Terug</div>
			<div class="h_header">Kies Foto</div>
		</div>
		<div id="plaatje">
		</div>
	 </div>	

	 <div id="container_emoji">
		<div id="cheader">
			<div class="h_chats" onclick="terugemo(0)">< Terug</div>
			<div class="h_header">Kies Emoji</div>
		</div>
		<div id="emoji">
		</div>
	 </div>	

	</div>
	</div>
	<div id="phoneglareX"></div>
	<div id="dingX"></div>	
	</body>
</html>
