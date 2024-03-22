//waiting until page done loaded
    
document.addEventListener('DOMContentLoaded',function(){
   
    if(document.querySelector("#loginbtn")){
        document.querySelector("#loginbtn").addEventListener('click' , function(){   

            let username = document.querySelector("#username").value;
            let password = document.querySelector("#password").value;
            if(username.length <1 &&password.length <1 ){
                window.alert(" enter username and password ");
                event.preventDefault();

            }
            
        })
    }
    if(document.querySelector("#submitbtn")){
        document.querySelector("#submitbtn").addEventListener('click'  , function(){
            let password = document.querySelector("#pass").value;
            let confirmpassword = document.querySelector("#confirm-pass").value;
            if(password !== confirmpassword){
                window.alert("password and confirm password not match");
                event.preventDefault();

                
            }
        })
    }

  
})
