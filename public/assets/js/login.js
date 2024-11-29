const form =  document.getElementById('form');
const email = document.getElementById('email');
const password = document.getElementById('password');
const alert_backend =  document.getElementById('alert_backend');
const alert_backend_close = document.getElementById('alert_backend_close');



form.addEventListener('submit', (e) =>{
    alert_backend.classList.add('show');
    validateEmail(email);
})  



alert_backend_close.addEventListener('click',  () => {
    alert_backend.classList.add('hidden');
});

function validateEmail(email){
    email_Value = email.value;
    console.log(email_Value);
}