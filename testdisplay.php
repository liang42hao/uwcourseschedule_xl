 <?php session_start(); 
 	$type=$_SESSION['type'];?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel='stylesheet' href='./fullcalendar/fullcalendar.css' />
	<script src='./fullcalendar/lib/jquery.min.js'></script>
	<script src='./fullcalendar/lib/moment.min.js'></script>
	<script src='./fullcalendar/fullcalendar.js'></script>
	<script type="text/javascript">
		var logintype='<?php echo $type;?>';
		var eventarray=new Array;
		var savearray=new Array;
        var startdate='2016-02-29';
        var enddate='2016-03-04';
				var tempname;
				var temptimea;
				var tempdatea;
				var templocationa;
				var tempid;
				var tempcoursename;
        $(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        // put your options and callbacks here
        header: {
        	left: 'prev,next today myCustomButton',
        	center: 'title',
        	right: 'month,agendaWeek,agendaDay'

        },
				minTime: "08:00:00",
        maxTime: "22:00:00",
        eventSources:[eventarray],
        eventOverlap:false,
    });
    $('#calendar').fullCalendar( 'changeView', 'agendaWeek');


});
function StringToDate(DateStr)
{

    var converted = Date.parse(DateStr);
    var myDate = new Date(converted);
    if (isNaN(myDate))
    {
        //var delimCahar = DateStr.indexOf('/')!=-1?'/':'-';
        var arys= DateStr.split('-');
        myDate = new Date(arys[0],--arys[1],arys[2]);
    }
    return myDate;
}






function comptime(beginTime,endTime) {

  //  var beginTime = "2009-09-21 00:00:00";
  //  var endTime = "2009-09-21 00:00:01";
    var beginTimes = beginTime.substring(0, 10).split('-');
    var endTimes = endTime.substring(0, 10).split('-');

   beginTime = beginTimes[1] + '-' + beginTimes[2] + '-' + beginTimes[0] + ' ' + beginTime.substring(10, 19);
    endTime = endTimes[1] + '-' + endTimes[2] + '-' + endTimes[0] + ' ' + endTime.substring(10, 19);
		beginTime =beginTime.replace("-", "/").replace("-", "/");
		endTime =endTime.replace("-", "/").replace("-", "/");
    //alert(beginTime + "aaa" + endTime);
    //alert(Date.parse(endTime));
    //alert(Date.parse(beginTime));

	//	beginTime=StringToDate(beginTime);
		//endTime=StringToDate(endTime);
	//console.log("i is ");
	//console.log(i);
	//	console.log("start is ");
	//	console.log(start);
//		console.log("new");
	//	console.log(beginTime);
		//console.log(endTime);
    var a = (Date.parse(endTime) - Date.parse(beginTime)) / 3600 / 1000;
		//console.log("a is ");
		//console.log(a);
    if (a < 0) {
			//console.log("-1");
        return -1;//endTime小!
    } else if (a > 0) {
			//console.log("1");
        return 1; //endTime da!
    } else if (a == 0) {

			//console.log("0");
      return 0;
    } else {
			console.log("error");
        return 'exception'
    }
}
        function updateevent()
        {
        	console.log(eventarray);
        	$('#calendar').fullCalendar('removeEvents');
        	$('#calendar').fullCalendar('addEventSource', eventarray);
        	var bool=isOverlapping(eventarray);
        	console.log("over lapping is ");
        	console.log(bool);
					if(bool==true){
						//deleteevent(tempname,temptimea,tempdatea,templocationa,"2016-05-01","2016-08-31")
						//hidecontent(tempid);
						alert("course time conflict!");
						courseselect(tempid,tempdatea,temptimea,templocationa,tempcoursename);
					}
        	$('#calendar').fullCalendar('rerenderEvents');
        }
        function isOverlapping(event){
    // "calendar" on line below should ref the element on which fc has been called
    var array = $('#calendar').fullCalendar('clientEvents');
	for(i in array){
		for(a in event){
			var starttime1=array[i].start._i;
			var endtime1=array[i].end._i;
			var starttime2=event[a].start;
			var endtime2=event[a].end;
			starttime1=starttime1.substring(0,10)+" "+starttime1.substring(11,16)+":00";
			starttime2=starttime2.substring(0,10)+" "+starttime2.substring(11,16)+":00";
			endtime1=endtime1.substring(0,10)+" "+endtime1.substring(11,16)+":00";
			endtime2=endtime2.substring(0,10)+" "+endtime2.substring(11,16)+":00";
			var temp1=array[i]['title'];
			var temp2=event[a]['title'];
			var temptitle1=temp1.substring(0,16);
			var temptitle2=temp2.substring(0,16);
		//	console.log(temptitle1);
			//console.log(temptitle2);
        if(temptitle1!=temptitle2){
					//console.log(Date(array[i].start._i));
					//console.log(Date(event[a].end));
            if(!(comptime(starttime1,endtime2)==-1 || comptime(endtime1,starttime2)==1)){
								console.log("find here");
							//	console.log(Date(starttime1));
								console.log(starttime2);
								console.log(endtime1);
								//console.log(Date(endtime2));
                return true;
            }
					}
        }
    }
    return false;
}

