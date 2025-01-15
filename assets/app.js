import 'bootstrap-icons/font/bootstrap-icons.scss';
import './styles/app.scss';
import * as bootstrap from 'bootstrap';
// import * as Popper from "@popperjs/core";

// Menu

const $ancestors = document.querySelectorAll('#main-menu li[data-has-children] > span');
$ancestors.forEach((ancestor)=> {
  ancestor.addEventListener('click', (e) => {
    ancestor.parentElement.classList.toggle('current_ancestor')
  });
})
