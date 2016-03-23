$(document).ready(function(){
    $("#usrDate").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
    $("#nbrDays").mask("9?99",{placeholder:""})
    $("#ctryCode").mask("aa",{placeholder:" "})
});
$("#usrInput-form").validate({    
    // Validation rules
    rules: {
        usrDate: { 
            required: true,         
            date: true            
        }, 
        nbrDays: "required",        
        ctryCode: "required"
    },
    
    // Specify the validation error messages
    messages: {
        usrDate: "Please enter a valid date",
        nbrDays: "Please enter from 1 to 999 days",        
        ctryCode: {
            required: "Please enter a country code",
            minlength: "The country code must be two characters"
        }
    },
    
    submitHandler: function(form) {
        form.submit();
    }
});

$( "#usrInput-form" ).submit(function( event ) {
    event.preventDefault();
    console.log('start date');
    var i = $("#usrDate").val().split("/");
    var i2 = i[2]+"-"+i[0]+"-"+i[1]
    var j = new Date($("#usrDate").val()); //day of the week for monday-based
    //j = new Date("2016-03-01");
    var adj = (j.getDay()+1)>6?0:j.getDay()+1; //adjusted to sunday based week
    var month_name = function(dt){  
        mlist = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];  
        return mlist[dt.getMonth()];  
    };

    var endDate = new Date($("#usrDate").val());
    endDate = addDays( endDate, $("#nbrDays").val() );
    months = nbrMonths(j,endDate);

    console.log("daysInMonth:"+daysInMonth(i[0],i[2]));
    console.log('months: ', months);
    console.log('endDate: ', endDate);

    $("#hdata").val(months);  

    alert(); 
});

//Month is 1 based
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}

function nbrMonths(start,end) {
    console.log("start:",start);
    console.log("end:",end);

    monthCount = (end.getFullYear() - start.getFullYear())*12 + 
        (end.getMonth() - start.getMonth());
    return monthCount;
}

function addDays(date,days) {
    date.setDate(date.getDate() + parseInt(days));
    return date;
}