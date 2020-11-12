const person = {
 name: 'john',
 age: 4,
 education: false,
 greeting() {
  console.log("hello " + this.name);
 },
};

person.greeting();