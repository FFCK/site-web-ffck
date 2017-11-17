"use strict";

/**
 * Code-Port: "Hello {0}".format("World"); returns "Hello World"
 */
if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) { 
      return typeof args[number] != 'undefined'
        ? args[number]
        : match
      ;
    });
  };
} 

/**
 * Code-Port: Check if a string starts with a other string
 */
if (typeof String.prototype.startsWith != 'function') {
  String.prototype.startsWith = function (str){
    return this.indexOf(str) === 0;
  };
}

/**
 * Value not undefined
 */
function RMLisDefined(attr) {
    if (typeof attr !== typeof undefined && attr !== false && attr !== null) {
        return true;
    }
    return false;
}