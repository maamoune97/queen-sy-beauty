console.clear()

const navExpand = [].slice.call(document.querySelectorAll('.nav-expand'))
const backLink = `<li class="nav-item">
	<a class="nav-link nav-back-link" href="javascript:;">
        <i class="fa fa-arrow-back"></i> Retour
	</a>
</li>`

navExpand.forEach(item => {
    item.querySelector('.nav-expand-content').insertAdjacentHTML('afterbegin', backLink)
    item.querySelector('.nav-link').addEventListener('click', () => item.classList.add('active'))
    item.querySelector('.nav-back-link').addEventListener('click', () => item.classList.remove('active'))
})


const ham = document.getElementById('ham')
var root = document.getElementsByTagName( 'html' )
 ham.addEventListener('click', function() {
    document.body.classList.toggle('nav-is-toggled')
})

/*$("#ham").click(function(){
    $("html, body").toggleClass("nav-is-toggled");
  }); */