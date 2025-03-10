import './bootstrap.js';
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




// EditorJS

import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import Checklist from '@editorjs/checklist';
import EditorjsList from '@editorjs/list';
import Embed from '@editorjs/embed';
import Quote from '@editorjs/quote';
import Table from '@editorjs/table';

const $editorjs = document.getElementById('editorjs');
if($editorjs) {
  const inputTarget = $editorjs.dataset.inputTarget;
  const $inputTarget = document.getElementById(inputTarget);

  const editor = new EditorJS({
    holder: 'editorjs',
    placeholder: 'Let`s write an awesome story!',
    tools: {
      header: Header,
      checklist: Checklist,
      list: EditorjsList,
      embed: Embed,
      quote: Quote,
      table: Table,
    },
    data: $inputTarget ? JSON.parse($inputTarget.value) : null,
    onChange: () => {
      saveData();
    }
  });

  const saveData = () => {
    if(!$inputTarget) {
      return;
    }
    editor.save().then((outputData) => {
      $inputTarget.value = JSON.stringify(outputData);
    }).catch((error) => {
      console.log('Saving failed: ', error)
    });
  }
}






