'use strict'
function AddFiles(){
    let input = document.createElement("input");
    input.setAttribute('type', 'file');
    input.setAttribute('name','files[]');
    let parent  = document.createElement("p");
    parent.appendChild(input);
    let GrandParent = document.getElementById('FileForm');
    GrandParent.appendChild(parent);
}