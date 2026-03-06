document.addEventListener("DOMContentLoaded", function(e){

    e.preventDefault();

    fetch("../Api/login.php")
    .then(res => res.json())
    .then(data => {
        if(data.Status == "account_logged"){
            window.alert(data.message);
        }
        else{
            console.log(data.message);
        }
    })

});