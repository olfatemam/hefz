/*--------------------
Setup
--------------------*/
const canvas = document.getElementById('canvas')
const ctx = canvas.getContext('2d')
const win = {
  w: window.innerWidth,
  h: window.innerHeight,
}
const img = new Image()


/*--------------------
Cover Image
--------------------*/
const coverImg = (img, type = 'cover') => {
  const imgRatio = img.height / img.width
  const winRatio = window.innerHeight / window.innerWidth
  if ((imgRatio < winRatio && type === 'contain') || (imgRatio > winRatio && type === 'cover')) {
    const h = window.innerWidth * imgRatio
    ctx.drawImage(img, 0, (window.innerHeight - h) / 2, window.innerWidth, h)
  }
  if ((imgRatio > winRatio && type === 'contain') || (imgRatio < winRatio && type === 'cover')) {
    const w = window.innerWidth * winRatio / imgRatio
    ctx.drawImage(img, (win.w - w) / 2, 0, w, window.innerHeight)
  }
}


/*--------------------
Render
--------------------*/
const render = () => {
  ctx.clearRect(0, 0, win.w, win.h)
  //const type = document.querySelector('input[name="type"]:checked').value
  coverImg(img, 'contain')
  requestAnimationFrame(render)
}


/*--------------------
Init
--------------------*/
const init = () => {
  resize()
  render()
}


/*--------------------
Preload Image
--------------------*/
const imgSrc = 'https://raw.githubusercontent.com/supahfunk/supah-codepen/master/autumn.jpg'
img.onload = init
img.src = imgSrc


/*--------------------
Resize
--------------------*/
const resize = () => {
  win.w = window.innerWidth
  win.h = window.innerHeight
  canvas.width = win.w
  canvas.height = win.h
  canvas.style.width = `${win.w}px`
  canvas.style.height = `${win.h}px`
}
window.addEventListener('resize', init)
