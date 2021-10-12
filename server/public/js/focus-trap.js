/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./resources/js/focus-trap.js ***!
  \************************************/
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/**
 * Limit focus to focusable elements inside `element`
 * @param {HTMLElement} element - DOM element to focus trap inside
 * @return {Function} cleanup function
 */
function focusTrap(element) {
  var focusableElements = getFocusableElements(element);
  var firstFocusableEl = focusableElements[0];
  var lastFocusableEl = focusableElements[focusableElements.length - 1]; // Wait for the case the element was not yet rendered

  setTimeout(function () {
    return firstFocusableEl.focus();
  }, 50);
  /**
   * Get all focusable elements inside `element`
   * @param {HTMLElement} element - DOM element to focus trap inside
   * @return {HTMLElement[]} List of focusable elements
   */

  function getFocusableElements() {
    var element = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
    return _toConsumableArray(element.querySelectorAll('a, button, details, input, select, textarea, [tabindex]:not([tabindex="-1"])')).filter(function (e) {
      return !e.hasAttribute('disabled');
    });
  }

  function handleKeyDown(e) {
    var TAB = 9;
    var isTab = e.key.toLowerCase() === 'tab' || e.keyCode === TAB;
    if (!isTab) return;

    if (e.shiftKey) {
      if (document.activeElement === firstFocusableEl) {
        lastFocusableEl.focus();
        e.preventDefault();
      }
    } else {
      if (document.activeElement === lastFocusableEl) {
        firstFocusableEl.focus();
        e.preventDefault();
      }
    }
  }

  element.addEventListener('keydown', handleKeyDown);
  return function cleanup() {
    element.removeEventListener('keydown', handleKeyDown);
  };
}
/******/ })()
;