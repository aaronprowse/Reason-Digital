// src/app.js
// alert('hello world')
const hamburger = document.querySelector('.ham')
const menu = document.querySelector('.menu')
hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('change')
    menu.classList.toggle('nav-change')
})