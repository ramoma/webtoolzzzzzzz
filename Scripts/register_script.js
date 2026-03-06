document.getElementById("c_submit").addEventListener("click", function(e){

    e.preventDefault();

    
    let password = document.getElementById("password").value;
    let c_password = document.getElementById("c_password").value;
    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value; 
    let c_submit = document.getElementById("c_submit").value;
    
    if(password != "" && c_password != ""){
       if(password == c_password){
            
            let data = {
                username: username,
                c_submit: c_submit,
                email: email

            };

            let json = JSON.stringify(data);

            fetch("../Api/register.php", {
                method: "POST",
                headers: {
                    "Content-Type" : "application/json"
                },
                body: json
            })
            .then(res => res.json())
            .then(data =>{

                if(data.Status === "user error"){
                    console.log(data.Status);
                    window.alert(data.message);
                    document.getElementById("user_error").classList.remove("hidden");
                }
                else if(data.Status === "email error"){
                    console.log(data.Status);
                    window.alert(data.message);
                }
                else if(data.Status === "account error"){
                    console.log(data.Status);
                    window.alert(data.message);
                }
                else{
                    console.log(data.Status);
                    document.querySelector(".card1").classList.add("hidden");
                    document.querySelector(".card2").classList.remove("hidden");
                }
            }).catch(err=>console.error("something went wrong", err));
        
        }
        else{
            window.alert("passwords dont match");
        } 
    }else{
        window.alert("missing input fields");
    }
});

document.getElementById("skip").addEventListener("click", function(e){
    e.preventDefault();

    let fullname = document.getElementById("firstname").value + " " + document.getElementById("lastname").value;
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let email = document.getElementById("email").value;
    let skip_banking = document.getElementById("skip").value;
    let gender = document.querySelector('input[name="gender"]:checked').value;

    let data = {
        fullname: fullname,
        username: username,
        password: password,
        email: email,
        status: skip_banking,
        gender: gender
    };

    var json = JSON.stringify(data);
    console.log(json);

    fetch("../Api/register.php", {
        method: "POST",
        headers: {
            "Content-Type" : "application/json"
        },
        body: json
    })
    .then(res=>res.json())
    .then(data=>{
            if(data.Status == "error"){
                console.log(data.message);
                window.alert(data.message);
            }
            else{
               window.alert("sent verification code");
                window.open("http://localhost/htmls/webtoolzzzzzzz/pages/index.html", "_self"); 
            }      
    }).catch(err=> console.log("something went wrong", err));

});

document.getElementById("register_submit").addEventListener("click", function(e){

        
        e.preventDefault();
        let username = document.getElementById("username").value;
        let fullName =document.getElementById("firstname").value  +" "+ document.getElementById("lastname").value;
        let email = document.getElementById("email").value;
        let gender = document.querySelector("input[name = 'gender']:checked").value;
        let membership =  document.querySelector("input[name = 'membership']:checked").value;
        let password = document.getElementById("password").value;
        let register = document.getElementById("register_submit").value;
        
        let data = {
            fullname: fullName,
            email: email,
            gender: gender,
            membership: membership,
            password: password,
            username: username,
            register: register
        };

        let json = JSON.stringify(data);
        console.log(json);

        fetch("../Api/register.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: json
        }).then(res=>res.json())
        .then(data => {

            if(data.Status === "success"){
                window.alert("sent verification code");
                window.open("http://localhost/htmls/webtoolzzzzzzz/pages/index.html", "_self");
                console.log(data.message);
            }
            
        })
        .catch(err => console.error("something went wrong", err));

    });


