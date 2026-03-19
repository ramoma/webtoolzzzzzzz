document.addEventListener("DOMContentLoaded", function(){

    const sess_done = document.getElementById("sessions_done");

    fetch("../Api/user_dashboard_data.php")
    .then(res => res.json())
    .then(data => {

        if(data.Status === "success"){
            sess_done.innerHTML = data.sess_count;
        }else{
            document.location.href = data.redirect;
        }

    });

})
