document.getElementById("register_submit").addEventListener("click", function(e){

        e.preventDefault();
        let fullName =document.getElementById("firstname").value  +" "+ document.getElementById("lastname").value;
        let email = document.getElementById("email").value;
        let gender = document.getElementById("gender").value;
        let membership =  document.getElementById("membership").value;


        let data = {
            "fullname": fullName,
            "email": email,
            "gender": gender,
            "membership": membership
        };
        
        let json = JSON.stringify(data);

        fetch("../Api/register.php", {
            method: "POST",
            body: json
        }).then(res=>res.json())
        .catch("err");


    });