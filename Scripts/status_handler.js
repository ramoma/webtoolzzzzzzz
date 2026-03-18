document.addEventListener("DOMContentLoaded", function(){

    fetch("../Api/login.php")
    .then(res => res.json())
    .then(data => {
        if(data.Status == "account_logged"){
            console.log(data.message);
            document.getElementById("log_link").innerHTML = "Account";
            document.getElementById("log_link").href = data.redirect;
        }else{
            console.log(data.message);
        }
    });
});
