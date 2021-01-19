const urlParams = new URLSearchParams(window.location.search);

const loginParam = urlParams.get('login');
const registryParam = urlParams.get('registry');
const registryFParam = urlParams.get('account');
const menuParam = urlParams.get('files');
const camera = urlParams.get('camera');
const sensors = urlParams.get('sensors');
const preview = urlParams.get('preview');
const windows = urlParams.get('window');

if(loginParam == 'false'){
	document.getElementById("login_alert").style.display = "block"; 
}
if(loginParam == 'confirmation'){
	document.getElementById("confirm_alert").style.display = "block"; 
}
if(registryParam == 'true'){
	document.getElementById("registry_alert").style.display = "block"; 
}
if(registryFParam == 'false'){
	document.getElementById("registryF_alert").style.display = "block"; 
}
if(preview == 'true'){
	document.getElementById("preview").style.display = "block"; 
}
if(windows == 'true'){
	document.getElementById("preview_window").style.display = "block"; 
	document.getElementById("preview").style.display = "block"; 
}
if(menuParam == 'true'){
	document.getElementById("video").style.display = "block";
	$.ajax({
    url: '../include/video_inc.php',
    type: 'post',
    data: { "show": "1"},
    success: function(response) { 
	console.log(response); 
	$("#videos").append(response);
	}
});
document.getElementById("index").style.display = "none"; 
}
if(camera == 'true'){
	document.getElementById("camera").style.display = "block"; 
}
if(sensors == 'true'){
	document.getElementById("sensors").style.display = "block"; 
}

$.ajax({
	type:'POST',
    url:'../include/getdata_inc.php',
    dataType: "json",
    success:function(data){
		
		if(data.record_all_time==1){
			$("#recordinfo").attr("selected",true);
		}
		else{
			$("#recordinfo2").attr("selected",true);
		}
		$("#startrecord").attr("value",data.record_start); 
		$("#stoprecord").attr("value",data.record_stop); 
		if(data.resolutionV==1920){
			$("#resolution").attr("selected",true);
		}
		else if(data.resolutionV==1280){
			$("#resolution2").attr("selected",true);
		}
		$("#time").attr("value",data.record_time); 
		$("#fps").attr("value",data.FPS); 
		$("#setemail").attr("value",data.email); 
			
		if(data.magnet == 1){
			$("#magnetOFF").show();
			$("#magnetON").hide();
		}
		else if(data.magnet==0){
			$("#magnetON").show();
			$("#magnetOFF").hide();
		}
		
		if(data.app == 1){
			$("#powerOFF").show();
			$("#powerON").hide();
		}
		else if(data.app==0){
			$("#powerON").show();
			$("#powerOFF").hide();
		}

		if(data.sensors_all_time==1){
			$("#sensorsinfo").attr("selected",true);
		}
		else{
			$("#sensorsinfo2").attr("selected",true);
		}
		$("#startsensors").attr("value",data.sensors_start); 
		$("#stopsensors").attr("value",data.sensors_stop); 
			
		if(data.recording_status == 1){
			$("#recording_status").attr("checked",true);
			console.log("true");
		}
		else{
			$("#recording_status").attr("checked",false);
		}
			
		if(data.sensors_status == 1){
			$("#sensors_status").attr("checked",true);
			console.log("true");
		}
		else{
			$("#sensors_status").attr("checked",false);
		}
	}
});
function sendSensorData(){
	let mode = $('#sesnsors_mode option:selected').val();
	let start = $("#startsensors").val();
	let stop = $("#stopsensors").val();
	let email = $("#setemail").val();
	data = {
		's_mode' : mode,
		's_start' : start,
		's_stop' : stop,
		'email' : email
	}
	$.ajax({
		type:'POST',
		url:'../include/sensor_inc.php',
		data: {details:data},
		dataType: "json",
		success: function(response) {
			$("#send_info:hidden").show();
			setTimeout(function() {
				location.reload();
			}, 2000);
	   }
	});	
}
function sendRecordData(){
	let record_mode = $('#recordmode option:selected').val();
	let record_start = $("#startrecord").val();
	let record_stop = $("#stoprecord").val();
	let record_r_mode = $("#resolutionmode").val();
	let record_FPS = $("#fps").val();
	let record_time = $("#time").val();
	data = {
		'mode' :record_mode,
		'start' : record_start,
		'stop' : record_stop,
		'resolution' : record_r_mode,
		'FPS' : record_FPS,
		'time' : record_time
	}
	$.ajax({
		type:'POST',
		url:'../include/camera_inc.php',
		data: {details:data},
		dataType: "json",
		success: function(response) {
			$("#send_info:hidden").show();
			setTimeout(function() {
				location.reload();
			}, 2000);
	   }
	});	
}
function start_preview(){		
	$.ajax({
    url: '../include/manage_inc.php',
    type: 'post',
    data: { p_start: "1"},
    success: function(response) {
		$('.spinner-border').css('display', 'inline-block');
		setTimeout(function(){
			$('.spinner-border').css('display', 'none');
			window.location.href = "../index.php?window=true"; }, 5000);
		}
	});
}
function stop_preview(){		
	$.ajax({
    url: '../include/manage_inc.php',
    type: 'post',
    data: { p_stop: "1"},
    success: function(response) {
		window.location.href = "../index.php?preview=true";
		}
	});
}
function start(){		
	$.ajax({
    url: '../include/manage_inc.php',
    type: 'post',
    data: { start: "1"},
    success: function(response) {  window.location.href = "../index.php?camera=true"; }
});
}
function stop(){		
	$.ajax({
    url: '../include/manage_inc.php',
    type: 'post',
    data: { stop: "1"},
    success: function(response) {  window.location.href = "../index.php?camera=true"; }
});
}

function restartApp(){		
	$.ajax({
    url: '../include/manage_inc.php',
    type: 'post',
    data: { restart: "yes"},
    success: function(response) { window.location.href = "../index.php?restart=true"; }
});
}
function load(x){
	let file = $("#download"+x).text();
	window.location.href = "../include/download_inc.php?filename="+file;
}
function del(x){
	let file = $("#download"+x).text();
	window.location.href = "../include/delete_inc.php?filename="+file;
}
