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

// Once Human / Ajouter un ingrédient à une recipe

document
  .querySelectorAll('.add_recipe_ingredient')
  .forEach(btn => {
    btn.addEventListener("click", addFormToCollection)
  });

function addFormToCollection(e) {
  const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

  const item = document.createElement('li');

  item.innerHTML = collectionHolder
    .dataset
    .prototype
    .replace(
      /__name__/g,
      collectionHolder.dataset.index
    );

  addIngredientFormDeleteLink(item);

  collectionHolder.appendChild(item);

  collectionHolder.dataset.index++;
};

document
  .querySelectorAll('ul.ingredients li')
  .forEach((ingredient) => {
    addIngredientFormDeleteLink(ingredient)
  });


function addIngredientFormDeleteLink(item) {
  const removeFormButton = document.createElement('button');
  removeFormButton.innerText = 'Delete';
  removeFormButton.classList.add('btn');
  removeFormButton.classList.add('btn-danger');

  item.append(removeFormButton);

  removeFormButton.addEventListener('click', (e) => {
    e.preventDefault();
    // remove the li for the tag form
    item.remove();
  });
}
