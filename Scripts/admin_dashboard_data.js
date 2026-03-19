document.addEventListener("DOMContentLoaded", function(){

    const total_members = document.getElementById("total_members");
    const sessions_today = document.getElementById("sessions_today");
    const pending_payments = document.getElementById("pending_payments");

    fetch("../Api/admin_dashboard_data.php")
    .then(res => res.json())
    .then(data => {
        if(data.Status == "success"){
            total_members.innerHTML = data.user_count;
            sessions_today.innerHTML = data.sessions_count;
            pending_payments.innerHTML = data.payment_status;
        }else if(data.Status == "not_logged"){
            document.location.href = data.redirect;
        }else{
            console.log("what");
        }


    })

});
