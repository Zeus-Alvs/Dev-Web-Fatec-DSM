function mousedentro(){

  const produtos = document.getElementById("mousecima");
  produtos.style.display = "grid";
}

function mousefora(){
  const produtos = document.getElementById("mousecima");
  produtos.style.display = "none";
}

let escuro = true;

function tema(){
    const estilo = document.getElementById("estilo");
    const imagens = document.querySelectorAll('img.image')
    
    if(escuro == true){
        estilo.href = 'styleclaro.css';

        imagens.forEach(img => {
            let currentSrc = img.src; 
            
            img.src = currentSrc.replace('/claro/', '/escuro/');
        });

        escuro = false;
    }
    else{
        estilo.href = 'styleescuro.css';

        imagens.forEach(img => {
            let currentSrc = img.src;

            img.src = currentSrc.replace('/escuro/', '/claro/');
        });

        escuro = true;
    }
}