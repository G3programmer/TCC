

const myObserver = new IntersectionObserver ((entries) => {
console.log(entries)
})

const elements = document.querySelector('.hidden')

elements.forEach((element) => myObserver.observe(element))
