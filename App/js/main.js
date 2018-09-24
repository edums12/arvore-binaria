var _modalTriggers = document.querySelectorAll('.modal-trigger')

for(i = 0; i < _modalTriggers.length; i++)
{
    _modalTriggers[i].addEventListener('click', openModal)
}

document.querySelector('.screen-modal').addEventListener('click', (e) => {
    e.preventDefault()

    var _this = e.target

    _this.className = _this.className.replace(' active', '')

    var _modalOpen = document.querySelector('.modal.active')

    _modalOpen.className = _modalOpen.className.replace(' active', '')
});

function openModal(e){
    e.preventDefault()

    var _modal = document.getElementById(e.target.getAttribute('data-modal'))
    
    _modal.className += ' active'

    document.querySelector('.screen-modal').className += ' active'

    if(_modal.getAttribute('focused') != undefined)
    {
        document.querySelector(_modal.getAttribute('focused')).focus()
        
        document.querySelector(_modal.getAttribute('focused')).value = ""
    }
}

window.addEventListener('keypress', (e) => {
    
    if (e.keyCode == 65) { // SHIFT + N
        document.getElementById('btn-add').click()
    }

    if (e.keyCode == 76) { // SHIFT + L
        document.getElementById('btn-limpar').click()
    }

    if (e.keyCode == 82) { // SHIFT + R
        document.getElementById('btn-reordenar').click()
    }

    if (e.keyCode == 70) { // SHIFT + F
        document.getElementById('btn-existe').click()
    }

    // alert(e.keyCode);

})

window.onload = () => {
    var toast = document.getElementById("toast")

    if(toast != undefined)
    {
        if(toast.className != null)
        {
            toast.className += " show"
        }
        else
        {
            toast.className = "show"
        }
    }

    setTimeout(
        () => { 
            toast.className = toast.className.replace("show", "")
        },
    5000)
}