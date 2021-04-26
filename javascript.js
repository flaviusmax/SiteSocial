// Example 26-14: javascript.js

canvas               = O('logo')
context              = canvas.getContext('2d')
context.font         = 'bold italic 100px Georgia'
context.font.shadow  = '5'
context.textBaseline = 'top'
image                = new Image()
image.src            = 'logo.png'

image.onload = function()
{
  gradient = context.createLinearGradient(0, 0, 0, 89)
  gradient.addColorStop(0.00, '#00FF66')
  gradient.addColorStop(0.66, '#FF0099')
  context.fillStyle = gradient
  context.fillText( " F      la  Ro", 0, 0)
  context.strokeText( " F      la  Ro", 0, 0)
  context.drawImage(image, 110, 15) //pozitia pozei
}

function O(i) { return typeof i == 'object' ? i : document.getElementById(i) }
function S(i) { return O(i).style                                            }
function C(i) { return document.getElementsByClassName(i)                    }
