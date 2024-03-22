    document.addEventListener("DOMContentLoaded" , function(){
        let loginbtn = document.querySelector("#loginbtn");
        if(loginbtn){
            loginbtn.addEventListener("click" , function(e){
                e.preventDefault();
                let username = document.querySelector("#username").value;
                let password = document.querySelector("#password").value;
                let display = document.querySelector("#login-err");
                if(username < 1  || password < 1){
                    display.innerHTML = "invalid username or password!!"
                }
                else{
                    let params = "login=true&username="+username+"&password="+password;
                    let xhropen = {
                        method:"POST",
                        url:"authenticator.php",
                        boolean:true
                    }
                sendAjaxrequest(params , xhropen)
                .then((xhr)=>{
                    if(xhr.status == 200){
                        let response = JSON.parse(xhr.response);
                        console.log(response);
                        if(response.oke){
                            location.href = response.redirect;
                        }
                        else{
                            display.innerHTML = "invalid username or password";
                        }
                    }
                    else{
                        display.innerHTML = "something wrong ,try again!!!"
                    }
                })
                }
            })
        }
    let signupbtn = document.querySelector(".form-sign");
    if(signupbtn){
        signupbtn.addEventListener("submit",function(e){
            e.preventDefault();
            let display = this.querySelector("#signup-erro") ; 
            let name = this.querySelector("#name").value;
            let username = this.querySelector("#username").value;
            let password = this.querySelector("#pass").value;
            let repassword = this.querySelector("#confirm-pass").value;
            if(password!= repassword ||  name.length < 1 || username.length<1 || password.length < 1 || repassword.length<1){
                display.innerHTML = "try again !!";
            }
            else{
                let xhropen = {
                    method : "POST",
                    url:"authenticator.php",
                    boolean:true
                };
                let params = "signup=true&name="+name+"&username="+username+"&password="+password;
                sendAjaxrequest(params , xhropen)
                .then((xhr)=>{
                    let response = JSON.parse(xhr.response);
                    if(response.oke){
                        location.href = response.redirect;
                    }
                    else{
                        display.innerHTML = response.message;
                    }
                })
            }
        })
    }
    let user_info = document.querySelectorAll(".user-container");
    if(user_info){
        user_info.forEach(element => {
            let owner_id  = element.querySelector("#session_id").value;
            let user_id = element.querySelector("#userid").innerHTML;
            let dltbtn = element.querySelector(".delete_user_btn");
            dltbtn.addEventListener("click" , function(){
                if(owner_id === user_id){
                    alert("cant delete yourself!!!");
                }
                else{
                    let params  = "deleteuser=true&id="+user_id;
                    let xhropen = {
                        method:"POST",
                        url:"control.php",
                        boolean:true
                    }
                    sendAjaxrequest(params , xhropen)
                    .then((result)=>{
                        let response = JSON.parse(result.response)
                        if(response.oke){
                            location.href = response.redirect;
                        }
                    })
                }
            })
         
        });
    }
})
    function sendAjaxrequest(params , xhropen){
        return new Promise((resolve , reject)=>{
            let xhr = new XMLHttpRequest();
            xhr.open(xhropen["method"] , xhropen["url"] , xhropen["boolean"]);
            if(xhropen["method"] === "POST"){
                xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');
            }
            xhr.onload = function(){
                resolve(xhr);
            }
            if(params){
                xhr.send(params);
            }
            else{
                xhr.send();
            }
        })
}