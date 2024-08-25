// variaveis globais
let nav = 0
let clicked = null
let events = localStorage.getItem('events') ? JSON.parse(localStorage.getItem('events')) : []


// variavel do modal:
const novoPedido = document.getElementById('novoPedido')
const deletePedido = document.getElementById('deletePedido')
const backDrop = document.getElementById('modalBackDrop')
const pedidoTitulo = document.getElementById('pedidoTitulo')
// --------
const calendario = document.getElementById('calendario') // div calendario:
const dias = ['domingo','segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'] //array com os dias:

//funções

function openModal(date){
  clicked = date
  const eventDay = events.find((event)=>event.date === clicked)
 

  if (eventDay){
   document.getElementById('pedidoTexto').innerText = eventDay.title
   deletePedido.style.display = 'block'


  } else{
    novoPedido.style.display = 'block'

  }

  backDrop.style.display = 'block'
}

//função load() será chamada quando a pagina carregar:

function load (){ 
  const date = new Date() 
  

  //mudar titulo do mês:
  if(nav !== 0){
    date.setMonth(new Date().getMonth() + nav) 
  }
  
  const dia = date.getDate()
  const mes = date.getMonth()
  const ano = date.getFullYear()

  
  
  const diaMes = new Date (ano, mes + 1 , 0).getDate()
  const primeiroDiaDoMes = new Date (ano, mes, 1)
  

  const dateString = primeiroDiaDoMes.toLocaleDateString('pt-br', {
    dias: 'long',
    ano:   'numeric',
    mes:   'numeric',
    dia:   'numeric',
  })
  

  const paddinDays = dias.indexOf(dateString.split(', ') [0])
  
  //mostrar mês e ano:
  document.getElementById('mesEAnoDisplay').innerText = `${date.toLocaleDateString('pt-br',{mes: 'long'})}, ${ano}`

  
  calendario.innerHTML =''

  // criando uma div com os dias:

  for (let i = 0;i <= paddinDays + diaMes; i++) {
    const dayS = document.createElement('div')
    dayS.classList.add('dia')

    const dayString = `${mes + 1}/${i - paddinDays}/${ano}`

    //condicional para criar os dias de um mês:
     
    if (i > paddinDays) {
      dayS.innerText = i - paddinDays
      

      const eventDay = events.find(event=>event.date === dayString)
      
      if(i - paddinDays == dia && nav == 0){
        dayS.id = 'currentDay'
      }


      if(eventDay){
        const eventDiv = document.createElement('div')
        eventDiv.classList.add('event')
        eventDiv.innerText = eventDay.title
        dayS.appendChild(eventDiv)

      }

      dayS.addEventListener('click', ()=> openModal(dayString))

    } else {
      dayS.classList.add('padding')
    }

    
    calendario.appendChild(dayS)
  }
}

function closeModal(){
  pedidoTitulo.classList.remove('error')
  novoPedido.style.display = 'none'
  backDrop.style.display = 'none'
  deletar.style.display = 'none'

  pedidoTitulo.value = ''
  clicked = null
  load()

}
function saveEvent(){
  if(pedidoTitulo.value){
    pedidoTitulo.classList.remove('error')

    events.push({
      date: clicked,
      title: pedidoTitulo.value
    })

    localStorage.setItem('events', JSON.stringify(events))
    closeModal()

  }else{
    pedidoTitulo.classList.add('error')
  }
}

function deleteEvent(){

  events = events.filter(event => event.date !== clicked)
  localStorage.setItem('events', JSON.stringify(events))
  closeModal()
}

// botões 

function buttons (){
  document.getElementById('btn-prev').addEventListener('click', ()=>{
    nav--
    load()
    
  })

  document.getElementById('btn-next').addEventListener('click',()=>{
    nav++
    load()
    
  })

  document.getElementById('salvar').addEventListener('click',()=> saveEvent())

  document.getElementById('cancelar').addEventListener('click',()=>closeModal())

  document.getElementById('deletePedido').addEventListener('click', ()=>deleteEvent())

  document.getElementById('close').addEventListener('click', ()=>closeModal())
  
}
buttons()
load()

