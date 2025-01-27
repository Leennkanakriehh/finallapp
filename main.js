
buttons.forEach(function (button) {
    button.onclick = function () {
        if (!isLoggedIn) {
            displayBox();
        } else {
            addToCart();
        }
    };
});

var buttons = document.querySelectorAll('.buy-button');
var box = document.querySelector('.login-signup-box');
var overlay; //intially there is no overlay

buttons.forEach(function (button) {
    button.onclick = displayBox;
});

function displayBox() {
    overlay = document.createElement('div');
    overlay.className = 'overlay'; //assign a class name
    document.body.appendChild(overlay); // Append to the body

    box.style.display = 'inline-block';

    console.log('Box displayed!');

    // close box and overlay if clicked 
    overlay.onclick = function () {
        box.style.display = 'none'; // hide box
        overlay.remove(); // remove the overlay
        console.log('Box hidden!');
    };
}


var loginButton = document.getElementById('login-btn');
var SignUpButton = document.getElementById('signup-btn');

loginButton.onclick = function () {
    window.location.href = 'login.php';
};

SignUpButton.onclick = function () {
    window.location.href = 'register.php';
};

