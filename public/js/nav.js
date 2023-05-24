const uri = window.location.href

switch(true) {
  case (uri.includes('ativacao')):
    document.querySelector('li[name="activation"]').classList.add('active')
    break;
  case (uri.includes('empresa')):
    document.querySelector('li[name="company"]').classList.add('active')
    break;
  case (uri.includes('favoritos')):
    document.querySelector('li[name="favorites"]').classList.add('active')
    break;
  case (uri.includes('ferias')):
    document.querySelector('li[name="vacation"]').classList.add('active')
    break;
  case (uri.includes('lojas')):
    document.querySelector('li[name="stores"]').classList.add('active')
    break;
  case (uri.includes('modulos')):
    document.querySelector('li[name="modules"]').classList.add('active')
    break;
  case (uri.includes('ponto')):
    document.querySelector('li[name="punched-clock"]').classList.add('active')
    break;
  case (uri.includes('sair')):
    document.querySelector('li[name="logout"]').classList.add('active')
    break;
  default:
	document.querySelector('li[name="panel"]').classList.add('active')
    break;
}
