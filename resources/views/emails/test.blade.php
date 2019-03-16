<<<<<<< HEAD
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
尊敬的{{ $name }}：<br/>
　　<a target="_blank">{{ $msg_data }}</a>
</body>
=======
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
<div class="msg-box cui-msg-extend-message-alert msg-box-rb" id="message" style="width: 250px;height: 96px;display: none;">
	<div class="msgbox-titlebar">
	<span class="msgbox-title" title="温馨提醒">温馨提醒</span>
	</div>
	<div class="msgbox-content">
	<div class="box-icon cui-icon box-icon-alert">
	</div>
	<div class="box-msg" id="msg">
	</div>
	</div>
</div>
<button type="button" class="btn filter-change" id="remind_btn" onClick="autoRemind('ON')">开启提醒</button>
</body>
<script type="text/javascript">
		/** 自动提醒功能 开始**/
	//开启关闭自动提醒
	function autoRemind(switchFlag){
		debugger;
		if(switchFlag == 'ON'){
			jQuery.ajax({
	 			type: "POST",
	 		    url: "#URL()/fastrepairforother/addAutoRemindStatus?type=1",
	 		    async:false,
	 		    success: function(json){
	 		    	var result = json.result;
	 		    	if(result == "success"){
						var autoRemindInterval = ${autoRemindInterval};
						myVar = setInterval(queryNewFaultReport, 1000*60*autoRemindInterval);
						$("#remind_btn").attr("onClick","autoRemind('OFF')");
						$("#remind_btn").text("关闭提醒");
						cui.message("开启成功",'success');	 		    	
	 		    	}
	 		    }
	 		});
		}else if(switchFlag == 'OFF'){
			jQuery.ajax({
	 			type: "POST",
	 		    url: "#URL()/fastrepairforother/addAutoRemindStatus?type=2",
	 		    async:false,
	 		    success: function(json){
	 		    	var result = json.result;
	 		    	if(result == "success"){
						clearInterval(myVar);
						$("#remind_btn").attr("onClick","autoRemind('ON')");
						$("#remind_btn").text("开启提醒");
						closeSound();
						$("#message").hide();
						cui.message("关闭成功",'success');	 		    	
	 		    	}
	 		    }
	 		});
		}
	}
	//查询新增报障单数
var startTime = "${curDate}";
function queryNewFaultReport(){
	var count = 0;
	debugger;
	jQuery.ajax({
 		type: "POST",
 		url: "#URL()/fastrepairforother/queryNewReportCount?startTime="+startTime,
 		async:false,
 		success: function(json){
 		 count = json.count;
 		}
 	}); 
	var msg = "发现<span style='color:red'>"+count+"</span>条新报障单，<a href='javascript:window.location.href=window.location.href;'>查看</a>";
	msg+="或<a href='javascript:closeSound();'>关闭声音</a>";
	if(count>0){
		$("#msg").html(msg);
		var height = getClientHeight();
		var top = getScrollTop();
		$("#message").css({"position":"fixed","top":top+height,"right":"2px"});
		$("#message").show();
		playSound();
	}
}
	//播放音乐
	function playSound()
    {
      var borswer = window.navigator.userAgent.toLowerCase();
      if ( borswer.indexOf( "ie" ) >= 0 )
      {
        //IE内核浏览器
        var strEmbed = '<embed name="embedPlay" src="#URL()/include/fastrepair/ding.mp3" autostart="true" hidden="true" loop="true"></embed>';
        if ( $( "body" ).find( "embed" ).length <= 0 ){
          $( "body" ).append( strEmbed );
        }else{  
          var embed = document.embedPlay;
	      //浏览器不支持 audio，则使用 embed 播放
          embed.play();
        }  
      }else
      {
        //非IE内核浏览器
        var strAudio = "<audio id='audioPlay' src='#URL()/include/fastrepair/ding.mp3' loop='loop' hidden='true'>";
        if ( $( "body" ).find( "audio" ).length <= 0 )
          $( "body" ).append( strAudio );
        var audio = document.getElementById( "audioPlay" );
 
        //浏览器支持 audio
        audio.play();
      }
      var msgHtml = $("#msg").html();
      var index = msgHtml.indexOf("或");
      msgHtml = msgHtml.substring(0,index+1);
      msgHtml += "<a href='javascript:closeSound();'>关闭声音</a>";
      $("#msg").html(msgHtml);
    }
    
    //关闭音乐
    function closeSound()
    {
      var borswer = window.navigator.userAgent.toLowerCase();
      if ( borswer.indexOf( "ie" ) >= 0 )
      {
        //IE内核浏览器
        var embed = document.embedPlay;
 
        //浏览器不支持 audio，则使用 embed 播放
        embed.stop();
      } else
      {
        //非IE内核浏览器
        var audio = document.getElementById( "audioPlay" );
 
        //浏览器支持 audio
        audio.pause();
      } 
      var msgHtml = $("#msg").html();
      var index = msgHtml.indexOf("或");
      msgHtml = msgHtml.substring(0,index+1);
      msgHtml += "<a href='javascript:playSound();'>开启声音</a>";
      $("#msg").html(msgHtml);
    }
		//滚动事件
		window.parent.onscroll=function(){
	    	var box= document.getElementById("message");
			var height = getClientHeight();
			var top = getScrollTop();
		    box.style.top=height+top+"px";
		}
 
	//获取滚动高度
	function getScrollTop()
	{
	  var scrollTop=0;
	  if(window.parent.document.documentElement && window.parent.document.documentElement.scrollTop)
	  {
	  	scrollTop=window.parent.document.documentElement.scrollTop;
	  }
	  else if(window.parent.document.body)
	  {
	  	scrollTop=window.parent.document.body.scrollTop;
	  }
	  return scrollTop;
	}
	
	//获取页面可视化高度
	function getClientHeight()
	{
	  var clientHeight=0;
	  if(window.parent.document.body.clientHeight && window.parent.document.documentElement.clientHeight)
	  {
	  	var clientHeight = (window.parent.document.body.clientHeight<window.parent.document.documentElement.clientHeight)?window.parent.document.body.clientHeight:window.parent.document.documentElement.clientHeight;
	  }
	  else
	  {
	  	var clientHeight = (window.parent.document.body.clientHeight>window.parent.document.documentElement.clientHeight)?window.parent.document.body.clientHeight:window.parent.document.documentElement.clientHeight;
	  }
	  return clientHeight-245;
	}

</script>
>>>>>>> 30087df2a0aeb4380a27ed22b7c9556b87bb3fb6
</html>