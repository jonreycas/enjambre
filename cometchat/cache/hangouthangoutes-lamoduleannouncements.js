
function getTimeDisplay(ts){var ap="";var hour=ts.getHours();var minute=ts.getMinutes();var todaysDate=new Date();var todaysDay=todaysDate.getDate();var date=ts.getDate();var month=ts.getMonth();var armyTime=0;if(!armyTime){if(hour>11){ap="pm";}else{ap="am";}
if(hour>12){hour=hour-12;}
if(hour==0){hour=12;}}
if(minute<10){minute="0"+minute;}
var months=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];var type='th';if(date==1||date==21||date==31){type='st';}
else if(date==2||date==22){type='nd';}
else if(date==3||date==23){type='rd';}
if(date!=todaysDay){return hour+":"+minute+ap+' '+date+type+' '+months[month];}else{return hour+":"+minute+ap;}}
$(document).ready(function(){if(jQuery().slimScroll){$('.announcements').slimScroll({height:'310px',allowPageScroll:false});$(".announcements").css("height","310px");}
jqcc('.chattime').each(function(key,value){var ts=new Date(jqcc(this).attr('timestamp')*1000);var timest=getTimeDisplay(ts);jqcc(this).html(timest);});});