// document.addEventListener("DOMContentLoaded", function(e){
//
//
//     fetch("../Api/login.php")
//     .then(res => res.json())
//     .then(data => {
//         // console.log(data + "balls");
//         if(data.Status == "account_logged"){
//             window.alert(data.message);
//             window.open("http://localhost/htmls/webtoolzzzzzzz/pages/user_dashboard.html", "_self");
//         }
//         else{
//             console.log(data.message);
//         }
//     })
//
// });

document.getElementById("login").addEventListener("click", function(e){

    e.preventDefault();

    username = document.getElementById("username").value;
    password = document.getElementById("password").value;
    check_pass = document.getElementById("con_pass").value;
    login = document.getElementById("login").value;

    if(password == check_pass){

        data = {
            username: username,
            password: password,
            login: login
        };

        json = JSON.stringify(data);

        fetch("../Api/login.php", {
            method: "POST",
            headers: {
                "Content-Type" : "application/json"
            },
            body: json
        })
        .then(res => res.json())
        .then(data => {
            if(data.Status == "success"){
                window.alert(data.message);
                window.open("http://localhost/htmls/webtoolzzzzzzz/pages/user_dashboard.html", "_self");
            }else if(data.Status == "failed"){
                window.alert(data.message);
            }else{
                console.log(data.message);
            }
        })
    }
    else{
        window.alert("Passwords don't match");
    }
});