function update(name,time,date,location,type)
{
	if($type==1)
	{
		addevent(name,time,date,location,start,end);
	}
	else
	{
		deleteevent(name,start,end);
	}
}
function daysBetween(DateOne,DateTwo)
{
	var OneMonth = DateOne.substring(5,DateOne.lastIndexOf ('-'));
	var OneDay = DateOne.substring(DateOne.length,DateOne.lastIndexOf ('-')+1);
	var OneYear = DateOne.substring(0,DateOne.indexOf ('-'));

	var TwoMonth = DateTwo.substring(5,DateTwo.lastIndexOf ('-'));
	var TwoDay = DateTwo.substring(DateTwo.length,DateTwo.lastIndexOf ('-')+1);
	var TwoYear = DateTwo.substring(0,DateTwo.indexOf ('-'));

	var cha=((Date.parse(OneMonth+'/'+OneDay+'/'+OneYear)- Date.parse(TwoMonth+'/'+TwoDay+'/'+TwoYear))/86400000);
	return Math.abs(cha);
}
function transfer(str)
{
	switch (str){
		case "M":
		return 1;
		case "T":
		return 2;
		case "W":
		return 3;
		case "F":
		return 5;
	}

}

function getdate(date)
{
	var datearray=new Array();
	if(date.search(/Th/)!=-1)
	{
		var location=date.search(/Th/);
		for(var i=0;i<date.length;i++)
		{
			if(i!=location){
				datearray.push(transfer(date[i]));
			}
			else
			{
				datearray.push(4);
				i++;
			}

		}

	}
	else
	{
		for(var i=0;i<date.length;i++)
		{

				datearray.push(transfer(date[i]));


		}
	}
	console.log("the date array is ");
	console.log(datearray);
	return datearray;

}

function in_array(stringToSearch, arrayToSearch) {
	for (s = 0; s < arrayToSearch.length; s++) {
		thisEntry = arrayToSearch[s].toString();
		if (thisEntry == stringToSearch) {
			return true;
		}
	}
	return false;
}


