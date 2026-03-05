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

                if(data.Status === "error"){
                    console.log(data.Status);
                    window.alert(data.message);
                }
                else{
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

    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let email = document.getElementById("email").value;
    let skip_banking = document.getElementById("skip").value;

    let data = {
        username: username,
        password: password,
        email: email,
        status: skip_banking
    };

    var json = JSON.stringify(data);

    fetch("../Api/register.php", {
        method: "POST",
        headers: {
            "Content-Type" : "application/json"
        },
        body: json
    })
    .then(res=>res.json())
    .then(data=>
        {
            if(data.Status == "error"){
                console.log(data.message);
                window.alert(data.message);
            }
            else{
               window.alert("sent verification code");
                window.open("http://localhost/htmls/webapps_finals/finals%20wewbtools/pages/index.html", "_self"); 
            }      
    }).catch(err=> console.log("something went wrong", err));

});

document.getElementById("register_submit").addEventListener("click", function(e){

        
        e.preventDefault();
        let username = document.getElementById("username").value;
        let fullName =document.getElementById("firstname").value  +" "+ document.getElementById("lastname").value;
        let email = document.getElementById("email").value;
        let gender = document.getElementById("gender").value;
        let membership =  document.getElementById("membership").value;
        let password = document.getElementById("password").value;

        


        let data = {
            fullname: username
            // email: email,
            // gender: gender,
            // membership: membership
        };

        let json = JSON.stringify(data);

        fetch("../Api/register.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: json
        }).then(res=>res.json())
        .then(data => {

            if(data.Status === "error"){
                window.alert("sent verification code");
                window.open("http://localhost/htmls/webapps_finals/finals%20wewbtools/pages/index.html", "_self");
                console.log(data.message);
            }
            
        })
        .catch(err => console.error("something went wrong", err));

    });


