document.addEventListener("DOMContentLoaded", function(){

    fetch("../Api/check_status.php")
    .then(res => res.json())
    .then(data => {
        if(data.Status == "account_logged"){
            console.log(data.message);
            document.getElementById("log_link").innerHTML = "Account";
            document.getElementById("log_link").href = "user_dashboard.html";
        }else{
            console.log(data.message);
        }
    });
});
