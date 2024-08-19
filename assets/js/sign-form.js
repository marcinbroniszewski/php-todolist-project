const signInputs = document.querySelectorAll('.sign-input')

const deleteError = (e) => { 
    const errorParagraph = e.target.nextElementSibling

    if (errorParagraph && errorParagraph.classList.contains('error')) {
      errorParagraph.remove() 
    } 
 }

signInputs.forEach(input => input.addEventListener('input', deleteError))