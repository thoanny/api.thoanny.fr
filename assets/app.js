import './styles/app.scss';

// Menu

const $ancestors = document.querySelectorAll('#sidebar ul li span');
$ancestors.forEach((ancestor)=> {
  ancestor.addEventListener('click', (e) => {
    ancestor.parentElement.classList.toggle('current_ancestor')
  });
})
