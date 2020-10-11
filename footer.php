<div style="position: fixed; right: 0; bottom: 0; margin-right: 50px; margin-bottom:50px;">  
    <h1 id="time"></h1>
    <h5 id="date" class="text-info"></h5>
</div>

<script>
    var myVar = setInterval(myTimer, 50);
    function myTimer() {
        var dt = new Date();
        document.getElementById("time").innerHTML = dt.toLocaleTimeString();
        document.getElementById("date").innerHTML = dt.toDateString();
    }
</script>
