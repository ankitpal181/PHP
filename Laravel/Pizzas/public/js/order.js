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

__webpack_require__(/*! /home/daffola-793/Training/PHP/Laravel/Pizzas/Modules/Order/Resources/assets/js/app.js */"./Resources/assets/js/app.js");
module.exports = __webpack_require__(/*! /home/daffola-793/Training/PHP/Laravel/Pizzas/Modules/Order/Resources/assets/sass/app.scss */"./Resources/assets/sass/app.scss");


/***/ })

/******/ });

function recalculate_order(change_amount) {
  let order_amount = parseInt($("#edit-order-amount").text()) + change_amount;
  let discount_rate = $("#edit-discount-rate").text().match(/(\d+)/)[0] / 100;
  let tax_rate = $("#edit-tax-rate").text().match(/(\d+)/)[0] / 100;
  let discount = order_amount * discount_rate;
  let tax = order_amount * tax_rate;
  let total_amount = order_amount - discount + tax;

  $("#edit-order-amount").text(order_amount);
  $("#edit-discount").text(discount.toFixed(1));
  $("#edit-tax").text(tax.toFixed(1));
  $("#edit-total-amount").text(total_amount.toFixed(1));
}

$(document).ready(function() {
  $("[id^=drop-menu-icon]").click(function() {
    $(this).parent().children("#item-list").children(".item-details").slideToggle('fast');

    if ($(this).children(".drop-menu-icon").hasClass("fa-angle-down")) {
      $(this).children(".drop-menu-icon").removeClass("fa-angle-down");
      $(this).children(".drop-menu-icon").addClass("fa-angle-up");
    } else {
      $(this).children(".drop-menu-icon").removeClass("fa-angle-up");
      $(this).children(".drop-menu-icon").addClass("fa-angle-down");
    }
  });

  $(".delete-item-button").click(function() {
    let change_amount = -1 * parseInt($(this).parent().parent().children("#edit-item-order-amount").text());

    $(this).parent().children("#delete-item-checkbox").prop("checked", true);
    $(this).parent().parent().css("display", "none");
    recalculate_order(change_amount);
  });

  $(".edit-item-quantity").change(function() {
    let price = parseInt($(this).parent().parent().children("#edit-item-price").text());
    let quantity = parseInt($(this).val());
    let old_amount = $(this).parent().parent().children("#edit-item-order-amount").text();
    let new_amount = price * quantity;
    let change_amount = new_amount - old_amount;

    $(this).parent().parent().children("#edit-item-order-amount").text(new_amount);
    recalculate_order(change_amount);
  });
});
