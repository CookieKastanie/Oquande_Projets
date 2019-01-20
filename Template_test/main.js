const menu = document.querySelector('#menu');
const content = document.querySelector('#content');

const loadPage = (p) => {
  fetch("./"+ p +".php").then(rep => {
    return rep.text();
  }).then(text => {
    content.innerHTML = text;
  });
}

let i = 0;
for(let e of menu.getElementsByTagName("li")){
  const index = ++i;
  e.onclick = () => {
    loadPage("page"+ index);
  }
}
