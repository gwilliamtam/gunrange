<div class="card date-picker" id="date-picker">
    <div class="card-body">
        {{--year--}}
        <div class="row">
            <div class="value-picker year-col">
                {{ date("Y") }}
            </div>
            <div class="control-picker">
                <div class="slider">
                    <input type="range" min="{{ intval(date("Y")-50) }}" max="{{ date("Y") }}" value="{{ date("Y") }}" id="year-slider" oninput="yearChange()">
                </div>
            </div>
        </div>

        {{--month--}}
        <div class="row">
            <div class="value-picker month-col">
                {{ date("F") }}
            </div>
            <div class="control-picker">
                <div class="slider">
                    <input type="range" min="1" max="12" value="{{ intval(date("m")) }}" id="month-slider" oninput="monthChange()">
                </div>
            </div>
        </div>

        {{--day--}}
        <div class="row">
            <div class="value-picker day-col">
                {{ date("d") }}
            </div>
            <div class="control-picker">
                <div class="slider">
                    <input type="range" min="1" max="31" value="{{ intval(date("d")) }}" id="day-slider" oninput="dayChange()">
                </div>
            </div>
        </div>

        {{--hour--}}
        <div class="row">
            <div class="value-picker hours-col">
                {{ date("H") }} hr
            </div>
            <div class="control-picker">
                <div class="slider">
                    <input type="range" min="0" max="23" value="{{ intval(date("H")) }}" id="hours-slider" oninput="hoursChange()">
                </div>
            </div>
        </div>

        {{--minutes--}}
        <div class="row">
            <div class="value-picker minutes-col">
                {{ date("i") }} min
            </div>
            <div class="control-picker">
                <div class="slider">
                    <input type="range" min="0" max="59" value="{{ intval(date("i")) }}" id="minutes-slider" oninput="minutesChange()">
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    var year = {{ date("Y") }}
    var months = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
    var endOfMonth = Array(31,28,31,30,31,30,31,31,30,31,30,31)
    var weekday = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday")
    var month = parseInt({{ date("m") }})-1
    var day = {{ date("d") }}
    var hours = {{ date("H") }}
    var minutes = {{ date("i") }}

    setEndOfTheMonth()

    function setSliders(timeValueJson){
        var timeValue = JSON.parse(timeValueJson)
        console.log("x",timeValue.date_time)

        $("#year-slider").val(timeValue.date_time.substr(0,4))
        $("#month-slider").val(timeValue.date_time.substr(5,2))
        $("#day-slider").val(timeValue.date_time.substr(8,2))
        $("#hours-slider").val(timeValue.date_time.substr(11,2))
        $("#minutes-slider").val(timeValue.date_time.substr(14,2))

        yearChange()
        monthChange()
        dayChange()
        hoursChange()
        minutesChange()
    }

    function setEndOfTheMonth(){
        if( (year % 4) == 0){
            endOfMonth[1] = 29
        }else{
            endOfMonth[1] = 28
        }
        $("#day-slider").attr("max", endOfMonth[month])
        if(day>endOfMonth[month]){
            day = endOfMonth[month]
            $(".day-col").html(day)
        }
    }

    function displayDate()
    {
        var tag = "#{{ $dateField }}"
        var displayDay = day > 9 ? day : "0"+day
        var numericMonth = month+1
        var displayMonth = numericMonth > 9 ? numericMonth : "0"+numericMonth
        var displayHours = hours > 9 ? hours : "0"+hours
        var displayMinutes = minutes > 9 ? minutes : "0"+minutes

        var d = new Date(displayMonth + " " + displayDay + ", " + year + " " + displayHours + ":" + displayMinutes + ":00");

        var weekdayName = weekday[d.getDay()];

        var theDate = weekdayName + ", " + year + "-" + displayMonth + "-" + displayDay + " " + displayHours + ":" + displayMinutes
        $(tag).val( theDate )
        console.log(theDate)
    }

    function yearChange() {
        year = $("#year-slider").val()
        $(".year-col").html(year)
        setEndOfTheMonth()
        displayDate()
    }

    function monthChange() {
        month =  parseInt($("#month-slider").val()) - 1
        $(".month-col").html(months[month])
        setEndOfTheMonth()
        displayDate()
    }

    function dayChange() {
        day = $("#day-slider").val()
        $(".day-col").html(day)
        displayDate()
    }

    function hoursChange() {
        hours = $("#hours-slider").val()
        $(".hours-col").html(hours + " hr")
        displayDate()
    }

    function minutesChange() {
        minutes = $("#minutes-slider").val()
        $(".minutes-col").html(minutes + " min")
        displayDate()
    }

    displayDate()


</script>