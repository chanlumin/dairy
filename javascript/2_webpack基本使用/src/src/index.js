import printMe from './print'
class Rectangle {
  // constructor
  constructor(height, width) {
    this.height = height;
    this.width = width;
  }
  // Getter
  get area() {
    return this.calcArea()
  }
  // Method
  calcArea() {
    return this.height * this.width;
  }
}

const square = new Rectangle(10, 10);

console.log(square.area);

/**
 * 创建一个带有btn的 div
 * @returns {Element}
 */
function component() {
  let element = document.createElement('div'),
      btn = document.createElement('button');
  btn.innerHTML = "Click me"
  btn.onclick = printMe

  element.appendChild(btn)

  return element
}

// 添加 element 到body中去

document.body.appendChild(component())