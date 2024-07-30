// This is javascript fo the page that creates the accounts.

document.getElementById('signup').addEventListener('click', function (event) {
    event.preventDefault();
    creatAccount();
});

function creatAccount(){
    const fullName = document.getElementById('Full_Name').value;
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const email = document.getElementById('email').value;
    const ids = ['title','signup', 'creatAccountForm', 'login']
    elements = getElementsByIds(ids);
    elements.forEach(element => {
        if(element){
            element.classList.add('hide');
        }
        // welcome the user to the webpage
        const welcome = document.getElementById('welcome');
        welcome.innerHTML = `
        <h2>Hello ${fullName}</h2>
        <p>Your Username is: ${username}</p>
        <p>Your Password is: ${password}</p>
        <p>Your Email is: ${email}</p>`;
        welcome.classList.remove('hide');
    });


}

function getElementsByIds(ids){
    return ids.map(id => document.getElementById(id));
}