function addevent(name,time,date,location,start,end)
{

	var newevent=new Array();
	var datearray=getdate(date);
	var gap=daysBetween(end,start);
		tempname=name;
	 temptimea=time;
	 tempdatea=date;

	//console.log("temp location is ");
	//console.log(templocationa);
	var uom;
	for(var i=1;i<gap;i++)
	{
		Date.prototype.format = function(format)
		{
			var o =
			{
        "M+" : this.getMonth()+1, //month
        "d+" : this.getDate(),    //day
        "h+" : this.getHours(),   //hour
        "m+" : this.getMinutes(), //minute
        "s+" : this.getSeconds(), //second
        "q+" : Math.floor((this.getMonth()+3)/3),  //quarter
        "S" : this.getMilliseconds() //millisecond
    }
    if(/(y+)/.test(format))
    	format=format.replace(RegExp.$1,(this.getFullYear()+"").substr(4 - RegExp.$1.length));
    for(var k in o)
    	if(new RegExp("("+ k +")").test(format))
    		format = format.replace(RegExp.$1,RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
    	return format;
    }
    //console.log("i is ");
    //console.log(i);
    //	console.log("start is ");
    //	console.log(start);
     uom = new Date(new Date(start)-0+i*86400000);
		//console.log(uom.getDay());
		//console.log(uom);

		if(in_array(uom.getDay(),datearray))
		{
			//console.log("the date is in array and will add in array");
			uomtemp1=uom;
			uomtemp=uomtemp1.format("yyyy-MM-dd");
			var starttime=uomtemp+"T"+time.substring(0,5);
			var endtime=uomtemp+"T"+time.substring(6,11);
			var namestring=name.toString();
			var stringlength=namestring.length;
			var neweventa={
			title  : namestring.substring(1,stringlength-1)+"----"+location,
			start  : starttime.toString(),
			end    : endtime.toString()
		}
		console.log(neweventa.title);
			//console.log(uom);
			//console.log(time);
			eventarray.push(neweventa);
		}
		//console.log(uom);
	}
	updateevent();

}



function deleteevent(name,time,date,location,start,end)
{
	//console.log("delete event called");
	var namestring=name.toString();
	var stringlength=namestring.length;
	for(var i=0;i<eventarray.length;i++)
	{
		console.log(eventarray[i]);
		if(eventarray[i]['title']==namestring.substring(1,stringlength-1)+"----"+location)
		{
			console.log("item found");
					eventarray.splice(i,1);
		i--;
		}

	}
	updateevent();
}

//for select use
function showconetnt(id)
{
	document.getElementById(id).style.display="inline";
	console.log("id is ");
	console.log(id);
	console.log("function called");
}
function hidecontent(id)
{
	console.log(document.getElementById(id).style.color);
	if(document.getElementById(id).style.color=="black"||document.getElementById(id).style.color==""){
		document.getElementById(id).style.display="none";}
		console.log("hide called");

	}

	function courseselect(id,date,time,location,coursename)
	{

		console.log(id);
		console.log(" course get clicked");
		tempid=id;
		tempcoursename=coursename;
		templocationa=location;
		console.log("date is ");
		var datestring=date.toString();
		var stringlength=datestring.length;
		var datea=datestring.substr(1,stringlength-2);
		console.log(datestring.substr(1,stringlength-2));


		console.log("time is ");
		var timestring=time.toString();
		var stringlength=timestring.length;
		console.log(timestring.substring(1,stringlength-1));
		var timea=timestring.substring(1,stringlength-1);

		console.log("location is ");
		var locationstring=location.toString();
		var stringlength=locationstring.length;
		console.log(locationstring.substring(1,stringlength-1));
		var locationa=locationstring.substring(1,stringlength-1);


		if(document.getElementById(id).style.color=="black"||document.getElementById(id).style.color=="")
		{
			document.getElementById(id).style.color="blue";
			addevent(coursename,timea,datea,locationa,"2016-05-01","2016-08-31");
		}
		else {
			document.getElementById(id).style.color="black";
			deleteevent(coursename,timea,datea,locationa,"2016-05-01","2016-08-31");
		}
	}


	function contains(arr, obj) {  
    var i = arr.length;  
    while (i--) {  
        if (arr[i] === obj) {  
            return true;  
        }  
    }  
    return false;  
}  
	function save()
	{
		var events=eventarray;
		for(var i=0;i<events.length;i++)
		{
			if(!contains(events[i].title,savearray))
			{
				savearray.push(events[i].title);
			}
		}
		console.log("save function called ");
		console.log(savearray);
	}
</script>
<style>
	.clearFloat { clear: both; }

	#calendar
	{
		float:left;
		position:relative;
	}
	.course{
		position:relative;
		left: 5px;
		margin:20px;
		width:250px;
		float:left;



	}

	.lec
	{
		float:left;
		position:relative;

	}
	.tut
	{
		float:left;
		position:relative;

	}
	.tst
	{
		float:left;
		position:relative;

	}

	.lec:hover {
		background:rgba(0,0,100,0.5);
		transition: 0.2s;
	}
	.tut:hover {
		background:rgba(0,0,100,0.5);
		transition: 0.2s;
	}
	.tst:hover {
		background:rgba(0,0,100,0.5);
		transition: 0.2s;
	}
	.coursename{
		float:left;
		position:relative;

		width:400px;
		font-size: 15pt;
		font-weight:bold;


	}
	.coursenumber{
		float:left;
		position:relative;

		width: 125px;


	}
	.time{
		float:left;
		position:relative;

		width: 125px;


	}
	.location
	{
		margin-left: 125px;
		float:left;
		position:relative;

		width: 125px;
	}
	.else
	{
		margin-left: 125px;
		float:left;
		position:relative;

		width: 125px;
	}
	.hidden{
		display:none;
	}
	.search{
		float:left;
		position:relative;
	}
	.space{
		float:left;
		position:relative;
		margin-top:10px;
	}


</style>
</head>
<body>
	<?php
	$displaynumber=0;
	$username=$_SESSION['username'];
	$password=$_SESSION['password'];
	$coursearray=$_SESSION['courses'];

	if($type==2)
	{
		$userdata=$_SESSION['userdata'];
	}
//print_r($coursearray);
	displaymain($coursearray,$type);
	function displaymain($coursearray,$type)
	{
//	echo "display main called ";
		global $displaynumber;
		foreach ($coursearray as $key => $value) {
		# code...
			?>
			<div class="course">
				<?php
				displaycourse($value);
			//$displaynumber++;
				?>
			</div>

			<?php
		}
		if($type!=3)
		{
			?>
			<button type="button" onclick="save()">Store your courses!</button>
			<?php
		}
	}
	function displaycourse($array)
	{
		global $displaynumber;
		?>
		<div class="space">
		</div>
		<div class="coursename">
			<?php
			$name= $array[0]['coursepre'].$array[0]['coursenumber'];
			echo $name;
			?>
		</div>
		<?php
		for($i=0;$i<sizeof($array);$i++){
			$displaynumber++;
			$tempcoursetype=$array[$i]['coursetype'];
			switch ($tempcoursetype) {
				case 'LEC':

				$value=$array[$i];
				$time=substr($value['coursetime'],0,5)."-".substr($value['coursetime'],-5);
				$date=$value['coursedate'];
				$location=$value['courselocationbuilding']."-".$value['courselocationbuildingroomnumber'];
				$coursename=$array[0]['coursepre'].$array[0]['coursenumber']."--".$tempcoursetype.sprintf("%03d", $value['courselecnum']);
				?>
				<div class="lec" onmouseover="showconetnt(<?php echo $displaynumber;?>)" onmouseout="hidecontent(<?php echo $displaynumber;?>)" onclick="courseselect(<?php echo $displaynumber;?>,<?php echo "/".$date."/";?>,<?php echo "/".$time."/";?>,<?php echo "/".$location."/";?>,<?php echo "/".$coursename."/";?>)">
					<div class="coursenumber">
						<?php
						echo $tempcoursetype;
						echo "  ";
						echo sprintf("%03d", $value['courselecnum']);?>
					</div>
					<div class="time">
						<?php

						echo $time;
						echo "   ";

						echo $value['coursedate'];
						?>
					</div>
					<div id=<?php echo $displaynumber;?> class="hidden">
						<div class="location" >
							<?php
							echo "Campus: ";
							echo $value['courselocation'];
							echo "<br>";
							echo "Building name: ";
							echo $value['courselocationbuilding'];
							echo "<br>";
							echo "Room number: ";
							echo $value['courselocationbuildingroomnumber'];
							echo "<br>";?>
						</div>
						<div class="else" >
							<?php
							$temp=$value['courseinstructors'];
							echo "Instructor :  $temp";
							echo "<br>";
							$temp1=$value['enrollment_capacity'];
							$temp2=$value['enrollment_total'];
							$remain=$temp1-$temp2;
							$num=(int)$remain;
							//echo "num is $num";
							if($num<=20)
							{
								echo '<span style="color:red">';
								//remaining seats : $remain';
							}

								echo "remaining seats : $remain";
								echo "<br>";
							$temp=$value['waiting_total'];
							echo "waiting list : $temp";?>
						</div>
					</div>
					<div class="clearFloat"></div>
				</div>

				<?php
				break;
				case 'TUT':

				$value=$array[$i];
				$time=substr($value['coursetime'],0,5)."-".substr($value['coursetime'],-5);
				$date=$value['coursedate'];
				$location=$value['courselocationbuilding']."-".$value['courselocationbuildingroomnumber'];
				$coursename=$array[0]['coursepre'].$array[0]['coursenumber']."--".$tempcoursetype.sprintf("%03d", $value['courselecnum']);
				?>
				<div class="tut" onmouseover="showconetnt(<?php echo $displaynumber;?>)" onmouseout="hidecontent(<?php echo $displaynumber;?>)" onclick="courseselect(<?php echo $displaynumber;?>,<?php echo "/".$date."/";?>,<?php echo "/".$time."/";?>,<?php echo "/".$location."/";?>,<?php echo "/".$coursename."/";?>)">
					<div class="coursenumber">
						<?php
						echo $tempcoursetype;
						echo "  ";
						echo sprintf("%03d", $value['courselecnum']);?>
					</div>
					<div class="time">
						<?php

						echo $time;
						echo "   ";

						echo $value['coursedate'];
						?>
					</div>
					<div id=<?php echo $displaynumber;?> class="hidden">
						<div class="location" >
							<?php
							echo "Campus: ";
							echo $value['courselocation'];
							echo "<br>";
							echo "Building name: ";
							echo $value['courselocationbuilding'];
							echo "<br>";
							echo "Room number: ";
							echo $value['courselocationbuildingroomnumber'];
							echo "<br>";?>
						</div>
						<div class="else" >
							<?php
							$temp=$value['courseinstructors'];
							echo "Instructor :  $temp";
							echo "<br>";
							$temp1=$value['enrollment_capacity'];
							$temp2=$value['enrollment_total'];
							$remain=$temp1-$temp2;
							$num=(int)$remain;
							//echo "num is $num";
							if($num<=20)
							{
								echo '<span style="color:red">';
								//remaining seats : $remain';
							}

								echo "remaining seats : $remain";
								echo "<br>";
							$temp=$value['waiting_total'];
							echo "waiting list : $temp";?>
						</div>
					</div>
					<div class="clearFloat"></div>
				</div>
				<?php
				break;
				case 'TST':

				$value=$array[$i];
				$time=substr($value['coursetime'],0,5)."-".substr($value['coursetime'],-5);
				$date=$value['coursedate'];
				?>
				<div class="tst" onmouseover="showconetnt(<?php echo $displaynumber;?>)" onmouseout="hidecontent(<?php echo $displaynumber;?>)" >
					<div class="coursenumber">
						<?php
						echo $tempcoursetype;
						echo "  ";
						echo sprintf("%03d", $value['courselecnum']);?>
					</div>
					<div class="time">
						<?php

						echo $time;
						echo "   ";

						echo $value['coursedate'];
						?>
					</div>
					<div id=<?php echo $displaynumber;?> class="hidden">
						<div class="location" >
							<?php
							echo "Campus: ";
							echo $value['courselocation'];
							echo "<br>";
							echo "Building name: ";
							echo $value['courselocationbuilding'];
							echo "<br>";
							echo "Room number: ";
							echo $value['courselocationbuildingroomnumber'];
							echo "<br>";?>
						</div>
						<div class="else" >
							<?php
							$temp=$value['courseinstructors'];
							echo "Instructor :  $temp";
							echo "<br>";
							$temp1=$value['enrollment_capacity'];
							$temp2=$value['enrollment_total'];
							$remain=$temp1-$temp2;
							$num=(int)$remain;
							//echo "num is $num";
							if($num<=10)
							{
								echo '<span style="color:red">';
								//remaining seats : $remain';
							}

								echo "remaining seats : $remain";
								echo "<br>";
							$temp=$value['waiting_total'];
							echo "waiting list : $temp";?>
						</div>
					</div>
					<div class="clearFloat"></div>
				</div>
				<?php
				break;


			}
		}




	}
	?>

	<div class="search">
		    Type in the Professor Name to know his rating!
		<script>
  (function() {
    var cx = '012128436757510335578:2zcgi-uoay4';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search>
</div>
	<div id='calendar'></div>



</body>
</html>
