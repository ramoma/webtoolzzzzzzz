document.addEventListener("DOMContentLoaded", function(){

    const total_members = document.getElementById("total_members");
    const sessions_today = document.getElementById("sessions_today");
    const pending_payments = document.getElementById("pending_payments");

    fetch("../Api/user_dashboard_data.php")
    .then(res => res.json())
    .then(data => {

        total_members.innerHTML = data.user_count;
        sessions_today.innerHTML = data.sessions_count;
        pending_payments.innerHTML = data.payment_status;

    })

});
