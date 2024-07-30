// This is the javascript for the Login Page
document.getElementById('login').addEventListener('click', function (event) {
    event.preventDefault();
    login();
})

function login() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    hideContent();
    const enter = document.getElementById('enter');
    enter.innerHTML = `
    <h1>Hello ${username}!</h1>
    <p> This is probably not your password: ${password}</p>
    <p> The database has not been built yet.</p>`;
    enter.classList.remove('hide');
    const header = document.getElementById('header');

    header.classList.add('add_margin');
}

function hideContent(){
    const content = document.getElementById('content');

    content.classList.add('hide');
}

