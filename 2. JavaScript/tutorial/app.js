// CallBack, Higher Order functions, Functions as First Class OBjects

function morning(name) {
 return `Good morning ${name.toUpperCase()}`;
}

function afternoon(name) {
 return `Good afternoon ${name.repeat(3)}`; 
}

function greet(name, cb) {
 const myName = 'John';
 console.log(`${cb(name)}, my name is ${myName}`);
}

greet('bobo', morning);
greet('peter', afternoon)