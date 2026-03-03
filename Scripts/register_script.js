document.getElementById("register_submit").addEventListener("click", function(e){

        e.preventDefault();
        let fullName =document.getElementById("firstname").value  +" "+ document.getElementById("lastname").value;
        let email = document.getElementById("email").value;
        let gender = document.getElementById("gender").value;
        let membership =  document.getElementById("membership").value;
        let password = document.getElementById("password").value;


        let data = {
            fullname: fullName
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
            console.log(data.message);
        })
        .catch(err => console.error("something went wrong", err));


    });