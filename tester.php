<html>
	<head>
		<title>Maaskei Chat (c)koelooptiemanna productions</title>
		<script src="jquery-2.1.4.min.js"></script>

		<script type="text/javascript">

			var repeat='';
			var tn='';
			var irri=0;
			var groep='';

			$(document).ready(function(){
				groepnummer();
				lees_emos();
				lees_namen();
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
					$file=fopen('logs/lieske.txt','a');
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
			
			function stop_Interval(){
				clearInterval(repeat);
			};

			function lees_emos(){
				$("#emoji").html('');
				for (i=1;i<218;i++) {
					$("#emoji").append('<div class="midden_emoji"><img src="emoji/emoji_'+pad(i,5)+'.png" onclick="terugemo('+i+')"/></div>');
				};
			};

			function lees_namen(){
				$.post("leerling_init.php",{
					'groep': groep
				}, function(data){
					var lines = data.split('\n');
					tg=lines[0][0];
					tn=lines[0].substr(1);
					lg=lines[1][0];
					ln=lines[1].substr(1);
					
					$("#tester_naam").val(tn);
					$("#tester_geslacht").val(tg);
					$("#leerling_naam").val(ln);
					$("#leerling_geslacht").val(lg);

				});
			};

			function doe_init(){
				tn=$("#tester_naam").val();
				tg=$("#tester_geslacht").val();
				ln=$("#leerling_naam").val();
				lg=$("#leerling_geslacht").val();
				
				if ((tn!='') && (tg!='') && (ln!='') && (lg!='')){
					$.post("init.php",{
						'groep': groep,
						'tester_naam': tn,
						'tester_geslacht': tg,
						'leerling_naam': ln,
						'leerling_geslacht': lg
					});	
				};
				$(".h_who").text(ln);
				if (lg == 'v') {$("#chat_icon").prop("src","images/girl.png");} else {$("#chat_icon").prop("src","images/boy.png");};

				$("#plaatje").html('');
				for (i=1;i<10;i++) {
					$("#plaatje").append('<div class="midden"><img src="images/t'+tg+i+'.jpg" width="200px" onclick="terug('+i+')"/></div>');
				};
			};


			function begin_chat(){
				doe_init();
				$("#container_init").animate({
					left: '-320'
				},500);
				$("#container_chat").animate({
					left: '0'
				},500);
				begin_Interval();
			};

			function end_chat(){
				stop_Interval();
				$("#container_init").animate({
					left: '0'
				},500);
				$("#container_chat").animate({
					left: '320'
				},500);
			};



			function zoek(){
				ide=$('#chat div').eq(-2).attr('id');	
			    $.post("read.php",{
				    'groep': groep,
				    'ide': ide,
				    'naam': tn
			    }, function(data){
				    if (data!='leeg') {
						$("#chat").append(data);
						if (data) {$("#chat").animate({scrollTop: $('#chat').prop("scrollHeight")+500}, 600);}
					};
				});
			};

			function pad (str, max) {
			  str = str.toString();
			  return str.length < max ? pad("0" + str, max) : str;
			}

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
					    'naam': tn,
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
			    var regel = '<div id="' + tijd_id + '" class="rechts">' + '<img src="images/t' + tg + nummer + '.jpg" width="200px"/>' + '<div class="time">' + tijd + '<img src="images/check.png" width="20px"/></div></div>';
			    $("#chat").append(regel);
			    $.post("commit.php",{
				    'groep': groep,
				    'datum': tijd_id,
				    'naam': tn,
				    'bericht': '/t' + tg + nummer,
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
				    'naam': tn,
				    'bericht': '@' + num,
				    'tijd': tijd
			    });
				$("#chat").animate({scrollTop: $('#chat').prop("scrollHeight")}, 600);
				
			};

			
			function wis(){
		    	$.post("maakleeg.php",{
			    	'groep': groep
		    	});
		    	$("#chat").html('');
		    };

			function kies_plaatje(){
				$("#container_chat").animate({
					left: '-320'
				},500);
				$("#container_plaatje").animate({
					left: '0'
				},500);
			};
			function terug(nummer){
				$("#container_chat").animate({
					left: '0'
				},500);
				$("#container_plaatje").animate({
					left: '320'
				},500);
				if (! nummer==0){plaatje(nummer);}
			};

			function kies_emoji(){
				$("#container_chat").animate({
					left: '-320'
				},500);
				$("#container_emoji").animate({
					left: '0'
				},500);
			};
			function terugemo(nummer){
				$("#container_chat").animate({
					left: '0'
				},500);
				$("#container_emoji").animate({
					left: '320'
				},500);
				if (! nummer==0){emoji(nummer);}
			};


			function bewaar(){
				tn=$("#tester_naam").val();
				tg=$("#tester_geslacht").val();
				ln=$("#leerling_naam").val();
				lg=$("#leerling_geslacht").val();

				$("#phone").fadeOut();
				$("#phoneglare").fadeOut();
				$("#ding").fadeOut();
				regel = "<h2>Chat gesprek tussen tester: " + tn + "(" + tg + ")<br> en leerling: " + ln + "(" + lg + ")</h2><br>";
				$("#output").html(regel);

			    $.post("bewaar.php",{
				    'groep': groep,
				    'naam': tn
			    }, function(data){
					$("#output").append(data);
 				});
			};

 		</script>
 		<link href='http://fonts.googleapis.com/css?family=Roboto:500' rel='stylesheet' type='text/css'>
 		<link href='style.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
 	<div id="phone">
	<div id="container_screen">
	 <div id="container_init">
		<div id="iheader">
			<div class="ih_who"><h3>Whazzap</h3>chat emulator speciaal onderwijs</div>
		</div>
		<div id="imain">
			<label>Tester:</label><input id='tester_naam' value='Tester'></input><select id='tester_geslacht'><option value='m'>Jongen</option><option value='v'>Meisje</option></select>
			<br>
			<label>Leerling:</label><input id='leerling_naam' value='Leerling'></input><select id='leerling_geslacht'><option value='m'>Jongen</option><option value='v' selected>Meisje</option></select>
			<br>
			<button onclick="wis()">Wis Chat</button>
			<br>
			<button onclick="bewaar()">Bekijk Chatlog (printen/opslaan)</button>
			<br>
			<button onclick="begin_chat()">Start Chat</button>
		</div>
		<div id="ifooter">
			&copy;2015 Roel Koster (koelooptiemanna@gmail.com)<br>emojis (Emoji One Artwork)<br>alle rechten voorbehouden
		</div>
	 </div>
	 <div id="container_chat">
		<div id="cheader">
			<div class="h_chats" onclick="end_chat()">< Menu</div>
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
	<div id="output"></div>
	</body>
</html>
