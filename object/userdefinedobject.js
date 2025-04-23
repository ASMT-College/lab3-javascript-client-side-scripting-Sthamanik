// user defined object
/*A user-defined object in JavaScript is an object that a developer creates using either an object literal, 
a constructor function, or an ES6 class. These objects can store properties and methods that define their behavior. */

//ways to create a user-defined object

// Using Object Literals (Simplest & Most Common)
let person = {
    name: "John",
    age: 30,
    greet: function () {
      return `Hello, my name is ${this.name}.`;
    }
  };
  
  console.log(person.name); // John
  console.log(person.greet()); // Hello, my name is John.

// Using constructor function
function Person(name, age) {
    this.name = name;
    this.age = age;
    this.greet = function () {
      return `Hi, I am ${this.name}, and I am ${this.age} years old.`;
    };
  }
  
  // Creating instances of Person
  let person1 = new Person("Alice", 25);
  let person2 = new Person("Bob", 28);
  
  console.log(person1.greet()); // Hi, I am Alice, and I am 25 years old.
  console.log(person2.greet()); // Hi, I am Bob, and I am 28 years old.

// Using ES6 class
class Person1 {
    constructor(name, age) {
      this.name = name;
      this.age = age;
    }
  
    greet() {
      return `Hello, my name is ${this.name}.`;
    }
  }
  
  // Creating instances
  let person11 = new Person1("Charlie", 22);
  console.log(person11.greet()); // Hello, my name is Charlie.

// using object.create method
let personPrototype = {
    greet: function () {
      return `Hi, my name is ${this.name}.`;
    }
  };
  
  // Creating an object with personPrototype
  let person111 = Object.create(personPrototype);
  person1.name = "David";
  
  console.log(person111.greet()); // Hi, my name is David.
  
  