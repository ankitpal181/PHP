/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Resources/assets/js/app.js":
/*!************************************!*\
  !*** ./Resources/assets/js/app.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./Resources/assets/sass/app.scss":
/*!****************************************!*\
  !*** ./Resources/assets/sass/app.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!***************************************************************************!*\
  !*** multi ./Resources/assets/js/app.js ./Resources/assets/sass/app.scss ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/daffola-793/Training/PHP/Laravel/Pizzas/Modules/Dashboard/Resources/assets/js/app.js */"./Resources/assets/js/app.js");
module.exports = __webpack_require__(/*! /home/daffola-793/Training/PHP/Laravel/Pizzas/Modules/Dashboard/Resources/assets/sass/app.scss */"./Resources/assets/sass/app.scss");


/***/ })

/******/ });

// JS for common resources

$(document).ready(function() {
  let current_tab = $(location).attr('pathname');
  let end_pos = current_tab.indexOf('/', 1);
  if (end_pos > 0) {
    current_tab = current_tab.substring(1, end_pos);
  } else {
    current_tab = current_tab.substring(1);
  }

  $("#"+current_tab).css({"background-color": "inherit", "color": "#fff", "border-bottom": "none"});
});

// JS for inter-connected resources

function changeQuantity(operation, item, item_price) {
  let item_quantity = parseInt($("#" + item).children("div").children("#item-quantity").val());
  let total = parseInt($("#total-amount").text());

  if (operation == "minus") {
    $("#" + item).children("div").children("#item-quantity").val(item_quantity - 1);
    $("#total-amount").text(total - item_price);
  } else {
    $("#" + item).children("div").children("#item-quantity").val(item_quantity + 1);
    $("#total-amount").text(total + item_price);
  }
}

$(document).ready(function() {
  $("[id^=delete-fields-]").click(function() {
    let delete_checked = $(this).children("#delete-checkbox").prop("checked");
    let item_price = parseInt($(this).children("p").children("#item-price").text());
    let item = $(this).children("p").text().replace(item_price, "");
    let total = parseInt($("#total-amount").text());
    if (!delete_checked) {
      $("#item-quantity-list").append("<li id='" + item.replace(/\s/g,'') + "' class='item-details'><p class='item-name temp-cart-item-name'>" + item + "</p><div class='item-quantity-wrapper'><button type='button' class='btn btn-primary quantity-minus-button' onclick='changeQuantity(\"minus\", \"" + item.replace(/\s/g,'') + "\", " + item_price + ")'>-</button><input type='text' class='item-quantity' id='item-quantity' name='" + item.replace(/\s/g,'') + "' form='order-form' value= '1' readonly='readonly'><button type='button' class='btn btn-primary quantity-plus-button' onclick='changeQuantity(\"plus\", \"" + item.replace(/\s/g,'') + "\", " + item_price + ")'>+</button></div></li>");
      $("#total-amount").text(total + item_price);
    } else {
      $("#" + item.replace(/\s/g,'')).remove();
      $("#total-amount").text(total - item_price);
    }
  });
});
