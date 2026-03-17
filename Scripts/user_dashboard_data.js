document.addEventListener("DOMContentLoaded", function(){

    const total_members = document.getElementById("total_members");

    fetch("../Api/user_dashboard_data.php")
    .then(res => res.json())
    .then(data => {

        total_members.innerHTML = data.user_count;

    })

});
