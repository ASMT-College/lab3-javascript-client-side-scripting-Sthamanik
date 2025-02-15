/* In JavaScript, objects are collections of key-value pairs where keys are strings (or Symbols) and 
values can be any data type, including other objects, arrays, or functions. 

Types of Objects in JavaScript
User-Defined Objects (Created using object literals or constructors)
Built-in (Inbuilt) Objects (Predefined objects like Array, String, Math, Date, etc.) */

// built in obejcts
/* array objects

ways to define array objects
Using an Array Literal (Recommended)
let arr = [1, 2, 3, 4, 5];

Using the Array Constructor
let arr = new Array(1, 2, 3, 4, 5);

Using the Array.of() Method
let arr = Array.of(1, 2, 3, 4, 5);

Using the Array.from() Method (Creates an array from iterable objects)
let arr = Array.from("hello"); 

array methods and properties
length → Returns the number of elements in an array
push(value) → Adds an element at the end.
pop() → Removes the last element.
shift() → Removes the first element.
unshift(value) → Adds an element at the beginning.
indexOf(value) → Returns the index of a value.
includes(value) → Checks if an array contains a value.
join(separator) → Converts an array into a string.
reverse() → Reverses the array.
sort() → Sorts the array.
map(callback) → Transforms each element.
filter(callback) → Returns elements that match a condition.
reduce(callback, initialValue) → Reduces to a single value.
*/

/*String object

Ways to define string object
Using String Literals (Recommended)
let str = "Hello World";

Using the String Constructor
let str = new String("Hello World");

string methods and properties
length → Returns the length of a string.
charAt(index) → Returns character at index.
concat(str1, str2, ...) → Joins multiple strings.
indexOf(substring) → Returns the position of the first occurrence.
includes(substring) → Checks if a string contains a substring.
toUpperCase() → Converts to uppercase.
toLowerCase() → Converts to lowercase.
trim() → Removes whitespace from both ends.
replace(old, new) → Replaces a substring.
slice(start, end) → Extracts part of a string.
split(separator) → Splits a string into an array.
*/

/* Math object
DIfferent properties and methods

Math Properties
Math.PI → Returns π (3.141592653589793).
Math.E → Returns Euler's number (~2.718).

Math Methods
Math.abs(x) → Returns absolute value.
Math.ceil(x) → Rounds up.
Math.floor(x) → Rounds down.
Math.round(x) → Rounds to the nearest integer.
Math.sqrt(x) → Returns square root.
Math.pow(base, exponent) → Returns base^exponent.
Math.max(a, b, c, ...) → Returns the maximum value.
Math.min(a, b, c, ...) → Returns the minimum value.
Math.random() → Returns a random number (0 to 1).
Math.trunc(x) → Removes decimal part. 
*/