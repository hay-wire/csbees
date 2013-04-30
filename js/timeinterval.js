// Simple pretty dates implementation by Prashant Dwivedi<prashant@neurals.in>

function easydate(dateTimeStr) {
	dateTimeStr = dateTimeStr.replace("-", "/");
	dateTimeStr = dateTimeStr.replace("-", "/");
	
	var givenDate = new Date(dateTimeStr);
	var sysDate = new Date();
	
	var secDiff = parseInt( sysDate.getSeconds()) - parseInt( givenDate.getSeconds() );
	var minDiff = parseInt( sysDate.getMinutes()) - parseInt( givenDate.getMinutes() );
	var dateDiff = parseInt( sysDate.getDate()) - parseInt( givenDate.getDate() );
	var hourDiff = parseInt( sysDate.getHours()) - parseInt( givenDate.getHours() );
	var monthDiff = parseInt( sysDate.getMonth()) - parseInt( givenDate.getMonth() );
	var yearDiff = parseInt( sysDate.getFullYear()) - parseInt( givenDate.getFullYear() );
	
	//console.log("secDiff: "+ secDiff);
	//console.log("minDiff: "+ minDiff);
	//console.log("dateDiff: "+ dateDiff);
	//console.log("hourDiff: "+ hourDiff);
	//console.log("monthDiff: "+ monthDiff);
	

	var sec = parseInt( givenDate.getSeconds());
	var mint = parseInt( givenDate.getMinutes());

	var date = parseInt( givenDate.getDate());
	var hour = parseInt( givenDate.getHours());
	var month = parseInt( givenDate.getMonth());
	var year = parseInt( givenDate.getFullYear());
	var monthWord;
//	console.log('Month:=')

	if(month==0)
		monthWord = 'Jan';
	else if(month==1)
		monthWord = 'Feb';
	else if(month==2)
		monthWord = 'Mar';
	else if(month==3)
		monthWord = 'Apr';
	else if(month==4)
		monthWord = 'May';
	else if(month==5)
		monthWord = 'June';
	else if(month==6)
		monthWord = 'July';
	else if(month==7)
		monthWord = 'Aug';
	else if(month==8)
		monthWord = 'Sept';
	else if(month==9)
		monthWord = 'Oct';
	else if(month==10)
		monthWord = 'Nov';
	else if(month==11)
		monthWord = 'Dec';
	
	if(hour>=12)
	{	var hour12 = (hour - 12);
		var hourSuffix = "pm";
	}
	else
	{	var hour12 = hour;
		var hourSuffix = "am";
	}
	
	if(mint<10)
		mint = '0'+mint;
	
	
	if(dateDiff>=2 || monthDiff>0 || yearDiff>0) {
		easyDateStr = monthWord + " " + date + ", " + year + " at " + hour12 + ":" + mint + hourSuffix;
		//easyDateStr = givenDate.parse('mmm d, yyyy');
		//easyDateStr = givenDate.toString('d mmm, yyyy');
	}
	else
	{	if(dateDiff==1) {
			easyDateStr = "Yesterday at "+ hour12 + ":" + mint + hourSuffix;
		}
		else
		{	if(hourDiff>3) {
				easyDateStr = "Today at "+ hour12 + ":" + mint + hourSuffix;
			}
			else
			{	if(minDiff<0)
				{	minDiff = 60 + minDiff;
					hourDiff--;
				}
				
				if(hourDiff>0)
				{	easyDateStr = hourDiff + " Hour " + minDiff + " Minutes ago";
				}
				else	// gap is in minutes or seconds!
				{	if(minDiff>0)
						easyDateStr = minDiff + " Minutes ago";
					else
					{
						//easyDateStr = givenDate.toString();
						easyDateStr = " just now";
					}
				}
				
			
			}
		
		}
	}
	


	//console.log(givenDate.toDateString());
	//console.log("system: "+sysDate);
	//console.log("easyDateStr: "+easyDateStr);
	return easyDateStr;	
}

//
