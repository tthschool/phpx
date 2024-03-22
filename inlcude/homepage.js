

document.addEventListener("DOMContentLoaded" , function(){
    document.querySelectorAll("#delete").forEach(function(button){
        button.addEventListener("click" , function(){
            let x = this.parentElement.querySelector("#delete_user").value;
            let y = this.parentElement.querySelector("#session_id").value;
            console.log(x);
            if (x  !== y){
                if(confirm(`delete user ${x}!`)){
                    confirmDelete();
                }
                else
                {
                    event.preventDefault();
                }
            }
            else
            {
                alert("you cant delete your self");
                event.preventDefault();
            }
            
        })
    })
})
function confirmDelete(){
    document.querySelector("#deleteuser").submit();
}