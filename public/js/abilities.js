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
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Abilities.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/abilities/Abilities.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _event_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../event.js */ "./resources/assets/js/components/event.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['id', 'api', 'permission'],
  data: function data() {
    return {
      abilities: [],
      parents: [],
      meta: [],
      loading: true,
      show_parent: false,
      parent: null,
      waiting: false,
      modal: false
    };
  },
  methods: {
    getAbilities: function getAbilities() {
      var _this = this;

      axios.get(this.api).then(function (response) {
        _this.abilities = response.data.data.abilities;
        _this.parents = response.data.data.parents;
        _this.meta = response.data.data.meta;
        _this.loading = false;
        _this.waiting = false;

        if (_this.parent) {
          // We need to find our parent again to "reload" it properly
          _this.parent = _this.parents[_this.parent.id];

          _this.showParent(_this.parent);
        }
      });
    },
    //
    showParent: function showParent(parent) {
      this.show_parent = !!parent;
    },

    /**
     * Add an ability
     */
    addAbility: function addAbility() {
      _event_js__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('add_ability', this.meta.add_url);
    },

    /**
     * Delete an ability from the dataset. This sends a delete request to the api and
     * splices the message out of the dataset.
     * @param ability
     */
    deleteAbility: function deleteAbility(ability) {
      var _this2 = this;

      this.waiting = true;
      axios["delete"](ability.actions["delete"]).then(function () {
        _this2.getAbilities();
      })["catch"](function () {
        // Ability might have been deleted by someone else
        _this2.getAbilities();
      });
    }
  },
  mounted: function mounted() {
    var _this3 = this;

    this.getAbilities();
    _event_js__WEBPACK_IMPORTED_MODULE_0__["default"].$on('click_parent', function (parent) {
      _this3.parent = parent;

      _this3.showParent(parent);
    });
    _event_js__WEBPACK_IMPORTED_MODULE_0__["default"].$on('delete_ability', function (ability) {
      _this3.deleteAbility(ability);
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Ability.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/abilities/Ability.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _event_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../event.js */ "./resources/assets/js/components/event.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['ability', 'permission', 'meta'],
  data: function data() {
    return {
      details: false
    };
  },
  computed: {
    hasAttribute: function hasAttribute() {
      return this.ability.attributes.length > 0;
    },
    canDelete: function canDelete() {
      return this.permission;
    },
    isSelf: function isSelf() {
      return this.meta.user_id == this.ability.created_by;
    }
  },
  methods: {
    click: function click(ability) {
      this.details = !this.details;
    },
    deleteAbility: function deleteAbility(ability) {
      _event_js__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('delete_ability', ability);
    },
    setVisibility: function setVisibility(visibility) {
      var _this = this;

      var data = {
        visibility: visibility,
        ability_id: this.ability.ability_id
      };
      axios.patch(this.ability.actions.edit, data).then(function (response) {
        _this.ability.visibility = visibility;
        _event_js__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('edited_ability', ability);
      })["catch"](function () {});
    },
    useCharge: function useCharge(ability, charge) {
      if (charge > ability.used_charges) {
        ability.used_charges += 1;
      } else {
        ability.used_charges -= 1;
      }

      axios.post(ability.actions.use, {
        'used': ability.used_charges
      }).then(function (res) {
        if (!res.data.success) {
          ability.used_charges -= 1;
        }
      })["catch"](function () {
        ability.used_charges -= 1;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _event_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../event.js */ "./resources/assets/js/components/event.js");
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  props: [],
  data: function data() {
    return {
      modal: false,
      modalContent: ''
    };
  },
  methods: {
    showModal: function showModal(url) {
      var _this = this;

      this.modal = true;
      axios.get(url).then(function (response) {
        _this.modalContent = response.data;
      });
    },
    modalStyle: function modalStyle() {
      return this.modal ? 'block' : 'hidden';
    }
  },
  mounted: function mounted() {
    var _this2 = this;

    _event_js__WEBPACK_IMPORTED_MODULE_0__["default"].$on('add_ability', function (url) {
      _this2.showModal(url);
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Parent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/abilities/Parent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _event_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../event.js */ "./resources/assets/js/components/event.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['ability'],
  data: function data() {
    return {
      active: false
    };
  },
  computed: {
    backgroundImage: function backgroundImage() {
      if (this.ability.has_image) {
        return {
          backgroundImage: 'url(' + this.ability.image + ')'
        };
      }

      return {};
    }
  },
  methods: {
    click: function click(ability) {
      _event_js__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('click_parent', this.active ? null : ability);
    }
  },
  mounted: function mounted() {
    var _this = this;

    _event_js__WEBPACK_IMPORTED_MODULE_0__["default"].$on('click_parent', function (ab) {
      _this.active = ab && ab.id === _this.ability.id;
    });
  }
});

/***/ }),

/***/ "./node_modules/node-libs-browser/node_modules/timers-browserify/main.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/node-libs-browser/node_modules/timers-browserify/main.js ***!
  \*******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var scope = (typeof global !== "undefined" && global) ||
            (typeof self !== "undefined" && self) ||
            window;
var apply = Function.prototype.apply;

// DOM APIs, for completeness

exports.setTimeout = function() {
  return new Timeout(apply.call(setTimeout, scope, arguments), clearTimeout);
};
exports.setInterval = function() {
  return new Timeout(apply.call(setInterval, scope, arguments), clearInterval);
};
exports.clearTimeout =
exports.clearInterval = function(timeout) {
  if (timeout) {
    timeout.close();
  }
};

function Timeout(id, clearFn) {
  this._id = id;
  this._clearFn = clearFn;
}
Timeout.prototype.unref = Timeout.prototype.ref = function() {};
Timeout.prototype.close = function() {
  this._clearFn.call(scope, this._id);
};

// Does not start the time, just sets up the members needed.
exports.enroll = function(item, msecs) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = msecs;
};

exports.unenroll = function(item) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = -1;
};

exports._unrefActive = exports.active = function(item) {
  clearTimeout(item._idleTimeoutId);

  var msecs = item._idleTimeout;
  if (msecs >= 0) {
    item._idleTimeoutId = setTimeout(function onTimeout() {
      if (item._onTimeout)
        item._onTimeout();
    }, msecs);
  }
};

// setimmediate attaches itself to the global object
__webpack_require__(/*! setimmediate */ "./node_modules/setimmediate/setImmediate.js");
// On some exotic environments, it's not clear which object `setimmediate` was
// able to install onto.  Search each possibility in the same order as the
// `setimmediate` library.
exports.setImmediate = (typeof self !== "undefined" && self.setImmediate) ||
                       (typeof global !== "undefined" && global.setImmediate) ||
                       (this && this.setImmediate);
exports.clearImmediate = (typeof self !== "undefined" && self.clearImmediate) ||
                         (typeof global !== "undefined" && global.clearImmediate) ||
                         (this && this.clearImmediate);

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),

/***/ "./node_modules/setimmediate/setImmediate.js":
/*!***************************************************!*\
  !*** ./node_modules/setimmediate/setImmediate.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global, process) {(function (global, undefined) {
    "use strict";

    if (global.setImmediate) {
        return;
    }

    var nextHandle = 1; // Spec says greater than zero
    var tasksByHandle = {};
    var currentlyRunningATask = false;
    var doc = global.document;
    var registerImmediate;

    function setImmediate(callback) {
      // Callback can either be a function or a string
      if (typeof callback !== "function") {
        callback = new Function("" + callback);
      }
      // Copy function arguments
      var args = new Array(arguments.length - 1);
      for (var i = 0; i < args.length; i++) {
          args[i] = arguments[i + 1];
      }
      // Store and register the task
      var task = { callback: callback, args: args };
      tasksByHandle[nextHandle] = task;
      registerImmediate(nextHandle);
      return nextHandle++;
    }

    function clearImmediate(handle) {
        delete tasksByHandle[handle];
    }

    function run(task) {
        var callback = task.callback;
        var args = task.args;
        switch (args.length) {
        case 0:
            callback();
            break;
        case 1:
            callback(args[0]);
            break;
        case 2:
            callback(args[0], args[1]);
            break;
        case 3:
            callback(args[0], args[1], args[2]);
            break;
        default:
            callback.apply(undefined, args);
            break;
        }
    }

    function runIfPresent(handle) {
        // From the spec: "Wait until any invocations of this algorithm started before this one have completed."
        // So if we're currently running a task, we'll need to delay this invocation.
        if (currentlyRunningATask) {
            // Delay by doing a setTimeout. setImmediate was tried instead, but in Firefox 7 it generated a
            // "too much recursion" error.
            setTimeout(runIfPresent, 0, handle);
        } else {
            var task = tasksByHandle[handle];
            if (task) {
                currentlyRunningATask = true;
                try {
                    run(task);
                } finally {
                    clearImmediate(handle);
                    currentlyRunningATask = false;
                }
            }
        }
    }

    function installNextTickImplementation() {
        registerImmediate = function(handle) {
            process.nextTick(function () { runIfPresent(handle); });
        };
    }

    function canUsePostMessage() {
        // The test against `importScripts` prevents this implementation from being installed inside a web worker,
        // where `global.postMessage` means something completely different and can't be used for this purpose.
        if (global.postMessage && !global.importScripts) {
            var postMessageIsAsynchronous = true;
            var oldOnMessage = global.onmessage;
            global.onmessage = function() {
                postMessageIsAsynchronous = false;
            };
            global.postMessage("", "*");
            global.onmessage = oldOnMessage;
            return postMessageIsAsynchronous;
        }
    }

    function installPostMessageImplementation() {
        // Installs an event handler on `global` for the `message` event: see
        // * https://developer.mozilla.org/en/DOM/window.postMessage
        // * http://www.whatwg.org/specs/web-apps/current-work/multipage/comms.html#crossDocumentMessages

        var messagePrefix = "setImmediate$" + Math.random() + "$";
        var onGlobalMessage = function(event) {
            if (event.source === global &&
                typeof event.data === "string" &&
                event.data.indexOf(messagePrefix) === 0) {
                runIfPresent(+event.data.slice(messagePrefix.length));
            }
        };

        if (global.addEventListener) {
            global.addEventListener("message", onGlobalMessage, false);
        } else {
            global.attachEvent("onmessage", onGlobalMessage);
        }

        registerImmediate = function(handle) {
            global.postMessage(messagePrefix + handle, "*");
        };
    }

    function installMessageChannelImplementation() {
        var channel = new MessageChannel();
        channel.port1.onmessage = function(event) {
            var handle = event.data;
            runIfPresent(handle);
        };

        registerImmediate = function(handle) {
            channel.port2.postMessage(handle);
        };
    }

    function installReadyStateChangeImplementation() {
        var html = doc.documentElement;
        registerImmediate = function(handle) {
            // Create a <script> element; its readystatechange event will be fired asynchronously once it is inserted
            // into the document. Do so, thus queuing up the task. Remember to clean up once it's been called.
            var script = doc.createElement("script");
            script.onreadystatechange = function () {
                runIfPresent(handle);
                script.onreadystatechange = null;
                html.removeChild(script);
                script = null;
            };
            html.appendChild(script);
        };
    }

    function installSetTimeoutImplementation() {
        registerImmediate = function(handle) {
            setTimeout(runIfPresent, 0, handle);
        };
    }

    // If supported, we should attach to the prototype of global, since that is where setTimeout et al. live.
    var attachTo = Object.getPrototypeOf && Object.getPrototypeOf(global);
    attachTo = attachTo && attachTo.setTimeout ? attachTo : global;

    // Don't get fooled by e.g. browserify environments.
    if ({}.toString.call(global.process) === "[object process]") {
        // For Node.js before 0.9
        installNextTickImplementation();

    } else if (canUsePostMessage()) {
        // For non-IE10 modern browsers
        installPostMessageImplementation();

    } else if (global.MessageChannel) {
        // For web workers, where supported
        installMessageChannelImplementation();

    } else if (doc && "onreadystatechange" in doc.createElement("script")) {
        // For IE 6–8
        installReadyStateChangeImplementation();

    } else {
        // For older browsers
        installSetTimeoutImplementation();
    }

    attachTo.setImmediate = setImmediate;
    attachTo.clearImmediate = clearImmediate;
}(typeof self === "undefined" ? typeof global === "undefined" ? this : global : self));

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js"), __webpack_require__(/*! ./../process/browser.js */ "./node_modules/process/browser.js")))

/***/ }),

/***/ "./node_modules/uiv/dist/uiv.esm.js":
/*!******************************************!*\
  !*** ./node_modules/uiv/dist/uiv.esm.js ***!
  \******************************************/
/*! exports provided: Carousel, Slide, Collapse, Dropdown, Modal, Tab, Tabs, DatePicker, Affix, Alert, Pagination, Tooltip, Popover, TimePicker, Typeahead, ProgressBar, ProgressBarStack, Breadcrumbs, BreadcrumbItem, Btn, BtnGroup, BtnToolbar, MultiSelect, Navbar, NavbarNav, NavbarForm, NavbarText, tooltip, popover, scrollspy, MessageBox, Notification, install */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Carousel", function() { return Carousel; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Slide", function() { return Slide; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Collapse", function() { return Collapse; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Dropdown", function() { return Dropdown; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Modal", function() { return Modal; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Tab", function() { return Tab; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Tabs", function() { return Tabs; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "DatePicker", function() { return DatePicker; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Affix", function() { return Affix; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Alert", function() { return Alert; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Pagination", function() { return Pagination; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Tooltip", function() { return Tooltip; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Popover", function() { return Popover; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TimePicker", function() { return TimePicker; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Typeahead", function() { return Typeahead; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ProgressBar", function() { return ProgressBar; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ProgressBarStack", function() { return ProgressBarStack; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Breadcrumbs", function() { return Breadcrumbs; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "BreadcrumbItem", function() { return BreadcrumbItem; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Btn", function() { return Btn; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "BtnGroup", function() { return BtnGroup; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "BtnToolbar", function() { return BtnToolbar; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MultiSelect", function() { return MultiSelect; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Navbar", function() { return Navbar; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "NavbarNav", function() { return NavbarNav; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "NavbarForm", function() { return NavbarForm; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "NavbarText", function() { return NavbarText; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "tooltip", function() { return tooltip; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "popover", function() { return popover; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "scrollspy", function() { return scrollspy; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MessageBox", function() { return messageBox; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Notification", function() { return notification; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "install", function() { return install; });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);


function isExist(obj) {
  return typeof obj !== 'undefined' && obj !== null;
}

function isFunction(obj) {
  return typeof obj === 'function';
}

function isNumber(obj) {
  return typeof obj === 'number';
}

function isString(obj) {
  return typeof obj === 'string';
}

function isBoolean(obj) {
  return typeof obj === 'boolean';
}

function isPromiseSupported() {
  return typeof window !== 'undefined' && isExist(window.Promise);
}

var Carousel = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('div', { staticClass: "carousel slide", attrs: { "data-ride": "carousel" }, on: { "mouseenter": _vm.stopInterval, "mouseleave": _vm.startInterval } }, [_vm.indicators ? _vm._t("indicators", [_c('ol', { staticClass: "carousel-indicators" }, _vm._l(_vm.slides, function (slide, index) {
      return _c('li', { class: { active: index === _vm.activeIndex }, on: { "click": function click($event) {
            return _vm.select(index);
          } } });
    }), 0)], { "select": _vm.select, "activeIndex": _vm.activeIndex }) : _vm._e(), _vm._v(" "), _c('div', { staticClass: "carousel-inner", attrs: { "role": "listbox" } }, [_vm._t("default")], 2), _vm._v(" "), _vm.controls ? _c('a', { staticClass: "left carousel-control", attrs: { "href": "#", "role": "button" }, on: { "click": function click($event) {
          $event.preventDefault();return _vm.prev();
        } } }, [_c('span', { class: _vm.iconControlLeft, attrs: { "aria-hidden": "true" } }), _vm._v(" "), _c('span', { staticClass: "sr-only" }, [_vm._v("Previous")])]) : _vm._e(), _vm._v(" "), _vm.controls ? _c('a', { staticClass: "right carousel-control", attrs: { "href": "#", "role": "button" }, on: { "click": function click($event) {
          $event.preventDefault();return _vm.next();
        } } }, [_c('span', { class: _vm.iconControlRight, attrs: { "aria-hidden": "true" } }), _vm._v(" "), _c('span', { staticClass: "sr-only" }, [_vm._v("Next")])]) : _vm._e()], 2);
  }, staticRenderFns: [],
  props: {
    value: Number,
    indicators: {
      type: Boolean,
      default: true
    },
    controls: {
      type: Boolean,
      default: true
    },
    interval: {
      type: Number,
      default: 5000
    },
    iconControlLeft: {
      type: String,
      default: 'glyphicon glyphicon-chevron-left'
    },
    iconControlRight: {
      type: String,
      default: 'glyphicon glyphicon-chevron-right'
    }
  },
  data: function data() {
    return {
      slides: [],
      activeIndex: 0, // Make v-model not required
      timeoutId: 0,
      intervalId: 0
    };
  },

  watch: {
    interval: function interval() {
      this.startInterval();
    },
    value: function value(index, oldValue) {
      this.run(index, oldValue);
      this.activeIndex = index;
    }
  },
  mounted: function mounted() {
    if (isExist(this.value)) {
      this.activeIndex = this.value;
    }
    if (this.slides.length > 0) {
      this.$select(this.activeIndex);
    }
    this.startInterval();
  },
  beforeDestroy: function beforeDestroy() {
    this.stopInterval();
  },

  methods: {
    run: function run(newIndex, oldIndex) {
      var _this = this;

      var currentActiveIndex = oldIndex || 0;
      var direction = void 0;
      if (newIndex > currentActiveIndex) {
        direction = ['next', 'left'];
      } else {
        direction = ['prev', 'right'];
      }
      this.slides[newIndex].slideClass[direction[0]] = true;
      this.$nextTick(function () {
        _this.slides[newIndex].$el.offsetHeight;
        _this.slides.forEach(function (slide, i) {
          if (i === currentActiveIndex) {
            slide.slideClass.active = true;
            slide.slideClass[direction[1]] = true;
          } else if (i === newIndex) {
            slide.slideClass[direction[1]] = true;
          }
        });
        _this.timeoutId = setTimeout(function () {
          _this.$select(newIndex);
          _this.$emit('change', newIndex);
          _this.timeoutId = 0;
        }, 600);
      });
    },
    startInterval: function startInterval() {
      var _this2 = this;

      this.stopInterval();
      if (this.interval > 0) {
        this.intervalId = setInterval(function () {
          _this2.next();
        }, this.interval);
      }
    },
    stopInterval: function stopInterval() {
      clearInterval(this.intervalId);
      this.intervalId = 0;
    },
    resetAllSlideClass: function resetAllSlideClass() {
      this.slides.forEach(function (slide) {
        slide.slideClass.active = false;
        slide.slideClass.left = false;
        slide.slideClass.right = false;
        slide.slideClass.next = false;
        slide.slideClass.prev = false;
      });
    },
    $select: function $select(index) {
      this.resetAllSlideClass();
      this.slides[index].slideClass.active = true;
    },
    select: function select(index) {
      if (this.timeoutId !== 0 || index === this.activeIndex) {
        return;
      }
      if (isExist(this.value)) {
        this.$emit('input', index);
      } else {
        this.run(index, this.activeIndex);
        this.activeIndex = index;
      }
    },
    prev: function prev() {
      this.select(this.activeIndex === 0 ? this.slides.length - 1 : this.activeIndex - 1);
    },
    next: function next() {
      this.select(this.activeIndex === this.slides.length - 1 ? 0 : this.activeIndex + 1);
    }
  }
};

function spliceIfExist(arr, item) {
  if (Array.isArray(arr)) {
    var index = arr.indexOf(item);
    if (index >= 0) {
      arr.splice(index, 1);
    }
  }
}

function range(end) {
  var start = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
  var step = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 1;

  var arr = [];
  for (var i = start; i < end; i += step) {
    arr.push(i);
  }
  return arr;
}

function nodeListToArray(nodeList) {
  return Array.prototype.slice.call(nodeList || []);
}

function onlyUnique(value, index, self) {
  return self.indexOf(value) === index;
}

var Slide = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('div', { staticClass: "item", class: _vm.slideClass }, [_vm._t("default")], 2);
  }, staticRenderFns: [],
  data: function data() {
    return {
      slideClass: {
        active: false,
        prev: false,
        next: false,
        left: false,
        right: false
      }
    };
  },
  created: function created() {
    try {
      this.$parent.slides.push(this);
    } catch (e) {
      throw new Error('Slide parent must be Carousel.');
    }
  },
  beforeDestroy: function beforeDestroy() {
    var slides = this.$parent && this.$parent.slides;
    spliceIfExist(slides, this);
  }
};

var EVENTS = {
  MOUSE_ENTER: 'mouseenter',
  MOUSE_LEAVE: 'mouseleave',
  FOCUS: 'focus',
  BLUR: 'blur',
  CLICK: 'click',
  INPUT: 'input',
  KEY_DOWN: 'keydown',
  KEY_UP: 'keyup',
  KEY_PRESS: 'keypress',
  RESIZE: 'resize',
  SCROLL: 'scroll',
  TOUCH_START: 'touchstart',
  TOUCH_END: 'touchend'
};

var TRIGGERS = {
  CLICK: 'click',
  HOVER: 'hover',
  FOCUS: 'focus',
  HOVER_FOCUS: 'hover-focus',
  OUTSIDE_CLICK: 'outside-click',
  MANUAL: 'manual'
};

var PLACEMENTS = {
  TOP: 'top',
  RIGHT: 'right',
  BOTTOM: 'bottom',
  LEFT: 'left'
};

function isIE11() {
  return !!window.MSInputMethodContext && !!document.documentMode;
}

function isIE10() {
  return window.navigator.appVersion.indexOf('MSIE 10') !== -1;
}

function getComputedStyle(el) {
  return window.getComputedStyle(el);
}

function getViewportSize() {
  var width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
  var height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
  return { width: width, height: height };
}

var scrollbarWidth = null;
var savedScreenSize = null;

function getScrollbarWidth() {
  var recalculate = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

  var screenSize = getViewportSize();
  // return directly when already calculated & not force recalculate & screen size not changed
  if (scrollbarWidth !== null && !recalculate && screenSize.height === savedScreenSize.height && screenSize.width === savedScreenSize.width) {
    return scrollbarWidth;
  }
  if (document.readyState === 'loading') {
    return null;
  }
  var div1 = document.createElement('div');
  var div2 = document.createElement('div');
  div1.style.width = div2.style.width = div1.style.height = div2.style.height = '100px';
  div1.style.overflow = 'scroll';
  div2.style.overflow = 'hidden';
  document.body.appendChild(div1);
  document.body.appendChild(div2);
  scrollbarWidth = Math.abs(div1.scrollHeight - div2.scrollHeight);
  document.body.removeChild(div1);
  document.body.removeChild(div2);
  // save new screen size
  savedScreenSize = screenSize;
  return scrollbarWidth;
}

function on(element, event, handler) {
  element.addEventListener(event, handler);
}

function off(element, event, handler) {
  element.removeEventListener(event, handler);
}

function isElement(el) {
  return el && el.nodeType === Node.ELEMENT_NODE;
}

function removeFromDom(el) {
  isElement(el) && isElement(el.parentNode) && el.parentNode.removeChild(el);
}

function ensureElementMatchesFunction() {
  if (!Element.prototype.matches) {
    Element.prototype.matches = Element.prototype.matchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector || Element.prototype.oMatchesSelector || Element.prototype.webkitMatchesSelector || function (s) {
      var matches = (this.document || this.ownerDocument).querySelectorAll(s);
      var i = matches.length;
      while (--i >= 0 && matches.item(i) !== this) {}
      return i > -1;
    };
  }
}

function addClass(el, className) {
  if (!isElement(el)) {
    return;
  }
  if (el.className) {
    var classes = el.className.split(' ');
    if (classes.indexOf(className) < 0) {
      classes.push(className);
      el.className = classes.join(' ');
    }
  } else {
    el.className = className;
  }
}

function removeClass(el, className) {
  if (!isElement(el)) {
    return;
  }
  if (el.className) {
    var classes = el.className.split(' ');
    var newClasses = [];
    for (var i = 0, l = classes.length; i < l; i++) {
      if (classes[i] !== className) {
        newClasses.push(classes[i]);
      }
    }
    el.className = newClasses.join(' ');
  }
}

function hasClass(el, className) {
  if (!isElement(el)) {
    return false;
  }
  var classes = el.className.split(' ');
  for (var i = 0, l = classes.length; i < l; i++) {
    if (classes[i] === className) {
      return true;
    }
  }
  return false;
}

function setDropdownPosition(dropdown, trigger) {
  var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

  var doc = document.documentElement;
  var containerScrollLeft = (window.pageXOffset || doc.scrollLeft) - (doc.clientLeft || 0);
  var containerScrollTop = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
  var rect = trigger.getBoundingClientRect();
  var dropdownRect = dropdown.getBoundingClientRect();
  dropdown.style.right = 'auto';
  dropdown.style.bottom = 'auto';
  if (options.menuRight) {
    dropdown.style.left = containerScrollLeft + rect.left + rect.width - dropdownRect.width + 'px';
  } else {
    dropdown.style.left = containerScrollLeft + rect.left + 'px';
  }
  if (options.dropup) {
    dropdown.style.top = containerScrollTop + rect.top - dropdownRect.height - 4 + 'px';
  } else {
    dropdown.style.top = containerScrollTop + rect.top + rect.height + 'px';
  }
}

function isAvailableAtPosition(trigger, popup, placement) {
  var triggerRect = trigger.getBoundingClientRect();
  var popupRect = popup.getBoundingClientRect();
  var viewPortSize = getViewportSize();
  var top = true;
  var right = true;
  var bottom = true;
  var left = true;
  switch (placement) {
    case PLACEMENTS.TOP:
      top = triggerRect.top >= popupRect.height;
      left = triggerRect.left + triggerRect.width / 2 >= popupRect.width / 2;
      right = triggerRect.right - triggerRect.width / 2 + popupRect.width / 2 <= viewPortSize.width;
      break;
    case PLACEMENTS.BOTTOM:
      bottom = triggerRect.bottom + popupRect.height <= viewPortSize.height;
      left = triggerRect.left + triggerRect.width / 2 >= popupRect.width / 2;
      right = triggerRect.right - triggerRect.width / 2 + popupRect.width / 2 <= viewPortSize.width;
      break;
    case PLACEMENTS.RIGHT:
      right = triggerRect.right + popupRect.width <= viewPortSize.width;
      top = triggerRect.top + triggerRect.height / 2 >= popupRect.height / 2;
      bottom = triggerRect.bottom - triggerRect.height / 2 + popupRect.height / 2 <= viewPortSize.height;
      break;
    case PLACEMENTS.LEFT:
      left = triggerRect.left >= popupRect.width;
      top = triggerRect.top + triggerRect.height / 2 >= popupRect.height / 2;
      bottom = triggerRect.bottom - triggerRect.height / 2 + popupRect.height / 2 <= viewPortSize.height;
      break;
  }
  return top && right && bottom && left;
}

function setTooltipPosition(tooltip, trigger, placement, auto, appendToSelector, viewport) {
  if (!isElement(tooltip) || !isElement(trigger)) {
    return;
  }
  var isPopover = tooltip && tooltip.className && tooltip.className.indexOf('popover') >= 0;
  var containerScrollTop = void 0;
  var containerScrollLeft = void 0;
  if (!isExist(appendToSelector) || appendToSelector === 'body') {
    var doc = document.documentElement;
    containerScrollLeft = (window.pageXOffset || doc.scrollLeft) - (doc.clientLeft || 0);
    containerScrollTop = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
  } else {
    var container = document.querySelector(appendToSelector);
    containerScrollLeft = container.scrollLeft;
    containerScrollTop = container.scrollTop;
  }
  // auto adjust placement
  if (auto) {
    // Try: right -> bottom -> left -> top
    // Cause the default placement is top
    var placements = [PLACEMENTS.RIGHT, PLACEMENTS.BOTTOM, PLACEMENTS.LEFT, PLACEMENTS.TOP];
    // The class switch helper function
    var changePlacementClass = function changePlacementClass(placement) {
      // console.log(placement)
      placements.forEach(function (placement) {
        removeClass(tooltip, placement);
      });
      addClass(tooltip, placement);
    };
    // No need to adjust if the default placement fits
    if (!isAvailableAtPosition(trigger, tooltip, placement)) {
      for (var i = 0, l = placements.length; i < l; i++) {
        // Re-assign placement class
        changePlacementClass(placements[i]);
        // Break if new placement fits
        if (isAvailableAtPosition(trigger, tooltip, placements[i])) {
          placement = placements[i];
          break;
        }
      }
      changePlacementClass(placement);
    }
  }
  // fix left and top for tooltip
  var rect = trigger.getBoundingClientRect();
  var tooltipRect = tooltip.getBoundingClientRect();
  var top = void 0;
  var left = void 0;
  if (placement === PLACEMENTS.BOTTOM) {
    top = containerScrollTop + rect.top + rect.height;
    left = containerScrollLeft + rect.left + rect.width / 2 - tooltipRect.width / 2;
  } else if (placement === PLACEMENTS.LEFT) {
    top = containerScrollTop + rect.top + rect.height / 2 - tooltipRect.height / 2;
    left = containerScrollLeft + rect.left - tooltipRect.width;
  } else if (placement === PLACEMENTS.RIGHT) {
    top = containerScrollTop + rect.top + rect.height / 2 - tooltipRect.height / 2;
    // https://github.com/wxsms/uiv/issues/272
    // add 1px to fix above issue
    left = containerScrollLeft + rect.left + rect.width + 1;
  } else {
    top = containerScrollTop + rect.top - tooltipRect.height;
    left = containerScrollLeft + rect.left + rect.width / 2 - tooltipRect.width / 2;
  }
  var viewportEl = void 0;
  // viewport option
  if (isString(viewport)) {
    viewportEl = document.querySelector(viewport);
  } else if (isFunction(viewport)) {
    viewportEl = viewport(trigger);
  }
  if (isElement(viewportEl)) {
    var popoverFix = isPopover ? 11 : 0;
    var viewportReact = viewportEl.getBoundingClientRect();
    var viewportTop = containerScrollTop + viewportReact.top;
    var viewportLeft = containerScrollLeft + viewportReact.left;
    var viewportBottom = viewportTop + viewportReact.height;
    var viewportRight = viewportLeft + viewportReact.width;
    // fix top
    if (top < viewportTop) {
      top = viewportTop;
    } else if (top + tooltipRect.height > viewportBottom) {
      top = viewportBottom - tooltipRect.height;
    }
    // fix left
    if (left < viewportLeft) {
      left = viewportLeft;
    } else if (left + tooltipRect.width > viewportRight) {
      left = viewportRight - tooltipRect.width;
    }
    // fix for popover pointer
    if (placement === PLACEMENTS.BOTTOM) {
      top -= popoverFix;
    } else if (placement === PLACEMENTS.LEFT) {
      left += popoverFix;
    } else if (placement === PLACEMENTS.RIGHT) {
      left -= popoverFix;
    } else {
      top += popoverFix;
    }
  }
  // set position finally
  tooltip.style.top = top + 'px';
  tooltip.style.left = left + 'px';
}

function hasScrollbar(el) {
  var SCROLL = 'scroll';
  var hasVScroll = el.scrollHeight > el.clientHeight;
  var style = getComputedStyle(el);
  return hasVScroll || style.overflow === SCROLL || style.overflowY === SCROLL;
}

function toggleBodyOverflow(enable) {
  var MODAL_OPEN = 'modal-open';
  var body = document.body;
  if (enable) {
    removeClass(body, MODAL_OPEN);
    body.style.paddingRight = null;
  } else {
    var browsersWithFloatingScrollbar = isIE10() || isIE11();
    var documentHasScrollbar = hasScrollbar(document.documentElement) || hasScrollbar(document.body);
    if (documentHasScrollbar && !browsersWithFloatingScrollbar) {
      body.style.paddingRight = getScrollbarWidth() + 'px';
    }
    addClass(body, MODAL_OPEN);
  }
}

function getClosest(el, selector) {
  ensureElementMatchesFunction();
  var parent = void 0;
  var _el = el;
  while (_el) {
    parent = _el.parentElement;
    if (parent && parent.matches(selector)) {
      return parent;
    }
    _el = parent;
  }
  return null;
}

function getParents(el, selector) {
  var until = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;

  ensureElementMatchesFunction();
  var parents = [];
  var parent = el.parentElement;
  while (parent) {
    if (parent.matches(selector)) {
      parents.push(parent);
    } else if (until && (until === parent || parent.matches(until))) {
      break;
    }
    parent = parent.parentElement;
  }
  return parents;
}

function focus(el) {
  if (!isElement(el)) {
    return;
  }
  el.getAttribute('tabindex') ? null : el.setAttribute('tabindex', '-1');
  el.focus();
}

var COLLAPSE = 'collapse';
var IN = 'in';
var COLLAPSING = 'collapsing';

var Collapse = {
  render: function render(h) {
    return h(this.tag, {}, this.$slots.default);
  },

  props: {
    tag: {
      type: String,
      default: 'div'
    },
    value: {
      type: Boolean,
      default: false
    },
    transitionDuration: {
      type: Number,
      default: 350
    }
  },
  data: function data() {
    return {
      timeoutId: 0
    };
  },

  watch: {
    value: function value(show) {
      this.toggle(show);
    }
  },
  mounted: function mounted() {
    var el = this.$el;
    addClass(el, COLLAPSE);
    if (this.value) {
      addClass(el, IN);
    }
  },

  methods: {
    toggle: function toggle(show) {
      var _this = this;

      clearTimeout(this.timeoutId);
      var el = this.$el;
      if (show) {
        this.$emit('show');
        removeClass(el, COLLAPSE);
        el.style.height = 'auto';
        var height = window.getComputedStyle(el).height;
        el.style.height = null;
        addClass(el, COLLAPSING);
        el.offsetHeight; // force repaint
        el.style.height = height;
        this.timeoutId = setTimeout(function () {
          removeClass(el, COLLAPSING);
          addClass(el, COLLAPSE);
          addClass(el, IN);
          el.style.height = null;
          _this.timeoutId = 0;
          _this.$emit('shown');
        }, this.transitionDuration);
      } else {
        this.$emit('hide');
        el.style.height = window.getComputedStyle(el).height;
        removeClass(el, IN);
        removeClass(el, COLLAPSE);
        el.offsetHeight;
        el.style.height = null;
        addClass(el, COLLAPSING);
        this.timeoutId = setTimeout(function () {
          addClass(el, COLLAPSE);
          removeClass(el, COLLAPSING);
          el.style.height = null;
          _this.timeoutId = 0;
          _this.$emit('hidden');
        }, this.transitionDuration);
      }
    }
  }
};

var DEFAULT_TAG = 'div';

var Dropdown = {
  render: function render(h) {
    return h(this.tag, {
      class: {
        'btn-group': this.tag === DEFAULT_TAG,
        dropdown: !this.dropup,
        dropup: this.dropup,
        open: this.show
      }
    }, [this.$slots.default, h('ul', {
      class: {
        'dropdown-menu': true,
        'dropdown-menu-right': this.menuRight
      },
      ref: 'dropdown'
    }, [this.$slots.dropdown])]);
  },

  props: {
    tag: {
      type: String,
      default: DEFAULT_TAG
    },
    appendToBody: {
      type: Boolean,
      default: false
    },
    value: Boolean,
    dropup: {
      type: Boolean,
      default: false
    },
    menuRight: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    notCloseElements: Array,
    positionElement: null
  },
  data: function data() {
    return {
      show: false,
      triggerEl: undefined
    };
  },

  watch: {
    value: function value(v) {
      this.toggle(v);
    }
  },
  mounted: function mounted() {
    this.initTrigger();
    if (this.triggerEl) {
      on(this.triggerEl, EVENTS.CLICK, this.toggle);
      on(this.triggerEl, EVENTS.KEY_DOWN, this.onKeyPress);
    }
    on(this.$refs.dropdown, EVENTS.KEY_DOWN, this.onKeyPress);
    on(window, EVENTS.CLICK, this.windowClicked);
    on(window, EVENTS.TOUCH_END, this.windowClicked);
    if (this.value) {
      this.toggle(true);
    }
  },
  beforeDestroy: function beforeDestroy() {
    this.removeDropdownFromBody();
    if (this.triggerEl) {
      off(this.triggerEl, EVENTS.CLICK, this.toggle);
      off(this.triggerEl, EVENTS.KEY_DOWN, this.onKeyPress);
    }
    off(this.$refs.dropdown, EVENTS.KEY_DOWN, this.onKeyPress);
    off(window, EVENTS.CLICK, this.windowClicked);
    off(window, EVENTS.TOUCH_END, this.windowClicked);
  },

  methods: {
    onKeyPress: function onKeyPress(event) {
      if (this.show) {
        var dropdownEl = this.$refs.dropdown;
        var keyCode = event.keyCode || event.which;
        if (keyCode === 27) {
          this.toggle(false);
          this.triggerEl && this.triggerEl.focus();
        } else if (keyCode === 13) {
          var currentFocus = dropdownEl.querySelector('li > a:focus');
          currentFocus && currentFocus.click();
        } else if (keyCode === 38 || keyCode === 40) {
          event.preventDefault();
          event.stopPropagation();
          var _currentFocus = dropdownEl.querySelector('li > a:focus');
          var items = dropdownEl.querySelectorAll('li:not(.disabled) > a');
          if (!_currentFocus) {
            focus(items[0]);
          } else {
            for (var i = 0; i < items.length; i++) {
              if (_currentFocus === items[i]) {
                if (keyCode === 38 && i < items.length > 0) {
                  focus(items[i - 1]);
                } else if (keyCode === 40 && i < items.length - 1) {
                  focus(items[i + 1]);
                }
                break;
              }
            }
          }
        }
      }
    },
    initTrigger: function initTrigger() {
      var trigger = this.$el.querySelector('[data-role="trigger"]') || this.$el.querySelector('.dropdown-toggle') || this.$el.firstChild;
      this.triggerEl = trigger && trigger !== this.$refs.dropdown ? trigger : null;
    },
    toggle: function toggle(show) {
      if (this.disabled) {
        return;
      }
      if (isBoolean(show)) {
        this.show = show;
      } else {
        this.show = !this.show;
      }
      if (this.appendToBody) {
        this.show ? this.appendDropdownToBody() : this.removeDropdownFromBody();
      }
      this.$emit('input', this.show);
    },
    windowClicked: function windowClicked(event) {
      var target = event.target;
      if (this.show && target) {
        var targetInNotCloseElements = false;
        if (this.notCloseElements) {
          for (var i = 0, l = this.notCloseElements.length; i < l; i++) {
            var isTargetInElement = this.notCloseElements[i].contains(target);
            var shouldBreak = isTargetInElement;
            if (this.appendToBody) {
              var isTargetInDropdown = this.$refs.dropdown.contains(target);
              var isElInElements = this.notCloseElements.indexOf(this.$el) >= 0;
              shouldBreak = isTargetInElement || isTargetInDropdown && isElInElements;
            }
            if (shouldBreak) {
              targetInNotCloseElements = true;
              break;
            }
          }
        }
        var targetInDropdownBody = this.$refs.dropdown.contains(target);
        var targetInTrigger = this.$el.contains(target) && !targetInDropdownBody;
        // normally, a dropdown select event is handled by @click that trigger after @touchend
        // then @touchend event have to be ignore in this case
        var targetInDropdownAndIsTouchEvent = targetInDropdownBody && event.type === 'touchend';
        if (!targetInTrigger && !targetInNotCloseElements && !targetInDropdownAndIsTouchEvent) {
          this.toggle(false);
        }
      }
    },
    appendDropdownToBody: function appendDropdownToBody() {
      try {
        var el = this.$refs.dropdown;
        el.style.display = 'block';
        document.body.appendChild(el);
        var positionElement = this.positionElement || this.$el;
        setDropdownPosition(el, positionElement, this);
      } catch (e) {
        // Silent
      }
    },
    removeDropdownFromBody: function removeDropdownFromBody() {
      try {
        var el = this.$refs.dropdown;
        el.removeAttribute('style');
        this.$el.appendChild(el);
      } catch (e) {
        // Silent
      }
    }
  }
};

var defaultLang = {
  uiv: {
    datePicker: {
      clear: 'Clear',
      today: 'Today',
      month: 'Month',
      month1: 'January',
      month2: 'February',
      month3: 'March',
      month4: 'April',
      month5: 'May',
      month6: 'June',
      month7: 'July',
      month8: 'August',
      month9: 'September',
      month10: 'October',
      month11: 'November',
      month12: 'December',
      year: 'Year',
      week1: 'Mon',
      week2: 'Tue',
      week3: 'Wed',
      week4: 'Thu',
      week5: 'Fri',
      week6: 'Sat',
      week7: 'Sun'
    },
    timePicker: {
      am: 'AM',
      pm: 'PM'
    },
    modal: {
      cancel: 'Cancel',
      ok: 'OK'
    },
    multiSelect: {
      placeholder: 'Select...',
      filterPlaceholder: 'Search...'
    }
  }
};

// https://github.com/ElemeFE/element/blob/dev/src/locale/index.js
var lang = defaultLang;

var i18nHandler = function i18nHandler() {
  var vuei18n = Object.getPrototypeOf(this).$t;
  if (isFunction(vuei18n)) {
    try {
      return vuei18n.apply(this, arguments);
    } catch (err) {
      //  vuei18n.apply doesn't work with 7.3.3 of vue-i18n
      return this.$t.apply(this, arguments);
    }
  }
};

var t = function t(path, options) {
  options = options || {};

  var value = i18nHandler.apply(this, arguments);
  if (isExist(value) && !options.$$locale) {
    return value;
  }
  var array = path.split('.');
  var current = options.$$locale || lang;

  for (var i = 0, j = array.length; i < j; i++) {
    var property = array[i];
    value = current[property];
    if (i === j - 1) return value;
    if (!value) return '';
    current = value;
  }
  return '';
};

var use = function use(l) {
  lang = l || lang;
};

var i18n = function i18n(fn) {
  i18nHandler = fn || i18nHandler;
};

var locale = { use: use, t: t, i18n: i18n };

var defineProperty = function (obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
};

var _extends = Object.assign || function (target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i];

    for (var key in source) {
      if (Object.prototype.hasOwnProperty.call(source, key)) {
        target[key] = source[key];
      }
    }
  }

  return target;
};

var Local = {
  methods: {
    t: function t$$1() {
      for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
        args[_key] = arguments[_key];
      }

      args[1] = _extends({ $$locale: this.locale }, args[1]);
      return t.apply(this, args);
    }
  },
  props: {
    locale: Object
  }
};

function mergeData() {
  for (var e, a, s = {}, t = arguments.length; t--;) {
    for (var r = 0, c = Object.keys(arguments[t]); r < c.length; r++) {
      switch (e = c[r]) {case "class":case "style":case "directives":
          Array.isArray(s[e]) || (s[e] = []), s[e] = s[e].concat(arguments[t][e]);break;case "staticClass":
          if (!arguments[t][e]) break;void 0 === s[e] && (s[e] = ""), s[e] && (s[e] += " "), s[e] += arguments[t][e].trim();break;case "on":case "nativeOn":
          s[e] || (s[e] = {});for (var o = 0, n = Object.keys(arguments[t][e]); o < n.length; o++) {
            a = n[o], s[e][a] ? s[e][a] = [].concat(s[e][a], arguments[t][e][a]) : s[e][a] = arguments[t][e][a];
          }break;case "attrs":case "props":case "domProps":case "scopedSlots":case "staticStyle":case "hook":case "transition":
          s[e] || (s[e] = {}), s[e] = __assign({}, arguments[t][e], s[e]);break;case "slot":case "key":case "ref":case "tag":case "show":case "keepAlive":default:
          s[e] || (s[e] = arguments[t][e]);}
    }
  }return s;
}var __assign = Object.assign || function (e) {
  for (var a, s = 1, t = arguments.length; s < t; s++) {
    a = arguments[s];for (var r in a) {
      Object.prototype.hasOwnProperty.call(a, r) && (e[r] = a[r]);
    }
  }return e;
};

var linkMixin = {
  props: {
    // <a> props
    href: String,
    target: String,
    // <router-link> props
    to: null,
    replace: {
      type: Boolean,
      default: false
    },
    append: {
      type: Boolean,
      default: false
    },
    exact: {
      type: Boolean,
      default: false
    }
  }
};

var BtnGroup = {
  functional: true,
  render: function render(h, _ref) {
    var props = _ref.props,
        children = _ref.children,
        data = _ref.data;

    return h('div', mergeData(data, {
      class: defineProperty({
        'btn-group': !props.vertical,
        'btn-group-vertical': props.vertical,
        'btn-group-justified': props.justified
      }, 'btn-group-' + props.size, props.size),
      attrs: {
        role: 'group',
        'data-toggle': 'buttons'
      }
    }), children);
  },

  props: {
    size: String,
    vertical: {
      type: Boolean,
      default: false
    },
    justified: {
      type: Boolean,
      default: false
    }
  }
};

var INPUT_TYPE_CHECKBOX = 'checkbox';
var INPUT_TYPE_RADIO = 'radio';

var Btn = {
  functional: true,
  mixins: [linkMixin],
  render: function render(h, _ref) {
    var _classes;

    var children = _ref.children,
        props = _ref.props,
        data = _ref.data;

    // event listeners
    var listeners = data.on || {};
    // checkbox: model contain inputValue
    // radio: model === inputValue
    var isInputActive = props.inputType === INPUT_TYPE_CHECKBOX ? props.value.indexOf(props.inputValue) >= 0 : props.value === props.inputValue;
    // button class
    var classes = (_classes = {
      btn: true,
      active: props.inputType ? isInputActive : props.active,
      disabled: props.disabled,
      'btn-block': props.block
    }, defineProperty(_classes, 'btn-' + props.type, Boolean(props.type)), defineProperty(_classes, 'btn-' + props.size, Boolean(props.size)), _classes);
    // prevent event for disabled links
    var on = {
      click: function click(e) {
        if (props.disabled && e instanceof Event) {
          e.preventDefault();
          e.stopPropagation();
        }
      }
    };
    // render params
    var tag = void 0,
        options = void 0,
        slot = void 0;

    if (props.href) {
      // is native link
      tag = 'a';
      slot = children;
      options = mergeData(data, {
        on: on,
        class: classes,
        attrs: {
          role: 'button',
          href: props.href,
          target: props.target
        }
      });
    } else if (props.to) {
      // is vue router link
      tag = 'router-link';
      slot = children;
      options = mergeData(data, {
        nativeOn: on,
        class: classes,
        props: {
          event: props.disabled ? '' : 'click', // prevent nav while disabled
          to: props.to,
          replace: props.replace,
          append: props.append,
          exact: props.exact
        },
        attrs: {
          role: 'button'
        }
      });
    } else if (props.inputType) {
      // is input checkbox or radio
      tag = 'label';
      options = mergeData(data, {
        on: on,
        class: classes
      });
      slot = [h('input', {
        attrs: {
          autocomplete: 'off',
          type: props.inputType,
          checked: isInputActive ? 'checked' : null,
          disabled: props.disabled
        },
        domProps: {
          checked: isInputActive // required
        },
        on: {
          input: function input(evt) {
            evt.stopPropagation();
          },
          change: function change() {
            if (props.inputType === INPUT_TYPE_CHECKBOX) {
              var valueCopied = props.value.slice();
              if (isInputActive) {
                valueCopied.splice(valueCopied.indexOf(props.inputValue), 1);
              } else {
                valueCopied.push(props.inputValue);
              }
              listeners['input'](valueCopied);
            } else {
              listeners['input'](props.inputValue);
            }
          }
        }
      }), children];
    } else if (props.justified) {
      // is in justified btn-group
      tag = BtnGroup;
      options = {};
      slot = [h('button', mergeData(data, {
        on: on,
        class: classes,
        attrs: {
          type: props.nativeType,
          disabled: props.disabled
        }
      }), children)];
    } else {
      // is button
      tag = 'button';
      slot = children;
      options = mergeData(data, {
        on: on,
        class: classes,
        attrs: {
          type: props.nativeType,
          disabled: props.disabled
        }
      });
    }

    return h(tag, options, slot);
  },

  props: {
    justified: {
      type: Boolean,
      default: false
    },
    type: {
      type: String,
      default: 'default'
    },
    nativeType: {
      type: String,
      default: 'button'
    },
    size: String,
    block: {
      type: Boolean,
      default: false
    },
    active: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    // <input> props
    value: null,
    inputValue: null,
    inputType: {
      type: String,
      validator: function validator(value) {
        return value === INPUT_TYPE_CHECKBOX || value === INPUT_TYPE_RADIO;
      }
    }
  }
};

var MODAL_BACKDROP = 'modal-backdrop';
var IN$1 = 'in';
var getOpenModals = function getOpenModals() {
  return document.querySelectorAll('.' + MODAL_BACKDROP);
};
var getOpenModalNum = function getOpenModalNum() {
  return getOpenModals().length;
};

var Modal = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('div', { staticClass: "modal", class: { fade: _vm.transitionDuration > 0 }, attrs: { "tabindex": "-1", "role": "dialog" }, on: { "mousedown": function mousedown($event) {
          if ($event.target !== $event.currentTarget) {
            return null;
          }return _vm.backdropClicked($event);
        } } }, [_c('div', { ref: "dialog", staticClass: "modal-dialog", class: _vm.modalSizeClass, attrs: { "role": "document" } }, [_c('div', { staticClass: "modal-content" }, [_vm.header ? _c('div', { staticClass: "modal-header" }, [_vm._t("header", [_vm.dismissBtn ? _c('button', { staticClass: "close", staticStyle: { "position": "relative", "z-index": "1060" }, attrs: { "type": "button", "aria-label": "Close" }, on: { "click": function click($event) {
          return _vm.toggle(false);
        } } }, [_c('span', { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]) : _vm._e(), _vm._v(" "), _c('h4', { staticClass: "modal-title" }, [_vm._t("title", [_vm._v(_vm._s(_vm.title))])], 2)])], 2) : _vm._e(), _vm._v(" "), _c('div', { staticClass: "modal-body" }, [_vm._t("default")], 2), _vm._v(" "), _vm.footer ? _c('div', { staticClass: "modal-footer" }, [_vm._t("footer", [_c('btn', { attrs: { "type": _vm.cancelType }, on: { "click": function click($event) {
          return _vm.toggle(false, 'cancel');
        } } }, [_c('span', [_vm._v(_vm._s(_vm.cancelText || _vm.t('uiv.modal.cancel')))])]), _vm._v(" "), _c('btn', { attrs: { "type": _vm.okType, "data-action": "auto-focus" }, on: { "click": function click($event) {
          return _vm.toggle(false, 'ok');
        } } }, [_c('span', [_vm._v(_vm._s(_vm.okText || _vm.t('uiv.modal.ok')))])])])], 2) : _vm._e()])]), _vm._v(" "), _c('div', { ref: "backdrop", staticClass: "modal-backdrop", class: { fade: _vm.transitionDuration > 0 } })]);
  }, staticRenderFns: [],
  mixins: [Local],
  components: { Btn: Btn },
  props: {
    value: {
      type: Boolean,
      default: false
    },
    title: String,
    size: String,
    backdrop: {
      type: Boolean,
      default: true
    },
    footer: {
      type: Boolean,
      default: true
    },
    header: {
      type: Boolean,
      default: true
    },
    cancelText: String,
    cancelType: {
      type: String,
      default: 'default'
    },
    okText: String,
    okType: {
      type: String,
      default: 'primary'
    },
    dismissBtn: {
      type: Boolean,
      default: true
    },
    transitionDuration: {
      type: Number,
      default: 150
    },
    autoFocus: {
      type: Boolean,
      default: false
    },
    keyboard: {
      type: Boolean,
      default: true
    },
    beforeClose: Function,
    zOffset: {
      type: Number,
      default: 20
    },
    appendToBody: {
      type: Boolean,
      default: false
    },
    displayStyle: {
      type: String,
      default: 'block'
    }
  },
  data: function data() {
    return {
      msg: '',
      timeoutId: 0
    };
  },

  computed: {
    modalSizeClass: function modalSizeClass() {
      return defineProperty({}, 'modal-' + this.size, Boolean(this.size));
    }
  },
  watch: {
    value: function value(v) {
      this.$toggle(v);
    }
  },
  mounted: function mounted() {
    removeFromDom(this.$refs.backdrop);
    on(window, EVENTS.KEY_UP, this.onKeyPress);
    if (this.value) {
      this.$toggle(true);
    }
  },
  beforeDestroy: function beforeDestroy() {
    clearTimeout(this.timeoutId);
    removeFromDom(this.$refs.backdrop);
    removeFromDom(this.$el);
    if (getOpenModalNum() === 0) {
      toggleBodyOverflow(true);
    }
    off(window, EVENTS.KEY_UP, this.onKeyPress);
  },

  methods: {
    onKeyPress: function onKeyPress(event) {
      if (this.keyboard && this.value && event.keyCode === 27) {
        var thisModal = this.$refs.backdrop;
        var thisZIndex = thisModal.style.zIndex;
        thisZIndex = thisZIndex && thisZIndex !== 'auto' ? parseInt(thisZIndex) : 0;
        // Find out if this modal is the top most one.
        var modals = getOpenModals();
        var modalsLength = modals.length;
        for (var i = 0; i < modalsLength; i++) {
          if (modals[i] !== thisModal) {
            var zIndex = modals[i].style.zIndex;
            zIndex = zIndex && zIndex !== 'auto' ? parseInt(zIndex) : 0;
            // if any existing modal has higher zIndex, ignore
            if (zIndex > thisZIndex) {
              return;
            }
          }
        }
        this.toggle(false);
      }
    },
    toggle: function toggle(show, msg) {
      var _this = this;

      var shouldClose = true;
      if (isFunction(this.beforeClose)) {
        shouldClose = this.beforeClose(msg);
      }

      if (isPromiseSupported()) {
        // Skip the hiding when beforeClose returning falsely value or returned Promise resolves to falsely value
        // Use Promise.resolve to accept both Boolean values and Promises
        Promise.resolve(shouldClose).then(function (shouldClose) {
          // Skip the hiding while show===false
          if (!show && shouldClose) {
            _this.msg = msg;
            _this.$emit('input', show);
          }
        });
      } else {
        // Fallback to old version if promise is not supported
        // skip the hiding while show===false & beforeClose returning falsely value
        if (!show && !shouldClose) {
          return;
        }

        this.msg = msg;
        this.$emit('input', show);
      }
    },
    $toggle: function $toggle(show) {
      var _this2 = this;

      var modal = this.$el;
      var backdrop = this.$refs.backdrop;
      clearTimeout(this.timeoutId);
      if (show) {
        var alreadyOpenModalNum = getOpenModalNum();
        document.body.appendChild(backdrop);
        if (this.appendToBody) {
          document.body.appendChild(modal);
        }
        modal.style.display = this.displayStyle;
        modal.scrollTop = 0;
        backdrop.offsetHeight; // force repaint
        toggleBodyOverflow(false);
        addClass(backdrop, IN$1);
        addClass(modal, IN$1);
        // fix z-index for nested modals
        // no need to calculate if no modal is already open
        if (alreadyOpenModalNum > 0) {
          var modalBaseZ = parseInt(getComputedStyle(modal).zIndex) || 1050; // 1050 is default modal z-Index
          var backdropBaseZ = parseInt(getComputedStyle(backdrop).zIndex) || 1040; // 1040 is default backdrop z-Index
          var offset = alreadyOpenModalNum * this.zOffset;
          modal.style.zIndex = '' + (modalBaseZ + offset);
          backdrop.style.zIndex = '' + (backdropBaseZ + offset);
        }
        // z-index fix end
        this.timeoutId = setTimeout(function () {
          if (_this2.autoFocus) {
            var btn = _this2.$el.querySelector('[data-action="auto-focus"]');
            if (btn) {
              btn.focus();
            }
          }
          _this2.$emit('show');
          _this2.timeoutId = 0;
        }, this.transitionDuration);
      } else {
        removeClass(backdrop, IN$1);
        removeClass(modal, IN$1);
        this.timeoutId = setTimeout(function () {
          modal.style.display = 'none';
          removeFromDom(backdrop);
          if (_this2.appendToBody) {
            removeFromDom(modal);
          }
          if (getOpenModalNum() === 0) {
            toggleBodyOverflow(true);
          }
          _this2.$emit('hide', _this2.msg || 'dismiss');
          _this2.msg = '';
          _this2.timeoutId = 0;
          // restore z-index for nested modals
          modal.style.zIndex = '';
          backdrop.style.zIndex = '';
          // z-index fix end
        }, this.transitionDuration);
      }
    },
    backdropClicked: function backdropClicked(event) {
      if (this.backdrop) {
        this.toggle(false);
      }
    }
  }
};

var ACTIVE_CLASS = 'active';
var IN_CLASS = 'in';

var Tab = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('div', { staticClass: "tab-pane", class: { fade: _vm.transition > 0 }, attrs: { "role": "tabpanel" } }, [_vm._t("default")], 2);
  }, staticRenderFns: [],
  props: {
    title: {
      type: String,
      default: 'Tab Title'
    },
    htmlTitle: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    'tab-classes': {
      type: Object,
      default: function _default() {
        return {};
      }
    },
    group: String,
    pullRight: {
      type: Boolean,
      default: false
    }
  },
  data: function data() {
    return {
      active: true,
      transition: 150
    };
  },

  watch: {
    active: function active(_active) {
      var _this = this;

      if (_active) {
        setTimeout(function () {
          addClass(_this.$el, ACTIVE_CLASS);
          _this.$el.offsetHeight;
          addClass(_this.$el, IN_CLASS);
          try {
            _this.$parent.$emit('after-change', _this.$parent.activeIndex);
          } catch (e) {
            throw new Error('<tab> parent must be <tabs>.');
          }
        }, this.transition);
      } else {
        removeClass(this.$el, IN_CLASS);
        setTimeout(function () {
          removeClass(_this.$el, ACTIVE_CLASS);
        }, this.transition);
      }
    }
  },
  created: function created() {
    try {
      this.$parent.tabs.push(this);
    } catch (e) {
      throw new Error('<tab> parent must be <tabs>.');
    }
  },
  beforeDestroy: function beforeDestroy() {
    var tabs = this.$parent && this.$parent.tabs;
    spliceIfExist(tabs, this);
  },

  methods: {
    show: function show() {
      var _this2 = this;

      this.$nextTick(function () {
        addClass(_this2.$el, ACTIVE_CLASS);
        addClass(_this2.$el, IN_CLASS);
      });
    }
  }
};

var BEFORE_CHANGE_EVENT = 'before-change';

var Tabs = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('section', [_c('ul', { class: _vm.navClasses, attrs: { "role": "tablist" } }, [_vm._l(_vm.groupedTabs, function (tab, index) {
      return [tab.tabs ? _c('dropdown', { class: _vm.getTabClasses(tab), attrs: { "role": "presentation", "tag": "li" } }, [_c('a', { staticClass: "dropdown-toggle", attrs: { "role": "tab", "href": "#" }, on: { "click": function click($event) {
            $event.preventDefault();
          } } }, [_vm._v(_vm._s(tab.group) + " "), _c('span', { staticClass: "caret" })]), _vm._v(" "), _c('template', { slot: "dropdown" }, _vm._l(tab.tabs, function (subTab) {
        return _c('li', { class: _vm.getTabClasses(subTab, true) }, [_c('a', { attrs: { "href": "#" }, on: { "click": function click($event) {
              $event.preventDefault();_vm.select(_vm.tabs.indexOf(subTab));
            } } }, [_vm._v(_vm._s(subTab.title))])]);
      }), 0)], 2) : _c('li', { class: _vm.getTabClasses(tab), attrs: { "role": "presentation" } }, [tab.htmlTitle ? _c('a', { attrs: { "role": "tab", "href": "#" }, domProps: { "innerHTML": _vm._s(tab.title) }, on: { "click": function click($event) {
            $event.preventDefault();_vm.select(_vm.tabs.indexOf(tab));
          } } }) : _c('a', { attrs: { "role": "tab", "href": "#" }, domProps: { "textContent": _vm._s(tab.title) }, on: { "click": function click($event) {
            $event.preventDefault();_vm.select(_vm.tabs.indexOf(tab));
          } } })])];
    }), _vm._v(" "), !_vm.justified && _vm.$slots['nav-right'] ? _c('li', { staticClass: "pull-right" }, [_vm._t("nav-right")], 2) : _vm._e()], 2), _vm._v(" "), _c('div', { class: _vm.contentClasses }, [_vm._t("default")], 2)]);
  }, staticRenderFns: [],
  components: { Dropdown: Dropdown },
  props: {
    value: {
      type: Number,
      validator: function validator(v) {
        return v >= 0;
      }
    },
    transitionDuration: {
      type: Number,
      default: 150
    },
    justified: Boolean,
    pills: Boolean,
    stacked: Boolean,
    customNavClass: null,
    customContentClass: null
  },
  data: function data() {
    return {
      tabs: [],
      activeIndex: 0 // Make v-model not required
    };
  },

  watch: {
    value: {
      immediate: true,
      handler: function handler(value) {
        if (isNumber(value)) {
          this.activeIndex = value;
          this.selectCurrent();
        }
      }
    },
    tabs: function tabs(_tabs) {
      var _this = this;

      _tabs.forEach(function (tab, index) {
        tab.transition = _this.transitionDuration;
        if (index === _this.activeIndex) {
          tab.show();
        }
      });
      this.selectCurrent();
    }
  },
  computed: {
    navClasses: function navClasses() {
      var tabClasses = {
        'nav': true,
        'nav-justified': this.justified,
        'nav-tabs': !this.pills,
        'nav-pills': this.pills,
        'nav-stacked': this.stacked && this.pills
      };
      var customNavClass = this.customNavClass;
      if (isExist(customNavClass)) {
        if (isString(customNavClass)) {
          return _extends({}, tabClasses, defineProperty({}, customNavClass, true));
        } else {
          return _extends({}, tabClasses, customNavClass);
        }
      } else {
        return tabClasses;
      }
    },
    contentClasses: function contentClasses() {
      var contentClasses = {
        'tab-content': true
      };
      var customContentClass = this.customContentClass;
      if (isExist(customContentClass)) {
        if (isString(customContentClass)) {
          return _extends({}, contentClasses, defineProperty({}, customContentClass, true));
        } else {
          return _extends({}, contentClasses, customContentClass);
        }
      } else {
        return contentClasses;
      }
    },
    groupedTabs: function groupedTabs() {
      var tabs = [];
      var hash = {};
      this.tabs.forEach(function (tab) {
        if (tab.group) {
          if (hash.hasOwnProperty(tab.group)) {
            tabs[hash[tab.group]].tabs.push(tab);
          } else {
            tabs.push({
              tabs: [tab],
              group: tab.group
            });
            hash[tab.group] = tabs.length - 1;
          }
          if (tab.active) {
            tabs[hash[tab.group]].active = true;
          }
          if (tab.pullRight) {
            tabs[hash[tab.group]].pullRight = true;
          }
        } else {
          tabs.push(tab);
        }
      });
      return tabs;
    }
  },
  methods: {
    getTabClasses: function getTabClasses(tab) {
      var isSubTab = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

      var defaultClasses = {
        active: tab.active,
        disabled: tab.disabled,
        'pull-right': tab.pullRight && !isSubTab

        // return with new classes added to tab
      };return _extends(defaultClasses, tab['tabClasses']);
    },
    selectCurrent: function selectCurrent() {
      var _this2 = this;

      var found = false;
      this.tabs.forEach(function (tab, index) {
        if (index === _this2.activeIndex) {
          found = !tab.active;
          tab.active = true;
        } else {
          tab.active = false;
        }
      });
      if (found) {
        this.$emit('change', this.activeIndex);
      }
    },
    selectValidate: function selectValidate(index) {
      var _this3 = this;

      if (isFunction(this.$listeners[BEFORE_CHANGE_EVENT])) {
        this.$emit(BEFORE_CHANGE_EVENT, this.activeIndex, index, function (result) {
          if (!isExist(result)) {
            _this3.$select(index);
          }
        });
      } else {
        this.$select(index);
      }
    },
    select: function select(index) {
      if (!this.tabs[index].disabled && index !== this.activeIndex) {
        this.selectValidate(index);
      }
    },
    $select: function $select(index) {
      if (isNumber(this.value)) {
        this.$emit('input', index);
      } else {
        this.activeIndex = index;
        this.selectCurrent();
      }
    }
  }
};

function pad(value, num) {
  value = value + '';
  for (var i = num - value.length; i > 0; i--) {
    value = '0' + value;
  }
  return value;
}

var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

function daysInMonth(month, year) {
  return new Date(year, month + 1, 0).getDate();
}

function stringify(date, format) {
  try {
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var monthName = monthNames[month - 1];
    return format.replace(/yyyy/g, year).replace(/MMMM/g, monthName).replace(/MMM/g, monthName.substring(0, 3)).replace(/MM/g, pad(month, 2)).replace(/dd/g, pad(day, 2)).replace(/yy/g, year).replace(/M(?!a)/g, month).replace(/d/g, day);
  } catch (e) {
    return '';
  }
}

function convertDateToUTC(date) {
  return new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
}

/* https://stackoverflow.com/questions/6117814/get-week-of-year-in-javascript-like-in-php
 *
 * For a given date, get the ISO week number
 *
 * Based on information at:
 *
 *    http://www.merlyn.demon.co.uk/weekcalc.htm#WNR
 *
 * Algorithm is to find nearest thursday, it's year
 * is the year of the week number. Then get weeks
 * between that date and the first day of that year.
 *
 * Note that dates in one year can be weeks of previous
 * or next year, overlap is up to 3 days.
 *
 * e.g. 2014/12/29 is Monday in week  1 of 2015
 *      2012/1/1   is Sunday in week 52 of 2011
 */
function getWeekNumber(d) {
  // Copy date so don't modify original
  d = new Date(Date.UTC(d.year, d.month, d.date));
  // Set to nearest Thursday: current date + 4 - current day number
  // Make Sunday's day number 7
  d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
  // Get first day of year
  var yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
  // Calculate full weeks to nearest Thursday
  return Math.ceil(((d - yearStart) / 86400000 + 1) / 7);
}

var DateView = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('table', { staticStyle: { "width": "100%" }, attrs: { "role": "grid" } }, [_c('thead', [_c('tr', [_c('td', [_c('btn', { staticClass: "uiv-datepicker-pager-prev", staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm" }, on: { "click": _vm.goPrevMonth } }, [_c('i', { class: _vm.iconControlLeft })])], 1), _vm._v(" "), _c('td', { attrs: { "colspan": _vm.weekNumbers ? 6 : 5 } }, [_c('btn', { staticClass: "uiv-datepicker-title", staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm" }, on: { "click": _vm.changeView } }, [_c('b', [_vm._v(_vm._s(_vm.yearMonthStr))])])], 1), _vm._v(" "), _c('td', [_c('btn', { staticClass: "uiv-datepicker-pager-next", staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm" }, on: { "click": _vm.goNextMonth } }, [_c('i', { class: _vm.iconControlRight })])], 1)]), _vm._v(" "), _c('tr', { attrs: { "align": "center" } }, [_vm.weekNumbers ? _c('td') : _vm._e(), _vm._v(" "), _vm._l(_vm.weekDays, function (day) {
      return _c('td', { attrs: { "width": "14.2857142857%" } }, [_c('small', { staticClass: "uiv-datepicker-week" }, [_vm._v(_vm._s(_vm.tWeekName(day === 0 ? 7 : day)))])]);
    })], 2)]), _vm._v(" "), _c('tbody', _vm._l(_vm.monthDayRows, function (row) {
      return _c('tr', [_vm.weekNumbers ? _c('td', { staticClass: "text-center", staticStyle: { "border-right": "1px solid #eee" } }, [_c('small', { staticClass: "text-muted" }, [_vm._v(_vm._s(_vm.getWeekNumber(row[_vm.weekStartsWith])))])]) : _vm._e(), _vm._v(" "), _vm._l(row, function (date) {
        return _c('td', [_c('btn', { class: date.classes, staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm", "data-action": "select", "type": _vm.getBtnType(date), "disabled": date.disabled }, on: { "click": function click($event) {
              return _vm.select(date);
            } } }, [_c('span', { class: { 'text-muted': _vm.month !== date.month }, attrs: { "data-action": "select" } }, [_vm._v(_vm._s(date.date))])])], 1);
      })], 2);
    }), 0)]);
  }, staticRenderFns: [],
  mixins: [Local],
  props: {
    month: Number,
    year: Number,
    date: Date,
    today: Date,
    limit: Object,
    weekStartsWith: Number,
    iconControlLeft: String,
    iconControlRight: String,
    dateClass: Function,
    yearMonthFormatter: Function,
    weekNumbers: Boolean
  },
  components: { Btn: Btn },
  computed: {
    weekDays: function weekDays() {
      var days = [];
      var firstDay = this.weekStartsWith;
      while (days.length < 7) {
        days.push(firstDay++);
        if (firstDay > 6) {
          firstDay = 0;
        }
      }
      return days;
    },
    yearMonthStr: function yearMonthStr() {
      if (this.yearMonthFormatter) {
        return this.yearMonthFormatter(this.year, this.month);
      } else {
        return isExist(this.month) ? this.year + ' ' + this.t('uiv.datePicker.month' + (this.month + 1)) : this.year;
      }
    },
    monthDayRows: function monthDayRows() {
      var rows = [];
      var firstDay = new Date(this.year, this.month, 1);
      var prevMonthLastDate = new Date(this.year, this.month, 0).getDate();
      var startIndex = firstDay.getDay();
      // console.log(startIndex)
      var daysNum = daysInMonth(this.month, this.year);
      var weekOffset = 0;
      if (this.weekStartsWith > startIndex) {
        weekOffset = 7 - this.weekStartsWith;
      } else {
        weekOffset = 0 - this.weekStartsWith;
      }
      // console.log(prevMonthLastDate, startIndex, daysNum)
      for (var i = 0; i < 6; i++) {
        rows.push([]);
        for (var j = 0 - weekOffset; j < 7 - weekOffset; j++) {
          var currentIndex = i * 7 + j;
          var date = { year: this.year, disabled: false
            // date in and not in current month
          };if (currentIndex < startIndex) {
            date.date = prevMonthLastDate - startIndex + currentIndex + 1;
            if (this.month > 0) {
              date.month = this.month - 1;
            } else {
              date.month = 11;
              date.year--;
            }
          } else if (currentIndex < startIndex + daysNum) {
            date.date = currentIndex - startIndex + 1;
            date.month = this.month;
          } else {
            date.date = currentIndex - startIndex - daysNum + 1;
            if (this.month < 11) {
              date.month = this.month + 1;
            } else {
              date.month = 0;
              date.year++;
            }
          }
          // process limit dates
          var dateObj = new Date(date.year, date.month, date.date);
          var afterFrom = true;
          var beforeTo = true;
          if (this.limit && this.limit.from) {
            afterFrom = dateObj >= this.limit.from;
          }
          if (this.limit && this.limit.to) {
            beforeTo = dateObj < this.limit.to;
          }
          date.disabled = !afterFrom || !beforeTo;
          date.classes = isFunction(this.dateClass) ? this.dateClass(dateObj, {
            currentMonth: this.month,
            currentYear: this.year
          }) : '';
          rows[i].push(date);
        }
      }
      return rows;
    }
  },
  methods: {
    getWeekNumber: getWeekNumber,
    tWeekName: function tWeekName(index) {
      return this.t('uiv.datePicker.week' + index);
    },
    getBtnType: function getBtnType(date) {
      if (this.date && date.date === this.date.getDate() && date.month === this.date.getMonth() && date.year === this.date.getFullYear()) {
        return 'primary';
      } else if (date.date === this.today.getDate() && date.month === this.today.getMonth() && date.year === this.today.getFullYear()) {
        return 'info';
      } else {
        return 'default';
      }
    },
    select: function select(date) {
      this.$emit('date-change', date);
    },
    goPrevMonth: function goPrevMonth() {
      var month = this.month;
      var year = this.year;
      if (this.month > 0) {
        month--;
      } else {
        month = 11;
        year--;
        this.$emit('year-change', year);
      }
      this.$emit('month-change', month);
    },
    goNextMonth: function goNextMonth() {
      var month = this.month;
      var year = this.year;
      if (this.month < 11) {
        month++;
      } else {
        month = 0;
        year++;
        this.$emit('year-change', year);
      }
      this.$emit('month-change', month);
    },
    changeView: function changeView() {
      this.$emit('view-change', 'm');
    }
  }
};

var MonthView = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('table', { staticStyle: { "width": "100%" }, attrs: { "role": "grid" } }, [_c('thead', [_c('tr', [_c('td', [_c('btn', { staticClass: "uiv-datepicker-pager-prev", staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm" }, on: { "click": _vm.goPrevYear } }, [_c('i', { class: _vm.iconControlLeft })])], 1), _vm._v(" "), _c('td', { attrs: { "colspan": "4" } }, [_c('btn', { staticClass: "uiv-datepicker-title", staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm" }, on: { "click": function click($event) {
          return _vm.changeView();
        } } }, [_c('b', [_vm._v(_vm._s(_vm.year))])])], 1), _vm._v(" "), _c('td', [_c('btn', { staticClass: "uiv-datepicker-pager-next", staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm" }, on: { "click": _vm.goNextYear } }, [_c('i', { class: _vm.iconControlRight })])], 1)])]), _vm._v(" "), _c('tbody', _vm._l(_vm.rows, function (row, i) {
      return _c('tr', _vm._l(row, function (month, j) {
        return _c('td', { attrs: { "colspan": "2", "width": "33.333333%" } }, [_c('btn', { staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm", "type": _vm.getBtnClass(i * 3 + j) }, on: { "click": function click($event) {
              return _vm.changeView(i * 3 + j);
            } } }, [_c('span', [_vm._v(_vm._s(_vm.tCell(month)))])])], 1);
      }), 0);
    }), 0)]);
  }, staticRenderFns: [],
  components: { Btn: Btn },
  mixins: [Local],
  props: {
    month: Number,
    year: Number,
    iconControlLeft: String,
    iconControlRight: String
  },
  data: function data() {
    return {
      rows: []
    };
  },
  mounted: function mounted() {
    for (var i = 0; i < 4; i++) {
      this.rows.push([]);
      for (var j = 0; j < 3; j++) {
        this.rows[i].push(i * 3 + j + 1);
      }
    }
  },

  methods: {
    tCell: function tCell(cell) {
      return this.t('uiv.datePicker.month' + cell);
    },
    getBtnClass: function getBtnClass(month) {
      if (month === this.month) {
        return 'primary';
      } else {
        return 'default';
      }
    },
    goPrevYear: function goPrevYear() {
      this.$emit('year-change', this.year - 1);
    },
    goNextYear: function goNextYear() {
      this.$emit('year-change', this.year + 1);
    },
    changeView: function changeView(monthIndex) {
      if (isExist(monthIndex)) {
        this.$emit('month-change', monthIndex);
        this.$emit('view-change', 'd');
      } else {
        this.$emit('view-change', 'y');
      }
    }
  }
};

var YearView = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('table', { staticStyle: { "width": "100%" }, attrs: { "role": "grid" } }, [_c('thead', [_c('tr', [_c('td', [_c('btn', { staticClass: "uiv-datepicker-pager-prev", staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm" }, on: { "click": _vm.goPrevYear } }, [_c('i', { class: _vm.iconControlLeft })])], 1), _vm._v(" "), _c('td', { attrs: { "colspan": "3" } }, [_c('btn', { staticClass: "uiv-datepicker-title", staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm" } }, [_c('b', [_vm._v(_vm._s(_vm.yearStr))])])], 1), _vm._v(" "), _c('td', [_c('btn', { staticClass: "uiv-datepicker-pager-next", staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm" }, on: { "click": _vm.goNextYear } }, [_c('i', { class: _vm.iconControlRight })])], 1)])]), _vm._v(" "), _c('tbody', _vm._l(_vm.rows, function (row) {
      return _c('tr', _vm._l(row, function (year) {
        return _c('td', { attrs: { "width": "20%" } }, [_c('btn', { staticStyle: { "border": "none" }, attrs: { "block": "", "size": "sm", "type": _vm.getBtnClass(year) }, on: { "click": function click($event) {
              return _vm.changeView(year);
            } } }, [_c('span', [_vm._v(_vm._s(year))])])], 1);
      }), 0);
    }), 0)]);
  }, staticRenderFns: [],
  components: { Btn: Btn },
  props: {
    year: Number,
    iconControlLeft: String,
    iconControlRight: String
  },
  computed: {
    rows: function rows() {
      var rows = [];
      var yearGroupStart = this.year - this.year % 20;
      for (var i = 0; i < 4; i++) {
        rows.push([]);
        for (var j = 0; j < 5; j++) {
          rows[i].push(yearGroupStart + i * 5 + j);
        }
      }
      return rows;
    },
    yearStr: function yearStr() {
      var start = this.year - this.year % 20;
      return start + ' ~ ' + (start + 19);
    }
  },
  methods: {
    getBtnClass: function getBtnClass(year) {
      if (year === this.year) {
        return 'primary';
      } else {
        return 'default';
      }
    },
    goPrevYear: function goPrevYear() {
      this.$emit('year-change', this.year - 20);
    },
    goNextYear: function goNextYear() {
      this.$emit('year-change', this.year + 20);
    },
    changeView: function changeView(year) {
      this.$emit('year-change', year);
      this.$emit('view-change', 'm');
    }
  }
};

var DatePicker = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('div', { class: _vm.pickerClass, style: _vm.pickerStyle, attrs: { "data-role": "date-picker" }, on: { "click": _vm.onPickerClick } }, [_c('date-view', { directives: [{ name: "show", rawName: "v-show", value: _vm.view === 'd', expression: "view==='d'" }], attrs: { "month": _vm.currentMonth, "year": _vm.currentYear, "date": _vm.valueDateObj, "today": _vm.now, "limit": _vm.limit, "week-starts-with": _vm.weekStartsWith, "icon-control-left": _vm.iconControlLeft, "icon-control-right": _vm.iconControlRight, "date-class": _vm.dateClass, "year-month-formatter": _vm.yearMonthFormatter, "week-numbers": _vm.weekNumbers, "locale": _vm.locale }, on: { "month-change": _vm.onMonthChange, "year-change": _vm.onYearChange, "date-change": _vm.onDateChange, "view-change": _vm.onViewChange } }), _vm._v(" "), _c('month-view', { directives: [{ name: "show", rawName: "v-show", value: _vm.view === 'm', expression: "view==='m'" }], attrs: { "month": _vm.currentMonth, "year": _vm.currentYear, "icon-control-left": _vm.iconControlLeft, "icon-control-right": _vm.iconControlRight, "locale": _vm.locale }, on: { "month-change": _vm.onMonthChange, "year-change": _vm.onYearChange, "view-change": _vm.onViewChange } }), _vm._v(" "), _c('year-view', { directives: [{ name: "show", rawName: "v-show", value: _vm.view === 'y', expression: "view==='y'" }], attrs: { "year": _vm.currentYear, "icon-control-left": _vm.iconControlLeft, "icon-control-right": _vm.iconControlRight }, on: { "year-change": _vm.onYearChange, "view-change": _vm.onViewChange } }), _vm._v(" "), _vm.todayBtn || _vm.clearBtn ? _c('div', [_c('br'), _vm._v(" "), _c('div', { staticClass: "text-center" }, [_vm.todayBtn ? _c('btn', { attrs: { "data-action": "select", "type": "info", "size": "sm" }, domProps: { "textContent": _vm._s(_vm.t('uiv.datePicker.today')) }, on: { "click": _vm.selectToday } }) : _vm._e(), _vm._v(" "), _vm.clearBtn ? _c('btn', { attrs: { "data-action": "select", "size": "sm" }, domProps: { "textContent": _vm._s(_vm.t('uiv.datePicker.clear')) }, on: { "click": _vm.clearSelect } }) : _vm._e()], 1)]) : _vm._e()], 1);
  }, staticRenderFns: [],
  mixins: [Local],
  components: { DateView: DateView, MonthView: MonthView, YearView: YearView, Btn: Btn },
  props: {
    value: null,
    width: {
      type: Number,
      default: 270
    },
    todayBtn: {
      type: Boolean,
      default: true
    },
    clearBtn: {
      type: Boolean,
      default: true
    },
    closeOnSelected: {
      type: Boolean,
      default: true
    },
    limitFrom: null,
    limitTo: null,
    format: {
      type: String,
      default: 'yyyy-MM-dd'
    },
    initialView: {
      type: String,
      default: 'd'
    },
    dateParser: {
      type: Function,
      default: Date.parse
    },
    dateClass: Function,
    yearMonthFormatter: Function,
    weekStartsWith: {
      type: Number,
      default: 0,
      validator: function validator(value) {
        return value >= 0 && value <= 6;
      }
    },
    weekNumbers: Boolean,
    iconControlLeft: {
      type: String,
      default: 'glyphicon glyphicon-chevron-left'
    },
    iconControlRight: {
      type: String,
      default: 'glyphicon glyphicon-chevron-right'
    }
  },
  data: function data() {
    return {
      show: false,
      now: new Date(),
      currentMonth: 0,
      currentYear: 0,
      view: 'd'
    };
  },

  computed: {
    valueDateObj: function valueDateObj() {
      var ts = this.dateParser(this.value);
      if (isNaN(ts)) {
        return null;
      } else {
        var date = new Date(ts);
        if (date.getHours() !== 0) {
          date = new Date(ts + date.getTimezoneOffset() * 60 * 1000);
        }
        return date;
      }
    },
    pickerStyle: function pickerStyle() {
      return {
        width: this.width + 'px'
      };
    },
    pickerClass: function pickerClass() {
      return {
        'uiv-datepicker': true,
        'uiv-datepicker-date': this.view === 'd',
        'uiv-datepicker-month': this.view === 'm',
        'uiv-datepicker-year': this.view === 'y'
      };
    },
    limit: function limit() {
      var limit = {};
      if (this.limitFrom) {
        var limitFrom = this.dateParser(this.limitFrom);
        if (!isNaN(limitFrom)) {
          limitFrom = convertDateToUTC(new Date(limitFrom));
          limitFrom.setHours(0, 0, 0, 0);
          limit.from = limitFrom;
        }
      }
      if (this.limitTo) {
        var limitTo = this.dateParser(this.limitTo);
        if (!isNaN(limitTo)) {
          limitTo = convertDateToUTC(new Date(limitTo));
          limitTo.setHours(0, 0, 0, 0);
          limit.to = limitTo;
        }
      }
      return limit;
    }
  },
  mounted: function mounted() {
    if (this.value) {
      this.setMonthAndYearByValue(this.value);
    } else {
      this.currentMonth = this.now.getMonth();
      this.currentYear = this.now.getFullYear();
      this.view = this.initialView;
    }
  },

  watch: {
    value: function value(val, oldVal) {
      this.setMonthAndYearByValue(val, oldVal);
    }
  },
  methods: {
    setMonthAndYearByValue: function setMonthAndYearByValue(val, oldVal) {
      var ts = this.dateParser(val);
      if (!isNaN(ts)) {
        var date = new Date(ts);
        if (date.getHours() !== 0) {
          date = new Date(ts + date.getTimezoneOffset() * 60 * 1000);
        }
        if (this.limit && (this.limit.from && date < this.limit.from || this.limit.to && date >= this.limit.to)) {
          this.$emit('input', oldVal || '');
        } else {
          this.currentMonth = date.getMonth();
          this.currentYear = date.getFullYear();
        }
      }
    },
    onMonthChange: function onMonthChange(month) {
      this.currentMonth = month;
    },
    onYearChange: function onYearChange(year) {
      this.currentYear = year;
      this.currentMonth = undefined;
    },
    onDateChange: function onDateChange(date) {
      if (date && isNumber(date.date) && isNumber(date.month) && isNumber(date.year)) {
        var _date = new Date(date.year, date.month, date.date);
        this.$emit('input', this.format ? stringify(_date, this.format) : _date);
        // if the input event trigger nothing (same value)
        // manually correct
        this.currentMonth = date.month;
        this.currentYear = date.year;
      } else {
        this.$emit('input', '');
      }
    },
    onViewChange: function onViewChange(view) {
      this.view = view;
    },
    selectToday: function selectToday() {
      this.view = 'd';
      this.onDateChange({
        date: this.now.getDate(),
        month: this.now.getMonth(),
        year: this.now.getFullYear()
      });
    },
    clearSelect: function clearSelect() {
      this.currentMonth = this.now.getMonth();
      this.currentYear = this.now.getFullYear();
      this.view = this.initialView;
      this.onDateChange();
    },
    onPickerClick: function onPickerClick(event) {
      if (event.target.getAttribute('data-action') !== 'select' || !this.closeOnSelected) {
        event.stopPropagation();
      }
    }
  }
};

var HANDLER = '_uiv_scroll_handler';
var events = [EVENTS.RESIZE, EVENTS.SCROLL];

var bind = function bind(el, binding) {
  var callback = binding.value;
  if (!isFunction(callback)) {
    return;
  }
  unbind(el);
  el[HANDLER] = callback;
  events.forEach(function (event) {
    on(window, event, el[HANDLER]);
  });
};

var unbind = function unbind(el) {
  events.forEach(function (event) {
    off(window, event, el[HANDLER]);
  });
  delete el[HANDLER];
};

var update = function update(el, binding) {
  if (binding.value !== binding.oldValue) {
    bind(el, binding);
  }
};

var scroll = { bind: bind, unbind: unbind, update: update };

var Affix = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('div', { staticClass: "hidden-print" }, [_c('div', { directives: [{ name: "scroll", rawName: "v-scroll", value: _vm.onScroll, expression: "onScroll" }], class: _vm.classes, style: _vm.styles }, [_vm._t("default")], 2)]);
  }, staticRenderFns: [],
  directives: {
    scroll: scroll
  },
  props: {
    offset: {
      type: Number,
      default: 0
    }
  },
  data: function data() {
    return {
      affixed: false
    };
  },

  computed: {
    classes: function classes() {
      return {
        affix: this.affixed
      };
    },
    styles: function styles() {
      return {
        top: this.affixed ? this.offset + 'px' : null
      };
    }
  },
  methods: {
    // from https://github.com/ant-design/ant-design/blob/master/components/affix/index.jsx#L20
    onScroll: function onScroll() {
      var _this = this;

      // if is hidden don't calculate anything
      if (!(this.$el.offsetWidth || this.$el.offsetHeight || this.$el.getClientRects().length)) {
        return;
      }
      // get window scroll and element position to detect if have to be normal or affixed
      var scroll$$1 = {};
      var element = {};
      var rect = this.$el.getBoundingClientRect();
      var body = document.body;
      var _arr = ['Top', 'Left'];
      for (var _i = 0; _i < _arr.length; _i++) {
        var type = _arr[_i];
        var t = type.toLowerCase();
        scroll$$1[t] = window['page' + (type === 'Top' ? 'Y' : 'X') + 'Offset'];
        element[t] = scroll$$1[t] + rect[t] - (this.$el['client' + type] || body['client' + type] || 0);
      }
      var fix = scroll$$1.top > element.top - this.offset;
      if (this.affixed !== fix) {
        this.affixed = fix;
        if (this.affixed) {
          this.$emit('affix');
          this.$nextTick(function () {
            _this.$emit('affixed');
          });
        }
      }
    }
  }
};

var Alert = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('div', { class: _vm.alertClass, attrs: { "role": "alert" } }, [_vm.dismissible ? _c('button', { staticClass: "close", attrs: { "type": "button", "aria-label": "Close" }, on: { "click": _vm.closeAlert } }, [_c('span', { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]) : _vm._e(), _vm._v(" "), _vm._t("default")], 2);
  }, staticRenderFns: [],
  props: {
    dismissible: {
      type: Boolean,
      default: false
    },
    duration: {
      type: Number,
      default: 0
    },
    type: {
      type: String,
      default: 'info'
    }
  },
  data: function data() {
    return {
      timeout: 0
    };
  },

  computed: {
    alertClass: function alertClass() {
      var _ref;

      return _ref = {
        'alert': true
      }, defineProperty(_ref, "alert-" + this.type, Boolean(this.type)), defineProperty(_ref, 'alert-dismissible', this.dismissible), _ref;
    }
  },
  methods: {
    closeAlert: function closeAlert() {
      clearTimeout(this.timeout);
      this.$emit('dismissed');
    }
  },
  mounted: function mounted() {
    if (this.duration > 0) {
      this.timeout = setTimeout(this.closeAlert, this.duration);
    }
  },
  destroyed: function destroyed() {
    clearTimeout(this.timeout);
  }
};

var Pagination = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('nav', { class: _vm.navClasses, attrs: { "aria-label": "Page navigation" } }, [_c('ul', { staticClass: "pagination", class: _vm.classes }, [_vm.boundaryLinks ? _c('li', { class: { disabled: _vm.value <= 1 || _vm.disabled } }, [_c('a', { attrs: { "href": "#", "role": "button", "aria-label": "First" }, on: { "click": function click($event) {
          $event.preventDefault();return _vm.onPageChange(1);
        } } }, [_c('span', { attrs: { "aria-hidden": "true" } }, [_vm._v("«")])])]) : _vm._e(), _vm._v(" "), _vm.directionLinks ? _c('li', { class: { disabled: _vm.value <= 1 || _vm.disabled } }, [_c('a', { attrs: { "href": "#", "role": "button", "aria-label": "Previous" }, on: { "click": function click($event) {
          $event.preventDefault();return _vm.onPageChange(_vm.value - 1);
        } } }, [_c('span', { attrs: { "aria-hidden": "true" } }, [_vm._v("‹")])])]) : _vm._e(), _vm._v(" "), _vm.sliceStart > 0 ? _c('li', { class: { disabled: _vm.disabled } }, [_c('a', { attrs: { "href": "#", "role": "button", "aria-label": "Previous group" }, on: { "click": function click($event) {
          $event.preventDefault();return _vm.toPage(1);
        } } }, [_c('span', { attrs: { "aria-hidden": "true" } }, [_vm._v("…")])])]) : _vm._e(), _vm._v(" "), _vm._l(_vm.sliceArray, function (item) {
      return _c('li', { key: item, class: { active: _vm.value === item + 1, disabled: _vm.disabled } }, [_c('a', { attrs: { "href": "#", "role": "button" }, on: { "click": function click($event) {
            $event.preventDefault();return _vm.onPageChange(item + 1);
          } } }, [_vm._v(_vm._s(item + 1))])]);
    }), _vm._v(" "), _vm.sliceStart < _vm.totalPage - _vm.maxSize ? _c('li', { class: { disabled: _vm.disabled } }, [_c('a', { attrs: { "href": "#", "role": "button", "aria-label": "Next group" }, on: { "click": function click($event) {
          $event.preventDefault();return _vm.toPage(0);
        } } }, [_c('span', { attrs: { "aria-hidden": "true" } }, [_vm._v("…")])])]) : _vm._e(), _vm._v(" "), _vm.directionLinks ? _c('li', { class: { disabled: _vm.value >= _vm.totalPage || _vm.disabled } }, [_c('a', { attrs: { "href": "#", "role": "button", "aria-label": "Next" }, on: { "click": function click($event) {
          $event.preventDefault();return _vm.onPageChange(_vm.value + 1);
        } } }, [_c('span', { attrs: { "aria-hidden": "true" } }, [_vm._v("›")])])]) : _vm._e(), _vm._v(" "), _vm.boundaryLinks ? _c('li', { class: { disabled: _vm.value >= _vm.totalPage || _vm.disabled } }, [_c('a', { attrs: { "href": "#", "role": "button", "aria-label": "Last" }, on: { "click": function click($event) {
          $event.preventDefault();return _vm.onPageChange(_vm.totalPage);
        } } }, [_c('span', { attrs: { "aria-hidden": "true" } }, [_vm._v("»")])])]) : _vm._e()], 2)]);
  }, staticRenderFns: [],
  props: {
    value: {
      type: Number,
      required: true,
      validator: function validator(v) {
        return v >= 1;
      }
    },
    boundaryLinks: {
      type: Boolean,
      default: false
    },
    directionLinks: {
      type: Boolean,
      default: true
    },
    size: String,
    align: String,
    totalPage: {
      type: Number,
      required: true,
      validator: function validator(v) {
        return v >= 0;
      }
    },
    maxSize: {
      type: Number,
      default: 5,
      validator: function validator(v) {
        return v >= 0;
      }
    },
    disabled: Boolean
  },
  data: function data() {
    return {
      sliceStart: 0
    };
  },

  computed: {
    navClasses: function navClasses() {
      return defineProperty({}, 'text-' + this.align, Boolean(this.align));
    },
    classes: function classes() {
      return defineProperty({}, 'pagination-' + this.size, Boolean(this.size));
    },
    sliceArray: function sliceArray() {
      return range(this.totalPage).slice(this.sliceStart, this.sliceStart + this.maxSize);
    }
  },
  methods: {
    calculateSliceStart: function calculateSliceStart() {
      var currentPage = this.value;
      var chunkSize = this.maxSize;
      var currentChunkStart = this.sliceStart;
      var currentChunkEnd = currentChunkStart + chunkSize;
      if (currentPage > currentChunkEnd) {
        var lastChunkStart = this.totalPage - chunkSize;
        if (currentPage > lastChunkStart) {
          this.sliceStart = lastChunkStart;
        } else {
          this.sliceStart = currentPage - 1;
        }
      } else if (currentPage < currentChunkStart + 1) {
        if (currentPage > chunkSize) {
          this.sliceStart = currentPage - chunkSize;
        } else {
          this.sliceStart = 0;
        }
      }
    },
    onPageChange: function onPageChange(page) {
      if (!this.disabled && page > 0 && page <= this.totalPage && page !== this.value) {
        this.$emit('input', page);
        this.$emit('change', page);
      }
    },
    toPage: function toPage(pre) {
      if (this.disabled) {
        return;
      }
      var chunkSize = this.maxSize;
      var currentChunkStart = this.sliceStart;
      var lastChunkStart = this.totalPage - chunkSize;
      var start = pre ? currentChunkStart - chunkSize : currentChunkStart + chunkSize;
      if (start < 0) {
        this.sliceStart = 0;
      } else if (start > lastChunkStart) {
        this.sliceStart = lastChunkStart;
      } else {
        this.sliceStart = start;
      }
    }
  },
  created: function created() {
    this.$watch(function (vm) {
      return [vm.value, vm.maxSize, vm.totalPage].join();
    }, this.calculateSliceStart, {
      immediate: true
    });
  }
};

var SHOW_CLASS = 'in';

var popupMixin = {
  props: {
    value: {
      type: Boolean,
      default: false
    },
    tag: {
      type: String,
      default: 'span'
    },
    placement: {
      type: String,
      default: PLACEMENTS.TOP
    },
    autoPlacement: {
      type: Boolean,
      default: true
    },
    appendTo: {
      type: String,
      default: 'body'
    },
    transitionDuration: {
      type: Number,
      default: 150
    },
    hideDelay: {
      type: Number,
      default: 0
    },
    showDelay: {
      type: Number,
      default: 0
    },
    enable: {
      type: Boolean,
      default: true
    },
    enterable: {
      type: Boolean,
      default: true
    },
    target: null,
    viewport: null,
    customClass: String
  },
  data: function data() {
    return {
      triggerEl: null,
      hideTimeoutId: 0,
      showTimeoutId: 0,
      transitionTimeoutId: 0,
      autoTimeoutId: 0
    };
  },

  watch: {
    value: function value(v) {
      v ? this.show() : this.hide();
    },
    trigger: function trigger() {
      this.clearListeners();
      this.initListeners();
    },
    target: function target(value) {
      this.clearListeners();
      this.initTriggerElByTarget(value);
      this.initListeners();
    },
    allContent: function allContent(value) {
      var _this = this;

      // can not use value because it can not detect slot changes
      if (this.isNotEmpty()) {
        // reset position while content changed & is shown
        // nextTick is required
        this.$nextTick(function () {
          if (_this.isShown()) {
            _this.resetPosition();
          }
        });
      } else {
        this.hide();
      }
    },
    enable: function enable(value) {
      // hide if enable changed to false
      if (!value) {
        this.hide();
      }
    }
  },
  mounted: function mounted() {
    var _this2 = this;

    ensureElementMatchesFunction();
    removeFromDom(this.$refs.popup);
    this.$nextTick(function () {
      _this2.initTriggerElByTarget(_this2.target);
      _this2.initListeners();
      if (_this2.value) {
        _this2.show();
      }
    });
  },
  beforeDestroy: function beforeDestroy() {
    this.clearListeners();
    removeFromDom(this.$refs.popup);
  },

  methods: {
    initTriggerElByTarget: function initTriggerElByTarget(target) {
      if (target) {
        // target exist
        if (isString(target)) {
          // is selector
          this.triggerEl = document.querySelector(target);
        } else if (isElement(target)) {
          // is element
          this.triggerEl = target;
        } else if (isElement(target.$el)) {
          // is component
          this.triggerEl = target.$el;
        }
      } else {
        // find special element
        var trigger = this.$el.querySelector('[data-role="trigger"]');
        if (trigger) {
          this.triggerEl = trigger;
        } else {
          // use the first child
          var firstChild = this.$el.firstChild;
          this.triggerEl = firstChild === this.$refs.popup ? null : firstChild;
        }
      }
    },
    initListeners: function initListeners() {
      if (this.triggerEl) {
        if (this.trigger === TRIGGERS.HOVER) {
          on(this.triggerEl, EVENTS.MOUSE_ENTER, this.show);
          on(this.triggerEl, EVENTS.MOUSE_LEAVE, this.hide);
        } else if (this.trigger === TRIGGERS.FOCUS) {
          on(this.triggerEl, EVENTS.FOCUS, this.show);
          on(this.triggerEl, EVENTS.BLUR, this.hide);
        } else if (this.trigger === TRIGGERS.HOVER_FOCUS) {
          on(this.triggerEl, EVENTS.MOUSE_ENTER, this.handleAuto);
          on(this.triggerEl, EVENTS.MOUSE_LEAVE, this.handleAuto);
          on(this.triggerEl, EVENTS.FOCUS, this.handleAuto);
          on(this.triggerEl, EVENTS.BLUR, this.handleAuto);
        } else if (this.trigger === TRIGGERS.CLICK || this.trigger === TRIGGERS.OUTSIDE_CLICK) {
          on(this.triggerEl, EVENTS.CLICK, this.toggle);
        }
      }
      on(window, EVENTS.CLICK, this.windowClicked);
    },
    clearListeners: function clearListeners() {
      if (this.triggerEl) {
        off(this.triggerEl, EVENTS.FOCUS, this.show);
        off(this.triggerEl, EVENTS.BLUR, this.hide);
        off(this.triggerEl, EVENTS.MOUSE_ENTER, this.show);
        off(this.triggerEl, EVENTS.MOUSE_LEAVE, this.hide);
        off(this.triggerEl, EVENTS.CLICK, this.toggle);
        off(this.triggerEl, EVENTS.MOUSE_ENTER, this.handleAuto);
        off(this.triggerEl, EVENTS.MOUSE_LEAVE, this.handleAuto);
        off(this.triggerEl, EVENTS.FOCUS, this.handleAuto);
        off(this.triggerEl, EVENTS.BLUR, this.handleAuto);
      }
      off(window, EVENTS.CLICK, this.windowClicked);
      this.clearTimeouts();
    },
    clearTimeouts: function clearTimeouts() {
      if (this.hideTimeoutId) {
        clearTimeout(this.hideTimeoutId);
        this.hideTimeoutId = 0;
      }
      if (this.showTimeoutId) {
        clearTimeout(this.showTimeoutId);
        this.showTimeoutId = 0;
      }
      if (this.transitionTimeoutId) {
        clearTimeout(this.transitionTimeoutId);
        this.transitionTimeoutId = 0;
      }
      if (this.autoTimeoutId) {
        clearTimeout(this.autoTimeoutId);
        this.autoTimeoutId = 0;
      }
    },
    resetPosition: function resetPosition() {
      var popup = this.$refs.popup;
      if (popup) {
        setTooltipPosition(popup, this.triggerEl, this.placement, this.autoPlacement, this.appendTo, this.viewport);
        popup.offsetHeight;
      }
    },
    hideOnLeave: function hideOnLeave() {
      if (this.trigger === TRIGGERS.HOVER || this.trigger === TRIGGERS.HOVER_FOCUS && !this.triggerEl.matches(':focus')) {
        this.$hide();
      }
    },
    toggle: function toggle() {
      if (this.isShown()) {
        this.hide();
      } else {
        this.show();
      }
    },
    show: function show() {
      var _this3 = this;

      if (this.enable && this.triggerEl && this.isNotEmpty() && !this.isShown()) {
        var popUpAppendedContainer = this.hideTimeoutId > 0; // weird condition
        if (popUpAppendedContainer) {
          clearTimeout(this.hideTimeoutId);
          this.hideTimeoutId = 0;
        }
        if (this.transitionTimeoutId > 0) {
          clearTimeout(this.transitionTimeoutId);
          this.transitionTimeoutId = 0;
        }
        clearTimeout(this.showTimeoutId);
        this.showTimeoutId = setTimeout(function () {
          _this3.showTimeoutId = 0;
          var popup = _this3.$refs.popup;
          if (popup) {
            // add to dom
            if (!popUpAppendedContainer) {
              popup.className = _this3.name + ' ' + _this3.placement + ' ' + (_this3.customClass ? _this3.customClass : '') + ' fade';
              var container = document.querySelector(_this3.appendTo);
              container.appendChild(popup);
              _this3.resetPosition();
            }
            addClass(popup, SHOW_CLASS);
            _this3.$emit('input', true);
            _this3.$emit('show');
          }
        }, this.showDelay);
      }
    },
    hide: function hide() {
      var _this4 = this;

      if (this.showTimeoutId > 0) {
        clearTimeout(this.showTimeoutId);
        this.showTimeoutId = 0;
      }

      if (!this.isShown()) {
        return;
      }
      if (this.enterable && (this.trigger === TRIGGERS.HOVER || this.trigger === TRIGGERS.HOVER_FOCUS)) {
        clearTimeout(this.hideTimeoutId);
        this.hideTimeoutId = setTimeout(function () {
          _this4.hideTimeoutId = 0;
          var popup = _this4.$refs.popup;
          if (popup && !popup.matches(':hover')) {
            _this4.$hide();
          }
        }, 100);
      } else {
        this.$hide();
      }
    },
    $hide: function $hide() {
      var _this5 = this;

      if (this.isShown()) {
        clearTimeout(this.hideTimeoutId);
        this.hideTimeoutId = setTimeout(function () {
          _this5.hideTimeoutId = 0;
          removeClass(_this5.$refs.popup, SHOW_CLASS);
          // gives fade out time
          _this5.transitionTimeoutId = setTimeout(function () {
            _this5.transitionTimeoutId = 0;
            removeFromDom(_this5.$refs.popup);
            _this5.$emit('input', false);
            _this5.$emit('hide');
          }, _this5.transitionDuration);
        }, this.hideDelay);
      }
    },
    isShown: function isShown() {
      return hasClass(this.$refs.popup, SHOW_CLASS);
    },
    windowClicked: function windowClicked(event) {
      if (this.triggerEl && isFunction(this.triggerEl.contains) && !this.triggerEl.contains(event.target) && this.trigger === TRIGGERS.OUTSIDE_CLICK && !(this.$refs.popup && this.$refs.popup.contains(event.target)) && this.isShown()) {
        this.hide();
      }
    },
    handleAuto: function handleAuto() {
      var _this6 = this;

      clearTimeout(this.autoTimeoutId);
      this.autoTimeoutId = setTimeout(function () {
        _this6.autoTimeoutId = 0;
        if (_this6.triggerEl.matches(':hover, :focus')) {
          _this6.show();
        } else {
          _this6.hide();
        }
      }, 20); // 20ms make firefox happy
    }
  }
};

var Tooltip = {
  mixins: [popupMixin],
  data: function data() {
    return {
      name: 'tooltip'
    };
  },
  render: function render(h) {
    return h(this.tag, [this.$slots.default, h('div', {
      ref: 'popup',
      attrs: {
        role: 'tooltip'
      },
      on: {
        mouseleave: this.hideOnLeave
      }
    }, [h('div', { 'class': 'tooltip-arrow' }), h('div', {
      'class': 'tooltip-inner',
      domProps: { innerHTML: this.text }
    })])]);
  },

  props: {
    text: {
      type: String,
      default: ''
    },
    trigger: {
      type: String,
      default: TRIGGERS.HOVER_FOCUS
    }
  },
  computed: {
    allContent: function allContent() {
      return this.text;
    }
  },
  methods: {
    isNotEmpty: function isNotEmpty() {
      return this.text;
    }
  }
};

var Popover = {
  mixins: [popupMixin],
  data: function data() {
    return {
      name: 'popover'
    };
  },
  render: function render(h) {
    return h(this.tag, [this.$slots.default, h('div', {
      style: {
        display: 'block'
      },
      ref: 'popup',
      on: {
        mouseleave: this.hideOnLeave
      }
    }, [h('div', { 'class': 'arrow' }), h('h3', {
      'class': 'popover-title',
      directives: [{ name: 'show', value: this.title }]
    }, this.title), h('div', { 'class': 'popover-content' }, [this.content || this.$slots.popover])])]);
  },

  props: {
    title: {
      type: String,
      default: ''
    },
    content: {
      type: String,
      default: ''
    },
    trigger: {
      type: String,
      default: TRIGGERS.OUTSIDE_CLICK
    }
  },
  computed: {
    allContent: function allContent() {
      return this.title + this.content;
    }
  },
  methods: {
    isNotEmpty: function isNotEmpty() {
      return this.title || this.content || this.$slots.popover;
    }
  }
};

var maxHours = 23;
var zero = 0;
var maxMinutes = 59;
var cutUpAmAndPm = 12;

var TimePicker = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('section', { on: { "click": function click($event) {
          $event.stopPropagation();
        } } }, [_c('table', [_c('tbody', [_vm.controls ? _c('tr', { staticClass: "text-center" }, [_c('td', [_c('btn', { attrs: { "type": "link", "size": "sm", "disabled": _vm.readonly }, on: { "click": function click($event) {
          return _vm.changeTime(1, 1);
        } } }, [_c('i', { class: _vm.iconControlUp })])], 1), _vm._v(" "), _c('td', [_vm._v(" ")]), _vm._v(" "), _c('td', [_c('btn', { attrs: { "type": "link", "size": "sm", "disabled": _vm.readonly }, on: { "click": function click($event) {
          return _vm.changeTime(0, 1);
        } } }, [_c('i', { class: _vm.iconControlUp })])], 1), _vm._v(" "), _vm.showMeridian ? _c('td') : _vm._e()]) : _vm._e(), _vm._v(" "), _c('tr', [_c('td', { staticClass: "form-group" }, [_c('input', { directives: [{ name: "model", rawName: "v-model.lazy", value: _vm.hoursText, expression: "hoursText", modifiers: { "lazy": true } }], ref: "hoursInput", staticClass: "form-control text-center", style: _vm.inputStyles, attrs: { "type": "tel", "pattern": "\\d*", "placeholder": "HH", "readonly": _vm.readonly, "maxlength": "2", "size": "2" }, domProps: { "value": _vm.hoursText }, on: { "mouseup": _vm.selectInputValue, "keydown": [function ($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "up", 38, $event.key, ["Up", "ArrowUp"])) {
            return null;
          }$event.preventDefault();return _vm.changeTime(1, 1);
        }, function ($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "down", 40, $event.key, ["Down", "ArrowDown"])) {
            return null;
          }$event.preventDefault();return _vm.changeTime(1, 0);
        }], "wheel": function wheel($event) {
          return _vm.onWheel($event, true);
        }, "change": function change($event) {
          _vm.hoursText = $event.target.value;
        } } })]), _vm._v(" "), _vm._m(0), _vm._v(" "), _c('td', { staticClass: "form-group" }, [_c('input', { directives: [{ name: "model", rawName: "v-model.lazy", value: _vm.minutesText, expression: "minutesText", modifiers: { "lazy": true } }], ref: "minutesInput", staticClass: "form-control text-center", style: _vm.inputStyles, attrs: { "type": "tel", "pattern": "\\d*", "placeholder": "MM", "readonly": _vm.readonly, "maxlength": "2", "size": "2" }, domProps: { "value": _vm.minutesText }, on: { "mouseup": _vm.selectInputValue, "keydown": [function ($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "up", 38, $event.key, ["Up", "ArrowUp"])) {
            return null;
          }$event.preventDefault();return _vm.changeTime(0, 1);
        }, function ($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "down", 40, $event.key, ["Down", "ArrowDown"])) {
            return null;
          }$event.preventDefault();return _vm.changeTime(0, 0);
        }], "wheel": function wheel($event) {
          return _vm.onWheel($event, false);
        }, "change": function change($event) {
          _vm.minutesText = $event.target.value;
        } } })]), _vm._v(" "), _vm.showMeridian ? _c('td', [_vm._v("   "), _c('btn', { attrs: { "data-action": "toggleMeridian", "disabled": _vm.readonly }, domProps: { "textContent": _vm._s(_vm.meridian ? _vm.t('uiv.timePicker.am') : _vm.t('uiv.timePicker.pm')) }, on: { "click": _vm.toggleMeridian } })], 1) : _vm._e()]), _vm._v(" "), _vm.controls ? _c('tr', { staticClass: "text-center" }, [_c('td', [_c('btn', { attrs: { "type": "link", "size": "sm", "disabled": _vm.readonly }, on: { "click": function click($event) {
          return _vm.changeTime(1, 0);
        } } }, [_c('i', { class: _vm.iconControlDown })])], 1), _vm._v(" "), _c('td', [_vm._v(" ")]), _vm._v(" "), _c('td', [_c('btn', { attrs: { "type": "link", "size": "sm", "disabled": _vm.readonly }, on: { "click": function click($event) {
          return _vm.changeTime(0, 0);
        } } }, [_c('i', { class: _vm.iconControlDown })])], 1), _vm._v(" "), _vm.showMeridian ? _c('td') : _vm._e()]) : _vm._e()])])]);
  }, staticRenderFns: [function () {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('td', [_vm._v(" "), _c('b', [_vm._v(":")]), _vm._v(" ")]);
  }],
  components: { Btn: Btn },
  mixins: [Local],
  props: {
    value: {
      type: Date,
      required: true
    },
    showMeridian: {
      type: Boolean,
      default: true
    },
    min: Date,
    max: Date,
    hourStep: {
      type: Number,
      default: 1
    },
    minStep: {
      type: Number,
      default: 1
    },
    readonly: {
      type: Boolean,
      default: false
    },
    controls: {
      type: Boolean,
      default: true
    },
    iconControlUp: {
      type: String,
      default: 'glyphicon glyphicon-chevron-up'
    },
    iconControlDown: {
      type: String,
      default: 'glyphicon glyphicon-chevron-down'
    },
    inputWidth: {
      type: Number,
      default: 50
    }
  },
  data: function data() {
    return {
      hours: 0,
      minutes: 0,
      meridian: true,
      hoursText: '',
      minutesText: ''
    };
  },
  mounted: function mounted() {
    this.updateByValue(this.value);
  },

  computed: {
    inputStyles: function inputStyles() {
      return {
        width: this.inputWidth + 'px'
      };
    }
  },
  watch: {
    value: function value(_value) {
      this.updateByValue(_value);
    },
    showMeridian: function showMeridian(value) {
      this.setTime();
    },
    hoursText: function hoursText(value) {
      if (this.hours === 0 && value === '') {
        // Prevent a runtime reset from being overwritten
        return;
      }
      var hour = parseInt(value);
      if (this.showMeridian) {
        if (hour >= 1 && hour <= cutUpAmAndPm) {
          if (this.meridian) {
            this.hours = hour === cutUpAmAndPm ? 0 : hour;
          } else {
            this.hours = hour === cutUpAmAndPm ? cutUpAmAndPm : hour + cutUpAmAndPm;
          }
        }
      } else if (hour >= zero && hour <= maxHours) {
        this.hours = hour;
      }
      this.setTime();
    },
    minutesText: function minutesText(value) {
      if (this.minutes === 0 && value === '') {
        // Prevent a runtime reset from being overwritten
        return;
      }
      var minutesStr = parseInt(value);
      if (minutesStr >= zero && minutesStr <= maxMinutes) {
        this.minutes = minutesStr;
      }
      this.setTime();
    }
  },
  methods: {
    updateByValue: function updateByValue(value) {
      if (isNaN(value.getTime())) {
        this.hours = 0;
        this.minutes = 0;
        this.hoursText = '';
        this.minutesText = '';
        this.meridian = true;
        return;
      }
      this.hours = value.getHours();
      this.minutes = value.getMinutes();
      if (!this.showMeridian) {
        this.hoursText = pad(this.hours, 2);
      } else {
        if (this.hours >= cutUpAmAndPm) {
          if (this.hours === cutUpAmAndPm) {
            this.hoursText = this.hours + '';
          } else {
            this.hoursText = pad(this.hours - cutUpAmAndPm, 2);
          }
          this.meridian = false;
        } else {
          if (this.hours === zero) {
            this.hoursText = cutUpAmAndPm.toString();
          } else {
            this.hoursText = pad(this.hours, 2);
          }
          this.meridian = true;
        }
      }
      this.minutesText = pad(this.minutes, 2);
      // lazy model won't update when using keyboard up/down
      this.$refs.hoursInput.value = this.hoursText;
      this.$refs.minutesInput.value = this.minutesText;
    },
    addHour: function addHour(step) {
      step = step || this.hourStep;
      this.hours = this.hours >= maxHours ? zero : this.hours + step;
    },
    reduceHour: function reduceHour(step) {
      step = step || this.hourStep;
      this.hours = this.hours <= zero ? maxHours : this.hours - step;
    },
    addMinute: function addMinute() {
      if (this.minutes >= maxMinutes) {
        this.minutes = zero;
        this.addHour(1);
      } else {
        this.minutes += this.minStep;
      }
    },
    reduceMinute: function reduceMinute() {
      if (this.minutes <= zero) {
        this.minutes = maxMinutes + 1 - this.minStep;
        this.reduceHour(1);
      } else {
        this.minutes -= this.minStep;
      }
    },
    changeTime: function changeTime(isHour, isPlus) {
      if (!this.readonly) {
        if (isHour && isPlus) {
          this.addHour();
        } else if (isHour && !isPlus) {
          this.reduceHour();
        } else if (!isHour && isPlus) {
          this.addMinute();
        } else {
          this.reduceMinute();
        }
        this.setTime();
      }
    },
    toggleMeridian: function toggleMeridian() {
      this.meridian = !this.meridian;
      if (this.meridian) {
        this.hours -= cutUpAmAndPm;
      } else {
        this.hours += cutUpAmAndPm;
      }
      this.setTime();
    },
    onWheel: function onWheel(e, isHour) {
      if (!this.readonly) {
        e.preventDefault();
        this.changeTime(isHour, e.deltaY < 0);
      }
    },
    setTime: function setTime() {
      var time = this.value;
      if (isNaN(time.getTime())) {
        time = new Date();
        time.setHours(0);
        time.setMinutes(0);
      }
      time.setHours(this.hours);
      time.setMinutes(this.minutes);
      if (this.max) {
        var max = new Date(time);
        max.setHours(this.max.getHours());
        max.setMinutes(this.max.getMinutes());
        time = time > max ? max : time;
      }
      if (this.min) {
        var min = new Date(time);
        min.setHours(this.min.getHours());
        min.setMinutes(this.min.getMinutes());
        time = time < min ? min : time;
      }
      this.$emit('input', new Date(time));
    },
    selectInputValue: function selectInputValue(e) {
      // mouseup should be prevented!
      // See various comments in https://stackoverflow.com/questions/3272089/programmatically-selecting-text-in-an-input-field-on-ios-devices-mobile-safari
      e.target.setSelectionRange(0, 2);
    }
  }
};

function getRequest(url) {
  var request = new window.XMLHttpRequest();
  var data = {};
  var p = {
    then: function then(fn1, fn2) {
      return p.done(fn1).fail(fn2);
    },
    catch: function _catch(fn) {
      return p.fail(fn);
    },
    always: function always(fn) {
      return p.done(fn).fail(fn);
    }
  };
  var statuses = ['done', 'fail'];
  statuses.forEach(function (name) {
    data[name] = [];
    p[name] = function (fn) {
      if (fn instanceof Function) data[name].push(fn);
      return p;
    };
  });
  p.done(JSON.parse);
  request.onreadystatechange = function () {
    if (request.readyState === 4) {
      var e = { status: request.status };
      if (request.status === 200) {
        var response = request.responseText;
        for (var i in data.done) {
          if (data.done.hasOwnProperty(i) && isFunction(data.done[i])) {
            var value = data.done[i](response);
            if (isExist(value)) {
              response = value;
            }
          }
        }
      } else {
        data.fail.forEach(function (fail) {
          return fail(e);
        });
      }
    }
  };
  request.open('GET', url);
  request.setRequestHeader('Accept', 'application/json');
  request.send();
  return p;
}

var Typeahead = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('dropdown', { ref: "dropdown", attrs: { "tag": "section", "append-to-body": _vm.appendToBody, "not-close-elements": _vm.elements, "position-element": _vm.inputEl }, model: { value: _vm.open, callback: function callback($$v) {
          _vm.open = $$v;
        }, expression: "open" } }, [_c('template', { slot: "dropdown" }, [_vm._t("item", _vm._l(_vm.items, function (item, index) {
      return _c('li', { class: { active: _vm.activeIndex === index } }, [_c('a', { attrs: { "href": "#" }, on: { "click": function click($event) {
            $event.preventDefault();return _vm.selectItem(item);
          } } }, [_c('span', { domProps: { "innerHTML": _vm._s(_vm.highlight(item)) } })])]);
    }), { "items": _vm.items, "activeIndex": _vm.activeIndex, "select": _vm.selectItem, "highlight": _vm.highlight }), _vm._v(" "), !_vm.items || _vm.items.length === 0 ? _vm._t("empty") : _vm._e()], 2)], 2);
  }, staticRenderFns: [],
  components: { Dropdown: Dropdown },
  props: {
    value: {
      required: true
    },
    data: Array,
    itemKey: String,
    appendToBody: {
      type: Boolean,
      default: false
    },
    ignoreCase: {
      type: Boolean,
      default: true
    },
    matchStart: {
      type: Boolean,
      default: false
    },
    forceSelect: {
      type: Boolean,
      default: false
    },
    forceClear: {
      type: Boolean,
      default: false
    },
    limit: {
      type: Number,
      default: 10
    },
    asyncSrc: String,
    asyncKey: String,
    asyncFunction: Function,
    debounce: {
      type: Number,
      default: 200
    },
    openOnFocus: {
      type: Boolean,
      default: true
    },
    openOnEmpty: {
      type: Boolean,
      default: false
    },
    target: {
      required: true
    },
    preselect: {
      type: Boolean,
      default: true
    }
  },
  data: function data() {
    return {
      inputEl: null,
      items: [],
      activeIndex: 0,
      timeoutID: 0,
      elements: [],
      open: false,
      dropdownMenuEl: null
    };
  },

  computed: {
    regexOptions: function regexOptions() {
      var options = '';
      if (this.ignoreCase) {
        options += 'i';
      }
      if (!this.matchStart) {
        options += 'g';
      }
      return options;
    }
  },
  mounted: function mounted() {
    var _this = this;

    ensureElementMatchesFunction();
    this.$nextTick(function () {
      _this.initInputElByTarget(_this.target);
      _this.initListeners();
      _this.dropdownMenuEl = _this.$refs.dropdown.$el.querySelector('.dropdown-menu');
      // set input text if v-model not empty
      if (_this.value) {
        _this.setInputTextByValue(_this.value);
      }
    });
  },
  beforeDestroy: function beforeDestroy() {
    this.removeListeners();
  },

  watch: {
    target: function target(el) {
      this.removeListeners();
      this.initInputElByTarget(el);
      this.initListeners();
    },
    value: function value(_value) {
      this.setInputTextByValue(_value);
    }
  },
  methods: {
    setInputTextByValue: function setInputTextByValue(value) {
      if (isString(value)) {
        // direct
        this.inputEl.value = value;
      } else if (value) {
        // is object
        this.inputEl.value = this.itemKey ? value[this.itemKey] : value;
      } else if (value === null) {
        // is null or undefined or something else not valid
        this.inputEl.value = '';
      }
    },
    hasEmptySlot: function hasEmptySlot() {
      return !!this.$slots['empty'] || !!this.$scopedSlots['empty'];
    },
    initInputElByTarget: function initInputElByTarget(target) {
      if (!target) {
        return;
      }
      if (isString(target)) {
        // is selector
        this.inputEl = document.querySelector(target);
      } else if (isElement(target)) {
        // is element
        this.inputEl = target;
      } else if (isElement(target.$el)) {
        // is component
        this.inputEl = target.$el;
      }
    },
    initListeners: function initListeners() {
      if (this.inputEl) {
        this.elements = [this.inputEl];
        on(this.inputEl, EVENTS.FOCUS, this.inputFocused);
        on(this.inputEl, EVENTS.BLUR, this.inputBlured);
        on(this.inputEl, EVENTS.INPUT, this.inputChanged);
        on(this.inputEl, EVENTS.KEY_DOWN, this.inputKeyPressed);
      }
    },
    removeListeners: function removeListeners() {
      this.elements = [];
      if (this.inputEl) {
        off(this.inputEl, EVENTS.FOCUS, this.inputFocused);
        off(this.inputEl, EVENTS.BLUR, this.inputBlured);
        off(this.inputEl, EVENTS.INPUT, this.inputChanged);
        off(this.inputEl, EVENTS.KEY_DOWN, this.inputKeyPressed);
      }
    },
    prepareItems: function prepareItems(data) {
      var disableFilters = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

      if (disableFilters) {
        this.items = data.slice(0, this.limit);
        return;
      }
      this.items = [];
      this.activeIndex = this.preselect ? 0 : -1;
      for (var i = 0, l = data.length; i < l; i++) {
        var item = data[i];
        var key = this.itemKey ? item[this.itemKey] : item;
        key = key.toString();
        var index = -1;
        if (this.ignoreCase) {
          index = key.toLowerCase().indexOf(this.inputEl.value.toLowerCase());
        } else {
          index = key.indexOf(this.inputEl.value);
        }
        if (this.matchStart ? index === 0 : index >= 0) {
          this.items.push(item);
        }
        if (this.items.length >= this.limit) {
          break;
        }
      }
    },
    fetchItems: function fetchItems(value, debounce) {
      var _this2 = this;

      clearTimeout(this.timeoutID);
      if (value === '' && !this.openOnEmpty) {
        this.open = false;
      } else if (this.data) {
        this.prepareItems(this.data);
        this.open = this.hasEmptySlot() || Boolean(this.items.length);
      } else if (this.asyncSrc) {
        this.timeoutID = setTimeout(function () {
          _this2.$emit('loading');
          getRequest(_this2.asyncSrc + encodeURIComponent(value)).then(function (data) {
            if (_this2.inputEl.matches(':focus')) {
              _this2.prepareItems(_this2.asyncKey ? data[_this2.asyncKey] : data, true);
              _this2.open = _this2.hasEmptySlot() || Boolean(_this2.items.length);
            }
            _this2.$emit('loaded');
          }).catch(function (err) {
            console.error(err);
            _this2.$emit('loaded-error');
          });
        }, debounce);
      } else if (this.asyncFunction) {
        var cb = function cb(data) {
          if (_this2.inputEl.matches(':focus')) {
            _this2.prepareItems(data, true);
            _this2.open = _this2.hasEmptySlot() || Boolean(_this2.items.length);
          }
          _this2.$emit('loaded');
        };
        this.timeoutID = setTimeout(function () {
          _this2.$emit('loading');
          _this2.asyncFunction(value, cb);
        }, debounce);
      }
    },
    inputChanged: function inputChanged() {
      var value = this.inputEl.value;
      this.fetchItems(value, this.debounce);
      this.$emit('input', this.forceSelect ? undefined : value);
    },
    inputFocused: function inputFocused() {
      if (this.openOnFocus) {
        var value = this.inputEl.value;
        this.fetchItems(value, 0);
      }
    },
    inputBlured: function inputBlured() {
      var _this3 = this;

      if (!this.dropdownMenuEl.matches(':hover')) {
        this.open = false;
      }
      if (this.inputEl && this.forceClear) {
        this.$nextTick(function () {
          if (typeof _this3.value === 'undefined') {
            _this3.inputEl.value = '';
          }
        });
      }
    },
    inputKeyPressed: function inputKeyPressed(event) {
      event.stopPropagation();
      if (this.open) {
        switch (event.keyCode) {
          case 13:
            if (this.activeIndex >= 0) {
              this.selectItem(this.items[this.activeIndex]);
            } else {
              this.open = false;
            }
            event.preventDefault();
            break;
          case 27:
            this.open = false;
            break;
          case 38:
            this.activeIndex = this.activeIndex > 0 ? this.activeIndex - 1 : 0;
            break;
          case 40:
            var maxIndex = this.items.length - 1;
            this.activeIndex = this.activeIndex < maxIndex ? this.activeIndex + 1 : maxIndex;
            break;
        }
      }
    },
    selectItem: function selectItem(item) {
      this.$emit('input', item);
      this.open = false;
    },
    highlight: function highlight(item) {
      var value = this.itemKey ? item[this.itemKey] : item;
      var inputValue = this.inputEl.value.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&');
      return value.replace(new RegExp('' + inputValue, this.regexOptions), '<b>$&</b>');
    }
  }
};

var ProgressBarStack = {
  functional: true,
  render: function render(h, _ref) {
    var props = _ref.props,
        data = _ref.data;

    return h('div', mergeData(data, {
      class: defineProperty({
        'progress-bar': true,
        'progress-bar-striped': props.striped,
        'active': props.striped && props.active
      }, 'progress-bar-' + props.type, Boolean(props.type)),
      style: {
        minWidth: props.minWidth ? '2em' : null,
        width: props.value + '%'
      },
      attrs: {
        role: 'progressbar',
        'aria-valuemin': 0,
        'aria-valuenow': props.value,
        'aria-valuemax': 100
      }
    }), props.label ? props.labelText ? props.labelText : props.value + '%' : null);
  },

  props: {
    value: {
      type: Number,
      required: true,
      validator: function validator(value) {
        return value >= 0 && value <= 100;
      }
    },
    labelText: String,
    type: String,
    label: {
      type: Boolean,
      default: false
    },
    minWidth: {
      type: Boolean,
      default: false
    },
    striped: {
      type: Boolean,
      default: false
    },
    active: {
      type: Boolean,
      default: false
    }
  }
};

var ProgressBar = {
  functional: true,
  render: function render(h, _ref) {
    var props = _ref.props,
        data = _ref.data,
        children = _ref.children;

    return h('div', mergeData(data, { class: 'progress' }), children && children.length ? children : [h(ProgressBarStack, { props: props })]);
  }
};

var BreadcrumbItem = {
  functional: true,
  mixins: [linkMixin],
  render: function render(h, _ref) {
    var props = _ref.props,
        data = _ref.data,
        children = _ref.children;

    var slot = void 0;
    if (props.active) {
      slot = children;
    } else if (props.to) {
      slot = [h('router-link', {
        props: {
          to: props.to,
          replace: props.replace,
          append: props.append,
          exact: props.exact
        }
      }, children)];
    } else {
      slot = [h('a', {
        attrs: {
          href: props.href,
          target: props.target
        }
      }, children)];
    }
    return h('li', mergeData(data, { class: { active: props.active } }), slot);
  },

  props: {
    active: {
      type: Boolean,
      default: false
    }
  }
};

var Breadcrumbs = {
  functional: true,
  render: function render(h, _ref) {
    var props = _ref.props,
        data = _ref.data,
        children = _ref.children;

    var slot = [];
    if (children && children.length) {
      slot = children;
    } else if (props.items) {
      slot = props.items.map(function (item, index) {
        return h(BreadcrumbItem, {
          key: item.hasOwnProperty('key') ? item.key : index,
          props: {
            active: item.hasOwnProperty('active') ? item.active : index === props.items.length - 1,
            href: item.href,
            target: item.target,
            to: item.to,
            replace: item.replace,
            append: item.append,
            exact: item.exact
          }
        }, item.text);
      });
    }
    return h('ol', mergeData(data, { class: 'breadcrumb' }), slot);
  },

  props: {
    items: Array
  }
};

var BtnToolbar = {
  functional: true,
  render: function render(h, _ref) {
    var children = _ref.children,
        data = _ref.data;

    return h('div', mergeData(data, {
      class: {
        'btn-toolbar': true
      },
      attrs: {
        role: 'toolbar'
      }
    }), children);
  }
};

var MultiSelect = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('dropdown', { ref: "dropdown", style: _vm.containerStyles, attrs: { "not-close-elements": _vm.els, "append-to-body": _vm.appendToBody, "disabled": _vm.disabled }, nativeOn: { "keydown": function keydown($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "esc", 27, $event.key, ["Esc", "Escape"])) {
            return null;
          }_vm.showDropdown = false;
        } }, model: { value: _vm.showDropdown, callback: function callback($$v) {
          _vm.showDropdown = $$v;
        }, expression: "showDropdown" } }, [_c('div', { staticClass: "form-control dropdown-toggle clearfix", class: _vm.selectClasses, attrs: { "disabled": _vm.disabled, "tabindex": "0", "data-role": "trigger" }, on: { "focus": function focus($event) {
          return _vm.$emit('focus', $event);
        }, "blur": function blur($event) {
          return _vm.$emit('blur', $event);
        }, "keydown": [function ($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "down", 40, $event.key, ["Down", "ArrowDown"])) {
            return null;
          }$event.preventDefault();$event.stopPropagation();return _vm.goNextOption($event);
        }, function ($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "up", 38, $event.key, ["Up", "ArrowUp"])) {
            return null;
          }$event.preventDefault();$event.stopPropagation();return _vm.goPrevOption($event);
        }, function ($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) {
            return null;
          }$event.preventDefault();$event.stopPropagation();return _vm.selectOption($event);
        }] } }, [_c('div', { class: _vm.selectTextClasses, staticStyle: { "display": "inline-block", "vertical-align": "middle" } }, [_vm._v(_vm._s(_vm.selectedText))]), _vm._v(" "), _c('div', { staticClass: "pull-right", staticStyle: { "display": "inline-block", "vertical-align": "middle" } }, [_c('span', [_vm._v(" ")]), _vm._v(" "), _c('span', { staticClass: "caret" })])]), _vm._v(" "), _c('template', { slot: "dropdown" }, [_vm.filterable ? _c('li', { staticStyle: { "padding": "4px 8px" } }, [_c('input', { directives: [{ name: "model", rawName: "v-model", value: _vm.filterInput, expression: "filterInput" }], ref: "filterInput", staticClass: "form-control input-sm", attrs: { "aria-label": "Filter...", "type": "text", "placeholder": _vm.filterPlaceholder || _vm.t('uiv.multiSelect.filterPlaceholder') }, domProps: { "value": _vm.filterInput }, on: { "keydown": [function ($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "down", 40, $event.key, ["Down", "ArrowDown"])) {
            return null;
          }$event.preventDefault();$event.stopPropagation();return _vm.goNextOption($event);
        }, function ($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "up", 38, $event.key, ["Up", "ArrowUp"])) {
            return null;
          }$event.preventDefault();$event.stopPropagation();return _vm.goPrevOption($event);
        }, function ($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) {
            return null;
          }$event.preventDefault();$event.stopPropagation();return _vm.selectOption($event);
        }], "input": function input($event) {
          if ($event.target.composing) {
            return;
          }_vm.filterInput = $event.target.value;
        } } })]) : _vm._e(), _vm._v(" "), _vm._l(_vm.groupedOptions, function (item) {
      return [item.$group ? _c('li', { staticClass: "dropdown-header", domProps: { "textContent": _vm._s(item.$group) } }) : _vm._e(), _vm._v(" "), _vm._l(item.options, function (_item) {
        return [_c('li', { class: _vm.itemClasses(_item), staticStyle: { "outline": "0" }, on: { "keydown": [function ($event) {
              if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "down", 40, $event.key, ["Down", "ArrowDown"])) {
                return null;
              }$event.preventDefault();$event.stopPropagation();return _vm.goNextOption($event);
            }, function ($event) {
              if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "up", 38, $event.key, ["Up", "ArrowUp"])) {
                return null;
              }$event.preventDefault();$event.stopPropagation();return _vm.goPrevOption($event);
            }, function ($event) {
              if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) {
                return null;
              }$event.preventDefault();$event.stopPropagation();return _vm.selectOption($event);
            }], "click": function click($event) {
              $event.stopPropagation();return _vm.toggle(_item);
            }, "mouseenter": function mouseenter($event) {
              _vm.currentActive = -1;
            } } }, [_vm.isItemSelected(_item) ? _c('a', { staticStyle: { "outline": "0" }, attrs: { "role": "button" } }, [_c('b', [_vm._v(_vm._s(_item[_vm.labelKey]))]), _vm._v(" "), _vm.selectedIcon ? _c('span', { class: _vm.selectedIconClasses }) : _vm._e()]) : _c('a', { staticStyle: { "outline": "0" }, attrs: { "role": "button" } }, [_c('span', [_vm._v(_vm._s(_item[_vm.labelKey]))])])])];
      })];
    })], 2)], 2);
  }, staticRenderFns: [],
  mixins: [Local],
  components: { Dropdown: Dropdown },
  props: {
    value: {
      type: Array,
      required: true
    },
    options: {
      type: Array,
      required: true
    },
    labelKey: {
      type: String,
      default: 'label'
    },
    valueKey: {
      type: String,
      default: 'value'
    },
    limit: {
      type: Number,
      default: 0
    },
    size: String,
    placeholder: String,
    split: {
      type: String,
      default: ', '
    },
    disabled: {
      type: Boolean,
      default: false
    },
    appendToBody: {
      type: Boolean,
      default: false
    },
    block: {
      type: Boolean,
      default: false
    },
    collapseSelected: {
      type: Boolean,
      default: false
    },
    filterable: {
      type: Boolean,
      default: false
    },
    filterAutoFocus: {
      type: Boolean,
      default: true
    },
    filterFunction: Function,
    filterPlaceholder: String,
    selectedIcon: {
      type: String,
      default: 'glyphicon glyphicon-ok'
    },
    itemSelectedClass: String
  },
  data: function data() {
    return {
      showDropdown: false,
      els: [],
      filterInput: '',
      currentActive: -1
    };
  },

  computed: {
    containerStyles: function containerStyles() {
      return {
        width: this.block ? '100%' : ''
      };
    },
    filteredOptions: function filteredOptions() {
      var _this = this;

      if (this.filterable && this.filterInput) {
        if (this.filterFunction) {
          return this.filterFunction(this.filterInput);
        } else {
          var filterInput = this.filterInput.toLowerCase();
          return this.options.filter(function (v) {
            return v[_this.valueKey].toString().toLowerCase().indexOf(filterInput) >= 0 || v[_this.labelKey].toString().toLowerCase().indexOf(filterInput) >= 0;
          });
        }
      } else {
        return this.options;
      }
    },
    groupedOptions: function groupedOptions() {
      var _this2 = this;

      return this.filteredOptions.map(function (v) {
        return v.group;
      }).filter(onlyUnique).map(function (v) {
        return {
          options: _this2.filteredOptions.filter(function (option) {
            return option.group === v;
          }),
          $group: v
        };
      });
    },
    flatternGroupedOptions: function flatternGroupedOptions() {
      if (this.groupedOptions && this.groupedOptions.length) {
        var result = [];
        this.groupedOptions.forEach(function (v) {
          result = result.concat(v.options);
        });
        return result;
      } else {
        return [];
      }
    },
    selectClasses: function selectClasses() {
      return defineProperty({}, 'input-' + this.size, this.size);
    },
    selectedIconClasses: function selectedIconClasses() {
      var _ref2;

      return _ref2 = {}, defineProperty(_ref2, this.selectedIcon, true), defineProperty(_ref2, 'pull-right', true), _ref2;
    },
    selectTextClasses: function selectTextClasses() {
      return {
        'text-muted': this.value.length === 0
      };
    },
    labelValue: function labelValue() {
      var _this3 = this;

      var optionsByValue = this.options.map(function (v) {
        return v[_this3.valueKey];
      });
      return this.value.map(function (v) {
        var index = optionsByValue.indexOf(v);
        return index >= 0 ? _this3.options[index][_this3.labelKey] : v;
      });
    },
    selectedText: function selectedText() {
      if (this.value.length) {
        var labelValue = this.labelValue;
        if (this.collapseSelected) {
          var str = labelValue[0];
          str += labelValue.length > 1 ? this.split + '+' + (labelValue.length - 1) : '';
          return str;
        } else {
          return labelValue.join(this.split);
        }
      } else {
        return this.placeholder || this.t('uiv.multiSelect.placeholder');
      }
    }
  },
  watch: {
    showDropdown: function showDropdown(v) {
      var _this4 = this;

      // clear filter input when dropdown toggles
      this.filterInput = '';
      this.currentActive = -1;
      this.$emit('visible-change', v);
      if (v && this.filterable && this.filterAutoFocus) {
        this.$nextTick(function () {
          _this4.$refs.filterInput.focus();
        });
      }
    }
  },
  mounted: function mounted() {
    this.els = [this.$el];
  },

  methods: {
    goPrevOption: function goPrevOption() {
      if (!this.showDropdown) {
        return;
      }
      this.currentActive > 0 ? this.currentActive-- : this.currentActive = this.flatternGroupedOptions.length - 1;
    },
    goNextOption: function goNextOption() {
      if (!this.showDropdown) {
        return;
      }
      this.currentActive < this.flatternGroupedOptions.length - 1 ? this.currentActive++ : this.currentActive = 0;
    },
    selectOption: function selectOption() {
      var index = this.currentActive;
      var options = this.flatternGroupedOptions;
      if (!this.showDropdown) {
        this.showDropdown = true;
      } else if (index >= 0 && index < options.length) {
        this.toggle(options[index]);
      }
    },
    itemClasses: function itemClasses(item) {
      var result = {
        disabled: item.disabled,
        active: this.currentActive === this.flatternGroupedOptions.indexOf(item)
      };
      if (this.itemSelectedClass) {
        result[this.itemSelectedClass] = this.isItemSelected(item);
      }
      return result;
    },
    isItemSelected: function isItemSelected(item) {
      return this.value.indexOf(item[this.valueKey]) >= 0;
    },
    toggle: function toggle(item) {
      if (item.disabled) {
        return;
      }
      var value = item[this.valueKey];
      var index = this.value.indexOf(value);
      if (this.limit === 1) {
        var newValue = index >= 0 ? [] : [value];
        this.$emit('input', newValue);
        this.$emit('change', newValue);
      } else {
        if (index >= 0) {
          var newVal = this.value.slice();
          newVal.splice(index, 1);
          this.$emit('input', newVal);
          this.$emit('change', newVal);
        } else if (this.limit === 0 || this.value.length < this.limit) {
          var _newVal = this.value.slice();
          _newVal.push(value);
          this.$emit('input', _newVal);
          this.$emit('change', _newVal);
        } else {
          this.$emit('limit-exceed');
        }
      }
    }
  }
};

var Navbar = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('nav', { class: _vm.navClasses }, [_c('div', { class: _vm.fluid ? 'container-fluid' : 'container' }, [_c('div', { staticClass: "navbar-header" }, [_vm._t("collapse-btn", [_c('button', { staticClass: "navbar-toggle collapsed", attrs: { "type": "button" }, on: { "click": _vm.toggle } }, [_c('span', { staticClass: "sr-only" }, [_vm._v("Toggle navigation")]), _vm._v(" "), _c('span', { staticClass: "icon-bar" }), _vm._v(" "), _c('span', { staticClass: "icon-bar" }), _vm._v(" "), _c('span', { staticClass: "icon-bar" })])]), _vm._v(" "), _vm._t("brand")], 2), _vm._v(" "), _vm._t("default"), _vm._v(" "), _c('collapse', { staticClass: "navbar-collapse", model: { value: _vm.show, callback: function callback($$v) {
          _vm.show = $$v;
        }, expression: "show" } }, [_vm._t("collapse")], 2)], 2)]);
  }, staticRenderFns: [],
  components: { Collapse: Collapse },
  props: {
    value: Boolean,
    fluid: {
      type: Boolean,
      default: true
    },
    fixedTop: Boolean,
    fixedBottom: Boolean,
    staticTop: Boolean,
    inverse: Boolean
  },
  data: function data() {
    return {
      show: false
    };
  },

  computed: {
    navClasses: function navClasses() {
      return {
        navbar: true,
        'navbar-default': !this.inverse,
        'navbar-inverse': this.inverse,
        'navbar-static-top': this.staticTop,
        'navbar-fixed-bottom': this.fixedBottom,
        'navbar-fixed-top': this.fixedTop
      };
    }
  },
  mounted: function mounted() {
    this.show = !!this.value;
  },

  watch: {
    value: function value(v) {
      this.show = v;
    }
  },
  methods: {
    toggle: function toggle() {
      this.show = !this.show;
      this.$emit('input', this.show);
    }
  }
};

var NavbarNav = {
  functional: true,
  render: function render(h, _ref) {
    var children = _ref.children,
        data = _ref.data,
        props = _ref.props;

    return h('ul', mergeData(data, {
      class: {
        nav: true,
        'navbar-nav': true,
        'navbar-left': props.left,
        'navbar-right': props.right
      }
    }), children);
  },

  props: {
    left: Boolean,
    right: Boolean
  }
};

var NavbarForm = {
  functional: true,
  render: function render(h, _ref) {
    var children = _ref.children,
        data = _ref.data,
        props = _ref.props;

    return h('form', mergeData(data, {
      class: {
        'navbar-form': true,
        'navbar-left': props.left,
        'navbar-right': props.right
      }
    }), children);
  },

  props: {
    left: Boolean,
    right: Boolean
  }
};

var NavbarText = {
  functional: true,
  render: function render(h, _ref) {
    var children = _ref.children,
        data = _ref.data,
        props = _ref.props;

    return h('p', mergeData(data, {
      class: {
        'navbar-text': true,
        'navbar-left': props.left,
        'navbar-right': props.right
      }
    }), children);
  },

  props: {
    left: Boolean,
    right: Boolean
  }
};



var components = Object.freeze({
	Carousel: Carousel,
	Slide: Slide,
	Collapse: Collapse,
	Dropdown: Dropdown,
	Modal: Modal,
	Tab: Tab,
	Tabs: Tabs,
	DatePicker: DatePicker,
	Affix: Affix,
	Alert: Alert,
	Pagination: Pagination,
	Tooltip: Tooltip,
	Popover: Popover,
	TimePicker: TimePicker,
	Typeahead: Typeahead,
	ProgressBar: ProgressBar,
	ProgressBarStack: ProgressBarStack,
	Breadcrumbs: Breadcrumbs,
	BreadcrumbItem: BreadcrumbItem,
	Btn: Btn,
	BtnGroup: BtnGroup,
	BtnToolbar: BtnToolbar,
	MultiSelect: MultiSelect,
	Navbar: Navbar,
	NavbarNav: NavbarNav,
	NavbarForm: NavbarForm,
	NavbarText: NavbarText
});

var INSTANCE = '_uiv_tooltip_instance';

var bind$1 = function bind(el, binding) {
  // console.log('bind')
  unbind$1(el);
  var Constructor = vue__WEBPACK_IMPORTED_MODULE_0___default.a.extend(Tooltip);
  var vm = new Constructor({
    propsData: {
      target: el,
      appendTo: binding.arg && '#' + binding.arg,
      text: typeof binding.value === 'string' ? binding.value && binding.value.toString() : binding.value && binding.value.text && binding.value.text.toString(),
      viewport: binding.value && binding.value.viewport && binding.value.viewport.toString(),
      customClass: binding.value && binding.value.customClass && binding.value.customClass.toString(),
      showDelay: binding.value && binding.value.showDelay,
      hideDelay: binding.value && binding.value.hideDelay
    }
  });
  var options = [];
  for (var key in binding.modifiers) {
    if (binding.modifiers.hasOwnProperty(key) && binding.modifiers[key]) {
      options.push(key);
    }
  }
  options.forEach(function (option) {
    if (/(top)|(left)|(right)|(bottom)/.test(option)) {
      vm.placement = option;
    } else if (/(hover)|(focus)|(click)/.test(option)) {
      vm.trigger = option;
    } else if (/unenterable/.test(option)) {
      vm.enterable = false;
    }
  });
  vm.$mount();
  el[INSTANCE] = vm;
};

var unbind$1 = function unbind(el) {
  // console.log('unbind')
  var vm = el[INSTANCE];
  if (vm) {
    vm.$destroy();
  }
  delete el[INSTANCE];
};

var update$1 = function update(el, binding) {
  // console.log('update')
  if (binding.value !== binding.oldValue) {
    bind$1(el, binding);
  }
};

var tooltip = { bind: bind$1, unbind: unbind$1, update: update$1 };

var INSTANCE$1 = '_uiv_popover_instance';

var bind$2 = function bind(el, binding) {
  // console.log('bind')
  unbind$2(el);
  var Constructor = vue__WEBPACK_IMPORTED_MODULE_0___default.a.extend(Popover);
  var vm = new Constructor({
    propsData: {
      target: el,
      appendTo: binding.arg && '#' + binding.arg,
      title: binding.value && binding.value.title && binding.value.title.toString(),
      content: binding.value && binding.value.content && binding.value.content.toString(),
      viewport: binding.value && binding.value.viewport && binding.value.viewport.toString(),
      customClass: binding.value && binding.value.customClass && binding.value.customClass.toString()
    }
  });
  var options = [];
  for (var key in binding.modifiers) {
    if (binding.modifiers.hasOwnProperty(key) && binding.modifiers[key]) {
      options.push(key);
    }
  }
  options.forEach(function (option) {
    if (/(top)|(left)|(right)|(bottom)/.test(option)) {
      vm.placement = option;
    } else if (/(hover)|(focus)|(click)/.test(option)) {
      vm.trigger = option;
    } else if (/unenterable/.test(option)) {
      vm.enterable = false;
    }
  });
  vm.$mount();
  el[INSTANCE$1] = vm;
};

var unbind$2 = function unbind(el) {
  // console.log('unbind')
  var vm = el[INSTANCE$1];
  if (vm) {
    vm.$destroy();
  }
  delete el[INSTANCE$1];
};

var update$2 = function update(el, binding) {
  // console.log('update')
  if (binding.value !== binding.oldValue) {
    bind$2(el, binding);
  }
};

var popover = { bind: bind$2, unbind: unbind$2, update: update$2 };

function ScrollSpy(element) {
  var target = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'body';
  var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

  this.el = element;
  this.opts = _extends({}, ScrollSpy.DEFAULTS, options);
  this.opts.target = target;
  if (target === 'body') {
    this.scrollElement = window;
  } else {
    this.scrollElement = document.querySelector('[id=' + target + ']');
  }
  this.selector = 'li > a';
  this.offsets = [];
  this.targets = [];
  this.activeTarget = null;
  this.scrollHeight = 0;
  if (this.scrollElement) {
    this.refresh();
    this.process();
  }
}

ScrollSpy.DEFAULTS = {
  offset: 10,
  callback: function callback(ele) {
    return 0;
  }
};

ScrollSpy.prototype.getScrollHeight = function () {
  return this.scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
};

ScrollSpy.prototype.refresh = function () {
  var _this = this;

  this.offsets = [];
  this.targets = [];
  this.scrollHeight = this.getScrollHeight();
  var list = nodeListToArray(this.el.querySelectorAll(this.selector));
  var isWindow = this.scrollElement === window;
  list.map(function (ele) {
    var href = ele.getAttribute('href');
    if (/^#./.test(href)) {
      var doc = document.documentElement;
      var rootEl = isWindow ? document : _this.scrollElement;
      var hrefEl = rootEl.querySelector('[id=\'' + href.slice(1) + '\']');
      var windowScrollTop = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
      var offset = isWindow ? hrefEl.getBoundingClientRect().top + windowScrollTop : hrefEl.offsetTop + _this.scrollElement.scrollTop;
      return [offset, href];
    } else {
      return null;
    }
  }).filter(function (item) {
    return item;
  }).sort(function (a, b) {
    return a[0] - b[0];
  }).forEach(function (item) {
    _this.offsets.push(item[0]);
    _this.targets.push(item[1]);
  });
  // console.log(this.offsets, this.targets)
};

ScrollSpy.prototype.process = function () {
  var isWindow = this.scrollElement === window;
  var scrollTop = (isWindow ? window.pageYOffset : this.scrollElement.scrollTop) + this.opts.offset;
  var scrollHeight = this.getScrollHeight();
  var scrollElementHeight = isWindow ? getViewportSize().height : this.scrollElement.getBoundingClientRect().height;
  var maxScroll = this.opts.offset + scrollHeight - scrollElementHeight;
  var offsets = this.offsets;
  var targets = this.targets;
  var activeTarget = this.activeTarget;
  var i = void 0;
  if (this.scrollHeight !== scrollHeight) {
    this.refresh();
  }
  if (scrollTop >= maxScroll) {
    return activeTarget !== (i = targets[targets.length - 1]) && this.activate(i);
  }
  if (activeTarget && scrollTop < offsets[0]) {
    this.activeTarget = null;
    return this.clear();
  }
  for (i = offsets.length; i--;) {
    activeTarget !== targets[i] && scrollTop >= offsets[i] && (offsets[i + 1] === undefined || scrollTop < offsets[i + 1]) && this.activate(targets[i]);
  }
};

ScrollSpy.prototype.activate = function (target) {
  this.activeTarget = target;
  this.clear();
  var selector = this.selector + '[data-target="' + target + '"],' + this.selector + '[href="' + target + '"]';
  var activeCallback = this.opts.callback;
  var active = nodeListToArray(this.el.querySelectorAll(selector));
  active.forEach(function (ele) {
    getParents(ele, 'li').forEach(function (item) {
      addClass(item, 'active');
      activeCallback(item);
    });
    if (getParents(ele, '.dropdown-menu').length) {
      addClass(getClosest(ele, 'li.dropdown'), 'active');
    }
  });
};

ScrollSpy.prototype.clear = function () {
  var _this2 = this;

  var list = nodeListToArray(this.el.querySelectorAll(this.selector));
  list.forEach(function (ele) {
    getParents(ele, '.active', _this2.opts.target).forEach(function (item) {
      removeClass(item, 'active');
    });
  });
};

var INSTANCE$2 = '_uiv_scrollspy_instance';
var events$1 = [EVENTS.RESIZE, EVENTS.SCROLL];

var bind$3 = function bind(el, binding) {
  // console.log('bind')
  unbind$3(el);
};

var inserted = function inserted(el, binding) {
  // console.log('inserted')
  var scrollSpy = new ScrollSpy(el, binding.arg, binding.value);
  if (scrollSpy.scrollElement) {
    scrollSpy.handler = function () {
      scrollSpy.process();
    };
    events$1.forEach(function (event) {
      on(scrollSpy.scrollElement, event, scrollSpy.handler);
    });
  }
  el[INSTANCE$2] = scrollSpy;
};

var unbind$3 = function unbind(el) {
  // console.log('unbind')
  var instance = el[INSTANCE$2];
  if (instance && instance.scrollElement) {
    events$1.forEach(function (event) {
      off(instance.scrollElement, event, instance.handler);
    });
    delete el[INSTANCE$2];
  }
};

var update$3 = function update(el, binding) {
  // console.log('update')
  var isArgUpdated = binding.arg !== binding.oldArg;
  var isValueUpdated = binding.value !== binding.oldValue;
  if (isArgUpdated || isValueUpdated) {
    bind$3(el, binding);
    inserted(el, binding);
  }
};

var scrollspy = { bind: bind$3, unbind: unbind$3, update: update$3, inserted: inserted };



var directives = Object.freeze({
	tooltip: tooltip,
	popover: popover,
	scrollspy: scrollspy
});

var TYPES = {
  ALERT: 0,
  CONFIRM: 1,
  PROMPT: 2
};

var MessageBox = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('modal', { ref: "modal", class: _vm.customClass, attrs: { "auto-focus": "", "size": _vm.size, "title": _vm.title, "header": !!_vm.title, "backdrop": _vm.closeOnBackdropClick, "cancel-text": _vm.cancelText, "ok-text": _vm.okText }, on: { "hide": _vm.cb }, model: { value: _vm.show, callback: function callback($$v) {
          _vm.show = $$v;
        }, expression: "show" } }, [_vm.html ? _c('div', { domProps: { "innerHTML": _vm._s(_vm.content) } }) : _c('p', [_vm._v(_vm._s(_vm.content))]), _vm._v(" "), _vm.type === _vm.TYPES.PROMPT ? _c('div', [_c('div', { staticClass: "form-group", class: { 'has-error': _vm.inputNotValid } }, [_vm.inputType === 'checkbox' ? _c('input', { directives: [{ name: "model", rawName: "v-model", value: _vm.input, expression: "input" }], ref: "input", staticClass: "form-control", attrs: { "required": "", "data-action": "auto-focus", "type": "checkbox" }, domProps: { "checked": Array.isArray(_vm.input) ? _vm._i(_vm.input, null) > -1 : _vm.input }, on: { "change": [function ($event) {
          var $$a = _vm.input,
              $$el = $event.target,
              $$c = $$el.checked ? true : false;if (Array.isArray($$a)) {
            var $$v = null,
                $$i = _vm._i($$a, $$v);if ($$el.checked) {
              $$i < 0 && (_vm.input = $$a.concat([$$v]));
            } else {
              $$i > -1 && (_vm.input = $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
            }
          } else {
            _vm.input = $$c;
          }
        }, function ($event) {
          _vm.dirty = true;
        }], "keyup": function keyup($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) {
            return null;
          }return _vm.validate($event);
        } } }) : _vm.inputType === 'radio' ? _c('input', { directives: [{ name: "model", rawName: "v-model", value: _vm.input, expression: "input" }], ref: "input", staticClass: "form-control", attrs: { "required": "", "data-action": "auto-focus", "type": "radio" }, domProps: { "checked": _vm._q(_vm.input, null) }, on: { "change": [function ($event) {
          _vm.input = null;
        }, function ($event) {
          _vm.dirty = true;
        }], "keyup": function keyup($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) {
            return null;
          }return _vm.validate($event);
        } } }) : _c('input', { directives: [{ name: "model", rawName: "v-model", value: _vm.input, expression: "input" }], ref: "input", staticClass: "form-control", attrs: { "required": "", "data-action": "auto-focus", "type": _vm.inputType }, domProps: { "value": _vm.input }, on: { "change": function change($event) {
          _vm.dirty = true;
        }, "keyup": function keyup($event) {
          if (!$event.type.indexOf('key') && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) {
            return null;
          }return _vm.validate($event);
        }, "input": function input($event) {
          if ($event.target.composing) {
            return;
          }_vm.input = $event.target.value;
        } } }), _vm._v(" "), _c('span', { directives: [{ name: "show", rawName: "v-show", value: _vm.inputNotValid, expression: "inputNotValid" }], staticClass: "help-block" }, [_vm._v(_vm._s(_vm.inputError))])])]) : _vm._e(), _vm._v(" "), _vm.type === _vm.TYPES.ALERT ? _c('template', { slot: "footer" }, [_c('btn', { attrs: { "type": _vm.okType, "data-action": _vm.autoFocus === 'ok' ? 'auto-focus' : '' }, domProps: { "textContent": _vm._s(_vm.okBtnText) }, on: { "click": function click($event) {
          return _vm.toggle(false, 'ok');
        } } })], 1) : _c('template', { slot: "footer" }, [_c('btn', { attrs: { "type": _vm.cancelType, "data-action": _vm.autoFocus === 'cancel' ? 'auto-focus' : '' }, domProps: { "textContent": _vm._s(_vm.cancelBtnText) }, on: { "click": function click($event) {
          return _vm.toggle(false, 'cancel');
        } } }), _vm._v(" "), _vm.type === _vm.TYPES.CONFIRM ? _c('btn', { attrs: { "type": _vm.okType, "data-action": _vm.autoFocus === 'ok' ? 'auto-focus' : '' }, domProps: { "textContent": _vm._s(_vm.okBtnText) }, on: { "click": function click($event) {
          return _vm.toggle(false, 'ok');
        } } }) : _c('btn', { attrs: { "type": _vm.okType }, domProps: { "textContent": _vm._s(_vm.okBtnText) }, on: { "click": _vm.validate } })], 1)], 2);
  }, staticRenderFns: [],
  mixins: [Local],
  components: { Modal: Modal, Btn: Btn },
  props: {
    backdrop: null,
    title: String,
    content: String,
    html: {
      type: Boolean,
      default: false
    },
    okText: String,
    okType: {
      type: String,
      default: 'primary'
    },
    cancelText: String,
    cancelType: {
      type: String,
      default: 'default'
    },
    type: {
      type: Number,
      default: TYPES.ALERT
    },
    size: {
      type: String,
      default: 'sm'
    },
    cb: {
      type: Function,
      required: true
    },
    validator: {
      type: Function,
      default: function _default() {
        return null;
      }
    },
    customClass: null,
    defaultValue: String,
    inputType: {
      type: String,
      default: 'text'
    },
    autoFocus: {
      type: String,
      default: 'ok'
    }
  },
  data: function data() {
    return {
      TYPES: TYPES,
      show: false,
      input: '',
      dirty: false
    };
  },
  mounted: function mounted() {
    if (this.defaultValue) {
      this.input = this.defaultValue;
    }
  },

  computed: {
    closeOnBackdropClick: function closeOnBackdropClick() {
      // use backdrop prop if exist
      // otherwise, only not available if render as alert
      return isExist(this.backdrop) ? Boolean(this.backdrop) : this.type !== TYPES.ALERT;
    },
    inputError: function inputError() {
      return this.validator(this.input);
    },
    inputNotValid: function inputNotValid() {
      return this.dirty && this.inputError;
    },
    okBtnText: function okBtnText() {
      return this.okText || this.t('uiv.modal.ok');
    },
    cancelBtnText: function cancelBtnText() {
      return this.cancelText || this.t('uiv.modal.cancel');
    }
  },
  methods: {
    toggle: function toggle(show, msg) {
      this.$refs.modal.toggle(show, msg);
    },
    validate: function validate() {
      this.dirty = true;
      if (!isExist(this.inputError)) {
        this.toggle(false, { value: this.input });
      }
    }
  }
};

var queue = [];

var destroy = function destroy(instance) {
  // console.log('destroyModal')
  removeFromDom(instance.$el);
  instance.$destroy();
  spliceIfExist(queue, instance);
};

// handel cancel or ok for confirm & prompt
var shallResolve = function shallResolve(type, msg) {
  if (type === TYPES.CONFIRM) {
    // is confirm
    return msg === 'ok';
  } else {
    // is prompt
    return isExist(msg) && isString(msg.value);
  }
};

var init = function init(type, options, _cb) {
  var resolve = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  var reject = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : null;

  var i18n = this.$i18n;
  var instance = new vue__WEBPACK_IMPORTED_MODULE_0___default.a({
    extends: MessageBox,
    i18n: i18n,
    propsData: _extends({
      type: type
    }, options, {
      cb: function cb(msg) {
        destroy(instance);
        if (isFunction(_cb)) {
          if (type === TYPES.CONFIRM) {
            shallResolve(type, msg) ? _cb(null, msg) : _cb(msg);
          } else if (type === TYPES.PROMPT) {
            shallResolve(type, msg) ? _cb(null, msg.value) : _cb(msg);
          } else {
            _cb(msg);
          }
        } else if (resolve && reject) {
          if (type === TYPES.CONFIRM) {
            shallResolve(type, msg) ? resolve(msg) : reject(msg);
          } else if (type === TYPES.PROMPT) {
            shallResolve(type, msg) ? resolve(msg.value) : reject(msg);
          } else {
            resolve(msg);
          }
        }
      }
    })
  });
  instance.$mount();
  document.body.appendChild(instance.$el);
  instance.show = true;
  queue.push(instance);
};

var initModal = function initModal(type) {
  var _this = this;

  var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  var cb = arguments[2];

  if (isPromiseSupported()) {
    return new Promise(function (resolve, reject) {
      init.apply(_this, [type, options, cb, resolve, reject]);
    });
  } else {
    init.apply(this, [type, options, cb]);
  }
};

var alert = function alert(options, cb) {
  return initModal.apply(this, [TYPES.ALERT, options, cb]);
};

var confirm = function confirm(options, cb) {
  return initModal.apply(this, [TYPES.CONFIRM, options, cb]);
};

var prompt = function prompt(options, cb) {
  return initModal.apply(this, [TYPES.PROMPT, options, cb]);
};

var messageBox = { alert: alert, confirm: confirm, prompt: prompt };

var TYPES$1 = {
  SUCCESS: 'success',
  INFO: 'info',
  DANGER: 'danger',
  WARNING: 'warning'
};

var PLACEMENTS$1 = {
  TOP_LEFT: 'top-left',
  TOP_RIGHT: 'top-right',
  BOTTOM_LEFT: 'bottom-left',
  BOTTOM_RIGHT: 'bottom-right'
};

var IN_CLASS$1 = 'in';
var ICON = 'glyphicon';
var WIDTH = 300;
var TRANSITION_DURATION = 300;

var Notification = { render: function render() {
    var _vm = this;var _h = _vm.$createElement;var _c = _vm._self._c || _h;return _c('alert', { staticClass: "fade", class: _vm.customClass, style: _vm.styles, attrs: { "type": _vm.type, "duration": _vm.duration, "dismissible": _vm.dismissible }, on: { "dismissed": _vm.onDismissed } }, [_c('div', { staticClass: "media", staticStyle: { "margin": "0" } }, [_vm.icons ? _c('div', { staticClass: "media-left" }, [_c('span', { class: _vm.icons, staticStyle: { "font-size": "1.5em" } })]) : _vm._e(), _vm._v(" "), _c('div', { staticClass: "media-body" }, [_vm.title ? _c('div', { staticClass: "media-heading" }, [_c('b', [_vm._v(_vm._s(_vm.title))])]) : _vm._e(), _vm._v(" "), _vm.html ? _c('div', { domProps: { "innerHTML": _vm._s(_vm.content) } }) : _c('div', [_vm._v(_vm._s(_vm.content))])])])]);
  }, staticRenderFns: [],
  components: { Alert: Alert },
  props: {
    title: String,
    content: String,
    html: {
      type: Boolean,
      default: false
    },
    duration: {
      type: Number,
      default: 5000
    },
    dismissible: {
      type: Boolean,
      default: true
    },
    type: String,
    placement: String,
    icon: String,
    customClass: null,
    cb: {
      type: Function,
      required: true
    },
    queue: {
      type: Array,
      required: true
    },
    offsetY: {
      type: Number,
      default: 15
    },
    offsetX: {
      type: Number,
      default: 15
    },
    offset: {
      type: Number,
      default: 15
    }
  },
  data: function data() {
    return {
      height: 0,
      top: 0,
      horizontal: this.placement === PLACEMENTS$1.TOP_LEFT || this.placement === PLACEMENTS$1.BOTTOM_LEFT ? 'left' : 'right',
      vertical: this.placement === PLACEMENTS$1.TOP_LEFT || this.placement === PLACEMENTS$1.TOP_RIGHT ? 'top' : 'bottom'
    };
  },
  created: function created() {
    // get prev notifications total height in the queue
    this.top = this.getTotalHeightOfQueue(this.queue);
  },
  mounted: function mounted() {
    var _this = this;

    var el = this.$el;
    el.style[this.vertical] = this.top + 'px';
    this.$nextTick(function () {
      el.style[_this.horizontal] = '-' + WIDTH + 'px';
      _this.height = el.offsetHeight;
      el.style[_this.horizontal] = _this.offsetX + 'px';
      addClass(el, IN_CLASS$1);
    });
  },

  computed: {
    styles: function styles() {
      var _ref;

      var queue = this.queue;
      var thisIndex = queue.indexOf(this);
      return _ref = {
        position: 'fixed'
      }, defineProperty(_ref, this.vertical, this.getTotalHeightOfQueue(queue, thisIndex) + 'px'), defineProperty(_ref, 'width', WIDTH + 'px'), defineProperty(_ref, 'transition', 'all ' + TRANSITION_DURATION / 1000 + 's ease-in-out'), _ref;
    },
    icons: function icons() {
      if (isString(this.icon)) {
        return this.icon;
      }
      switch (this.type) {
        case TYPES$1.INFO:
        case TYPES$1.WARNING:
          return ICON + ' ' + ICON + '-info-sign';
        case TYPES$1.SUCCESS:
          return ICON + ' ' + ICON + '-ok-sign';
        case TYPES$1.DANGER:
          return ICON + ' ' + ICON + '-remove-sign';
        default:
          return null;
      }
    }
  },
  methods: {
    getTotalHeightOfQueue: function getTotalHeightOfQueue(queue) {
      var lastIndex = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : queue.length;

      var totalHeight = this.offsetY;
      for (var i = 0; i < lastIndex; i++) {
        totalHeight += queue[i].height + this.offset;
      }
      return totalHeight;
    },
    onDismissed: function onDismissed() {
      removeClass(this.$el, IN_CLASS$1);
      setTimeout(this.cb, TRANSITION_DURATION);
    }
  }
};

var _queues;

var queues = (_queues = {}, defineProperty(_queues, PLACEMENTS$1.TOP_LEFT, []), defineProperty(_queues, PLACEMENTS$1.TOP_RIGHT, []), defineProperty(_queues, PLACEMENTS$1.BOTTOM_LEFT, []), defineProperty(_queues, PLACEMENTS$1.BOTTOM_RIGHT, []), _queues);

var destroy$1 = function destroy(queue, instance) {
  // console.log('destroyNotification')
  removeFromDom(instance.$el);
  instance.$destroy();
  spliceIfExist(queue, instance);
};

var init$1 = function init(options, _cb) {
  var resolve = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  var reject = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

  var placement = options.placement;
  var queue = queues[placement];
  // check if placement is valid
  if (!isExist(queue)) {
    return;
  }
  /* istanbul ignore else */
  // `error` alias of `danger`
  if (options.type === 'error') {
    options.type = 'danger';
  }
  var instance = new vue__WEBPACK_IMPORTED_MODULE_0___default.a({
    extends: Notification,
    propsData: _extends({
      queue: queue,
      placement: placement
    }, options, {
      cb: function cb(msg) {
        destroy$1(queue, instance);
        if (isFunction(_cb)) {
          _cb(msg);
        } else if (resolve && reject) {
          resolve(msg);
        }
      }
    })
  });
  instance.$mount();
  document.body.appendChild(instance.$el);
  queue.push(instance);
};

var _notify = function _notify() {
  var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var cb = arguments[1];

  // simplify usage: pass string as option.content
  if (isString(options)) {
    options = {
      content: options
    };
  }
  // set default placement as top-right
  if (!isExist(options.placement)) {
    options.placement = PLACEMENTS$1.TOP_RIGHT;
  }
  if (isPromiseSupported()) {
    return new Promise(function (resolve, reject) {
      init$1(options, cb, resolve, reject);
    });
  } else {
    init$1(options, cb);
  }
};

function _notify2(type, args) {
  if (isString(args)) {
    _notify({
      content: args,
      type: type
    });
  } else {
    _notify(_extends({}, args, {
      type: type
    }));
  }
}

var notify = Object.defineProperties(_notify, {
  success: {
    configurable: false,
    writable: false,
    value: function value(args) {
      _notify2('success', args);
    }
  },
  info: {
    configurable: false,
    writable: false,
    value: function value(args) {
      _notify2('info', args);
    }
  },
  warning: {
    configurable: false,
    writable: false,
    value: function value(args) {
      _notify2('warning', args);
    }
  },
  danger: {
    configurable: false,
    writable: false,
    value: function value(args) {
      _notify2('danger', args);
    }
  },
  error: {
    configurable: false,
    writable: false,
    value: function value(args) {
      _notify2('danger', args);
    }
  },
  dismissAll: {
    configurable: false,
    writable: false,
    value: function value() {
      for (var key in queues) {
        /* istanbul ignore else */
        if (queues.hasOwnProperty(key)) {
          queues[key].forEach(function (instance) {
            instance.onDismissed();
          });
        }
      }
    }
  }
});

var notification = { notify: notify };



var services = Object.freeze({
	MessageBox: messageBox,
	Notification: notification
});

var install = function install(Vue$$1) {
  var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

  // Setup language, en-US for default
  locale.use(options.locale);
  locale.i18n(options.i18n);
  // Register components
  Object.keys(components).forEach(function (key) {
    var _key = options.prefix ? options.prefix + key : key;
    Vue$$1.component(_key, components[key]);
  });
  // Register directives
  Object.keys(directives).forEach(function (key) {
    var _key = options.prefix ? options.prefix + '-' + key : key;
    Vue$$1.directive(_key, directives[key]);
  });
  // Register services
  Object.keys(services).forEach(function (key) {
    var service = services[key];
    Object.keys(service).forEach(function (serviceKey) {
      var _key = options.prefix ? options.prefix + '_' + serviceKey : serviceKey;
      Vue$$1.prototype['$' + _key] = service[serviceKey];
    });
  });
};


//# sourceMappingURL=uiv.esm.js.map


/***/ }),

/***/ "./node_modules/vue-i18n/dist/vue-i18n.esm.js":
/*!****************************************************!*\
  !*** ./node_modules/vue-i18n/dist/vue-i18n.esm.js ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/*!
 * vue-i18n v8.17.6 
 * (c) 2020 kazuya kawaguchi
 * Released under the MIT License.
 */
/*  */

/**
 * constants
 */

var numberFormatKeys = [
  'style',
  'currency',
  'currencyDisplay',
  'useGrouping',
  'minimumIntegerDigits',
  'minimumFractionDigits',
  'maximumFractionDigits',
  'minimumSignificantDigits',
  'maximumSignificantDigits',
  'localeMatcher',
  'formatMatcher',
  'unit'
];

/**
 * utilities
 */

function warn (msg, err) {
  if (typeof console !== 'undefined') {
    console.warn('[vue-i18n] ' + msg);
    /* istanbul ignore if */
    if (err) {
      console.warn(err.stack);
    }
  }
}

function error (msg, err) {
  if (typeof console !== 'undefined') {
    console.error('[vue-i18n] ' + msg);
    /* istanbul ignore if */
    if (err) {
      console.error(err.stack);
    }
  }
}

var isArray = Array.isArray;

function isObject (obj) {
  return obj !== null && typeof obj === 'object'
}

function isBoolean (val) {
  return typeof val === 'boolean'
}

function isString (val) {
  return typeof val === 'string'
}

var toString = Object.prototype.toString;
var OBJECT_STRING = '[object Object]';
function isPlainObject (obj) {
  return toString.call(obj) === OBJECT_STRING
}

function isNull (val) {
  return val === null || val === undefined
}

function parseArgs () {
  var args = [], len = arguments.length;
  while ( len-- ) args[ len ] = arguments[ len ];

  var locale = null;
  var params = null;
  if (args.length === 1) {
    if (isObject(args[0]) || Array.isArray(args[0])) {
      params = args[0];
    } else if (typeof args[0] === 'string') {
      locale = args[0];
    }
  } else if (args.length === 2) {
    if (typeof args[0] === 'string') {
      locale = args[0];
    }
    /* istanbul ignore if */
    if (isObject(args[1]) || Array.isArray(args[1])) {
      params = args[1];
    }
  }

  return { locale: locale, params: params }
}

function looseClone (obj) {
  return JSON.parse(JSON.stringify(obj))
}

function remove (arr, item) {
  if (arr.length) {
    var index = arr.indexOf(item);
    if (index > -1) {
      return arr.splice(index, 1)
    }
  }
}

function includes (arr, item) {
  return !!~arr.indexOf(item)
}

var hasOwnProperty = Object.prototype.hasOwnProperty;
function hasOwn (obj, key) {
  return hasOwnProperty.call(obj, key)
}

function merge (target) {
  var arguments$1 = arguments;

  var output = Object(target);
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments$1[i];
    if (source !== undefined && source !== null) {
      var key = (void 0);
      for (key in source) {
        if (hasOwn(source, key)) {
          if (isObject(source[key])) {
            output[key] = merge(output[key], source[key]);
          } else {
            output[key] = source[key];
          }
        }
      }
    }
  }
  return output
}

function looseEqual (a, b) {
  if (a === b) { return true }
  var isObjectA = isObject(a);
  var isObjectB = isObject(b);
  if (isObjectA && isObjectB) {
    try {
      var isArrayA = Array.isArray(a);
      var isArrayB = Array.isArray(b);
      if (isArrayA && isArrayB) {
        return a.length === b.length && a.every(function (e, i) {
          return looseEqual(e, b[i])
        })
      } else if (!isArrayA && !isArrayB) {
        var keysA = Object.keys(a);
        var keysB = Object.keys(b);
        return keysA.length === keysB.length && keysA.every(function (key) {
          return looseEqual(a[key], b[key])
        })
      } else {
        /* istanbul ignore next */
        return false
      }
    } catch (e) {
      /* istanbul ignore next */
      return false
    }
  } else if (!isObjectA && !isObjectB) {
    return String(a) === String(b)
  } else {
    return false
  }
}

/*  */

function extend (Vue) {
  if (!Vue.prototype.hasOwnProperty('$i18n')) {
    // $FlowFixMe
    Object.defineProperty(Vue.prototype, '$i18n', {
      get: function get () { return this._i18n }
    });
  }

  Vue.prototype.$t = function (key) {
    var values = [], len = arguments.length - 1;
    while ( len-- > 0 ) values[ len ] = arguments[ len + 1 ];

    var i18n = this.$i18n;
    return i18n._t.apply(i18n, [ key, i18n.locale, i18n._getMessages(), this ].concat( values ))
  };

  Vue.prototype.$tc = function (key, choice) {
    var values = [], len = arguments.length - 2;
    while ( len-- > 0 ) values[ len ] = arguments[ len + 2 ];

    var i18n = this.$i18n;
    return i18n._tc.apply(i18n, [ key, i18n.locale, i18n._getMessages(), this, choice ].concat( values ))
  };

  Vue.prototype.$te = function (key, locale) {
    var i18n = this.$i18n;
    return i18n._te(key, i18n.locale, i18n._getMessages(), locale)
  };

  Vue.prototype.$d = function (value) {
    var ref;

    var args = [], len = arguments.length - 1;
    while ( len-- > 0 ) args[ len ] = arguments[ len + 1 ];
    return (ref = this.$i18n).d.apply(ref, [ value ].concat( args ))
  };

  Vue.prototype.$n = function (value) {
    var ref;

    var args = [], len = arguments.length - 1;
    while ( len-- > 0 ) args[ len ] = arguments[ len + 1 ];
    return (ref = this.$i18n).n.apply(ref, [ value ].concat( args ))
  };
}

/*  */

var mixin = {
  beforeCreate: function beforeCreate () {
    var options = this.$options;
    options.i18n = options.i18n || (options.__i18n ? {} : null);

    if (options.i18n) {
      if (options.i18n instanceof VueI18n) {
        // init locale messages via custom blocks
        if (options.__i18n) {
          try {
            var localeMessages = {};
            options.__i18n.forEach(function (resource) {
              localeMessages = merge(localeMessages, JSON.parse(resource));
            });
            Object.keys(localeMessages).forEach(function (locale) {
              options.i18n.mergeLocaleMessage(locale, localeMessages[locale]);
            });
          } catch (e) {
            if (true) {
              error("Cannot parse locale messages via custom blocks.", e);
            }
          }
        }
        this._i18n = options.i18n;
        this._i18nWatcher = this._i18n.watchI18nData();
      } else if (isPlainObject(options.i18n)) {
        // component local i18n
        if (this.$root && this.$root.$i18n && this.$root.$i18n instanceof VueI18n) {
          options.i18n.root = this.$root;
          options.i18n.formatter = this.$root.$i18n.formatter;
          options.i18n.fallbackLocale = this.$root.$i18n.fallbackLocale;
          options.i18n.formatFallbackMessages = this.$root.$i18n.formatFallbackMessages;
          options.i18n.silentTranslationWarn = this.$root.$i18n.silentTranslationWarn;
          options.i18n.silentFallbackWarn = this.$root.$i18n.silentFallbackWarn;
          options.i18n.pluralizationRules = this.$root.$i18n.pluralizationRules;
          options.i18n.preserveDirectiveContent = this.$root.$i18n.preserveDirectiveContent;
        }

        // init locale messages via custom blocks
        if (options.__i18n) {
          try {
            var localeMessages$1 = {};
            options.__i18n.forEach(function (resource) {
              localeMessages$1 = merge(localeMessages$1, JSON.parse(resource));
            });
            options.i18n.messages = localeMessages$1;
          } catch (e) {
            if (true) {
              warn("Cannot parse locale messages via custom blocks.", e);
            }
          }
        }

        var ref = options.i18n;
        var sharedMessages = ref.sharedMessages;
        if (sharedMessages && isPlainObject(sharedMessages)) {
          options.i18n.messages = merge(options.i18n.messages, sharedMessages);
        }

        this._i18n = new VueI18n(options.i18n);
        this._i18nWatcher = this._i18n.watchI18nData();

        if (options.i18n.sync === undefined || !!options.i18n.sync) {
          this._localeWatcher = this.$i18n.watchLocale();
        }
      } else {
        if (true) {
          warn("Cannot be interpreted 'i18n' option.");
        }
      }
    } else if (this.$root && this.$root.$i18n && this.$root.$i18n instanceof VueI18n) {
      // root i18n
      this._i18n = this.$root.$i18n;
    } else if (options.parent && options.parent.$i18n && options.parent.$i18n instanceof VueI18n) {
      // parent i18n
      this._i18n = options.parent.$i18n;
    }
  },

  beforeMount: function beforeMount () {
    var options = this.$options;
    options.i18n = options.i18n || (options.__i18n ? {} : null);

    if (options.i18n) {
      if (options.i18n instanceof VueI18n) {
        // init locale messages via custom blocks
        this._i18n.subscribeDataChanging(this);
        this._subscribing = true;
      } else if (isPlainObject(options.i18n)) {
        this._i18n.subscribeDataChanging(this);
        this._subscribing = true;
      } else {
        if (true) {
          warn("Cannot be interpreted 'i18n' option.");
        }
      }
    } else if (this.$root && this.$root.$i18n && this.$root.$i18n instanceof VueI18n) {
      this._i18n.subscribeDataChanging(this);
      this._subscribing = true;
    } else if (options.parent && options.parent.$i18n && options.parent.$i18n instanceof VueI18n) {
      this._i18n.subscribeDataChanging(this);
      this._subscribing = true;
    }
  },

  beforeDestroy: function beforeDestroy () {
    if (!this._i18n) { return }

    var self = this;
    this.$nextTick(function () {
      if (self._subscribing) {
        self._i18n.unsubscribeDataChanging(self);
        delete self._subscribing;
      }

      if (self._i18nWatcher) {
        self._i18nWatcher();
        self._i18n.destroyVM();
        delete self._i18nWatcher;
      }

      if (self._localeWatcher) {
        self._localeWatcher();
        delete self._localeWatcher;
      }
    });
  }
};

/*  */

var interpolationComponent = {
  name: 'i18n',
  functional: true,
  props: {
    tag: {
      type: [String, Boolean],
      default: 'span'
    },
    path: {
      type: String,
      required: true
    },
    locale: {
      type: String
    },
    places: {
      type: [Array, Object]
    }
  },
  render: function render (h, ref) {
    var data = ref.data;
    var parent = ref.parent;
    var props = ref.props;
    var slots = ref.slots;

    var $i18n = parent.$i18n;
    if (!$i18n) {
      if (true) {
        warn('Cannot find VueI18n instance!');
      }
      return
    }

    var path = props.path;
    var locale = props.locale;
    var places = props.places;
    var params = slots();
    var children = $i18n.i(
      path,
      locale,
      onlyHasDefaultPlace(params) || places
        ? useLegacyPlaces(params.default, places)
        : params
    );

    var tag = (!!props.tag && props.tag !== true) || props.tag === false ? props.tag : 'span';
    return tag ? h(tag, data, children) : children
  }
};

function onlyHasDefaultPlace (params) {
  var prop;
  for (prop in params) {
    if (prop !== 'default') { return false }
  }
  return Boolean(prop)
}

function useLegacyPlaces (children, places) {
  var params = places ? createParamsFromPlaces(places) : {};

  if (!children) { return params }

  // Filter empty text nodes
  children = children.filter(function (child) {
    return child.tag || child.text.trim() !== ''
  });

  var everyPlace = children.every(vnodeHasPlaceAttribute);
  if ( true && everyPlace) {
    warn('`place` attribute is deprecated in next major version. Please switch to Vue slots.');
  }

  return children.reduce(
    everyPlace ? assignChildPlace : assignChildIndex,
    params
  )
}

function createParamsFromPlaces (places) {
  if (true) {
    warn('`places` prop is deprecated in next major version. Please switch to Vue slots.');
  }

  return Array.isArray(places)
    ? places.reduce(assignChildIndex, {})
    : Object.assign({}, places)
}

function assignChildPlace (params, child) {
  if (child.data && child.data.attrs && child.data.attrs.place) {
    params[child.data.attrs.place] = child;
  }
  return params
}

function assignChildIndex (params, child, index) {
  params[index] = child;
  return params
}

function vnodeHasPlaceAttribute (vnode) {
  return Boolean(vnode.data && vnode.data.attrs && vnode.data.attrs.place)
}

/*  */

var numberComponent = {
  name: 'i18n-n',
  functional: true,
  props: {
    tag: {
      type: [String, Boolean],
      default: 'span'
    },
    value: {
      type: Number,
      required: true
    },
    format: {
      type: [String, Object]
    },
    locale: {
      type: String
    }
  },
  render: function render (h, ref) {
    var props = ref.props;
    var parent = ref.parent;
    var data = ref.data;

    var i18n = parent.$i18n;

    if (!i18n) {
      if (true) {
        warn('Cannot find VueI18n instance!');
      }
      return null
    }

    var key = null;
    var options = null;

    if (isString(props.format)) {
      key = props.format;
    } else if (isObject(props.format)) {
      if (props.format.key) {
        key = props.format.key;
      }

      // Filter out number format options only
      options = Object.keys(props.format).reduce(function (acc, prop) {
        var obj;

        if (includes(numberFormatKeys, prop)) {
          return Object.assign({}, acc, ( obj = {}, obj[prop] = props.format[prop], obj ))
        }
        return acc
      }, null);
    }

    var locale = props.locale || i18n.locale;
    var parts = i18n._ntp(props.value, locale, key, options);

    var values = parts.map(function (part, index) {
      var obj;

      var slot = data.scopedSlots && data.scopedSlots[part.type];
      return slot ? slot(( obj = {}, obj[part.type] = part.value, obj.index = index, obj.parts = parts, obj )) : part.value
    });

    var tag = (!!props.tag && props.tag !== true) || props.tag === false ? props.tag : 'span';
    return tag
      ? h(tag, {
        attrs: data.attrs,
        'class': data['class'],
        staticClass: data.staticClass
      }, values)
      : values
  }
};

/*  */

function bind (el, binding, vnode) {
  if (!assert(el, vnode)) { return }

  t(el, binding, vnode);
}

function update (el, binding, vnode, oldVNode) {
  if (!assert(el, vnode)) { return }

  var i18n = vnode.context.$i18n;
  if (localeEqual(el, vnode) &&
    (looseEqual(binding.value, binding.oldValue) &&
     looseEqual(el._localeMessage, i18n.getLocaleMessage(i18n.locale)))) { return }

  t(el, binding, vnode);
}

function unbind (el, binding, vnode, oldVNode) {
  var vm = vnode.context;
  if (!vm) {
    warn('Vue instance does not exists in VNode context');
    return
  }

  var i18n = vnode.context.$i18n || {};
  if (!binding.modifiers.preserve && !i18n.preserveDirectiveContent) {
    el.textContent = '';
  }
  el._vt = undefined;
  delete el['_vt'];
  el._locale = undefined;
  delete el['_locale'];
  el._localeMessage = undefined;
  delete el['_localeMessage'];
}

function assert (el, vnode) {
  var vm = vnode.context;
  if (!vm) {
    warn('Vue instance does not exists in VNode context');
    return false
  }

  if (!vm.$i18n) {
    warn('VueI18n instance does not exists in Vue instance');
    return false
  }

  return true
}

function localeEqual (el, vnode) {
  var vm = vnode.context;
  return el._locale === vm.$i18n.locale
}

function t (el, binding, vnode) {
  var ref$1, ref$2;

  var value = binding.value;

  var ref = parseValue(value);
  var path = ref.path;
  var locale = ref.locale;
  var args = ref.args;
  var choice = ref.choice;
  if (!path && !locale && !args) {
    warn('value type not supported');
    return
  }

  if (!path) {
    warn('`path` is required in v-t directive');
    return
  }

  var vm = vnode.context;
  if (choice) {
    el._vt = el.textContent = (ref$1 = vm.$i18n).tc.apply(ref$1, [ path, choice ].concat( makeParams(locale, args) ));
  } else {
    el._vt = el.textContent = (ref$2 = vm.$i18n).t.apply(ref$2, [ path ].concat( makeParams(locale, args) ));
  }
  el._locale = vm.$i18n.locale;
  el._localeMessage = vm.$i18n.getLocaleMessage(vm.$i18n.locale);
}

function parseValue (value) {
  var path;
  var locale;
  var args;
  var choice;

  if (isString(value)) {
    path = value;
  } else if (isPlainObject(value)) {
    path = value.path;
    locale = value.locale;
    args = value.args;
    choice = value.choice;
  }

  return { path: path, locale: locale, args: args, choice: choice }
}

function makeParams (locale, args) {
  var params = [];

  locale && params.push(locale);
  if (args && (Array.isArray(args) || isPlainObject(args))) {
    params.push(args);
  }

  return params
}

var Vue;

function install (_Vue) {
  /* istanbul ignore if */
  if ( true && install.installed && _Vue === Vue) {
    warn('already installed.');
    return
  }
  install.installed = true;

  Vue = _Vue;

  var version = (Vue.version && Number(Vue.version.split('.')[0])) || -1;
  /* istanbul ignore if */
  if ( true && version < 2) {
    warn(("vue-i18n (" + (install.version) + ") need to use Vue 2.0 or later (Vue: " + (Vue.version) + ")."));
    return
  }

  extend(Vue);
  Vue.mixin(mixin);
  Vue.directive('t', { bind: bind, update: update, unbind: unbind });
  Vue.component(interpolationComponent.name, interpolationComponent);
  Vue.component(numberComponent.name, numberComponent);

  // use simple mergeStrategies to prevent i18n instance lose '__proto__'
  var strats = Vue.config.optionMergeStrategies;
  strats.i18n = function (parentVal, childVal) {
    return childVal === undefined
      ? parentVal
      : childVal
  };
}

/*  */

var BaseFormatter = function BaseFormatter () {
  this._caches = Object.create(null);
};

BaseFormatter.prototype.interpolate = function interpolate (message, values) {
  if (!values) {
    return [message]
  }
  var tokens = this._caches[message];
  if (!tokens) {
    tokens = parse(message);
    this._caches[message] = tokens;
  }
  return compile(tokens, values)
};



var RE_TOKEN_LIST_VALUE = /^(?:\d)+/;
var RE_TOKEN_NAMED_VALUE = /^(?:\w)+/;

function parse (format) {
  var tokens = [];
  var position = 0;

  var text = '';
  while (position < format.length) {
    var char = format[position++];
    if (char === '{') {
      if (text) {
        tokens.push({ type: 'text', value: text });
      }

      text = '';
      var sub = '';
      char = format[position++];
      while (char !== undefined && char !== '}') {
        sub += char;
        char = format[position++];
      }
      var isClosed = char === '}';

      var type = RE_TOKEN_LIST_VALUE.test(sub)
        ? 'list'
        : isClosed && RE_TOKEN_NAMED_VALUE.test(sub)
          ? 'named'
          : 'unknown';
      tokens.push({ value: sub, type: type });
    } else if (char === '%') {
      // when found rails i18n syntax, skip text capture
      if (format[(position)] !== '{') {
        text += char;
      }
    } else {
      text += char;
    }
  }

  text && tokens.push({ type: 'text', value: text });

  return tokens
}

function compile (tokens, values) {
  var compiled = [];
  var index = 0;

  var mode = Array.isArray(values)
    ? 'list'
    : isObject(values)
      ? 'named'
      : 'unknown';
  if (mode === 'unknown') { return compiled }

  while (index < tokens.length) {
    var token = tokens[index];
    switch (token.type) {
      case 'text':
        compiled.push(token.value);
        break
      case 'list':
        compiled.push(values[parseInt(token.value, 10)]);
        break
      case 'named':
        if (mode === 'named') {
          compiled.push((values)[token.value]);
        } else {
          if (true) {
            warn(("Type of token '" + (token.type) + "' and format of value '" + mode + "' don't match!"));
          }
        }
        break
      case 'unknown':
        if (true) {
          warn("Detect 'unknown' type of token!");
        }
        break
    }
    index++;
  }

  return compiled
}

/*  */

/**
 *  Path parser
 *  - Inspired:
 *    Vue.js Path parser
 */

// actions
var APPEND = 0;
var PUSH = 1;
var INC_SUB_PATH_DEPTH = 2;
var PUSH_SUB_PATH = 3;

// states
var BEFORE_PATH = 0;
var IN_PATH = 1;
var BEFORE_IDENT = 2;
var IN_IDENT = 3;
var IN_SUB_PATH = 4;
var IN_SINGLE_QUOTE = 5;
var IN_DOUBLE_QUOTE = 6;
var AFTER_PATH = 7;
var ERROR = 8;

var pathStateMachine = [];

pathStateMachine[BEFORE_PATH] = {
  'ws': [BEFORE_PATH],
  'ident': [IN_IDENT, APPEND],
  '[': [IN_SUB_PATH],
  'eof': [AFTER_PATH]
};

pathStateMachine[IN_PATH] = {
  'ws': [IN_PATH],
  '.': [BEFORE_IDENT],
  '[': [IN_SUB_PATH],
  'eof': [AFTER_PATH]
};

pathStateMachine[BEFORE_IDENT] = {
  'ws': [BEFORE_IDENT],
  'ident': [IN_IDENT, APPEND],
  '0': [IN_IDENT, APPEND],
  'number': [IN_IDENT, APPEND]
};

pathStateMachine[IN_IDENT] = {
  'ident': [IN_IDENT, APPEND],
  '0': [IN_IDENT, APPEND],
  'number': [IN_IDENT, APPEND],
  'ws': [IN_PATH, PUSH],
  '.': [BEFORE_IDENT, PUSH],
  '[': [IN_SUB_PATH, PUSH],
  'eof': [AFTER_PATH, PUSH]
};

pathStateMachine[IN_SUB_PATH] = {
  "'": [IN_SINGLE_QUOTE, APPEND],
  '"': [IN_DOUBLE_QUOTE, APPEND],
  '[': [IN_SUB_PATH, INC_SUB_PATH_DEPTH],
  ']': [IN_PATH, PUSH_SUB_PATH],
  'eof': ERROR,
  'else': [IN_SUB_PATH, APPEND]
};

pathStateMachine[IN_SINGLE_QUOTE] = {
  "'": [IN_SUB_PATH, APPEND],
  'eof': ERROR,
  'else': [IN_SINGLE_QUOTE, APPEND]
};

pathStateMachine[IN_DOUBLE_QUOTE] = {
  '"': [IN_SUB_PATH, APPEND],
  'eof': ERROR,
  'else': [IN_DOUBLE_QUOTE, APPEND]
};

/**
 * Check if an expression is a literal value.
 */

var literalValueRE = /^\s?(?:true|false|-?[\d.]+|'[^']*'|"[^"]*")\s?$/;
function isLiteral (exp) {
  return literalValueRE.test(exp)
}

/**
 * Strip quotes from a string
 */

function stripQuotes (str) {
  var a = str.charCodeAt(0);
  var b = str.charCodeAt(str.length - 1);
  return a === b && (a === 0x22 || a === 0x27)
    ? str.slice(1, -1)
    : str
}

/**
 * Determine the type of a character in a keypath.
 */

function getPathCharType (ch) {
  if (ch === undefined || ch === null) { return 'eof' }

  var code = ch.charCodeAt(0);

  switch (code) {
    case 0x5B: // [
    case 0x5D: // ]
    case 0x2E: // .
    case 0x22: // "
    case 0x27: // '
      return ch

    case 0x5F: // _
    case 0x24: // $
    case 0x2D: // -
      return 'ident'

    case 0x09: // Tab
    case 0x0A: // Newline
    case 0x0D: // Return
    case 0xA0:  // No-break space
    case 0xFEFF:  // Byte Order Mark
    case 0x2028:  // Line Separator
    case 0x2029:  // Paragraph Separator
      return 'ws'
  }

  return 'ident'
}

/**
 * Format a subPath, return its plain form if it is
 * a literal string or number. Otherwise prepend the
 * dynamic indicator (*).
 */

function formatSubPath (path) {
  var trimmed = path.trim();
  // invalid leading 0
  if (path.charAt(0) === '0' && isNaN(path)) { return false }

  return isLiteral(trimmed) ? stripQuotes(trimmed) : '*' + trimmed
}

/**
 * Parse a string path into an array of segments
 */

function parse$1 (path) {
  var keys = [];
  var index = -1;
  var mode = BEFORE_PATH;
  var subPathDepth = 0;
  var c;
  var key;
  var newChar;
  var type;
  var transition;
  var action;
  var typeMap;
  var actions = [];

  actions[PUSH] = function () {
    if (key !== undefined) {
      keys.push(key);
      key = undefined;
    }
  };

  actions[APPEND] = function () {
    if (key === undefined) {
      key = newChar;
    } else {
      key += newChar;
    }
  };

  actions[INC_SUB_PATH_DEPTH] = function () {
    actions[APPEND]();
    subPathDepth++;
  };

  actions[PUSH_SUB_PATH] = function () {
    if (subPathDepth > 0) {
      subPathDepth--;
      mode = IN_SUB_PATH;
      actions[APPEND]();
    } else {
      subPathDepth = 0;
      if (key === undefined) { return false }
      key = formatSubPath(key);
      if (key === false) {
        return false
      } else {
        actions[PUSH]();
      }
    }
  };

  function maybeUnescapeQuote () {
    var nextChar = path[index + 1];
    if ((mode === IN_SINGLE_QUOTE && nextChar === "'") ||
      (mode === IN_DOUBLE_QUOTE && nextChar === '"')) {
      index++;
      newChar = '\\' + nextChar;
      actions[APPEND]();
      return true
    }
  }

  while (mode !== null) {
    index++;
    c = path[index];

    if (c === '\\' && maybeUnescapeQuote()) {
      continue
    }

    type = getPathCharType(c);
    typeMap = pathStateMachine[mode];
    transition = typeMap[type] || typeMap['else'] || ERROR;

    if (transition === ERROR) {
      return // parse error
    }

    mode = transition[0];
    action = actions[transition[1]];
    if (action) {
      newChar = transition[2];
      newChar = newChar === undefined
        ? c
        : newChar;
      if (action() === false) {
        return
      }
    }

    if (mode === AFTER_PATH) {
      return keys
    }
  }
}





var I18nPath = function I18nPath () {
  this._cache = Object.create(null);
};

/**
 * External parse that check for a cache hit first
 */
I18nPath.prototype.parsePath = function parsePath (path) {
  var hit = this._cache[path];
  if (!hit) {
    hit = parse$1(path);
    if (hit) {
      this._cache[path] = hit;
    }
  }
  return hit || []
};

/**
 * Get path value from path string
 */
I18nPath.prototype.getPathValue = function getPathValue (obj, path) {
  if (!isObject(obj)) { return null }

  var paths = this.parsePath(path);
  if (paths.length === 0) {
    return null
  } else {
    var length = paths.length;
    var last = obj;
    var i = 0;
    while (i < length) {
      var value = last[paths[i]];
      if (value === undefined) {
        return null
      }
      last = value;
      i++;
    }

    return last
  }
};

/*  */



var htmlTagMatcher = /<\/?[\w\s="/.':;#-\/]+>/;
var linkKeyMatcher = /(?:@(?:\.[a-z]+)?:(?:[\w\-_|.]+|\([\w\-_|.]+\)))/g;
var linkKeyPrefixMatcher = /^@(?:\.([a-z]+))?:/;
var bracketsMatcher = /[()]/g;
var defaultModifiers = {
  'upper': function (str) { return str.toLocaleUpperCase(); },
  'lower': function (str) { return str.toLocaleLowerCase(); },
  'capitalize': function (str) { return ("" + (str.charAt(0).toLocaleUpperCase()) + (str.substr(1))); }
};

var defaultFormatter = new BaseFormatter();

var VueI18n = function VueI18n (options) {
  var this$1 = this;
  if ( options === void 0 ) options = {};

  // Auto install if it is not done yet and `window` has `Vue`.
  // To allow users to avoid auto-installation in some cases,
  // this code should be placed here. See #290
  /* istanbul ignore if */
  if (!Vue && typeof window !== 'undefined' && window.Vue) {
    install(window.Vue);
  }

  var locale = options.locale || 'en-US';
  var fallbackLocale = options.fallbackLocale === false
    ? false
    : options.fallbackLocale || 'en-US';
  var messages = options.messages || {};
  var dateTimeFormats = options.dateTimeFormats || {};
  var numberFormats = options.numberFormats || {};

  this._vm = null;
  this._formatter = options.formatter || defaultFormatter;
  this._modifiers = options.modifiers || {};
  this._missing = options.missing || null;
  this._root = options.root || null;
  this._sync = options.sync === undefined ? true : !!options.sync;
  this._fallbackRoot = options.fallbackRoot === undefined
    ? true
    : !!options.fallbackRoot;
  this._formatFallbackMessages = options.formatFallbackMessages === undefined
    ? false
    : !!options.formatFallbackMessages;
  this._silentTranslationWarn = options.silentTranslationWarn === undefined
    ? false
    : options.silentTranslationWarn;
  this._silentFallbackWarn = options.silentFallbackWarn === undefined
    ? false
    : !!options.silentFallbackWarn;
  this._dateTimeFormatters = {};
  this._numberFormatters = {};
  this._path = new I18nPath();
  this._dataListeners = [];
  this._preserveDirectiveContent = options.preserveDirectiveContent === undefined
    ? false
    : !!options.preserveDirectiveContent;
  this.pluralizationRules = options.pluralizationRules || {};
  this._warnHtmlInMessage = options.warnHtmlInMessage || 'off';
  this._postTranslation = options.postTranslation || null;

  this._exist = function (message, key) {
    if (!message || !key) { return false }
    if (!isNull(this$1._path.getPathValue(message, key))) { return true }
    // fallback for flat key
    if (message[key]) { return true }
    return false
  };

  if (this._warnHtmlInMessage === 'warn' || this._warnHtmlInMessage === 'error') {
    Object.keys(messages).forEach(function (locale) {
      this$1._checkLocaleMessage(locale, this$1._warnHtmlInMessage, messages[locale]);
    });
  }

  this._initVM({
    locale: locale,
    fallbackLocale: fallbackLocale,
    messages: messages,
    dateTimeFormats: dateTimeFormats,
    numberFormats: numberFormats
  });
};

var prototypeAccessors = { vm: { configurable: true },messages: { configurable: true },dateTimeFormats: { configurable: true },numberFormats: { configurable: true },availableLocales: { configurable: true },locale: { configurable: true },fallbackLocale: { configurable: true },formatFallbackMessages: { configurable: true },missing: { configurable: true },formatter: { configurable: true },silentTranslationWarn: { configurable: true },silentFallbackWarn: { configurable: true },preserveDirectiveContent: { configurable: true },warnHtmlInMessage: { configurable: true },postTranslation: { configurable: true } };

VueI18n.prototype._checkLocaleMessage = function _checkLocaleMessage (locale, level, message) {
  var paths = [];

  var fn = function (level, locale, message, paths) {
    if (isPlainObject(message)) {
      Object.keys(message).forEach(function (key) {
        var val = message[key];
        if (isPlainObject(val)) {
          paths.push(key);
          paths.push('.');
          fn(level, locale, val, paths);
          paths.pop();
          paths.pop();
        } else {
          paths.push(key);
          fn(level, locale, val, paths);
          paths.pop();
        }
      });
    } else if (Array.isArray(message)) {
      message.forEach(function (item, index) {
        if (isPlainObject(item)) {
          paths.push(("[" + index + "]"));
          paths.push('.');
          fn(level, locale, item, paths);
          paths.pop();
          paths.pop();
        } else {
          paths.push(("[" + index + "]"));
          fn(level, locale, item, paths);
          paths.pop();
        }
      });
    } else if (isString(message)) {
      var ret = htmlTagMatcher.test(message);
      if (ret) {
        var msg = "Detected HTML in message '" + message + "' of keypath '" + (paths.join('')) + "' at '" + locale + "'. Consider component interpolation with '<i18n>' to avoid XSS. See https://bit.ly/2ZqJzkp";
        if (level === 'warn') {
          warn(msg);
        } else if (level === 'error') {
          error(msg);
        }
      }
    }
  };

  fn(level, locale, message, paths);
};

VueI18n.prototype._initVM = function _initVM (data) {
  var silent = Vue.config.silent;
  Vue.config.silent = true;
  this._vm = new Vue({ data: data });
  Vue.config.silent = silent;
};

VueI18n.prototype.destroyVM = function destroyVM () {
  this._vm.$destroy();
};

VueI18n.prototype.subscribeDataChanging = function subscribeDataChanging (vm) {
  this._dataListeners.push(vm);
};

VueI18n.prototype.unsubscribeDataChanging = function unsubscribeDataChanging (vm) {
  remove(this._dataListeners, vm);
};

VueI18n.prototype.watchI18nData = function watchI18nData () {
  var self = this;
  return this._vm.$watch('$data', function () {
    var i = self._dataListeners.length;
    while (i--) {
      Vue.nextTick(function () {
        self._dataListeners[i] && self._dataListeners[i].$forceUpdate();
      });
    }
  }, { deep: true })
};

VueI18n.prototype.watchLocale = function watchLocale () {
  /* istanbul ignore if */
  if (!this._sync || !this._root) { return null }
  var target = this._vm;
  return this._root.$i18n.vm.$watch('locale', function (val) {
    target.$set(target, 'locale', val);
    target.$forceUpdate();
  }, { immediate: true })
};

prototypeAccessors.vm.get = function () { return this._vm };

prototypeAccessors.messages.get = function () { return looseClone(this._getMessages()) };
prototypeAccessors.dateTimeFormats.get = function () { return looseClone(this._getDateTimeFormats()) };
prototypeAccessors.numberFormats.get = function () { return looseClone(this._getNumberFormats()) };
prototypeAccessors.availableLocales.get = function () { return Object.keys(this.messages).sort() };

prototypeAccessors.locale.get = function () { return this._vm.locale };
prototypeAccessors.locale.set = function (locale) {
  this._vm.$set(this._vm, 'locale', locale);
};

prototypeAccessors.fallbackLocale.get = function () { return this._vm.fallbackLocale };
prototypeAccessors.fallbackLocale.set = function (locale) {
  this._localeChainCache = {};
  this._vm.$set(this._vm, 'fallbackLocale', locale);
};

prototypeAccessors.formatFallbackMessages.get = function () { return this._formatFallbackMessages };
prototypeAccessors.formatFallbackMessages.set = function (fallback) { this._formatFallbackMessages = fallback; };

prototypeAccessors.missing.get = function () { return this._missing };
prototypeAccessors.missing.set = function (handler) { this._missing = handler; };

prototypeAccessors.formatter.get = function () { return this._formatter };
prototypeAccessors.formatter.set = function (formatter) { this._formatter = formatter; };

prototypeAccessors.silentTranslationWarn.get = function () { return this._silentTranslationWarn };
prototypeAccessors.silentTranslationWarn.set = function (silent) { this._silentTranslationWarn = silent; };

prototypeAccessors.silentFallbackWarn.get = function () { return this._silentFallbackWarn };
prototypeAccessors.silentFallbackWarn.set = function (silent) { this._silentFallbackWarn = silent; };

prototypeAccessors.preserveDirectiveContent.get = function () { return this._preserveDirectiveContent };
prototypeAccessors.preserveDirectiveContent.set = function (preserve) { this._preserveDirectiveContent = preserve; };

prototypeAccessors.warnHtmlInMessage.get = function () { return this._warnHtmlInMessage };
prototypeAccessors.warnHtmlInMessage.set = function (level) {
    var this$1 = this;

  var orgLevel = this._warnHtmlInMessage;
  this._warnHtmlInMessage = level;
  if (orgLevel !== level && (level === 'warn' || level === 'error')) {
    var messages = this._getMessages();
    Object.keys(messages).forEach(function (locale) {
      this$1._checkLocaleMessage(locale, this$1._warnHtmlInMessage, messages[locale]);
    });
  }
};

prototypeAccessors.postTranslation.get = function () { return this._postTranslation };
prototypeAccessors.postTranslation.set = function (handler) { this._postTranslation = handler; };

VueI18n.prototype._getMessages = function _getMessages () { return this._vm.messages };
VueI18n.prototype._getDateTimeFormats = function _getDateTimeFormats () { return this._vm.dateTimeFormats };
VueI18n.prototype._getNumberFormats = function _getNumberFormats () { return this._vm.numberFormats };

VueI18n.prototype._warnDefault = function _warnDefault (locale, key, result, vm, values, interpolateMode) {
  if (!isNull(result)) { return result }
  if (this._missing) {
    var missingRet = this._missing.apply(null, [locale, key, vm, values]);
    if (isString(missingRet)) {
      return missingRet
    }
  } else {
    if ( true && !this._isSilentTranslationWarn(key)) {
      warn(
        "Cannot translate the value of keypath '" + key + "'. " +
        'Use the value of keypath as default.'
      );
    }
  }

  if (this._formatFallbackMessages) {
    var parsedArgs = parseArgs.apply(void 0, values);
    return this._render(key, interpolateMode, parsedArgs.params, key)
  } else {
    return key
  }
};

VueI18n.prototype._isFallbackRoot = function _isFallbackRoot (val) {
  return !val && !isNull(this._root) && this._fallbackRoot
};

VueI18n.prototype._isSilentFallbackWarn = function _isSilentFallbackWarn (key) {
  return this._silentFallbackWarn instanceof RegExp
    ? this._silentFallbackWarn.test(key)
    : this._silentFallbackWarn
};

VueI18n.prototype._isSilentFallback = function _isSilentFallback (locale, key) {
  return this._isSilentFallbackWarn(key) && (this._isFallbackRoot() || locale !== this.fallbackLocale)
};

VueI18n.prototype._isSilentTranslationWarn = function _isSilentTranslationWarn (key) {
  return this._silentTranslationWarn instanceof RegExp
    ? this._silentTranslationWarn.test(key)
    : this._silentTranslationWarn
};

VueI18n.prototype._interpolate = function _interpolate (
  locale,
  message,
  key,
  host,
  interpolateMode,
  values,
  visitedLinkStack
) {
  if (!message) { return null }

  var pathRet = this._path.getPathValue(message, key);
  if (Array.isArray(pathRet) || isPlainObject(pathRet)) { return pathRet }

  var ret;
  if (isNull(pathRet)) {
    /* istanbul ignore else */
    if (isPlainObject(message)) {
      ret = message[key];
      if (!isString(ret)) {
        if ( true && !this._isSilentTranslationWarn(key) && !this._isSilentFallback(locale, key)) {
          warn(("Value of key '" + key + "' is not a string!"));
        }
        return null
      }
    } else {
      return null
    }
  } else {
    /* istanbul ignore else */
    if (isString(pathRet)) {
      ret = pathRet;
    } else {
      if ( true && !this._isSilentTranslationWarn(key) && !this._isSilentFallback(locale, key)) {
        warn(("Value of key '" + key + "' is not a string!"));
      }
      return null
    }
  }

  // Check for the existence of links within the translated string
  if (ret.indexOf('@:') >= 0 || ret.indexOf('@.') >= 0) {
    ret = this._link(locale, message, ret, host, 'raw', values, visitedLinkStack);
  }

  return this._render(ret, interpolateMode, values, key)
};

VueI18n.prototype._link = function _link (
  locale,
  message,
  str,
  host,
  interpolateMode,
  values,
  visitedLinkStack
) {
  var ret = str;

  // Match all the links within the local
  // We are going to replace each of
  // them with its translation
  var matches = ret.match(linkKeyMatcher);
  for (var idx in matches) {
    // ie compatible: filter custom array
    // prototype method
    if (!matches.hasOwnProperty(idx)) {
      continue
    }
    var link = matches[idx];
    var linkKeyPrefixMatches = link.match(linkKeyPrefixMatcher);
    var linkPrefix = linkKeyPrefixMatches[0];
      var formatterName = linkKeyPrefixMatches[1];

    // Remove the leading @:, @.case: and the brackets
    var linkPlaceholder = link.replace(linkPrefix, '').replace(bracketsMatcher, '');

    if (includes(visitedLinkStack, linkPlaceholder)) {
      if (true) {
        warn(("Circular reference found. \"" + link + "\" is already visited in the chain of " + (visitedLinkStack.reverse().join(' <- '))));
      }
      return ret
    }
    visitedLinkStack.push(linkPlaceholder);

    // Translate the link
    var translated = this._interpolate(
      locale, message, linkPlaceholder, host,
      interpolateMode === 'raw' ? 'string' : interpolateMode,
      interpolateMode === 'raw' ? undefined : values,
      visitedLinkStack
    );

    if (this._isFallbackRoot(translated)) {
      if ( true && !this._isSilentTranslationWarn(linkPlaceholder)) {
        warn(("Fall back to translate the link placeholder '" + linkPlaceholder + "' with root locale."));
      }
      /* istanbul ignore if */
      if (!this._root) { throw Error('unexpected error') }
      var root = this._root.$i18n;
      translated = root._translate(
        root._getMessages(), root.locale, root.fallbackLocale,
        linkPlaceholder, host, interpolateMode, values
      );
    }
    translated = this._warnDefault(
      locale, linkPlaceholder, translated, host,
      Array.isArray(values) ? values : [values],
      interpolateMode
    );

    if (this._modifiers.hasOwnProperty(formatterName)) {
      translated = this._modifiers[formatterName](translated);
    } else if (defaultModifiers.hasOwnProperty(formatterName)) {
      translated = defaultModifiers[formatterName](translated);
    }

    visitedLinkStack.pop();

    // Replace the link with the translated
    ret = !translated ? ret : ret.replace(link, translated);
  }

  return ret
};

VueI18n.prototype._render = function _render (message, interpolateMode, values, path) {
  var ret = this._formatter.interpolate(message, values, path);

  // If the custom formatter refuses to work - apply the default one
  if (!ret) {
    ret = defaultFormatter.interpolate(message, values, path);
  }

  // if interpolateMode is **not** 'string' ('row'),
  // return the compiled data (e.g. ['foo', VNode, 'bar']) with formatter
  return interpolateMode === 'string' && !isString(ret) ? ret.join('') : ret
};

VueI18n.prototype._appendItemToChain = function _appendItemToChain (chain, item, blocks) {
  var follow = false;
  if (!includes(chain, item)) {
    follow = true;
    if (item) {
      follow = item[item.length - 1] !== '!';
      item = item.replace(/!/g, '');
      chain.push(item);
      if (blocks && blocks[item]) {
        follow = blocks[item];
      }
    }
  }
  return follow
};

VueI18n.prototype._appendLocaleToChain = function _appendLocaleToChain (chain, locale, blocks) {
  var follow;
  var tokens = locale.split('-');
  do {
    var item = tokens.join('-');
    follow = this._appendItemToChain(chain, item, blocks);
    tokens.splice(-1, 1);
  } while (tokens.length && (follow === true))
  return follow
};

VueI18n.prototype._appendBlockToChain = function _appendBlockToChain (chain, block, blocks) {
  var follow = true;
  for (var i = 0; (i < block.length) && (isBoolean(follow)); i++) {
    var locale = block[i];
    if (isString(locale)) {
      follow = this._appendLocaleToChain(chain, locale, blocks);
    }
  }
  return follow
};

VueI18n.prototype._getLocaleChain = function _getLocaleChain (start, fallbackLocale) {
  if (start === '') { return [] }

  if (!this._localeChainCache) {
    this._localeChainCache = {};
  }

  var chain = this._localeChainCache[start];
  if (!chain) {
    if (!fallbackLocale) {
      fallbackLocale = this.fallbackLocale;
    }
    chain = [];

    // first block defined by start
    var block = [start];

    // while any intervening block found
    while (isArray(block)) {
      block = this._appendBlockToChain(
        chain,
        block,
        fallbackLocale
      );
    }

    // last block defined by default
    var defaults;
    if (isArray(fallbackLocale)) {
      defaults = fallbackLocale;
    } else if (isObject(fallbackLocale)) {
      if (fallbackLocale['default']) {
        defaults = fallbackLocale['default'];
      } else {
        defaults = null;
      }
    } else {
      defaults = fallbackLocale;
    }

    // convert defaults to array
    if (isString(defaults)) {
      block = [defaults];
    } else {
      block = defaults;
    }
    if (block) {
      this._appendBlockToChain(
        chain,
        block,
        null
      );
    }
    this._localeChainCache[start] = chain;
  }
  return chain
};

VueI18n.prototype._translate = function _translate (
  messages,
  locale,
  fallback,
  key,
  host,
  interpolateMode,
  args
) {
  var chain = this._getLocaleChain(locale, fallback);
  var res;
  for (var i = 0; i < chain.length; i++) {
    var step = chain[i];
    res =
      this._interpolate(step, messages[step], key, host, interpolateMode, args, [key]);
    if (!isNull(res)) {
      if (step !== locale && "development" !== 'production' && !this._isSilentTranslationWarn(key) && !this._isSilentFallbackWarn(key)) {
        warn(("Fall back to translate the keypath '" + key + "' with '" + step + "' locale."));
      }
      return res
    }
  }
  return null
};

VueI18n.prototype._t = function _t (key, _locale, messages, host) {
    var ref;

    var values = [], len = arguments.length - 4;
    while ( len-- > 0 ) values[ len ] = arguments[ len + 4 ];
  if (!key) { return '' }

  var parsedArgs = parseArgs.apply(void 0, values);
  var locale = parsedArgs.locale || _locale;

  var ret = this._translate(
    messages, locale, this.fallbackLocale, key,
    host, 'string', parsedArgs.params
  );
  if (this._isFallbackRoot(ret)) {
    if ( true && !this._isSilentTranslationWarn(key) && !this._isSilentFallbackWarn(key)) {
      warn(("Fall back to translate the keypath '" + key + "' with root locale."));
    }
    /* istanbul ignore if */
    if (!this._root) { throw Error('unexpected error') }
    return (ref = this._root).$t.apply(ref, [ key ].concat( values ))
  } else {
    ret = this._warnDefault(locale, key, ret, host, values, 'string');
    if (this._postTranslation && ret !== null && ret !== undefined) {
      ret = this._postTranslation(ret, key);
    }
    return ret
  }
};

VueI18n.prototype.t = function t (key) {
    var ref;

    var values = [], len = arguments.length - 1;
    while ( len-- > 0 ) values[ len ] = arguments[ len + 1 ];
  return (ref = this)._t.apply(ref, [ key, this.locale, this._getMessages(), null ].concat( values ))
};

VueI18n.prototype._i = function _i (key, locale, messages, host, values) {
  var ret =
    this._translate(messages, locale, this.fallbackLocale, key, host, 'raw', values);
  if (this._isFallbackRoot(ret)) {
    if ( true && !this._isSilentTranslationWarn(key)) {
      warn(("Fall back to interpolate the keypath '" + key + "' with root locale."));
    }
    if (!this._root) { throw Error('unexpected error') }
    return this._root.$i18n.i(key, locale, values)
  } else {
    return this._warnDefault(locale, key, ret, host, [values], 'raw')
  }
};

VueI18n.prototype.i = function i (key, locale, values) {
  /* istanbul ignore if */
  if (!key) { return '' }

  if (!isString(locale)) {
    locale = this.locale;
  }

  return this._i(key, locale, this._getMessages(), null, values)
};

VueI18n.prototype._tc = function _tc (
  key,
  _locale,
  messages,
  host,
  choice
) {
    var ref;

    var values = [], len = arguments.length - 5;
    while ( len-- > 0 ) values[ len ] = arguments[ len + 5 ];
  if (!key) { return '' }
  if (choice === undefined) {
    choice = 1;
  }

  var predefined = { 'count': choice, 'n': choice };
  var parsedArgs = parseArgs.apply(void 0, values);
  parsedArgs.params = Object.assign(predefined, parsedArgs.params);
  values = parsedArgs.locale === null ? [parsedArgs.params] : [parsedArgs.locale, parsedArgs.params];
  return this.fetchChoice((ref = this)._t.apply(ref, [ key, _locale, messages, host ].concat( values )), choice)
};

VueI18n.prototype.fetchChoice = function fetchChoice (message, choice) {
  /* istanbul ignore if */
  if (!message && !isString(message)) { return null }
  var choices = message.split('|');

  choice = this.getChoiceIndex(choice, choices.length);
  if (!choices[choice]) { return message }
  return choices[choice].trim()
};

/**
 * @param choice {number} a choice index given by the input to $tc: `$tc('path.to.rule', choiceIndex)`
 * @param choicesLength {number} an overall amount of available choices
 * @returns a final choice index
*/
VueI18n.prototype.getChoiceIndex = function getChoiceIndex (choice, choicesLength) {
  // Default (old) getChoiceIndex implementation - english-compatible
  var defaultImpl = function (_choice, _choicesLength) {
    _choice = Math.abs(_choice);

    if (_choicesLength === 2) {
      return _choice
        ? _choice > 1
          ? 1
          : 0
        : 1
    }

    return _choice ? Math.min(_choice, 2) : 0
  };

  if (this.locale in this.pluralizationRules) {
    return this.pluralizationRules[this.locale].apply(this, [choice, choicesLength])
  } else {
    return defaultImpl(choice, choicesLength)
  }
};

VueI18n.prototype.tc = function tc (key, choice) {
    var ref;

    var values = [], len = arguments.length - 2;
    while ( len-- > 0 ) values[ len ] = arguments[ len + 2 ];
  return (ref = this)._tc.apply(ref, [ key, this.locale, this._getMessages(), null, choice ].concat( values ))
};

VueI18n.prototype._te = function _te (key, locale, messages) {
    var args = [], len = arguments.length - 3;
    while ( len-- > 0 ) args[ len ] = arguments[ len + 3 ];

  var _locale = parseArgs.apply(void 0, args).locale || locale;
  return this._exist(messages[_locale], key)
};

VueI18n.prototype.te = function te (key, locale) {
  return this._te(key, this.locale, this._getMessages(), locale)
};

VueI18n.prototype.getLocaleMessage = function getLocaleMessage (locale) {
  return looseClone(this._vm.messages[locale] || {})
};

VueI18n.prototype.setLocaleMessage = function setLocaleMessage (locale, message) {
  if (this._warnHtmlInMessage === 'warn' || this._warnHtmlInMessage === 'error') {
    this._checkLocaleMessage(locale, this._warnHtmlInMessage, message);
  }
  this._vm.$set(this._vm.messages, locale, message);
};

VueI18n.prototype.mergeLocaleMessage = function mergeLocaleMessage (locale, message) {
  if (this._warnHtmlInMessage === 'warn' || this._warnHtmlInMessage === 'error') {
    this._checkLocaleMessage(locale, this._warnHtmlInMessage, message);
  }
  this._vm.$set(this._vm.messages, locale, merge({}, this._vm.messages[locale] || {}, message));
};

VueI18n.prototype.getDateTimeFormat = function getDateTimeFormat (locale) {
  return looseClone(this._vm.dateTimeFormats[locale] || {})
};

VueI18n.prototype.setDateTimeFormat = function setDateTimeFormat (locale, format) {
  this._vm.$set(this._vm.dateTimeFormats, locale, format);
  this._clearDateTimeFormat(locale, format);
};

VueI18n.prototype.mergeDateTimeFormat = function mergeDateTimeFormat (locale, format) {
  this._vm.$set(this._vm.dateTimeFormats, locale, merge(this._vm.dateTimeFormats[locale] || {}, format));
  this._clearDateTimeFormat(locale, format);
};

VueI18n.prototype._clearDateTimeFormat = function _clearDateTimeFormat (locale, format) {
  for (var key in format) {
    var id = locale + "__" + key;

    if (!this._dateTimeFormatters.hasOwnProperty(id)) {
      continue
    }

    delete this._dateTimeFormatters[id];
  }
};

VueI18n.prototype._localizeDateTime = function _localizeDateTime (
  value,
  locale,
  fallback,
  dateTimeFormats,
  key
) {
  var _locale = locale;
  var formats = dateTimeFormats[_locale];

  var chain = this._getLocaleChain(locale, fallback);
  for (var i = 0; i < chain.length; i++) {
    var current = _locale;
    var step = chain[i];
    formats = dateTimeFormats[step];
    _locale = step;
    // fallback locale
    if (isNull(formats) || isNull(formats[key])) {
      if (step !== locale && "development" !== 'production' && !this._isSilentTranslationWarn(key) && !this._isSilentFallbackWarn(key)) {
        warn(("Fall back to '" + step + "' datetime formats from '" + current + "' datetime formats."));
      }
    } else {
      break
    }
  }

  if (isNull(formats) || isNull(formats[key])) {
    return null
  } else {
    var format = formats[key];
    var id = _locale + "__" + key;
    var formatter = this._dateTimeFormatters[id];
    if (!formatter) {
      formatter = this._dateTimeFormatters[id] = new Intl.DateTimeFormat(_locale, format);
    }
    return formatter.format(value)
  }
};

VueI18n.prototype._d = function _d (value, locale, key) {
  /* istanbul ignore if */
  if ( true && !VueI18n.availabilities.dateTimeFormat) {
    warn('Cannot format a Date value due to not supported Intl.DateTimeFormat.');
    return ''
  }

  if (!key) {
    return new Intl.DateTimeFormat(locale).format(value)
  }

  var ret =
    this._localizeDateTime(value, locale, this.fallbackLocale, this._getDateTimeFormats(), key);
  if (this._isFallbackRoot(ret)) {
    if ( true && !this._isSilentTranslationWarn(key) && !this._isSilentFallbackWarn(key)) {
      warn(("Fall back to datetime localization of root: key '" + key + "'."));
    }
    /* istanbul ignore if */
    if (!this._root) { throw Error('unexpected error') }
    return this._root.$i18n.d(value, key, locale)
  } else {
    return ret || ''
  }
};

VueI18n.prototype.d = function d (value) {
    var args = [], len = arguments.length - 1;
    while ( len-- > 0 ) args[ len ] = arguments[ len + 1 ];

  var locale = this.locale;
  var key = null;

  if (args.length === 1) {
    if (isString(args[0])) {
      key = args[0];
    } else if (isObject(args[0])) {
      if (args[0].locale) {
        locale = args[0].locale;
      }
      if (args[0].key) {
        key = args[0].key;
      }
    }
  } else if (args.length === 2) {
    if (isString(args[0])) {
      key = args[0];
    }
    if (isString(args[1])) {
      locale = args[1];
    }
  }

  return this._d(value, locale, key)
};

VueI18n.prototype.getNumberFormat = function getNumberFormat (locale) {
  return looseClone(this._vm.numberFormats[locale] || {})
};

VueI18n.prototype.setNumberFormat = function setNumberFormat (locale, format) {
  this._vm.$set(this._vm.numberFormats, locale, format);
  this._clearNumberFormat(locale, format);
};

VueI18n.prototype.mergeNumberFormat = function mergeNumberFormat (locale, format) {
  this._vm.$set(this._vm.numberFormats, locale, merge(this._vm.numberFormats[locale] || {}, format));
  this._clearNumberFormat(locale, format);
};

VueI18n.prototype._clearNumberFormat = function _clearNumberFormat (locale, format) {
  for (var key in format) {
    var id = locale + "__" + key;

    if (!this._numberFormatters.hasOwnProperty(id)) {
      continue
    }

    delete this._numberFormatters[id];
  }
};

VueI18n.prototype._getNumberFormatter = function _getNumberFormatter (
  value,
  locale,
  fallback,
  numberFormats,
  key,
  options
) {
  var _locale = locale;
  var formats = numberFormats[_locale];

  var chain = this._getLocaleChain(locale, fallback);
  for (var i = 0; i < chain.length; i++) {
    var current = _locale;
    var step = chain[i];
    formats = numberFormats[step];
    _locale = step;
    // fallback locale
    if (isNull(formats) || isNull(formats[key])) {
      if (step !== locale && "development" !== 'production' && !this._isSilentTranslationWarn(key) && !this._isSilentFallbackWarn(key)) {
        warn(("Fall back to '" + step + "' number formats from '" + current + "' number formats."));
      }
    } else {
      break
    }
  }

  if (isNull(formats) || isNull(formats[key])) {
    return null
  } else {
    var format = formats[key];

    var formatter;
    if (options) {
      // If options specified - create one time number formatter
      formatter = new Intl.NumberFormat(_locale, Object.assign({}, format, options));
    } else {
      var id = _locale + "__" + key;
      formatter = this._numberFormatters[id];
      if (!formatter) {
        formatter = this._numberFormatters[id] = new Intl.NumberFormat(_locale, format);
      }
    }
    return formatter
  }
};

VueI18n.prototype._n = function _n (value, locale, key, options) {
  /* istanbul ignore if */
  if (!VueI18n.availabilities.numberFormat) {
    if (true) {
      warn('Cannot format a Number value due to not supported Intl.NumberFormat.');
    }
    return ''
  }

  if (!key) {
    var nf = !options ? new Intl.NumberFormat(locale) : new Intl.NumberFormat(locale, options);
    return nf.format(value)
  }

  var formatter = this._getNumberFormatter(value, locale, this.fallbackLocale, this._getNumberFormats(), key, options);
  var ret = formatter && formatter.format(value);
  if (this._isFallbackRoot(ret)) {
    if ( true && !this._isSilentTranslationWarn(key) && !this._isSilentFallbackWarn(key)) {
      warn(("Fall back to number localization of root: key '" + key + "'."));
    }
    /* istanbul ignore if */
    if (!this._root) { throw Error('unexpected error') }
    return this._root.$i18n.n(value, Object.assign({}, { key: key, locale: locale }, options))
  } else {
    return ret || ''
  }
};

VueI18n.prototype.n = function n (value) {
    var args = [], len = arguments.length - 1;
    while ( len-- > 0 ) args[ len ] = arguments[ len + 1 ];

  var locale = this.locale;
  var key = null;
  var options = null;

  if (args.length === 1) {
    if (isString(args[0])) {
      key = args[0];
    } else if (isObject(args[0])) {
      if (args[0].locale) {
        locale = args[0].locale;
      }
      if (args[0].key) {
        key = args[0].key;
      }

      // Filter out number format options only
      options = Object.keys(args[0]).reduce(function (acc, key) {
          var obj;

        if (includes(numberFormatKeys, key)) {
          return Object.assign({}, acc, ( obj = {}, obj[key] = args[0][key], obj ))
        }
        return acc
      }, null);
    }
  } else if (args.length === 2) {
    if (isString(args[0])) {
      key = args[0];
    }
    if (isString(args[1])) {
      locale = args[1];
    }
  }

  return this._n(value, locale, key, options)
};

VueI18n.prototype._ntp = function _ntp (value, locale, key, options) {
  /* istanbul ignore if */
  if (!VueI18n.availabilities.numberFormat) {
    if (true) {
      warn('Cannot format to parts a Number value due to not supported Intl.NumberFormat.');
    }
    return []
  }

  if (!key) {
    var nf = !options ? new Intl.NumberFormat(locale) : new Intl.NumberFormat(locale, options);
    return nf.formatToParts(value)
  }

  var formatter = this._getNumberFormatter(value, locale, this.fallbackLocale, this._getNumberFormats(), key, options);
  var ret = formatter && formatter.formatToParts(value);
  if (this._isFallbackRoot(ret)) {
    if ( true && !this._isSilentTranslationWarn(key)) {
      warn(("Fall back to format number to parts of root: key '" + key + "' ."));
    }
    /* istanbul ignore if */
    if (!this._root) { throw Error('unexpected error') }
    return this._root.$i18n._ntp(value, locale, key, options)
  } else {
    return ret || []
  }
};

Object.defineProperties( VueI18n.prototype, prototypeAccessors );

var availabilities;
// $FlowFixMe
Object.defineProperty(VueI18n, 'availabilities', {
  get: function get () {
    if (!availabilities) {
      var intlDefined = typeof Intl !== 'undefined';
      availabilities = {
        dateTimeFormat: intlDefined && typeof Intl.DateTimeFormat !== 'undefined',
        numberFormat: intlDefined && typeof Intl.NumberFormat !== 'undefined'
      };
    }

    return availabilities
  }
});

VueI18n.install = install;
VueI18n.version = '8.17.6';

/* harmony default export */ __webpack_exports__["default"] = (VueI18n);


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Abilities.vue?vue&type=template&id=2cd6794c&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/abilities/Abilities.vue?vue&type=template&id=2cd6794c& ***!
  \*****************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "viewport box-abilities" },
    [
      _vm.loading
        ? _c("div", { staticClass: "load more text-center" }, [
            _c("i", { staticClass: "fa fa-spin fa-spinner" })
          ])
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "row" },
        _vm._l(_vm.parents, function(parent) {
          return _c("parent", { key: parent.id, attrs: { ability: parent } })
        }),
        1
      ),
      _vm._v(" "),
      _vm.show_parent
        ? _c(
            "div",
            [
              _vm.parent.entry
                ? _c("div", { staticClass: "box box-solid" }, [
                    _c("div", { staticClass: "box-header" }, [
                      _c("span", { staticClass: "box-title" }, [
                        _vm._v(
                          "\n                    " +
                            _vm._s(_vm.parent.name) +
                            "\n                "
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", {
                      staticClass: "box-body",
                      domProps: { innerHTML: _vm._s(_vm.parent.entry) }
                    })
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm._l(_vm.parent.abilities, function(ability) {
                return _c("ability", {
                  key: ability.id,
                  attrs: {
                    ability: ability,
                    permission: _vm.permission,
                    meta: _vm.meta
                  }
                })
              })
            ],
            2
          )
        : _vm._e(),
      _vm._v(" "),
      _vm._l(_vm.abilities, function(ability) {
        return !_vm.show_parent
          ? _c("ability", {
              key: ability.id,
              attrs: {
                ability: ability,
                permission: _vm.permission,
                meta: _vm.meta
              }
            })
          : _vm._e()
      }),
      _vm._v(" "),
      _c("ability_form"),
      _vm._v(" "),
      _vm.waiting
        ? _c("div", { staticClass: "box-waiting" }, [
            _c("i", { staticClass: "fa fa-spin fa-spinner fa-4x" })
          ])
        : _vm._e()
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Ability.vue?vue&type=template&id=28b7eabc&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/abilities/Ability.vue?vue&type=template&id=28b7eabc& ***!
  \***************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "ability" }, [
    _c("div", { staticClass: "box box-solid" }, [
      _c("div", { staticClass: "box-header with-border" }, [
        _c(
          "span",
          { staticClass: "box-title" },
          [
            _vm.permission
              ? _c(
                  "dropdown",
                  {
                    staticClass: "message-options",
                    attrs: { tag: "a", "menu-left": "" }
                  },
                  [
                    _c(
                      "a",
                      {
                        staticClass: "dropdown-toggle",
                        attrs: { role: "button" }
                      },
                      [
                        _vm.ability.visibility === "admin"
                          ? _c("i", {
                              staticClass: "fas fa-lock",
                              attrs: {
                                title: _vm.$t("crud.visibilities.admin")
                              }
                            })
                          : _vm._e(),
                        _vm._v(" "),
                        _vm.ability.visibility === "self"
                          ? _c("i", {
                              staticClass: "fas fa-user-lock",
                              attrs: { title: _vm.$t("crud.visibilities.self") }
                            })
                          : _vm._e(),
                        _vm._v(" "),
                        _vm.ability.visibility === "all"
                          ? _c("i", {
                              staticClass: "fa fa-eye",
                              attrs: { title: _vm.$t("crud.visibilities.all") }
                            })
                          : _vm._e()
                      ]
                    ),
                    _vm._v(" "),
                    _c("template", { slot: "dropdown" }, [
                      _c("li", [
                        _c(
                          "a",
                          {
                            attrs: { role: "button" },
                            on: {
                              click: function($event) {
                                return _vm.setVisibility("all")
                              }
                            }
                          },
                          [_vm._v(_vm._s(_vm.$t("crud.visibilities.all")))]
                        )
                      ]),
                      _vm._v(" "),
                      _vm.meta.is_admin
                        ? _c("li", [
                            _c(
                              "a",
                              {
                                attrs: { role: "button" },
                                on: {
                                  click: function($event) {
                                    return _vm.setVisibility("admin")
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  _vm._s(_vm.$t("crud.visibilities.admin"))
                                )
                              ]
                            )
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      this.isSelf
                        ? _c("li", [
                            _c(
                              "a",
                              {
                                attrs: { role: "button" },
                                on: {
                                  click: function($event) {
                                    return _vm.setVisibility("self")
                                  }
                                }
                              },
                              [_vm._v(_vm._s(_vm.$t("crud.visibilities.self")))]
                            )
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      this.isSelf
                        ? _c("li", [
                            _c(
                              "a",
                              {
                                attrs: { role: "button" },
                                on: {
                                  click: function($event) {
                                    return _vm.setVisibility("admin.self")
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  _vm._s(_vm.$t("crud.visibilities.admin-self"))
                                )
                              ]
                            )
                          ])
                        : _vm._e()
                    ])
                  ],
                  2
                )
              : _vm._e(),
            _vm._v(
              "\n                " + _vm._s(_vm.ability.name) + "\n            "
            )
          ],
          1
        ),
        _vm._v(" "),
        this.canDelete
          ? _c(
              "a",
              {
                staticClass: "pull-right",
                attrs: { role: "button" },
                on: {
                  click: function($event) {
                    return _vm.deleteAbility(_vm.ability)
                  }
                }
              },
              [
                _c("i", { staticClass: "fa fa-trash" }),
                _vm._v(" " + _vm._s(_vm.$t("crud.remove")) + "\n            ")
              ]
            )
          : _vm._e()
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "box-body" }, [
        _c("span", { staticClass: "help-block" }, [
          _vm._v(_vm._s(_vm.ability.type))
        ]),
        _vm._v(" "),
        _c("div", { domProps: { innerHTML: _vm._s(_vm.ability.entry) } }),
        _vm._v(" "),
        _vm.ability.charges
          ? _c("div", [
              _c(
                "div",
                { staticClass: "charges" },
                _vm._l(_vm.ability.charges, function(n) {
                  return _c("div", {
                    staticClass: "charge",
                    class: { used: _vm.ability.used_charges >= n },
                    on: {
                      click: function($event) {
                        return _vm.useCharge(_vm.ability, n)
                      }
                    }
                  })
                }),
                0
              )
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.hasAttribute
          ? _c(
              "div",
              {
                staticClass: "text-center more-available",
                on: {
                  click: function($event) {
                    return _vm.click(_vm.ability)
                  }
                }
              },
              [
                !_vm.details
                  ? _c("i", { staticClass: "fa fa-chevron-down" })
                  : _vm._e()
              ]
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.details && _vm.hasAttribute
          ? _c("div", [
              _c(
                "dl",
                { staticClass: "dl-horizontal" },
                _vm._l(_vm.ability.attributes, function(att) {
                  return _c("div", [
                    att.type == "section"
                      ? _c("div", { staticClass: "panel panel-default" }, [
                          _c("div", { staticClass: "panel-heading" }, [
                            _c("h4", { staticClass: "panel-title" }, [
                              _vm._v(_vm._s(att.name))
                            ])
                          ])
                        ])
                      : _c("div", [
                          _c("dt", [_vm._v(_vm._s(att.name))]),
                          _vm._v(" "),
                          att.type == "checkbox"
                            ? _c("dd", [
                                att.value == 1
                                  ? _c("i", { staticClass: "fa fa-check" })
                                  : _vm._e()
                              ])
                            : _c("dd", {
                                domProps: { innerHTML: _vm._s(att.value) }
                              })
                        ])
                  ])
                }),
                0
              )
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.hasAttribute
          ? _c(
              "div",
              {
                staticClass: "text-center more-available",
                on: {
                  click: function($event) {
                    return _vm.click(_vm.ability)
                  }
                }
              },
              [
                _vm.details
                  ? _c("i", { staticClass: "fa fa-chevron-up" })
                  : _vm._e()
              ]
            )
          : _vm._e()
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=template&id=2745a7a0&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=template&id=2745a7a0& ***!
  \*******************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "modal fade in",
      style: { display: this.modalStyle() },
      attrs: { tabindex: "-1", role: "dialog" }
    },
    [
      _c("div", { staticClass: "modal-dialog", attrs: { role: "document" } }, [
        _c("div", {
          staticClass: "modal-content",
          domProps: { innerHTML: _vm._s(_vm.modalContent) }
        })
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Parent.vue?vue&type=template&id=5dd571f0&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/abilities/Parent.vue?vue&type=template&id=5dd571f0& ***!
  \**************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-xs-4 col-sm-3 col-lg-2 text-center" }, [
    _c(
      "div",
      {
        staticClass: "ability-parent",
        class: { active: _vm.active, without: !_vm.ability.has_image },
        style: _vm.backgroundImage,
        on: {
          click: function($event) {
            return _vm.click(_vm.ability)
          }
        }
      },
      [
        _c("div", { staticClass: "ability-name" }, [
          _c("div", { staticClass: "name" }, [
            _vm._v(
              "\n                " + _vm._s(_vm.ability.name) + "\n            "
            )
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./node_modules/vue/dist/vue.common.dev.js":
/*!*************************************************!*\
  !*** ./node_modules/vue/dist/vue.common.dev.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(global, setImmediate) {/*!
 * Vue.js v2.6.11
 * (c) 2014-2019 Evan You
 * Released under the MIT License.
 */


/*  */

var emptyObject = Object.freeze({});

// These helpers produce better VM code in JS engines due to their
// explicitness and function inlining.
function isUndef (v) {
  return v === undefined || v === null
}

function isDef (v) {
  return v !== undefined && v !== null
}

function isTrue (v) {
  return v === true
}

function isFalse (v) {
  return v === false
}

/**
 * Check if value is primitive.
 */
function isPrimitive (value) {
  return (
    typeof value === 'string' ||
    typeof value === 'number' ||
    // $flow-disable-line
    typeof value === 'symbol' ||
    typeof value === 'boolean'
  )
}

/**
 * Quick object check - this is primarily used to tell
 * Objects from primitive values when we know the value
 * is a JSON-compliant type.
 */
function isObject (obj) {
  return obj !== null && typeof obj === 'object'
}

/**
 * Get the raw type string of a value, e.g., [object Object].
 */
var _toString = Object.prototype.toString;

function toRawType (value) {
  return _toString.call(value).slice(8, -1)
}

/**
 * Strict object type check. Only returns true
 * for plain JavaScript objects.
 */
function isPlainObject (obj) {
  return _toString.call(obj) === '[object Object]'
}

function isRegExp (v) {
  return _toString.call(v) === '[object RegExp]'
}

/**
 * Check if val is a valid array index.
 */
function isValidArrayIndex (val) {
  var n = parseFloat(String(val));
  return n >= 0 && Math.floor(n) === n && isFinite(val)
}

function isPromise (val) {
  return (
    isDef(val) &&
    typeof val.then === 'function' &&
    typeof val.catch === 'function'
  )
}

/**
 * Convert a value to a string that is actually rendered.
 */
function toString (val) {
  return val == null
    ? ''
    : Array.isArray(val) || (isPlainObject(val) && val.toString === _toString)
      ? JSON.stringify(val, null, 2)
      : String(val)
}

/**
 * Convert an input value to a number for persistence.
 * If the conversion fails, return original string.
 */
function toNumber (val) {
  var n = parseFloat(val);
  return isNaN(n) ? val : n
}

/**
 * Make a map and return a function for checking if a key
 * is in that map.
 */
function makeMap (
  str,
  expectsLowerCase
) {
  var map = Object.create(null);
  var list = str.split(',');
  for (var i = 0; i < list.length; i++) {
    map[list[i]] = true;
  }
  return expectsLowerCase
    ? function (val) { return map[val.toLowerCase()]; }
    : function (val) { return map[val]; }
}

/**
 * Check if a tag is a built-in tag.
 */
var isBuiltInTag = makeMap('slot,component', true);

/**
 * Check if an attribute is a reserved attribute.
 */
var isReservedAttribute = makeMap('key,ref,slot,slot-scope,is');

/**
 * Remove an item from an array.
 */
function remove (arr, item) {
  if (arr.length) {
    var index = arr.indexOf(item);
    if (index > -1) {
      return arr.splice(index, 1)
    }
  }
}

/**
 * Check whether an object has the property.
 */
var hasOwnProperty = Object.prototype.hasOwnProperty;
function hasOwn (obj, key) {
  return hasOwnProperty.call(obj, key)
}

/**
 * Create a cached version of a pure function.
 */
function cached (fn) {
  var cache = Object.create(null);
  return (function cachedFn (str) {
    var hit = cache[str];
    return hit || (cache[str] = fn(str))
  })
}

/**
 * Camelize a hyphen-delimited string.
 */
var camelizeRE = /-(\w)/g;
var camelize = cached(function (str) {
  return str.replace(camelizeRE, function (_, c) { return c ? c.toUpperCase() : ''; })
});

/**
 * Capitalize a string.
 */
var capitalize = cached(function (str) {
  return str.charAt(0).toUpperCase() + str.slice(1)
});

/**
 * Hyphenate a camelCase string.
 */
var hyphenateRE = /\B([A-Z])/g;
var hyphenate = cached(function (str) {
  return str.replace(hyphenateRE, '-$1').toLowerCase()
});

/**
 * Simple bind polyfill for environments that do not support it,
 * e.g., PhantomJS 1.x. Technically, we don't need this anymore
 * since native bind is now performant enough in most browsers.
 * But removing it would mean breaking code that was able to run in
 * PhantomJS 1.x, so this must be kept for backward compatibility.
 */

/* istanbul ignore next */
function polyfillBind (fn, ctx) {
  function boundFn (a) {
    var l = arguments.length;
    return l
      ? l > 1
        ? fn.apply(ctx, arguments)
        : fn.call(ctx, a)
      : fn.call(ctx)
  }

  boundFn._length = fn.length;
  return boundFn
}

function nativeBind (fn, ctx) {
  return fn.bind(ctx)
}

var bind = Function.prototype.bind
  ? nativeBind
  : polyfillBind;

/**
 * Convert an Array-like object to a real Array.
 */
function toArray (list, start) {
  start = start || 0;
  var i = list.length - start;
  var ret = new Array(i);
  while (i--) {
    ret[i] = list[i + start];
  }
  return ret
}

/**
 * Mix properties into target object.
 */
function extend (to, _from) {
  for (var key in _from) {
    to[key] = _from[key];
  }
  return to
}

/**
 * Merge an Array of Objects into a single Object.
 */
function toObject (arr) {
  var res = {};
  for (var i = 0; i < arr.length; i++) {
    if (arr[i]) {
      extend(res, arr[i]);
    }
  }
  return res
}

/* eslint-disable no-unused-vars */

/**
 * Perform no operation.
 * Stubbing args to make Flow happy without leaving useless transpiled code
 * with ...rest (https://flow.org/blog/2017/05/07/Strict-Function-Call-Arity/).
 */
function noop (a, b, c) {}

/**
 * Always return false.
 */
var no = function (a, b, c) { return false; };

/* eslint-enable no-unused-vars */

/**
 * Return the same value.
 */
var identity = function (_) { return _; };

/**
 * Generate a string containing static keys from compiler modules.
 */
function genStaticKeys (modules) {
  return modules.reduce(function (keys, m) {
    return keys.concat(m.staticKeys || [])
  }, []).join(',')
}

/**
 * Check if two values are loosely equal - that is,
 * if they are plain objects, do they have the same shape?
 */
function looseEqual (a, b) {
  if (a === b) { return true }
  var isObjectA = isObject(a);
  var isObjectB = isObject(b);
  if (isObjectA && isObjectB) {
    try {
      var isArrayA = Array.isArray(a);
      var isArrayB = Array.isArray(b);
      if (isArrayA && isArrayB) {
        return a.length === b.length && a.every(function (e, i) {
          return looseEqual(e, b[i])
        })
      } else if (a instanceof Date && b instanceof Date) {
        return a.getTime() === b.getTime()
      } else if (!isArrayA && !isArrayB) {
        var keysA = Object.keys(a);
        var keysB = Object.keys(b);
        return keysA.length === keysB.length && keysA.every(function (key) {
          return looseEqual(a[key], b[key])
        })
      } else {
        /* istanbul ignore next */
        return false
      }
    } catch (e) {
      /* istanbul ignore next */
      return false
    }
  } else if (!isObjectA && !isObjectB) {
    return String(a) === String(b)
  } else {
    return false
  }
}

/**
 * Return the first index at which a loosely equal value can be
 * found in the array (if value is a plain object, the array must
 * contain an object of the same shape), or -1 if it is not present.
 */
function looseIndexOf (arr, val) {
  for (var i = 0; i < arr.length; i++) {
    if (looseEqual(arr[i], val)) { return i }
  }
  return -1
}

/**
 * Ensure a function is called only once.
 */
function once (fn) {
  var called = false;
  return function () {
    if (!called) {
      called = true;
      fn.apply(this, arguments);
    }
  }
}

var SSR_ATTR = 'data-server-rendered';

var ASSET_TYPES = [
  'component',
  'directive',
  'filter'
];

var LIFECYCLE_HOOKS = [
  'beforeCreate',
  'created',
  'beforeMount',
  'mounted',
  'beforeUpdate',
  'updated',
  'beforeDestroy',
  'destroyed',
  'activated',
  'deactivated',
  'errorCaptured',
  'serverPrefetch'
];

/*  */



var config = ({
  /**
   * Option merge strategies (used in core/util/options)
   */
  // $flow-disable-line
  optionMergeStrategies: Object.create(null),

  /**
   * Whether to suppress warnings.
   */
  silent: false,

  /**
   * Show production mode tip message on boot?
   */
  productionTip: "development" !== 'production',

  /**
   * Whether to enable devtools
   */
  devtools: "development" !== 'production',

  /**
   * Whether to record perf
   */
  performance: false,

  /**
   * Error handler for watcher errors
   */
  errorHandler: null,

  /**
   * Warn handler for watcher warns
   */
  warnHandler: null,

  /**
   * Ignore certain custom elements
   */
  ignoredElements: [],

  /**
   * Custom user key aliases for v-on
   */
  // $flow-disable-line
  keyCodes: Object.create(null),

  /**
   * Check if a tag is reserved so that it cannot be registered as a
   * component. This is platform-dependent and may be overwritten.
   */
  isReservedTag: no,

  /**
   * Check if an attribute is reserved so that it cannot be used as a component
   * prop. This is platform-dependent and may be overwritten.
   */
  isReservedAttr: no,

  /**
   * Check if a tag is an unknown element.
   * Platform-dependent.
   */
  isUnknownElement: no,

  /**
   * Get the namespace of an element
   */
  getTagNamespace: noop,

  /**
   * Parse the real tag name for the specific platform.
   */
  parsePlatformTagName: identity,

  /**
   * Check if an attribute must be bound using property, e.g. value
   * Platform-dependent.
   */
  mustUseProp: no,

  /**
   * Perform updates asynchronously. Intended to be used by Vue Test Utils
   * This will significantly reduce performance if set to false.
   */
  async: true,

  /**
   * Exposed for legacy reasons
   */
  _lifecycleHooks: LIFECYCLE_HOOKS
});

/*  */

/**
 * unicode letters used for parsing html tags, component names and property paths.
 * using https://www.w3.org/TR/html53/semantics-scripting.html#potentialcustomelementname
 * skipping \u10000-\uEFFFF due to it freezing up PhantomJS
 */
var unicodeRegExp = /a-zA-Z\u00B7\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u037D\u037F-\u1FFF\u200C-\u200D\u203F-\u2040\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD/;

/**
 * Check if a string starts with $ or _
 */
function isReserved (str) {
  var c = (str + '').charCodeAt(0);
  return c === 0x24 || c === 0x5F
}

/**
 * Define a property.
 */
function def (obj, key, val, enumerable) {
  Object.defineProperty(obj, key, {
    value: val,
    enumerable: !!enumerable,
    writable: true,
    configurable: true
  });
}

/**
 * Parse simple path.
 */
var bailRE = new RegExp(("[^" + (unicodeRegExp.source) + ".$_\\d]"));
function parsePath (path) {
  if (bailRE.test(path)) {
    return
  }
  var segments = path.split('.');
  return function (obj) {
    for (var i = 0; i < segments.length; i++) {
      if (!obj) { return }
      obj = obj[segments[i]];
    }
    return obj
  }
}

/*  */

// can we use __proto__?
var hasProto = '__proto__' in {};

// Browser environment sniffing
var inBrowser = typeof window !== 'undefined';
var inWeex = typeof WXEnvironment !== 'undefined' && !!WXEnvironment.platform;
var weexPlatform = inWeex && WXEnvironment.platform.toLowerCase();
var UA = inBrowser && window.navigator.userAgent.toLowerCase();
var isIE = UA && /msie|trident/.test(UA);
var isIE9 = UA && UA.indexOf('msie 9.0') > 0;
var isEdge = UA && UA.indexOf('edge/') > 0;
var isAndroid = (UA && UA.indexOf('android') > 0) || (weexPlatform === 'android');
var isIOS = (UA && /iphone|ipad|ipod|ios/.test(UA)) || (weexPlatform === 'ios');
var isChrome = UA && /chrome\/\d+/.test(UA) && !isEdge;
var isPhantomJS = UA && /phantomjs/.test(UA);
var isFF = UA && UA.match(/firefox\/(\d+)/);

// Firefox has a "watch" function on Object.prototype...
var nativeWatch = ({}).watch;

var supportsPassive = false;
if (inBrowser) {
  try {
    var opts = {};
    Object.defineProperty(opts, 'passive', ({
      get: function get () {
        /* istanbul ignore next */
        supportsPassive = true;
      }
    })); // https://github.com/facebook/flow/issues/285
    window.addEventListener('test-passive', null, opts);
  } catch (e) {}
}

// this needs to be lazy-evaled because vue may be required before
// vue-server-renderer can set VUE_ENV
var _isServer;
var isServerRendering = function () {
  if (_isServer === undefined) {
    /* istanbul ignore if */
    if (!inBrowser && !inWeex && typeof global !== 'undefined') {
      // detect presence of vue-server-renderer and avoid
      // Webpack shimming the process
      _isServer = global['process'] && global['process'].env.VUE_ENV === 'server';
    } else {
      _isServer = false;
    }
  }
  return _isServer
};

// detect devtools
var devtools = inBrowser && window.__VUE_DEVTOOLS_GLOBAL_HOOK__;

/* istanbul ignore next */
function isNative (Ctor) {
  return typeof Ctor === 'function' && /native code/.test(Ctor.toString())
}

var hasSymbol =
  typeof Symbol !== 'undefined' && isNative(Symbol) &&
  typeof Reflect !== 'undefined' && isNative(Reflect.ownKeys);

var _Set;
/* istanbul ignore if */ // $flow-disable-line
if (typeof Set !== 'undefined' && isNative(Set)) {
  // use native Set when available.
  _Set = Set;
} else {
  // a non-standard Set polyfill that only works with primitive keys.
  _Set = /*@__PURE__*/(function () {
    function Set () {
      this.set = Object.create(null);
    }
    Set.prototype.has = function has (key) {
      return this.set[key] === true
    };
    Set.prototype.add = function add (key) {
      this.set[key] = true;
    };
    Set.prototype.clear = function clear () {
      this.set = Object.create(null);
    };

    return Set;
  }());
}

/*  */

var warn = noop;
var tip = noop;
var generateComponentTrace = (noop); // work around flow check
var formatComponentName = (noop);

{
  var hasConsole = typeof console !== 'undefined';
  var classifyRE = /(?:^|[-_])(\w)/g;
  var classify = function (str) { return str
    .replace(classifyRE, function (c) { return c.toUpperCase(); })
    .replace(/[-_]/g, ''); };

  warn = function (msg, vm) {
    var trace = vm ? generateComponentTrace(vm) : '';

    if (config.warnHandler) {
      config.warnHandler.call(null, msg, vm, trace);
    } else if (hasConsole && (!config.silent)) {
      console.error(("[Vue warn]: " + msg + trace));
    }
  };

  tip = function (msg, vm) {
    if (hasConsole && (!config.silent)) {
      console.warn("[Vue tip]: " + msg + (
        vm ? generateComponentTrace(vm) : ''
      ));
    }
  };

  formatComponentName = function (vm, includeFile) {
    if (vm.$root === vm) {
      return '<Root>'
    }
    var options = typeof vm === 'function' && vm.cid != null
      ? vm.options
      : vm._isVue
        ? vm.$options || vm.constructor.options
        : vm;
    var name = options.name || options._componentTag;
    var file = options.__file;
    if (!name && file) {
      var match = file.match(/([^/\\]+)\.vue$/);
      name = match && match[1];
    }

    return (
      (name ? ("<" + (classify(name)) + ">") : "<Anonymous>") +
      (file && includeFile !== false ? (" at " + file) : '')
    )
  };

  var repeat = function (str, n) {
    var res = '';
    while (n) {
      if (n % 2 === 1) { res += str; }
      if (n > 1) { str += str; }
      n >>= 1;
    }
    return res
  };

  generateComponentTrace = function (vm) {
    if (vm._isVue && vm.$parent) {
      var tree = [];
      var currentRecursiveSequence = 0;
      while (vm) {
        if (tree.length > 0) {
          var last = tree[tree.length - 1];
          if (last.constructor === vm.constructor) {
            currentRecursiveSequence++;
            vm = vm.$parent;
            continue
          } else if (currentRecursiveSequence > 0) {
            tree[tree.length - 1] = [last, currentRecursiveSequence];
            currentRecursiveSequence = 0;
          }
        }
        tree.push(vm);
        vm = vm.$parent;
      }
      return '\n\nfound in\n\n' + tree
        .map(function (vm, i) { return ("" + (i === 0 ? '---> ' : repeat(' ', 5 + i * 2)) + (Array.isArray(vm)
            ? ((formatComponentName(vm[0])) + "... (" + (vm[1]) + " recursive calls)")
            : formatComponentName(vm))); })
        .join('\n')
    } else {
      return ("\n\n(found in " + (formatComponentName(vm)) + ")")
    }
  };
}

/*  */

var uid = 0;

/**
 * A dep is an observable that can have multiple
 * directives subscribing to it.
 */
var Dep = function Dep () {
  this.id = uid++;
  this.subs = [];
};

Dep.prototype.addSub = function addSub (sub) {
  this.subs.push(sub);
};

Dep.prototype.removeSub = function removeSub (sub) {
  remove(this.subs, sub);
};

Dep.prototype.depend = function depend () {
  if (Dep.target) {
    Dep.target.addDep(this);
  }
};

Dep.prototype.notify = function notify () {
  // stabilize the subscriber list first
  var subs = this.subs.slice();
  if (!config.async) {
    // subs aren't sorted in scheduler if not running async
    // we need to sort them now to make sure they fire in correct
    // order
    subs.sort(function (a, b) { return a.id - b.id; });
  }
  for (var i = 0, l = subs.length; i < l; i++) {
    subs[i].update();
  }
};

// The current target watcher being evaluated.
// This is globally unique because only one watcher
// can be evaluated at a time.
Dep.target = null;
var targetStack = [];

function pushTarget (target) {
  targetStack.push(target);
  Dep.target = target;
}

function popTarget () {
  targetStack.pop();
  Dep.target = targetStack[targetStack.length - 1];
}

/*  */

var VNode = function VNode (
  tag,
  data,
  children,
  text,
  elm,
  context,
  componentOptions,
  asyncFactory
) {
  this.tag = tag;
  this.data = data;
  this.children = children;
  this.text = text;
  this.elm = elm;
  this.ns = undefined;
  this.context = context;
  this.fnContext = undefined;
  this.fnOptions = undefined;
  this.fnScopeId = undefined;
  this.key = data && data.key;
  this.componentOptions = componentOptions;
  this.componentInstance = undefined;
  this.parent = undefined;
  this.raw = false;
  this.isStatic = false;
  this.isRootInsert = true;
  this.isComment = false;
  this.isCloned = false;
  this.isOnce = false;
  this.asyncFactory = asyncFactory;
  this.asyncMeta = undefined;
  this.isAsyncPlaceholder = false;
};

var prototypeAccessors = { child: { configurable: true } };

// DEPRECATED: alias for componentInstance for backwards compat.
/* istanbul ignore next */
prototypeAccessors.child.get = function () {
  return this.componentInstance
};

Object.defineProperties( VNode.prototype, prototypeAccessors );

var createEmptyVNode = function (text) {
  if ( text === void 0 ) text = '';

  var node = new VNode();
  node.text = text;
  node.isComment = true;
  return node
};

function createTextVNode (val) {
  return new VNode(undefined, undefined, undefined, String(val))
}

// optimized shallow clone
// used for static nodes and slot nodes because they may be reused across
// multiple renders, cloning them avoids errors when DOM manipulations rely
// on their elm reference.
function cloneVNode (vnode) {
  var cloned = new VNode(
    vnode.tag,
    vnode.data,
    // #7975
    // clone children array to avoid mutating original in case of cloning
    // a child.
    vnode.children && vnode.children.slice(),
    vnode.text,
    vnode.elm,
    vnode.context,
    vnode.componentOptions,
    vnode.asyncFactory
  );
  cloned.ns = vnode.ns;
  cloned.isStatic = vnode.isStatic;
  cloned.key = vnode.key;
  cloned.isComment = vnode.isComment;
  cloned.fnContext = vnode.fnContext;
  cloned.fnOptions = vnode.fnOptions;
  cloned.fnScopeId = vnode.fnScopeId;
  cloned.asyncMeta = vnode.asyncMeta;
  cloned.isCloned = true;
  return cloned
}

/*
 * not type checking this file because flow doesn't play well with
 * dynamically accessing methods on Array prototype
 */

var arrayProto = Array.prototype;
var arrayMethods = Object.create(arrayProto);

var methodsToPatch = [
  'push',
  'pop',
  'shift',
  'unshift',
  'splice',
  'sort',
  'reverse'
];

/**
 * Intercept mutating methods and emit events
 */
methodsToPatch.forEach(function (method) {
  // cache original method
  var original = arrayProto[method];
  def(arrayMethods, method, function mutator () {
    var args = [], len = arguments.length;
    while ( len-- ) args[ len ] = arguments[ len ];

    var result = original.apply(this, args);
    var ob = this.__ob__;
    var inserted;
    switch (method) {
      case 'push':
      case 'unshift':
        inserted = args;
        break
      case 'splice':
        inserted = args.slice(2);
        break
    }
    if (inserted) { ob.observeArray(inserted); }
    // notify change
    ob.dep.notify();
    return result
  });
});

/*  */

var arrayKeys = Object.getOwnPropertyNames(arrayMethods);

/**
 * In some cases we may want to disable observation inside a component's
 * update computation.
 */
var shouldObserve = true;

function toggleObserving (value) {
  shouldObserve = value;
}

/**
 * Observer class that is attached to each observed
 * object. Once attached, the observer converts the target
 * object's property keys into getter/setters that
 * collect dependencies and dispatch updates.
 */
var Observer = function Observer (value) {
  this.value = value;
  this.dep = new Dep();
  this.vmCount = 0;
  def(value, '__ob__', this);
  if (Array.isArray(value)) {
    if (hasProto) {
      protoAugment(value, arrayMethods);
    } else {
      copyAugment(value, arrayMethods, arrayKeys);
    }
    this.observeArray(value);
  } else {
    this.walk(value);
  }
};

/**
 * Walk through all properties and convert them into
 * getter/setters. This method should only be called when
 * value type is Object.
 */
Observer.prototype.walk = function walk (obj) {
  var keys = Object.keys(obj);
  for (var i = 0; i < keys.length; i++) {
    defineReactive$$1(obj, keys[i]);
  }
};

/**
 * Observe a list of Array items.
 */
Observer.prototype.observeArray = function observeArray (items) {
  for (var i = 0, l = items.length; i < l; i++) {
    observe(items[i]);
  }
};

// helpers

/**
 * Augment a target Object or Array by intercepting
 * the prototype chain using __proto__
 */
function protoAugment (target, src) {
  /* eslint-disable no-proto */
  target.__proto__ = src;
  /* eslint-enable no-proto */
}

/**
 * Augment a target Object or Array by defining
 * hidden properties.
 */
/* istanbul ignore next */
function copyAugment (target, src, keys) {
  for (var i = 0, l = keys.length; i < l; i++) {
    var key = keys[i];
    def(target, key, src[key]);
  }
}

/**
 * Attempt to create an observer instance for a value,
 * returns the new observer if successfully observed,
 * or the existing observer if the value already has one.
 */
function observe (value, asRootData) {
  if (!isObject(value) || value instanceof VNode) {
    return
  }
  var ob;
  if (hasOwn(value, '__ob__') && value.__ob__ instanceof Observer) {
    ob = value.__ob__;
  } else if (
    shouldObserve &&
    !isServerRendering() &&
    (Array.isArray(value) || isPlainObject(value)) &&
    Object.isExtensible(value) &&
    !value._isVue
  ) {
    ob = new Observer(value);
  }
  if (asRootData && ob) {
    ob.vmCount++;
  }
  return ob
}

/**
 * Define a reactive property on an Object.
 */
function defineReactive$$1 (
  obj,
  key,
  val,
  customSetter,
  shallow
) {
  var dep = new Dep();

  var property = Object.getOwnPropertyDescriptor(obj, key);
  if (property && property.configurable === false) {
    return
  }

  // cater for pre-defined getter/setters
  var getter = property && property.get;
  var setter = property && property.set;
  if ((!getter || setter) && arguments.length === 2) {
    val = obj[key];
  }

  var childOb = !shallow && observe(val);
  Object.defineProperty(obj, key, {
    enumerable: true,
    configurable: true,
    get: function reactiveGetter () {
      var value = getter ? getter.call(obj) : val;
      if (Dep.target) {
        dep.depend();
        if (childOb) {
          childOb.dep.depend();
          if (Array.isArray(value)) {
            dependArray(value);
          }
        }
      }
      return value
    },
    set: function reactiveSetter (newVal) {
      var value = getter ? getter.call(obj) : val;
      /* eslint-disable no-self-compare */
      if (newVal === value || (newVal !== newVal && value !== value)) {
        return
      }
      /* eslint-enable no-self-compare */
      if (customSetter) {
        customSetter();
      }
      // #7981: for accessor properties without setter
      if (getter && !setter) { return }
      if (setter) {
        setter.call(obj, newVal);
      } else {
        val = newVal;
      }
      childOb = !shallow && observe(newVal);
      dep.notify();
    }
  });
}

/**
 * Set a property on an object. Adds the new property and
 * triggers change notification if the property doesn't
 * already exist.
 */
function set (target, key, val) {
  if (isUndef(target) || isPrimitive(target)
  ) {
    warn(("Cannot set reactive property on undefined, null, or primitive value: " + ((target))));
  }
  if (Array.isArray(target) && isValidArrayIndex(key)) {
    target.length = Math.max(target.length, key);
    target.splice(key, 1, val);
    return val
  }
  if (key in target && !(key in Object.prototype)) {
    target[key] = val;
    return val
  }
  var ob = (target).__ob__;
  if (target._isVue || (ob && ob.vmCount)) {
    warn(
      'Avoid adding reactive properties to a Vue instance or its root $data ' +
      'at runtime - declare it upfront in the data option.'
    );
    return val
  }
  if (!ob) {
    target[key] = val;
    return val
  }
  defineReactive$$1(ob.value, key, val);
  ob.dep.notify();
  return val
}

/**
 * Delete a property and trigger change if necessary.
 */
function del (target, key) {
  if (isUndef(target) || isPrimitive(target)
  ) {
    warn(("Cannot delete reactive property on undefined, null, or primitive value: " + ((target))));
  }
  if (Array.isArray(target) && isValidArrayIndex(key)) {
    target.splice(key, 1);
    return
  }
  var ob = (target).__ob__;
  if (target._isVue || (ob && ob.vmCount)) {
    warn(
      'Avoid deleting properties on a Vue instance or its root $data ' +
      '- just set it to null.'
    );
    return
  }
  if (!hasOwn(target, key)) {
    return
  }
  delete target[key];
  if (!ob) {
    return
  }
  ob.dep.notify();
}

/**
 * Collect dependencies on array elements when the array is touched, since
 * we cannot intercept array element access like property getters.
 */
function dependArray (value) {
  for (var e = (void 0), i = 0, l = value.length; i < l; i++) {
    e = value[i];
    e && e.__ob__ && e.__ob__.dep.depend();
    if (Array.isArray(e)) {
      dependArray(e);
    }
  }
}

/*  */

/**
 * Option overwriting strategies are functions that handle
 * how to merge a parent option value and a child option
 * value into the final value.
 */
var strats = config.optionMergeStrategies;

/**
 * Options with restrictions
 */
{
  strats.el = strats.propsData = function (parent, child, vm, key) {
    if (!vm) {
      warn(
        "option \"" + key + "\" can only be used during instance " +
        'creation with the `new` keyword.'
      );
    }
    return defaultStrat(parent, child)
  };
}

/**
 * Helper that recursively merges two data objects together.
 */
function mergeData (to, from) {
  if (!from) { return to }
  var key, toVal, fromVal;

  var keys = hasSymbol
    ? Reflect.ownKeys(from)
    : Object.keys(from);

  for (var i = 0; i < keys.length; i++) {
    key = keys[i];
    // in case the object is already observed...
    if (key === '__ob__') { continue }
    toVal = to[key];
    fromVal = from[key];
    if (!hasOwn(to, key)) {
      set(to, key, fromVal);
    } else if (
      toVal !== fromVal &&
      isPlainObject(toVal) &&
      isPlainObject(fromVal)
    ) {
      mergeData(toVal, fromVal);
    }
  }
  return to
}

/**
 * Data
 */
function mergeDataOrFn (
  parentVal,
  childVal,
  vm
) {
  if (!vm) {
    // in a Vue.extend merge, both should be functions
    if (!childVal) {
      return parentVal
    }
    if (!parentVal) {
      return childVal
    }
    // when parentVal & childVal are both present,
    // we need to return a function that returns the
    // merged result of both functions... no need to
    // check if parentVal is a function here because
    // it has to be a function to pass previous merges.
    return function mergedDataFn () {
      return mergeData(
        typeof childVal === 'function' ? childVal.call(this, this) : childVal,
        typeof parentVal === 'function' ? parentVal.call(this, this) : parentVal
      )
    }
  } else {
    return function mergedInstanceDataFn () {
      // instance merge
      var instanceData = typeof childVal === 'function'
        ? childVal.call(vm, vm)
        : childVal;
      var defaultData = typeof parentVal === 'function'
        ? parentVal.call(vm, vm)
        : parentVal;
      if (instanceData) {
        return mergeData(instanceData, defaultData)
      } else {
        return defaultData
      }
    }
  }
}

strats.data = function (
  parentVal,
  childVal,
  vm
) {
  if (!vm) {
    if (childVal && typeof childVal !== 'function') {
      warn(
        'The "data" option should be a function ' +
        'that returns a per-instance value in component ' +
        'definitions.',
        vm
      );

      return parentVal
    }
    return mergeDataOrFn(parentVal, childVal)
  }

  return mergeDataOrFn(parentVal, childVal, vm)
};

/**
 * Hooks and props are merged as arrays.
 */
function mergeHook (
  parentVal,
  childVal
) {
  var res = childVal
    ? parentVal
      ? parentVal.concat(childVal)
      : Array.isArray(childVal)
        ? childVal
        : [childVal]
    : parentVal;
  return res
    ? dedupeHooks(res)
    : res
}

function dedupeHooks (hooks) {
  var res = [];
  for (var i = 0; i < hooks.length; i++) {
    if (res.indexOf(hooks[i]) === -1) {
      res.push(hooks[i]);
    }
  }
  return res
}

LIFECYCLE_HOOKS.forEach(function (hook) {
  strats[hook] = mergeHook;
});

/**
 * Assets
 *
 * When a vm is present (instance creation), we need to do
 * a three-way merge between constructor options, instance
 * options and parent options.
 */
function mergeAssets (
  parentVal,
  childVal,
  vm,
  key
) {
  var res = Object.create(parentVal || null);
  if (childVal) {
    assertObjectType(key, childVal, vm);
    return extend(res, childVal)
  } else {
    return res
  }
}

ASSET_TYPES.forEach(function (type) {
  strats[type + 's'] = mergeAssets;
});

/**
 * Watchers.
 *
 * Watchers hashes should not overwrite one
 * another, so we merge them as arrays.
 */
strats.watch = function (
  parentVal,
  childVal,
  vm,
  key
) {
  // work around Firefox's Object.prototype.watch...
  if (parentVal === nativeWatch) { parentVal = undefined; }
  if (childVal === nativeWatch) { childVal = undefined; }
  /* istanbul ignore if */
  if (!childVal) { return Object.create(parentVal || null) }
  {
    assertObjectType(key, childVal, vm);
  }
  if (!parentVal) { return childVal }
  var ret = {};
  extend(ret, parentVal);
  for (var key$1 in childVal) {
    var parent = ret[key$1];
    var child = childVal[key$1];
    if (parent && !Array.isArray(parent)) {
      parent = [parent];
    }
    ret[key$1] = parent
      ? parent.concat(child)
      : Array.isArray(child) ? child : [child];
  }
  return ret
};

/**
 * Other object hashes.
 */
strats.props =
strats.methods =
strats.inject =
strats.computed = function (
  parentVal,
  childVal,
  vm,
  key
) {
  if (childVal && "development" !== 'production') {
    assertObjectType(key, childVal, vm);
  }
  if (!parentVal) { return childVal }
  var ret = Object.create(null);
  extend(ret, parentVal);
  if (childVal) { extend(ret, childVal); }
  return ret
};
strats.provide = mergeDataOrFn;

/**
 * Default strategy.
 */
var defaultStrat = function (parentVal, childVal) {
  return childVal === undefined
    ? parentVal
    : childVal
};

/**
 * Validate component names
 */
function checkComponents (options) {
  for (var key in options.components) {
    validateComponentName(key);
  }
}

function validateComponentName (name) {
  if (!new RegExp(("^[a-zA-Z][\\-\\.0-9_" + (unicodeRegExp.source) + "]*$")).test(name)) {
    warn(
      'Invalid component name: "' + name + '". Component names ' +
      'should conform to valid custom element name in html5 specification.'
    );
  }
  if (isBuiltInTag(name) || config.isReservedTag(name)) {
    warn(
      'Do not use built-in or reserved HTML elements as component ' +
      'id: ' + name
    );
  }
}

/**
 * Ensure all props option syntax are normalized into the
 * Object-based format.
 */
function normalizeProps (options, vm) {
  var props = options.props;
  if (!props) { return }
  var res = {};
  var i, val, name;
  if (Array.isArray(props)) {
    i = props.length;
    while (i--) {
      val = props[i];
      if (typeof val === 'string') {
        name = camelize(val);
        res[name] = { type: null };
      } else {
        warn('props must be strings when using array syntax.');
      }
    }
  } else if (isPlainObject(props)) {
    for (var key in props) {
      val = props[key];
      name = camelize(key);
      res[name] = isPlainObject(val)
        ? val
        : { type: val };
    }
  } else {
    warn(
      "Invalid value for option \"props\": expected an Array or an Object, " +
      "but got " + (toRawType(props)) + ".",
      vm
    );
  }
  options.props = res;
}

/**
 * Normalize all injections into Object-based format
 */
function normalizeInject (options, vm) {
  var inject = options.inject;
  if (!inject) { return }
  var normalized = options.inject = {};
  if (Array.isArray(inject)) {
    for (var i = 0; i < inject.length; i++) {
      normalized[inject[i]] = { from: inject[i] };
    }
  } else if (isPlainObject(inject)) {
    for (var key in inject) {
      var val = inject[key];
      normalized[key] = isPlainObject(val)
        ? extend({ from: key }, val)
        : { from: val };
    }
  } else {
    warn(
      "Invalid value for option \"inject\": expected an Array or an Object, " +
      "but got " + (toRawType(inject)) + ".",
      vm
    );
  }
}

/**
 * Normalize raw function directives into object format.
 */
function normalizeDirectives (options) {
  var dirs = options.directives;
  if (dirs) {
    for (var key in dirs) {
      var def$$1 = dirs[key];
      if (typeof def$$1 === 'function') {
        dirs[key] = { bind: def$$1, update: def$$1 };
      }
    }
  }
}

function assertObjectType (name, value, vm) {
  if (!isPlainObject(value)) {
    warn(
      "Invalid value for option \"" + name + "\": expected an Object, " +
      "but got " + (toRawType(value)) + ".",
      vm
    );
  }
}

/**
 * Merge two option objects into a new one.
 * Core utility used in both instantiation and inheritance.
 */
function mergeOptions (
  parent,
  child,
  vm
) {
  {
    checkComponents(child);
  }

  if (typeof child === 'function') {
    child = child.options;
  }

  normalizeProps(child, vm);
  normalizeInject(child, vm);
  normalizeDirectives(child);

  // Apply extends and mixins on the child options,
  // but only if it is a raw options object that isn't
  // the result of another mergeOptions call.
  // Only merged options has the _base property.
  if (!child._base) {
    if (child.extends) {
      parent = mergeOptions(parent, child.extends, vm);
    }
    if (child.mixins) {
      for (var i = 0, l = child.mixins.length; i < l; i++) {
        parent = mergeOptions(parent, child.mixins[i], vm);
      }
    }
  }

  var options = {};
  var key;
  for (key in parent) {
    mergeField(key);
  }
  for (key in child) {
    if (!hasOwn(parent, key)) {
      mergeField(key);
    }
  }
  function mergeField (key) {
    var strat = strats[key] || defaultStrat;
    options[key] = strat(parent[key], child[key], vm, key);
  }
  return options
}

/**
 * Resolve an asset.
 * This function is used because child instances need access
 * to assets defined in its ancestor chain.
 */
function resolveAsset (
  options,
  type,
  id,
  warnMissing
) {
  /* istanbul ignore if */
  if (typeof id !== 'string') {
    return
  }
  var assets = options[type];
  // check local registration variations first
  if (hasOwn(assets, id)) { return assets[id] }
  var camelizedId = camelize(id);
  if (hasOwn(assets, camelizedId)) { return assets[camelizedId] }
  var PascalCaseId = capitalize(camelizedId);
  if (hasOwn(assets, PascalCaseId)) { return assets[PascalCaseId] }
  // fallback to prototype chain
  var res = assets[id] || assets[camelizedId] || assets[PascalCaseId];
  if (warnMissing && !res) {
    warn(
      'Failed to resolve ' + type.slice(0, -1) + ': ' + id,
      options
    );
  }
  return res
}

/*  */



function validateProp (
  key,
  propOptions,
  propsData,
  vm
) {
  var prop = propOptions[key];
  var absent = !hasOwn(propsData, key);
  var value = propsData[key];
  // boolean casting
  var booleanIndex = getTypeIndex(Boolean, prop.type);
  if (booleanIndex > -1) {
    if (absent && !hasOwn(prop, 'default')) {
      value = false;
    } else if (value === '' || value === hyphenate(key)) {
      // only cast empty string / same name to boolean if
      // boolean has higher priority
      var stringIndex = getTypeIndex(String, prop.type);
      if (stringIndex < 0 || booleanIndex < stringIndex) {
        value = true;
      }
    }
  }
  // check default value
  if (value === undefined) {
    value = getPropDefaultValue(vm, prop, key);
    // since the default value is a fresh copy,
    // make sure to observe it.
    var prevShouldObserve = shouldObserve;
    toggleObserving(true);
    observe(value);
    toggleObserving(prevShouldObserve);
  }
  {
    assertProp(prop, key, value, vm, absent);
  }
  return value
}

/**
 * Get the default value of a prop.
 */
function getPropDefaultValue (vm, prop, key) {
  // no default, return undefined
  if (!hasOwn(prop, 'default')) {
    return undefined
  }
  var def = prop.default;
  // warn against non-factory defaults for Object & Array
  if (isObject(def)) {
    warn(
      'Invalid default value for prop "' + key + '": ' +
      'Props with type Object/Array must use a factory function ' +
      'to return the default value.',
      vm
    );
  }
  // the raw prop value was also undefined from previous render,
  // return previous default value to avoid unnecessary watcher trigger
  if (vm && vm.$options.propsData &&
    vm.$options.propsData[key] === undefined &&
    vm._props[key] !== undefined
  ) {
    return vm._props[key]
  }
  // call factory function for non-Function types
  // a value is Function if its prototype is function even across different execution context
  return typeof def === 'function' && getType(prop.type) !== 'Function'
    ? def.call(vm)
    : def
}

/**
 * Assert whether a prop is valid.
 */
function assertProp (
  prop,
  name,
  value,
  vm,
  absent
) {
  if (prop.required && absent) {
    warn(
      'Missing required prop: "' + name + '"',
      vm
    );
    return
  }
  if (value == null && !prop.required) {
    return
  }
  var type = prop.type;
  var valid = !type || type === true;
  var expectedTypes = [];
  if (type) {
    if (!Array.isArray(type)) {
      type = [type];
    }
    for (var i = 0; i < type.length && !valid; i++) {
      var assertedType = assertType(value, type[i]);
      expectedTypes.push(assertedType.expectedType || '');
      valid = assertedType.valid;
    }
  }

  if (!valid) {
    warn(
      getInvalidTypeMessage(name, value, expectedTypes),
      vm
    );
    return
  }
  var validator = prop.validator;
  if (validator) {
    if (!validator(value)) {
      warn(
        'Invalid prop: custom validator check failed for prop "' + name + '".',
        vm
      );
    }
  }
}

var simpleCheckRE = /^(String|Number|Boolean|Function|Symbol)$/;

function assertType (value, type) {
  var valid;
  var expectedType = getType(type);
  if (simpleCheckRE.test(expectedType)) {
    var t = typeof value;
    valid = t === expectedType.toLowerCase();
    // for primitive wrapper objects
    if (!valid && t === 'object') {
      valid = value instanceof type;
    }
  } else if (expectedType === 'Object') {
    valid = isPlainObject(value);
  } else if (expectedType === 'Array') {
    valid = Array.isArray(value);
  } else {
    valid = value instanceof type;
  }
  return {
    valid: valid,
    expectedType: expectedType
  }
}

/**
 * Use function string name to check built-in types,
 * because a simple equality check will fail when running
 * across different vms / iframes.
 */
function getType (fn) {
  var match = fn && fn.toString().match(/^\s*function (\w+)/);
  return match ? match[1] : ''
}

function isSameType (a, b) {
  return getType(a) === getType(b)
}

function getTypeIndex (type, expectedTypes) {
  if (!Array.isArray(expectedTypes)) {
    return isSameType(expectedTypes, type) ? 0 : -1
  }
  for (var i = 0, len = expectedTypes.length; i < len; i++) {
    if (isSameType(expectedTypes[i], type)) {
      return i
    }
  }
  return -1
}

function getInvalidTypeMessage (name, value, expectedTypes) {
  var message = "Invalid prop: type check failed for prop \"" + name + "\"." +
    " Expected " + (expectedTypes.map(capitalize).join(', '));
  var expectedType = expectedTypes[0];
  var receivedType = toRawType(value);
  var expectedValue = styleValue(value, expectedType);
  var receivedValue = styleValue(value, receivedType);
  // check if we need to specify expected value
  if (expectedTypes.length === 1 &&
      isExplicable(expectedType) &&
      !isBoolean(expectedType, receivedType)) {
    message += " with value " + expectedValue;
  }
  message += ", got " + receivedType + " ";
  // check if we need to specify received value
  if (isExplicable(receivedType)) {
    message += "with value " + receivedValue + ".";
  }
  return message
}

function styleValue (value, type) {
  if (type === 'String') {
    return ("\"" + value + "\"")
  } else if (type === 'Number') {
    return ("" + (Number(value)))
  } else {
    return ("" + value)
  }
}

function isExplicable (value) {
  var explicitTypes = ['string', 'number', 'boolean'];
  return explicitTypes.some(function (elem) { return value.toLowerCase() === elem; })
}

function isBoolean () {
  var args = [], len = arguments.length;
  while ( len-- ) args[ len ] = arguments[ len ];

  return args.some(function (elem) { return elem.toLowerCase() === 'boolean'; })
}

/*  */

function handleError (err, vm, info) {
  // Deactivate deps tracking while processing error handler to avoid possible infinite rendering.
  // See: https://github.com/vuejs/vuex/issues/1505
  pushTarget();
  try {
    if (vm) {
      var cur = vm;
      while ((cur = cur.$parent)) {
        var hooks = cur.$options.errorCaptured;
        if (hooks) {
          for (var i = 0; i < hooks.length; i++) {
            try {
              var capture = hooks[i].call(cur, err, vm, info) === false;
              if (capture) { return }
            } catch (e) {
              globalHandleError(e, cur, 'errorCaptured hook');
            }
          }
        }
      }
    }
    globalHandleError(err, vm, info);
  } finally {
    popTarget();
  }
}

function invokeWithErrorHandling (
  handler,
  context,
  args,
  vm,
  info
) {
  var res;
  try {
    res = args ? handler.apply(context, args) : handler.call(context);
    if (res && !res._isVue && isPromise(res) && !res._handled) {
      res.catch(function (e) { return handleError(e, vm, info + " (Promise/async)"); });
      // issue #9511
      // avoid catch triggering multiple times when nested calls
      res._handled = true;
    }
  } catch (e) {
    handleError(e, vm, info);
  }
  return res
}

function globalHandleError (err, vm, info) {
  if (config.errorHandler) {
    try {
      return config.errorHandler.call(null, err, vm, info)
    } catch (e) {
      // if the user intentionally throws the original error in the handler,
      // do not log it twice
      if (e !== err) {
        logError(e, null, 'config.errorHandler');
      }
    }
  }
  logError(err, vm, info);
}

function logError (err, vm, info) {
  {
    warn(("Error in " + info + ": \"" + (err.toString()) + "\""), vm);
  }
  /* istanbul ignore else */
  if ((inBrowser || inWeex) && typeof console !== 'undefined') {
    console.error(err);
  } else {
    throw err
  }
}

/*  */

var isUsingMicroTask = false;

var callbacks = [];
var pending = false;

function flushCallbacks () {
  pending = false;
  var copies = callbacks.slice(0);
  callbacks.length = 0;
  for (var i = 0; i < copies.length; i++) {
    copies[i]();
  }
}

// Here we have async deferring wrappers using microtasks.
// In 2.5 we used (macro) tasks (in combination with microtasks).
// However, it has subtle problems when state is changed right before repaint
// (e.g. #6813, out-in transitions).
// Also, using (macro) tasks in event handler would cause some weird behaviors
// that cannot be circumvented (e.g. #7109, #7153, #7546, #7834, #8109).
// So we now use microtasks everywhere, again.
// A major drawback of this tradeoff is that there are some scenarios
// where microtasks have too high a priority and fire in between supposedly
// sequential events (e.g. #4521, #6690, which have workarounds)
// or even between bubbling of the same event (#6566).
var timerFunc;

// The nextTick behavior leverages the microtask queue, which can be accessed
// via either native Promise.then or MutationObserver.
// MutationObserver has wider support, however it is seriously bugged in
// UIWebView in iOS >= 9.3.3 when triggered in touch event handlers. It
// completely stops working after triggering a few times... so, if native
// Promise is available, we will use it:
/* istanbul ignore next, $flow-disable-line */
if (typeof Promise !== 'undefined' && isNative(Promise)) {
  var p = Promise.resolve();
  timerFunc = function () {
    p.then(flushCallbacks);
    // In problematic UIWebViews, Promise.then doesn't completely break, but
    // it can get stuck in a weird state where callbacks are pushed into the
    // microtask queue but the queue isn't being flushed, until the browser
    // needs to do some other work, e.g. handle a timer. Therefore we can
    // "force" the microtask queue to be flushed by adding an empty timer.
    if (isIOS) { setTimeout(noop); }
  };
  isUsingMicroTask = true;
} else if (!isIE && typeof MutationObserver !== 'undefined' && (
  isNative(MutationObserver) ||
  // PhantomJS and iOS 7.x
  MutationObserver.toString() === '[object MutationObserverConstructor]'
)) {
  // Use MutationObserver where native Promise is not available,
  // e.g. PhantomJS, iOS7, Android 4.4
  // (#6466 MutationObserver is unreliable in IE11)
  var counter = 1;
  var observer = new MutationObserver(flushCallbacks);
  var textNode = document.createTextNode(String(counter));
  observer.observe(textNode, {
    characterData: true
  });
  timerFunc = function () {
    counter = (counter + 1) % 2;
    textNode.data = String(counter);
  };
  isUsingMicroTask = true;
} else if (typeof setImmediate !== 'undefined' && isNative(setImmediate)) {
  // Fallback to setImmediate.
  // Technically it leverages the (macro) task queue,
  // but it is still a better choice than setTimeout.
  timerFunc = function () {
    setImmediate(flushCallbacks);
  };
} else {
  // Fallback to setTimeout.
  timerFunc = function () {
    setTimeout(flushCallbacks, 0);
  };
}

function nextTick (cb, ctx) {
  var _resolve;
  callbacks.push(function () {
    if (cb) {
      try {
        cb.call(ctx);
      } catch (e) {
        handleError(e, ctx, 'nextTick');
      }
    } else if (_resolve) {
      _resolve(ctx);
    }
  });
  if (!pending) {
    pending = true;
    timerFunc();
  }
  // $flow-disable-line
  if (!cb && typeof Promise !== 'undefined') {
    return new Promise(function (resolve) {
      _resolve = resolve;
    })
  }
}

/*  */

var mark;
var measure;

{
  var perf = inBrowser && window.performance;
  /* istanbul ignore if */
  if (
    perf &&
    perf.mark &&
    perf.measure &&
    perf.clearMarks &&
    perf.clearMeasures
  ) {
    mark = function (tag) { return perf.mark(tag); };
    measure = function (name, startTag, endTag) {
      perf.measure(name, startTag, endTag);
      perf.clearMarks(startTag);
      perf.clearMarks(endTag);
      // perf.clearMeasures(name)
    };
  }
}

/* not type checking this file because flow doesn't play well with Proxy */

var initProxy;

{
  var allowedGlobals = makeMap(
    'Infinity,undefined,NaN,isFinite,isNaN,' +
    'parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,' +
    'Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,' +
    'require' // for Webpack/Browserify
  );

  var warnNonPresent = function (target, key) {
    warn(
      "Property or method \"" + key + "\" is not defined on the instance but " +
      'referenced during render. Make sure that this property is reactive, ' +
      'either in the data option, or for class-based components, by ' +
      'initializing the property. ' +
      'See: https://vuejs.org/v2/guide/reactivity.html#Declaring-Reactive-Properties.',
      target
    );
  };

  var warnReservedPrefix = function (target, key) {
    warn(
      "Property \"" + key + "\" must be accessed with \"$data." + key + "\" because " +
      'properties starting with "$" or "_" are not proxied in the Vue instance to ' +
      'prevent conflicts with Vue internals. ' +
      'See: https://vuejs.org/v2/api/#data',
      target
    );
  };

  var hasProxy =
    typeof Proxy !== 'undefined' && isNative(Proxy);

  if (hasProxy) {
    var isBuiltInModifier = makeMap('stop,prevent,self,ctrl,shift,alt,meta,exact');
    config.keyCodes = new Proxy(config.keyCodes, {
      set: function set (target, key, value) {
        if (isBuiltInModifier(key)) {
          warn(("Avoid overwriting built-in modifier in config.keyCodes: ." + key));
          return false
        } else {
          target[key] = value;
          return true
        }
      }
    });
  }

  var hasHandler = {
    has: function has (target, key) {
      var has = key in target;
      var isAllowed = allowedGlobals(key) ||
        (typeof key === 'string' && key.charAt(0) === '_' && !(key in target.$data));
      if (!has && !isAllowed) {
        if (key in target.$data) { warnReservedPrefix(target, key); }
        else { warnNonPresent(target, key); }
      }
      return has || !isAllowed
    }
  };

  var getHandler = {
    get: function get (target, key) {
      if (typeof key === 'string' && !(key in target)) {
        if (key in target.$data) { warnReservedPrefix(target, key); }
        else { warnNonPresent(target, key); }
      }
      return target[key]
    }
  };

  initProxy = function initProxy (vm) {
    if (hasProxy) {
      // determine which proxy handler to use
      var options = vm.$options;
      var handlers = options.render && options.render._withStripped
        ? getHandler
        : hasHandler;
      vm._renderProxy = new Proxy(vm, handlers);
    } else {
      vm._renderProxy = vm;
    }
  };
}

/*  */

var seenObjects = new _Set();

/**
 * Recursively traverse an object to evoke all converted
 * getters, so that every nested property inside the object
 * is collected as a "deep" dependency.
 */
function traverse (val) {
  _traverse(val, seenObjects);
  seenObjects.clear();
}

function _traverse (val, seen) {
  var i, keys;
  var isA = Array.isArray(val);
  if ((!isA && !isObject(val)) || Object.isFrozen(val) || val instanceof VNode) {
    return
  }
  if (val.__ob__) {
    var depId = val.__ob__.dep.id;
    if (seen.has(depId)) {
      return
    }
    seen.add(depId);
  }
  if (isA) {
    i = val.length;
    while (i--) { _traverse(val[i], seen); }
  } else {
    keys = Object.keys(val);
    i = keys.length;
    while (i--) { _traverse(val[keys[i]], seen); }
  }
}

/*  */

var normalizeEvent = cached(function (name) {
  var passive = name.charAt(0) === '&';
  name = passive ? name.slice(1) : name;
  var once$$1 = name.charAt(0) === '~'; // Prefixed last, checked first
  name = once$$1 ? name.slice(1) : name;
  var capture = name.charAt(0) === '!';
  name = capture ? name.slice(1) : name;
  return {
    name: name,
    once: once$$1,
    capture: capture,
    passive: passive
  }
});

function createFnInvoker (fns, vm) {
  function invoker () {
    var arguments$1 = arguments;

    var fns = invoker.fns;
    if (Array.isArray(fns)) {
      var cloned = fns.slice();
      for (var i = 0; i < cloned.length; i++) {
        invokeWithErrorHandling(cloned[i], null, arguments$1, vm, "v-on handler");
      }
    } else {
      // return handler return value for single handlers
      return invokeWithErrorHandling(fns, null, arguments, vm, "v-on handler")
    }
  }
  invoker.fns = fns;
  return invoker
}

function updateListeners (
  on,
  oldOn,
  add,
  remove$$1,
  createOnceHandler,
  vm
) {
  var name, def$$1, cur, old, event;
  for (name in on) {
    def$$1 = cur = on[name];
    old = oldOn[name];
    event = normalizeEvent(name);
    if (isUndef(cur)) {
      warn(
        "Invalid handler for event \"" + (event.name) + "\": got " + String(cur),
        vm
      );
    } else if (isUndef(old)) {
      if (isUndef(cur.fns)) {
        cur = on[name] = createFnInvoker(cur, vm);
      }
      if (isTrue(event.once)) {
        cur = on[name] = createOnceHandler(event.name, cur, event.capture);
      }
      add(event.name, cur, event.capture, event.passive, event.params);
    } else if (cur !== old) {
      old.fns = cur;
      on[name] = old;
    }
  }
  for (name in oldOn) {
    if (isUndef(on[name])) {
      event = normalizeEvent(name);
      remove$$1(event.name, oldOn[name], event.capture);
    }
  }
}

/*  */

function mergeVNodeHook (def, hookKey, hook) {
  if (def instanceof VNode) {
    def = def.data.hook || (def.data.hook = {});
  }
  var invoker;
  var oldHook = def[hookKey];

  function wrappedHook () {
    hook.apply(this, arguments);
    // important: remove merged hook to ensure it's called only once
    // and prevent memory leak
    remove(invoker.fns, wrappedHook);
  }

  if (isUndef(oldHook)) {
    // no existing hook
    invoker = createFnInvoker([wrappedHook]);
  } else {
    /* istanbul ignore if */
    if (isDef(oldHook.fns) && isTrue(oldHook.merged)) {
      // already a merged invoker
      invoker = oldHook;
      invoker.fns.push(wrappedHook);
    } else {
      // existing plain hook
      invoker = createFnInvoker([oldHook, wrappedHook]);
    }
  }

  invoker.merged = true;
  def[hookKey] = invoker;
}

/*  */

function extractPropsFromVNodeData (
  data,
  Ctor,
  tag
) {
  // we are only extracting raw values here.
  // validation and default values are handled in the child
  // component itself.
  var propOptions = Ctor.options.props;
  if (isUndef(propOptions)) {
    return
  }
  var res = {};
  var attrs = data.attrs;
  var props = data.props;
  if (isDef(attrs) || isDef(props)) {
    for (var key in propOptions) {
      var altKey = hyphenate(key);
      {
        var keyInLowerCase = key.toLowerCase();
        if (
          key !== keyInLowerCase &&
          attrs && hasOwn(attrs, keyInLowerCase)
        ) {
          tip(
            "Prop \"" + keyInLowerCase + "\" is passed to component " +
            (formatComponentName(tag || Ctor)) + ", but the declared prop name is" +
            " \"" + key + "\". " +
            "Note that HTML attributes are case-insensitive and camelCased " +
            "props need to use their kebab-case equivalents when using in-DOM " +
            "templates. You should probably use \"" + altKey + "\" instead of \"" + key + "\"."
          );
        }
      }
      checkProp(res, props, key, altKey, true) ||
      checkProp(res, attrs, key, altKey, false);
    }
  }
  return res
}

function checkProp (
  res,
  hash,
  key,
  altKey,
  preserve
) {
  if (isDef(hash)) {
    if (hasOwn(hash, key)) {
      res[key] = hash[key];
      if (!preserve) {
        delete hash[key];
      }
      return true
    } else if (hasOwn(hash, altKey)) {
      res[key] = hash[altKey];
      if (!preserve) {
        delete hash[altKey];
      }
      return true
    }
  }
  return false
}

/*  */

// The template compiler attempts to minimize the need for normalization by
// statically analyzing the template at compile time.
//
// For plain HTML markup, normalization can be completely skipped because the
// generated render function is guaranteed to return Array<VNode>. There are
// two cases where extra normalization is needed:

// 1. When the children contains components - because a functional component
// may return an Array instead of a single root. In this case, just a simple
// normalization is needed - if any child is an Array, we flatten the whole
// thing with Array.prototype.concat. It is guaranteed to be only 1-level deep
// because functional components already normalize their own children.
function simpleNormalizeChildren (children) {
  for (var i = 0; i < children.length; i++) {
    if (Array.isArray(children[i])) {
      return Array.prototype.concat.apply([], children)
    }
  }
  return children
}

// 2. When the children contains constructs that always generated nested Arrays,
// e.g. <template>, <slot>, v-for, or when the children is provided by user
// with hand-written render functions / JSX. In such cases a full normalization
// is needed to cater to all possible types of children values.
function normalizeChildren (children) {
  return isPrimitive(children)
    ? [createTextVNode(children)]
    : Array.isArray(children)
      ? normalizeArrayChildren(children)
      : undefined
}

function isTextNode (node) {
  return isDef(node) && isDef(node.text) && isFalse(node.isComment)
}

function normalizeArrayChildren (children, nestedIndex) {
  var res = [];
  var i, c, lastIndex, last;
  for (i = 0; i < children.length; i++) {
    c = children[i];
    if (isUndef(c) || typeof c === 'boolean') { continue }
    lastIndex = res.length - 1;
    last = res[lastIndex];
    //  nested
    if (Array.isArray(c)) {
      if (c.length > 0) {
        c = normalizeArrayChildren(c, ((nestedIndex || '') + "_" + i));
        // merge adjacent text nodes
        if (isTextNode(c[0]) && isTextNode(last)) {
          res[lastIndex] = createTextVNode(last.text + (c[0]).text);
          c.shift();
        }
        res.push.apply(res, c);
      }
    } else if (isPrimitive(c)) {
      if (isTextNode(last)) {
        // merge adjacent text nodes
        // this is necessary for SSR hydration because text nodes are
        // essentially merged when rendered to HTML strings
        res[lastIndex] = createTextVNode(last.text + c);
      } else if (c !== '') {
        // convert primitive to vnode
        res.push(createTextVNode(c));
      }
    } else {
      if (isTextNode(c) && isTextNode(last)) {
        // merge adjacent text nodes
        res[lastIndex] = createTextVNode(last.text + c.text);
      } else {
        // default key for nested array children (likely generated by v-for)
        if (isTrue(children._isVList) &&
          isDef(c.tag) &&
          isUndef(c.key) &&
          isDef(nestedIndex)) {
          c.key = "__vlist" + nestedIndex + "_" + i + "__";
        }
        res.push(c);
      }
    }
  }
  return res
}

/*  */

function initProvide (vm) {
  var provide = vm.$options.provide;
  if (provide) {
    vm._provided = typeof provide === 'function'
      ? provide.call(vm)
      : provide;
  }
}

function initInjections (vm) {
  var result = resolveInject(vm.$options.inject, vm);
  if (result) {
    toggleObserving(false);
    Object.keys(result).forEach(function (key) {
      /* istanbul ignore else */
      {
        defineReactive$$1(vm, key, result[key], function () {
          warn(
            "Avoid mutating an injected value directly since the changes will be " +
            "overwritten whenever the provided component re-renders. " +
            "injection being mutated: \"" + key + "\"",
            vm
          );
        });
      }
    });
    toggleObserving(true);
  }
}

function resolveInject (inject, vm) {
  if (inject) {
    // inject is :any because flow is not smart enough to figure out cached
    var result = Object.create(null);
    var keys = hasSymbol
      ? Reflect.ownKeys(inject)
      : Object.keys(inject);

    for (var i = 0; i < keys.length; i++) {
      var key = keys[i];
      // #6574 in case the inject object is observed...
      if (key === '__ob__') { continue }
      var provideKey = inject[key].from;
      var source = vm;
      while (source) {
        if (source._provided && hasOwn(source._provided, provideKey)) {
          result[key] = source._provided[provideKey];
          break
        }
        source = source.$parent;
      }
      if (!source) {
        if ('default' in inject[key]) {
          var provideDefault = inject[key].default;
          result[key] = typeof provideDefault === 'function'
            ? provideDefault.call(vm)
            : provideDefault;
        } else {
          warn(("Injection \"" + key + "\" not found"), vm);
        }
      }
    }
    return result
  }
}

/*  */



/**
 * Runtime helper for resolving raw children VNodes into a slot object.
 */
function resolveSlots (
  children,
  context
) {
  if (!children || !children.length) {
    return {}
  }
  var slots = {};
  for (var i = 0, l = children.length; i < l; i++) {
    var child = children[i];
    var data = child.data;
    // remove slot attribute if the node is resolved as a Vue slot node
    if (data && data.attrs && data.attrs.slot) {
      delete data.attrs.slot;
    }
    // named slots should only be respected if the vnode was rendered in the
    // same context.
    if ((child.context === context || child.fnContext === context) &&
      data && data.slot != null
    ) {
      var name = data.slot;
      var slot = (slots[name] || (slots[name] = []));
      if (child.tag === 'template') {
        slot.push.apply(slot, child.children || []);
      } else {
        slot.push(child);
      }
    } else {
      (slots.default || (slots.default = [])).push(child);
    }
  }
  // ignore slots that contains only whitespace
  for (var name$1 in slots) {
    if (slots[name$1].every(isWhitespace)) {
      delete slots[name$1];
    }
  }
  return slots
}

function isWhitespace (node) {
  return (node.isComment && !node.asyncFactory) || node.text === ' '
}

/*  */

function normalizeScopedSlots (
  slots,
  normalSlots,
  prevSlots
) {
  var res;
  var hasNormalSlots = Object.keys(normalSlots).length > 0;
  var isStable = slots ? !!slots.$stable : !hasNormalSlots;
  var key = slots && slots.$key;
  if (!slots) {
    res = {};
  } else if (slots._normalized) {
    // fast path 1: child component re-render only, parent did not change
    return slots._normalized
  } else if (
    isStable &&
    prevSlots &&
    prevSlots !== emptyObject &&
    key === prevSlots.$key &&
    !hasNormalSlots &&
    !prevSlots.$hasNormal
  ) {
    // fast path 2: stable scoped slots w/ no normal slots to proxy,
    // only need to normalize once
    return prevSlots
  } else {
    res = {};
    for (var key$1 in slots) {
      if (slots[key$1] && key$1[0] !== '$') {
        res[key$1] = normalizeScopedSlot(normalSlots, key$1, slots[key$1]);
      }
    }
  }
  // expose normal slots on scopedSlots
  for (var key$2 in normalSlots) {
    if (!(key$2 in res)) {
      res[key$2] = proxyNormalSlot(normalSlots, key$2);
    }
  }
  // avoriaz seems to mock a non-extensible $scopedSlots object
  // and when that is passed down this would cause an error
  if (slots && Object.isExtensible(slots)) {
    (slots)._normalized = res;
  }
  def(res, '$stable', isStable);
  def(res, '$key', key);
  def(res, '$hasNormal', hasNormalSlots);
  return res
}

function normalizeScopedSlot(normalSlots, key, fn) {
  var normalized = function () {
    var res = arguments.length ? fn.apply(null, arguments) : fn({});
    res = res && typeof res === 'object' && !Array.isArray(res)
      ? [res] // single vnode
      : normalizeChildren(res);
    return res && (
      res.length === 0 ||
      (res.length === 1 && res[0].isComment) // #9658
    ) ? undefined
      : res
  };
  // this is a slot using the new v-slot syntax without scope. although it is
  // compiled as a scoped slot, render fn users would expect it to be present
  // on this.$slots because the usage is semantically a normal slot.
  if (fn.proxy) {
    Object.defineProperty(normalSlots, key, {
      get: normalized,
      enumerable: true,
      configurable: true
    });
  }
  return normalized
}

function proxyNormalSlot(slots, key) {
  return function () { return slots[key]; }
}

/*  */

/**
 * Runtime helper for rendering v-for lists.
 */
function renderList (
  val,
  render
) {
  var ret, i, l, keys, key;
  if (Array.isArray(val) || typeof val === 'string') {
    ret = new Array(val.length);
    for (i = 0, l = val.length; i < l; i++) {
      ret[i] = render(val[i], i);
    }
  } else if (typeof val === 'number') {
    ret = new Array(val);
    for (i = 0; i < val; i++) {
      ret[i] = render(i + 1, i);
    }
  } else if (isObject(val)) {
    if (hasSymbol && val[Symbol.iterator]) {
      ret = [];
      var iterator = val[Symbol.iterator]();
      var result = iterator.next();
      while (!result.done) {
        ret.push(render(result.value, ret.length));
        result = iterator.next();
      }
    } else {
      keys = Object.keys(val);
      ret = new Array(keys.length);
      for (i = 0, l = keys.length; i < l; i++) {
        key = keys[i];
        ret[i] = render(val[key], key, i);
      }
    }
  }
  if (!isDef(ret)) {
    ret = [];
  }
  (ret)._isVList = true;
  return ret
}

/*  */

/**
 * Runtime helper for rendering <slot>
 */
function renderSlot (
  name,
  fallback,
  props,
  bindObject
) {
  var scopedSlotFn = this.$scopedSlots[name];
  var nodes;
  if (scopedSlotFn) { // scoped slot
    props = props || {};
    if (bindObject) {
      if (!isObject(bindObject)) {
        warn(
          'slot v-bind without argument expects an Object',
          this
        );
      }
      props = extend(extend({}, bindObject), props);
    }
    nodes = scopedSlotFn(props) || fallback;
  } else {
    nodes = this.$slots[name] || fallback;
  }

  var target = props && props.slot;
  if (target) {
    return this.$createElement('template', { slot: target }, nodes)
  } else {
    return nodes
  }
}

/*  */

/**
 * Runtime helper for resolving filters
 */
function resolveFilter (id) {
  return resolveAsset(this.$options, 'filters', id, true) || identity
}

/*  */

function isKeyNotMatch (expect, actual) {
  if (Array.isArray(expect)) {
    return expect.indexOf(actual) === -1
  } else {
    return expect !== actual
  }
}

/**
 * Runtime helper for checking keyCodes from config.
 * exposed as Vue.prototype._k
 * passing in eventKeyName as last argument separately for backwards compat
 */
function checkKeyCodes (
  eventKeyCode,
  key,
  builtInKeyCode,
  eventKeyName,
  builtInKeyName
) {
  var mappedKeyCode = config.keyCodes[key] || builtInKeyCode;
  if (builtInKeyName && eventKeyName && !config.keyCodes[key]) {
    return isKeyNotMatch(builtInKeyName, eventKeyName)
  } else if (mappedKeyCode) {
    return isKeyNotMatch(mappedKeyCode, eventKeyCode)
  } else if (eventKeyName) {
    return hyphenate(eventKeyName) !== key
  }
}

/*  */

/**
 * Runtime helper for merging v-bind="object" into a VNode's data.
 */
function bindObjectProps (
  data,
  tag,
  value,
  asProp,
  isSync
) {
  if (value) {
    if (!isObject(value)) {
      warn(
        'v-bind without argument expects an Object or Array value',
        this
      );
    } else {
      if (Array.isArray(value)) {
        value = toObject(value);
      }
      var hash;
      var loop = function ( key ) {
        if (
          key === 'class' ||
          key === 'style' ||
          isReservedAttribute(key)
        ) {
          hash = data;
        } else {
          var type = data.attrs && data.attrs.type;
          hash = asProp || config.mustUseProp(tag, type, key)
            ? data.domProps || (data.domProps = {})
            : data.attrs || (data.attrs = {});
        }
        var camelizedKey = camelize(key);
        var hyphenatedKey = hyphenate(key);
        if (!(camelizedKey in hash) && !(hyphenatedKey in hash)) {
          hash[key] = value[key];

          if (isSync) {
            var on = data.on || (data.on = {});
            on[("update:" + key)] = function ($event) {
              value[key] = $event;
            };
          }
        }
      };

      for (var key in value) loop( key );
    }
  }
  return data
}

/*  */

/**
 * Runtime helper for rendering static trees.
 */
function renderStatic (
  index,
  isInFor
) {
  var cached = this._staticTrees || (this._staticTrees = []);
  var tree = cached[index];
  // if has already-rendered static tree and not inside v-for,
  // we can reuse the same tree.
  if (tree && !isInFor) {
    return tree
  }
  // otherwise, render a fresh tree.
  tree = cached[index] = this.$options.staticRenderFns[index].call(
    this._renderProxy,
    null,
    this // for render fns generated for functional component templates
  );
  markStatic(tree, ("__static__" + index), false);
  return tree
}

/**
 * Runtime helper for v-once.
 * Effectively it means marking the node as static with a unique key.
 */
function markOnce (
  tree,
  index,
  key
) {
  markStatic(tree, ("__once__" + index + (key ? ("_" + key) : "")), true);
  return tree
}

function markStatic (
  tree,
  key,
  isOnce
) {
  if (Array.isArray(tree)) {
    for (var i = 0; i < tree.length; i++) {
      if (tree[i] && typeof tree[i] !== 'string') {
        markStaticNode(tree[i], (key + "_" + i), isOnce);
      }
    }
  } else {
    markStaticNode(tree, key, isOnce);
  }
}

function markStaticNode (node, key, isOnce) {
  node.isStatic = true;
  node.key = key;
  node.isOnce = isOnce;
}

/*  */

function bindObjectListeners (data, value) {
  if (value) {
    if (!isPlainObject(value)) {
      warn(
        'v-on without argument expects an Object value',
        this
      );
    } else {
      var on = data.on = data.on ? extend({}, data.on) : {};
      for (var key in value) {
        var existing = on[key];
        var ours = value[key];
        on[key] = existing ? [].concat(existing, ours) : ours;
      }
    }
  }
  return data
}

/*  */

function resolveScopedSlots (
  fns, // see flow/vnode
  res,
  // the following are added in 2.6
  hasDynamicKeys,
  contentHashKey
) {
  res = res || { $stable: !hasDynamicKeys };
  for (var i = 0; i < fns.length; i++) {
    var slot = fns[i];
    if (Array.isArray(slot)) {
      resolveScopedSlots(slot, res, hasDynamicKeys);
    } else if (slot) {
      // marker for reverse proxying v-slot without scope on this.$slots
      if (slot.proxy) {
        slot.fn.proxy = true;
      }
      res[slot.key] = slot.fn;
    }
  }
  if (contentHashKey) {
    (res).$key = contentHashKey;
  }
  return res
}

/*  */

function bindDynamicKeys (baseObj, values) {
  for (var i = 0; i < values.length; i += 2) {
    var key = values[i];
    if (typeof key === 'string' && key) {
      baseObj[values[i]] = values[i + 1];
    } else if (key !== '' && key !== null) {
      // null is a special value for explicitly removing a binding
      warn(
        ("Invalid value for dynamic directive argument (expected string or null): " + key),
        this
      );
    }
  }
  return baseObj
}

// helper to dynamically append modifier runtime markers to event names.
// ensure only append when value is already string, otherwise it will be cast
// to string and cause the type check to miss.
function prependModifier (value, symbol) {
  return typeof value === 'string' ? symbol + value : value
}

/*  */

function installRenderHelpers (target) {
  target._o = markOnce;
  target._n = toNumber;
  target._s = toString;
  target._l = renderList;
  target._t = renderSlot;
  target._q = looseEqual;
  target._i = looseIndexOf;
  target._m = renderStatic;
  target._f = resolveFilter;
  target._k = checkKeyCodes;
  target._b = bindObjectProps;
  target._v = createTextVNode;
  target._e = createEmptyVNode;
  target._u = resolveScopedSlots;
  target._g = bindObjectListeners;
  target._d = bindDynamicKeys;
  target._p = prependModifier;
}

/*  */

function FunctionalRenderContext (
  data,
  props,
  children,
  parent,
  Ctor
) {
  var this$1 = this;

  var options = Ctor.options;
  // ensure the createElement function in functional components
  // gets a unique context - this is necessary for correct named slot check
  var contextVm;
  if (hasOwn(parent, '_uid')) {
    contextVm = Object.create(parent);
    // $flow-disable-line
    contextVm._original = parent;
  } else {
    // the context vm passed in is a functional context as well.
    // in this case we want to make sure we are able to get a hold to the
    // real context instance.
    contextVm = parent;
    // $flow-disable-line
    parent = parent._original;
  }
  var isCompiled = isTrue(options._compiled);
  var needNormalization = !isCompiled;

  this.data = data;
  this.props = props;
  this.children = children;
  this.parent = parent;
  this.listeners = data.on || emptyObject;
  this.injections = resolveInject(options.inject, parent);
  this.slots = function () {
    if (!this$1.$slots) {
      normalizeScopedSlots(
        data.scopedSlots,
        this$1.$slots = resolveSlots(children, parent)
      );
    }
    return this$1.$slots
  };

  Object.defineProperty(this, 'scopedSlots', ({
    enumerable: true,
    get: function get () {
      return normalizeScopedSlots(data.scopedSlots, this.slots())
    }
  }));

  // support for compiled functional template
  if (isCompiled) {
    // exposing $options for renderStatic()
    this.$options = options;
    // pre-resolve slots for renderSlot()
    this.$slots = this.slots();
    this.$scopedSlots = normalizeScopedSlots(data.scopedSlots, this.$slots);
  }

  if (options._scopeId) {
    this._c = function (a, b, c, d) {
      var vnode = createElement(contextVm, a, b, c, d, needNormalization);
      if (vnode && !Array.isArray(vnode)) {
        vnode.fnScopeId = options._scopeId;
        vnode.fnContext = parent;
      }
      return vnode
    };
  } else {
    this._c = function (a, b, c, d) { return createElement(contextVm, a, b, c, d, needNormalization); };
  }
}

installRenderHelpers(FunctionalRenderContext.prototype);

function createFunctionalComponent (
  Ctor,
  propsData,
  data,
  contextVm,
  children
) {
  var options = Ctor.options;
  var props = {};
  var propOptions = options.props;
  if (isDef(propOptions)) {
    for (var key in propOptions) {
      props[key] = validateProp(key, propOptions, propsData || emptyObject);
    }
  } else {
    if (isDef(data.attrs)) { mergeProps(props, data.attrs); }
    if (isDef(data.props)) { mergeProps(props, data.props); }
  }

  var renderContext = new FunctionalRenderContext(
    data,
    props,
    children,
    contextVm,
    Ctor
  );

  var vnode = options.render.call(null, renderContext._c, renderContext);

  if (vnode instanceof VNode) {
    return cloneAndMarkFunctionalResult(vnode, data, renderContext.parent, options, renderContext)
  } else if (Array.isArray(vnode)) {
    var vnodes = normalizeChildren(vnode) || [];
    var res = new Array(vnodes.length);
    for (var i = 0; i < vnodes.length; i++) {
      res[i] = cloneAndMarkFunctionalResult(vnodes[i], data, renderContext.parent, options, renderContext);
    }
    return res
  }
}

function cloneAndMarkFunctionalResult (vnode, data, contextVm, options, renderContext) {
  // #7817 clone node before setting fnContext, otherwise if the node is reused
  // (e.g. it was from a cached normal slot) the fnContext causes named slots
  // that should not be matched to match.
  var clone = cloneVNode(vnode);
  clone.fnContext = contextVm;
  clone.fnOptions = options;
  {
    (clone.devtoolsMeta = clone.devtoolsMeta || {}).renderContext = renderContext;
  }
  if (data.slot) {
    (clone.data || (clone.data = {})).slot = data.slot;
  }
  return clone
}

function mergeProps (to, from) {
  for (var key in from) {
    to[camelize(key)] = from[key];
  }
}

/*  */

/*  */

/*  */

/*  */

// inline hooks to be invoked on component VNodes during patch
var componentVNodeHooks = {
  init: function init (vnode, hydrating) {
    if (
      vnode.componentInstance &&
      !vnode.componentInstance._isDestroyed &&
      vnode.data.keepAlive
    ) {
      // kept-alive components, treat as a patch
      var mountedNode = vnode; // work around flow
      componentVNodeHooks.prepatch(mountedNode, mountedNode);
    } else {
      var child = vnode.componentInstance = createComponentInstanceForVnode(
        vnode,
        activeInstance
      );
      child.$mount(hydrating ? vnode.elm : undefined, hydrating);
    }
  },

  prepatch: function prepatch (oldVnode, vnode) {
    var options = vnode.componentOptions;
    var child = vnode.componentInstance = oldVnode.componentInstance;
    updateChildComponent(
      child,
      options.propsData, // updated props
      options.listeners, // updated listeners
      vnode, // new parent vnode
      options.children // new children
    );
  },

  insert: function insert (vnode) {
    var context = vnode.context;
    var componentInstance = vnode.componentInstance;
    if (!componentInstance._isMounted) {
      componentInstance._isMounted = true;
      callHook(componentInstance, 'mounted');
    }
    if (vnode.data.keepAlive) {
      if (context._isMounted) {
        // vue-router#1212
        // During updates, a kept-alive component's child components may
        // change, so directly walking the tree here may call activated hooks
        // on incorrect children. Instead we push them into a queue which will
        // be processed after the whole patch process ended.
        queueActivatedComponent(componentInstance);
      } else {
        activateChildComponent(componentInstance, true /* direct */);
      }
    }
  },

  destroy: function destroy (vnode) {
    var componentInstance = vnode.componentInstance;
    if (!componentInstance._isDestroyed) {
      if (!vnode.data.keepAlive) {
        componentInstance.$destroy();
      } else {
        deactivateChildComponent(componentInstance, true /* direct */);
      }
    }
  }
};

var hooksToMerge = Object.keys(componentVNodeHooks);

function createComponent (
  Ctor,
  data,
  context,
  children,
  tag
) {
  if (isUndef(Ctor)) {
    return
  }

  var baseCtor = context.$options._base;

  // plain options object: turn it into a constructor
  if (isObject(Ctor)) {
    Ctor = baseCtor.extend(Ctor);
  }

  // if at this stage it's not a constructor or an async component factory,
  // reject.
  if (typeof Ctor !== 'function') {
    {
      warn(("Invalid Component definition: " + (String(Ctor))), context);
    }
    return
  }

  // async component
  var asyncFactory;
  if (isUndef(Ctor.cid)) {
    asyncFactory = Ctor;
    Ctor = resolveAsyncComponent(asyncFactory, baseCtor);
    if (Ctor === undefined) {
      // return a placeholder node for async component, which is rendered
      // as a comment node but preserves all the raw information for the node.
      // the information will be used for async server-rendering and hydration.
      return createAsyncPlaceholder(
        asyncFactory,
        data,
        context,
        children,
        tag
      )
    }
  }

  data = data || {};

  // resolve constructor options in case global mixins are applied after
  // component constructor creation
  resolveConstructorOptions(Ctor);

  // transform component v-model data into props & events
  if (isDef(data.model)) {
    transformModel(Ctor.options, data);
  }

  // extract props
  var propsData = extractPropsFromVNodeData(data, Ctor, tag);

  // functional component
  if (isTrue(Ctor.options.functional)) {
    return createFunctionalComponent(Ctor, propsData, data, context, children)
  }

  // extract listeners, since these needs to be treated as
  // child component listeners instead of DOM listeners
  var listeners = data.on;
  // replace with listeners with .native modifier
  // so it gets processed during parent component patch.
  data.on = data.nativeOn;

  if (isTrue(Ctor.options.abstract)) {
    // abstract components do not keep anything
    // other than props & listeners & slot

    // work around flow
    var slot = data.slot;
    data = {};
    if (slot) {
      data.slot = slot;
    }
  }

  // install component management hooks onto the placeholder node
  installComponentHooks(data);

  // return a placeholder vnode
  var name = Ctor.options.name || tag;
  var vnode = new VNode(
    ("vue-component-" + (Ctor.cid) + (name ? ("-" + name) : '')),
    data, undefined, undefined, undefined, context,
    { Ctor: Ctor, propsData: propsData, listeners: listeners, tag: tag, children: children },
    asyncFactory
  );

  return vnode
}

function createComponentInstanceForVnode (
  vnode, // we know it's MountedComponentVNode but flow doesn't
  parent // activeInstance in lifecycle state
) {
  var options = {
    _isComponent: true,
    _parentVnode: vnode,
    parent: parent
  };
  // check inline-template render functions
  var inlineTemplate = vnode.data.inlineTemplate;
  if (isDef(inlineTemplate)) {
    options.render = inlineTemplate.render;
    options.staticRenderFns = inlineTemplate.staticRenderFns;
  }
  return new vnode.componentOptions.Ctor(options)
}

function installComponentHooks (data) {
  var hooks = data.hook || (data.hook = {});
  for (var i = 0; i < hooksToMerge.length; i++) {
    var key = hooksToMerge[i];
    var existing = hooks[key];
    var toMerge = componentVNodeHooks[key];
    if (existing !== toMerge && !(existing && existing._merged)) {
      hooks[key] = existing ? mergeHook$1(toMerge, existing) : toMerge;
    }
  }
}

function mergeHook$1 (f1, f2) {
  var merged = function (a, b) {
    // flow complains about extra args which is why we use any
    f1(a, b);
    f2(a, b);
  };
  merged._merged = true;
  return merged
}

// transform component v-model info (value and callback) into
// prop and event handler respectively.
function transformModel (options, data) {
  var prop = (options.model && options.model.prop) || 'value';
  var event = (options.model && options.model.event) || 'input'
  ;(data.attrs || (data.attrs = {}))[prop] = data.model.value;
  var on = data.on || (data.on = {});
  var existing = on[event];
  var callback = data.model.callback;
  if (isDef(existing)) {
    if (
      Array.isArray(existing)
        ? existing.indexOf(callback) === -1
        : existing !== callback
    ) {
      on[event] = [callback].concat(existing);
    }
  } else {
    on[event] = callback;
  }
}

/*  */

var SIMPLE_NORMALIZE = 1;
var ALWAYS_NORMALIZE = 2;

// wrapper function for providing a more flexible interface
// without getting yelled at by flow
function createElement (
  context,
  tag,
  data,
  children,
  normalizationType,
  alwaysNormalize
) {
  if (Array.isArray(data) || isPrimitive(data)) {
    normalizationType = children;
    children = data;
    data = undefined;
  }
  if (isTrue(alwaysNormalize)) {
    normalizationType = ALWAYS_NORMALIZE;
  }
  return _createElement(context, tag, data, children, normalizationType)
}

function _createElement (
  context,
  tag,
  data,
  children,
  normalizationType
) {
  if (isDef(data) && isDef((data).__ob__)) {
    warn(
      "Avoid using observed data object as vnode data: " + (JSON.stringify(data)) + "\n" +
      'Always create fresh vnode data objects in each render!',
      context
    );
    return createEmptyVNode()
  }
  // object syntax in v-bind
  if (isDef(data) && isDef(data.is)) {
    tag = data.is;
  }
  if (!tag) {
    // in case of component :is set to falsy value
    return createEmptyVNode()
  }
  // warn against non-primitive key
  if (isDef(data) && isDef(data.key) && !isPrimitive(data.key)
  ) {
    {
      warn(
        'Avoid using non-primitive value as key, ' +
        'use string/number value instead.',
        context
      );
    }
  }
  // support single function children as default scoped slot
  if (Array.isArray(children) &&
    typeof children[0] === 'function'
  ) {
    data = data || {};
    data.scopedSlots = { default: children[0] };
    children.length = 0;
  }
  if (normalizationType === ALWAYS_NORMALIZE) {
    children = normalizeChildren(children);
  } else if (normalizationType === SIMPLE_NORMALIZE) {
    children = simpleNormalizeChildren(children);
  }
  var vnode, ns;
  if (typeof tag === 'string') {
    var Ctor;
    ns = (context.$vnode && context.$vnode.ns) || config.getTagNamespace(tag);
    if (config.isReservedTag(tag)) {
      // platform built-in elements
      if (isDef(data) && isDef(data.nativeOn)) {
        warn(
          ("The .native modifier for v-on is only valid on components but it was used on <" + tag + ">."),
          context
        );
      }
      vnode = new VNode(
        config.parsePlatformTagName(tag), data, children,
        undefined, undefined, context
      );
    } else if ((!data || !data.pre) && isDef(Ctor = resolveAsset(context.$options, 'components', tag))) {
      // component
      vnode = createComponent(Ctor, data, context, children, tag);
    } else {
      // unknown or unlisted namespaced elements
      // check at runtime because it may get assigned a namespace when its
      // parent normalizes children
      vnode = new VNode(
        tag, data, children,
        undefined, undefined, context
      );
    }
  } else {
    // direct component options / constructor
    vnode = createComponent(tag, data, context, children);
  }
  if (Array.isArray(vnode)) {
    return vnode
  } else if (isDef(vnode)) {
    if (isDef(ns)) { applyNS(vnode, ns); }
    if (isDef(data)) { registerDeepBindings(data); }
    return vnode
  } else {
    return createEmptyVNode()
  }
}

function applyNS (vnode, ns, force) {
  vnode.ns = ns;
  if (vnode.tag === 'foreignObject') {
    // use default namespace inside foreignObject
    ns = undefined;
    force = true;
  }
  if (isDef(vnode.children)) {
    for (var i = 0, l = vnode.children.length; i < l; i++) {
      var child = vnode.children[i];
      if (isDef(child.tag) && (
        isUndef(child.ns) || (isTrue(force) && child.tag !== 'svg'))) {
        applyNS(child, ns, force);
      }
    }
  }
}

// ref #5318
// necessary to ensure parent re-render when deep bindings like :style and
// :class are used on slot nodes
function registerDeepBindings (data) {
  if (isObject(data.style)) {
    traverse(data.style);
  }
  if (isObject(data.class)) {
    traverse(data.class);
  }
}

/*  */

function initRender (vm) {
  vm._vnode = null; // the root of the child tree
  vm._staticTrees = null; // v-once cached trees
  var options = vm.$options;
  var parentVnode = vm.$vnode = options._parentVnode; // the placeholder node in parent tree
  var renderContext = parentVnode && parentVnode.context;
  vm.$slots = resolveSlots(options._renderChildren, renderContext);
  vm.$scopedSlots = emptyObject;
  // bind the createElement fn to this instance
  // so that we get proper render context inside it.
  // args order: tag, data, children, normalizationType, alwaysNormalize
  // internal version is used by render functions compiled from templates
  vm._c = function (a, b, c, d) { return createElement(vm, a, b, c, d, false); };
  // normalization is always applied for the public version, used in
  // user-written render functions.
  vm.$createElement = function (a, b, c, d) { return createElement(vm, a, b, c, d, true); };

  // $attrs & $listeners are exposed for easier HOC creation.
  // they need to be reactive so that HOCs using them are always updated
  var parentData = parentVnode && parentVnode.data;

  /* istanbul ignore else */
  {
    defineReactive$$1(vm, '$attrs', parentData && parentData.attrs || emptyObject, function () {
      !isUpdatingChildComponent && warn("$attrs is readonly.", vm);
    }, true);
    defineReactive$$1(vm, '$listeners', options._parentListeners || emptyObject, function () {
      !isUpdatingChildComponent && warn("$listeners is readonly.", vm);
    }, true);
  }
}

var currentRenderingInstance = null;

function renderMixin (Vue) {
  // install runtime convenience helpers
  installRenderHelpers(Vue.prototype);

  Vue.prototype.$nextTick = function (fn) {
    return nextTick(fn, this)
  };

  Vue.prototype._render = function () {
    var vm = this;
    var ref = vm.$options;
    var render = ref.render;
    var _parentVnode = ref._parentVnode;

    if (_parentVnode) {
      vm.$scopedSlots = normalizeScopedSlots(
        _parentVnode.data.scopedSlots,
        vm.$slots,
        vm.$scopedSlots
      );
    }

    // set parent vnode. this allows render functions to have access
    // to the data on the placeholder node.
    vm.$vnode = _parentVnode;
    // render self
    var vnode;
    try {
      // There's no need to maintain a stack because all render fns are called
      // separately from one another. Nested component's render fns are called
      // when parent component is patched.
      currentRenderingInstance = vm;
      vnode = render.call(vm._renderProxy, vm.$createElement);
    } catch (e) {
      handleError(e, vm, "render");
      // return error render result,
      // or previous vnode to prevent render error causing blank component
      /* istanbul ignore else */
      if (vm.$options.renderError) {
        try {
          vnode = vm.$options.renderError.call(vm._renderProxy, vm.$createElement, e);
        } catch (e) {
          handleError(e, vm, "renderError");
          vnode = vm._vnode;
        }
      } else {
        vnode = vm._vnode;
      }
    } finally {
      currentRenderingInstance = null;
    }
    // if the returned array contains only a single node, allow it
    if (Array.isArray(vnode) && vnode.length === 1) {
      vnode = vnode[0];
    }
    // return empty vnode in case the render function errored out
    if (!(vnode instanceof VNode)) {
      if (Array.isArray(vnode)) {
        warn(
          'Multiple root nodes returned from render function. Render function ' +
          'should return a single root node.',
          vm
        );
      }
      vnode = createEmptyVNode();
    }
    // set parent
    vnode.parent = _parentVnode;
    return vnode
  };
}

/*  */

function ensureCtor (comp, base) {
  if (
    comp.__esModule ||
    (hasSymbol && comp[Symbol.toStringTag] === 'Module')
  ) {
    comp = comp.default;
  }
  return isObject(comp)
    ? base.extend(comp)
    : comp
}

function createAsyncPlaceholder (
  factory,
  data,
  context,
  children,
  tag
) {
  var node = createEmptyVNode();
  node.asyncFactory = factory;
  node.asyncMeta = { data: data, context: context, children: children, tag: tag };
  return node
}

function resolveAsyncComponent (
  factory,
  baseCtor
) {
  if (isTrue(factory.error) && isDef(factory.errorComp)) {
    return factory.errorComp
  }

  if (isDef(factory.resolved)) {
    return factory.resolved
  }

  var owner = currentRenderingInstance;
  if (owner && isDef(factory.owners) && factory.owners.indexOf(owner) === -1) {
    // already pending
    factory.owners.push(owner);
  }

  if (isTrue(factory.loading) && isDef(factory.loadingComp)) {
    return factory.loadingComp
  }

  if (owner && !isDef(factory.owners)) {
    var owners = factory.owners = [owner];
    var sync = true;
    var timerLoading = null;
    var timerTimeout = null

    ;(owner).$on('hook:destroyed', function () { return remove(owners, owner); });

    var forceRender = function (renderCompleted) {
      for (var i = 0, l = owners.length; i < l; i++) {
        (owners[i]).$forceUpdate();
      }

      if (renderCompleted) {
        owners.length = 0;
        if (timerLoading !== null) {
          clearTimeout(timerLoading);
          timerLoading = null;
        }
        if (timerTimeout !== null) {
          clearTimeout(timerTimeout);
          timerTimeout = null;
        }
      }
    };

    var resolve = once(function (res) {
      // cache resolved
      factory.resolved = ensureCtor(res, baseCtor);
      // invoke callbacks only if this is not a synchronous resolve
      // (async resolves are shimmed as synchronous during SSR)
      if (!sync) {
        forceRender(true);
      } else {
        owners.length = 0;
      }
    });

    var reject = once(function (reason) {
      warn(
        "Failed to resolve async component: " + (String(factory)) +
        (reason ? ("\nReason: " + reason) : '')
      );
      if (isDef(factory.errorComp)) {
        factory.error = true;
        forceRender(true);
      }
    });

    var res = factory(resolve, reject);

    if (isObject(res)) {
      if (isPromise(res)) {
        // () => Promise
        if (isUndef(factory.resolved)) {
          res.then(resolve, reject);
        }
      } else if (isPromise(res.component)) {
        res.component.then(resolve, reject);

        if (isDef(res.error)) {
          factory.errorComp = ensureCtor(res.error, baseCtor);
        }

        if (isDef(res.loading)) {
          factory.loadingComp = ensureCtor(res.loading, baseCtor);
          if (res.delay === 0) {
            factory.loading = true;
          } else {
            timerLoading = setTimeout(function () {
              timerLoading = null;
              if (isUndef(factory.resolved) && isUndef(factory.error)) {
                factory.loading = true;
                forceRender(false);
              }
            }, res.delay || 200);
          }
        }

        if (isDef(res.timeout)) {
          timerTimeout = setTimeout(function () {
            timerTimeout = null;
            if (isUndef(factory.resolved)) {
              reject(
                "timeout (" + (res.timeout) + "ms)"
              );
            }
          }, res.timeout);
        }
      }
    }

    sync = false;
    // return in case resolved synchronously
    return factory.loading
      ? factory.loadingComp
      : factory.resolved
  }
}

/*  */

function isAsyncPlaceholder (node) {
  return node.isComment && node.asyncFactory
}

/*  */

function getFirstComponentChild (children) {
  if (Array.isArray(children)) {
    for (var i = 0; i < children.length; i++) {
      var c = children[i];
      if (isDef(c) && (isDef(c.componentOptions) || isAsyncPlaceholder(c))) {
        return c
      }
    }
  }
}

/*  */

/*  */

function initEvents (vm) {
  vm._events = Object.create(null);
  vm._hasHookEvent = false;
  // init parent attached events
  var listeners = vm.$options._parentListeners;
  if (listeners) {
    updateComponentListeners(vm, listeners);
  }
}

var target;

function add (event, fn) {
  target.$on(event, fn);
}

function remove$1 (event, fn) {
  target.$off(event, fn);
}

function createOnceHandler (event, fn) {
  var _target = target;
  return function onceHandler () {
    var res = fn.apply(null, arguments);
    if (res !== null) {
      _target.$off(event, onceHandler);
    }
  }
}

function updateComponentListeners (
  vm,
  listeners,
  oldListeners
) {
  target = vm;
  updateListeners(listeners, oldListeners || {}, add, remove$1, createOnceHandler, vm);
  target = undefined;
}

function eventsMixin (Vue) {
  var hookRE = /^hook:/;
  Vue.prototype.$on = function (event, fn) {
    var vm = this;
    if (Array.isArray(event)) {
      for (var i = 0, l = event.length; i < l; i++) {
        vm.$on(event[i], fn);
      }
    } else {
      (vm._events[event] || (vm._events[event] = [])).push(fn);
      // optimize hook:event cost by using a boolean flag marked at registration
      // instead of a hash lookup
      if (hookRE.test(event)) {
        vm._hasHookEvent = true;
      }
    }
    return vm
  };

  Vue.prototype.$once = function (event, fn) {
    var vm = this;
    function on () {
      vm.$off(event, on);
      fn.apply(vm, arguments);
    }
    on.fn = fn;
    vm.$on(event, on);
    return vm
  };

  Vue.prototype.$off = function (event, fn) {
    var vm = this;
    // all
    if (!arguments.length) {
      vm._events = Object.create(null);
      return vm
    }
    // array of events
    if (Array.isArray(event)) {
      for (var i$1 = 0, l = event.length; i$1 < l; i$1++) {
        vm.$off(event[i$1], fn);
      }
      return vm
    }
    // specific event
    var cbs = vm._events[event];
    if (!cbs) {
      return vm
    }
    if (!fn) {
      vm._events[event] = null;
      return vm
    }
    // specific handler
    var cb;
    var i = cbs.length;
    while (i--) {
      cb = cbs[i];
      if (cb === fn || cb.fn === fn) {
        cbs.splice(i, 1);
        break
      }
    }
    return vm
  };

  Vue.prototype.$emit = function (event) {
    var vm = this;
    {
      var lowerCaseEvent = event.toLowerCase();
      if (lowerCaseEvent !== event && vm._events[lowerCaseEvent]) {
        tip(
          "Event \"" + lowerCaseEvent + "\" is emitted in component " +
          (formatComponentName(vm)) + " but the handler is registered for \"" + event + "\". " +
          "Note that HTML attributes are case-insensitive and you cannot use " +
          "v-on to listen to camelCase events when using in-DOM templates. " +
          "You should probably use \"" + (hyphenate(event)) + "\" instead of \"" + event + "\"."
        );
      }
    }
    var cbs = vm._events[event];
    if (cbs) {
      cbs = cbs.length > 1 ? toArray(cbs) : cbs;
      var args = toArray(arguments, 1);
      var info = "event handler for \"" + event + "\"";
      for (var i = 0, l = cbs.length; i < l; i++) {
        invokeWithErrorHandling(cbs[i], vm, args, vm, info);
      }
    }
    return vm
  };
}

/*  */

var activeInstance = null;
var isUpdatingChildComponent = false;

function setActiveInstance(vm) {
  var prevActiveInstance = activeInstance;
  activeInstance = vm;
  return function () {
    activeInstance = prevActiveInstance;
  }
}

function initLifecycle (vm) {
  var options = vm.$options;

  // locate first non-abstract parent
  var parent = options.parent;
  if (parent && !options.abstract) {
    while (parent.$options.abstract && parent.$parent) {
      parent = parent.$parent;
    }
    parent.$children.push(vm);
  }

  vm.$parent = parent;
  vm.$root = parent ? parent.$root : vm;

  vm.$children = [];
  vm.$refs = {};

  vm._watcher = null;
  vm._inactive = null;
  vm._directInactive = false;
  vm._isMounted = false;
  vm._isDestroyed = false;
  vm._isBeingDestroyed = false;
}

function lifecycleMixin (Vue) {
  Vue.prototype._update = function (vnode, hydrating) {
    var vm = this;
    var prevEl = vm.$el;
    var prevVnode = vm._vnode;
    var restoreActiveInstance = setActiveInstance(vm);
    vm._vnode = vnode;
    // Vue.prototype.__patch__ is injected in entry points
    // based on the rendering backend used.
    if (!prevVnode) {
      // initial render
      vm.$el = vm.__patch__(vm.$el, vnode, hydrating, false /* removeOnly */);
    } else {
      // updates
      vm.$el = vm.__patch__(prevVnode, vnode);
    }
    restoreActiveInstance();
    // update __vue__ reference
    if (prevEl) {
      prevEl.__vue__ = null;
    }
    if (vm.$el) {
      vm.$el.__vue__ = vm;
    }
    // if parent is an HOC, update its $el as well
    if (vm.$vnode && vm.$parent && vm.$vnode === vm.$parent._vnode) {
      vm.$parent.$el = vm.$el;
    }
    // updated hook is called by the scheduler to ensure that children are
    // updated in a parent's updated hook.
  };

  Vue.prototype.$forceUpdate = function () {
    var vm = this;
    if (vm._watcher) {
      vm._watcher.update();
    }
  };

  Vue.prototype.$destroy = function () {
    var vm = this;
    if (vm._isBeingDestroyed) {
      return
    }
    callHook(vm, 'beforeDestroy');
    vm._isBeingDestroyed = true;
    // remove self from parent
    var parent = vm.$parent;
    if (parent && !parent._isBeingDestroyed && !vm.$options.abstract) {
      remove(parent.$children, vm);
    }
    // teardown watchers
    if (vm._watcher) {
      vm._watcher.teardown();
    }
    var i = vm._watchers.length;
    while (i--) {
      vm._watchers[i].teardown();
    }
    // remove reference from data ob
    // frozen object may not have observer.
    if (vm._data.__ob__) {
      vm._data.__ob__.vmCount--;
    }
    // call the last hook...
    vm._isDestroyed = true;
    // invoke destroy hooks on current rendered tree
    vm.__patch__(vm._vnode, null);
    // fire destroyed hook
    callHook(vm, 'destroyed');
    // turn off all instance listeners.
    vm.$off();
    // remove __vue__ reference
    if (vm.$el) {
      vm.$el.__vue__ = null;
    }
    // release circular reference (#6759)
    if (vm.$vnode) {
      vm.$vnode.parent = null;
    }
  };
}

function mountComponent (
  vm,
  el,
  hydrating
) {
  vm.$el = el;
  if (!vm.$options.render) {
    vm.$options.render = createEmptyVNode;
    {
      /* istanbul ignore if */
      if ((vm.$options.template && vm.$options.template.charAt(0) !== '#') ||
        vm.$options.el || el) {
        warn(
          'You are using the runtime-only build of Vue where the template ' +
          'compiler is not available. Either pre-compile the templates into ' +
          'render functions, or use the compiler-included build.',
          vm
        );
      } else {
        warn(
          'Failed to mount component: template or render function not defined.',
          vm
        );
      }
    }
  }
  callHook(vm, 'beforeMount');

  var updateComponent;
  /* istanbul ignore if */
  if (config.performance && mark) {
    updateComponent = function () {
      var name = vm._name;
      var id = vm._uid;
      var startTag = "vue-perf-start:" + id;
      var endTag = "vue-perf-end:" + id;

      mark(startTag);
      var vnode = vm._render();
      mark(endTag);
      measure(("vue " + name + " render"), startTag, endTag);

      mark(startTag);
      vm._update(vnode, hydrating);
      mark(endTag);
      measure(("vue " + name + " patch"), startTag, endTag);
    };
  } else {
    updateComponent = function () {
      vm._update(vm._render(), hydrating);
    };
  }

  // we set this to vm._watcher inside the watcher's constructor
  // since the watcher's initial patch may call $forceUpdate (e.g. inside child
  // component's mounted hook), which relies on vm._watcher being already defined
  new Watcher(vm, updateComponent, noop, {
    before: function before () {
      if (vm._isMounted && !vm._isDestroyed) {
        callHook(vm, 'beforeUpdate');
      }
    }
  }, true /* isRenderWatcher */);
  hydrating = false;

  // manually mounted instance, call mounted on self
  // mounted is called for render-created child components in its inserted hook
  if (vm.$vnode == null) {
    vm._isMounted = true;
    callHook(vm, 'mounted');
  }
  return vm
}

function updateChildComponent (
  vm,
  propsData,
  listeners,
  parentVnode,
  renderChildren
) {
  {
    isUpdatingChildComponent = true;
  }

  // determine whether component has slot children
  // we need to do this before overwriting $options._renderChildren.

  // check if there are dynamic scopedSlots (hand-written or compiled but with
  // dynamic slot names). Static scoped slots compiled from template has the
  // "$stable" marker.
  var newScopedSlots = parentVnode.data.scopedSlots;
  var oldScopedSlots = vm.$scopedSlots;
  var hasDynamicScopedSlot = !!(
    (newScopedSlots && !newScopedSlots.$stable) ||
    (oldScopedSlots !== emptyObject && !oldScopedSlots.$stable) ||
    (newScopedSlots && vm.$scopedSlots.$key !== newScopedSlots.$key)
  );

  // Any static slot children from the parent may have changed during parent's
  // update. Dynamic scoped slots may also have changed. In such cases, a forced
  // update is necessary to ensure correctness.
  var needsForceUpdate = !!(
    renderChildren ||               // has new static slots
    vm.$options._renderChildren ||  // has old static slots
    hasDynamicScopedSlot
  );

  vm.$options._parentVnode = parentVnode;
  vm.$vnode = parentVnode; // update vm's placeholder node without re-render

  if (vm._vnode) { // update child tree's parent
    vm._vnode.parent = parentVnode;
  }
  vm.$options._renderChildren = renderChildren;

  // update $attrs and $listeners hash
  // these are also reactive so they may trigger child update if the child
  // used them during render
  vm.$attrs = parentVnode.data.attrs || emptyObject;
  vm.$listeners = listeners || emptyObject;

  // update props
  if (propsData && vm.$options.props) {
    toggleObserving(false);
    var props = vm._props;
    var propKeys = vm.$options._propKeys || [];
    for (var i = 0; i < propKeys.length; i++) {
      var key = propKeys[i];
      var propOptions = vm.$options.props; // wtf flow?
      props[key] = validateProp(key, propOptions, propsData, vm);
    }
    toggleObserving(true);
    // keep a copy of raw propsData
    vm.$options.propsData = propsData;
  }

  // update listeners
  listeners = listeners || emptyObject;
  var oldListeners = vm.$options._parentListeners;
  vm.$options._parentListeners = listeners;
  updateComponentListeners(vm, listeners, oldListeners);

  // resolve slots + force update if has children
  if (needsForceUpdate) {
    vm.$slots = resolveSlots(renderChildren, parentVnode.context);
    vm.$forceUpdate();
  }

  {
    isUpdatingChildComponent = false;
  }
}

function isInInactiveTree (vm) {
  while (vm && (vm = vm.$parent)) {
    if (vm._inactive) { return true }
  }
  return false
}

function activateChildComponent (vm, direct) {
  if (direct) {
    vm._directInactive = false;
    if (isInInactiveTree(vm)) {
      return
    }
  } else if (vm._directInactive) {
    return
  }
  if (vm._inactive || vm._inactive === null) {
    vm._inactive = false;
    for (var i = 0; i < vm.$children.length; i++) {
      activateChildComponent(vm.$children[i]);
    }
    callHook(vm, 'activated');
  }
}

function deactivateChildComponent (vm, direct) {
  if (direct) {
    vm._directInactive = true;
    if (isInInactiveTree(vm)) {
      return
    }
  }
  if (!vm._inactive) {
    vm._inactive = true;
    for (var i = 0; i < vm.$children.length; i++) {
      deactivateChildComponent(vm.$children[i]);
    }
    callHook(vm, 'deactivated');
  }
}

function callHook (vm, hook) {
  // #7573 disable dep collection when invoking lifecycle hooks
  pushTarget();
  var handlers = vm.$options[hook];
  var info = hook + " hook";
  if (handlers) {
    for (var i = 0, j = handlers.length; i < j; i++) {
      invokeWithErrorHandling(handlers[i], vm, null, vm, info);
    }
  }
  if (vm._hasHookEvent) {
    vm.$emit('hook:' + hook);
  }
  popTarget();
}

/*  */

var MAX_UPDATE_COUNT = 100;

var queue = [];
var activatedChildren = [];
var has = {};
var circular = {};
var waiting = false;
var flushing = false;
var index = 0;

/**
 * Reset the scheduler's state.
 */
function resetSchedulerState () {
  index = queue.length = activatedChildren.length = 0;
  has = {};
  {
    circular = {};
  }
  waiting = flushing = false;
}

// Async edge case #6566 requires saving the timestamp when event listeners are
// attached. However, calling performance.now() has a perf overhead especially
// if the page has thousands of event listeners. Instead, we take a timestamp
// every time the scheduler flushes and use that for all event listeners
// attached during that flush.
var currentFlushTimestamp = 0;

// Async edge case fix requires storing an event listener's attach timestamp.
var getNow = Date.now;

// Determine what event timestamp the browser is using. Annoyingly, the
// timestamp can either be hi-res (relative to page load) or low-res
// (relative to UNIX epoch), so in order to compare time we have to use the
// same timestamp type when saving the flush timestamp.
// All IE versions use low-res event timestamps, and have problematic clock
// implementations (#9632)
if (inBrowser && !isIE) {
  var performance = window.performance;
  if (
    performance &&
    typeof performance.now === 'function' &&
    getNow() > document.createEvent('Event').timeStamp
  ) {
    // if the event timestamp, although evaluated AFTER the Date.now(), is
    // smaller than it, it means the event is using a hi-res timestamp,
    // and we need to use the hi-res version for event listener timestamps as
    // well.
    getNow = function () { return performance.now(); };
  }
}

/**
 * Flush both queues and run the watchers.
 */
function flushSchedulerQueue () {
  currentFlushTimestamp = getNow();
  flushing = true;
  var watcher, id;

  // Sort queue before flush.
  // This ensures that:
  // 1. Components are updated from parent to child. (because parent is always
  //    created before the child)
  // 2. A component's user watchers are run before its render watcher (because
  //    user watchers are created before the render watcher)
  // 3. If a component is destroyed during a parent component's watcher run,
  //    its watchers can be skipped.
  queue.sort(function (a, b) { return a.id - b.id; });

  // do not cache length because more watchers might be pushed
  // as we run existing watchers
  for (index = 0; index < queue.length; index++) {
    watcher = queue[index];
    if (watcher.before) {
      watcher.before();
    }
    id = watcher.id;
    has[id] = null;
    watcher.run();
    // in dev build, check and stop circular updates.
    if (has[id] != null) {
      circular[id] = (circular[id] || 0) + 1;
      if (circular[id] > MAX_UPDATE_COUNT) {
        warn(
          'You may have an infinite update loop ' + (
            watcher.user
              ? ("in watcher with expression \"" + (watcher.expression) + "\"")
              : "in a component render function."
          ),
          watcher.vm
        );
        break
      }
    }
  }

  // keep copies of post queues before resetting state
  var activatedQueue = activatedChildren.slice();
  var updatedQueue = queue.slice();

  resetSchedulerState();

  // call component updated and activated hooks
  callActivatedHooks(activatedQueue);
  callUpdatedHooks(updatedQueue);

  // devtool hook
  /* istanbul ignore if */
  if (devtools && config.devtools) {
    devtools.emit('flush');
  }
}

function callUpdatedHooks (queue) {
  var i = queue.length;
  while (i--) {
    var watcher = queue[i];
    var vm = watcher.vm;
    if (vm._watcher === watcher && vm._isMounted && !vm._isDestroyed) {
      callHook(vm, 'updated');
    }
  }
}

/**
 * Queue a kept-alive component that was activated during patch.
 * The queue will be processed after the entire tree has been patched.
 */
function queueActivatedComponent (vm) {
  // setting _inactive to false here so that a render function can
  // rely on checking whether it's in an inactive tree (e.g. router-view)
  vm._inactive = false;
  activatedChildren.push(vm);
}

function callActivatedHooks (queue) {
  for (var i = 0; i < queue.length; i++) {
    queue[i]._inactive = true;
    activateChildComponent(queue[i], true /* true */);
  }
}

/**
 * Push a watcher into the watcher queue.
 * Jobs with duplicate IDs will be skipped unless it's
 * pushed when the queue is being flushed.
 */
function queueWatcher (watcher) {
  var id = watcher.id;
  if (has[id] == null) {
    has[id] = true;
    if (!flushing) {
      queue.push(watcher);
    } else {
      // if already flushing, splice the watcher based on its id
      // if already past its id, it will be run next immediately.
      var i = queue.length - 1;
      while (i > index && queue[i].id > watcher.id) {
        i--;
      }
      queue.splice(i + 1, 0, watcher);
    }
    // queue the flush
    if (!waiting) {
      waiting = true;

      if (!config.async) {
        flushSchedulerQueue();
        return
      }
      nextTick(flushSchedulerQueue);
    }
  }
}

/*  */



var uid$2 = 0;

/**
 * A watcher parses an expression, collects dependencies,
 * and fires callback when the expression value changes.
 * This is used for both the $watch() api and directives.
 */
var Watcher = function Watcher (
  vm,
  expOrFn,
  cb,
  options,
  isRenderWatcher
) {
  this.vm = vm;
  if (isRenderWatcher) {
    vm._watcher = this;
  }
  vm._watchers.push(this);
  // options
  if (options) {
    this.deep = !!options.deep;
    this.user = !!options.user;
    this.lazy = !!options.lazy;
    this.sync = !!options.sync;
    this.before = options.before;
  } else {
    this.deep = this.user = this.lazy = this.sync = false;
  }
  this.cb = cb;
  this.id = ++uid$2; // uid for batching
  this.active = true;
  this.dirty = this.lazy; // for lazy watchers
  this.deps = [];
  this.newDeps = [];
  this.depIds = new _Set();
  this.newDepIds = new _Set();
  this.expression = expOrFn.toString();
  // parse expression for getter
  if (typeof expOrFn === 'function') {
    this.getter = expOrFn;
  } else {
    this.getter = parsePath(expOrFn);
    if (!this.getter) {
      this.getter = noop;
      warn(
        "Failed watching path: \"" + expOrFn + "\" " +
        'Watcher only accepts simple dot-delimited paths. ' +
        'For full control, use a function instead.',
        vm
      );
    }
  }
  this.value = this.lazy
    ? undefined
    : this.get();
};

/**
 * Evaluate the getter, and re-collect dependencies.
 */
Watcher.prototype.get = function get () {
  pushTarget(this);
  var value;
  var vm = this.vm;
  try {
    value = this.getter.call(vm, vm);
  } catch (e) {
    if (this.user) {
      handleError(e, vm, ("getter for watcher \"" + (this.expression) + "\""));
    } else {
      throw e
    }
  } finally {
    // "touch" every property so they are all tracked as
    // dependencies for deep watching
    if (this.deep) {
      traverse(value);
    }
    popTarget();
    this.cleanupDeps();
  }
  return value
};

/**
 * Add a dependency to this directive.
 */
Watcher.prototype.addDep = function addDep (dep) {
  var id = dep.id;
  if (!this.newDepIds.has(id)) {
    this.newDepIds.add(id);
    this.newDeps.push(dep);
    if (!this.depIds.has(id)) {
      dep.addSub(this);
    }
  }
};

/**
 * Clean up for dependency collection.
 */
Watcher.prototype.cleanupDeps = function cleanupDeps () {
  var i = this.deps.length;
  while (i--) {
    var dep = this.deps[i];
    if (!this.newDepIds.has(dep.id)) {
      dep.removeSub(this);
    }
  }
  var tmp = this.depIds;
  this.depIds = this.newDepIds;
  this.newDepIds = tmp;
  this.newDepIds.clear();
  tmp = this.deps;
  this.deps = this.newDeps;
  this.newDeps = tmp;
  this.newDeps.length = 0;
};

/**
 * Subscriber interface.
 * Will be called when a dependency changes.
 */
Watcher.prototype.update = function update () {
  /* istanbul ignore else */
  if (this.lazy) {
    this.dirty = true;
  } else if (this.sync) {
    this.run();
  } else {
    queueWatcher(this);
  }
};

/**
 * Scheduler job interface.
 * Will be called by the scheduler.
 */
Watcher.prototype.run = function run () {
  if (this.active) {
    var value = this.get();
    if (
      value !== this.value ||
      // Deep watchers and watchers on Object/Arrays should fire even
      // when the value is the same, because the value may
      // have mutated.
      isObject(value) ||
      this.deep
    ) {
      // set new value
      var oldValue = this.value;
      this.value = value;
      if (this.user) {
        try {
          this.cb.call(this.vm, value, oldValue);
        } catch (e) {
          handleError(e, this.vm, ("callback for watcher \"" + (this.expression) + "\""));
        }
      } else {
        this.cb.call(this.vm, value, oldValue);
      }
    }
  }
};

/**
 * Evaluate the value of the watcher.
 * This only gets called for lazy watchers.
 */
Watcher.prototype.evaluate = function evaluate () {
  this.value = this.get();
  this.dirty = false;
};

/**
 * Depend on all deps collected by this watcher.
 */
Watcher.prototype.depend = function depend () {
  var i = this.deps.length;
  while (i--) {
    this.deps[i].depend();
  }
};

/**
 * Remove self from all dependencies' subscriber list.
 */
Watcher.prototype.teardown = function teardown () {
  if (this.active) {
    // remove self from vm's watcher list
    // this is a somewhat expensive operation so we skip it
    // if the vm is being destroyed.
    if (!this.vm._isBeingDestroyed) {
      remove(this.vm._watchers, this);
    }
    var i = this.deps.length;
    while (i--) {
      this.deps[i].removeSub(this);
    }
    this.active = false;
  }
};

/*  */

var sharedPropertyDefinition = {
  enumerable: true,
  configurable: true,
  get: noop,
  set: noop
};

function proxy (target, sourceKey, key) {
  sharedPropertyDefinition.get = function proxyGetter () {
    return this[sourceKey][key]
  };
  sharedPropertyDefinition.set = function proxySetter (val) {
    this[sourceKey][key] = val;
  };
  Object.defineProperty(target, key, sharedPropertyDefinition);
}

function initState (vm) {
  vm._watchers = [];
  var opts = vm.$options;
  if (opts.props) { initProps(vm, opts.props); }
  if (opts.methods) { initMethods(vm, opts.methods); }
  if (opts.data) {
    initData(vm);
  } else {
    observe(vm._data = {}, true /* asRootData */);
  }
  if (opts.computed) { initComputed(vm, opts.computed); }
  if (opts.watch && opts.watch !== nativeWatch) {
    initWatch(vm, opts.watch);
  }
}

function initProps (vm, propsOptions) {
  var propsData = vm.$options.propsData || {};
  var props = vm._props = {};
  // cache prop keys so that future props updates can iterate using Array
  // instead of dynamic object key enumeration.
  var keys = vm.$options._propKeys = [];
  var isRoot = !vm.$parent;
  // root instance props should be converted
  if (!isRoot) {
    toggleObserving(false);
  }
  var loop = function ( key ) {
    keys.push(key);
    var value = validateProp(key, propsOptions, propsData, vm);
    /* istanbul ignore else */
    {
      var hyphenatedKey = hyphenate(key);
      if (isReservedAttribute(hyphenatedKey) ||
          config.isReservedAttr(hyphenatedKey)) {
        warn(
          ("\"" + hyphenatedKey + "\" is a reserved attribute and cannot be used as component prop."),
          vm
        );
      }
      defineReactive$$1(props, key, value, function () {
        if (!isRoot && !isUpdatingChildComponent) {
          warn(
            "Avoid mutating a prop directly since the value will be " +
            "overwritten whenever the parent component re-renders. " +
            "Instead, use a data or computed property based on the prop's " +
            "value. Prop being mutated: \"" + key + "\"",
            vm
          );
        }
      });
    }
    // static props are already proxied on the component's prototype
    // during Vue.extend(). We only need to proxy props defined at
    // instantiation here.
    if (!(key in vm)) {
      proxy(vm, "_props", key);
    }
  };

  for (var key in propsOptions) loop( key );
  toggleObserving(true);
}

function initData (vm) {
  var data = vm.$options.data;
  data = vm._data = typeof data === 'function'
    ? getData(data, vm)
    : data || {};
  if (!isPlainObject(data)) {
    data = {};
    warn(
      'data functions should return an object:\n' +
      'https://vuejs.org/v2/guide/components.html#data-Must-Be-a-Function',
      vm
    );
  }
  // proxy data on instance
  var keys = Object.keys(data);
  var props = vm.$options.props;
  var methods = vm.$options.methods;
  var i = keys.length;
  while (i--) {
    var key = keys[i];
    {
      if (methods && hasOwn(methods, key)) {
        warn(
          ("Method \"" + key + "\" has already been defined as a data property."),
          vm
        );
      }
    }
    if (props && hasOwn(props, key)) {
      warn(
        "The data property \"" + key + "\" is already declared as a prop. " +
        "Use prop default value instead.",
        vm
      );
    } else if (!isReserved(key)) {
      proxy(vm, "_data", key);
    }
  }
  // observe data
  observe(data, true /* asRootData */);
}

function getData (data, vm) {
  // #7573 disable dep collection when invoking data getters
  pushTarget();
  try {
    return data.call(vm, vm)
  } catch (e) {
    handleError(e, vm, "data()");
    return {}
  } finally {
    popTarget();
  }
}

var computedWatcherOptions = { lazy: true };

function initComputed (vm, computed) {
  // $flow-disable-line
  var watchers = vm._computedWatchers = Object.create(null);
  // computed properties are just getters during SSR
  var isSSR = isServerRendering();

  for (var key in computed) {
    var userDef = computed[key];
    var getter = typeof userDef === 'function' ? userDef : userDef.get;
    if (getter == null) {
      warn(
        ("Getter is missing for computed property \"" + key + "\"."),
        vm
      );
    }

    if (!isSSR) {
      // create internal watcher for the computed property.
      watchers[key] = new Watcher(
        vm,
        getter || noop,
        noop,
        computedWatcherOptions
      );
    }

    // component-defined computed properties are already defined on the
    // component prototype. We only need to define computed properties defined
    // at instantiation here.
    if (!(key in vm)) {
      defineComputed(vm, key, userDef);
    } else {
      if (key in vm.$data) {
        warn(("The computed property \"" + key + "\" is already defined in data."), vm);
      } else if (vm.$options.props && key in vm.$options.props) {
        warn(("The computed property \"" + key + "\" is already defined as a prop."), vm);
      }
    }
  }
}

function defineComputed (
  target,
  key,
  userDef
) {
  var shouldCache = !isServerRendering();
  if (typeof userDef === 'function') {
    sharedPropertyDefinition.get = shouldCache
      ? createComputedGetter(key)
      : createGetterInvoker(userDef);
    sharedPropertyDefinition.set = noop;
  } else {
    sharedPropertyDefinition.get = userDef.get
      ? shouldCache && userDef.cache !== false
        ? createComputedGetter(key)
        : createGetterInvoker(userDef.get)
      : noop;
    sharedPropertyDefinition.set = userDef.set || noop;
  }
  if (sharedPropertyDefinition.set === noop) {
    sharedPropertyDefinition.set = function () {
      warn(
        ("Computed property \"" + key + "\" was assigned to but it has no setter."),
        this
      );
    };
  }
  Object.defineProperty(target, key, sharedPropertyDefinition);
}

function createComputedGetter (key) {
  return function computedGetter () {
    var watcher = this._computedWatchers && this._computedWatchers[key];
    if (watcher) {
      if (watcher.dirty) {
        watcher.evaluate();
      }
      if (Dep.target) {
        watcher.depend();
      }
      return watcher.value
    }
  }
}

function createGetterInvoker(fn) {
  return function computedGetter () {
    return fn.call(this, this)
  }
}

function initMethods (vm, methods) {
  var props = vm.$options.props;
  for (var key in methods) {
    {
      if (typeof methods[key] !== 'function') {
        warn(
          "Method \"" + key + "\" has type \"" + (typeof methods[key]) + "\" in the component definition. " +
          "Did you reference the function correctly?",
          vm
        );
      }
      if (props && hasOwn(props, key)) {
        warn(
          ("Method \"" + key + "\" has already been defined as a prop."),
          vm
        );
      }
      if ((key in vm) && isReserved(key)) {
        warn(
          "Method \"" + key + "\" conflicts with an existing Vue instance method. " +
          "Avoid defining component methods that start with _ or $."
        );
      }
    }
    vm[key] = typeof methods[key] !== 'function' ? noop : bind(methods[key], vm);
  }
}

function initWatch (vm, watch) {
  for (var key in watch) {
    var handler = watch[key];
    if (Array.isArray(handler)) {
      for (var i = 0; i < handler.length; i++) {
        createWatcher(vm, key, handler[i]);
      }
    } else {
      createWatcher(vm, key, handler);
    }
  }
}

function createWatcher (
  vm,
  expOrFn,
  handler,
  options
) {
  if (isPlainObject(handler)) {
    options = handler;
    handler = handler.handler;
  }
  if (typeof handler === 'string') {
    handler = vm[handler];
  }
  return vm.$watch(expOrFn, handler, options)
}

function stateMixin (Vue) {
  // flow somehow has problems with directly declared definition object
  // when using Object.defineProperty, so we have to procedurally build up
  // the object here.
  var dataDef = {};
  dataDef.get = function () { return this._data };
  var propsDef = {};
  propsDef.get = function () { return this._props };
  {
    dataDef.set = function () {
      warn(
        'Avoid replacing instance root $data. ' +
        'Use nested data properties instead.',
        this
      );
    };
    propsDef.set = function () {
      warn("$props is readonly.", this);
    };
  }
  Object.defineProperty(Vue.prototype, '$data', dataDef);
  Object.defineProperty(Vue.prototype, '$props', propsDef);

  Vue.prototype.$set = set;
  Vue.prototype.$delete = del;

  Vue.prototype.$watch = function (
    expOrFn,
    cb,
    options
  ) {
    var vm = this;
    if (isPlainObject(cb)) {
      return createWatcher(vm, expOrFn, cb, options)
    }
    options = options || {};
    options.user = true;
    var watcher = new Watcher(vm, expOrFn, cb, options);
    if (options.immediate) {
      try {
        cb.call(vm, watcher.value);
      } catch (error) {
        handleError(error, vm, ("callback for immediate watcher \"" + (watcher.expression) + "\""));
      }
    }
    return function unwatchFn () {
      watcher.teardown();
    }
  };
}

/*  */

var uid$3 = 0;

function initMixin (Vue) {
  Vue.prototype._init = function (options) {
    var vm = this;
    // a uid
    vm._uid = uid$3++;

    var startTag, endTag;
    /* istanbul ignore if */
    if (config.performance && mark) {
      startTag = "vue-perf-start:" + (vm._uid);
      endTag = "vue-perf-end:" + (vm._uid);
      mark(startTag);
    }

    // a flag to avoid this being observed
    vm._isVue = true;
    // merge options
    if (options && options._isComponent) {
      // optimize internal component instantiation
      // since dynamic options merging is pretty slow, and none of the
      // internal component options needs special treatment.
      initInternalComponent(vm, options);
    } else {
      vm.$options = mergeOptions(
        resolveConstructorOptions(vm.constructor),
        options || {},
        vm
      );
    }
    /* istanbul ignore else */
    {
      initProxy(vm);
    }
    // expose real self
    vm._self = vm;
    initLifecycle(vm);
    initEvents(vm);
    initRender(vm);
    callHook(vm, 'beforeCreate');
    initInjections(vm); // resolve injections before data/props
    initState(vm);
    initProvide(vm); // resolve provide after data/props
    callHook(vm, 'created');

    /* istanbul ignore if */
    if (config.performance && mark) {
      vm._name = formatComponentName(vm, false);
      mark(endTag);
      measure(("vue " + (vm._name) + " init"), startTag, endTag);
    }

    if (vm.$options.el) {
      vm.$mount(vm.$options.el);
    }
  };
}

function initInternalComponent (vm, options) {
  var opts = vm.$options = Object.create(vm.constructor.options);
  // doing this because it's faster than dynamic enumeration.
  var parentVnode = options._parentVnode;
  opts.parent = options.parent;
  opts._parentVnode = parentVnode;

  var vnodeComponentOptions = parentVnode.componentOptions;
  opts.propsData = vnodeComponentOptions.propsData;
  opts._parentListeners = vnodeComponentOptions.listeners;
  opts._renderChildren = vnodeComponentOptions.children;
  opts._componentTag = vnodeComponentOptions.tag;

  if (options.render) {
    opts.render = options.render;
    opts.staticRenderFns = options.staticRenderFns;
  }
}

function resolveConstructorOptions (Ctor) {
  var options = Ctor.options;
  if (Ctor.super) {
    var superOptions = resolveConstructorOptions(Ctor.super);
    var cachedSuperOptions = Ctor.superOptions;
    if (superOptions !== cachedSuperOptions) {
      // super option changed,
      // need to resolve new options.
      Ctor.superOptions = superOptions;
      // check if there are any late-modified/attached options (#4976)
      var modifiedOptions = resolveModifiedOptions(Ctor);
      // update base extend options
      if (modifiedOptions) {
        extend(Ctor.extendOptions, modifiedOptions);
      }
      options = Ctor.options = mergeOptions(superOptions, Ctor.extendOptions);
      if (options.name) {
        options.components[options.name] = Ctor;
      }
    }
  }
  return options
}

function resolveModifiedOptions (Ctor) {
  var modified;
  var latest = Ctor.options;
  var sealed = Ctor.sealedOptions;
  for (var key in latest) {
    if (latest[key] !== sealed[key]) {
      if (!modified) { modified = {}; }
      modified[key] = latest[key];
    }
  }
  return modified
}

function Vue (options) {
  if (!(this instanceof Vue)
  ) {
    warn('Vue is a constructor and should be called with the `new` keyword');
  }
  this._init(options);
}

initMixin(Vue);
stateMixin(Vue);
eventsMixin(Vue);
lifecycleMixin(Vue);
renderMixin(Vue);

/*  */

function initUse (Vue) {
  Vue.use = function (plugin) {
    var installedPlugins = (this._installedPlugins || (this._installedPlugins = []));
    if (installedPlugins.indexOf(plugin) > -1) {
      return this
    }

    // additional parameters
    var args = toArray(arguments, 1);
    args.unshift(this);
    if (typeof plugin.install === 'function') {
      plugin.install.apply(plugin, args);
    } else if (typeof plugin === 'function') {
      plugin.apply(null, args);
    }
    installedPlugins.push(plugin);
    return this
  };
}

/*  */

function initMixin$1 (Vue) {
  Vue.mixin = function (mixin) {
    this.options = mergeOptions(this.options, mixin);
    return this
  };
}

/*  */

function initExtend (Vue) {
  /**
   * Each instance constructor, including Vue, has a unique
   * cid. This enables us to create wrapped "child
   * constructors" for prototypal inheritance and cache them.
   */
  Vue.cid = 0;
  var cid = 1;

  /**
   * Class inheritance
   */
  Vue.extend = function (extendOptions) {
    extendOptions = extendOptions || {};
    var Super = this;
    var SuperId = Super.cid;
    var cachedCtors = extendOptions._Ctor || (extendOptions._Ctor = {});
    if (cachedCtors[SuperId]) {
      return cachedCtors[SuperId]
    }

    var name = extendOptions.name || Super.options.name;
    if (name) {
      validateComponentName(name);
    }

    var Sub = function VueComponent (options) {
      this._init(options);
    };
    Sub.prototype = Object.create(Super.prototype);
    Sub.prototype.constructor = Sub;
    Sub.cid = cid++;
    Sub.options = mergeOptions(
      Super.options,
      extendOptions
    );
    Sub['super'] = Super;

    // For props and computed properties, we define the proxy getters on
    // the Vue instances at extension time, on the extended prototype. This
    // avoids Object.defineProperty calls for each instance created.
    if (Sub.options.props) {
      initProps$1(Sub);
    }
    if (Sub.options.computed) {
      initComputed$1(Sub);
    }

    // allow further extension/mixin/plugin usage
    Sub.extend = Super.extend;
    Sub.mixin = Super.mixin;
    Sub.use = Super.use;

    // create asset registers, so extended classes
    // can have their private assets too.
    ASSET_TYPES.forEach(function (type) {
      Sub[type] = Super[type];
    });
    // enable recursive self-lookup
    if (name) {
      Sub.options.components[name] = Sub;
    }

    // keep a reference to the super options at extension time.
    // later at instantiation we can check if Super's options have
    // been updated.
    Sub.superOptions = Super.options;
    Sub.extendOptions = extendOptions;
    Sub.sealedOptions = extend({}, Sub.options);

    // cache constructor
    cachedCtors[SuperId] = Sub;
    return Sub
  };
}

function initProps$1 (Comp) {
  var props = Comp.options.props;
  for (var key in props) {
    proxy(Comp.prototype, "_props", key);
  }
}

function initComputed$1 (Comp) {
  var computed = Comp.options.computed;
  for (var key in computed) {
    defineComputed(Comp.prototype, key, computed[key]);
  }
}

/*  */

function initAssetRegisters (Vue) {
  /**
   * Create asset registration methods.
   */
  ASSET_TYPES.forEach(function (type) {
    Vue[type] = function (
      id,
      definition
    ) {
      if (!definition) {
        return this.options[type + 's'][id]
      } else {
        /* istanbul ignore if */
        if (type === 'component') {
          validateComponentName(id);
        }
        if (type === 'component' && isPlainObject(definition)) {
          definition.name = definition.name || id;
          definition = this.options._base.extend(definition);
        }
        if (type === 'directive' && typeof definition === 'function') {
          definition = { bind: definition, update: definition };
        }
        this.options[type + 's'][id] = definition;
        return definition
      }
    };
  });
}

/*  */



function getComponentName (opts) {
  return opts && (opts.Ctor.options.name || opts.tag)
}

function matches (pattern, name) {
  if (Array.isArray(pattern)) {
    return pattern.indexOf(name) > -1
  } else if (typeof pattern === 'string') {
    return pattern.split(',').indexOf(name) > -1
  } else if (isRegExp(pattern)) {
    return pattern.test(name)
  }
  /* istanbul ignore next */
  return false
}

function pruneCache (keepAliveInstance, filter) {
  var cache = keepAliveInstance.cache;
  var keys = keepAliveInstance.keys;
  var _vnode = keepAliveInstance._vnode;
  for (var key in cache) {
    var cachedNode = cache[key];
    if (cachedNode) {
      var name = getComponentName(cachedNode.componentOptions);
      if (name && !filter(name)) {
        pruneCacheEntry(cache, key, keys, _vnode);
      }
    }
  }
}

function pruneCacheEntry (
  cache,
  key,
  keys,
  current
) {
  var cached$$1 = cache[key];
  if (cached$$1 && (!current || cached$$1.tag !== current.tag)) {
    cached$$1.componentInstance.$destroy();
  }
  cache[key] = null;
  remove(keys, key);
}

var patternTypes = [String, RegExp, Array];

var KeepAlive = {
  name: 'keep-alive',
  abstract: true,

  props: {
    include: patternTypes,
    exclude: patternTypes,
    max: [String, Number]
  },

  created: function created () {
    this.cache = Object.create(null);
    this.keys = [];
  },

  destroyed: function destroyed () {
    for (var key in this.cache) {
      pruneCacheEntry(this.cache, key, this.keys);
    }
  },

  mounted: function mounted () {
    var this$1 = this;

    this.$watch('include', function (val) {
      pruneCache(this$1, function (name) { return matches(val, name); });
    });
    this.$watch('exclude', function (val) {
      pruneCache(this$1, function (name) { return !matches(val, name); });
    });
  },

  render: function render () {
    var slot = this.$slots.default;
    var vnode = getFirstComponentChild(slot);
    var componentOptions = vnode && vnode.componentOptions;
    if (componentOptions) {
      // check pattern
      var name = getComponentName(componentOptions);
      var ref = this;
      var include = ref.include;
      var exclude = ref.exclude;
      if (
        // not included
        (include && (!name || !matches(include, name))) ||
        // excluded
        (exclude && name && matches(exclude, name))
      ) {
        return vnode
      }

      var ref$1 = this;
      var cache = ref$1.cache;
      var keys = ref$1.keys;
      var key = vnode.key == null
        // same constructor may get registered as different local components
        // so cid alone is not enough (#3269)
        ? componentOptions.Ctor.cid + (componentOptions.tag ? ("::" + (componentOptions.tag)) : '')
        : vnode.key;
      if (cache[key]) {
        vnode.componentInstance = cache[key].componentInstance;
        // make current key freshest
        remove(keys, key);
        keys.push(key);
      } else {
        cache[key] = vnode;
        keys.push(key);
        // prune oldest entry
        if (this.max && keys.length > parseInt(this.max)) {
          pruneCacheEntry(cache, keys[0], keys, this._vnode);
        }
      }

      vnode.data.keepAlive = true;
    }
    return vnode || (slot && slot[0])
  }
};

var builtInComponents = {
  KeepAlive: KeepAlive
};

/*  */

function initGlobalAPI (Vue) {
  // config
  var configDef = {};
  configDef.get = function () { return config; };
  {
    configDef.set = function () {
      warn(
        'Do not replace the Vue.config object, set individual fields instead.'
      );
    };
  }
  Object.defineProperty(Vue, 'config', configDef);

  // exposed util methods.
  // NOTE: these are not considered part of the public API - avoid relying on
  // them unless you are aware of the risk.
  Vue.util = {
    warn: warn,
    extend: extend,
    mergeOptions: mergeOptions,
    defineReactive: defineReactive$$1
  };

  Vue.set = set;
  Vue.delete = del;
  Vue.nextTick = nextTick;

  // 2.6 explicit observable API
  Vue.observable = function (obj) {
    observe(obj);
    return obj
  };

  Vue.options = Object.create(null);
  ASSET_TYPES.forEach(function (type) {
    Vue.options[type + 's'] = Object.create(null);
  });

  // this is used to identify the "base" constructor to extend all plain-object
  // components with in Weex's multi-instance scenarios.
  Vue.options._base = Vue;

  extend(Vue.options.components, builtInComponents);

  initUse(Vue);
  initMixin$1(Vue);
  initExtend(Vue);
  initAssetRegisters(Vue);
}

initGlobalAPI(Vue);

Object.defineProperty(Vue.prototype, '$isServer', {
  get: isServerRendering
});

Object.defineProperty(Vue.prototype, '$ssrContext', {
  get: function get () {
    /* istanbul ignore next */
    return this.$vnode && this.$vnode.ssrContext
  }
});

// expose FunctionalRenderContext for ssr runtime helper installation
Object.defineProperty(Vue, 'FunctionalRenderContext', {
  value: FunctionalRenderContext
});

Vue.version = '2.6.11';

/*  */

// these are reserved for web because they are directly compiled away
// during template compilation
var isReservedAttr = makeMap('style,class');

// attributes that should be using props for binding
var acceptValue = makeMap('input,textarea,option,select,progress');
var mustUseProp = function (tag, type, attr) {
  return (
    (attr === 'value' && acceptValue(tag)) && type !== 'button' ||
    (attr === 'selected' && tag === 'option') ||
    (attr === 'checked' && tag === 'input') ||
    (attr === 'muted' && tag === 'video')
  )
};

var isEnumeratedAttr = makeMap('contenteditable,draggable,spellcheck');

var isValidContentEditableValue = makeMap('events,caret,typing,plaintext-only');

var convertEnumeratedValue = function (key, value) {
  return isFalsyAttrValue(value) || value === 'false'
    ? 'false'
    // allow arbitrary string value for contenteditable
    : key === 'contenteditable' && isValidContentEditableValue(value)
      ? value
      : 'true'
};

var isBooleanAttr = makeMap(
  'allowfullscreen,async,autofocus,autoplay,checked,compact,controls,declare,' +
  'default,defaultchecked,defaultmuted,defaultselected,defer,disabled,' +
  'enabled,formnovalidate,hidden,indeterminate,inert,ismap,itemscope,loop,multiple,' +
  'muted,nohref,noresize,noshade,novalidate,nowrap,open,pauseonexit,readonly,' +
  'required,reversed,scoped,seamless,selected,sortable,translate,' +
  'truespeed,typemustmatch,visible'
);

var xlinkNS = 'http://www.w3.org/1999/xlink';

var isXlink = function (name) {
  return name.charAt(5) === ':' && name.slice(0, 5) === 'xlink'
};

var getXlinkProp = function (name) {
  return isXlink(name) ? name.slice(6, name.length) : ''
};

var isFalsyAttrValue = function (val) {
  return val == null || val === false
};

/*  */

function genClassForVnode (vnode) {
  var data = vnode.data;
  var parentNode = vnode;
  var childNode = vnode;
  while (isDef(childNode.componentInstance)) {
    childNode = childNode.componentInstance._vnode;
    if (childNode && childNode.data) {
      data = mergeClassData(childNode.data, data);
    }
  }
  while (isDef(parentNode = parentNode.parent)) {
    if (parentNode && parentNode.data) {
      data = mergeClassData(data, parentNode.data);
    }
  }
  return renderClass(data.staticClass, data.class)
}

function mergeClassData (child, parent) {
  return {
    staticClass: concat(child.staticClass, parent.staticClass),
    class: isDef(child.class)
      ? [child.class, parent.class]
      : parent.class
  }
}

function renderClass (
  staticClass,
  dynamicClass
) {
  if (isDef(staticClass) || isDef(dynamicClass)) {
    return concat(staticClass, stringifyClass(dynamicClass))
  }
  /* istanbul ignore next */
  return ''
}

function concat (a, b) {
  return a ? b ? (a + ' ' + b) : a : (b || '')
}

function stringifyClass (value) {
  if (Array.isArray(value)) {
    return stringifyArray(value)
  }
  if (isObject(value)) {
    return stringifyObject(value)
  }
  if (typeof value === 'string') {
    return value
  }
  /* istanbul ignore next */
  return ''
}

function stringifyArray (value) {
  var res = '';
  var stringified;
  for (var i = 0, l = value.length; i < l; i++) {
    if (isDef(stringified = stringifyClass(value[i])) && stringified !== '') {
      if (res) { res += ' '; }
      res += stringified;
    }
  }
  return res
}

function stringifyObject (value) {
  var res = '';
  for (var key in value) {
    if (value[key]) {
      if (res) { res += ' '; }
      res += key;
    }
  }
  return res
}

/*  */

var namespaceMap = {
  svg: 'http://www.w3.org/2000/svg',
  math: 'http://www.w3.org/1998/Math/MathML'
};

var isHTMLTag = makeMap(
  'html,body,base,head,link,meta,style,title,' +
  'address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,' +
  'div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,' +
  'a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,' +
  's,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,' +
  'embed,object,param,source,canvas,script,noscript,del,ins,' +
  'caption,col,colgroup,table,thead,tbody,td,th,tr,' +
  'button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,' +
  'output,progress,select,textarea,' +
  'details,dialog,menu,menuitem,summary,' +
  'content,element,shadow,template,blockquote,iframe,tfoot'
);

// this map is intentionally selective, only covering SVG elements that may
// contain child elements.
var isSVG = makeMap(
  'svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,font-face,' +
  'foreignObject,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,' +
  'polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view',
  true
);

var isPreTag = function (tag) { return tag === 'pre'; };

var isReservedTag = function (tag) {
  return isHTMLTag(tag) || isSVG(tag)
};

function getTagNamespace (tag) {
  if (isSVG(tag)) {
    return 'svg'
  }
  // basic support for MathML
  // note it doesn't support other MathML elements being component roots
  if (tag === 'math') {
    return 'math'
  }
}

var unknownElementCache = Object.create(null);
function isUnknownElement (tag) {
  /* istanbul ignore if */
  if (!inBrowser) {
    return true
  }
  if (isReservedTag(tag)) {
    return false
  }
  tag = tag.toLowerCase();
  /* istanbul ignore if */
  if (unknownElementCache[tag] != null) {
    return unknownElementCache[tag]
  }
  var el = document.createElement(tag);
  if (tag.indexOf('-') > -1) {
    // http://stackoverflow.com/a/28210364/1070244
    return (unknownElementCache[tag] = (
      el.constructor === window.HTMLUnknownElement ||
      el.constructor === window.HTMLElement
    ))
  } else {
    return (unknownElementCache[tag] = /HTMLUnknownElement/.test(el.toString()))
  }
}

var isTextInputType = makeMap('text,number,password,search,email,tel,url');

/*  */

/**
 * Query an element selector if it's not an element already.
 */
function query (el) {
  if (typeof el === 'string') {
    var selected = document.querySelector(el);
    if (!selected) {
      warn(
        'Cannot find element: ' + el
      );
      return document.createElement('div')
    }
    return selected
  } else {
    return el
  }
}

/*  */

function createElement$1 (tagName, vnode) {
  var elm = document.createElement(tagName);
  if (tagName !== 'select') {
    return elm
  }
  // false or null will remove the attribute but undefined will not
  if (vnode.data && vnode.data.attrs && vnode.data.attrs.multiple !== undefined) {
    elm.setAttribute('multiple', 'multiple');
  }
  return elm
}

function createElementNS (namespace, tagName) {
  return document.createElementNS(namespaceMap[namespace], tagName)
}

function createTextNode (text) {
  return document.createTextNode(text)
}

function createComment (text) {
  return document.createComment(text)
}

function insertBefore (parentNode, newNode, referenceNode) {
  parentNode.insertBefore(newNode, referenceNode);
}

function removeChild (node, child) {
  node.removeChild(child);
}

function appendChild (node, child) {
  node.appendChild(child);
}

function parentNode (node) {
  return node.parentNode
}

function nextSibling (node) {
  return node.nextSibling
}

function tagName (node) {
  return node.tagName
}

function setTextContent (node, text) {
  node.textContent = text;
}

function setStyleScope (node, scopeId) {
  node.setAttribute(scopeId, '');
}

var nodeOps = /*#__PURE__*/Object.freeze({
  createElement: createElement$1,
  createElementNS: createElementNS,
  createTextNode: createTextNode,
  createComment: createComment,
  insertBefore: insertBefore,
  removeChild: removeChild,
  appendChild: appendChild,
  parentNode: parentNode,
  nextSibling: nextSibling,
  tagName: tagName,
  setTextContent: setTextContent,
  setStyleScope: setStyleScope
});

/*  */

var ref = {
  create: function create (_, vnode) {
    registerRef(vnode);
  },
  update: function update (oldVnode, vnode) {
    if (oldVnode.data.ref !== vnode.data.ref) {
      registerRef(oldVnode, true);
      registerRef(vnode);
    }
  },
  destroy: function destroy (vnode) {
    registerRef(vnode, true);
  }
};

function registerRef (vnode, isRemoval) {
  var key = vnode.data.ref;
  if (!isDef(key)) { return }

  var vm = vnode.context;
  var ref = vnode.componentInstance || vnode.elm;
  var refs = vm.$refs;
  if (isRemoval) {
    if (Array.isArray(refs[key])) {
      remove(refs[key], ref);
    } else if (refs[key] === ref) {
      refs[key] = undefined;
    }
  } else {
    if (vnode.data.refInFor) {
      if (!Array.isArray(refs[key])) {
        refs[key] = [ref];
      } else if (refs[key].indexOf(ref) < 0) {
        // $flow-disable-line
        refs[key].push(ref);
      }
    } else {
      refs[key] = ref;
    }
  }
}

/**
 * Virtual DOM patching algorithm based on Snabbdom by
 * Simon Friis Vindum (@paldepind)
 * Licensed under the MIT License
 * https://github.com/paldepind/snabbdom/blob/master/LICENSE
 *
 * modified by Evan You (@yyx990803)
 *
 * Not type-checking this because this file is perf-critical and the cost
 * of making flow understand it is not worth it.
 */

var emptyNode = new VNode('', {}, []);

var hooks = ['create', 'activate', 'update', 'remove', 'destroy'];

function sameVnode (a, b) {
  return (
    a.key === b.key && (
      (
        a.tag === b.tag &&
        a.isComment === b.isComment &&
        isDef(a.data) === isDef(b.data) &&
        sameInputType(a, b)
      ) || (
        isTrue(a.isAsyncPlaceholder) &&
        a.asyncFactory === b.asyncFactory &&
        isUndef(b.asyncFactory.error)
      )
    )
  )
}

function sameInputType (a, b) {
  if (a.tag !== 'input') { return true }
  var i;
  var typeA = isDef(i = a.data) && isDef(i = i.attrs) && i.type;
  var typeB = isDef(i = b.data) && isDef(i = i.attrs) && i.type;
  return typeA === typeB || isTextInputType(typeA) && isTextInputType(typeB)
}

function createKeyToOldIdx (children, beginIdx, endIdx) {
  var i, key;
  var map = {};
  for (i = beginIdx; i <= endIdx; ++i) {
    key = children[i].key;
    if (isDef(key)) { map[key] = i; }
  }
  return map
}

function createPatchFunction (backend) {
  var i, j;
  var cbs = {};

  var modules = backend.modules;
  var nodeOps = backend.nodeOps;

  for (i = 0; i < hooks.length; ++i) {
    cbs[hooks[i]] = [];
    for (j = 0; j < modules.length; ++j) {
      if (isDef(modules[j][hooks[i]])) {
        cbs[hooks[i]].push(modules[j][hooks[i]]);
      }
    }
  }

  function emptyNodeAt (elm) {
    return new VNode(nodeOps.tagName(elm).toLowerCase(), {}, [], undefined, elm)
  }

  function createRmCb (childElm, listeners) {
    function remove$$1 () {
      if (--remove$$1.listeners === 0) {
        removeNode(childElm);
      }
    }
    remove$$1.listeners = listeners;
    return remove$$1
  }

  function removeNode (el) {
    var parent = nodeOps.parentNode(el);
    // element may have already been removed due to v-html / v-text
    if (isDef(parent)) {
      nodeOps.removeChild(parent, el);
    }
  }

  function isUnknownElement$$1 (vnode, inVPre) {
    return (
      !inVPre &&
      !vnode.ns &&
      !(
        config.ignoredElements.length &&
        config.ignoredElements.some(function (ignore) {
          return isRegExp(ignore)
            ? ignore.test(vnode.tag)
            : ignore === vnode.tag
        })
      ) &&
      config.isUnknownElement(vnode.tag)
    )
  }

  var creatingElmInVPre = 0;

  function createElm (
    vnode,
    insertedVnodeQueue,
    parentElm,
    refElm,
    nested,
    ownerArray,
    index
  ) {
    if (isDef(vnode.elm) && isDef(ownerArray)) {
      // This vnode was used in a previous render!
      // now it's used as a new node, overwriting its elm would cause
      // potential patch errors down the road when it's used as an insertion
      // reference node. Instead, we clone the node on-demand before creating
      // associated DOM element for it.
      vnode = ownerArray[index] = cloneVNode(vnode);
    }

    vnode.isRootInsert = !nested; // for transition enter check
    if (createComponent(vnode, insertedVnodeQueue, parentElm, refElm)) {
      return
    }

    var data = vnode.data;
    var children = vnode.children;
    var tag = vnode.tag;
    if (isDef(tag)) {
      {
        if (data && data.pre) {
          creatingElmInVPre++;
        }
        if (isUnknownElement$$1(vnode, creatingElmInVPre)) {
          warn(
            'Unknown custom element: <' + tag + '> - did you ' +
            'register the component correctly? For recursive components, ' +
            'make sure to provide the "name" option.',
            vnode.context
          );
        }
      }

      vnode.elm = vnode.ns
        ? nodeOps.createElementNS(vnode.ns, tag)
        : nodeOps.createElement(tag, vnode);
      setScope(vnode);

      /* istanbul ignore if */
      {
        createChildren(vnode, children, insertedVnodeQueue);
        if (isDef(data)) {
          invokeCreateHooks(vnode, insertedVnodeQueue);
        }
        insert(parentElm, vnode.elm, refElm);
      }

      if (data && data.pre) {
        creatingElmInVPre--;
      }
    } else if (isTrue(vnode.isComment)) {
      vnode.elm = nodeOps.createComment(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    } else {
      vnode.elm = nodeOps.createTextNode(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    }
  }

  function createComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i = vnode.data;
    if (isDef(i)) {
      var isReactivated = isDef(vnode.componentInstance) && i.keepAlive;
      if (isDef(i = i.hook) && isDef(i = i.init)) {
        i(vnode, false /* hydrating */);
      }
      // after calling the init hook, if the vnode is a child component
      // it should've created a child instance and mounted it. the child
      // component also has set the placeholder vnode's elm.
      // in that case we can just return the element and be done.
      if (isDef(vnode.componentInstance)) {
        initComponent(vnode, insertedVnodeQueue);
        insert(parentElm, vnode.elm, refElm);
        if (isTrue(isReactivated)) {
          reactivateComponent(vnode, insertedVnodeQueue, parentElm, refElm);
        }
        return true
      }
    }
  }

  function initComponent (vnode, insertedVnodeQueue) {
    if (isDef(vnode.data.pendingInsert)) {
      insertedVnodeQueue.push.apply(insertedVnodeQueue, vnode.data.pendingInsert);
      vnode.data.pendingInsert = null;
    }
    vnode.elm = vnode.componentInstance.$el;
    if (isPatchable(vnode)) {
      invokeCreateHooks(vnode, insertedVnodeQueue);
      setScope(vnode);
    } else {
      // empty component root.
      // skip all element-related modules except for ref (#3455)
      registerRef(vnode);
      // make sure to invoke the insert hook
      insertedVnodeQueue.push(vnode);
    }
  }

  function reactivateComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i;
    // hack for #4339: a reactivated component with inner transition
    // does not trigger because the inner node's created hooks are not called
    // again. It's not ideal to involve module-specific logic in here but
    // there doesn't seem to be a better way to do it.
    var innerNode = vnode;
    while (innerNode.componentInstance) {
      innerNode = innerNode.componentInstance._vnode;
      if (isDef(i = innerNode.data) && isDef(i = i.transition)) {
        for (i = 0; i < cbs.activate.length; ++i) {
          cbs.activate[i](emptyNode, innerNode);
        }
        insertedVnodeQueue.push(innerNode);
        break
      }
    }
    // unlike a newly created component,
    // a reactivated keep-alive component doesn't insert itself
    insert(parentElm, vnode.elm, refElm);
  }

  function insert (parent, elm, ref$$1) {
    if (isDef(parent)) {
      if (isDef(ref$$1)) {
        if (nodeOps.parentNode(ref$$1) === parent) {
          nodeOps.insertBefore(parent, elm, ref$$1);
        }
      } else {
        nodeOps.appendChild(parent, elm);
      }
    }
  }

  function createChildren (vnode, children, insertedVnodeQueue) {
    if (Array.isArray(children)) {
      {
        checkDuplicateKeys(children);
      }
      for (var i = 0; i < children.length; ++i) {
        createElm(children[i], insertedVnodeQueue, vnode.elm, null, true, children, i);
      }
    } else if (isPrimitive(vnode.text)) {
      nodeOps.appendChild(vnode.elm, nodeOps.createTextNode(String(vnode.text)));
    }
  }

  function isPatchable (vnode) {
    while (vnode.componentInstance) {
      vnode = vnode.componentInstance._vnode;
    }
    return isDef(vnode.tag)
  }

  function invokeCreateHooks (vnode, insertedVnodeQueue) {
    for (var i$1 = 0; i$1 < cbs.create.length; ++i$1) {
      cbs.create[i$1](emptyNode, vnode);
    }
    i = vnode.data.hook; // Reuse variable
    if (isDef(i)) {
      if (isDef(i.create)) { i.create(emptyNode, vnode); }
      if (isDef(i.insert)) { insertedVnodeQueue.push(vnode); }
    }
  }

  // set scope id attribute for scoped CSS.
  // this is implemented as a special case to avoid the overhead
  // of going through the normal attribute patching process.
  function setScope (vnode) {
    var i;
    if (isDef(i = vnode.fnScopeId)) {
      nodeOps.setStyleScope(vnode.elm, i);
    } else {
      var ancestor = vnode;
      while (ancestor) {
        if (isDef(i = ancestor.context) && isDef(i = i.$options._scopeId)) {
          nodeOps.setStyleScope(vnode.elm, i);
        }
        ancestor = ancestor.parent;
      }
    }
    // for slot content they should also get the scopeId from the host instance.
    if (isDef(i = activeInstance) &&
      i !== vnode.context &&
      i !== vnode.fnContext &&
      isDef(i = i.$options._scopeId)
    ) {
      nodeOps.setStyleScope(vnode.elm, i);
    }
  }

  function addVnodes (parentElm, refElm, vnodes, startIdx, endIdx, insertedVnodeQueue) {
    for (; startIdx <= endIdx; ++startIdx) {
      createElm(vnodes[startIdx], insertedVnodeQueue, parentElm, refElm, false, vnodes, startIdx);
    }
  }

  function invokeDestroyHook (vnode) {
    var i, j;
    var data = vnode.data;
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.destroy)) { i(vnode); }
      for (i = 0; i < cbs.destroy.length; ++i) { cbs.destroy[i](vnode); }
    }
    if (isDef(i = vnode.children)) {
      for (j = 0; j < vnode.children.length; ++j) {
        invokeDestroyHook(vnode.children[j]);
      }
    }
  }

  function removeVnodes (vnodes, startIdx, endIdx) {
    for (; startIdx <= endIdx; ++startIdx) {
      var ch = vnodes[startIdx];
      if (isDef(ch)) {
        if (isDef(ch.tag)) {
          removeAndInvokeRemoveHook(ch);
          invokeDestroyHook(ch);
        } else { // Text node
          removeNode(ch.elm);
        }
      }
    }
  }

  function removeAndInvokeRemoveHook (vnode, rm) {
    if (isDef(rm) || isDef(vnode.data)) {
      var i;
      var listeners = cbs.remove.length + 1;
      if (isDef(rm)) {
        // we have a recursively passed down rm callback
        // increase the listeners count
        rm.listeners += listeners;
      } else {
        // directly removing
        rm = createRmCb(vnode.elm, listeners);
      }
      // recursively invoke hooks on child component root node
      if (isDef(i = vnode.componentInstance) && isDef(i = i._vnode) && isDef(i.data)) {
        removeAndInvokeRemoveHook(i, rm);
      }
      for (i = 0; i < cbs.remove.length; ++i) {
        cbs.remove[i](vnode, rm);
      }
      if (isDef(i = vnode.data.hook) && isDef(i = i.remove)) {
        i(vnode, rm);
      } else {
        rm();
      }
    } else {
      removeNode(vnode.elm);
    }
  }

  function updateChildren (parentElm, oldCh, newCh, insertedVnodeQueue, removeOnly) {
    var oldStartIdx = 0;
    var newStartIdx = 0;
    var oldEndIdx = oldCh.length - 1;
    var oldStartVnode = oldCh[0];
    var oldEndVnode = oldCh[oldEndIdx];
    var newEndIdx = newCh.length - 1;
    var newStartVnode = newCh[0];
    var newEndVnode = newCh[newEndIdx];
    var oldKeyToIdx, idxInOld, vnodeToMove, refElm;

    // removeOnly is a special flag used only by <transition-group>
    // to ensure removed elements stay in correct relative positions
    // during leaving transitions
    var canMove = !removeOnly;

    {
      checkDuplicateKeys(newCh);
    }

    while (oldStartIdx <= oldEndIdx && newStartIdx <= newEndIdx) {
      if (isUndef(oldStartVnode)) {
        oldStartVnode = oldCh[++oldStartIdx]; // Vnode has been moved left
      } else if (isUndef(oldEndVnode)) {
        oldEndVnode = oldCh[--oldEndIdx];
      } else if (sameVnode(oldStartVnode, newStartVnode)) {
        patchVnode(oldStartVnode, newStartVnode, insertedVnodeQueue, newCh, newStartIdx);
        oldStartVnode = oldCh[++oldStartIdx];
        newStartVnode = newCh[++newStartIdx];
      } else if (sameVnode(oldEndVnode, newEndVnode)) {
        patchVnode(oldEndVnode, newEndVnode, insertedVnodeQueue, newCh, newEndIdx);
        oldEndVnode = oldCh[--oldEndIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldStartVnode, newEndVnode)) { // Vnode moved right
        patchVnode(oldStartVnode, newEndVnode, insertedVnodeQueue, newCh, newEndIdx);
        canMove && nodeOps.insertBefore(parentElm, oldStartVnode.elm, nodeOps.nextSibling(oldEndVnode.elm));
        oldStartVnode = oldCh[++oldStartIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldEndVnode, newStartVnode)) { // Vnode moved left
        patchVnode(oldEndVnode, newStartVnode, insertedVnodeQueue, newCh, newStartIdx);
        canMove && nodeOps.insertBefore(parentElm, oldEndVnode.elm, oldStartVnode.elm);
        oldEndVnode = oldCh[--oldEndIdx];
        newStartVnode = newCh[++newStartIdx];
      } else {
        if (isUndef(oldKeyToIdx)) { oldKeyToIdx = createKeyToOldIdx(oldCh, oldStartIdx, oldEndIdx); }
        idxInOld = isDef(newStartVnode.key)
          ? oldKeyToIdx[newStartVnode.key]
          : findIdxInOld(newStartVnode, oldCh, oldStartIdx, oldEndIdx);
        if (isUndef(idxInOld)) { // New element
          createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm, false, newCh, newStartIdx);
        } else {
          vnodeToMove = oldCh[idxInOld];
          if (sameVnode(vnodeToMove, newStartVnode)) {
            patchVnode(vnodeToMove, newStartVnode, insertedVnodeQueue, newCh, newStartIdx);
            oldCh[idxInOld] = undefined;
            canMove && nodeOps.insertBefore(parentElm, vnodeToMove.elm, oldStartVnode.elm);
          } else {
            // same key but different element. treat as new element
            createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm, false, newCh, newStartIdx);
          }
        }
        newStartVnode = newCh[++newStartIdx];
      }
    }
    if (oldStartIdx > oldEndIdx) {
      refElm = isUndef(newCh[newEndIdx + 1]) ? null : newCh[newEndIdx + 1].elm;
      addVnodes(parentElm, refElm, newCh, newStartIdx, newEndIdx, insertedVnodeQueue);
    } else if (newStartIdx > newEndIdx) {
      removeVnodes(oldCh, oldStartIdx, oldEndIdx);
    }
  }

  function checkDuplicateKeys (children) {
    var seenKeys = {};
    for (var i = 0; i < children.length; i++) {
      var vnode = children[i];
      var key = vnode.key;
      if (isDef(key)) {
        if (seenKeys[key]) {
          warn(
            ("Duplicate keys detected: '" + key + "'. This may cause an update error."),
            vnode.context
          );
        } else {
          seenKeys[key] = true;
        }
      }
    }
  }

  function findIdxInOld (node, oldCh, start, end) {
    for (var i = start; i < end; i++) {
      var c = oldCh[i];
      if (isDef(c) && sameVnode(node, c)) { return i }
    }
  }

  function patchVnode (
    oldVnode,
    vnode,
    insertedVnodeQueue,
    ownerArray,
    index,
    removeOnly
  ) {
    if (oldVnode === vnode) {
      return
    }

    if (isDef(vnode.elm) && isDef(ownerArray)) {
      // clone reused vnode
      vnode = ownerArray[index] = cloneVNode(vnode);
    }

    var elm = vnode.elm = oldVnode.elm;

    if (isTrue(oldVnode.isAsyncPlaceholder)) {
      if (isDef(vnode.asyncFactory.resolved)) {
        hydrate(oldVnode.elm, vnode, insertedVnodeQueue);
      } else {
        vnode.isAsyncPlaceholder = true;
      }
      return
    }

    // reuse element for static trees.
    // note we only do this if the vnode is cloned -
    // if the new node is not cloned it means the render functions have been
    // reset by the hot-reload-api and we need to do a proper re-render.
    if (isTrue(vnode.isStatic) &&
      isTrue(oldVnode.isStatic) &&
      vnode.key === oldVnode.key &&
      (isTrue(vnode.isCloned) || isTrue(vnode.isOnce))
    ) {
      vnode.componentInstance = oldVnode.componentInstance;
      return
    }

    var i;
    var data = vnode.data;
    if (isDef(data) && isDef(i = data.hook) && isDef(i = i.prepatch)) {
      i(oldVnode, vnode);
    }

    var oldCh = oldVnode.children;
    var ch = vnode.children;
    if (isDef(data) && isPatchable(vnode)) {
      for (i = 0; i < cbs.update.length; ++i) { cbs.update[i](oldVnode, vnode); }
      if (isDef(i = data.hook) && isDef(i = i.update)) { i(oldVnode, vnode); }
    }
    if (isUndef(vnode.text)) {
      if (isDef(oldCh) && isDef(ch)) {
        if (oldCh !== ch) { updateChildren(elm, oldCh, ch, insertedVnodeQueue, removeOnly); }
      } else if (isDef(ch)) {
        {
          checkDuplicateKeys(ch);
        }
        if (isDef(oldVnode.text)) { nodeOps.setTextContent(elm, ''); }
        addVnodes(elm, null, ch, 0, ch.length - 1, insertedVnodeQueue);
      } else if (isDef(oldCh)) {
        removeVnodes(oldCh, 0, oldCh.length - 1);
      } else if (isDef(oldVnode.text)) {
        nodeOps.setTextContent(elm, '');
      }
    } else if (oldVnode.text !== vnode.text) {
      nodeOps.setTextContent(elm, vnode.text);
    }
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.postpatch)) { i(oldVnode, vnode); }
    }
  }

  function invokeInsertHook (vnode, queue, initial) {
    // delay insert hooks for component root nodes, invoke them after the
    // element is really inserted
    if (isTrue(initial) && isDef(vnode.parent)) {
      vnode.parent.data.pendingInsert = queue;
    } else {
      for (var i = 0; i < queue.length; ++i) {
        queue[i].data.hook.insert(queue[i]);
      }
    }
  }

  var hydrationBailed = false;
  // list of modules that can skip create hook during hydration because they
  // are already rendered on the client or has no need for initialization
  // Note: style is excluded because it relies on initial clone for future
  // deep updates (#7063).
  var isRenderedModule = makeMap('attrs,class,staticClass,staticStyle,key');

  // Note: this is a browser-only function so we can assume elms are DOM nodes.
  function hydrate (elm, vnode, insertedVnodeQueue, inVPre) {
    var i;
    var tag = vnode.tag;
    var data = vnode.data;
    var children = vnode.children;
    inVPre = inVPre || (data && data.pre);
    vnode.elm = elm;

    if (isTrue(vnode.isComment) && isDef(vnode.asyncFactory)) {
      vnode.isAsyncPlaceholder = true;
      return true
    }
    // assert node match
    {
      if (!assertNodeMatch(elm, vnode, inVPre)) {
        return false
      }
    }
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.init)) { i(vnode, true /* hydrating */); }
      if (isDef(i = vnode.componentInstance)) {
        // child component. it should have hydrated its own tree.
        initComponent(vnode, insertedVnodeQueue);
        return true
      }
    }
    if (isDef(tag)) {
      if (isDef(children)) {
        // empty element, allow client to pick up and populate children
        if (!elm.hasChildNodes()) {
          createChildren(vnode, children, insertedVnodeQueue);
        } else {
          // v-html and domProps: innerHTML
          if (isDef(i = data) && isDef(i = i.domProps) && isDef(i = i.innerHTML)) {
            if (i !== elm.innerHTML) {
              /* istanbul ignore if */
              if (typeof console !== 'undefined' &&
                !hydrationBailed
              ) {
                hydrationBailed = true;
                console.warn('Parent: ', elm);
                console.warn('server innerHTML: ', i);
                console.warn('client innerHTML: ', elm.innerHTML);
              }
              return false
            }
          } else {
            // iterate and compare children lists
            var childrenMatch = true;
            var childNode = elm.firstChild;
            for (var i$1 = 0; i$1 < children.length; i$1++) {
              if (!childNode || !hydrate(childNode, children[i$1], insertedVnodeQueue, inVPre)) {
                childrenMatch = false;
                break
              }
              childNode = childNode.nextSibling;
            }
            // if childNode is not null, it means the actual childNodes list is
            // longer than the virtual children list.
            if (!childrenMatch || childNode) {
              /* istanbul ignore if */
              if (typeof console !== 'undefined' &&
                !hydrationBailed
              ) {
                hydrationBailed = true;
                console.warn('Parent: ', elm);
                console.warn('Mismatching childNodes vs. VNodes: ', elm.childNodes, children);
              }
              return false
            }
          }
        }
      }
      if (isDef(data)) {
        var fullInvoke = false;
        for (var key in data) {
          if (!isRenderedModule(key)) {
            fullInvoke = true;
            invokeCreateHooks(vnode, insertedVnodeQueue);
            break
          }
        }
        if (!fullInvoke && data['class']) {
          // ensure collecting deps for deep class bindings for future updates
          traverse(data['class']);
        }
      }
    } else if (elm.data !== vnode.text) {
      elm.data = vnode.text;
    }
    return true
  }

  function assertNodeMatch (node, vnode, inVPre) {
    if (isDef(vnode.tag)) {
      return vnode.tag.indexOf('vue-component') === 0 || (
        !isUnknownElement$$1(vnode, inVPre) &&
        vnode.tag.toLowerCase() === (node.tagName && node.tagName.toLowerCase())
      )
    } else {
      return node.nodeType === (vnode.isComment ? 8 : 3)
    }
  }

  return function patch (oldVnode, vnode, hydrating, removeOnly) {
    if (isUndef(vnode)) {
      if (isDef(oldVnode)) { invokeDestroyHook(oldVnode); }
      return
    }

    var isInitialPatch = false;
    var insertedVnodeQueue = [];

    if (isUndef(oldVnode)) {
      // empty mount (likely as component), create new root element
      isInitialPatch = true;
      createElm(vnode, insertedVnodeQueue);
    } else {
      var isRealElement = isDef(oldVnode.nodeType);
      if (!isRealElement && sameVnode(oldVnode, vnode)) {
        // patch existing root node
        patchVnode(oldVnode, vnode, insertedVnodeQueue, null, null, removeOnly);
      } else {
        if (isRealElement) {
          // mounting to a real element
          // check if this is server-rendered content and if we can perform
          // a successful hydration.
          if (oldVnode.nodeType === 1 && oldVnode.hasAttribute(SSR_ATTR)) {
            oldVnode.removeAttribute(SSR_ATTR);
            hydrating = true;
          }
          if (isTrue(hydrating)) {
            if (hydrate(oldVnode, vnode, insertedVnodeQueue)) {
              invokeInsertHook(vnode, insertedVnodeQueue, true);
              return oldVnode
            } else {
              warn(
                'The client-side rendered virtual DOM tree is not matching ' +
                'server-rendered content. This is likely caused by incorrect ' +
                'HTML markup, for example nesting block-level elements inside ' +
                '<p>, or missing <tbody>. Bailing hydration and performing ' +
                'full client-side render.'
              );
            }
          }
          // either not server-rendered, or hydration failed.
          // create an empty node and replace it
          oldVnode = emptyNodeAt(oldVnode);
        }

        // replacing existing element
        var oldElm = oldVnode.elm;
        var parentElm = nodeOps.parentNode(oldElm);

        // create new node
        createElm(
          vnode,
          insertedVnodeQueue,
          // extremely rare edge case: do not insert if old element is in a
          // leaving transition. Only happens when combining transition +
          // keep-alive + HOCs. (#4590)
          oldElm._leaveCb ? null : parentElm,
          nodeOps.nextSibling(oldElm)
        );

        // update parent placeholder node element, recursively
        if (isDef(vnode.parent)) {
          var ancestor = vnode.parent;
          var patchable = isPatchable(vnode);
          while (ancestor) {
            for (var i = 0; i < cbs.destroy.length; ++i) {
              cbs.destroy[i](ancestor);
            }
            ancestor.elm = vnode.elm;
            if (patchable) {
              for (var i$1 = 0; i$1 < cbs.create.length; ++i$1) {
                cbs.create[i$1](emptyNode, ancestor);
              }
              // #6513
              // invoke insert hooks that may have been merged by create hooks.
              // e.g. for directives that uses the "inserted" hook.
              var insert = ancestor.data.hook.insert;
              if (insert.merged) {
                // start at index 1 to avoid re-invoking component mounted hook
                for (var i$2 = 1; i$2 < insert.fns.length; i$2++) {
                  insert.fns[i$2]();
                }
              }
            } else {
              registerRef(ancestor);
            }
            ancestor = ancestor.parent;
          }
        }

        // destroy old node
        if (isDef(parentElm)) {
          removeVnodes([oldVnode], 0, 0);
        } else if (isDef(oldVnode.tag)) {
          invokeDestroyHook(oldVnode);
        }
      }
    }

    invokeInsertHook(vnode, insertedVnodeQueue, isInitialPatch);
    return vnode.elm
  }
}

/*  */

var directives = {
  create: updateDirectives,
  update: updateDirectives,
  destroy: function unbindDirectives (vnode) {
    updateDirectives(vnode, emptyNode);
  }
};

function updateDirectives (oldVnode, vnode) {
  if (oldVnode.data.directives || vnode.data.directives) {
    _update(oldVnode, vnode);
  }
}

function _update (oldVnode, vnode) {
  var isCreate = oldVnode === emptyNode;
  var isDestroy = vnode === emptyNode;
  var oldDirs = normalizeDirectives$1(oldVnode.data.directives, oldVnode.context);
  var newDirs = normalizeDirectives$1(vnode.data.directives, vnode.context);

  var dirsWithInsert = [];
  var dirsWithPostpatch = [];

  var key, oldDir, dir;
  for (key in newDirs) {
    oldDir = oldDirs[key];
    dir = newDirs[key];
    if (!oldDir) {
      // new directive, bind
      callHook$1(dir, 'bind', vnode, oldVnode);
      if (dir.def && dir.def.inserted) {
        dirsWithInsert.push(dir);
      }
    } else {
      // existing directive, update
      dir.oldValue = oldDir.value;
      dir.oldArg = oldDir.arg;
      callHook$1(dir, 'update', vnode, oldVnode);
      if (dir.def && dir.def.componentUpdated) {
        dirsWithPostpatch.push(dir);
      }
    }
  }

  if (dirsWithInsert.length) {
    var callInsert = function () {
      for (var i = 0; i < dirsWithInsert.length; i++) {
        callHook$1(dirsWithInsert[i], 'inserted', vnode, oldVnode);
      }
    };
    if (isCreate) {
      mergeVNodeHook(vnode, 'insert', callInsert);
    } else {
      callInsert();
    }
  }

  if (dirsWithPostpatch.length) {
    mergeVNodeHook(vnode, 'postpatch', function () {
      for (var i = 0; i < dirsWithPostpatch.length; i++) {
        callHook$1(dirsWithPostpatch[i], 'componentUpdated', vnode, oldVnode);
      }
    });
  }

  if (!isCreate) {
    for (key in oldDirs) {
      if (!newDirs[key]) {
        // no longer present, unbind
        callHook$1(oldDirs[key], 'unbind', oldVnode, oldVnode, isDestroy);
      }
    }
  }
}

var emptyModifiers = Object.create(null);

function normalizeDirectives$1 (
  dirs,
  vm
) {
  var res = Object.create(null);
  if (!dirs) {
    // $flow-disable-line
    return res
  }
  var i, dir;
  for (i = 0; i < dirs.length; i++) {
    dir = dirs[i];
    if (!dir.modifiers) {
      // $flow-disable-line
      dir.modifiers = emptyModifiers;
    }
    res[getRawDirName(dir)] = dir;
    dir.def = resolveAsset(vm.$options, 'directives', dir.name, true);
  }
  // $flow-disable-line
  return res
}

function getRawDirName (dir) {
  return dir.rawName || ((dir.name) + "." + (Object.keys(dir.modifiers || {}).join('.')))
}

function callHook$1 (dir, hook, vnode, oldVnode, isDestroy) {
  var fn = dir.def && dir.def[hook];
  if (fn) {
    try {
      fn(vnode.elm, dir, vnode, oldVnode, isDestroy);
    } catch (e) {
      handleError(e, vnode.context, ("directive " + (dir.name) + " " + hook + " hook"));
    }
  }
}

var baseModules = [
  ref,
  directives
];

/*  */

function updateAttrs (oldVnode, vnode) {
  var opts = vnode.componentOptions;
  if (isDef(opts) && opts.Ctor.options.inheritAttrs === false) {
    return
  }
  if (isUndef(oldVnode.data.attrs) && isUndef(vnode.data.attrs)) {
    return
  }
  var key, cur, old;
  var elm = vnode.elm;
  var oldAttrs = oldVnode.data.attrs || {};
  var attrs = vnode.data.attrs || {};
  // clone observed objects, as the user probably wants to mutate it
  if (isDef(attrs.__ob__)) {
    attrs = vnode.data.attrs = extend({}, attrs);
  }

  for (key in attrs) {
    cur = attrs[key];
    old = oldAttrs[key];
    if (old !== cur) {
      setAttr(elm, key, cur);
    }
  }
  // #4391: in IE9, setting type can reset value for input[type=radio]
  // #6666: IE/Edge forces progress value down to 1 before setting a max
  /* istanbul ignore if */
  if ((isIE || isEdge) && attrs.value !== oldAttrs.value) {
    setAttr(elm, 'value', attrs.value);
  }
  for (key in oldAttrs) {
    if (isUndef(attrs[key])) {
      if (isXlink(key)) {
        elm.removeAttributeNS(xlinkNS, getXlinkProp(key));
      } else if (!isEnumeratedAttr(key)) {
        elm.removeAttribute(key);
      }
    }
  }
}

function setAttr (el, key, value) {
  if (el.tagName.indexOf('-') > -1) {
    baseSetAttr(el, key, value);
  } else if (isBooleanAttr(key)) {
    // set attribute for blank value
    // e.g. <option disabled>Select one</option>
    if (isFalsyAttrValue(value)) {
      el.removeAttribute(key);
    } else {
      // technically allowfullscreen is a boolean attribute for <iframe>,
      // but Flash expects a value of "true" when used on <embed> tag
      value = key === 'allowfullscreen' && el.tagName === 'EMBED'
        ? 'true'
        : key;
      el.setAttribute(key, value);
    }
  } else if (isEnumeratedAttr(key)) {
    el.setAttribute(key, convertEnumeratedValue(key, value));
  } else if (isXlink(key)) {
    if (isFalsyAttrValue(value)) {
      el.removeAttributeNS(xlinkNS, getXlinkProp(key));
    } else {
      el.setAttributeNS(xlinkNS, key, value);
    }
  } else {
    baseSetAttr(el, key, value);
  }
}

function baseSetAttr (el, key, value) {
  if (isFalsyAttrValue(value)) {
    el.removeAttribute(key);
  } else {
    // #7138: IE10 & 11 fires input event when setting placeholder on
    // <textarea>... block the first input event and remove the blocker
    // immediately.
    /* istanbul ignore if */
    if (
      isIE && !isIE9 &&
      el.tagName === 'TEXTAREA' &&
      key === 'placeholder' && value !== '' && !el.__ieph
    ) {
      var blocker = function (e) {
        e.stopImmediatePropagation();
        el.removeEventListener('input', blocker);
      };
      el.addEventListener('input', blocker);
      // $flow-disable-line
      el.__ieph = true; /* IE placeholder patched */
    }
    el.setAttribute(key, value);
  }
}

var attrs = {
  create: updateAttrs,
  update: updateAttrs
};

/*  */

function updateClass (oldVnode, vnode) {
  var el = vnode.elm;
  var data = vnode.data;
  var oldData = oldVnode.data;
  if (
    isUndef(data.staticClass) &&
    isUndef(data.class) && (
      isUndef(oldData) || (
        isUndef(oldData.staticClass) &&
        isUndef(oldData.class)
      )
    )
  ) {
    return
  }

  var cls = genClassForVnode(vnode);

  // handle transition classes
  var transitionClass = el._transitionClasses;
  if (isDef(transitionClass)) {
    cls = concat(cls, stringifyClass(transitionClass));
  }

  // set the class
  if (cls !== el._prevClass) {
    el.setAttribute('class', cls);
    el._prevClass = cls;
  }
}

var klass = {
  create: updateClass,
  update: updateClass
};

/*  */

var validDivisionCharRE = /[\w).+\-_$\]]/;

function parseFilters (exp) {
  var inSingle = false;
  var inDouble = false;
  var inTemplateString = false;
  var inRegex = false;
  var curly = 0;
  var square = 0;
  var paren = 0;
  var lastFilterIndex = 0;
  var c, prev, i, expression, filters;

  for (i = 0; i < exp.length; i++) {
    prev = c;
    c = exp.charCodeAt(i);
    if (inSingle) {
      if (c === 0x27 && prev !== 0x5C) { inSingle = false; }
    } else if (inDouble) {
      if (c === 0x22 && prev !== 0x5C) { inDouble = false; }
    } else if (inTemplateString) {
      if (c === 0x60 && prev !== 0x5C) { inTemplateString = false; }
    } else if (inRegex) {
      if (c === 0x2f && prev !== 0x5C) { inRegex = false; }
    } else if (
      c === 0x7C && // pipe
      exp.charCodeAt(i + 1) !== 0x7C &&
      exp.charCodeAt(i - 1) !== 0x7C &&
      !curly && !square && !paren
    ) {
      if (expression === undefined) {
        // first filter, end of expression
        lastFilterIndex = i + 1;
        expression = exp.slice(0, i).trim();
      } else {
        pushFilter();
      }
    } else {
      switch (c) {
        case 0x22: inDouble = true; break         // "
        case 0x27: inSingle = true; break         // '
        case 0x60: inTemplateString = true; break // `
        case 0x28: paren++; break                 // (
        case 0x29: paren--; break                 // )
        case 0x5B: square++; break                // [
        case 0x5D: square--; break                // ]
        case 0x7B: curly++; break                 // {
        case 0x7D: curly--; break                 // }
      }
      if (c === 0x2f) { // /
        var j = i - 1;
        var p = (void 0);
        // find first non-whitespace prev char
        for (; j >= 0; j--) {
          p = exp.charAt(j);
          if (p !== ' ') { break }
        }
        if (!p || !validDivisionCharRE.test(p)) {
          inRegex = true;
        }
      }
    }
  }

  if (expression === undefined) {
    expression = exp.slice(0, i).trim();
  } else if (lastFilterIndex !== 0) {
    pushFilter();
  }

  function pushFilter () {
    (filters || (filters = [])).push(exp.slice(lastFilterIndex, i).trim());
    lastFilterIndex = i + 1;
  }

  if (filters) {
    for (i = 0; i < filters.length; i++) {
      expression = wrapFilter(expression, filters[i]);
    }
  }

  return expression
}

function wrapFilter (exp, filter) {
  var i = filter.indexOf('(');
  if (i < 0) {
    // _f: resolveFilter
    return ("_f(\"" + filter + "\")(" + exp + ")")
  } else {
    var name = filter.slice(0, i);
    var args = filter.slice(i + 1);
    return ("_f(\"" + name + "\")(" + exp + (args !== ')' ? ',' + args : args))
  }
}

/*  */



/* eslint-disable no-unused-vars */
function baseWarn (msg, range) {
  console.error(("[Vue compiler]: " + msg));
}
/* eslint-enable no-unused-vars */

function pluckModuleFunction (
  modules,
  key
) {
  return modules
    ? modules.map(function (m) { return m[key]; }).filter(function (_) { return _; })
    : []
}

function addProp (el, name, value, range, dynamic) {
  (el.props || (el.props = [])).push(rangeSetItem({ name: name, value: value, dynamic: dynamic }, range));
  el.plain = false;
}

function addAttr (el, name, value, range, dynamic) {
  var attrs = dynamic
    ? (el.dynamicAttrs || (el.dynamicAttrs = []))
    : (el.attrs || (el.attrs = []));
  attrs.push(rangeSetItem({ name: name, value: value, dynamic: dynamic }, range));
  el.plain = false;
}

// add a raw attr (use this in preTransforms)
function addRawAttr (el, name, value, range) {
  el.attrsMap[name] = value;
  el.attrsList.push(rangeSetItem({ name: name, value: value }, range));
}

function addDirective (
  el,
  name,
  rawName,
  value,
  arg,
  isDynamicArg,
  modifiers,
  range
) {
  (el.directives || (el.directives = [])).push(rangeSetItem({
    name: name,
    rawName: rawName,
    value: value,
    arg: arg,
    isDynamicArg: isDynamicArg,
    modifiers: modifiers
  }, range));
  el.plain = false;
}

function prependModifierMarker (symbol, name, dynamic) {
  return dynamic
    ? ("_p(" + name + ",\"" + symbol + "\")")
    : symbol + name // mark the event as captured
}

function addHandler (
  el,
  name,
  value,
  modifiers,
  important,
  warn,
  range,
  dynamic
) {
  modifiers = modifiers || emptyObject;
  // warn prevent and passive modifier
  /* istanbul ignore if */
  if (
    warn &&
    modifiers.prevent && modifiers.passive
  ) {
    warn(
      'passive and prevent can\'t be used together. ' +
      'Passive handler can\'t prevent default event.',
      range
    );
  }

  // normalize click.right and click.middle since they don't actually fire
  // this is technically browser-specific, but at least for now browsers are
  // the only target envs that have right/middle clicks.
  if (modifiers.right) {
    if (dynamic) {
      name = "(" + name + ")==='click'?'contextmenu':(" + name + ")";
    } else if (name === 'click') {
      name = 'contextmenu';
      delete modifiers.right;
    }
  } else if (modifiers.middle) {
    if (dynamic) {
      name = "(" + name + ")==='click'?'mouseup':(" + name + ")";
    } else if (name === 'click') {
      name = 'mouseup';
    }
  }

  // check capture modifier
  if (modifiers.capture) {
    delete modifiers.capture;
    name = prependModifierMarker('!', name, dynamic);
  }
  if (modifiers.once) {
    delete modifiers.once;
    name = prependModifierMarker('~', name, dynamic);
  }
  /* istanbul ignore if */
  if (modifiers.passive) {
    delete modifiers.passive;
    name = prependModifierMarker('&', name, dynamic);
  }

  var events;
  if (modifiers.native) {
    delete modifiers.native;
    events = el.nativeEvents || (el.nativeEvents = {});
  } else {
    events = el.events || (el.events = {});
  }

  var newHandler = rangeSetItem({ value: value.trim(), dynamic: dynamic }, range);
  if (modifiers !== emptyObject) {
    newHandler.modifiers = modifiers;
  }

  var handlers = events[name];
  /* istanbul ignore if */
  if (Array.isArray(handlers)) {
    important ? handlers.unshift(newHandler) : handlers.push(newHandler);
  } else if (handlers) {
    events[name] = important ? [newHandler, handlers] : [handlers, newHandler];
  } else {
    events[name] = newHandler;
  }

  el.plain = false;
}

function getRawBindingAttr (
  el,
  name
) {
  return el.rawAttrsMap[':' + name] ||
    el.rawAttrsMap['v-bind:' + name] ||
    el.rawAttrsMap[name]
}

function getBindingAttr (
  el,
  name,
  getStatic
) {
  var dynamicValue =
    getAndRemoveAttr(el, ':' + name) ||
    getAndRemoveAttr(el, 'v-bind:' + name);
  if (dynamicValue != null) {
    return parseFilters(dynamicValue)
  } else if (getStatic !== false) {
    var staticValue = getAndRemoveAttr(el, name);
    if (staticValue != null) {
      return JSON.stringify(staticValue)
    }
  }
}

// note: this only removes the attr from the Array (attrsList) so that it
// doesn't get processed by processAttrs.
// By default it does NOT remove it from the map (attrsMap) because the map is
// needed during codegen.
function getAndRemoveAttr (
  el,
  name,
  removeFromMap
) {
  var val;
  if ((val = el.attrsMap[name]) != null) {
    var list = el.attrsList;
    for (var i = 0, l = list.length; i < l; i++) {
      if (list[i].name === name) {
        list.splice(i, 1);
        break
      }
    }
  }
  if (removeFromMap) {
    delete el.attrsMap[name];
  }
  return val
}

function getAndRemoveAttrByRegex (
  el,
  name
) {
  var list = el.attrsList;
  for (var i = 0, l = list.length; i < l; i++) {
    var attr = list[i];
    if (name.test(attr.name)) {
      list.splice(i, 1);
      return attr
    }
  }
}

function rangeSetItem (
  item,
  range
) {
  if (range) {
    if (range.start != null) {
      item.start = range.start;
    }
    if (range.end != null) {
      item.end = range.end;
    }
  }
  return item
}

/*  */

/**
 * Cross-platform code generation for component v-model
 */
function genComponentModel (
  el,
  value,
  modifiers
) {
  var ref = modifiers || {};
  var number = ref.number;
  var trim = ref.trim;

  var baseValueExpression = '$$v';
  var valueExpression = baseValueExpression;
  if (trim) {
    valueExpression =
      "(typeof " + baseValueExpression + " === 'string'" +
      "? " + baseValueExpression + ".trim()" +
      ": " + baseValueExpression + ")";
  }
  if (number) {
    valueExpression = "_n(" + valueExpression + ")";
  }
  var assignment = genAssignmentCode(value, valueExpression);

  el.model = {
    value: ("(" + value + ")"),
    expression: JSON.stringify(value),
    callback: ("function (" + baseValueExpression + ") {" + assignment + "}")
  };
}

/**
 * Cross-platform codegen helper for generating v-model value assignment code.
 */
function genAssignmentCode (
  value,
  assignment
) {
  var res = parseModel(value);
  if (res.key === null) {
    return (value + "=" + assignment)
  } else {
    return ("$set(" + (res.exp) + ", " + (res.key) + ", " + assignment + ")")
  }
}

/**
 * Parse a v-model expression into a base path and a final key segment.
 * Handles both dot-path and possible square brackets.
 *
 * Possible cases:
 *
 * - test
 * - test[key]
 * - test[test1[key]]
 * - test["a"][key]
 * - xxx.test[a[a].test1[key]]
 * - test.xxx.a["asa"][test1[key]]
 *
 */

var len, str, chr, index$1, expressionPos, expressionEndPos;



function parseModel (val) {
  // Fix https://github.com/vuejs/vue/pull/7730
  // allow v-model="obj.val " (trailing whitespace)
  val = val.trim();
  len = val.length;

  if (val.indexOf('[') < 0 || val.lastIndexOf(']') < len - 1) {
    index$1 = val.lastIndexOf('.');
    if (index$1 > -1) {
      return {
        exp: val.slice(0, index$1),
        key: '"' + val.slice(index$1 + 1) + '"'
      }
    } else {
      return {
        exp: val,
        key: null
      }
    }
  }

  str = val;
  index$1 = expressionPos = expressionEndPos = 0;

  while (!eof()) {
    chr = next();
    /* istanbul ignore if */
    if (isStringStart(chr)) {
      parseString(chr);
    } else if (chr === 0x5B) {
      parseBracket(chr);
    }
  }

  return {
    exp: val.slice(0, expressionPos),
    key: val.slice(expressionPos + 1, expressionEndPos)
  }
}

function next () {
  return str.charCodeAt(++index$1)
}

function eof () {
  return index$1 >= len
}

function isStringStart (chr) {
  return chr === 0x22 || chr === 0x27
}

function parseBracket (chr) {
  var inBracket = 1;
  expressionPos = index$1;
  while (!eof()) {
    chr = next();
    if (isStringStart(chr)) {
      parseString(chr);
      continue
    }
    if (chr === 0x5B) { inBracket++; }
    if (chr === 0x5D) { inBracket--; }
    if (inBracket === 0) {
      expressionEndPos = index$1;
      break
    }
  }
}

function parseString (chr) {
  var stringQuote = chr;
  while (!eof()) {
    chr = next();
    if (chr === stringQuote) {
      break
    }
  }
}

/*  */

var warn$1;

// in some cases, the event used has to be determined at runtime
// so we used some reserved tokens during compile.
var RANGE_TOKEN = '__r';
var CHECKBOX_RADIO_TOKEN = '__c';

function model (
  el,
  dir,
  _warn
) {
  warn$1 = _warn;
  var value = dir.value;
  var modifiers = dir.modifiers;
  var tag = el.tag;
  var type = el.attrsMap.type;

  {
    // inputs with type="file" are read only and setting the input's
    // value will throw an error.
    if (tag === 'input' && type === 'file') {
      warn$1(
        "<" + (el.tag) + " v-model=\"" + value + "\" type=\"file\">:\n" +
        "File inputs are read only. Use a v-on:change listener instead.",
        el.rawAttrsMap['v-model']
      );
    }
  }

  if (el.component) {
    genComponentModel(el, value, modifiers);
    // component v-model doesn't need extra runtime
    return false
  } else if (tag === 'select') {
    genSelect(el, value, modifiers);
  } else if (tag === 'input' && type === 'checkbox') {
    genCheckboxModel(el, value, modifiers);
  } else if (tag === 'input' && type === 'radio') {
    genRadioModel(el, value, modifiers);
  } else if (tag === 'input' || tag === 'textarea') {
    genDefaultModel(el, value, modifiers);
  } else if (!config.isReservedTag(tag)) {
    genComponentModel(el, value, modifiers);
    // component v-model doesn't need extra runtime
    return false
  } else {
    warn$1(
      "<" + (el.tag) + " v-model=\"" + value + "\">: " +
      "v-model is not supported on this element type. " +
      'If you are working with contenteditable, it\'s recommended to ' +
      'wrap a library dedicated for that purpose inside a custom component.',
      el.rawAttrsMap['v-model']
    );
  }

  // ensure runtime directive metadata
  return true
}

function genCheckboxModel (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var valueBinding = getBindingAttr(el, 'value') || 'null';
  var trueValueBinding = getBindingAttr(el, 'true-value') || 'true';
  var falseValueBinding = getBindingAttr(el, 'false-value') || 'false';
  addProp(el, 'checked',
    "Array.isArray(" + value + ")" +
    "?_i(" + value + "," + valueBinding + ")>-1" + (
      trueValueBinding === 'true'
        ? (":(" + value + ")")
        : (":_q(" + value + "," + trueValueBinding + ")")
    )
  );
  addHandler(el, 'change',
    "var $$a=" + value + "," +
        '$$el=$event.target,' +
        "$$c=$$el.checked?(" + trueValueBinding + "):(" + falseValueBinding + ");" +
    'if(Array.isArray($$a)){' +
      "var $$v=" + (number ? '_n(' + valueBinding + ')' : valueBinding) + "," +
          '$$i=_i($$a,$$v);' +
      "if($$el.checked){$$i<0&&(" + (genAssignmentCode(value, '$$a.concat([$$v])')) + ")}" +
      "else{$$i>-1&&(" + (genAssignmentCode(value, '$$a.slice(0,$$i).concat($$a.slice($$i+1))')) + ")}" +
    "}else{" + (genAssignmentCode(value, '$$c')) + "}",
    null, true
  );
}

function genRadioModel (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var valueBinding = getBindingAttr(el, 'value') || 'null';
  valueBinding = number ? ("_n(" + valueBinding + ")") : valueBinding;
  addProp(el, 'checked', ("_q(" + value + "," + valueBinding + ")"));
  addHandler(el, 'change', genAssignmentCode(value, valueBinding), null, true);
}

function genSelect (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var selectedVal = "Array.prototype.filter" +
    ".call($event.target.options,function(o){return o.selected})" +
    ".map(function(o){var val = \"_value\" in o ? o._value : o.value;" +
    "return " + (number ? '_n(val)' : 'val') + "})";

  var assignment = '$event.target.multiple ? $$selectedVal : $$selectedVal[0]';
  var code = "var $$selectedVal = " + selectedVal + ";";
  code = code + " " + (genAssignmentCode(value, assignment));
  addHandler(el, 'change', code, null, true);
}

function genDefaultModel (
  el,
  value,
  modifiers
) {
  var type = el.attrsMap.type;

  // warn if v-bind:value conflicts with v-model
  // except for inputs with v-bind:type
  {
    var value$1 = el.attrsMap['v-bind:value'] || el.attrsMap[':value'];
    var typeBinding = el.attrsMap['v-bind:type'] || el.attrsMap[':type'];
    if (value$1 && !typeBinding) {
      var binding = el.attrsMap['v-bind:value'] ? 'v-bind:value' : ':value';
      warn$1(
        binding + "=\"" + value$1 + "\" conflicts with v-model on the same element " +
        'because the latter already expands to a value binding internally',
        el.rawAttrsMap[binding]
      );
    }
  }

  var ref = modifiers || {};
  var lazy = ref.lazy;
  var number = ref.number;
  var trim = ref.trim;
  var needCompositionGuard = !lazy && type !== 'range';
  var event = lazy
    ? 'change'
    : type === 'range'
      ? RANGE_TOKEN
      : 'input';

  var valueExpression = '$event.target.value';
  if (trim) {
    valueExpression = "$event.target.value.trim()";
  }
  if (number) {
    valueExpression = "_n(" + valueExpression + ")";
  }

  var code = genAssignmentCode(value, valueExpression);
  if (needCompositionGuard) {
    code = "if($event.target.composing)return;" + code;
  }

  addProp(el, 'value', ("(" + value + ")"));
  addHandler(el, event, code, null, true);
  if (trim || number) {
    addHandler(el, 'blur', '$forceUpdate()');
  }
}

/*  */

// normalize v-model event tokens that can only be determined at runtime.
// it's important to place the event as the first in the array because
// the whole point is ensuring the v-model callback gets called before
// user-attached handlers.
function normalizeEvents (on) {
  /* istanbul ignore if */
  if (isDef(on[RANGE_TOKEN])) {
    // IE input[type=range] only supports `change` event
    var event = isIE ? 'change' : 'input';
    on[event] = [].concat(on[RANGE_TOKEN], on[event] || []);
    delete on[RANGE_TOKEN];
  }
  // This was originally intended to fix #4521 but no longer necessary
  // after 2.5. Keeping it for backwards compat with generated code from < 2.4
  /* istanbul ignore if */
  if (isDef(on[CHECKBOX_RADIO_TOKEN])) {
    on.change = [].concat(on[CHECKBOX_RADIO_TOKEN], on.change || []);
    delete on[CHECKBOX_RADIO_TOKEN];
  }
}

var target$1;

function createOnceHandler$1 (event, handler, capture) {
  var _target = target$1; // save current target element in closure
  return function onceHandler () {
    var res = handler.apply(null, arguments);
    if (res !== null) {
      remove$2(event, onceHandler, capture, _target);
    }
  }
}

// #9446: Firefox <= 53 (in particular, ESR 52) has incorrect Event.timeStamp
// implementation and does not fire microtasks in between event propagation, so
// safe to exclude.
var useMicrotaskFix = isUsingMicroTask && !(isFF && Number(isFF[1]) <= 53);

function add$1 (
  name,
  handler,
  capture,
  passive
) {
  // async edge case #6566: inner click event triggers patch, event handler
  // attached to outer element during patch, and triggered again. This
  // happens because browsers fire microtask ticks between event propagation.
  // the solution is simple: we save the timestamp when a handler is attached,
  // and the handler would only fire if the event passed to it was fired
  // AFTER it was attached.
  if (useMicrotaskFix) {
    var attachedTimestamp = currentFlushTimestamp;
    var original = handler;
    handler = original._wrapper = function (e) {
      if (
        // no bubbling, should always fire.
        // this is just a safety net in case event.timeStamp is unreliable in
        // certain weird environments...
        e.target === e.currentTarget ||
        // event is fired after handler attachment
        e.timeStamp >= attachedTimestamp ||
        // bail for environments that have buggy event.timeStamp implementations
        // #9462 iOS 9 bug: event.timeStamp is 0 after history.pushState
        // #9681 QtWebEngine event.timeStamp is negative value
        e.timeStamp <= 0 ||
        // #9448 bail if event is fired in another document in a multi-page
        // electron/nw.js app, since event.timeStamp will be using a different
        // starting reference
        e.target.ownerDocument !== document
      ) {
        return original.apply(this, arguments)
      }
    };
  }
  target$1.addEventListener(
    name,
    handler,
    supportsPassive
      ? { capture: capture, passive: passive }
      : capture
  );
}

function remove$2 (
  name,
  handler,
  capture,
  _target
) {
  (_target || target$1).removeEventListener(
    name,
    handler._wrapper || handler,
    capture
  );
}

function updateDOMListeners (oldVnode, vnode) {
  if (isUndef(oldVnode.data.on) && isUndef(vnode.data.on)) {
    return
  }
  var on = vnode.data.on || {};
  var oldOn = oldVnode.data.on || {};
  target$1 = vnode.elm;
  normalizeEvents(on);
  updateListeners(on, oldOn, add$1, remove$2, createOnceHandler$1, vnode.context);
  target$1 = undefined;
}

var events = {
  create: updateDOMListeners,
  update: updateDOMListeners
};

/*  */

var svgContainer;

function updateDOMProps (oldVnode, vnode) {
  if (isUndef(oldVnode.data.domProps) && isUndef(vnode.data.domProps)) {
    return
  }
  var key, cur;
  var elm = vnode.elm;
  var oldProps = oldVnode.data.domProps || {};
  var props = vnode.data.domProps || {};
  // clone observed objects, as the user probably wants to mutate it
  if (isDef(props.__ob__)) {
    props = vnode.data.domProps = extend({}, props);
  }

  for (key in oldProps) {
    if (!(key in props)) {
      elm[key] = '';
    }
  }

  for (key in props) {
    cur = props[key];
    // ignore children if the node has textContent or innerHTML,
    // as these will throw away existing DOM nodes and cause removal errors
    // on subsequent patches (#3360)
    if (key === 'textContent' || key === 'innerHTML') {
      if (vnode.children) { vnode.children.length = 0; }
      if (cur === oldProps[key]) { continue }
      // #6601 work around Chrome version <= 55 bug where single textNode
      // replaced by innerHTML/textContent retains its parentNode property
      if (elm.childNodes.length === 1) {
        elm.removeChild(elm.childNodes[0]);
      }
    }

    if (key === 'value' && elm.tagName !== 'PROGRESS') {
      // store value as _value as well since
      // non-string values will be stringified
      elm._value = cur;
      // avoid resetting cursor position when value is the same
      var strCur = isUndef(cur) ? '' : String(cur);
      if (shouldUpdateValue(elm, strCur)) {
        elm.value = strCur;
      }
    } else if (key === 'innerHTML' && isSVG(elm.tagName) && isUndef(elm.innerHTML)) {
      // IE doesn't support innerHTML for SVG elements
      svgContainer = svgContainer || document.createElement('div');
      svgContainer.innerHTML = "<svg>" + cur + "</svg>";
      var svg = svgContainer.firstChild;
      while (elm.firstChild) {
        elm.removeChild(elm.firstChild);
      }
      while (svg.firstChild) {
        elm.appendChild(svg.firstChild);
      }
    } else if (
      // skip the update if old and new VDOM state is the same.
      // `value` is handled separately because the DOM value may be temporarily
      // out of sync with VDOM state due to focus, composition and modifiers.
      // This  #4521 by skipping the unnecesarry `checked` update.
      cur !== oldProps[key]
    ) {
      // some property updates can throw
      // e.g. `value` on <progress> w/ non-finite value
      try {
        elm[key] = cur;
      } catch (e) {}
    }
  }
}

// check platforms/web/util/attrs.js acceptValue


function shouldUpdateValue (elm, checkVal) {
  return (!elm.composing && (
    elm.tagName === 'OPTION' ||
    isNotInFocusAndDirty(elm, checkVal) ||
    isDirtyWithModifiers(elm, checkVal)
  ))
}

function isNotInFocusAndDirty (elm, checkVal) {
  // return true when textbox (.number and .trim) loses focus and its value is
  // not equal to the updated value
  var notInFocus = true;
  // #6157
  // work around IE bug when accessing document.activeElement in an iframe
  try { notInFocus = document.activeElement !== elm; } catch (e) {}
  return notInFocus && elm.value !== checkVal
}

function isDirtyWithModifiers (elm, newVal) {
  var value = elm.value;
  var modifiers = elm._vModifiers; // injected by v-model runtime
  if (isDef(modifiers)) {
    if (modifiers.number) {
      return toNumber(value) !== toNumber(newVal)
    }
    if (modifiers.trim) {
      return value.trim() !== newVal.trim()
    }
  }
  return value !== newVal
}

var domProps = {
  create: updateDOMProps,
  update: updateDOMProps
};

/*  */

var parseStyleText = cached(function (cssText) {
  var res = {};
  var listDelimiter = /;(?![^(]*\))/g;
  var propertyDelimiter = /:(.+)/;
  cssText.split(listDelimiter).forEach(function (item) {
    if (item) {
      var tmp = item.split(propertyDelimiter);
      tmp.length > 1 && (res[tmp[0].trim()] = tmp[1].trim());
    }
  });
  return res
});

// merge static and dynamic style data on the same vnode
function normalizeStyleData (data) {
  var style = normalizeStyleBinding(data.style);
  // static style is pre-processed into an object during compilation
  // and is always a fresh object, so it's safe to merge into it
  return data.staticStyle
    ? extend(data.staticStyle, style)
    : style
}

// normalize possible array / string values into Object
function normalizeStyleBinding (bindingStyle) {
  if (Array.isArray(bindingStyle)) {
    return toObject(bindingStyle)
  }
  if (typeof bindingStyle === 'string') {
    return parseStyleText(bindingStyle)
  }
  return bindingStyle
}

/**
 * parent component style should be after child's
 * so that parent component's style could override it
 */
function getStyle (vnode, checkChild) {
  var res = {};
  var styleData;

  if (checkChild) {
    var childNode = vnode;
    while (childNode.componentInstance) {
      childNode = childNode.componentInstance._vnode;
      if (
        childNode && childNode.data &&
        (styleData = normalizeStyleData(childNode.data))
      ) {
        extend(res, styleData);
      }
    }
  }

  if ((styleData = normalizeStyleData(vnode.data))) {
    extend(res, styleData);
  }

  var parentNode = vnode;
  while ((parentNode = parentNode.parent)) {
    if (parentNode.data && (styleData = normalizeStyleData(parentNode.data))) {
      extend(res, styleData);
    }
  }
  return res
}

/*  */

var cssVarRE = /^--/;
var importantRE = /\s*!important$/;
var setProp = function (el, name, val) {
  /* istanbul ignore if */
  if (cssVarRE.test(name)) {
    el.style.setProperty(name, val);
  } else if (importantRE.test(val)) {
    el.style.setProperty(hyphenate(name), val.replace(importantRE, ''), 'important');
  } else {
    var normalizedName = normalize(name);
    if (Array.isArray(val)) {
      // Support values array created by autoprefixer, e.g.
      // {display: ["-webkit-box", "-ms-flexbox", "flex"]}
      // Set them one by one, and the browser will only set those it can recognize
      for (var i = 0, len = val.length; i < len; i++) {
        el.style[normalizedName] = val[i];
      }
    } else {
      el.style[normalizedName] = val;
    }
  }
};

var vendorNames = ['Webkit', 'Moz', 'ms'];

var emptyStyle;
var normalize = cached(function (prop) {
  emptyStyle = emptyStyle || document.createElement('div').style;
  prop = camelize(prop);
  if (prop !== 'filter' && (prop in emptyStyle)) {
    return prop
  }
  var capName = prop.charAt(0).toUpperCase() + prop.slice(1);
  for (var i = 0; i < vendorNames.length; i++) {
    var name = vendorNames[i] + capName;
    if (name in emptyStyle) {
      return name
    }
  }
});

function updateStyle (oldVnode, vnode) {
  var data = vnode.data;
  var oldData = oldVnode.data;

  if (isUndef(data.staticStyle) && isUndef(data.style) &&
    isUndef(oldData.staticStyle) && isUndef(oldData.style)
  ) {
    return
  }

  var cur, name;
  var el = vnode.elm;
  var oldStaticStyle = oldData.staticStyle;
  var oldStyleBinding = oldData.normalizedStyle || oldData.style || {};

  // if static style exists, stylebinding already merged into it when doing normalizeStyleData
  var oldStyle = oldStaticStyle || oldStyleBinding;

  var style = normalizeStyleBinding(vnode.data.style) || {};

  // store normalized style under a different key for next diff
  // make sure to clone it if it's reactive, since the user likely wants
  // to mutate it.
  vnode.data.normalizedStyle = isDef(style.__ob__)
    ? extend({}, style)
    : style;

  var newStyle = getStyle(vnode, true);

  for (name in oldStyle) {
    if (isUndef(newStyle[name])) {
      setProp(el, name, '');
    }
  }
  for (name in newStyle) {
    cur = newStyle[name];
    if (cur !== oldStyle[name]) {
      // ie9 setting to null has no effect, must use empty string
      setProp(el, name, cur == null ? '' : cur);
    }
  }
}

var style = {
  create: updateStyle,
  update: updateStyle
};

/*  */

var whitespaceRE = /\s+/;

/**
 * Add class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function addClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !(cls = cls.trim())) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(whitespaceRE).forEach(function (c) { return el.classList.add(c); });
    } else {
      el.classList.add(cls);
    }
  } else {
    var cur = " " + (el.getAttribute('class') || '') + " ";
    if (cur.indexOf(' ' + cls + ' ') < 0) {
      el.setAttribute('class', (cur + cls).trim());
    }
  }
}

/**
 * Remove class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function removeClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !(cls = cls.trim())) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(whitespaceRE).forEach(function (c) { return el.classList.remove(c); });
    } else {
      el.classList.remove(cls);
    }
    if (!el.classList.length) {
      el.removeAttribute('class');
    }
  } else {
    var cur = " " + (el.getAttribute('class') || '') + " ";
    var tar = ' ' + cls + ' ';
    while (cur.indexOf(tar) >= 0) {
      cur = cur.replace(tar, ' ');
    }
    cur = cur.trim();
    if (cur) {
      el.setAttribute('class', cur);
    } else {
      el.removeAttribute('class');
    }
  }
}

/*  */

function resolveTransition (def$$1) {
  if (!def$$1) {
    return
  }
  /* istanbul ignore else */
  if (typeof def$$1 === 'object') {
    var res = {};
    if (def$$1.css !== false) {
      extend(res, autoCssTransition(def$$1.name || 'v'));
    }
    extend(res, def$$1);
    return res
  } else if (typeof def$$1 === 'string') {
    return autoCssTransition(def$$1)
  }
}

var autoCssTransition = cached(function (name) {
  return {
    enterClass: (name + "-enter"),
    enterToClass: (name + "-enter-to"),
    enterActiveClass: (name + "-enter-active"),
    leaveClass: (name + "-leave"),
    leaveToClass: (name + "-leave-to"),
    leaveActiveClass: (name + "-leave-active")
  }
});

var hasTransition = inBrowser && !isIE9;
var TRANSITION = 'transition';
var ANIMATION = 'animation';

// Transition property/event sniffing
var transitionProp = 'transition';
var transitionEndEvent = 'transitionend';
var animationProp = 'animation';
var animationEndEvent = 'animationend';
if (hasTransition) {
  /* istanbul ignore if */
  if (window.ontransitionend === undefined &&
    window.onwebkittransitionend !== undefined
  ) {
    transitionProp = 'WebkitTransition';
    transitionEndEvent = 'webkitTransitionEnd';
  }
  if (window.onanimationend === undefined &&
    window.onwebkitanimationend !== undefined
  ) {
    animationProp = 'WebkitAnimation';
    animationEndEvent = 'webkitAnimationEnd';
  }
}

// binding to window is necessary to make hot reload work in IE in strict mode
var raf = inBrowser
  ? window.requestAnimationFrame
    ? window.requestAnimationFrame.bind(window)
    : setTimeout
  : /* istanbul ignore next */ function (fn) { return fn(); };

function nextFrame (fn) {
  raf(function () {
    raf(fn);
  });
}

function addTransitionClass (el, cls) {
  var transitionClasses = el._transitionClasses || (el._transitionClasses = []);
  if (transitionClasses.indexOf(cls) < 0) {
    transitionClasses.push(cls);
    addClass(el, cls);
  }
}

function removeTransitionClass (el, cls) {
  if (el._transitionClasses) {
    remove(el._transitionClasses, cls);
  }
  removeClass(el, cls);
}

function whenTransitionEnds (
  el,
  expectedType,
  cb
) {
  var ref = getTransitionInfo(el, expectedType);
  var type = ref.type;
  var timeout = ref.timeout;
  var propCount = ref.propCount;
  if (!type) { return cb() }
  var event = type === TRANSITION ? transitionEndEvent : animationEndEvent;
  var ended = 0;
  var end = function () {
    el.removeEventListener(event, onEnd);
    cb();
  };
  var onEnd = function (e) {
    if (e.target === el) {
      if (++ended >= propCount) {
        end();
      }
    }
  };
  setTimeout(function () {
    if (ended < propCount) {
      end();
    }
  }, timeout + 1);
  el.addEventListener(event, onEnd);
}

var transformRE = /\b(transform|all)(,|$)/;

function getTransitionInfo (el, expectedType) {
  var styles = window.getComputedStyle(el);
  // JSDOM may return undefined for transition properties
  var transitionDelays = (styles[transitionProp + 'Delay'] || '').split(', ');
  var transitionDurations = (styles[transitionProp + 'Duration'] || '').split(', ');
  var transitionTimeout = getTimeout(transitionDelays, transitionDurations);
  var animationDelays = (styles[animationProp + 'Delay'] || '').split(', ');
  var animationDurations = (styles[animationProp + 'Duration'] || '').split(', ');
  var animationTimeout = getTimeout(animationDelays, animationDurations);

  var type;
  var timeout = 0;
  var propCount = 0;
  /* istanbul ignore if */
  if (expectedType === TRANSITION) {
    if (transitionTimeout > 0) {
      type = TRANSITION;
      timeout = transitionTimeout;
      propCount = transitionDurations.length;
    }
  } else if (expectedType === ANIMATION) {
    if (animationTimeout > 0) {
      type = ANIMATION;
      timeout = animationTimeout;
      propCount = animationDurations.length;
    }
  } else {
    timeout = Math.max(transitionTimeout, animationTimeout);
    type = timeout > 0
      ? transitionTimeout > animationTimeout
        ? TRANSITION
        : ANIMATION
      : null;
    propCount = type
      ? type === TRANSITION
        ? transitionDurations.length
        : animationDurations.length
      : 0;
  }
  var hasTransform =
    type === TRANSITION &&
    transformRE.test(styles[transitionProp + 'Property']);
  return {
    type: type,
    timeout: timeout,
    propCount: propCount,
    hasTransform: hasTransform
  }
}

function getTimeout (delays, durations) {
  /* istanbul ignore next */
  while (delays.length < durations.length) {
    delays = delays.concat(delays);
  }

  return Math.max.apply(null, durations.map(function (d, i) {
    return toMs(d) + toMs(delays[i])
  }))
}

// Old versions of Chromium (below 61.0.3163.100) formats floating pointer numbers
// in a locale-dependent way, using a comma instead of a dot.
// If comma is not replaced with a dot, the input will be rounded down (i.e. acting
// as a floor function) causing unexpected behaviors
function toMs (s) {
  return Number(s.slice(0, -1).replace(',', '.')) * 1000
}

/*  */

function enter (vnode, toggleDisplay) {
  var el = vnode.elm;

  // call leave callback now
  if (isDef(el._leaveCb)) {
    el._leaveCb.cancelled = true;
    el._leaveCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (isUndef(data)) {
    return
  }

  /* istanbul ignore if */
  if (isDef(el._enterCb) || el.nodeType !== 1) {
    return
  }

  var css = data.css;
  var type = data.type;
  var enterClass = data.enterClass;
  var enterToClass = data.enterToClass;
  var enterActiveClass = data.enterActiveClass;
  var appearClass = data.appearClass;
  var appearToClass = data.appearToClass;
  var appearActiveClass = data.appearActiveClass;
  var beforeEnter = data.beforeEnter;
  var enter = data.enter;
  var afterEnter = data.afterEnter;
  var enterCancelled = data.enterCancelled;
  var beforeAppear = data.beforeAppear;
  var appear = data.appear;
  var afterAppear = data.afterAppear;
  var appearCancelled = data.appearCancelled;
  var duration = data.duration;

  // activeInstance will always be the <transition> component managing this
  // transition. One edge case to check is when the <transition> is placed
  // as the root node of a child component. In that case we need to check
  // <transition>'s parent for appear check.
  var context = activeInstance;
  var transitionNode = activeInstance.$vnode;
  while (transitionNode && transitionNode.parent) {
    context = transitionNode.context;
    transitionNode = transitionNode.parent;
  }

  var isAppear = !context._isMounted || !vnode.isRootInsert;

  if (isAppear && !appear && appear !== '') {
    return
  }

  var startClass = isAppear && appearClass
    ? appearClass
    : enterClass;
  var activeClass = isAppear && appearActiveClass
    ? appearActiveClass
    : enterActiveClass;
  var toClass = isAppear && appearToClass
    ? appearToClass
    : enterToClass;

  var beforeEnterHook = isAppear
    ? (beforeAppear || beforeEnter)
    : beforeEnter;
  var enterHook = isAppear
    ? (typeof appear === 'function' ? appear : enter)
    : enter;
  var afterEnterHook = isAppear
    ? (afterAppear || afterEnter)
    : afterEnter;
  var enterCancelledHook = isAppear
    ? (appearCancelled || enterCancelled)
    : enterCancelled;

  var explicitEnterDuration = toNumber(
    isObject(duration)
      ? duration.enter
      : duration
  );

  if (explicitEnterDuration != null) {
    checkDuration(explicitEnterDuration, 'enter', vnode);
  }

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl = getHookArgumentsLength(enterHook);

  var cb = el._enterCb = once(function () {
    if (expectsCSS) {
      removeTransitionClass(el, toClass);
      removeTransitionClass(el, activeClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, startClass);
      }
      enterCancelledHook && enterCancelledHook(el);
    } else {
      afterEnterHook && afterEnterHook(el);
    }
    el._enterCb = null;
  });

  if (!vnode.data.show) {
    // remove pending leave element on enter by injecting an insert hook
    mergeVNodeHook(vnode, 'insert', function () {
      var parent = el.parentNode;
      var pendingNode = parent && parent._pending && parent._pending[vnode.key];
      if (pendingNode &&
        pendingNode.tag === vnode.tag &&
        pendingNode.elm._leaveCb
      ) {
        pendingNode.elm._leaveCb();
      }
      enterHook && enterHook(el, cb);
    });
  }

  // start enter transition
  beforeEnterHook && beforeEnterHook(el);
  if (expectsCSS) {
    addTransitionClass(el, startClass);
    addTransitionClass(el, activeClass);
    nextFrame(function () {
      removeTransitionClass(el, startClass);
      if (!cb.cancelled) {
        addTransitionClass(el, toClass);
        if (!userWantsControl) {
          if (isValidDuration(explicitEnterDuration)) {
            setTimeout(cb, explicitEnterDuration);
          } else {
            whenTransitionEnds(el, type, cb);
          }
        }
      }
    });
  }

  if (vnode.data.show) {
    toggleDisplay && toggleDisplay();
    enterHook && enterHook(el, cb);
  }

  if (!expectsCSS && !userWantsControl) {
    cb();
  }
}

function leave (vnode, rm) {
  var el = vnode.elm;

  // call enter callback now
  if (isDef(el._enterCb)) {
    el._enterCb.cancelled = true;
    el._enterCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (isUndef(data) || el.nodeType !== 1) {
    return rm()
  }

  /* istanbul ignore if */
  if (isDef(el._leaveCb)) {
    return
  }

  var css = data.css;
  var type = data.type;
  var leaveClass = data.leaveClass;
  var leaveToClass = data.leaveToClass;
  var leaveActiveClass = data.leaveActiveClass;
  var beforeLeave = data.beforeLeave;
  var leave = data.leave;
  var afterLeave = data.afterLeave;
  var leaveCancelled = data.leaveCancelled;
  var delayLeave = data.delayLeave;
  var duration = data.duration;

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl = getHookArgumentsLength(leave);

  var explicitLeaveDuration = toNumber(
    isObject(duration)
      ? duration.leave
      : duration
  );

  if (isDef(explicitLeaveDuration)) {
    checkDuration(explicitLeaveDuration, 'leave', vnode);
  }

  var cb = el._leaveCb = once(function () {
    if (el.parentNode && el.parentNode._pending) {
      el.parentNode._pending[vnode.key] = null;
    }
    if (expectsCSS) {
      removeTransitionClass(el, leaveToClass);
      removeTransitionClass(el, leaveActiveClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, leaveClass);
      }
      leaveCancelled && leaveCancelled(el);
    } else {
      rm();
      afterLeave && afterLeave(el);
    }
    el._leaveCb = null;
  });

  if (delayLeave) {
    delayLeave(performLeave);
  } else {
    performLeave();
  }

  function performLeave () {
    // the delayed leave may have already been cancelled
    if (cb.cancelled) {
      return
    }
    // record leaving element
    if (!vnode.data.show && el.parentNode) {
      (el.parentNode._pending || (el.parentNode._pending = {}))[(vnode.key)] = vnode;
    }
    beforeLeave && beforeLeave(el);
    if (expectsCSS) {
      addTransitionClass(el, leaveClass);
      addTransitionClass(el, leaveActiveClass);
      nextFrame(function () {
        removeTransitionClass(el, leaveClass);
        if (!cb.cancelled) {
          addTransitionClass(el, leaveToClass);
          if (!userWantsControl) {
            if (isValidDuration(explicitLeaveDuration)) {
              setTimeout(cb, explicitLeaveDuration);
            } else {
              whenTransitionEnds(el, type, cb);
            }
          }
        }
      });
    }
    leave && leave(el, cb);
    if (!expectsCSS && !userWantsControl) {
      cb();
    }
  }
}

// only used in dev mode
function checkDuration (val, name, vnode) {
  if (typeof val !== 'number') {
    warn(
      "<transition> explicit " + name + " duration is not a valid number - " +
      "got " + (JSON.stringify(val)) + ".",
      vnode.context
    );
  } else if (isNaN(val)) {
    warn(
      "<transition> explicit " + name + " duration is NaN - " +
      'the duration expression might be incorrect.',
      vnode.context
    );
  }
}

function isValidDuration (val) {
  return typeof val === 'number' && !isNaN(val)
}

/**
 * Normalize a transition hook's argument length. The hook may be:
 * - a merged hook (invoker) with the original in .fns
 * - a wrapped component method (check ._length)
 * - a plain function (.length)
 */
function getHookArgumentsLength (fn) {
  if (isUndef(fn)) {
    return false
  }
  var invokerFns = fn.fns;
  if (isDef(invokerFns)) {
    // invoker
    return getHookArgumentsLength(
      Array.isArray(invokerFns)
        ? invokerFns[0]
        : invokerFns
    )
  } else {
    return (fn._length || fn.length) > 1
  }
}

function _enter (_, vnode) {
  if (vnode.data.show !== true) {
    enter(vnode);
  }
}

var transition = inBrowser ? {
  create: _enter,
  activate: _enter,
  remove: function remove$$1 (vnode, rm) {
    /* istanbul ignore else */
    if (vnode.data.show !== true) {
      leave(vnode, rm);
    } else {
      rm();
    }
  }
} : {};

var platformModules = [
  attrs,
  klass,
  events,
  domProps,
  style,
  transition
];

/*  */

// the directive module should be applied last, after all
// built-in modules have been applied.
var modules = platformModules.concat(baseModules);

var patch = createPatchFunction({ nodeOps: nodeOps, modules: modules });

/**
 * Not type checking this file because flow doesn't like attaching
 * properties to Elements.
 */

/* istanbul ignore if */
if (isIE9) {
  // http://www.matts411.com/post/internet-explorer-9-oninput/
  document.addEventListener('selectionchange', function () {
    var el = document.activeElement;
    if (el && el.vmodel) {
      trigger(el, 'input');
    }
  });
}

var directive = {
  inserted: function inserted (el, binding, vnode, oldVnode) {
    if (vnode.tag === 'select') {
      // #6903
      if (oldVnode.elm && !oldVnode.elm._vOptions) {
        mergeVNodeHook(vnode, 'postpatch', function () {
          directive.componentUpdated(el, binding, vnode);
        });
      } else {
        setSelected(el, binding, vnode.context);
      }
      el._vOptions = [].map.call(el.options, getValue);
    } else if (vnode.tag === 'textarea' || isTextInputType(el.type)) {
      el._vModifiers = binding.modifiers;
      if (!binding.modifiers.lazy) {
        el.addEventListener('compositionstart', onCompositionStart);
        el.addEventListener('compositionend', onCompositionEnd);
        // Safari < 10.2 & UIWebView doesn't fire compositionend when
        // switching focus before confirming composition choice
        // this also fixes the issue where some browsers e.g. iOS Chrome
        // fires "change" instead of "input" on autocomplete.
        el.addEventListener('change', onCompositionEnd);
        /* istanbul ignore if */
        if (isIE9) {
          el.vmodel = true;
        }
      }
    }
  },

  componentUpdated: function componentUpdated (el, binding, vnode) {
    if (vnode.tag === 'select') {
      setSelected(el, binding, vnode.context);
      // in case the options rendered by v-for have changed,
      // it's possible that the value is out-of-sync with the rendered options.
      // detect such cases and filter out values that no longer has a matching
      // option in the DOM.
      var prevOptions = el._vOptions;
      var curOptions = el._vOptions = [].map.call(el.options, getValue);
      if (curOptions.some(function (o, i) { return !looseEqual(o, prevOptions[i]); })) {
        // trigger change event if
        // no matching option found for at least one value
        var needReset = el.multiple
          ? binding.value.some(function (v) { return hasNoMatchingOption(v, curOptions); })
          : binding.value !== binding.oldValue && hasNoMatchingOption(binding.value, curOptions);
        if (needReset) {
          trigger(el, 'change');
        }
      }
    }
  }
};

function setSelected (el, binding, vm) {
  actuallySetSelected(el, binding, vm);
  /* istanbul ignore if */
  if (isIE || isEdge) {
    setTimeout(function () {
      actuallySetSelected(el, binding, vm);
    }, 0);
  }
}

function actuallySetSelected (el, binding, vm) {
  var value = binding.value;
  var isMultiple = el.multiple;
  if (isMultiple && !Array.isArray(value)) {
    warn(
      "<select multiple v-model=\"" + (binding.expression) + "\"> " +
      "expects an Array value for its binding, but got " + (Object.prototype.toString.call(value).slice(8, -1)),
      vm
    );
    return
  }
  var selected, option;
  for (var i = 0, l = el.options.length; i < l; i++) {
    option = el.options[i];
    if (isMultiple) {
      selected = looseIndexOf(value, getValue(option)) > -1;
      if (option.selected !== selected) {
        option.selected = selected;
      }
    } else {
      if (looseEqual(getValue(option), value)) {
        if (el.selectedIndex !== i) {
          el.selectedIndex = i;
        }
        return
      }
    }
  }
  if (!isMultiple) {
    el.selectedIndex = -1;
  }
}

function hasNoMatchingOption (value, options) {
  return options.every(function (o) { return !looseEqual(o, value); })
}

function getValue (option) {
  return '_value' in option
    ? option._value
    : option.value
}

function onCompositionStart (e) {
  e.target.composing = true;
}

function onCompositionEnd (e) {
  // prevent triggering an input event for no reason
  if (!e.target.composing) { return }
  e.target.composing = false;
  trigger(e.target, 'input');
}

function trigger (el, type) {
  var e = document.createEvent('HTMLEvents');
  e.initEvent(type, true, true);
  el.dispatchEvent(e);
}

/*  */

// recursively search for possible transition defined inside the component root
function locateNode (vnode) {
  return vnode.componentInstance && (!vnode.data || !vnode.data.transition)
    ? locateNode(vnode.componentInstance._vnode)
    : vnode
}

var show = {
  bind: function bind (el, ref, vnode) {
    var value = ref.value;

    vnode = locateNode(vnode);
    var transition$$1 = vnode.data && vnode.data.transition;
    var originalDisplay = el.__vOriginalDisplay =
      el.style.display === 'none' ? '' : el.style.display;
    if (value && transition$$1) {
      vnode.data.show = true;
      enter(vnode, function () {
        el.style.display = originalDisplay;
      });
    } else {
      el.style.display = value ? originalDisplay : 'none';
    }
  },

  update: function update (el, ref, vnode) {
    var value = ref.value;
    var oldValue = ref.oldValue;

    /* istanbul ignore if */
    if (!value === !oldValue) { return }
    vnode = locateNode(vnode);
    var transition$$1 = vnode.data && vnode.data.transition;
    if (transition$$1) {
      vnode.data.show = true;
      if (value) {
        enter(vnode, function () {
          el.style.display = el.__vOriginalDisplay;
        });
      } else {
        leave(vnode, function () {
          el.style.display = 'none';
        });
      }
    } else {
      el.style.display = value ? el.__vOriginalDisplay : 'none';
    }
  },

  unbind: function unbind (
    el,
    binding,
    vnode,
    oldVnode,
    isDestroy
  ) {
    if (!isDestroy) {
      el.style.display = el.__vOriginalDisplay;
    }
  }
};

var platformDirectives = {
  model: directive,
  show: show
};

/*  */

var transitionProps = {
  name: String,
  appear: Boolean,
  css: Boolean,
  mode: String,
  type: String,
  enterClass: String,
  leaveClass: String,
  enterToClass: String,
  leaveToClass: String,
  enterActiveClass: String,
  leaveActiveClass: String,
  appearClass: String,
  appearActiveClass: String,
  appearToClass: String,
  duration: [Number, String, Object]
};

// in case the child is also an abstract component, e.g. <keep-alive>
// we want to recursively retrieve the real component to be rendered
function getRealChild (vnode) {
  var compOptions = vnode && vnode.componentOptions;
  if (compOptions && compOptions.Ctor.options.abstract) {
    return getRealChild(getFirstComponentChild(compOptions.children))
  } else {
    return vnode
  }
}

function extractTransitionData (comp) {
  var data = {};
  var options = comp.$options;
  // props
  for (var key in options.propsData) {
    data[key] = comp[key];
  }
  // events.
  // extract listeners and pass them directly to the transition methods
  var listeners = options._parentListeners;
  for (var key$1 in listeners) {
    data[camelize(key$1)] = listeners[key$1];
  }
  return data
}

function placeholder (h, rawChild) {
  if (/\d-keep-alive$/.test(rawChild.tag)) {
    return h('keep-alive', {
      props: rawChild.componentOptions.propsData
    })
  }
}

function hasParentTransition (vnode) {
  while ((vnode = vnode.parent)) {
    if (vnode.data.transition) {
      return true
    }
  }
}

function isSameChild (child, oldChild) {
  return oldChild.key === child.key && oldChild.tag === child.tag
}

var isNotTextNode = function (c) { return c.tag || isAsyncPlaceholder(c); };

var isVShowDirective = function (d) { return d.name === 'show'; };

var Transition = {
  name: 'transition',
  props: transitionProps,
  abstract: true,

  render: function render (h) {
    var this$1 = this;

    var children = this.$slots.default;
    if (!children) {
      return
    }

    // filter out text nodes (possible whitespaces)
    children = children.filter(isNotTextNode);
    /* istanbul ignore if */
    if (!children.length) {
      return
    }

    // warn multiple elements
    if (children.length > 1) {
      warn(
        '<transition> can only be used on a single element. Use ' +
        '<transition-group> for lists.',
        this.$parent
      );
    }

    var mode = this.mode;

    // warn invalid mode
    if (mode && mode !== 'in-out' && mode !== 'out-in'
    ) {
      warn(
        'invalid <transition> mode: ' + mode,
        this.$parent
      );
    }

    var rawChild = children[0];

    // if this is a component root node and the component's
    // parent container node also has transition, skip.
    if (hasParentTransition(this.$vnode)) {
      return rawChild
    }

    // apply transition data to child
    // use getRealChild() to ignore abstract components e.g. keep-alive
    var child = getRealChild(rawChild);
    /* istanbul ignore if */
    if (!child) {
      return rawChild
    }

    if (this._leaving) {
      return placeholder(h, rawChild)
    }

    // ensure a key that is unique to the vnode type and to this transition
    // component instance. This key will be used to remove pending leaving nodes
    // during entering.
    var id = "__transition-" + (this._uid) + "-";
    child.key = child.key == null
      ? child.isComment
        ? id + 'comment'
        : id + child.tag
      : isPrimitive(child.key)
        ? (String(child.key).indexOf(id) === 0 ? child.key : id + child.key)
        : child.key;

    var data = (child.data || (child.data = {})).transition = extractTransitionData(this);
    var oldRawChild = this._vnode;
    var oldChild = getRealChild(oldRawChild);

    // mark v-show
    // so that the transition module can hand over the control to the directive
    if (child.data.directives && child.data.directives.some(isVShowDirective)) {
      child.data.show = true;
    }

    if (
      oldChild &&
      oldChild.data &&
      !isSameChild(child, oldChild) &&
      !isAsyncPlaceholder(oldChild) &&
      // #6687 component root is a comment node
      !(oldChild.componentInstance && oldChild.componentInstance._vnode.isComment)
    ) {
      // replace old child transition data with fresh one
      // important for dynamic transitions!
      var oldData = oldChild.data.transition = extend({}, data);
      // handle transition mode
      if (mode === 'out-in') {
        // return placeholder node and queue update when leave finishes
        this._leaving = true;
        mergeVNodeHook(oldData, 'afterLeave', function () {
          this$1._leaving = false;
          this$1.$forceUpdate();
        });
        return placeholder(h, rawChild)
      } else if (mode === 'in-out') {
        if (isAsyncPlaceholder(child)) {
          return oldRawChild
        }
        var delayedLeave;
        var performLeave = function () { delayedLeave(); };
        mergeVNodeHook(data, 'afterEnter', performLeave);
        mergeVNodeHook(data, 'enterCancelled', performLeave);
        mergeVNodeHook(oldData, 'delayLeave', function (leave) { delayedLeave = leave; });
      }
    }

    return rawChild
  }
};

/*  */

var props = extend({
  tag: String,
  moveClass: String
}, transitionProps);

delete props.mode;

var TransitionGroup = {
  props: props,

  beforeMount: function beforeMount () {
    var this$1 = this;

    var update = this._update;
    this._update = function (vnode, hydrating) {
      var restoreActiveInstance = setActiveInstance(this$1);
      // force removing pass
      this$1.__patch__(
        this$1._vnode,
        this$1.kept,
        false, // hydrating
        true // removeOnly (!important, avoids unnecessary moves)
      );
      this$1._vnode = this$1.kept;
      restoreActiveInstance();
      update.call(this$1, vnode, hydrating);
    };
  },

  render: function render (h) {
    var tag = this.tag || this.$vnode.data.tag || 'span';
    var map = Object.create(null);
    var prevChildren = this.prevChildren = this.children;
    var rawChildren = this.$slots.default || [];
    var children = this.children = [];
    var transitionData = extractTransitionData(this);

    for (var i = 0; i < rawChildren.length; i++) {
      var c = rawChildren[i];
      if (c.tag) {
        if (c.key != null && String(c.key).indexOf('__vlist') !== 0) {
          children.push(c);
          map[c.key] = c
          ;(c.data || (c.data = {})).transition = transitionData;
        } else {
          var opts = c.componentOptions;
          var name = opts ? (opts.Ctor.options.name || opts.tag || '') : c.tag;
          warn(("<transition-group> children must be keyed: <" + name + ">"));
        }
      }
    }

    if (prevChildren) {
      var kept = [];
      var removed = [];
      for (var i$1 = 0; i$1 < prevChildren.length; i$1++) {
        var c$1 = prevChildren[i$1];
        c$1.data.transition = transitionData;
        c$1.data.pos = c$1.elm.getBoundingClientRect();
        if (map[c$1.key]) {
          kept.push(c$1);
        } else {
          removed.push(c$1);
        }
      }
      this.kept = h(tag, null, kept);
      this.removed = removed;
    }

    return h(tag, null, children)
  },

  updated: function updated () {
    var children = this.prevChildren;
    var moveClass = this.moveClass || ((this.name || 'v') + '-move');
    if (!children.length || !this.hasMove(children[0].elm, moveClass)) {
      return
    }

    // we divide the work into three loops to avoid mixing DOM reads and writes
    // in each iteration - which helps prevent layout thrashing.
    children.forEach(callPendingCbs);
    children.forEach(recordPosition);
    children.forEach(applyTranslation);

    // force reflow to put everything in position
    // assign to this to avoid being removed in tree-shaking
    // $flow-disable-line
    this._reflow = document.body.offsetHeight;

    children.forEach(function (c) {
      if (c.data.moved) {
        var el = c.elm;
        var s = el.style;
        addTransitionClass(el, moveClass);
        s.transform = s.WebkitTransform = s.transitionDuration = '';
        el.addEventListener(transitionEndEvent, el._moveCb = function cb (e) {
          if (e && e.target !== el) {
            return
          }
          if (!e || /transform$/.test(e.propertyName)) {
            el.removeEventListener(transitionEndEvent, cb);
            el._moveCb = null;
            removeTransitionClass(el, moveClass);
          }
        });
      }
    });
  },

  methods: {
    hasMove: function hasMove (el, moveClass) {
      /* istanbul ignore if */
      if (!hasTransition) {
        return false
      }
      /* istanbul ignore if */
      if (this._hasMove) {
        return this._hasMove
      }
      // Detect whether an element with the move class applied has
      // CSS transitions. Since the element may be inside an entering
      // transition at this very moment, we make a clone of it and remove
      // all other transition classes applied to ensure only the move class
      // is applied.
      var clone = el.cloneNode();
      if (el._transitionClasses) {
        el._transitionClasses.forEach(function (cls) { removeClass(clone, cls); });
      }
      addClass(clone, moveClass);
      clone.style.display = 'none';
      this.$el.appendChild(clone);
      var info = getTransitionInfo(clone);
      this.$el.removeChild(clone);
      return (this._hasMove = info.hasTransform)
    }
  }
};

function callPendingCbs (c) {
  /* istanbul ignore if */
  if (c.elm._moveCb) {
    c.elm._moveCb();
  }
  /* istanbul ignore if */
  if (c.elm._enterCb) {
    c.elm._enterCb();
  }
}

function recordPosition (c) {
  c.data.newPos = c.elm.getBoundingClientRect();
}

function applyTranslation (c) {
  var oldPos = c.data.pos;
  var newPos = c.data.newPos;
  var dx = oldPos.left - newPos.left;
  var dy = oldPos.top - newPos.top;
  if (dx || dy) {
    c.data.moved = true;
    var s = c.elm.style;
    s.transform = s.WebkitTransform = "translate(" + dx + "px," + dy + "px)";
    s.transitionDuration = '0s';
  }
}

var platformComponents = {
  Transition: Transition,
  TransitionGroup: TransitionGroup
};

/*  */

// install platform specific utils
Vue.config.mustUseProp = mustUseProp;
Vue.config.isReservedTag = isReservedTag;
Vue.config.isReservedAttr = isReservedAttr;
Vue.config.getTagNamespace = getTagNamespace;
Vue.config.isUnknownElement = isUnknownElement;

// install platform runtime directives & components
extend(Vue.options.directives, platformDirectives);
extend(Vue.options.components, platformComponents);

// install platform patch function
Vue.prototype.__patch__ = inBrowser ? patch : noop;

// public mount method
Vue.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && inBrowser ? query(el) : undefined;
  return mountComponent(this, el, hydrating)
};

// devtools global hook
/* istanbul ignore next */
if (inBrowser) {
  setTimeout(function () {
    if (config.devtools) {
      if (devtools) {
        devtools.emit('init', Vue);
      } else {
        console[console.info ? 'info' : 'log'](
          'Download the Vue Devtools extension for a better development experience:\n' +
          'https://github.com/vuejs/vue-devtools'
        );
      }
    }
    if (config.productionTip !== false &&
      typeof console !== 'undefined'
    ) {
      console[console.info ? 'info' : 'log'](
        "You are running Vue in development mode.\n" +
        "Make sure to turn on production mode when deploying for production.\n" +
        "See more tips at https://vuejs.org/guide/deployment.html"
      );
    }
  }, 0);
}

/*  */

var defaultTagRE = /\{\{((?:.|\r?\n)+?)\}\}/g;
var regexEscapeRE = /[-.*+?^${}()|[\]\/\\]/g;

var buildRegex = cached(function (delimiters) {
  var open = delimiters[0].replace(regexEscapeRE, '\\$&');
  var close = delimiters[1].replace(regexEscapeRE, '\\$&');
  return new RegExp(open + '((?:.|\\n)+?)' + close, 'g')
});



function parseText (
  text,
  delimiters
) {
  var tagRE = delimiters ? buildRegex(delimiters) : defaultTagRE;
  if (!tagRE.test(text)) {
    return
  }
  var tokens = [];
  var rawTokens = [];
  var lastIndex = tagRE.lastIndex = 0;
  var match, index, tokenValue;
  while ((match = tagRE.exec(text))) {
    index = match.index;
    // push text token
    if (index > lastIndex) {
      rawTokens.push(tokenValue = text.slice(lastIndex, index));
      tokens.push(JSON.stringify(tokenValue));
    }
    // tag token
    var exp = parseFilters(match[1].trim());
    tokens.push(("_s(" + exp + ")"));
    rawTokens.push({ '@binding': exp });
    lastIndex = index + match[0].length;
  }
  if (lastIndex < text.length) {
    rawTokens.push(tokenValue = text.slice(lastIndex));
    tokens.push(JSON.stringify(tokenValue));
  }
  return {
    expression: tokens.join('+'),
    tokens: rawTokens
  }
}

/*  */

function transformNode (el, options) {
  var warn = options.warn || baseWarn;
  var staticClass = getAndRemoveAttr(el, 'class');
  if (staticClass) {
    var res = parseText(staticClass, options.delimiters);
    if (res) {
      warn(
        "class=\"" + staticClass + "\": " +
        'Interpolation inside attributes has been removed. ' +
        'Use v-bind or the colon shorthand instead. For example, ' +
        'instead of <div class="{{ val }}">, use <div :class="val">.',
        el.rawAttrsMap['class']
      );
    }
  }
  if (staticClass) {
    el.staticClass = JSON.stringify(staticClass);
  }
  var classBinding = getBindingAttr(el, 'class', false /* getStatic */);
  if (classBinding) {
    el.classBinding = classBinding;
  }
}

function genData (el) {
  var data = '';
  if (el.staticClass) {
    data += "staticClass:" + (el.staticClass) + ",";
  }
  if (el.classBinding) {
    data += "class:" + (el.classBinding) + ",";
  }
  return data
}

var klass$1 = {
  staticKeys: ['staticClass'],
  transformNode: transformNode,
  genData: genData
};

/*  */

function transformNode$1 (el, options) {
  var warn = options.warn || baseWarn;
  var staticStyle = getAndRemoveAttr(el, 'style');
  if (staticStyle) {
    /* istanbul ignore if */
    {
      var res = parseText(staticStyle, options.delimiters);
      if (res) {
        warn(
          "style=\"" + staticStyle + "\": " +
          'Interpolation inside attributes has been removed. ' +
          'Use v-bind or the colon shorthand instead. For example, ' +
          'instead of <div style="{{ val }}">, use <div :style="val">.',
          el.rawAttrsMap['style']
        );
      }
    }
    el.staticStyle = JSON.stringify(parseStyleText(staticStyle));
  }

  var styleBinding = getBindingAttr(el, 'style', false /* getStatic */);
  if (styleBinding) {
    el.styleBinding = styleBinding;
  }
}

function genData$1 (el) {
  var data = '';
  if (el.staticStyle) {
    data += "staticStyle:" + (el.staticStyle) + ",";
  }
  if (el.styleBinding) {
    data += "style:(" + (el.styleBinding) + "),";
  }
  return data
}

var style$1 = {
  staticKeys: ['staticStyle'],
  transformNode: transformNode$1,
  genData: genData$1
};

/*  */

var decoder;

var he = {
  decode: function decode (html) {
    decoder = decoder || document.createElement('div');
    decoder.innerHTML = html;
    return decoder.textContent
  }
};

/*  */

var isUnaryTag = makeMap(
  'area,base,br,col,embed,frame,hr,img,input,isindex,keygen,' +
  'link,meta,param,source,track,wbr'
);

// Elements that you can, intentionally, leave open
// (and which close themselves)
var canBeLeftOpenTag = makeMap(
  'colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr,source'
);

// HTML5 tags https://html.spec.whatwg.org/multipage/indices.html#elements-3
// Phrasing Content https://html.spec.whatwg.org/multipage/dom.html#phrasing-content
var isNonPhrasingTag = makeMap(
  'address,article,aside,base,blockquote,body,caption,col,colgroup,dd,' +
  'details,dialog,div,dl,dt,fieldset,figcaption,figure,footer,form,' +
  'h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,legend,li,menuitem,meta,' +
  'optgroup,option,param,rp,rt,source,style,summary,tbody,td,tfoot,th,thead,' +
  'title,tr,track'
);

/**
 * Not type-checking this file because it's mostly vendor code.
 */

// Regular Expressions for parsing tags and attributes
var attribute = /^\s*([^\s"'<>\/=]+)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/;
var dynamicArgAttribute = /^\s*((?:v-[\w-]+:|@|:|#)\[[^=]+\][^\s"'<>\/=]*)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/;
var ncname = "[a-zA-Z_][\\-\\.0-9_a-zA-Z" + (unicodeRegExp.source) + "]*";
var qnameCapture = "((?:" + ncname + "\\:)?" + ncname + ")";
var startTagOpen = new RegExp(("^<" + qnameCapture));
var startTagClose = /^\s*(\/?)>/;
var endTag = new RegExp(("^<\\/" + qnameCapture + "[^>]*>"));
var doctype = /^<!DOCTYPE [^>]+>/i;
// #7298: escape - to avoid being passed as HTML comment when inlined in page
var comment = /^<!\--/;
var conditionalComment = /^<!\[/;

// Special Elements (can contain anything)
var isPlainTextElement = makeMap('script,style,textarea', true);
var reCache = {};

var decodingMap = {
  '&lt;': '<',
  '&gt;': '>',
  '&quot;': '"',
  '&amp;': '&',
  '&#10;': '\n',
  '&#9;': '\t',
  '&#39;': "'"
};
var encodedAttr = /&(?:lt|gt|quot|amp|#39);/g;
var encodedAttrWithNewLines = /&(?:lt|gt|quot|amp|#39|#10|#9);/g;

// #5992
var isIgnoreNewlineTag = makeMap('pre,textarea', true);
var shouldIgnoreFirstNewline = function (tag, html) { return tag && isIgnoreNewlineTag(tag) && html[0] === '\n'; };

function decodeAttr (value, shouldDecodeNewlines) {
  var re = shouldDecodeNewlines ? encodedAttrWithNewLines : encodedAttr;
  return value.replace(re, function (match) { return decodingMap[match]; })
}

function parseHTML (html, options) {
  var stack = [];
  var expectHTML = options.expectHTML;
  var isUnaryTag$$1 = options.isUnaryTag || no;
  var canBeLeftOpenTag$$1 = options.canBeLeftOpenTag || no;
  var index = 0;
  var last, lastTag;
  while (html) {
    last = html;
    // Make sure we're not in a plaintext content element like script/style
    if (!lastTag || !isPlainTextElement(lastTag)) {
      var textEnd = html.indexOf('<');
      if (textEnd === 0) {
        // Comment:
        if (comment.test(html)) {
          var commentEnd = html.indexOf('-->');

          if (commentEnd >= 0) {
            if (options.shouldKeepComment) {
              options.comment(html.substring(4, commentEnd), index, index + commentEnd + 3);
            }
            advance(commentEnd + 3);
            continue
          }
        }

        // http://en.wikipedia.org/wiki/Conditional_comment#Downlevel-revealed_conditional_comment
        if (conditionalComment.test(html)) {
          var conditionalEnd = html.indexOf(']>');

          if (conditionalEnd >= 0) {
            advance(conditionalEnd + 2);
            continue
          }
        }

        // Doctype:
        var doctypeMatch = html.match(doctype);
        if (doctypeMatch) {
          advance(doctypeMatch[0].length);
          continue
        }

        // End tag:
        var endTagMatch = html.match(endTag);
        if (endTagMatch) {
          var curIndex = index;
          advance(endTagMatch[0].length);
          parseEndTag(endTagMatch[1], curIndex, index);
          continue
        }

        // Start tag:
        var startTagMatch = parseStartTag();
        if (startTagMatch) {
          handleStartTag(startTagMatch);
          if (shouldIgnoreFirstNewline(startTagMatch.tagName, html)) {
            advance(1);
          }
          continue
        }
      }

      var text = (void 0), rest = (void 0), next = (void 0);
      if (textEnd >= 0) {
        rest = html.slice(textEnd);
        while (
          !endTag.test(rest) &&
          !startTagOpen.test(rest) &&
          !comment.test(rest) &&
          !conditionalComment.test(rest)
        ) {
          // < in plain text, be forgiving and treat it as text
          next = rest.indexOf('<', 1);
          if (next < 0) { break }
          textEnd += next;
          rest = html.slice(textEnd);
        }
        text = html.substring(0, textEnd);
      }

      if (textEnd < 0) {
        text = html;
      }

      if (text) {
        advance(text.length);
      }

      if (options.chars && text) {
        options.chars(text, index - text.length, index);
      }
    } else {
      var endTagLength = 0;
      var stackedTag = lastTag.toLowerCase();
      var reStackedTag = reCache[stackedTag] || (reCache[stackedTag] = new RegExp('([\\s\\S]*?)(</' + stackedTag + '[^>]*>)', 'i'));
      var rest$1 = html.replace(reStackedTag, function (all, text, endTag) {
        endTagLength = endTag.length;
        if (!isPlainTextElement(stackedTag) && stackedTag !== 'noscript') {
          text = text
            .replace(/<!\--([\s\S]*?)-->/g, '$1') // #7298
            .replace(/<!\[CDATA\[([\s\S]*?)]]>/g, '$1');
        }
        if (shouldIgnoreFirstNewline(stackedTag, text)) {
          text = text.slice(1);
        }
        if (options.chars) {
          options.chars(text);
        }
        return ''
      });
      index += html.length - rest$1.length;
      html = rest$1;
      parseEndTag(stackedTag, index - endTagLength, index);
    }

    if (html === last) {
      options.chars && options.chars(html);
      if (!stack.length && options.warn) {
        options.warn(("Mal-formatted tag at end of template: \"" + html + "\""), { start: index + html.length });
      }
      break
    }
  }

  // Clean up any remaining tags
  parseEndTag();

  function advance (n) {
    index += n;
    html = html.substring(n);
  }

  function parseStartTag () {
    var start = html.match(startTagOpen);
    if (start) {
      var match = {
        tagName: start[1],
        attrs: [],
        start: index
      };
      advance(start[0].length);
      var end, attr;
      while (!(end = html.match(startTagClose)) && (attr = html.match(dynamicArgAttribute) || html.match(attribute))) {
        attr.start = index;
        advance(attr[0].length);
        attr.end = index;
        match.attrs.push(attr);
      }
      if (end) {
        match.unarySlash = end[1];
        advance(end[0].length);
        match.end = index;
        return match
      }
    }
  }

  function handleStartTag (match) {
    var tagName = match.tagName;
    var unarySlash = match.unarySlash;

    if (expectHTML) {
      if (lastTag === 'p' && isNonPhrasingTag(tagName)) {
        parseEndTag(lastTag);
      }
      if (canBeLeftOpenTag$$1(tagName) && lastTag === tagName) {
        parseEndTag(tagName);
      }
    }

    var unary = isUnaryTag$$1(tagName) || !!unarySlash;

    var l = match.attrs.length;
    var attrs = new Array(l);
    for (var i = 0; i < l; i++) {
      var args = match.attrs[i];
      var value = args[3] || args[4] || args[5] || '';
      var shouldDecodeNewlines = tagName === 'a' && args[1] === 'href'
        ? options.shouldDecodeNewlinesForHref
        : options.shouldDecodeNewlines;
      attrs[i] = {
        name: args[1],
        value: decodeAttr(value, shouldDecodeNewlines)
      };
      if (options.outputSourceRange) {
        attrs[i].start = args.start + args[0].match(/^\s*/).length;
        attrs[i].end = args.end;
      }
    }

    if (!unary) {
      stack.push({ tag: tagName, lowerCasedTag: tagName.toLowerCase(), attrs: attrs, start: match.start, end: match.end });
      lastTag = tagName;
    }

    if (options.start) {
      options.start(tagName, attrs, unary, match.start, match.end);
    }
  }

  function parseEndTag (tagName, start, end) {
    var pos, lowerCasedTagName;
    if (start == null) { start = index; }
    if (end == null) { end = index; }

    // Find the closest opened tag of the same type
    if (tagName) {
      lowerCasedTagName = tagName.toLowerCase();
      for (pos = stack.length - 1; pos >= 0; pos--) {
        if (stack[pos].lowerCasedTag === lowerCasedTagName) {
          break
        }
      }
    } else {
      // If no tag name is provided, clean shop
      pos = 0;
    }

    if (pos >= 0) {
      // Close all the open elements, up the stack
      for (var i = stack.length - 1; i >= pos; i--) {
        if (i > pos || !tagName &&
          options.warn
        ) {
          options.warn(
            ("tag <" + (stack[i].tag) + "> has no matching end tag."),
            { start: stack[i].start, end: stack[i].end }
          );
        }
        if (options.end) {
          options.end(stack[i].tag, start, end);
        }
      }

      // Remove the open elements from the stack
      stack.length = pos;
      lastTag = pos && stack[pos - 1].tag;
    } else if (lowerCasedTagName === 'br') {
      if (options.start) {
        options.start(tagName, [], true, start, end);
      }
    } else if (lowerCasedTagName === 'p') {
      if (options.start) {
        options.start(tagName, [], false, start, end);
      }
      if (options.end) {
        options.end(tagName, start, end);
      }
    }
  }
}

/*  */

var onRE = /^@|^v-on:/;
var dirRE = /^v-|^@|^:|^#/;
var forAliasRE = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/;
var forIteratorRE = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/;
var stripParensRE = /^\(|\)$/g;
var dynamicArgRE = /^\[.*\]$/;

var argRE = /:(.*)$/;
var bindRE = /^:|^\.|^v-bind:/;
var modifierRE = /\.[^.\]]+(?=[^\]]*$)/g;

var slotRE = /^v-slot(:|$)|^#/;

var lineBreakRE = /[\r\n]/;
var whitespaceRE$1 = /\s+/g;

var invalidAttributeRE = /[\s"'<>\/=]/;

var decodeHTMLCached = cached(he.decode);

var emptySlotScopeToken = "_empty_";

// configurable state
var warn$2;
var delimiters;
var transforms;
var preTransforms;
var postTransforms;
var platformIsPreTag;
var platformMustUseProp;
var platformGetTagNamespace;
var maybeComponent;

function createASTElement (
  tag,
  attrs,
  parent
) {
  return {
    type: 1,
    tag: tag,
    attrsList: attrs,
    attrsMap: makeAttrsMap(attrs),
    rawAttrsMap: {},
    parent: parent,
    children: []
  }
}

/**
 * Convert HTML string to AST.
 */
function parse (
  template,
  options
) {
  warn$2 = options.warn || baseWarn;

  platformIsPreTag = options.isPreTag || no;
  platformMustUseProp = options.mustUseProp || no;
  platformGetTagNamespace = options.getTagNamespace || no;
  var isReservedTag = options.isReservedTag || no;
  maybeComponent = function (el) { return !!el.component || !isReservedTag(el.tag); };

  transforms = pluckModuleFunction(options.modules, 'transformNode');
  preTransforms = pluckModuleFunction(options.modules, 'preTransformNode');
  postTransforms = pluckModuleFunction(options.modules, 'postTransformNode');

  delimiters = options.delimiters;

  var stack = [];
  var preserveWhitespace = options.preserveWhitespace !== false;
  var whitespaceOption = options.whitespace;
  var root;
  var currentParent;
  var inVPre = false;
  var inPre = false;
  var warned = false;

  function warnOnce (msg, range) {
    if (!warned) {
      warned = true;
      warn$2(msg, range);
    }
  }

  function closeElement (element) {
    trimEndingWhitespace(element);
    if (!inVPre && !element.processed) {
      element = processElement(element, options);
    }
    // tree management
    if (!stack.length && element !== root) {
      // allow root elements with v-if, v-else-if and v-else
      if (root.if && (element.elseif || element.else)) {
        {
          checkRootConstraints(element);
        }
        addIfCondition(root, {
          exp: element.elseif,
          block: element
        });
      } else {
        warnOnce(
          "Component template should contain exactly one root element. " +
          "If you are using v-if on multiple elements, " +
          "use v-else-if to chain them instead.",
          { start: element.start }
        );
      }
    }
    if (currentParent && !element.forbidden) {
      if (element.elseif || element.else) {
        processIfConditions(element, currentParent);
      } else {
        if (element.slotScope) {
          // scoped slot
          // keep it in the children list so that v-else(-if) conditions can
          // find it as the prev node.
          var name = element.slotTarget || '"default"'
          ;(currentParent.scopedSlots || (currentParent.scopedSlots = {}))[name] = element;
        }
        currentParent.children.push(element);
        element.parent = currentParent;
      }
    }

    // final children cleanup
    // filter out scoped slots
    element.children = element.children.filter(function (c) { return !(c).slotScope; });
    // remove trailing whitespace node again
    trimEndingWhitespace(element);

    // check pre state
    if (element.pre) {
      inVPre = false;
    }
    if (platformIsPreTag(element.tag)) {
      inPre = false;
    }
    // apply post-transforms
    for (var i = 0; i < postTransforms.length; i++) {
      postTransforms[i](element, options);
    }
  }

  function trimEndingWhitespace (el) {
    // remove trailing whitespace node
    if (!inPre) {
      var lastNode;
      while (
        (lastNode = el.children[el.children.length - 1]) &&
        lastNode.type === 3 &&
        lastNode.text === ' '
      ) {
        el.children.pop();
      }
    }
  }

  function checkRootConstraints (el) {
    if (el.tag === 'slot' || el.tag === 'template') {
      warnOnce(
        "Cannot use <" + (el.tag) + "> as component root element because it may " +
        'contain multiple nodes.',
        { start: el.start }
      );
    }
    if (el.attrsMap.hasOwnProperty('v-for')) {
      warnOnce(
        'Cannot use v-for on stateful component root element because ' +
        'it renders multiple elements.',
        el.rawAttrsMap['v-for']
      );
    }
  }

  parseHTML(template, {
    warn: warn$2,
    expectHTML: options.expectHTML,
    isUnaryTag: options.isUnaryTag,
    canBeLeftOpenTag: options.canBeLeftOpenTag,
    shouldDecodeNewlines: options.shouldDecodeNewlines,
    shouldDecodeNewlinesForHref: options.shouldDecodeNewlinesForHref,
    shouldKeepComment: options.comments,
    outputSourceRange: options.outputSourceRange,
    start: function start (tag, attrs, unary, start$1, end) {
      // check namespace.
      // inherit parent ns if there is one
      var ns = (currentParent && currentParent.ns) || platformGetTagNamespace(tag);

      // handle IE svg bug
      /* istanbul ignore if */
      if (isIE && ns === 'svg') {
        attrs = guardIESVGBug(attrs);
      }

      var element = createASTElement(tag, attrs, currentParent);
      if (ns) {
        element.ns = ns;
      }

      {
        if (options.outputSourceRange) {
          element.start = start$1;
          element.end = end;
          element.rawAttrsMap = element.attrsList.reduce(function (cumulated, attr) {
            cumulated[attr.name] = attr;
            return cumulated
          }, {});
        }
        attrs.forEach(function (attr) {
          if (invalidAttributeRE.test(attr.name)) {
            warn$2(
              "Invalid dynamic argument expression: attribute names cannot contain " +
              "spaces, quotes, <, >, / or =.",
              {
                start: attr.start + attr.name.indexOf("["),
                end: attr.start + attr.name.length
              }
            );
          }
        });
      }

      if (isForbiddenTag(element) && !isServerRendering()) {
        element.forbidden = true;
        warn$2(
          'Templates should only be responsible for mapping the state to the ' +
          'UI. Avoid placing tags with side-effects in your templates, such as ' +
          "<" + tag + ">" + ', as they will not be parsed.',
          { start: element.start }
        );
      }

      // apply pre-transforms
      for (var i = 0; i < preTransforms.length; i++) {
        element = preTransforms[i](element, options) || element;
      }

      if (!inVPre) {
        processPre(element);
        if (element.pre) {
          inVPre = true;
        }
      }
      if (platformIsPreTag(element.tag)) {
        inPre = true;
      }
      if (inVPre) {
        processRawAttrs(element);
      } else if (!element.processed) {
        // structural directives
        processFor(element);
        processIf(element);
        processOnce(element);
      }

      if (!root) {
        root = element;
        {
          checkRootConstraints(root);
        }
      }

      if (!unary) {
        currentParent = element;
        stack.push(element);
      } else {
        closeElement(element);
      }
    },

    end: function end (tag, start, end$1) {
      var element = stack[stack.length - 1];
      // pop stack
      stack.length -= 1;
      currentParent = stack[stack.length - 1];
      if (options.outputSourceRange) {
        element.end = end$1;
      }
      closeElement(element);
    },

    chars: function chars (text, start, end) {
      if (!currentParent) {
        {
          if (text === template) {
            warnOnce(
              'Component template requires a root element, rather than just text.',
              { start: start }
            );
          } else if ((text = text.trim())) {
            warnOnce(
              ("text \"" + text + "\" outside root element will be ignored."),
              { start: start }
            );
          }
        }
        return
      }
      // IE textarea placeholder bug
      /* istanbul ignore if */
      if (isIE &&
        currentParent.tag === 'textarea' &&
        currentParent.attrsMap.placeholder === text
      ) {
        return
      }
      var children = currentParent.children;
      if (inPre || text.trim()) {
        text = isTextTag(currentParent) ? text : decodeHTMLCached(text);
      } else if (!children.length) {
        // remove the whitespace-only node right after an opening tag
        text = '';
      } else if (whitespaceOption) {
        if (whitespaceOption === 'condense') {
          // in condense mode, remove the whitespace node if it contains
          // line break, otherwise condense to a single space
          text = lineBreakRE.test(text) ? '' : ' ';
        } else {
          text = ' ';
        }
      } else {
        text = preserveWhitespace ? ' ' : '';
      }
      if (text) {
        if (!inPre && whitespaceOption === 'condense') {
          // condense consecutive whitespaces into single space
          text = text.replace(whitespaceRE$1, ' ');
        }
        var res;
        var child;
        if (!inVPre && text !== ' ' && (res = parseText(text, delimiters))) {
          child = {
            type: 2,
            expression: res.expression,
            tokens: res.tokens,
            text: text
          };
        } else if (text !== ' ' || !children.length || children[children.length - 1].text !== ' ') {
          child = {
            type: 3,
            text: text
          };
        }
        if (child) {
          if (options.outputSourceRange) {
            child.start = start;
            child.end = end;
          }
          children.push(child);
        }
      }
    },
    comment: function comment (text, start, end) {
      // adding anyting as a sibling to the root node is forbidden
      // comments should still be allowed, but ignored
      if (currentParent) {
        var child = {
          type: 3,
          text: text,
          isComment: true
        };
        if (options.outputSourceRange) {
          child.start = start;
          child.end = end;
        }
        currentParent.children.push(child);
      }
    }
  });
  return root
}

function processPre (el) {
  if (getAndRemoveAttr(el, 'v-pre') != null) {
    el.pre = true;
  }
}

function processRawAttrs (el) {
  var list = el.attrsList;
  var len = list.length;
  if (len) {
    var attrs = el.attrs = new Array(len);
    for (var i = 0; i < len; i++) {
      attrs[i] = {
        name: list[i].name,
        value: JSON.stringify(list[i].value)
      };
      if (list[i].start != null) {
        attrs[i].start = list[i].start;
        attrs[i].end = list[i].end;
      }
    }
  } else if (!el.pre) {
    // non root node in pre blocks with no attributes
    el.plain = true;
  }
}

function processElement (
  element,
  options
) {
  processKey(element);

  // determine whether this is a plain element after
  // removing structural attributes
  element.plain = (
    !element.key &&
    !element.scopedSlots &&
    !element.attrsList.length
  );

  processRef(element);
  processSlotContent(element);
  processSlotOutlet(element);
  processComponent(element);
  for (var i = 0; i < transforms.length; i++) {
    element = transforms[i](element, options) || element;
  }
  processAttrs(element);
  return element
}

function processKey (el) {
  var exp = getBindingAttr(el, 'key');
  if (exp) {
    {
      if (el.tag === 'template') {
        warn$2(
          "<template> cannot be keyed. Place the key on real elements instead.",
          getRawBindingAttr(el, 'key')
        );
      }
      if (el.for) {
        var iterator = el.iterator2 || el.iterator1;
        var parent = el.parent;
        if (iterator && iterator === exp && parent && parent.tag === 'transition-group') {
          warn$2(
            "Do not use v-for index as key on <transition-group> children, " +
            "this is the same as not using keys.",
            getRawBindingAttr(el, 'key'),
            true /* tip */
          );
        }
      }
    }
    el.key = exp;
  }
}

function processRef (el) {
  var ref = getBindingAttr(el, 'ref');
  if (ref) {
    el.ref = ref;
    el.refInFor = checkInFor(el);
  }
}

function processFor (el) {
  var exp;
  if ((exp = getAndRemoveAttr(el, 'v-for'))) {
    var res = parseFor(exp);
    if (res) {
      extend(el, res);
    } else {
      warn$2(
        ("Invalid v-for expression: " + exp),
        el.rawAttrsMap['v-for']
      );
    }
  }
}



function parseFor (exp) {
  var inMatch = exp.match(forAliasRE);
  if (!inMatch) { return }
  var res = {};
  res.for = inMatch[2].trim();
  var alias = inMatch[1].trim().replace(stripParensRE, '');
  var iteratorMatch = alias.match(forIteratorRE);
  if (iteratorMatch) {
    res.alias = alias.replace(forIteratorRE, '').trim();
    res.iterator1 = iteratorMatch[1].trim();
    if (iteratorMatch[2]) {
      res.iterator2 = iteratorMatch[2].trim();
    }
  } else {
    res.alias = alias;
  }
  return res
}

function processIf (el) {
  var exp = getAndRemoveAttr(el, 'v-if');
  if (exp) {
    el.if = exp;
    addIfCondition(el, {
      exp: exp,
      block: el
    });
  } else {
    if (getAndRemoveAttr(el, 'v-else') != null) {
      el.else = true;
    }
    var elseif = getAndRemoveAttr(el, 'v-else-if');
    if (elseif) {
      el.elseif = elseif;
    }
  }
}

function processIfConditions (el, parent) {
  var prev = findPrevElement(parent.children);
  if (prev && prev.if) {
    addIfCondition(prev, {
      exp: el.elseif,
      block: el
    });
  } else {
    warn$2(
      "v-" + (el.elseif ? ('else-if="' + el.elseif + '"') : 'else') + " " +
      "used on element <" + (el.tag) + "> without corresponding v-if.",
      el.rawAttrsMap[el.elseif ? 'v-else-if' : 'v-else']
    );
  }
}

function findPrevElement (children) {
  var i = children.length;
  while (i--) {
    if (children[i].type === 1) {
      return children[i]
    } else {
      if (children[i].text !== ' ') {
        warn$2(
          "text \"" + (children[i].text.trim()) + "\" between v-if and v-else(-if) " +
          "will be ignored.",
          children[i]
        );
      }
      children.pop();
    }
  }
}

function addIfCondition (el, condition) {
  if (!el.ifConditions) {
    el.ifConditions = [];
  }
  el.ifConditions.push(condition);
}

function processOnce (el) {
  var once$$1 = getAndRemoveAttr(el, 'v-once');
  if (once$$1 != null) {
    el.once = true;
  }
}

// handle content being passed to a component as slot,
// e.g. <template slot="xxx">, <div slot-scope="xxx">
function processSlotContent (el) {
  var slotScope;
  if (el.tag === 'template') {
    slotScope = getAndRemoveAttr(el, 'scope');
    /* istanbul ignore if */
    if (slotScope) {
      warn$2(
        "the \"scope\" attribute for scoped slots have been deprecated and " +
        "replaced by \"slot-scope\" since 2.5. The new \"slot-scope\" attribute " +
        "can also be used on plain elements in addition to <template> to " +
        "denote scoped slots.",
        el.rawAttrsMap['scope'],
        true
      );
    }
    el.slotScope = slotScope || getAndRemoveAttr(el, 'slot-scope');
  } else if ((slotScope = getAndRemoveAttr(el, 'slot-scope'))) {
    /* istanbul ignore if */
    if (el.attrsMap['v-for']) {
      warn$2(
        "Ambiguous combined usage of slot-scope and v-for on <" + (el.tag) + "> " +
        "(v-for takes higher priority). Use a wrapper <template> for the " +
        "scoped slot to make it clearer.",
        el.rawAttrsMap['slot-scope'],
        true
      );
    }
    el.slotScope = slotScope;
  }

  // slot="xxx"
  var slotTarget = getBindingAttr(el, 'slot');
  if (slotTarget) {
    el.slotTarget = slotTarget === '""' ? '"default"' : slotTarget;
    el.slotTargetDynamic = !!(el.attrsMap[':slot'] || el.attrsMap['v-bind:slot']);
    // preserve slot as an attribute for native shadow DOM compat
    // only for non-scoped slots.
    if (el.tag !== 'template' && !el.slotScope) {
      addAttr(el, 'slot', slotTarget, getRawBindingAttr(el, 'slot'));
    }
  }

  // 2.6 v-slot syntax
  {
    if (el.tag === 'template') {
      // v-slot on <template>
      var slotBinding = getAndRemoveAttrByRegex(el, slotRE);
      if (slotBinding) {
        {
          if (el.slotTarget || el.slotScope) {
            warn$2(
              "Unexpected mixed usage of different slot syntaxes.",
              el
            );
          }
          if (el.parent && !maybeComponent(el.parent)) {
            warn$2(
              "<template v-slot> can only appear at the root level inside " +
              "the receiving component",
              el
            );
          }
        }
        var ref = getSlotName(slotBinding);
        var name = ref.name;
        var dynamic = ref.dynamic;
        el.slotTarget = name;
        el.slotTargetDynamic = dynamic;
        el.slotScope = slotBinding.value || emptySlotScopeToken; // force it into a scoped slot for perf
      }
    } else {
      // v-slot on component, denotes default slot
      var slotBinding$1 = getAndRemoveAttrByRegex(el, slotRE);
      if (slotBinding$1) {
        {
          if (!maybeComponent(el)) {
            warn$2(
              "v-slot can only be used on components or <template>.",
              slotBinding$1
            );
          }
          if (el.slotScope || el.slotTarget) {
            warn$2(
              "Unexpected mixed usage of different slot syntaxes.",
              el
            );
          }
          if (el.scopedSlots) {
            warn$2(
              "To avoid scope ambiguity, the default slot should also use " +
              "<template> syntax when there are other named slots.",
              slotBinding$1
            );
          }
        }
        // add the component's children to its default slot
        var slots = el.scopedSlots || (el.scopedSlots = {});
        var ref$1 = getSlotName(slotBinding$1);
        var name$1 = ref$1.name;
        var dynamic$1 = ref$1.dynamic;
        var slotContainer = slots[name$1] = createASTElement('template', [], el);
        slotContainer.slotTarget = name$1;
        slotContainer.slotTargetDynamic = dynamic$1;
        slotContainer.children = el.children.filter(function (c) {
          if (!c.slotScope) {
            c.parent = slotContainer;
            return true
          }
        });
        slotContainer.slotScope = slotBinding$1.value || emptySlotScopeToken;
        // remove children as they are returned from scopedSlots now
        el.children = [];
        // mark el non-plain so data gets generated
        el.plain = false;
      }
    }
  }
}

function getSlotName (binding) {
  var name = binding.name.replace(slotRE, '');
  if (!name) {
    if (binding.name[0] !== '#') {
      name = 'default';
    } else {
      warn$2(
        "v-slot shorthand syntax requires a slot name.",
        binding
      );
    }
  }
  return dynamicArgRE.test(name)
    // dynamic [name]
    ? { name: name.slice(1, -1), dynamic: true }
    // static name
    : { name: ("\"" + name + "\""), dynamic: false }
}

// handle <slot/> outlets
function processSlotOutlet (el) {
  if (el.tag === 'slot') {
    el.slotName = getBindingAttr(el, 'name');
    if (el.key) {
      warn$2(
        "`key` does not work on <slot> because slots are abstract outlets " +
        "and can possibly expand into multiple elements. " +
        "Use the key on a wrapping element instead.",
        getRawBindingAttr(el, 'key')
      );
    }
  }
}

function processComponent (el) {
  var binding;
  if ((binding = getBindingAttr(el, 'is'))) {
    el.component = binding;
  }
  if (getAndRemoveAttr(el, 'inline-template') != null) {
    el.inlineTemplate = true;
  }
}

function processAttrs (el) {
  var list = el.attrsList;
  var i, l, name, rawName, value, modifiers, syncGen, isDynamic;
  for (i = 0, l = list.length; i < l; i++) {
    name = rawName = list[i].name;
    value = list[i].value;
    if (dirRE.test(name)) {
      // mark element as dynamic
      el.hasBindings = true;
      // modifiers
      modifiers = parseModifiers(name.replace(dirRE, ''));
      // support .foo shorthand syntax for the .prop modifier
      if (modifiers) {
        name = name.replace(modifierRE, '');
      }
      if (bindRE.test(name)) { // v-bind
        name = name.replace(bindRE, '');
        value = parseFilters(value);
        isDynamic = dynamicArgRE.test(name);
        if (isDynamic) {
          name = name.slice(1, -1);
        }
        if (
          value.trim().length === 0
        ) {
          warn$2(
            ("The value for a v-bind expression cannot be empty. Found in \"v-bind:" + name + "\"")
          );
        }
        if (modifiers) {
          if (modifiers.prop && !isDynamic) {
            name = camelize(name);
            if (name === 'innerHtml') { name = 'innerHTML'; }
          }
          if (modifiers.camel && !isDynamic) {
            name = camelize(name);
          }
          if (modifiers.sync) {
            syncGen = genAssignmentCode(value, "$event");
            if (!isDynamic) {
              addHandler(
                el,
                ("update:" + (camelize(name))),
                syncGen,
                null,
                false,
                warn$2,
                list[i]
              );
              if (hyphenate(name) !== camelize(name)) {
                addHandler(
                  el,
                  ("update:" + (hyphenate(name))),
                  syncGen,
                  null,
                  false,
                  warn$2,
                  list[i]
                );
              }
            } else {
              // handler w/ dynamic event name
              addHandler(
                el,
                ("\"update:\"+(" + name + ")"),
                syncGen,
                null,
                false,
                warn$2,
                list[i],
                true // dynamic
              );
            }
          }
        }
        if ((modifiers && modifiers.prop) || (
          !el.component && platformMustUseProp(el.tag, el.attrsMap.type, name)
        )) {
          addProp(el, name, value, list[i], isDynamic);
        } else {
          addAttr(el, name, value, list[i], isDynamic);
        }
      } else if (onRE.test(name)) { // v-on
        name = name.replace(onRE, '');
        isDynamic = dynamicArgRE.test(name);
        if (isDynamic) {
          name = name.slice(1, -1);
        }
        addHandler(el, name, value, modifiers, false, warn$2, list[i], isDynamic);
      } else { // normal directives
        name = name.replace(dirRE, '');
        // parse arg
        var argMatch = name.match(argRE);
        var arg = argMatch && argMatch[1];
        isDynamic = false;
        if (arg) {
          name = name.slice(0, -(arg.length + 1));
          if (dynamicArgRE.test(arg)) {
            arg = arg.slice(1, -1);
            isDynamic = true;
          }
        }
        addDirective(el, name, rawName, value, arg, isDynamic, modifiers, list[i]);
        if (name === 'model') {
          checkForAliasModel(el, value);
        }
      }
    } else {
      // literal attribute
      {
        var res = parseText(value, delimiters);
        if (res) {
          warn$2(
            name + "=\"" + value + "\": " +
            'Interpolation inside attributes has been removed. ' +
            'Use v-bind or the colon shorthand instead. For example, ' +
            'instead of <div id="{{ val }}">, use <div :id="val">.',
            list[i]
          );
        }
      }
      addAttr(el, name, JSON.stringify(value), list[i]);
      // #6887 firefox doesn't update muted state if set via attribute
      // even immediately after element creation
      if (!el.component &&
          name === 'muted' &&
          platformMustUseProp(el.tag, el.attrsMap.type, name)) {
        addProp(el, name, 'true', list[i]);
      }
    }
  }
}

function checkInFor (el) {
  var parent = el;
  while (parent) {
    if (parent.for !== undefined) {
      return true
    }
    parent = parent.parent;
  }
  return false
}

function parseModifiers (name) {
  var match = name.match(modifierRE);
  if (match) {
    var ret = {};
    match.forEach(function (m) { ret[m.slice(1)] = true; });
    return ret
  }
}

function makeAttrsMap (attrs) {
  var map = {};
  for (var i = 0, l = attrs.length; i < l; i++) {
    if (
      map[attrs[i].name] && !isIE && !isEdge
    ) {
      warn$2('duplicate attribute: ' + attrs[i].name, attrs[i]);
    }
    map[attrs[i].name] = attrs[i].value;
  }
  return map
}

// for script (e.g. type="x/template") or style, do not decode content
function isTextTag (el) {
  return el.tag === 'script' || el.tag === 'style'
}

function isForbiddenTag (el) {
  return (
    el.tag === 'style' ||
    (el.tag === 'script' && (
      !el.attrsMap.type ||
      el.attrsMap.type === 'text/javascript'
    ))
  )
}

var ieNSBug = /^xmlns:NS\d+/;
var ieNSPrefix = /^NS\d+:/;

/* istanbul ignore next */
function guardIESVGBug (attrs) {
  var res = [];
  for (var i = 0; i < attrs.length; i++) {
    var attr = attrs[i];
    if (!ieNSBug.test(attr.name)) {
      attr.name = attr.name.replace(ieNSPrefix, '');
      res.push(attr);
    }
  }
  return res
}

function checkForAliasModel (el, value) {
  var _el = el;
  while (_el) {
    if (_el.for && _el.alias === value) {
      warn$2(
        "<" + (el.tag) + " v-model=\"" + value + "\">: " +
        "You are binding v-model directly to a v-for iteration alias. " +
        "This will not be able to modify the v-for source array because " +
        "writing to the alias is like modifying a function local variable. " +
        "Consider using an array of objects and use v-model on an object property instead.",
        el.rawAttrsMap['v-model']
      );
    }
    _el = _el.parent;
  }
}

/*  */

function preTransformNode (el, options) {
  if (el.tag === 'input') {
    var map = el.attrsMap;
    if (!map['v-model']) {
      return
    }

    var typeBinding;
    if (map[':type'] || map['v-bind:type']) {
      typeBinding = getBindingAttr(el, 'type');
    }
    if (!map.type && !typeBinding && map['v-bind']) {
      typeBinding = "(" + (map['v-bind']) + ").type";
    }

    if (typeBinding) {
      var ifCondition = getAndRemoveAttr(el, 'v-if', true);
      var ifConditionExtra = ifCondition ? ("&&(" + ifCondition + ")") : "";
      var hasElse = getAndRemoveAttr(el, 'v-else', true) != null;
      var elseIfCondition = getAndRemoveAttr(el, 'v-else-if', true);
      // 1. checkbox
      var branch0 = cloneASTElement(el);
      // process for on the main node
      processFor(branch0);
      addRawAttr(branch0, 'type', 'checkbox');
      processElement(branch0, options);
      branch0.processed = true; // prevent it from double-processed
      branch0.if = "(" + typeBinding + ")==='checkbox'" + ifConditionExtra;
      addIfCondition(branch0, {
        exp: branch0.if,
        block: branch0
      });
      // 2. add radio else-if condition
      var branch1 = cloneASTElement(el);
      getAndRemoveAttr(branch1, 'v-for', true);
      addRawAttr(branch1, 'type', 'radio');
      processElement(branch1, options);
      addIfCondition(branch0, {
        exp: "(" + typeBinding + ")==='radio'" + ifConditionExtra,
        block: branch1
      });
      // 3. other
      var branch2 = cloneASTElement(el);
      getAndRemoveAttr(branch2, 'v-for', true);
      addRawAttr(branch2, ':type', typeBinding);
      processElement(branch2, options);
      addIfCondition(branch0, {
        exp: ifCondition,
        block: branch2
      });

      if (hasElse) {
        branch0.else = true;
      } else if (elseIfCondition) {
        branch0.elseif = elseIfCondition;
      }

      return branch0
    }
  }
}

function cloneASTElement (el) {
  return createASTElement(el.tag, el.attrsList.slice(), el.parent)
}

var model$1 = {
  preTransformNode: preTransformNode
};

var modules$1 = [
  klass$1,
  style$1,
  model$1
];

/*  */

function text (el, dir) {
  if (dir.value) {
    addProp(el, 'textContent', ("_s(" + (dir.value) + ")"), dir);
  }
}

/*  */

function html (el, dir) {
  if (dir.value) {
    addProp(el, 'innerHTML', ("_s(" + (dir.value) + ")"), dir);
  }
}

var directives$1 = {
  model: model,
  text: text,
  html: html
};

/*  */

var baseOptions = {
  expectHTML: true,
  modules: modules$1,
  directives: directives$1,
  isPreTag: isPreTag,
  isUnaryTag: isUnaryTag,
  mustUseProp: mustUseProp,
  canBeLeftOpenTag: canBeLeftOpenTag,
  isReservedTag: isReservedTag,
  getTagNamespace: getTagNamespace,
  staticKeys: genStaticKeys(modules$1)
};

/*  */

var isStaticKey;
var isPlatformReservedTag;

var genStaticKeysCached = cached(genStaticKeys$1);

/**
 * Goal of the optimizer: walk the generated template AST tree
 * and detect sub-trees that are purely static, i.e. parts of
 * the DOM that never needs to change.
 *
 * Once we detect these sub-trees, we can:
 *
 * 1. Hoist them into constants, so that we no longer need to
 *    create fresh nodes for them on each re-render;
 * 2. Completely skip them in the patching process.
 */
function optimize (root, options) {
  if (!root) { return }
  isStaticKey = genStaticKeysCached(options.staticKeys || '');
  isPlatformReservedTag = options.isReservedTag || no;
  // first pass: mark all non-static nodes.
  markStatic$1(root);
  // second pass: mark static roots.
  markStaticRoots(root, false);
}

function genStaticKeys$1 (keys) {
  return makeMap(
    'type,tag,attrsList,attrsMap,plain,parent,children,attrs,start,end,rawAttrsMap' +
    (keys ? ',' + keys : '')
  )
}

function markStatic$1 (node) {
  node.static = isStatic(node);
  if (node.type === 1) {
    // do not make component slot content static. this avoids
    // 1. components not able to mutate slot nodes
    // 2. static slot content fails for hot-reloading
    if (
      !isPlatformReservedTag(node.tag) &&
      node.tag !== 'slot' &&
      node.attrsMap['inline-template'] == null
    ) {
      return
    }
    for (var i = 0, l = node.children.length; i < l; i++) {
      var child = node.children[i];
      markStatic$1(child);
      if (!child.static) {
        node.static = false;
      }
    }
    if (node.ifConditions) {
      for (var i$1 = 1, l$1 = node.ifConditions.length; i$1 < l$1; i$1++) {
        var block = node.ifConditions[i$1].block;
        markStatic$1(block);
        if (!block.static) {
          node.static = false;
        }
      }
    }
  }
}

function markStaticRoots (node, isInFor) {
  if (node.type === 1) {
    if (node.static || node.once) {
      node.staticInFor = isInFor;
    }
    // For a node to qualify as a static root, it should have children that
    // are not just static text. Otherwise the cost of hoisting out will
    // outweigh the benefits and it's better off to just always render it fresh.
    if (node.static && node.children.length && !(
      node.children.length === 1 &&
      node.children[0].type === 3
    )) {
      node.staticRoot = true;
      return
    } else {
      node.staticRoot = false;
    }
    if (node.children) {
      for (var i = 0, l = node.children.length; i < l; i++) {
        markStaticRoots(node.children[i], isInFor || !!node.for);
      }
    }
    if (node.ifConditions) {
      for (var i$1 = 1, l$1 = node.ifConditions.length; i$1 < l$1; i$1++) {
        markStaticRoots(node.ifConditions[i$1].block, isInFor);
      }
    }
  }
}

function isStatic (node) {
  if (node.type === 2) { // expression
    return false
  }
  if (node.type === 3) { // text
    return true
  }
  return !!(node.pre || (
    !node.hasBindings && // no dynamic bindings
    !node.if && !node.for && // not v-if or v-for or v-else
    !isBuiltInTag(node.tag) && // not a built-in
    isPlatformReservedTag(node.tag) && // not a component
    !isDirectChildOfTemplateFor(node) &&
    Object.keys(node).every(isStaticKey)
  ))
}

function isDirectChildOfTemplateFor (node) {
  while (node.parent) {
    node = node.parent;
    if (node.tag !== 'template') {
      return false
    }
    if (node.for) {
      return true
    }
  }
  return false
}

/*  */

var fnExpRE = /^([\w$_]+|\([^)]*?\))\s*=>|^function(?:\s+[\w$]+)?\s*\(/;
var fnInvokeRE = /\([^)]*?\);*$/;
var simplePathRE = /^[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['[^']*?']|\["[^"]*?"]|\[\d+]|\[[A-Za-z_$][\w$]*])*$/;

// KeyboardEvent.keyCode aliases
var keyCodes = {
  esc: 27,
  tab: 9,
  enter: 13,
  space: 32,
  up: 38,
  left: 37,
  right: 39,
  down: 40,
  'delete': [8, 46]
};

// KeyboardEvent.key aliases
var keyNames = {
  // #7880: IE11 and Edge use `Esc` for Escape key name.
  esc: ['Esc', 'Escape'],
  tab: 'Tab',
  enter: 'Enter',
  // #9112: IE11 uses `Spacebar` for Space key name.
  space: [' ', 'Spacebar'],
  // #7806: IE11 uses key names without `Arrow` prefix for arrow keys.
  up: ['Up', 'ArrowUp'],
  left: ['Left', 'ArrowLeft'],
  right: ['Right', 'ArrowRight'],
  down: ['Down', 'ArrowDown'],
  // #9112: IE11 uses `Del` for Delete key name.
  'delete': ['Backspace', 'Delete', 'Del']
};

// #4868: modifiers that prevent the execution of the listener
// need to explicitly return null so that we can determine whether to remove
// the listener for .once
var genGuard = function (condition) { return ("if(" + condition + ")return null;"); };

var modifierCode = {
  stop: '$event.stopPropagation();',
  prevent: '$event.preventDefault();',
  self: genGuard("$event.target !== $event.currentTarget"),
  ctrl: genGuard("!$event.ctrlKey"),
  shift: genGuard("!$event.shiftKey"),
  alt: genGuard("!$event.altKey"),
  meta: genGuard("!$event.metaKey"),
  left: genGuard("'button' in $event && $event.button !== 0"),
  middle: genGuard("'button' in $event && $event.button !== 1"),
  right: genGuard("'button' in $event && $event.button !== 2")
};

function genHandlers (
  events,
  isNative
) {
  var prefix = isNative ? 'nativeOn:' : 'on:';
  var staticHandlers = "";
  var dynamicHandlers = "";
  for (var name in events) {
    var handlerCode = genHandler(events[name]);
    if (events[name] && events[name].dynamic) {
      dynamicHandlers += name + "," + handlerCode + ",";
    } else {
      staticHandlers += "\"" + name + "\":" + handlerCode + ",";
    }
  }
  staticHandlers = "{" + (staticHandlers.slice(0, -1)) + "}";
  if (dynamicHandlers) {
    return prefix + "_d(" + staticHandlers + ",[" + (dynamicHandlers.slice(0, -1)) + "])"
  } else {
    return prefix + staticHandlers
  }
}

function genHandler (handler) {
  if (!handler) {
    return 'function(){}'
  }

  if (Array.isArray(handler)) {
    return ("[" + (handler.map(function (handler) { return genHandler(handler); }).join(',')) + "]")
  }

  var isMethodPath = simplePathRE.test(handler.value);
  var isFunctionExpression = fnExpRE.test(handler.value);
  var isFunctionInvocation = simplePathRE.test(handler.value.replace(fnInvokeRE, ''));

  if (!handler.modifiers) {
    if (isMethodPath || isFunctionExpression) {
      return handler.value
    }
    return ("function($event){" + (isFunctionInvocation ? ("return " + (handler.value)) : handler.value) + "}") // inline statement
  } else {
    var code = '';
    var genModifierCode = '';
    var keys = [];
    for (var key in handler.modifiers) {
      if (modifierCode[key]) {
        genModifierCode += modifierCode[key];
        // left/right
        if (keyCodes[key]) {
          keys.push(key);
        }
      } else if (key === 'exact') {
        var modifiers = (handler.modifiers);
        genModifierCode += genGuard(
          ['ctrl', 'shift', 'alt', 'meta']
            .filter(function (keyModifier) { return !modifiers[keyModifier]; })
            .map(function (keyModifier) { return ("$event." + keyModifier + "Key"); })
            .join('||')
        );
      } else {
        keys.push(key);
      }
    }
    if (keys.length) {
      code += genKeyFilter(keys);
    }
    // Make sure modifiers like prevent and stop get executed after key filtering
    if (genModifierCode) {
      code += genModifierCode;
    }
    var handlerCode = isMethodPath
      ? ("return " + (handler.value) + "($event)")
      : isFunctionExpression
        ? ("return (" + (handler.value) + ")($event)")
        : isFunctionInvocation
          ? ("return " + (handler.value))
          : handler.value;
    return ("function($event){" + code + handlerCode + "}")
  }
}

function genKeyFilter (keys) {
  return (
    // make sure the key filters only apply to KeyboardEvents
    // #9441: can't use 'keyCode' in $event because Chrome autofill fires fake
    // key events that do not have keyCode property...
    "if(!$event.type.indexOf('key')&&" +
    (keys.map(genFilterCode).join('&&')) + ")return null;"
  )
}

function genFilterCode (key) {
  var keyVal = parseInt(key, 10);
  if (keyVal) {
    return ("$event.keyCode!==" + keyVal)
  }
  var keyCode = keyCodes[key];
  var keyName = keyNames[key];
  return (
    "_k($event.keyCode," +
    (JSON.stringify(key)) + "," +
    (JSON.stringify(keyCode)) + "," +
    "$event.key," +
    "" + (JSON.stringify(keyName)) +
    ")"
  )
}

/*  */

function on (el, dir) {
  if (dir.modifiers) {
    warn("v-on without argument does not support modifiers.");
  }
  el.wrapListeners = function (code) { return ("_g(" + code + "," + (dir.value) + ")"); };
}

/*  */

function bind$1 (el, dir) {
  el.wrapData = function (code) {
    return ("_b(" + code + ",'" + (el.tag) + "'," + (dir.value) + "," + (dir.modifiers && dir.modifiers.prop ? 'true' : 'false') + (dir.modifiers && dir.modifiers.sync ? ',true' : '') + ")")
  };
}

/*  */

var baseDirectives = {
  on: on,
  bind: bind$1,
  cloak: noop
};

/*  */





var CodegenState = function CodegenState (options) {
  this.options = options;
  this.warn = options.warn || baseWarn;
  this.transforms = pluckModuleFunction(options.modules, 'transformCode');
  this.dataGenFns = pluckModuleFunction(options.modules, 'genData');
  this.directives = extend(extend({}, baseDirectives), options.directives);
  var isReservedTag = options.isReservedTag || no;
  this.maybeComponent = function (el) { return !!el.component || !isReservedTag(el.tag); };
  this.onceId = 0;
  this.staticRenderFns = [];
  this.pre = false;
};



function generate (
  ast,
  options
) {
  var state = new CodegenState(options);
  var code = ast ? genElement(ast, state) : '_c("div")';
  return {
    render: ("with(this){return " + code + "}"),
    staticRenderFns: state.staticRenderFns
  }
}

function genElement (el, state) {
  if (el.parent) {
    el.pre = el.pre || el.parent.pre;
  }

  if (el.staticRoot && !el.staticProcessed) {
    return genStatic(el, state)
  } else if (el.once && !el.onceProcessed) {
    return genOnce(el, state)
  } else if (el.for && !el.forProcessed) {
    return genFor(el, state)
  } else if (el.if && !el.ifProcessed) {
    return genIf(el, state)
  } else if (el.tag === 'template' && !el.slotTarget && !state.pre) {
    return genChildren(el, state) || 'void 0'
  } else if (el.tag === 'slot') {
    return genSlot(el, state)
  } else {
    // component or element
    var code;
    if (el.component) {
      code = genComponent(el.component, el, state);
    } else {
      var data;
      if (!el.plain || (el.pre && state.maybeComponent(el))) {
        data = genData$2(el, state);
      }

      var children = el.inlineTemplate ? null : genChildren(el, state, true);
      code = "_c('" + (el.tag) + "'" + (data ? ("," + data) : '') + (children ? ("," + children) : '') + ")";
    }
    // module transforms
    for (var i = 0; i < state.transforms.length; i++) {
      code = state.transforms[i](el, code);
    }
    return code
  }
}

// hoist static sub-trees out
function genStatic (el, state) {
  el.staticProcessed = true;
  // Some elements (templates) need to behave differently inside of a v-pre
  // node.  All pre nodes are static roots, so we can use this as a location to
  // wrap a state change and reset it upon exiting the pre node.
  var originalPreState = state.pre;
  if (el.pre) {
    state.pre = el.pre;
  }
  state.staticRenderFns.push(("with(this){return " + (genElement(el, state)) + "}"));
  state.pre = originalPreState;
  return ("_m(" + (state.staticRenderFns.length - 1) + (el.staticInFor ? ',true' : '') + ")")
}

// v-once
function genOnce (el, state) {
  el.onceProcessed = true;
  if (el.if && !el.ifProcessed) {
    return genIf(el, state)
  } else if (el.staticInFor) {
    var key = '';
    var parent = el.parent;
    while (parent) {
      if (parent.for) {
        key = parent.key;
        break
      }
      parent = parent.parent;
    }
    if (!key) {
      state.warn(
        "v-once can only be used inside v-for that is keyed. ",
        el.rawAttrsMap['v-once']
      );
      return genElement(el, state)
    }
    return ("_o(" + (genElement(el, state)) + "," + (state.onceId++) + "," + key + ")")
  } else {
    return genStatic(el, state)
  }
}

function genIf (
  el,
  state,
  altGen,
  altEmpty
) {
  el.ifProcessed = true; // avoid recursion
  return genIfConditions(el.ifConditions.slice(), state, altGen, altEmpty)
}

function genIfConditions (
  conditions,
  state,
  altGen,
  altEmpty
) {
  if (!conditions.length) {
    return altEmpty || '_e()'
  }

  var condition = conditions.shift();
  if (condition.exp) {
    return ("(" + (condition.exp) + ")?" + (genTernaryExp(condition.block)) + ":" + (genIfConditions(conditions, state, altGen, altEmpty)))
  } else {
    return ("" + (genTernaryExp(condition.block)))
  }

  // v-if with v-once should generate code like (a)?_m(0):_m(1)
  function genTernaryExp (el) {
    return altGen
      ? altGen(el, state)
      : el.once
        ? genOnce(el, state)
        : genElement(el, state)
  }
}

function genFor (
  el,
  state,
  altGen,
  altHelper
) {
  var exp = el.for;
  var alias = el.alias;
  var iterator1 = el.iterator1 ? ("," + (el.iterator1)) : '';
  var iterator2 = el.iterator2 ? ("," + (el.iterator2)) : '';

  if (state.maybeComponent(el) &&
    el.tag !== 'slot' &&
    el.tag !== 'template' &&
    !el.key
  ) {
    state.warn(
      "<" + (el.tag) + " v-for=\"" + alias + " in " + exp + "\">: component lists rendered with " +
      "v-for should have explicit keys. " +
      "See https://vuejs.org/guide/list.html#key for more info.",
      el.rawAttrsMap['v-for'],
      true /* tip */
    );
  }

  el.forProcessed = true; // avoid recursion
  return (altHelper || '_l') + "((" + exp + ")," +
    "function(" + alias + iterator1 + iterator2 + "){" +
      "return " + ((altGen || genElement)(el, state)) +
    '})'
}

function genData$2 (el, state) {
  var data = '{';

  // directives first.
  // directives may mutate the el's other properties before they are generated.
  var dirs = genDirectives(el, state);
  if (dirs) { data += dirs + ','; }

  // key
  if (el.key) {
    data += "key:" + (el.key) + ",";
  }
  // ref
  if (el.ref) {
    data += "ref:" + (el.ref) + ",";
  }
  if (el.refInFor) {
    data += "refInFor:true,";
  }
  // pre
  if (el.pre) {
    data += "pre:true,";
  }
  // record original tag name for components using "is" attribute
  if (el.component) {
    data += "tag:\"" + (el.tag) + "\",";
  }
  // module data generation functions
  for (var i = 0; i < state.dataGenFns.length; i++) {
    data += state.dataGenFns[i](el);
  }
  // attributes
  if (el.attrs) {
    data += "attrs:" + (genProps(el.attrs)) + ",";
  }
  // DOM props
  if (el.props) {
    data += "domProps:" + (genProps(el.props)) + ",";
  }
  // event handlers
  if (el.events) {
    data += (genHandlers(el.events, false)) + ",";
  }
  if (el.nativeEvents) {
    data += (genHandlers(el.nativeEvents, true)) + ",";
  }
  // slot target
  // only for non-scoped slots
  if (el.slotTarget && !el.slotScope) {
    data += "slot:" + (el.slotTarget) + ",";
  }
  // scoped slots
  if (el.scopedSlots) {
    data += (genScopedSlots(el, el.scopedSlots, state)) + ",";
  }
  // component v-model
  if (el.model) {
    data += "model:{value:" + (el.model.value) + ",callback:" + (el.model.callback) + ",expression:" + (el.model.expression) + "},";
  }
  // inline-template
  if (el.inlineTemplate) {
    var inlineTemplate = genInlineTemplate(el, state);
    if (inlineTemplate) {
      data += inlineTemplate + ",";
    }
  }
  data = data.replace(/,$/, '') + '}';
  // v-bind dynamic argument wrap
  // v-bind with dynamic arguments must be applied using the same v-bind object
  // merge helper so that class/style/mustUseProp attrs are handled correctly.
  if (el.dynamicAttrs) {
    data = "_b(" + data + ",\"" + (el.tag) + "\"," + (genProps(el.dynamicAttrs)) + ")";
  }
  // v-bind data wrap
  if (el.wrapData) {
    data = el.wrapData(data);
  }
  // v-on data wrap
  if (el.wrapListeners) {
    data = el.wrapListeners(data);
  }
  return data
}

function genDirectives (el, state) {
  var dirs = el.directives;
  if (!dirs) { return }
  var res = 'directives:[';
  var hasRuntime = false;
  var i, l, dir, needRuntime;
  for (i = 0, l = dirs.length; i < l; i++) {
    dir = dirs[i];
    needRuntime = true;
    var gen = state.directives[dir.name];
    if (gen) {
      // compile-time directive that manipulates AST.
      // returns true if it also needs a runtime counterpart.
      needRuntime = !!gen(el, dir, state.warn);
    }
    if (needRuntime) {
      hasRuntime = true;
      res += "{name:\"" + (dir.name) + "\",rawName:\"" + (dir.rawName) + "\"" + (dir.value ? (",value:(" + (dir.value) + "),expression:" + (JSON.stringify(dir.value))) : '') + (dir.arg ? (",arg:" + (dir.isDynamicArg ? dir.arg : ("\"" + (dir.arg) + "\""))) : '') + (dir.modifiers ? (",modifiers:" + (JSON.stringify(dir.modifiers))) : '') + "},";
    }
  }
  if (hasRuntime) {
    return res.slice(0, -1) + ']'
  }
}

function genInlineTemplate (el, state) {
  var ast = el.children[0];
  if (el.children.length !== 1 || ast.type !== 1) {
    state.warn(
      'Inline-template components must have exactly one child element.',
      { start: el.start }
    );
  }
  if (ast && ast.type === 1) {
    var inlineRenderFns = generate(ast, state.options);
    return ("inlineTemplate:{render:function(){" + (inlineRenderFns.render) + "},staticRenderFns:[" + (inlineRenderFns.staticRenderFns.map(function (code) { return ("function(){" + code + "}"); }).join(',')) + "]}")
  }
}

function genScopedSlots (
  el,
  slots,
  state
) {
  // by default scoped slots are considered "stable", this allows child
  // components with only scoped slots to skip forced updates from parent.
  // but in some cases we have to bail-out of this optimization
  // for example if the slot contains dynamic names, has v-if or v-for on them...
  var needsForceUpdate = el.for || Object.keys(slots).some(function (key) {
    var slot = slots[key];
    return (
      slot.slotTargetDynamic ||
      slot.if ||
      slot.for ||
      containsSlotChild(slot) // is passing down slot from parent which may be dynamic
    )
  });

  // #9534: if a component with scoped slots is inside a conditional branch,
  // it's possible for the same component to be reused but with different
  // compiled slot content. To avoid that, we generate a unique key based on
  // the generated code of all the slot contents.
  var needsKey = !!el.if;

  // OR when it is inside another scoped slot or v-for (the reactivity may be
  // disconnected due to the intermediate scope variable)
  // #9438, #9506
  // TODO: this can be further optimized by properly analyzing in-scope bindings
  // and skip force updating ones that do not actually use scope variables.
  if (!needsForceUpdate) {
    var parent = el.parent;
    while (parent) {
      if (
        (parent.slotScope && parent.slotScope !== emptySlotScopeToken) ||
        parent.for
      ) {
        needsForceUpdate = true;
        break
      }
      if (parent.if) {
        needsKey = true;
      }
      parent = parent.parent;
    }
  }

  var generatedSlots = Object.keys(slots)
    .map(function (key) { return genScopedSlot(slots[key], state); })
    .join(',');

  return ("scopedSlots:_u([" + generatedSlots + "]" + (needsForceUpdate ? ",null,true" : "") + (!needsForceUpdate && needsKey ? (",null,false," + (hash(generatedSlots))) : "") + ")")
}

function hash(str) {
  var hash = 5381;
  var i = str.length;
  while(i) {
    hash = (hash * 33) ^ str.charCodeAt(--i);
  }
  return hash >>> 0
}

function containsSlotChild (el) {
  if (el.type === 1) {
    if (el.tag === 'slot') {
      return true
    }
    return el.children.some(containsSlotChild)
  }
  return false
}

function genScopedSlot (
  el,
  state
) {
  var isLegacySyntax = el.attrsMap['slot-scope'];
  if (el.if && !el.ifProcessed && !isLegacySyntax) {
    return genIf(el, state, genScopedSlot, "null")
  }
  if (el.for && !el.forProcessed) {
    return genFor(el, state, genScopedSlot)
  }
  var slotScope = el.slotScope === emptySlotScopeToken
    ? ""
    : String(el.slotScope);
  var fn = "function(" + slotScope + "){" +
    "return " + (el.tag === 'template'
      ? el.if && isLegacySyntax
        ? ("(" + (el.if) + ")?" + (genChildren(el, state) || 'undefined') + ":undefined")
        : genChildren(el, state) || 'undefined'
      : genElement(el, state)) + "}";
  // reverse proxy v-slot without scope on this.$slots
  var reverseProxy = slotScope ? "" : ",proxy:true";
  return ("{key:" + (el.slotTarget || "\"default\"") + ",fn:" + fn + reverseProxy + "}")
}

function genChildren (
  el,
  state,
  checkSkip,
  altGenElement,
  altGenNode
) {
  var children = el.children;
  if (children.length) {
    var el$1 = children[0];
    // optimize single v-for
    if (children.length === 1 &&
      el$1.for &&
      el$1.tag !== 'template' &&
      el$1.tag !== 'slot'
    ) {
      var normalizationType = checkSkip
        ? state.maybeComponent(el$1) ? ",1" : ",0"
        : "";
      return ("" + ((altGenElement || genElement)(el$1, state)) + normalizationType)
    }
    var normalizationType$1 = checkSkip
      ? getNormalizationType(children, state.maybeComponent)
      : 0;
    var gen = altGenNode || genNode;
    return ("[" + (children.map(function (c) { return gen(c, state); }).join(',')) + "]" + (normalizationType$1 ? ("," + normalizationType$1) : ''))
  }
}

// determine the normalization needed for the children array.
// 0: no normalization needed
// 1: simple normalization needed (possible 1-level deep nested array)
// 2: full normalization needed
function getNormalizationType (
  children,
  maybeComponent
) {
  var res = 0;
  for (var i = 0; i < children.length; i++) {
    var el = children[i];
    if (el.type !== 1) {
      continue
    }
    if (needsNormalization(el) ||
        (el.ifConditions && el.ifConditions.some(function (c) { return needsNormalization(c.block); }))) {
      res = 2;
      break
    }
    if (maybeComponent(el) ||
        (el.ifConditions && el.ifConditions.some(function (c) { return maybeComponent(c.block); }))) {
      res = 1;
    }
  }
  return res
}

function needsNormalization (el) {
  return el.for !== undefined || el.tag === 'template' || el.tag === 'slot'
}

function genNode (node, state) {
  if (node.type === 1) {
    return genElement(node, state)
  } else if (node.type === 3 && node.isComment) {
    return genComment(node)
  } else {
    return genText(node)
  }
}

function genText (text) {
  return ("_v(" + (text.type === 2
    ? text.expression // no need for () because already wrapped in _s()
    : transformSpecialNewlines(JSON.stringify(text.text))) + ")")
}

function genComment (comment) {
  return ("_e(" + (JSON.stringify(comment.text)) + ")")
}

function genSlot (el, state) {
  var slotName = el.slotName || '"default"';
  var children = genChildren(el, state);
  var res = "_t(" + slotName + (children ? ("," + children) : '');
  var attrs = el.attrs || el.dynamicAttrs
    ? genProps((el.attrs || []).concat(el.dynamicAttrs || []).map(function (attr) { return ({
        // slot props are camelized
        name: camelize(attr.name),
        value: attr.value,
        dynamic: attr.dynamic
      }); }))
    : null;
  var bind$$1 = el.attrsMap['v-bind'];
  if ((attrs || bind$$1) && !children) {
    res += ",null";
  }
  if (attrs) {
    res += "," + attrs;
  }
  if (bind$$1) {
    res += (attrs ? '' : ',null') + "," + bind$$1;
  }
  return res + ')'
}

// componentName is el.component, take it as argument to shun flow's pessimistic refinement
function genComponent (
  componentName,
  el,
  state
) {
  var children = el.inlineTemplate ? null : genChildren(el, state, true);
  return ("_c(" + componentName + "," + (genData$2(el, state)) + (children ? ("," + children) : '') + ")")
}

function genProps (props) {
  var staticProps = "";
  var dynamicProps = "";
  for (var i = 0; i < props.length; i++) {
    var prop = props[i];
    var value = transformSpecialNewlines(prop.value);
    if (prop.dynamic) {
      dynamicProps += (prop.name) + "," + value + ",";
    } else {
      staticProps += "\"" + (prop.name) + "\":" + value + ",";
    }
  }
  staticProps = "{" + (staticProps.slice(0, -1)) + "}";
  if (dynamicProps) {
    return ("_d(" + staticProps + ",[" + (dynamicProps.slice(0, -1)) + "])")
  } else {
    return staticProps
  }
}

// #3895, #4268
function transformSpecialNewlines (text) {
  return text
    .replace(/\u2028/g, '\\u2028')
    .replace(/\u2029/g, '\\u2029')
}

/*  */



// these keywords should not appear inside expressions, but operators like
// typeof, instanceof and in are allowed
var prohibitedKeywordRE = new RegExp('\\b' + (
  'do,if,for,let,new,try,var,case,else,with,await,break,catch,class,const,' +
  'super,throw,while,yield,delete,export,import,return,switch,default,' +
  'extends,finally,continue,debugger,function,arguments'
).split(',').join('\\b|\\b') + '\\b');

// these unary operators should not be used as property/method names
var unaryOperatorsRE = new RegExp('\\b' + (
  'delete,typeof,void'
).split(',').join('\\s*\\([^\\)]*\\)|\\b') + '\\s*\\([^\\)]*\\)');

// strip strings in expressions
var stripStringRE = /'(?:[^'\\]|\\.)*'|"(?:[^"\\]|\\.)*"|`(?:[^`\\]|\\.)*\$\{|\}(?:[^`\\]|\\.)*`|`(?:[^`\\]|\\.)*`/g;

// detect problematic expressions in a template
function detectErrors (ast, warn) {
  if (ast) {
    checkNode(ast, warn);
  }
}

function checkNode (node, warn) {
  if (node.type === 1) {
    for (var name in node.attrsMap) {
      if (dirRE.test(name)) {
        var value = node.attrsMap[name];
        if (value) {
          var range = node.rawAttrsMap[name];
          if (name === 'v-for') {
            checkFor(node, ("v-for=\"" + value + "\""), warn, range);
          } else if (name === 'v-slot' || name[0] === '#') {
            checkFunctionParameterExpression(value, (name + "=\"" + value + "\""), warn, range);
          } else if (onRE.test(name)) {
            checkEvent(value, (name + "=\"" + value + "\""), warn, range);
          } else {
            checkExpression(value, (name + "=\"" + value + "\""), warn, range);
          }
        }
      }
    }
    if (node.children) {
      for (var i = 0; i < node.children.length; i++) {
        checkNode(node.children[i], warn);
      }
    }
  } else if (node.type === 2) {
    checkExpression(node.expression, node.text, warn, node);
  }
}

function checkEvent (exp, text, warn, range) {
  var stripped = exp.replace(stripStringRE, '');
  var keywordMatch = stripped.match(unaryOperatorsRE);
  if (keywordMatch && stripped.charAt(keywordMatch.index - 1) !== '$') {
    warn(
      "avoid using JavaScript unary operator as property name: " +
      "\"" + (keywordMatch[0]) + "\" in expression " + (text.trim()),
      range
    );
  }
  checkExpression(exp, text, warn, range);
}

function checkFor (node, text, warn, range) {
  checkExpression(node.for || '', text, warn, range);
  checkIdentifier(node.alias, 'v-for alias', text, warn, range);
  checkIdentifier(node.iterator1, 'v-for iterator', text, warn, range);
  checkIdentifier(node.iterator2, 'v-for iterator', text, warn, range);
}

function checkIdentifier (
  ident,
  type,
  text,
  warn,
  range
) {
  if (typeof ident === 'string') {
    try {
      new Function(("var " + ident + "=_"));
    } catch (e) {
      warn(("invalid " + type + " \"" + ident + "\" in expression: " + (text.trim())), range);
    }
  }
}

function checkExpression (exp, text, warn, range) {
  try {
    new Function(("return " + exp));
  } catch (e) {
    var keywordMatch = exp.replace(stripStringRE, '').match(prohibitedKeywordRE);
    if (keywordMatch) {
      warn(
        "avoid using JavaScript keyword as property name: " +
        "\"" + (keywordMatch[0]) + "\"\n  Raw expression: " + (text.trim()),
        range
      );
    } else {
      warn(
        "invalid expression: " + (e.message) + " in\n\n" +
        "    " + exp + "\n\n" +
        "  Raw expression: " + (text.trim()) + "\n",
        range
      );
    }
  }
}

function checkFunctionParameterExpression (exp, text, warn, range) {
  try {
    new Function(exp, '');
  } catch (e) {
    warn(
      "invalid function parameter expression: " + (e.message) + " in\n\n" +
      "    " + exp + "\n\n" +
      "  Raw expression: " + (text.trim()) + "\n",
      range
    );
  }
}

/*  */

var range = 2;

function generateCodeFrame (
  source,
  start,
  end
) {
  if ( start === void 0 ) start = 0;
  if ( end === void 0 ) end = source.length;

  var lines = source.split(/\r?\n/);
  var count = 0;
  var res = [];
  for (var i = 0; i < lines.length; i++) {
    count += lines[i].length + 1;
    if (count >= start) {
      for (var j = i - range; j <= i + range || end > count; j++) {
        if (j < 0 || j >= lines.length) { continue }
        res.push(("" + (j + 1) + (repeat$1(" ", 3 - String(j + 1).length)) + "|  " + (lines[j])));
        var lineLength = lines[j].length;
        if (j === i) {
          // push underline
          var pad = start - (count - lineLength) + 1;
          var length = end > count ? lineLength - pad : end - start;
          res.push("   |  " + repeat$1(" ", pad) + repeat$1("^", length));
        } else if (j > i) {
          if (end > count) {
            var length$1 = Math.min(end - count, lineLength);
            res.push("   |  " + repeat$1("^", length$1));
          }
          count += lineLength + 1;
        }
      }
      break
    }
  }
  return res.join('\n')
}

function repeat$1 (str, n) {
  var result = '';
  if (n > 0) {
    while (true) { // eslint-disable-line
      if (n & 1) { result += str; }
      n >>>= 1;
      if (n <= 0) { break }
      str += str;
    }
  }
  return result
}

/*  */



function createFunction (code, errors) {
  try {
    return new Function(code)
  } catch (err) {
    errors.push({ err: err, code: code });
    return noop
  }
}

function createCompileToFunctionFn (compile) {
  var cache = Object.create(null);

  return function compileToFunctions (
    template,
    options,
    vm
  ) {
    options = extend({}, options);
    var warn$$1 = options.warn || warn;
    delete options.warn;

    /* istanbul ignore if */
    {
      // detect possible CSP restriction
      try {
        new Function('return 1');
      } catch (e) {
        if (e.toString().match(/unsafe-eval|CSP/)) {
          warn$$1(
            'It seems you are using the standalone build of Vue.js in an ' +
            'environment with Content Security Policy that prohibits unsafe-eval. ' +
            'The template compiler cannot work in this environment. Consider ' +
            'relaxing the policy to allow unsafe-eval or pre-compiling your ' +
            'templates into render functions.'
          );
        }
      }
    }

    // check cache
    var key = options.delimiters
      ? String(options.delimiters) + template
      : template;
    if (cache[key]) {
      return cache[key]
    }

    // compile
    var compiled = compile(template, options);

    // check compilation errors/tips
    {
      if (compiled.errors && compiled.errors.length) {
        if (options.outputSourceRange) {
          compiled.errors.forEach(function (e) {
            warn$$1(
              "Error compiling template:\n\n" + (e.msg) + "\n\n" +
              generateCodeFrame(template, e.start, e.end),
              vm
            );
          });
        } else {
          warn$$1(
            "Error compiling template:\n\n" + template + "\n\n" +
            compiled.errors.map(function (e) { return ("- " + e); }).join('\n') + '\n',
            vm
          );
        }
      }
      if (compiled.tips && compiled.tips.length) {
        if (options.outputSourceRange) {
          compiled.tips.forEach(function (e) { return tip(e.msg, vm); });
        } else {
          compiled.tips.forEach(function (msg) { return tip(msg, vm); });
        }
      }
    }

    // turn code into functions
    var res = {};
    var fnGenErrors = [];
    res.render = createFunction(compiled.render, fnGenErrors);
    res.staticRenderFns = compiled.staticRenderFns.map(function (code) {
      return createFunction(code, fnGenErrors)
    });

    // check function generation errors.
    // this should only happen if there is a bug in the compiler itself.
    // mostly for codegen development use
    /* istanbul ignore if */
    {
      if ((!compiled.errors || !compiled.errors.length) && fnGenErrors.length) {
        warn$$1(
          "Failed to generate render function:\n\n" +
          fnGenErrors.map(function (ref) {
            var err = ref.err;
            var code = ref.code;

            return ((err.toString()) + " in\n\n" + code + "\n");
        }).join('\n'),
          vm
        );
      }
    }

    return (cache[key] = res)
  }
}

/*  */

function createCompilerCreator (baseCompile) {
  return function createCompiler (baseOptions) {
    function compile (
      template,
      options
    ) {
      var finalOptions = Object.create(baseOptions);
      var errors = [];
      var tips = [];

      var warn = function (msg, range, tip) {
        (tip ? tips : errors).push(msg);
      };

      if (options) {
        if (options.outputSourceRange) {
          // $flow-disable-line
          var leadingSpaceLength = template.match(/^\s*/)[0].length;

          warn = function (msg, range, tip) {
            var data = { msg: msg };
            if (range) {
              if (range.start != null) {
                data.start = range.start + leadingSpaceLength;
              }
              if (range.end != null) {
                data.end = range.end + leadingSpaceLength;
              }
            }
            (tip ? tips : errors).push(data);
          };
        }
        // merge custom modules
        if (options.modules) {
          finalOptions.modules =
            (baseOptions.modules || []).concat(options.modules);
        }
        // merge custom directives
        if (options.directives) {
          finalOptions.directives = extend(
            Object.create(baseOptions.directives || null),
            options.directives
          );
        }
        // copy other options
        for (var key in options) {
          if (key !== 'modules' && key !== 'directives') {
            finalOptions[key] = options[key];
          }
        }
      }

      finalOptions.warn = warn;

      var compiled = baseCompile(template.trim(), finalOptions);
      {
        detectErrors(compiled.ast, warn);
      }
      compiled.errors = errors;
      compiled.tips = tips;
      return compiled
    }

    return {
      compile: compile,
      compileToFunctions: createCompileToFunctionFn(compile)
    }
  }
}

/*  */

// `createCompilerCreator` allows creating compilers that use alternative
// parser/optimizer/codegen, e.g the SSR optimizing compiler.
// Here we just export a default compiler using the default parts.
var createCompiler = createCompilerCreator(function baseCompile (
  template,
  options
) {
  var ast = parse(template.trim(), options);
  if (options.optimize !== false) {
    optimize(ast, options);
  }
  var code = generate(ast, options);
  return {
    ast: ast,
    render: code.render,
    staticRenderFns: code.staticRenderFns
  }
});

/*  */

var ref$1 = createCompiler(baseOptions);
var compile = ref$1.compile;
var compileToFunctions = ref$1.compileToFunctions;

/*  */

// check whether current browser encodes a char inside attribute values
var div;
function getShouldDecode (href) {
  div = div || document.createElement('div');
  div.innerHTML = href ? "<a href=\"\n\"/>" : "<div a=\"\n\"/>";
  return div.innerHTML.indexOf('&#10;') > 0
}

// #3663: IE encodes newlines inside attribute values while other browsers don't
var shouldDecodeNewlines = inBrowser ? getShouldDecode(false) : false;
// #6828: chrome encodes content in a[href]
var shouldDecodeNewlinesForHref = inBrowser ? getShouldDecode(true) : false;

/*  */

var idToTemplate = cached(function (id) {
  var el = query(id);
  return el && el.innerHTML
});

var mount = Vue.prototype.$mount;
Vue.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && query(el);

  /* istanbul ignore if */
  if (el === document.body || el === document.documentElement) {
    warn(
      "Do not mount Vue to <html> or <body> - mount to normal elements instead."
    );
    return this
  }

  var options = this.$options;
  // resolve template/el and convert to render function
  if (!options.render) {
    var template = options.template;
    if (template) {
      if (typeof template === 'string') {
        if (template.charAt(0) === '#') {
          template = idToTemplate(template);
          /* istanbul ignore if */
          if (!template) {
            warn(
              ("Template element not found or is empty: " + (options.template)),
              this
            );
          }
        }
      } else if (template.nodeType) {
        template = template.innerHTML;
      } else {
        {
          warn('invalid template option:' + template, this);
        }
        return this
      }
    } else if (el) {
      template = getOuterHTML(el);
    }
    if (template) {
      /* istanbul ignore if */
      if (config.performance && mark) {
        mark('compile');
      }

      var ref = compileToFunctions(template, {
        outputSourceRange: "development" !== 'production',
        shouldDecodeNewlines: shouldDecodeNewlines,
        shouldDecodeNewlinesForHref: shouldDecodeNewlinesForHref,
        delimiters: options.delimiters,
        comments: options.comments
      }, this);
      var render = ref.render;
      var staticRenderFns = ref.staticRenderFns;
      options.render = render;
      options.staticRenderFns = staticRenderFns;

      /* istanbul ignore if */
      if (config.performance && mark) {
        mark('compile end');
        measure(("vue " + (this._name) + " compile"), 'compile', 'compile end');
      }
    }
  }
  return mount.call(this, el, hydrating)
};

/**
 * Get outerHTML of elements, taking care
 * of SVG elements in IE as well.
 */
function getOuterHTML (el) {
  if (el.outerHTML) {
    return el.outerHTML
  } else {
    var container = document.createElement('div');
    container.appendChild(el.cloneNode(true));
    return container.innerHTML
  }
}

Vue.compile = compileToFunctions;

module.exports = Vue;

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js"), __webpack_require__(/*! ./../../node-libs-browser/node_modules/timers-browserify/main.js */ "./node_modules/node-libs-browser/node_modules/timers-browserify/main.js").setImmediate))

/***/ }),

/***/ "./node_modules/vue/dist/vue.common.js":
/*!*********************************************!*\
  !*** ./node_modules/vue/dist/vue.common.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

if (false) {} else {
  module.exports = __webpack_require__(/*! ./vue.common.dev.js */ "./node_modules/vue/dist/vue.common.dev.js")
}


/***/ }),

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || new Function("return this")();
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),

/***/ "./resources/assets/js/abilities.js":
/*!******************************************!*\
  !*** ./resources/assets/js/abilities.js ***!
  \******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_abilities_Abilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/abilities/Abilities */ "./resources/assets/js/components/abilities/Abilities.vue");
/* harmony import */ var _components_abilities_Ability__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/abilities/Ability */ "./resources/assets/js/components/abilities/Ability.vue");
/* harmony import */ var _components_abilities_Parent__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/abilities/Parent */ "./resources/assets/js/components/abilities/Parent.vue");
/* harmony import */ var _components_abilities_AbilityForm__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/abilities/AbilityForm */ "./resources/assets/js/components/abilities/AbilityForm.vue");
/* harmony import */ var vue_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vue-i18n */ "./node_modules/vue-i18n/dist/vue-i18n.esm.js");
/* harmony import */ var _vue_i18n_locales_generated__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./vue-i18n-locales.generated */ "./resources/assets/js/vue-i18n-locales.generated.js");
/* harmony import */ var uiv__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! uiv */ "./node_modules/uiv/dist/uiv.esm.js");







window.Vue = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
Vue.component('abilities', _components_abilities_Abilities__WEBPACK_IMPORTED_MODULE_0__["default"]);
Vue.component('ability', _components_abilities_Ability__WEBPACK_IMPORTED_MODULE_1__["default"]);
Vue.component('ability_form', _components_abilities_AbilityForm__WEBPACK_IMPORTED_MODULE_3__["default"]);
Vue.component('parent', _components_abilities_Parent__WEBPACK_IMPORTED_MODULE_2__["default"]); // Boostrap

Vue.use(uiv__WEBPACK_IMPORTED_MODULE_6__); // Translations

Vue.use(vue_i18n__WEBPACK_IMPORTED_MODULE_4__["default"]);
var lang = document.documentElement.lang.substr(0, 2);
var i18n = new vue_i18n__WEBPACK_IMPORTED_MODULE_4__["default"]({
  locale: lang,
  fallbackLocale: 'en',
  messages: _vue_i18n_locales_generated__WEBPACK_IMPORTED_MODULE_5__["default"]
});
var app = new Vue({
  el: '#abilities',
  i18n: i18n
});

/***/ }),

/***/ "./resources/assets/js/components/abilities/Abilities.vue":
/*!****************************************************************!*\
  !*** ./resources/assets/js/components/abilities/Abilities.vue ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Abilities_vue_vue_type_template_id_2cd6794c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Abilities.vue?vue&type=template&id=2cd6794c& */ "./resources/assets/js/components/abilities/Abilities.vue?vue&type=template&id=2cd6794c&");
/* harmony import */ var _Abilities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Abilities.vue?vue&type=script&lang=js& */ "./resources/assets/js/components/abilities/Abilities.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Abilities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Abilities_vue_vue_type_template_id_2cd6794c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Abilities_vue_vue_type_template_id_2cd6794c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/components/abilities/Abilities.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/js/components/abilities/Abilities.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/assets/js/components/abilities/Abilities.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Abilities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Abilities.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Abilities.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Abilities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/assets/js/components/abilities/Abilities.vue?vue&type=template&id=2cd6794c&":
/*!***********************************************************************************************!*\
  !*** ./resources/assets/js/components/abilities/Abilities.vue?vue&type=template&id=2cd6794c& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Abilities_vue_vue_type_template_id_2cd6794c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Abilities.vue?vue&type=template&id=2cd6794c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Abilities.vue?vue&type=template&id=2cd6794c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Abilities_vue_vue_type_template_id_2cd6794c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Abilities_vue_vue_type_template_id_2cd6794c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/assets/js/components/abilities/Ability.vue":
/*!**************************************************************!*\
  !*** ./resources/assets/js/components/abilities/Ability.vue ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Ability_vue_vue_type_template_id_28b7eabc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Ability.vue?vue&type=template&id=28b7eabc& */ "./resources/assets/js/components/abilities/Ability.vue?vue&type=template&id=28b7eabc&");
/* harmony import */ var _Ability_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Ability.vue?vue&type=script&lang=js& */ "./resources/assets/js/components/abilities/Ability.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Ability_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Ability_vue_vue_type_template_id_28b7eabc___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Ability_vue_vue_type_template_id_28b7eabc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/components/abilities/Ability.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/js/components/abilities/Ability.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./resources/assets/js/components/abilities/Ability.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Ability_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Ability.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Ability.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Ability_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/assets/js/components/abilities/Ability.vue?vue&type=template&id=28b7eabc&":
/*!*********************************************************************************************!*\
  !*** ./resources/assets/js/components/abilities/Ability.vue?vue&type=template&id=28b7eabc& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Ability_vue_vue_type_template_id_28b7eabc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Ability.vue?vue&type=template&id=28b7eabc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Ability.vue?vue&type=template&id=28b7eabc&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Ability_vue_vue_type_template_id_28b7eabc___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Ability_vue_vue_type_template_id_28b7eabc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/assets/js/components/abilities/AbilityForm.vue":
/*!******************************************************************!*\
  !*** ./resources/assets/js/components/abilities/AbilityForm.vue ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AbilityForm_vue_vue_type_template_id_2745a7a0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AbilityForm.vue?vue&type=template&id=2745a7a0& */ "./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=template&id=2745a7a0&");
/* harmony import */ var _AbilityForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AbilityForm.vue?vue&type=script&lang=js& */ "./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AbilityForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AbilityForm_vue_vue_type_template_id_2745a7a0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _AbilityForm_vue_vue_type_template_id_2745a7a0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/components/abilities/AbilityForm.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AbilityForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./AbilityForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AbilityForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=template&id=2745a7a0&":
/*!*************************************************************************************************!*\
  !*** ./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=template&id=2745a7a0& ***!
  \*************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AbilityForm_vue_vue_type_template_id_2745a7a0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./AbilityForm.vue?vue&type=template&id=2745a7a0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/AbilityForm.vue?vue&type=template&id=2745a7a0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AbilityForm_vue_vue_type_template_id_2745a7a0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AbilityForm_vue_vue_type_template_id_2745a7a0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/assets/js/components/abilities/Parent.vue":
/*!*************************************************************!*\
  !*** ./resources/assets/js/components/abilities/Parent.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Parent_vue_vue_type_template_id_5dd571f0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Parent.vue?vue&type=template&id=5dd571f0& */ "./resources/assets/js/components/abilities/Parent.vue?vue&type=template&id=5dd571f0&");
/* harmony import */ var _Parent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Parent.vue?vue&type=script&lang=js& */ "./resources/assets/js/components/abilities/Parent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Parent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Parent_vue_vue_type_template_id_5dd571f0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Parent_vue_vue_type_template_id_5dd571f0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/components/abilities/Parent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/js/components/abilities/Parent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/assets/js/components/abilities/Parent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Parent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Parent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Parent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Parent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/assets/js/components/abilities/Parent.vue?vue&type=template&id=5dd571f0&":
/*!********************************************************************************************!*\
  !*** ./resources/assets/js/components/abilities/Parent.vue?vue&type=template&id=5dd571f0& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Parent_vue_vue_type_template_id_5dd571f0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Parent.vue?vue&type=template&id=5dd571f0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/abilities/Parent.vue?vue&type=template&id=5dd571f0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Parent_vue_vue_type_template_id_5dd571f0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Parent_vue_vue_type_template_id_5dd571f0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/assets/js/components/event.js":
/*!*************************************************!*\
  !*** ./resources/assets/js/components/event.js ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0___default.a());

/***/ }),

/***/ "./resources/assets/js/vue-i18n-locales.generated.js":
/*!***********************************************************!*\
  !*** ./resources/assets/js/vue-i18n-locales.generated.js ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  "ar": [],
  "base": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "entities": [],
    "front": [],
    "maps": [],
    "randomizers": [],
    "timelines": []
  },
  "ca": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "Crear nueva conversación",
        "success": "Conversación '{name}' creada.",
        "title": "Nueva Conversación"
      },
      "destroy": {
        "success": "Conversación '{name}' eliminada."
      },
      "edit": {
        "description": "Actualizar la conversación",
        "success": "Conversación '{name}' actualizada.",
        "title": "Conversación {name}"
      },
      "fields": {
        "messages": "Mensajes",
        "name": "Nombre",
        "participants": "Participantes",
        "target": "Objetivo",
        "type": "Tipo"
      },
      "hints": {
        "participants": "Por favor, añade participantes a la conversación."
      },
      "index": {
        "add": "Nueva Conversación",
        "description": "Gestiona las conversaciones de {name}.",
        "header": "Conversaciones en {name}",
        "title": "Conversaciones"
      },
      "messages": {
        "destroy": {
          "success": "Mensaje eliminado."
        },
        "is_updated": "Actualizado",
        "load_previous": "Cargar mensajes previos",
        "placeholders": {
          "message": "Tu mensaje"
        }
      },
      "participants": {
        "create": {
          "success": "El participante {entity} se ha añadido a la conversación."
        },
        "description": "Añadir o eliminar participantes de una conversación",
        "destroy": {
          "success": "El participante {entity} se ha eliminado de la conversación."
        },
        "modal": "Participantes",
        "title": "Participantes de {name}"
      },
      "placeholders": {
        "name": "Nombre de la conversación",
        "type": "Dentro del juego, Preparación, Argumento"
      },
      "show": {
        "description": "Vista detallada de conversación",
        "title": "Conversación {name}"
      },
      "tabs": {
        "conversation": "Conversación",
        "participants": "Participantes"
      },
      "targets": {
        "characters": "Personajes",
        "members": "Miembros"
      }
    },
    "crud": {
      "actions": {
        "actions": "Acciones",
        "apply": "Aplicar",
        "back": "Atrás",
        "copy": "Copiar",
        "copy_mention": "Copiar mención [ ]",
        "copy_to_campaign": "Copiar a campaña",
        "explore_view": "Vista anidada",
        "export": "Exportar",
        "find_out_more": "Saber más",
        "go_to": "Ir a {name}",
        "json-export": "Exportar (JSON)",
        "more": "Más acciones",
        "move": "Mover",
        "new": "Nuevo",
        "next": "Siguiente",
        "private": "Privado",
        "public": "Público",
        "reset": "Restablecer"
      },
      "add": "Añadir",
      "alerts": {
        "copy_mention": "La mención avanzada de la entidad se ha copiado a tu portapapeles."
      },
      "attributes": {
        "actions": {
          "add": "Añadir atributo",
          "add_block": "Añadir un bloque",
          "add_checkbox": "Añadir una casilla",
          "add_text": "Añadir texto",
          "apply_template": "Aplicar una plantilla de atributos",
          "manage": "Administrar",
          "remove_all": "Eliminar todos"
        },
        "create": {
          "description": "Crear nuevo atributo",
          "success": "Atributo {name} añadido a {entity}.",
          "title": "Nuevo atributo para {name}"
        },
        "destroy": {
          "success": "Atributo {name} de {entity} eliminado."
        },
        "edit": {
          "description": "Actualizar un atributo existente",
          "success": "Atributo {name} de {entity} actualizado.",
          "title": "Actualizar atributo a {name}"
        },
        "fields": {
          "attribute": "Atributo",
          "community_templates": "Plantillas de la comunidad",
          "is_private": "Atributos privados",
          "is_star": "Fijado",
          "template": "Plantilla",
          "value": "Valor"
        },
        "helpers": {
          "delete_all": "¿Seguro que quieres eliminar todos los atributos de esta entidad?"
        },
        "hints": {
          "is_private": "Puedes ocultar todos los atributos de una entidad a todos los miembros no administradores haciéndola privada."
        },
        "index": {
          "success": "Atributos de {entity} actualizados.",
          "title": "Atributos de {name}"
        },
        "placeholders": {
          "attribute": "Número de conquistas, Iniciativa, Población",
          "block": "Nombre del bloque",
          "checkbox": "Nombre de la casilla",
          "section": "Nombre de la sección",
          "template": "Seleccionar plantilla",
          "value": "Valor del atributo"
        },
        "template": {
          "success": "Plantilla de atributos {name} aplicada en {entity}",
          "title": "Aplicar plantilla de atributos a {name}"
        },
        "types": {
          "attribute": "Atributo",
          "block": "Bloque",
          "checkbox": "Casilla",
          "section": "Sección",
          "text": "Texto multilínea"
        },
        "visibility": {
          "entry": "El atributo se muestra en el menú de la entidad.",
          "private": "Atributo visible solo para miembros con el rol \"Admin\".",
          "public": "Atributo visible por todos los miembros.",
          "tab": "El atributo se muestra solo en la pestaña de Atributos."
        }
      },
      "boosted": "mejorada",
      "boosted_campaigns": "Campañas mejoradas",
      "bulk": {
        "actions": {
          "edit": "Editar y etiquetar en lote"
        },
        "age": {
          "helper": "Puedes usar + y - antes del número para actualizar la edad en dicha cantidad."
        },
        "delete": {
          "title": "Eliminar múltiples entidades",
          "warning": "¿Seguro que quieres eliminar las entidades seleccionadas?"
        },
        "edit": {
          "tagging": "Acción para las etiquetas",
          "tags": {
            "add": "Añadir",
            "remove": "Eliminar"
          },
          "title": "Editando múltiples entidades"
        },
        "errors": {
          "admin": "Solamente los administradores de la campaña pueden cambiar el estatus privado de las entidades.",
          "general": "Ha habido un error al procesar la acción. Vuelve a intentarlo o contáctanos si el problema persiste. Mensaje de error: {hint}."
        },
        "permissions": {
          "fields": {
            "override": "Ignorar"
          },
          "helpers": {
            "override": "Si está seleccionado, los permisos de las entidades seleccionadas serán ignorados y en cambio usarán estos ajustes. Si no está seleccionado, los estos permisos se añadirán a los existentes."
          },
          "title": "Cambiar permisos a varias entidades"
        },
        "success": {
          "copy_to_campaign": "{1} {count} entidad copiada a {campaign}.|[2,*] {count} entidades copiadas a {campaign}.",
          "editing": "{count} entidad se ha actualizado.|{count} entidades se han actualizado.",
          "permissions": "Permisos cambiados en {count} entidad.|Permisos cambiados en {count} entidades.",
          "private": "{count} entidad es ahora privada|{count} entidades son ahora privadas.",
          "public": "{count} entidad es ahora visible|{count} son ahora visibles."
        }
      },
      "cancel": "Cancelar",
      "click_modal": {
        "close": "Cerrar",
        "confirm": "Confirmar",
        "title": "Confirmar acción"
      },
      "copy_to_campaign": {
        "bulk_title": "Copiar entidades a otra campaña",
        "panel": "Copiar",
        "title": "Copiar '{name}' a otra campaña"
      },
      "create": "Crear",
      "datagrid": {
        "empty": "Aún no hay nada que mostrar."
      },
      "delete_modal": {
        "close": "Cerrar",
        "delete": "Eliminar",
        "description": "¿Seguro que quieres eliminar {tag}?",
        "mirrored": "Eliminar relación reflejada",
        "title": "Eliminar"
      },
      "destroy_many": {
        "success": "{count} entidad eliminada|{count} entidades eliminadas."
      },
      "edit": "Editar",
      "errors": {
        "boosted": "Esta función solo está disponible para las campañas mejoradas.",
        "node_must_not_be_a_descendant": "Nodo inválido (categoría, localización superior): sería un descendiente de sí mismo."
      },
      "events": {
        "hint": "Los eventos del calendario asociados a esta entidad se muestran aquí."
      },
      "export": "Exportar",
      "fields": {
        "ability": "Habilidad",
        "attribute_template": "Plantilla de atributos",
        "calendar": "Calendario",
        "calendar_date": "Fecha del calendario",
        "character": "Personaje",
        "colour": "Color",
        "copy_attributes": "Copiar atributos",
        "copy_notes": "Copiar notas de la entidad",
        "creator": "Creador",
        "dice_roll": "Tirada de dados",
        "entity": "Entidad",
        "entity_type": "Tipo de entidad",
        "entry": "Entrada",
        "event": "Evento",
        "excerpt": "Extracto",
        "family": "Familia",
        "files": "Archivos",
        "has_image": "Tiene imagen",
        "header_image": "Imagen de cabecera",
        "image": "Imagen",
        "is_private": "Privado",
        "is_star": "Fijada",
        "item": "Objeto",
        "location": "Localización",
        "map": "Mapa",
        "name": "Nombre",
        "organisation": "Organización",
        "position": "Posición",
        "race": "Raza",
        "tag": "Etiqueta",
        "tags": "Etiquetas",
        "timeline": "Línea de tiempo",
        "tooltip": "Descripción emergente",
        "type": "Tipo",
        "visibility": "Visibilidad"
      },
      "files": {
        "actions": {
          "drop": "Haz clic para añadir o arrastra un archivo",
          "manage": "Administrar archivos de la entidad"
        },
        "errors": {
          "max": "Has alcanzado el número máximo ({max}) de archivos para esta entidad.",
          "no_files": "No hay archivos."
        },
        "files": "Archivos subidos",
        "hints": {
          "limit": "Cada entidad puede tener un máximo de {max} archivos.",
          "limitations": "Formatos soportados: jpg, png, gif y pdf. Tamaño máximo de archivo: {size}"
        },
        "title": "Archivos de {name}"
      },
      "filter": "Filtrar",
      "filters": {
        "all": "Mostrar todos los descendientes",
        "clear": "Quitar filtros",
        "direct": "Filtrar solo los descendientes directos",
        "filtered": "Mostrando {count} de {total} {entity}.",
        "hide": "Ocultar filtros",
        "options": {
          "exclude": "Excluir",
          "include": "Incluir",
          "none": "Nada"
        },
        "show": "Mostrar filtros",
        "sorting": {
          "asc": "Ascendiente por {field}",
          "desc": "Descendiente por {field}",
          "helper": "Controla en qué orden aparecen los resultados."
        },
        "title": "Filtros"
      },
      "forms": {
        "actions": {
          "calendar": "Añadir fecha de calendario"
        },
        "copy_options": "Opciones de copia"
      },
      "hidden": "Oculto",
      "hints": {
        "attribute_template": "Aplica una plantilla de atributos directamente al crear esta entidad.",
        "calendar_date": "Las fechas de calendario hacen que sea más fácil filtrar las listas, y también fijan los eventos al calendario seleccionado.",
        "header_image": "Esta imagen está situada sobre la entidad. Para obtener mejores resultados, usa una imagen apaisada.",
        "image_limitations": "Formatos soportados: jpg, png y gif. Tamaño máximo del archivo: {size}.",
        "image_patreon": "Aumenta el límite apoyándonos en Patreon",
        "is_private": "Ocultar a los \"Invitados\"",
        "is_star": "Los elementos fijados aparecerán en el menú principal de la entidad.",
        "map_limitations": "Formatos soportados: jpg, png, gif y svg. Tamaño máximo del archivo: {size}.",
        "tooltip": "Reemplaza la descripción emergente automática con uno de los siguientes contenidos.",
        "visibility": "Al seleccionar \"Administrador\", solo los miembros con el rol de administrador podrán ver esto. \"Solo yo\" significa que solo tú puedes ver esto."
      },
      "history": {
        "created": "Creado por <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "created_date": "Creado <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "unknown": "Desconocido",
        "updated": "Última modificación por <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated_date": "Última modificación <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "view": "Historial de cambios de la entidad"
      },
      "image": {
        "error": "No hemos podido obtener la imagen. Puede que la página web no nos permita descargarla (típico de Squarespace o DeviantArt), o que el enlace ya no es válido."
      },
      "is_private": "Esta entidad es privada y no será visible por los usuarios Invitados.",
      "linking_help": "¿Como puedo enlazar otras entradas?",
      "manage": "Administrar",
      "move": {
        "description": "Mover esta entidad a otro lugar",
        "errors": {
          "permission": "No tienes permiso para crear entidades de este tipo en la campaña seleccionada.",
          "same_campaign": "Debes seleccionar otra campaña donde mover la entidad.",
          "unknown_campaign": "Campaña desconocida."
        },
        "fields": {
          "campaign": "Nueva campaña",
          "copy": "Hacer una copia",
          "target": "Nuevo tipo"
        },
        "hints": {
          "campaign": "También puedes intentar mover esta entidad a otra campaña.",
          "copy": "Selecciona esta opción si quieres crear una copia en la nueva campaña.",
          "target": "Por favor ten en cuenta que algunos datos pueden perderse al mover un elemento de un tipo a otro."
        },
        "success": "Entidad '{name}' movida.",
        "success_copy": "Entidad '{name}' copiada.",
        "title": "Mover {name}"
      },
      "new_entity": {
        "error": "Por favor revisa lo introducido.",
        "fields": {
          "name": "Nombre"
        },
        "title": "Nueva entidad"
      },
      "or_cancel": "o <a href=\"{url}\">Cancelar</a>",
      "panels": {
        "appearance": "Apariencia",
        "attribute_template": "Plantilla de atributos",
        "calendar_date": "Fecha de calendario",
        "entry": "Presentación",
        "general_information": "Información general",
        "move": "Mover",
        "system": "Sistema"
      },
      "permissions": {
        "action": "Acción",
        "actions": {
          "bulk": {
            "add": "Permitir",
            "deny": "Denegar",
            "ignore": "Ignorar",
            "remove": "Quitar"
          },
          "bulk_entity": {
            "allow": "Permitir",
            "deny": "Denegar",
            "inherit": "Heredar"
          },
          "delete": "Eliminar",
          "edit": "Editar",
          "entity_note": "Notas de entidad",
          "read": "Leer",
          "toggle": "Cambiar"
        },
        "allowed": "Permitido",
        "fields": {
          "member": "Miembro",
          "role": "Rol"
        },
        "helper": "Usa esta interfaz para afinar qué usuarios y roles pueden interactuar con esta entidad.",
        "helpers": {
          "entity_note": "Permite a los usuarios crear notas dentro de esta entidad. Sin este permiso, podrán seguir viendo las notas de entidad que se muestren a todos.",
          "setup": "Usa esta interfaz para afinar cómo los diferentes roles y usuarios pueden interactuar con esta entidad. {allow} les permitirá hacer dicha acción; {deny} se la denegará, y {inherit} usará el permiso que ya tenga el rol o usuario. Un usuario con una acción puesta en {allow} podrá hacerla, aunque su rol esté en {deny}."
        },
        "inherited": "Este rol ya tiene este permiso en esta entidad.",
        "inherited_by": "Este usuario forma parte del rol \"{role}\", que le otorga este permiso en esta entidad.",
        "success": "Permisos guardados.",
        "title": "Permisos",
        "too_many_members": "Esta campaña tiene demasiados miembros (>10) para mostrarlos todos en esta interfaz. Puedes usar el botón de permisos en la vista de entidad para controlar los permisos detalladamente."
      },
      "placeholders": {
        "ability": "Escoge una habilidad",
        "calendar": "Escoge un calendario",
        "character": "Escoge un personaje",
        "entity": "Entidad",
        "event": "Elige un evento",
        "family": "Elige una familia",
        "image_url": "Puedes subir una imagen desde una URL",
        "item": "Elige un objeto",
        "location": "Escoge una localización",
        "map": "Elige un mapa",
        "organisation": "Elige una organización",
        "race": "Elige una raza",
        "tag": "Elige una etiqueta"
      },
      "relations": {
        "actions": {
          "add": "Añadir una relación"
        },
        "fields": {
          "location": "Localización",
          "name": "Nombre",
          "relation": "Relación"
        },
        "hint": "Se pueden relacionar entidades para representar sus conexiones."
      },
      "remove": "Eliminar",
      "rename": "Renombrar",
      "save": "Guardar",
      "save_and_close": "Guardar y cerrar",
      "save_and_copy": "Guardar y copiar",
      "save_and_new": "Guardar y crear nuevo",
      "save_and_update": "Guardar y seguir editando",
      "save_and_view": "Guardar y ver",
      "search": "Buscar",
      "select": "Seleccionar",
      "tabs": {
        "abilities": "Habilidades",
        "attributes": "Atributos",
        "boost": "Mejorar",
        "calendars": "Calendarios",
        "default": "Por defecto",
        "events": "Eventos",
        "inventory": "Inventario",
        "map-points": "Puntos del mapa",
        "mentions": "Menciones",
        "menu": "Menú",
        "notes": "Notas",
        "permissions": "Permisos",
        "relations": "Relaciones",
        "reminders": "Recordatorios",
        "timelines": "Líneas de tiempo",
        "tooltip": "Descripción emergente"
      },
      "update": "Actualizar",
      "users": {
        "unknown": "Desconocido"
      },
      "view": "Ver",
      "visibilities": {
        "admin": "Admin",
        "admin-self": "Yo + Admin",
        "all": "Todos",
        "self": "Solo yo"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": [],
    "settings": {
      "account": {
        "actions": {
          "social": "Cambiar a inicio de sesión en Kanka",
          "update_email": "Actualizar email",
          "update_password": "Actualizar contraseña"
        },
        "description": "Actualizar cuenta",
        "email": "Cambiar email",
        "email_success": "Email actualizado.",
        "password": "Cambiar contraseña",
        "password_success": "Contraseña actualizada.",
        "social": {
          "error": "Ya estás utilizando el inicio de sesión de Kanka con esta cuenta.",
          "helper": "Tu cuenta está vinculada con {provider}. Puedes dejar de usarla y cambiar al inicio de sesión estándar de Kanka escribiendo una contraseña.",
          "success": "Tu cuenta ahora usa el inicio de sesión de Kanka.",
          "title": "De social a Kanka"
        },
        "title": "Cuenta"
      },
      "api": {
        "description": "Actualizar configuración de API",
        "experimental": "¡Bienvenido a las APIs de Kanka! Estas prestaciones aún son experimentales pero deberían ser lo suficientemente estables para que puedas comunicarte con las APIs. Crea un Token de Acceso Personal para usar en tus solicitudes de API, o usa el Token Cliente si quieres que tu app tenga acceso a datos de usuario.",
        "help": "Kanka ofrecerá próximamente una RESTful API para que aplicaciones terceras puedan conectarse a la app. Aquí se irán mostrando los detalles sobre cómo gestionar tus claves API.",
        "link": "Leer la documentación de la API",
        "request_permission": "Actualmente estamos construyendo una poderosa RESTful API para que aplicaciones terceras puedan conectarse a la app. Sin embargo, de momento limitamos el número de usuarios que pueden interactuar con la API mientras la pulimos. Si quieres acceder a la API y construir apps guays que interactúan con Kanka, contáctanos y te enviaremos toda la información que necesitas.",
        "title": "API"
      },
      "apps": {
        "actions": {
          "connect": "Conectar",
          "remove": "Eliminar"
        },
        "benefits": "Kanka ofrece algunas integraciones con servicios de terceros. Hay más integraciones planeadas para el futuro.",
        "discord": {
          "errors": {
            "add": "Ha ocurrido un error tratando de vincular tu cuenta de Discord con Kanka. Por favor, inténtalo de nuevo."
          },
          "success": {
            "add": "Se ha vinculado tu cuenta de Discord.",
            "remove": "Se ha desvinculado tu cuenta de Discord."
          },
          "text": "Accede a los roles de suscripción automáticamente."
        },
        "title": "Integración de aplicaciones"
      },
      "boost": {
        "benefits": {
          "first": "Para asegurar un progreso contínuo en Kanka, algunas características de campaña se pueden desbloquear mejorando la campaña. Las mejoras se desbloquean mediante {patreon}. Cualquiera que pueda ver una campaña puede mejorarla; así el máster no tiene que pagar la cuenta siempre. Una campaña permanece mejorada mientras un usuario la esté mejorando y continúe apoyando a Kanka en {patreon}. Si una campaña deja de estar mejorada, los datos no se pierden: solo permanecen ocultos hasta que la campaña vuelva a ser mejorada.",
          "header": "Imágenes de cabecera para las entidades.",
          "images": "Imágenes por defecto personalizadas",
          "more": "Saber más sobre todas las características.",
          "second": "Mejorar una campaña activa los siguientes beneficios:",
          "theme": "Tema y estilo personalizado a nivel de campaña.",
          "third": "Para mejorar una campaña, dirígete a la página de la campaña y haz clic en el botón de \"{boost_button}\" que hay sobre el botón de \"{edit_button}\".",
          "tooltip": "Descripciones emergentes personalizadas para las entidades.",
          "upload": "Capacidad de subida de archivos ampliada para todos los miembros de la campaña."
        },
        "buttons": {
          "boost": "Mejorar"
        },
        "campaigns": "Campañas mejoradas {count} / {max}",
        "exceptions": {
          "already_boosted": "La campaña {name} ya está mejorada.",
          "exhausted_boosts": "Te has quedado sin mejoras. Elimina tu mejora de una campaña antes de dársela a otra."
        },
        "success": {
          "boost": "Campaña {name} mejorada.",
          "delete": "Tu mejora de {name} se ha eliminado."
        },
        "title": "Mejorar"
      },
      "countries": {
        "austria": "Austria",
        "belgium": "Bégica",
        "france": "Francia",
        "germany": "Alemania",
        "italy": "Italia",
        "netherlands": "Holanda",
        "spain": "España"
      },
      "invoices": {
        "actions": {
          "download": "Descargar PDF",
          "view_all": "Ver todas"
        },
        "empty": "Sin facturas",
        "fields": {
          "amount": "Cantidad",
          "date": "Fecha",
          "invoice": "Factura",
          "status": "Estado"
        },
        "header": "Puedes descargar tus últimas 24 facturas a continuación.",
        "status": {
          "paid": "Pagada",
          "pending": "Pendiente"
        },
        "title": "Facturas"
      },
      "layout": {
        "description": "Actualizar opciones de diseño",
        "success": "Opciones de diseño actualizadas.",
        "title": "Diseño"
      },
      "menu": {
        "account": "Cuenta",
        "api": "API",
        "apps": "Aplicaciones",
        "billing": "Método de pago",
        "boost": "Mejorar",
        "invoices": "Facturas",
        "layout": "Diseño",
        "other": "Otros",
        "patreon": "Patreon",
        "payment_options": "Opciones de pago",
        "personal_settings": "Ajustes personales",
        "profile": "Perfil",
        "subscription": "Suscripción",
        "subscription_status": "Estado de la suscripción"
      },
      "patreon": {
        "actions": {
          "link": "Enlazar cuenta",
          "view": "Visita la página de Patreon de Kanka"
        },
        "benefits": "Si nos ayudas en Patreon podrás subir imágenes más pesadas, y así nos ayudarás a cubrir los costes del servidor y a dedicarle más tiempo a trabajar en Kanka.",
        "benefits_features": "Funciones increíbles",
        "deprecated": "Funcionalidad discontinuada. Si deseas apoyar a Kanka, puedes hacerlo mediante una {subscription}. La vinculación con Patreon aún sigue activa para nuestros Patrons que vincularon sus cuentas antes de la mudanza de Patreon.",
        "description": "Sincronizando con Patreon",
        "errors": {
          "invalid_token": "¡Token no válido! Patreon no ha podido validar tu petición.",
          "missing_code": "¡Falta el código! Patreon no ha enviado un código para identificar tu cuenta.",
          "no_pledge": "¡Sin \"pledge\"! Patreon ha identificado tu cuenta, pero no detecta ningún \"pledge\" activo."
        },
        "link": "Usa el siguiente botón si estás apoyando a Kanka en Patreon actualmente. ¡Esto te dará acceso a más cosas fantásticas extras!",
        "linked": "¡Gracias por apoyar a Kanka en Patreon! Se ha enlazado tu cuenta.",
        "pledge": "Pledge {name}",
        "remove": {
          "button": "Desvincular mi cuenta de Patreon",
          "success": "Tu cuenta de Patreon se ha desvinculado.",
          "text": "Desvincular tu cuenta de Patreon de Kanka eliminará tus bonus, tu nombre en el salón de la fama, tus mejoras y otras funcionalidades vinculadas. Sin embargo, tu contenido mejorado no se perderá: si vuelves a suscribirte, volverás a tener acceso a esos datos, incluyendo la posibilidad de volver a mejorar dicha campaña.",
          "title": "Desvincular mi cuenta de Patreon de Kanka"
        },
        "success": "¡Gracias por apoyar a Kanka en Patreon!",
        "title": "Patreon",
        "wrong_pledge": "Añadimos manualmente tu nivel de \"pledge\", así que ten en cuenta que podemos tardar unos pocos días. Si al cabo de un tiempo sigue sin estar bien, contáctanos por favor."
      },
      "profile": {
        "actions": {
          "update_profile": "Actualizar perfil"
        },
        "avatar": "Foto de perfil",
        "description": "Actualizar perfil",
        "success": "Perfil actualizado.",
        "title": "Perfil personal"
      },
      "subscription": {
        "actions": {
          "cancel_sub": "Cancelar suscripción",
          "subscribe": "Suscribirse",
          "update_currency": "Guardar moneda preferida"
        },
        "benefits": "Si nos apoyas, desbloquearás algunas nuevas {features} y nos ayudarás a dedicar más tiempo a la mejora de Kanka. No guardaremos tu información bancaria. Usamos {stripe} para gestionar los cobros.",
        "billing": {
          "helper": "Tu información de pago se procesa y se guarda de forma segura mediante {stripe}. Este método de pago se usará para todas tus suscripciones.",
          "saved": "Método de pago guardado",
          "title": "Editar método de pago"
        },
        "cancel": {
          "text": "¡Lamentamos verte marchar! Al cancelar tu suscripción, esta seguirá activa hasta el nuevo ciclo de facturación, tras lo cual perderás tus mejoras de campaña y otros beneficios relacionados. No tengas miedo de informarnos sobre cómo podemos mejorar o qué te ha llevado a tomar esta decisión."
        },
        "cancelled": "Se ha cancelado tu suscripción. Puedes renovarla una vez el período de la suscripción actual termine.",
        "change": {
          "text": {
            "monthly": "Estás suscribiéndote al nivel {tier}, que cuesta {amount} mensuales.",
            "yearly": "Estás suscribiéndote al nivel {tier}, que cuesta {amount} anuales."
          },
          "title": "Cambiar nivel de suscripción"
        },
        "currencies": {
          "eur": "Euros",
          "usd": "Dólares estadounidenses"
        },
        "currency": {
          "title": "Cambia la moneda de facturación"
        },
        "errors": {
          "callback": "Nuestro proveedor de pagos nos ha informado de un error. Por favor, vuelve a intentarlo o infórmanos si el problema persiste.",
          "subscribed": "No se ha podido procesar tu suscripción. Stripe nos ha dado este mensaje:"
        },
        "fields": {
          "active_since": "Activa desde",
          "active_until": "Activa hasta",
          "billed_monthly": "Cobro mensual",
          "billing": "Cobro",
          "currency": "Moneda de cobro",
          "payment_method": "Método de pago",
          "plan": "Plan actual",
          "reason": "Razón"
        },
        "helpers": {
          "alternatives": "Paga por tu suscripción usando {method}. Este método de pago no se renovará automáticamente al final de tu suscripción. {method} solo está disponible en euros.",
          "alternatives_warning": "No se puede mejorar la suscripción usando este método. Por favor, crea una nueva suscripción cuando la actual termine.",
          "alternatives_yearly": "Debido a las restricciones de los pagos recurrentes, {method} solo está disponible para las suscripciones anuales."
        },
        "manage_subscription": "Gestionar suscripción",
        "payment_method": {
          "actions": {
            "add_new": "Añadir nuevo método de pago",
            "change": "Cambiar método de pago",
            "save": "Guardar método de pago",
            "show_alternatives": "Métodos de pago alternativos"
          },
          "add_one": "Aún no tienes ningún método de pago guardado.",
          "alternatives": "Puedes suscribirte usando estos métodos de pago alternativos. Esto hará un solo cobro en tu cuenta y no se renovará automáticamente cada mes.",
          "card": "Tarjeta",
          "card_name": "Nombre en la tarjeta",
          "country": "País de residencia",
          "ending": "Termina en",
          "helper": "Se usará esta tarjeta para todas tus suscripciones.",
          "new_card": "Añadir nuevo método de pago",
          "saved": "{brand} que termina en {last4}"
        },
        "placeholders": {
          "reason": "Opcionalmente, puedes contarnos por qué ya no apoyas a Kanka. ¿Faltaba algo? ¿Cambió tu situación financiera?"
        },
        "plans": {
          "cost_monthly": "{amount} {currency} mensuales",
          "cost_yearly": "{amount} {currency} anuales"
        },
        "sub_status": "Información sobre la suscripción",
        "subscription": {
          "actions": {
            "downgrading": "Contáctanos para bajar de nivel",
            "rollback": "Cambiar a Kobold",
            "subscribe": "Cambiar a {tier} al mes",
            "subscribe_annual": "Cambiar a {tier} anualmente"
          }
        },
        "success": {
          "alternative": "Se ha registrado tu pago. Recibirás una notificación en cuanto terminemos de procesarlo y se active tu suscripción.",
          "callback": "Tu suscripción ha tenido éxito. Tu cuenta será actualizada en cuanto nuestro proveedor de pagos nos informe del cambio (puede llevar algunos minutos).",
          "cancel": "Se ha cancelado tu suscripción. Continuará activa hasta el final del período de pago.",
          "currency": "Se ha actualizado tu moneda preferida.",
          "subscribed": "Tu suscripción ha tenido éxito. ¡No te olvides de suscribirte a la newsletter de votaciones comunitarias para enterarte cuando se abra una votación! Puedes cambiar tu configuración de newsletters en tu perfil."
        },
        "tiers": "Niveles de suscripción",
        "trial_period": "Las suscripciones anuales tienen un período de cancelación de 14 días. Contáctanos en {email} si quieres cancelar tu suscripción anual y recuperar el dinero.",
        "upgrade_downgrade": {
          "button": "Información acerca de subir o bajar de nivel",
          "downgrade": {
            "bullets": {
              "end": "Tu nivel actual estará activo hasta el final de tu ciclo de pago actual, tras el cual se bajará tu suscripción al nuevo nivel."
            },
            "title": "Bajar de nivel"
          },
          "upgrade": {
            "bullets": {
              "immediate": "Se cobrará en tu método de pago inmediatamente y tendrás acceso al nuevo nivel.",
              "prorate": "Al subir de nivel de Owlbear a Elemental, solo se te cobrará la diferencia entre los dos niveles."
            },
            "title": "Subir de nivel"
          }
        },
        "warnings": {
          "incomplete": "No hemos podido hacer el cobro en tu tarjeta de crédito. Por favor, actualiza la información de la tarjeta y volveremos a intentarlo en los próximos días. Si vuelve a fallar, tu suscripción será cancelada.",
          "patreon": "Tu cuenta se encuentra vinculada con Patreon. Desvincúlala en la configuración de {patreon} antes de cambiarla por una suscripción de Kanka."
        }
      }
    }
  },
  "de": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "Erstelle eine neue Unterhaltung",
        "success": "Unterhaltung {name} erstellt.",
        "title": "Neue Unterhaltung"
      },
      "destroy": {
        "success": "Unterhaltung {name} gelöscht."
      },
      "edit": {
        "description": "Aktualisiere die Unterhaltung",
        "success": "Unterhaltung '{name}' aktualisiert.",
        "title": "Unterhaltung {name}"
      },
      "fields": {
        "messages": "Nachrichten",
        "name": "Name",
        "participants": "Teilnehmer",
        "target": "Ziel",
        "type": "Typ"
      },
      "hints": {
        "participants": "Bitte füge Teilnehmer zu deiner Unterhaltung hinzu, indem du das {icon} Symbol oben rechts drückst."
      },
      "index": {
        "add": "Neue Unterhaltung",
        "description": "Verwalte die Kategorie von {name}.",
        "header": "Unterhaltungen in {name}",
        "title": "Unterhaltungen"
      },
      "messages": {
        "destroy": {
          "success": "Nachricht gelöscht."
        },
        "is_updated": "Aktualisiert",
        "load_previous": "Lade vorherige Nachrichten",
        "placeholders": {
          "message": "Deine Nachricht"
        }
      },
      "participants": {
        "create": {
          "success": "Teilnehmer {entity} zu Unterhaltung hinzugefügt."
        },
        "description": "Entferne oder füge Teilnehmer einer Unterhaltung hinzu",
        "destroy": {
          "success": "Teilnehmer {entity} von Unterhaltung entfernt."
        },
        "modal": "Teilnehmer",
        "title": "Teilnehmer von {name}"
      },
      "placeholders": {
        "name": "Name der Unterhaltung",
        "type": "Im Spiel, Vorbereitung, Handlung"
      },
      "show": {
        "description": "Eine Detailansicht einer Unterhaltung",
        "title": "Unterhaltung {name}"
      },
      "tabs": {
        "conversation": "Unterhaltung",
        "participants": "Teilnehmer"
      },
      "targets": {
        "characters": "Charaktere",
        "members": "Mitglieder"
      }
    },
    "crud": {
      "actions": {
        "actions": "Aktionen",
        "apply": "Übernehmen",
        "back": "Zurück",
        "copy": "Kopieren",
        "copy_mention": "Kopie [] erwähnen",
        "copy_to_campaign": "Kopiere zu Kampagne",
        "explore_view": "Verschachtelte Ansicht",
        "export": "Exportieren",
        "find_out_more": "Mehr erfahren",
        "go_to": "Gehe zu {name}",
        "json-export": "Export (json)",
        "more": "Mehr Aktionen",
        "move": "Verschieben",
        "new": "Neu",
        "next": "Weiter",
        "private": "Privat",
        "public": "Öffentlich",
        "reset": "Zurücksetzen"
      },
      "add": "Hinzufügen",
      "alerts": {
        "copy_mention": "Die erweiterte Erwähnung dieses Objekts wurde in Ihre Zwischenablage kopiert."
      },
      "attributes": {
        "actions": {
          "add": "Attribut hinzufügen",
          "add_block": "Block hinzufügen",
          "add_checkbox": "Checkbox hinzufügen.",
          "add_text": "Text hinzufügen",
          "apply_template": "Eine Attributvorlage anwenden",
          "manage": "Verwalten",
          "remove_all": "Alles löschen"
        },
        "create": {
          "description": "Erstelle ein neues Attribut",
          "success": "Attribut {name} zu {entity} hinzugefügt",
          "title": "Neues Attribute für {name}"
        },
        "destroy": {
          "success": "Attribut {name} für {entity} entfernt"
        },
        "edit": {
          "description": "Aktualisiere ein bestehendes Attribut",
          "success": "Attribut {name} für {entity} aktualisiert",
          "title": "Aktualisiere Attribut für {name}"
        },
        "fields": {
          "attribute": "Attribut",
          "community_templates": "Community Vorlagen",
          "is_private": "Private Attribute",
          "is_star": "Angepinnt",
          "template": "Vorlage",
          "value": "Wert"
        },
        "helpers": {
          "delete_all": "Möchten Sie wirklich alle Attribute dieses Objekts löschen?"
        },
        "hints": {
          "is_private": "Sie können alle Attribute eines Objekts für alle Mitglieder außerhalb der Administratorrolle ausblenden, indem Sie sie privat machen."
        },
        "index": {
          "success": "Attribute für {entity} aktualisiert",
          "title": "Attribute für {name}"
        },
        "placeholders": {
          "attribute": "Anzahl der Eroberungen, Challenge Rating, Initiative, Bevölkerung",
          "block": "Blockname",
          "checkbox": "Checkbox Name",
          "section": "Abteilungsname",
          "template": "Wähle eine Vorlage",
          "value": "Wert des Attributs"
        },
        "template": {
          "success": "Attributvorlage {name} wird auf {entity} angewendet",
          "title": "Wende eine Attributvorlage auf {name} an"
        },
        "types": {
          "attribute": "Attribute",
          "block": "Block",
          "checkbox": "Checkbox",
          "section": "Abteilung",
          "text": "Mehrzeiliger Text"
        },
        "visibility": {
          "entry": "Das Attribut wird im Objektmenü angezeigt.",
          "private": "Attribut nur für Mitglieder der Rolle \"Admin\" sichtbar.",
          "public": "Attribut für alle Mitglieder sichtbar.",
          "tab": "Das Attribut wird nur im Attribute-Reiter angezeigt."
        }
      },
      "boosted": "geboostet",
      "boosted_campaigns": "geboostete Kampagne",
      "bulk": {
        "actions": {
          "edit": "Bearbeitung vieler Objekte"
        },
        "age": {
          "helper": "Sie können + und - vor der Nummer verwenden, um das Alter dynamisch zu aktualisieren."
        },
        "delete": {
          "title": "Mehrere Objekte löschen",
          "warning": "Möchten Sie die ausgewählten Objekte wirklich löschen?"
        },
        "edit": {
          "tagging": "Aktion für Tags",
          "tags": {
            "add": "Hinzufügen",
            "remove": "Entfernen"
          },
          "title": "Mehrere Objekte bearbeiten"
        },
        "errors": {
          "admin": "Nur Kampagnenadmins können den \"Privat\" Status eines Objektes ändern.",
          "general": "Bei der Verarbeitung Ihrer Aktion ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut und kontaktieren Sie uns, wenn das Problem weiterhin besteht. Fehlermeldung: {hint}."
        },
        "permissions": {
          "fields": {
            "override": "Überschreiben"
          },
          "helpers": {
            "override": "Wenn ausgewählt, werden die Berechtigungen der ausgewählten Objekte mit diesen überschrieben. Wenn das Kontrollkästchen deaktiviert ist, werden die ausgewählten Berechtigungen zu den vorhandenen Berechtigungen hinzugefügt."
          },
          "title": "Ändert die Berechtigungen für mehrere Objekte"
        },
        "success": {
          "copy_to_campaign": "{1} {count} der in {campaign} kopierten Objekte. | [2, *] {count}  der in {campaign} kopierten Objekte.",
          "editing": "1} {count} objekt wurde aktualisiert. | [2, *] {count} objekte wurden aktualisiert.",
          "permissions": "Berechtigungen für {count} Objekt geändert.|Berechtigungen für {count} Objekte geändert.",
          "private": "{count} Objekt ist jetzt privat.|{count} Objekte sind jetzt privat.",
          "public": "{count} Objekt ist jetzt sichtbar.|{count} Objekte sind jetzt sichtbar."
        }
      },
      "cancel": "Abbrechen",
      "click_modal": {
        "close": "Schließen",
        "confirm": "Bestätigen",
        "title": "Bestätige deine Aktion"
      },
      "copy_to_campaign": {
        "bulk_title": "Kopieren Sie Objekte in eine andere Kampagne",
        "panel": "Kopieren",
        "title": "Kopiere {name} in eine andere Kampagne"
      },
      "create": "Erstellen",
      "datagrid": {
        "empty": "Nichts zu sehen bisher."
      },
      "delete_modal": {
        "close": "Schließen",
        "delete": "Löschen",
        "description": "Bist du sicher das du {tag} entfernen möchtest?",
        "mirrored": "Entferne gespiegelte Beziehung.",
        "title": "Löschen bestätigen"
      },
      "destroy_many": {
        "success": "{count} Objekt gelöscht|{count} Objekte gelöscht"
      },
      "edit": "Bearbeiten",
      "errors": {
        "boosted": "Diese Funktion ist nur für geboostete Kampagnen verfügbar.",
        "node_must_not_be_a_descendant": "Ungültiges Objekt (Kategorie, Ort): es würde ein Nachkomme von sich selbst sein."
      },
      "events": {
        "hint": "Kalenderereignisse, die mit diesem Objekt verknüpft sind, werden hier dargestellt."
      },
      "export": "Exportieren",
      "fields": {
        "ability": "Fähigkeit",
        "attribute_template": "Attributsvorlage",
        "calendar": "Kalender",
        "calendar_date": "Datum",
        "character": "Charakter",
        "colour": "Farbe",
        "copy_attributes": "Kopiere Attribute",
        "copy_notes": "Kopiere Objektnotizen",
        "creator": "Ersteller",
        "dice_roll": "Würfelwürf",
        "entity": "Objekt",
        "entity_type": "Objekttyp",
        "entry": "Eintrag",
        "event": "Ereignis",
        "excerpt": "Auszug",
        "family": "Familie",
        "files": "Dateien",
        "has_image": "hat ein Bild",
        "header_image": "Kopfzeilenbild",
        "image": "Bild",
        "is_private": "Privat",
        "is_star": "Angepinnt",
        "item": "Gegenstand",
        "location": "Ort",
        "map": "Karte",
        "name": "Name",
        "organisation": "Organisation",
        "position": "Position",
        "race": "Rasse",
        "tag": "Tag",
        "tags": "Tags",
        "timeline": "Zeitstrahl",
        "tooltip": "Kurzinfo",
        "type": "Typ",
        "visibility": "Sichtbarkeit"
      },
      "files": {
        "actions": {
          "drop": "Klicken zum Hinzufügen oder Datei hierher ziehen (Drag & Drop).",
          "manage": "Verwalte Objektdateien"
        },
        "errors": {
          "max": "Du hast die maximale Anzahl ({max}) von Dateien in diesem Objekt erreicht.",
          "no_files": "Keine Dateien."
        },
        "files": "Hochgeladene Dateien",
        "hints": {
          "limit": "In jedem Objekt kann eine maximale Anzahl von {max} Dateien hochgeladen werden.",
          "limitations": "Unterstütze Formate: jpg, png, gif, und pdf. Max. Dateigröße: {size}"
        },
        "title": "Objektdateien für {name}"
      },
      "filter": "Filter",
      "filters": {
        "all": "Filter um alle Unterobjekte zu sehen",
        "clear": "Filter zurücksetzen",
        "direct": "Filter um nur direkte Unterobjekte zu sehen",
        "filtered": "Zeige {count} von {total} {entity}.",
        "hide": "Verstecken",
        "options": {
          "exclude": "Ausschließen",
          "include": "Einschließen",
          "none": "keine"
        },
        "show": "Zeigen",
        "sorting": {
          "asc": "{field} Aufsteigend",
          "desc": "{field} absteigend",
          "helper": "Steuern Sie, in welcher Reihenfolge die Ergebnisse angezeigt werden."
        },
        "title": "Filter"
      },
      "forms": {
        "actions": {
          "calendar": "Füge Datum hinzu"
        },
        "copy_options": "Kopiere Optionen"
      },
      "hidden": "Versteckt",
      "hints": {
        "attribute_template": "Wende eine Attributsvorlage direkt beim erstellen des Objektes an.",
        "calendar_date": "Ein Datum erlaubt es, Listen einfach zu filtern und pflegt ein Ereignis im ausgewählten Kalender.",
        "header_image": "Dieses Bild wird über dem Objekt platziert. Verwenden Sie ein breites Bild, um optimale Ergebnisse zu erzielen.",
        "image_limitations": "Unterstützte Formate: jpg, png und gif. Maximale Dateigröße: {size}.",
        "image_patreon": "Erhöhe das Limit indem du uns bei Patreon unterstützt.",
        "is_private": "Vor 'Zuschauern' verbergen",
        "is_star": "Angepinnte Objekte erscheinen im Objektmenü.",
        "map_limitations": "Unterstützte Formate: jpg, png, gif und svg. Max Dateigröße: {size}.",
        "tooltip": "Ersetzen Sie die automatisch generierte Kurzinfo durch den folgenden Inhalt.",
        "visibility": "Wenn die Sichtbarkeit auf Admin festgelegt wird, können dies nur Mitglieder in der Rolle Admin sehen. Wird es auf \"Selbst\" gesetzt, kannst es nur du sehen."
      },
      "history": {
        "created": "Erstellt von <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "created_date": "Erstelle <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "unknown": "Unbekannt",
        "updated": "Zuletzt aktualisiert von <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated_date": "Letzte Änderung <span data-toggle = \"tooltip\" title = \": realdate\">: Datum </ span>",
        "view": "Zeige Objektprotokoll"
      },
      "image": {
        "error": "Wir konnten das von dir angeforderte Bild nicht laden. Es könnte sein, dass die Website nicht erlaubt, Bilder herunterzuladen (typisch für Squarespace und DeviantArt) oder dass der Link nicht mehr gültig ist."
      },
      "is_private": "Dieses Objekt ist privat und nicht von Zuschauern einsehbar.",
      "linking_help": "Wie kann ich zu anderen Objekten verlinken?",
      "manage": "Verwalten",
      "move": {
        "description": "Verschiebe diese Objekt an einen anderen Ort",
        "errors": {
          "permission": "Du hast keine Berechtigung, Objekte diesen Typs in dieser Kampagne zu erstellen.",
          "same_campaign": "Du musst eine andere Kampagne auswählen, in welche du das Objekt verschieben willst.",
          "unknown_campaign": "Unbekannte Kampagne."
        },
        "fields": {
          "campaign": "Neue Kampagne",
          "copy": "Erstelle Kopie",
          "target": "Neuer Typ"
        },
        "hints": {
          "campaign": "Du kannst auch versuchen, dieses Objekt in eine andere Kampagne zu verschieben.",
          "copy": "Wähle diese Option, wenn du eine Kopie in der neuen Kampagne erstellen willst.",
          "target": "Bitte beachte, das einige Daten verloren gehen können, wenn ein Objekt von einem Typ zu einem anderen verschoben wird."
        },
        "success": "Objekt '{name}' verschoben",
        "success_copy": "Objekt '{name}' kopiert",
        "title": "Verschiebe {name} an einen anderen Ort"
      },
      "new_entity": {
        "error": "Bitte überprüfe deine Eingabe.",
        "fields": {
          "name": "Name"
        },
        "title": "Neues Objekt"
      },
      "or_cancel": "oder <a href=\"{url}\">abbrechen</a>",
      "panels": {
        "appearance": "Aussehen",
        "attribute_template": "Attributsvorlage",
        "calendar_date": "Datum",
        "entry": "Eintrag",
        "general_information": "Allgemeine Informationen",
        "move": "Verschieben",
        "system": "System"
      },
      "permissions": {
        "action": "Aktion",
        "actions": {
          "bulk": {
            "add": "Hinzufügen",
            "deny": "verweigern",
            "ignore": "Ignorieren",
            "remove": "Entfernen"
          },
          "bulk_entity": {
            "allow": "erlauben",
            "deny": "verweigern",
            "inherit": "Erben"
          },
          "delete": "Löschen",
          "edit": "Bearbeiten",
          "entity_note": "Objektnotizen",
          "read": "Lesen",
          "toggle": "Umschalten"
        },
        "allowed": "Erlaubt",
        "fields": {
          "member": "Mitglied",
          "role": "Rolle"
        },
        "helper": "Benutze dieses Interface um die Berechtigungen von Nutzern und Rollen mit diesem Objekt  fein zu justieren.",
        "helpers": {
          "entity_note": "Ermöglichen Sie Benutzern das Erstellen von Objektnotizen für dieses Objekt. Ohne diese Berechtigung können sie weiterhin Objekt Notizen sehen, die auf Sichtbarkeit Alle eingestellt sind.",
          "setup": "Verwenden Sie diese Schnittstelle, um zu optimieren, wie Rollen und Benutzer mit diesem Objekt interagieren können. {allow} ermöglicht dem Benutzer oder der Rolle, diese Aktion auszuführen. {deny} wird ihnen diese Handlung verweigern. {inherit} verwendet die Berechtigung des Benutzers oder der Hauptrolle. Ein Benutzer, der auf {allow} eingestellt ist, kann die Aktion ausführen, auch wenn seine Rolle auf {deny} eingestellt ist."
        },
        "inherited": "Für diese Rolle ist die Berechtigung für diesen Objekttyp bereits festgelegt.",
        "inherited_by": "Dieser Benutzer ist Teil der Rolle '{role}', die diese Berechtigungen für diesen Objekttyp erteilt.",
        "success": "Berechtigungen gespeichert.",
        "title": "Berechtigungen",
        "too_many_members": "Diese Kampagne hat zu viele Mitglieder (> 10), um in dieser Benutzeroberfläche angezeigt zu werden. Verwenden Sie die Schaltfläche Berechtigung in der Objektansicht, um die Berechtigungen im Detail zu steuern."
      },
      "placeholders": {
        "ability": "Wähle eine Fähigkeit",
        "calendar": "Wähle einen Kalender",
        "character": "Wähle einen Character",
        "entity": "Objekt",
        "event": "Wähle ein Ereignis",
        "family": "Wähle eine Familie",
        "image_url": "Du kannst ein Bild auch von einer URL hochladen",
        "item": "Wähle einen Gegenstand",
        "location": "Wähle einen Ort",
        "map": "Wähle eine Karte",
        "organisation": "Wähle eine Organisation",
        "race": "Wähle eine Rasse",
        "tag": "Wähle ein Tag"
      },
      "relations": {
        "actions": {
          "add": "Füge eine Beziehung hinzu"
        },
        "fields": {
          "location": "Ort",
          "name": "Name",
          "relation": "Beziehung"
        },
        "hint": "Beziehungen zwischen Objekten können erstellt werden, um deren Verbindung darzustellen."
      },
      "remove": "Löschen",
      "rename": "Umbenennen",
      "save": "Speichern",
      "save_and_close": "Speichern und schließen",
      "save_and_copy": "Speichern und kopieren",
      "save_and_new": "Speichern und neu",
      "save_and_update": "Speichern und aktualisieren",
      "save_and_view": "Speichern und ansehen",
      "search": "Suchen",
      "select": "Auswählen",
      "tabs": {
        "abilities": "Fähigkeiten",
        "attributes": "Attribute",
        "boost": "Boost",
        "calendars": "Kalender",
        "default": "Standard",
        "events": "Ereignisse",
        "inventory": "Inventar",
        "map-points": "Kartenmarker",
        "mentions": "Erwähnungen",
        "menu": "Menü",
        "notes": "Notizen",
        "permissions": "Berechtigungen",
        "relations": "Beziehungen",
        "reminders": "Erinnerungen",
        "timelines": "Zeitstrahlen",
        "tooltip": "Kurztip"
      },
      "update": "Bearbeiten",
      "users": {
        "unknown": "Unbekannt"
      },
      "view": "Ansehen",
      "visibilities": {
        "admin": "Admin",
        "admin-self": "Selbst & Admin",
        "all": "Jeder",
        "self": "Selbst"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": [],
    "settings": {
      "account": {
        "actions": {
          "social": "Zu Kanka Login wechseln",
          "update_email": "Email aktualisieren",
          "update_password": "Passwort aktualisieren"
        },
        "description": "Deinen Account aktualisieren",
        "email": "Email ändern",
        "email_success": "Email aktualisiert.",
        "password": "Passwort ändern",
        "password_success": "Passwort aktualisiert.",
        "social": {
          "error": "Du benutzt bereits das Kanka Login für dieses Konto.",
          "helper": "Dein Konto ist momentan von {provider}. Du kannst aufhören dieses zu benutzen und auf ein Standard Kanka Login wechseln, indem du ein Kennwort setzt.",
          "success": "Dein Konto benutzt jetzt das Kanka Login.",
          "title": "Social Konto"
        },
        "title": "Account"
      },
      "api": {
        "description": "Aktualisiere deine API Einstellungen",
        "experimental": "Willkommen zur API von Kanka! Diese Features sind noch experimentell, aber sollten stabil genug sein, um mit API zu kommunizieren. Erstelle ein persönliches Access Token, welches in deinem API Request genutzt wird, oder nutze das Client Token wenn du möchtest, dass deine App Zugriff auf Nutzerdaten hat.",
        "help": "Kanka wird bald eine RESTful API zur Verfügung stellen, so dass Drittanbieter-Apps mit Kanka kommunizieren können. Details, wie du deine API Keys verwaltest, wirst du bald hier finden.",
        "link": "Lies die API Dokumentation",
        "request_permission": "Wir bauen zurzeit eine mächtige RESTful API, so das Drittanbieter-Apps sich zu Kanka verbinden können. Allerdings limitieren wir aktuell noch die Anzahl der Nutzer, die die API nutzen können, solange wir noch daran arbeiten. Wenn du Zugriff auf die API haben möchtest und coole Apps bauen möchtest, die mit Kanka kommunizieren, bitte kontaktiere uns und wir senden dir die Informationen, die du brauchst.",
        "title": "API"
      },
      "apps": {
        "actions": {
          "connect": "Verbinden",
          "remove": "Entfernen"
        },
        "benefits": "Kanka bietet einige Integrationsmöglichkeiten für Dienste von Drittanbietern. Weitere Integrationen von Drittanbietern sind für die Zukunft geplant.",
        "discord": {
          "errors": {
            "add": "Beim Verknüpfen Ihres Discord-Kontos mit Kanka ist ein Fehler aufgetreten. Bitte versuche es erneut."
          },
          "success": {
            "add": "Ihr Discord-Konto wurde verknüpft.",
            "remove": "Ihr Discord-Konto wurde nicht verbunden."
          },
          "text": "Greifen Sie automatisch auf Ihre Abonnementrollen zu."
        },
        "title": "App Integration"
      },
      "boost": {
        "benefits": {
          "first": "Um weitere Fortschritte bei Kanka zu erzielen, werden einige Kampagnenfunktionen durch Boosten einer Kampagne freigeschaltet. Boosts werden durch Abonnements freigeschaltet. Jeder, der eine Kampagne anzeigen kann, kann sie verbessern, sodass der DM nicht immer die Rechnung bezahlen muss. Eine Kampagne bleibt verstärkt, solange ein Benutzer die Kampagne verstärkt und Kanka weiterhin unterstützt. Wenn eine Kampagne nicht mehr verstärkt wird, gehen keine Daten verloren, sondern werden nur ausgeblendet, bis die Kampagne erneut erhöht wird.",
          "header": "Objekt Header Bilder.",
          "images": "Benutzerdefinitierte Standardobjektbilder.",
          "more": "Erfahren Sie mehr über alle Funktionen.",
          "second": "Das Boosten einer Kampagne bietet die folgenden Vorteile:",
          "theme": "Leitmotiv auf Kampagnenebene und benutzerdefiniertes Design.",
          "third": "Um eine Kampagne zu boosten, rufen Sie die Seite der Kampagne auf und klicken Sie auf die Schaltfläche \"{boost_button}\" über der Schaltfläche \"{edit_button}\".",
          "tooltip": "Benutzerdefinierte Kurzinfo für Objekt.",
          "upload": "Erhöhte Upload-Größe für jedes Mitglied in der Kampagne."
        },
        "buttons": {
          "boost": "Boost"
        },
        "campaigns": "Geboostete Kampagne {count} / {max}",
        "exceptions": {
          "already_boosted": "Kampagne {name} ist bereits geboostet",
          "exhausted_boosts": "Sie haben keine Boosts mehr zu geben. Entfernen Sie Ihren Boost aus einer Kampagne, bevor Sie ihn einer anderen geben."
        },
        "success": {
          "boost": "Kampagne {name} geboostet",
          "delete": "Entferne den boost von {name}"
        },
        "title": "Boost"
      },
      "countries": {
        "austria": "Österreich",
        "belgium": "Belgien",
        "france": "Frankreich",
        "germany": "Deutschland",
        "italy": "Italien",
        "netherlands": "Niederlande",
        "spain": "Spanien"
      },
      "invoices": {
        "actions": {
          "download": "PDF herunterladen",
          "view_all": "Alle anzeigen"
        },
        "empty": "keine Rechnungen",
        "fields": {
          "amount": "Menge",
          "date": "Datum",
          "invoice": "Rechnung",
          "status": "Status"
        },
        "header": "Unten finden Sie eine Liste Ihrer letzten 24 Rechnungen, die heruntergeladen werden können.",
        "status": {
          "paid": "Bezahlt",
          "pending": "steht aus"
        },
        "title": "Rechnungen"
      },
      "layout": {
        "description": "Aktualisiere deine Layout Optionen",
        "success": "Layout Optionen aktualisiert.",
        "title": "Layout"
      },
      "menu": {
        "account": "Account",
        "api": "API",
        "apps": "Apps",
        "billing": "Zahlungsmethode",
        "boost": "Boost",
        "invoices": "Rechnungen",
        "layout": "Layout",
        "other": "Andere",
        "patreon": "Patreon",
        "payment_options": "Zahlungsmöglichkeiten",
        "personal_settings": "Persönliche Einstellungen",
        "profile": "Profil",
        "subscription": "Abonnement",
        "subscription_status": "Abonnement Status"
      },
      "patreon": {
        "actions": {
          "link": "Account verlinken",
          "view": "Besuche Kanka auf Patreon"
        },
        "benefits": "Eure Unterstützung auf Patreon erlaubt es euch größere Bilder hochzuladen, hilft uns die Serverkosten zu begleichen und mehr Arbeitszeit in Kanka zu stecken.",
        "benefits_features": "erstaunliche Eigenschaften",
        "deprecated": "Veraltete Funktion - Wenn Sie Kanka unterstützen möchten, tun Sie dies bitte mit einem {subscription}. Die Patreon-Verknüpfung ist weiterhin für unsere Benutzer aktiv, die ihr Konto vor dem Umzug von Patreon verknüpft haben.",
        "description": "Synchronisierung mit Patreon",
        "errors": {
          "invalid_token": "Ungültiger Token! Patreon konnte die Anfrage nicht validieren.",
          "missing_code": "Fehlender Code! Patreon hat keinen Code zurück geschickt, um deinen Account zu verifizieren.",
          "no_pledge": "Kein Pledge! Patreon hat deinen Account verifiziert, aber konnte keinen aktiven Pledge feststellen."
        },
        "link": "Benutze diesen Button, wenn du aktuell Kanka auf Patreon unterstützt. Das gibt dir Zugriff auf einige tolle Extras.",
        "linked": "Danke, dass du Kanka auf Patreon unterstützt! Dein Account wurde verlinkt.",
        "pledge": "Pledge {name}",
        "remove": {
          "button": "Trennen Sie die Verknüpfung Ihres Patreon-Kontos",
          "success": "Ihr Patreon-Konto wurde getrennt.",
          "text": "Wenn Sie die Verknüpfung Ihres Patreon-Kontos mit Kanka aufheben, werden Ihre Boni, Ihr Name in der Hall of Fame, Kampagnen-Boosts und andere Funktionen im Zusammenhang mit der Unterstützung von Kanka entfernt. Keiner Ihrer verstärkten Inhalte geht verloren (z. B. Objekt header). Wenn Sie sich erneut anmelden, haben Sie Zugriff auf alle Ihre vorherigen Daten, einschließlich der Möglichkeit, Ihre zuvor verstärkten Kampagnen zu verbessern.",
          "title": "Trennen Sie Ihr Patreon-Konto von Kanka"
        },
        "success": "Danke, dass du Kanka auf Patreon unterstützt.",
        "title": "Patreon",
        "wrong_pledge": "Euer Patreon Tier wird manuell von uns gesetzt. Daher kann es sein, dass es bis zu ein paar Tagen dauert bis es korrekt hinterlegt wird. Wenn es länger falsch ist, kontaktiert uns bitte."
      },
      "profile": {
        "actions": {
          "update_profile": "Aktualisiere dein Profil"
        },
        "avatar": "Profilbild",
        "description": "Aktualisiere dein Profil",
        "success": "Profil aktualisiert.",
        "title": "Persönliches Profil"
      },
      "subscription": {
        "actions": {
          "cancel_sub": "Abonnement beenden",
          "subscribe": "Abonnieren",
          "update_currency": "Speichern Sie die bevorzugte Währung"
        },
        "benefits": "Wenn Sie uns unterstützen, können Sie einige neue {features} freischalten und uns helfen  mehr Zeit in die Verbesserung von Kanka zu investieren. Es werden keine Kreditkarteninformationen gespeichert oder über unsere Server übertragen. Wir verwenden {stripe}, um alle Abrechnungen abzuwickeln.",
        "billing": {
          "helper": "Ihre Zahlungsinformationen werden sicher verarbeitet und gespeichert durch {stripe}. Diese Zahlungsmethode wird für alle Ihre Abonnements verwendet.",
          "saved": "Gespeicherte Zahlungsmethode",
          "title": "Zahlungsmethode ändern"
        },
        "cancel": {
          "text": "Es tut uns leid dich gehen zu sehen! Wenn Sie Ihr Abonnement kündigen, bleibt es bis zu Ihrem nächsten Abrechnungszyklus aktiv. Danach verlieren Sie Ihre Kampagnen-Boosts und andere Vorteile im Zusammenhang mit der Unterstützung von Kanka. Füllen Sie das folgende Formular aus, um uns mitzuteilen, was wir besser machen können oder was zu Ihrer Entscheidung geführt hat."
        },
        "cancelled": "Ihr Abonnement wurde gekündigt. Sie können ein Abonnement verlängern, sobald Ihr aktuelles Abonnement endet.",
        "change": {
          "text": {
            "monthly": "Sie abonnieren die {tier} Stufe , die monatlich in Rechnung gestellt wird für {amount}.",
            "yearly": "Sie abonnieren die {tier} Stufe, die jährlich in Rechnung gestellt wird für {amount}."
          },
          "title": "Abonnementstufe ändern"
        },
        "currencies": {
          "eur": "EUR",
          "usd": "USD"
        },
        "currency": {
          "title": "Ändern Sie Ihre bevorzugte Rechnungswährung"
        },
        "errors": {
          "callback": "Unser Zahlungsanbieter hat einen Fehler gemeldet. Bitte versuchen Sie es erneut oder kontaktieren Sie uns, wenn das Problem weiterhin besteht.",
          "subscribed": "Ihr Abonnement konnte nicht verarbeitet werden. Stripe lieferte den folgenden Hinweis."
        },
        "fields": {
          "active_since": "aktiv seit",
          "active_until": "aktiv bis",
          "billed_monthly": "Monatlich abgerechnet",
          "billing": "Abrechnung",
          "currency": "Abrechnungswährung",
          "payment_method": "Zahlungsmethode",
          "plan": "Derzeitiger Plan",
          "reason": "Ursache"
        },
        "helpers": {
          "alternatives": "Bezahlen Sie Ihr Abonnement mit {method}. Diese Zahlungsmethode wird am Ende Ihres Abonnements nicht automatisch verlängert. {method} ist nur in Euro verfügbar.",
          "alternatives_warning": "Ein Upgrade Ihres Abonnements mit dieser Methode ist nicht möglich. Bitte erstellen Sie ein neues Abonnement, wenn Ihr aktuelles Abonnement endet.",
          "alternatives_yearly": "Aufgrund der Einschränkungen bei wiederkehrenden Zahlungen ist die {method} nur für Jahresabonnements verfügbar"
        },
        "manage_subscription": "Abonnement verwalten",
        "payment_method": {
          "actions": {
            "add_new": "Füge eine neue Zahlungsmethode hinzu",
            "change": "Zahlungsmethode ändern",
            "save": "Zahlungsmethode speichern",
            "show_alternatives": "alternative Zahlungsoptionen"
          },
          "add_one": "Sie haben derzeit keine Zahlungsmethode gespeichert.",
          "alternatives": "Sie können diese alternativen Zahlungsoptionen abonnieren. Diese Aktion belastet Ihr Konto einmal und erneuert Ihr Abonnement nicht jeden Monat automatisch.",
          "card": "Karte",
          "card_name": "Name auf der Karte",
          "country": "Land des Wohnsitzes",
          "ending": "gültig bis",
          "helper": "Diese Karte wird für alle Ihre Abonnements verwendet.",
          "new_card": "Fügen sie eine neue Zahlungsmethode hinzu",
          "saved": "{brand} endet mit {last4}"
        },
        "placeholders": {
          "reason": "Sagen Sie uns optional, warum Sie Kanka nicht mehr unterstützen. Fehlt eine Funktion? Hat sich Ihre finanzielle Situation geändert?"
        },
        "plans": {
          "cost_monthly": "{currency} {amount} monatlich abgerechnet",
          "cost_yearly": "{currency} {amount} jährlich abgerechnet"
        },
        "sub_status": "Abonnementinformationen",
        "subscription": {
          "actions": {
            "downgrading": "Bitte kontaktieren Sie uns für ein Downgrade",
            "rollback": "Wechseln Sie zu Kobold",
            "subscribe": "Wechseln Sie zu {tier} monatlich",
            "subscribe_annual": "Wechseln Sie zu {tier} jährlich"
          }
        },
        "success": {
          "alternative": "Ihre Zahlung wurde registriert. Sie erhalten eine Benachrichtigung, sobald diese verarbeitet wurde und Ihr Abonnement aktiv ist.",
          "callback": "Ihr Abonnement war erfolgreich. Ihr Konto wird aktualisiert, sobald unsere Zahlung uns über die Änderung informiert (dies kann einige Minuten dauern).",
          "cancel": "Ihr Abonnement wurde gekündigt. Es bleibt bis zum Ende Ihres aktuellen Abrechnungszeitraums aktiv.",
          "currency": "Ihre bevorzugte Währungseinstellung wurde aktualisiert.",
          "subscribed": "Ihr Abonnement war erfolgreich. Vergessen Sie nicht, den Community Vote-Newsletter zu abonnieren, um benachrichtigt zu werden, wenn eine Abstimmung live geht. Sie können Ihre Newsletter-Einstellungen auf Ihrer Profilseite ändern."
        },
        "tiers": "Abonnementstufen",
        "trial_period": "Für Jahresabonnements gilt eine Stornierungsfrist von 14 Tagen. Kontaktieren Sie uns unter {email}, wenn Sie Ihr Jahresabonnement kündigen und eine Rückerstattung erhalten möchten.",
        "upgrade_downgrade": {
          "button": "Upgrade- und Downgrade-Informationen",
          "downgrade": {
            "bullets": {
              "end": "Ihre aktuelle Stufe bleibt bis zum Ende Ihres aktuellen Abrechnungszyklus aktiv. Danach werden Sie auf Ihre neue Stufe herabgestuft."
            },
            "title": "Beim Downgrade auf eine niedrigere Stufe"
          },
          "upgrade": {
            "bullets": {
              "immediate": "Ihre Zahlungsmethode wird sofort in Rechnung gestellt und Sie haben Zugriff auf Ihre neue Stufe.",
              "prorate": "Beim Upgrade von Owlbear auf Elemental wird Ihnen nur die Differenz zu Ihrer neuen Stufe in Rechnung gestellt."
            },
            "title": "Beim Upgrade auf eine höhere Stufe"
          }
        },
        "warnings": {
          "incomplete": "Wir konnten Ihre Kreditkarte nicht belasten. Bitte aktualisieren Sie Ihre Kreditkarteninformationen. Wir werden versuchen, sie in den nächsten Tagen erneut zu belasten. Wenn es erneut fehlschlägt, wird Ihr Abonnement gekündigt.",
          "patreon": "Ihr Konto ist derzeit mit Patreon verknüpft. Bitte trennen Sie die Verknüpfung Ihres Kontos in Ihren {patreon}-Einstellungen, bevor Sie zu einem Kanka-Abonnement wechseln."
        }
      }
    }
  },
  "en": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "Create a new conversation",
        "success": "Conversation '{name}' created.",
        "title": "New Conversation"
      },
      "destroy": {
        "success": "Conversation '{name}' removed."
      },
      "edit": {
        "description": "Update the conversation",
        "success": "Conversation '{name}' updated.",
        "title": "Conversation {name}"
      },
      "fields": {
        "messages": "Messages",
        "name": "Name",
        "participants": "Participants",
        "target": "Target",
        "type": "Type"
      },
      "hints": {
        "participants": "Please add participants to your conversation by pressing on the {icon} icon on the upper-right."
      },
      "index": {
        "add": "New Conversation",
        "description": "Manage the category of {name}.",
        "header": "Conversations in {name}",
        "title": "Conversations"
      },
      "messages": {
        "destroy": {
          "success": "Message removed."
        },
        "is_updated": "Updated",
        "load_previous": "Load previous messages",
        "placeholders": {
          "message": "Your message"
        }
      },
      "participants": {
        "create": {
          "success": "Participant {entity} added to the conversation."
        },
        "description": "Add or remove participants of a conversation",
        "destroy": {
          "success": "Participant {entity} removed from the conversation."
        },
        "modal": "Participants",
        "title": "Participants of {name}"
      },
      "placeholders": {
        "name": "Name of the conversation",
        "type": "In Game, Prep, Plot"
      },
      "show": {
        "description": "A detailed view of a conversation",
        "title": "Conversation {name}"
      },
      "tabs": {
        "conversation": "Conversation",
        "participants": "Participants"
      },
      "targets": {
        "characters": "Characters",
        "members": "Members"
      }
    },
    "crud": {
      "actions": {
        "actions": "Actions",
        "apply": "Apply",
        "back": "Back",
        "copy": "Copy",
        "copy_mention": "Copy [ ] mention",
        "copy_to_campaign": "Copy to Campaign",
        "explore_view": "Nested View",
        "export": "Export (PDF)",
        "find_out_more": "Find out more",
        "go_to": "Go to {name}",
        "json-export": "Export (JSON)",
        "more": "More Actions",
        "move": "Move",
        "new": "New",
        "next": "Next",
        "private": "Private",
        "public": "Public",
        "reset": "Reset"
      },
      "add": "Add",
      "alerts": {
        "copy_mention": "The entity's advanced mention was copied to your clipboard."
      },
      "attributes": {
        "actions": {
          "add": "Add an attribute",
          "add_block": "Add a block",
          "add_checkbox": "Add a checkbox",
          "add_text": "Add a text",
          "apply_template": "Apply an Attribute Template",
          "manage": "Manage",
          "remove_all": "Delete All"
        },
        "create": {
          "description": "Create a new attribute",
          "success": "Attribute {name} added to {entity}.",
          "title": "New Attribute for {name}"
        },
        "destroy": {
          "success": "Attribute {name} for {entity} removed."
        },
        "edit": {
          "description": "Update an existing attribute",
          "success": "Attribute {name} for {entity} updated.",
          "title": "Update attribute for {name}"
        },
        "fields": {
          "attribute": "Attribute",
          "community_templates": "Community Templates",
          "is_private": "Private Attributes",
          "is_star": "Pinned",
          "template": "Template",
          "value": "Value"
        },
        "helpers": {
          "delete_all": "Are you sure you want to delete all of this entity's attributes?"
        },
        "hints": {
          "is_private": "You can hide all the attributes of an entity for all members outside of the admin role by making it private."
        },
        "index": {
          "success": "Attributes for {entity} updated.",
          "title": "Attributes for {name}"
        },
        "placeholders": {
          "attribute": "Number of conquests, Challenge Rating, Initiative, Population",
          "block": "Block name",
          "checkbox": "Checkbox name",
          "section": "Section name",
          "template": "Select a template",
          "value": "Value of the attribute"
        },
        "template": {
          "success": "Attribute Template {name} applied to {entity}",
          "title": "Apply an Attribute Template for {name}"
        },
        "types": {
          "attribute": "Attribute",
          "block": "Block",
          "checkbox": "Checkbox",
          "section": "Section",
          "text": "Multiline Text"
        },
        "visibility": {
          "entry": "Attribute is displayed on the entity menu.",
          "private": "Attribute only visible to members of the \"Admin\" role.",
          "public": "Attribute visible to all members.",
          "tab": "Attribute is displayed only on the Attributes tab."
        }
      },
      "boosted": "Boosted",
      "boosted_campaigns": "Boosted Campaigns",
      "bulk": {
        "actions": {
          "edit": "Bulk Edit & Tagging"
        },
        "age": {
          "helper": "You can use + and - before the number to update the age by that amount."
        },
        "delete": {
          "title": "Deleting multiple entities",
          "warning": "Are you sure you want to delete the selected entities?"
        },
        "edit": {
          "tagging": "Action for tags",
          "tags": {
            "add": "Add",
            "remove": "Remove"
          },
          "title": "Editing multiple entities"
        },
        "errors": {
          "admin": "Only campaign admins can change the private status of entities.",
          "general": "An error occurred processing your action. Please try again and contact us if the problem persists. Error message: {hint}."
        },
        "permissions": {
          "fields": {
            "override": "Override"
          },
          "helpers": {
            "override": "If selected, permissions of the selected entities will be overwritten with these. If unchecked, the selected permissions will be added to the existing ones."
          },
          "title": "Change permissions for several entities"
        },
        "success": {
          "copy_to_campaign": "{1} {count} entity copied to {campaign}.|[2,*] {count} entities copied to {campaign}.",
          "editing": "{1} {count} entity was updated.|[2,*] {count} entities were updated.",
          "permissions": "{1} Permissions changed for {count} entity.|[2,*] Permissions changed for {count} entities.",
          "private": "{1} {count} entity is now private|[2,*] {count} entities are now private.",
          "public": "{1} {count} entity is now visible|[2,*] {count} entities are now visible."
        }
      },
      "cancel": "Cancel",
      "click_modal": {
        "close": "Close",
        "confirm": "Confirm",
        "title": "Confirm your action"
      },
      "copy_to_campaign": {
        "bulk_title": "Copy entities to another campaign",
        "panel": "Copy",
        "title": "Copy '{name}' to another campaign"
      },
      "create": "Create",
      "datagrid": {
        "empty": "Nothing to show yet."
      },
      "delete_modal": {
        "close": "Close",
        "delete": "Delete",
        "description": "Are you sure you want to remove {tag}?",
        "mirrored": "Remove mirrored relation.",
        "title": "Delete confirmation"
      },
      "destroy_many": {
        "success": "Deleted {count} entity|Deleted {count} entities."
      },
      "edit": "Edit",
      "errors": {
        "boosted": "This feature is only available to boosted campaigns.",
        "node_must_not_be_a_descendant": "Invalid node (tag, parent location): it would be a descendant of itself."
      },
      "events": {
        "hint": "Shown below is a list of all the Calendars in which this entity was added using the \"Add an event to a calendar\" interface."
      },
      "export": "Export",
      "fields": {
        "ability": "Ability",
        "attribute_template": "Attribute Template",
        "calendar": "Calendar",
        "calendar_date": "Calendar Date",
        "character": "Character",
        "colour": "Colour",
        "copy_attributes": "Copy Attributes",
        "copy_notes": "Copy Entity Notes",
        "creator": "Creator",
        "dice_roll": "Dice Roll",
        "entity": "Entity",
        "entity_type": "Entity Type",
        "entry": "Entry",
        "event": "Event",
        "excerpt": "Excerpt",
        "family": "Family",
        "files": "Files",
        "has_image": "Has an image",
        "header_image": "Header Image",
        "image": "Image",
        "is_private": "Private",
        "is_star": "Pinned",
        "item": "Item",
        "location": "Location",
        "map": "Map",
        "name": "Name",
        "organisation": "Organisation",
        "position": "Position",
        "race": "Race",
        "tag": "Tag",
        "tags": "Tags",
        "timeline": "Timeline",
        "tooltip": "Tooltip",
        "type": "Type",
        "visibility": "Visibility"
      },
      "files": {
        "actions": {
          "drop": "Click to Add or Drop a file",
          "manage": "Manage Entity Files"
        },
        "errors": {
          "max": "You have reached the maximum number ({max}) of files for this entity.",
          "no_files": "No files."
        },
        "files": "Uploaded Files",
        "hints": {
          "limit": "Each entity can have a maximum of {max} files uploaded to it.",
          "limitations": "Supported formats: {formats}. Max file size: {size}"
        },
        "title": "Entity Files for {name}"
      },
      "filter": "Filter",
      "filters": {
        "all": "Filter to all descendants",
        "clear": "Clear Filters",
        "direct": "Filter to direct descendants",
        "filtered": "Showing {count} of {total} {entity}.",
        "hide": "Hide Filters",
        "options": {
          "exclude": "Exclude",
          "include": "Include",
          "none": "None"
        },
        "show": "Show Filters",
        "sorting": {
          "asc": "{field} Ascending",
          "desc": "{field} Descending",
          "helper": "Control in which order results appear."
        },
        "title": "Filters"
      },
      "forms": {
        "actions": {
          "calendar": "Add a calendar date"
        },
        "copy_options": "Copy Options"
      },
      "hidden": "Hidden",
      "hints": {
        "attribute_template": "Apply an attribute template directly when creating this entity.",
        "calendar_date": "A calendar date allows easy filtering in lists, and also maintains a calendar event in the selected calendar.",
        "header_image": "This image is placed above the entity. For best results, use a wide image.",
        "image_limitations": "Supported formats: jpg, png and gif. Max file size: {size}.",
        "image_patreon": "Increase file size limit?",
        "is_private": "If set to private, this entity will only be visible to members who are in the campaign's \"Admin\" role.",
        "is_star": "Pinned elements will appear on the entity's menu",
        "map_limitations": "Supported formats: jpg, png, gif and svg. Max file size: {size}.",
        "tooltip": "Replace the automatically generated tooltip with the following contents.",
        "visibility": "Setting the visibility to admin means only members in the Admin campaign role can view this. Setting it to self means only you can view this."
      },
      "history": {
        "created": "Created by <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "created_date": "Created <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "unknown": "Unknown",
        "updated": "Last modified by <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated_date": "Last modified <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "view": "View entity log"
      },
      "image": {
        "error": "We weren't able to get the image you requested. It could be that the website doesn't allow us to download the image (typically for Squarespace and DeviantArt), or that the link is no longer valid. Please also make sure that the image isn't larger than {size}."
      },
      "is_private": "This entity is private and only visible to members of the Admin role.",
      "linking_help": "How can I link to other entries?",
      "manage": "Manage",
      "move": {
        "description": "Move this entity to another place",
        "errors": {
          "permission": "You aren't allowed to create entities of that type in the target campaign.",
          "same_campaign": "You need to select another campaign to move the entity to.",
          "unknown_campaign": "Unknown campaign."
        },
        "fields": {
          "campaign": "New campaign",
          "copy": "Make a copy",
          "target": "New type"
        },
        "hints": {
          "campaign": "You can also try to move this entity to another campaign.",
          "copy": "Select this option if you want to create copy in the new campaign.",
          "target": "Please be aware that some data might be lost when moving an element from one type to another."
        },
        "success": "Entity '{name}' moved.",
        "success_copy": "Entity '{name}' copied.",
        "title": "Move {name}"
      },
      "new_entity": {
        "error": "Please review your values.",
        "fields": {
          "name": "Name"
        },
        "title": "New entity"
      },
      "or_cancel": "or <a href=\"{url}\">cancel</a>",
      "panels": {
        "appearance": "Appearance",
        "attribute_template": "Attribute Template",
        "calendar_date": "Calendar Date",
        "entry": "Entry",
        "general_information": "General Information",
        "move": "Move",
        "system": "System"
      },
      "permissions": {
        "action": "Action",
        "actions": {
          "bulk": {
            "add": "Allow",
            "deny": "Deny",
            "ignore": "Skip",
            "remove": "Remove"
          },
          "bulk_entity": {
            "allow": "Allow",
            "deny": "Deny",
            "inherit": "Inherit"
          },
          "delete": "Delete",
          "edit": "Edit",
          "entity_note": "Entity Notes",
          "read": "Read",
          "toggle": "Toggle"
        },
        "allowed": "Allowed",
        "fields": {
          "member": "Member",
          "role": "Role"
        },
        "helper": "Use this interface to fine-tune which users and roles that can interact with this entity. {allow}",
        "helpers": {
          "setup": "Use this interface to fine-tune how roles and users can interact with this entity. {allow} will allow the user or role to do this action. {deny} will deny them that action. {inherit} will use the user's role or main role's permission. A user set to {allow} is able to do the action, even if their role is set to {deny}."
        },
        "inherited": "This role already has this permission set for this entity type.",
        "inherited_by": "This user is part of the '{role}' role which grants this permissions on this entity type.",
        "success": "Permissions saved.",
        "title": "Permissions",
        "too_many_members": "This campaign has too many members (>10) to display in this interface. Please use the Permission button on the entity view to control permissions in detail."
      },
      "placeholders": {
        "ability": "Choose an ability",
        "calendar": "Choose a calendar",
        "character": "Choose a character",
        "entity": "Entity",
        "event": "Choose an event",
        "family": "Choose a family",
        "image_url": "You can upload an image from a URL instead",
        "item": "Choose an item",
        "location": "Choose a location",
        "map": "Choose a map",
        "organisation": "Choose an organisation",
        "race": "Choose a race",
        "tag": "Choose a tag"
      },
      "relations": {
        "actions": {
          "add": "Add a relation"
        },
        "fields": {
          "location": "Location",
          "name": "Name",
          "relation": "Relation"
        },
        "hint": "Relations between entities can be set up to represent their connections."
      },
      "remove": "Remove",
      "rename": "Rename",
      "save": "Save",
      "save_and_close": "Save and Close",
      "save_and_copy": "Save and Copy",
      "save_and_new": "Save and New",
      "save_and_update": "Save and Edit",
      "save_and_view": "Save and View",
      "search": "Search",
      "select": "Select",
      "tabs": {
        "abilities": "Abilities",
        "attributes": "Attributes",
        "boost": "Boost",
        "calendars": "Calendars",
        "default": "Default",
        "events": "Events",
        "inventory": "Inventory",
        "map-points": "Map Points",
        "mentions": "Mentions",
        "menu": "Menu",
        "notes": "Entity Notes",
        "permissions": "Permissions",
        "relations": "Relations",
        "reminders": "Reminders",
        "timelines": "Timelines",
        "tooltip": "Tooltip"
      },
      "update": "Update",
      "users": {
        "unknown": "Unknown"
      },
      "view": "View",
      "visibilities": {
        "admin": "Admin",
        "admin-self": "Self & Admin",
        "all": "All",
        "self": "Self"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": [],
    "settings": {
      "account": {
        "actions": {
          "social": "Switch to Kanka Login",
          "update_email": "Update email",
          "update_password": "Update password"
        },
        "email": "Change email",
        "email_success": "Email updated.",
        "password": "Change password",
        "password_success": "Password updated.",
        "social": {
          "error": "You are already using the Kanka login for this account.",
          "helper": "Your account is currently managed by {provider}. You can stop using it and switch to the standard Kanka login by setting up a password.",
          "success": "Your account now uses the Kanka login.",
          "title": "Social to Kanka"
        },
        "title": "Account"
      },
      "api": {
        "experimental": "Welcome to the Kanka APIs! These features are still experimental but should be stable enough for you to start communicating with the APIs. Create a Personal Access Token to use in your api requests, or use the Client token if you want your app to have access to user data.",
        "help": "Kanka will soon provide an RESTful API so that third-party apps can connect to the app. Details on how to manage your API keys will be shown here.",
        "link": "Read the API documentation",
        "request_permission": "We are currently building a powerful RESTful API so that third-party apps can connect to the app. However, we are currently limiting the number of users who can interact with the API while we polish it. If you want to get access to the API and build cools apps that talk with Kanka, please contact us and we'll send you all the information you need.",
        "title": "API"
      },
      "apps": {
        "actions": {
          "connect": "Connect",
          "remove": "Remove"
        },
        "benefits": "Kanka provides a few integration to third party services. More third party integrations are planned for the future.",
        "discord": {
          "errors": {
            "add": "An error occurred linking up your Discord account with Kanka. Please try again."
          },
          "success": {
            "add": "Your Discord account has been linked.",
            "remove": "Your Discord account has been unlinked."
          },
          "text": "Access your subscription roles automatically."
        },
        "title": "App Integration"
      },
      "boost": {
        "benefits": {
          "first": "To secure continued progress on Kanka, some campaign features are unlocked by boosting a campaign. Boosts are unlocked through subscriptions. Anyone who can view a campaign can boost it, so that the DM doesn't always have to foot the bill. A campaign remains boosted as long as a user is boosting the campaign and they continue supporting Kanka. If a campaign is no longer boosted, data isn't lost, it is only hidden until the campaign is boosted again.",
          "header": "Entity header images.",
          "images": "Custom default entity images.",
          "more": "Find out more about all features.",
          "second": "Boosting a campaign enables the following benefits:",
          "theme": "Campaign level theme and custom styling.",
          "third": "To boost a campaign, go to the campaign's page, and click on the \"{boost_button}\" button above the \"{edit_button}\" button.",
          "tooltip": "Custom tooltips for entities.",
          "upload": "Increased upload size for every member in the campaign."
        },
        "buttons": {
          "boost": "Boost"
        },
        "campaigns": "Boosted Campaigns {count} / {max}",
        "exceptions": {
          "already_boosted": "Campaign {name} is already boosted.",
          "exhausted_boosts": "You are out of boosts to give. Remove your boost from a campaign before giving it to another."
        },
        "success": {
          "boost": "Campaign {name} boosted.",
          "delete": "Removed your boost from {name}."
        },
        "title": "Boost"
      },
      "countries": {
        "austria": "Austria",
        "belgium": "Belgium",
        "france": "France",
        "germany": "Germany",
        "italy": "Italy",
        "netherlands": "The Netherlands",
        "spain": "Spain"
      },
      "invoices": {
        "actions": {
          "download": "Download PDF",
          "view_all": "View all"
        },
        "empty": "No invoices",
        "fields": {
          "amount": "Amount",
          "date": "Date",
          "invoice": "Invoice",
          "status": "Status"
        },
        "header": "Below is a list of your last 24 invoices which can be downloaded.",
        "status": {
          "paid": "Paid",
          "pending": "Pending"
        },
        "title": "Invoices"
      },
      "layout": {
        "success": "Layout options updated.",
        "title": "Layout"
      },
      "menu": {
        "account": "Account",
        "api": "API",
        "apps": "Apps",
        "billing": "Payment Method",
        "boost": "Boost",
        "invoices": "Invoices",
        "layout": "Layout",
        "other": "Other",
        "patreon": "Patreon",
        "payment_options": "Payment Options",
        "personal_settings": "Personal Settings",
        "profile": "Profile",
        "subscription": "Subscription",
        "subscription_status": "Subscription Status"
      },
      "patreon": {
        "actions": {
          "link": "Link Account",
          "view": "Visit Kanka on Patreon"
        },
        "benefits": "Supporting us on {patreon} unlocks all sorts of {features} for you and your campaigns, and also helps us spend more time working on improving Kanka.",
        "benefits_features": "amazing features",
        "deprecated": "Deprecated feature - if you wish to support Kanka, please do so with a {subscription}. Patreon linking is still active for our Patrons who have linked their account before the move away from Patreon.",
        "description": "Syncing with Patreon",
        "errors": {
          "invalid_token": "Invalid token! Patreon couldn't validate your request.",
          "missing_code": "Missing code! Patreon didn't send back a code identifying your account.",
          "no_pledge": "No pledge! Patreon identified your account, but doesn't know of any active pledge."
        },
        "link": "Use the following button if you are currently supporting Kanka on {patreon}. This will unlock the bonuses",
        "linked": "Thank you for supporting Kanka on Patreon! Your account is linked.",
        "pledge": "Pledge: {name}",
        "remove": {
          "button": "Unlink your Patreon account",
          "success": "Your Patreon account has been unlinked.",
          "text": "Unlinking your Patreon account with Kanka will remove your bonuses, name on the hall of fame, campaign boosts, and other features linked to supporting Kanka. None of your boosted content will be lost (e.g. entity headers). By subscribing again, you will have access to all your previous data, including the ability to boost your previously boosted campaigns.",
          "title": "Unlink your Patreon account with Kanka"
        },
        "success": "Thank you for supporting Kanka on Patreon!",
        "title": "Patreon",
        "wrong_pledge": "Your pledge level is set manually by us, so please allow up to a few days for us to properly set it. If it stays wrong for a while, please contact us."
      },
      "profile": {
        "actions": {
          "update_profile": "Update profile"
        },
        "avatar": "Profile Picture",
        "success": "Profile updated.",
        "title": "Personal Profile"
      },
      "subscription": {
        "actions": {
          "cancel_sub": "Cancel subscription",
          "subscribe": "Subscribe",
          "update_currency": "Save prefered currency"
        },
        "benefits": "By supporting us, you can unlock some new {features} and help us invest more time into improving Kanka. No credit card information is stored or transits through our servers. We use {stripe} to handle all billing.",
        "billing": {
          "helper": "Your billing information is processed and stored safely through {stripe}. This payment method is used for all of your subscriptions.",
          "saved": "Saved payment method",
          "title": "Edit Payment Method"
        },
        "cancel": {
          "text": "Sorry to see you go! Cancelling your subscription will keep it active until your next billing cycle, after which you will lose your campaign boosts and other benefits related to supporting Kanka. Feel free to fill out the following form to inform us what we can do better, or what lead to your decision."
        },
        "cancelled": "Your subscription has been cancelled. You can renew a subscription once your current subscription ends.",
        "change": {
          "text": {
            "monthly": "You are subscribing at the {tier} tier, billed monthly for {amount}.",
            "yearly": "You are subscribing at the {tier} tier, billed annualy for {amount}."
          },
          "title": "Change Subscription Tier"
        },
        "currencies": {
          "eur": "EUR",
          "usd": "USD"
        },
        "currency": {
          "title": "Change your preferred billing currency"
        },
        "errors": {
          "callback": "Our payment provider reported an error. Please try again or contact us if the problem persists.",
          "subscribed": "Couldn't process your subscription. Stripe provided the following hint."
        },
        "fields": {
          "active_since": "Active since",
          "active_until": "Active until",
          "billing": "Billing",
          "currency": "Billing Currency",
          "payment_method": "Payment method",
          "plan": "Current plan",
          "reason": "Reason"
        },
        "helpers": {
          "alternatives": "Pay for your subscription using {method}. This payment method won't auto-renew at the end of your subscription. {method} is only available in Euros.",
          "alternatives_warning": "Upgrading your subscription when using this method is not possible. Please create a new subscription when your current one ends.",
          "alternatives_yearly": "Due to the restrictions surrounding recurring payments, {method} is only available for yearly subscriptions"
        },
        "manage_subscription": "Manage subscription",
        "payment_method": {
          "actions": {
            "add_new": "Add a new payment method",
            "change": "Change payment method",
            "save": "Save payment method",
            "show_alternatives": "Alternative payment options"
          },
          "add_one": "You currently have no payment method saved.",
          "alternatives": "You can subscribe using these alternative payment options. This action will charge your account once and not auto-renew your subscription every month.",
          "card": "Card",
          "card_name": "Name on card",
          "country": "Country of residence",
          "ending": "Ending in",
          "helper": "This card will be used for all of your subscriptions.",
          "new_card": "Add a new payment method",
          "saved": "{brand} ending with {last4}"
        },
        "placeholders": {
          "reason": "Optionally tell us why you are no longer supporting Kanka. Was a feature missing? Did your financial situation change?"
        },
        "plans": {
          "cost_monthly": "{currency} {amount} billed monthly",
          "cost_yearly": "{currency} {amount} billed yearly"
        },
        "sub_status": "Subscription information",
        "subscription": {
          "actions": {
            "downgrading": "Please contact us for downgrading",
            "rollback": "Change to Kobold",
            "subscribe": "Change to {tier} monthly",
            "subscribe_annual": "Change to {tier} yearly"
          }
        },
        "success": {
          "alternative": "Your payment was registered. You will get a notification as soon as it is processed and your subscription is active.",
          "callback": "Your subscription was successful. Your account will be updated as soon as our payment provided informs us of the change (this might take a few minutes).",
          "cancel": "Your subscription was cancelled. It will continue to be active until the end of your current billing period.",
          "currency": "Your prefered currency setting was updated.",
          "subscribed": "Your subscription was successful. Don't forget to subscribe to the Community Vote newsletter to be notified when a vote goes live. You can change your newsletter settings in your Profile page."
        },
        "tiers": "Subscription Tiers",
        "trial_period": "Yearly subscriptions have a 14 day cancellation policy. Contact us at {email} if you wish to cancel your yearly subscription and get a refund.",
        "upgrade_downgrade": {
          "button": "Upgrade & Downgrade Information",
          "downgrade": {
            "bullets": {
              "end": "Your current tier will stay active until the end of your current billing cycle, after which you will be downgraded to your new tier."
            },
            "title": "When downgrading to a lower tier"
          },
          "upgrade": {
            "bullets": {
              "immediate": "Your payment method will be billed immediately and you will have access to your new tier.",
              "prorate": "When upgrading from Owlbear to Elemental, you will only be billed the difference to your new tier."
            },
            "title": "When upgrading to a higher tier"
          }
        },
        "warnings": {
          "incomplete": "We couldn't charge your credit card. Please update your credit card information, and we will try charging it again in the next few days. If it fails again, your subscription will be cancelled.",
          "patreon": "Your account is currently linked with Patreon. Please unlink your account in your {patreon} settings before switching to a Kanka subscription."
        }
      }
    },
    "timelines": []
  },
  "en-US": {
    "calendars": [],
    "crud": {
      "fields": {
        "colour": "Color",
        "organisation": "Organization"
      },
      "placeholders": {
        "organisation": "Choose an organization"
      }
    },
    "maps": [],
    "randomisers": []
  },
  "es": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "Crear nueva conversación",
        "success": "Conversación '{name}' creada.",
        "title": "Nueva Conversación"
      },
      "destroy": {
        "success": "Conversación '{name}' eliminada."
      },
      "edit": {
        "description": "Actualizar la conversación",
        "success": "Conversación '{name}' actualizada.",
        "title": "Conversación {name}"
      },
      "fields": {
        "messages": "Mensajes",
        "name": "Nombre",
        "participants": "Participantes",
        "target": "Objetivo",
        "type": "Tipo"
      },
      "hints": {
        "participants": "Por favor, añade participantes a la conversación."
      },
      "index": {
        "add": "Nueva Conversación",
        "description": "Gestiona las conversaciones de {name}.",
        "header": "Conversaciones en {name}",
        "title": "Conversaciones"
      },
      "messages": {
        "destroy": {
          "success": "Mensaje eliminado."
        },
        "is_updated": "Actualizado",
        "load_previous": "Cargar mensajes previos",
        "placeholders": {
          "message": "Tu mensaje"
        }
      },
      "participants": {
        "create": {
          "success": "El participante {entity} se ha añadido a la conversación."
        },
        "description": "Añadir o eliminar participantes de una conversación",
        "destroy": {
          "success": "El participante {entity} se ha eliminado de la conversación."
        },
        "modal": "Participantes",
        "title": "Participantes de {name}"
      },
      "placeholders": {
        "name": "Nombre de la conversación",
        "type": "Dentro del juego, Preparación, Argumento"
      },
      "show": {
        "description": "Vista detallada de conversación",
        "title": "Conversación {name}"
      },
      "tabs": {
        "conversation": "Conversación",
        "participants": "Participantes"
      },
      "targets": {
        "characters": "Personajes",
        "members": "Miembros"
      }
    },
    "crud": {
      "actions": {
        "actions": "Acciones",
        "apply": "Aplicar",
        "back": "Atrás",
        "copy": "Copiar",
        "copy_mention": "Copiar mención [ ]",
        "copy_to_campaign": "Copiar a campaña",
        "explore_view": "Vista anidada",
        "export": "Exportar",
        "find_out_more": "Saber más",
        "go_to": "Ir a {name}",
        "json-export": "Exportar (JSON)",
        "more": "Más acciones",
        "move": "Mover",
        "new": "Nuevo",
        "next": "Siguiente",
        "private": "Privado",
        "public": "Público",
        "reset": "Restablecer"
      },
      "add": "Añadir",
      "alerts": {
        "copy_mention": "La mención avanzada de la entidad se ha copiado a tu portapapeles."
      },
      "attributes": {
        "actions": {
          "add": "Añadir atributo",
          "add_block": "Añadir un bloque",
          "add_checkbox": "Añadir una casilla",
          "add_text": "Añadir texto",
          "apply_template": "Aplicar una plantilla de atributos",
          "manage": "Administrar",
          "remove_all": "Eliminar todos"
        },
        "create": {
          "description": "Crear nuevo atributo",
          "success": "Atributo {name} añadido a {entity}.",
          "title": "Nuevo atributo para {name}"
        },
        "destroy": {
          "success": "Atributo {name} de {entity} eliminado."
        },
        "edit": {
          "description": "Actualizar un atributo existente",
          "success": "Atributo {name} de {entity} actualizado.",
          "title": "Actualizar atributo a {name}"
        },
        "fields": {
          "attribute": "Atributo",
          "community_templates": "Plantillas de la comunidad",
          "is_private": "Atributos privados",
          "is_star": "Fijado",
          "template": "Plantilla",
          "value": "Valor"
        },
        "helpers": {
          "delete_all": "¿Seguro que quieres eliminar todos los atributos de esta entidad?"
        },
        "hints": {
          "is_private": "Puedes ocultar todos los atributos de una entidad a todos los miembros no administradores haciéndola privada."
        },
        "index": {
          "success": "Atributos de {entity} actualizados.",
          "title": "Atributos de {name}"
        },
        "placeholders": {
          "attribute": "Número de conquistas, Iniciativa, Población",
          "block": "Nombre del bloque",
          "checkbox": "Nombre de la casilla",
          "section": "Nombre de la sección",
          "template": "Seleccionar plantilla",
          "value": "Valor del atributo"
        },
        "template": {
          "success": "Plantilla de atributos {name} aplicada en {entity}",
          "title": "Aplicar plantilla de atributos a {name}"
        },
        "types": {
          "attribute": "Atributo",
          "block": "Bloque",
          "checkbox": "Casilla",
          "section": "Sección",
          "text": "Texto multilínea"
        },
        "visibility": {
          "entry": "El atributo se muestra en el menú de la entidad.",
          "private": "Atributo visible solo para miembros con el rol \"Admin\".",
          "public": "Atributo visible por todos los miembros.",
          "tab": "El atributo se muestra solo en la pestaña de Atributos."
        }
      },
      "boosted": "mejorada",
      "boosted_campaigns": "Campañas mejoradas",
      "bulk": {
        "actions": {
          "edit": "Editar y etiquetar en lote"
        },
        "age": {
          "helper": "Puedes usar + y - antes del número para actualizar la edad en dicha cantidad."
        },
        "delete": {
          "title": "Eliminar múltiples entidades",
          "warning": "¿Seguro que quieres eliminar las entidades seleccionadas?"
        },
        "edit": {
          "tagging": "Acción para las etiquetas",
          "tags": {
            "add": "Añadir",
            "remove": "Eliminar"
          },
          "title": "Editando múltiples entidades"
        },
        "errors": {
          "admin": "Solamente los administradores de la campaña pueden cambiar el estatus privado de las entidades.",
          "general": "Ha habido un error al procesar la acción. Vuelve a intentarlo o contáctanos si el problema persiste. Mensaje de error: {hint}."
        },
        "permissions": {
          "fields": {
            "override": "Ignorar"
          },
          "helpers": {
            "override": "Si está seleccionado, los permisos de las entidades seleccionadas serán ignorados y en cambio usarán estos ajustes. Si no está seleccionado, los estos permisos se añadirán a los existentes."
          },
          "title": "Cambiar permisos a varias entidades"
        },
        "success": {
          "copy_to_campaign": "{1} {count} entidad copiada a {campaign}.|[2,*] {count} entidades copiadas a {campaign}.",
          "editing": "{count} entidad se ha actualizado.|{count} entidades se han actualizado.",
          "permissions": "Permisos cambiados en {count} entidad.|Permisos cambiados en {count} entidades.",
          "private": "{count} entidad es ahora privada|{count} entidades son ahora privadas.",
          "public": "{count} entidad es ahora visible|{count} son ahora visibles."
        }
      },
      "cancel": "Cancelar",
      "click_modal": {
        "close": "Cerrar",
        "confirm": "Confirmar",
        "title": "Confirmar acción"
      },
      "copy_to_campaign": {
        "bulk_title": "Copiar entidades a otra campaña",
        "panel": "Copiar",
        "title": "Copiar '{name}' a otra campaña"
      },
      "create": "Crear",
      "datagrid": {
        "empty": "Aún no hay nada que mostrar."
      },
      "delete_modal": {
        "close": "Cerrar",
        "delete": "Eliminar",
        "description": "¿Seguro que quieres eliminar {tag}?",
        "mirrored": "Eliminar relación reflejada",
        "title": "Eliminar"
      },
      "destroy_many": {
        "success": "{count} entidad eliminada|{count} entidades eliminadas."
      },
      "edit": "Editar",
      "errors": {
        "boosted": "Esta función solo está disponible para las campañas mejoradas.",
        "node_must_not_be_a_descendant": "Nodo inválido (categoría, localización superior): sería un descendiente de sí mismo."
      },
      "events": {
        "hint": "Los eventos del calendario asociados a esta entidad se muestran aquí."
      },
      "export": "Exportar",
      "fields": {
        "ability": "Habilidad",
        "attribute_template": "Plantilla de atributos",
        "calendar": "Calendario",
        "calendar_date": "Fecha del calendario",
        "character": "Personaje",
        "colour": "Color",
        "copy_attributes": "Copiar atributos",
        "copy_notes": "Copiar notas de la entidad",
        "creator": "Creador",
        "dice_roll": "Tirada de dados",
        "entity": "Entidad",
        "entity_type": "Tipo de entidad",
        "entry": "Entrada",
        "event": "Evento",
        "excerpt": "Extracto",
        "family": "Familia",
        "files": "Archivos",
        "has_image": "Tiene imagen",
        "header_image": "Imagen de cabecera",
        "image": "Imagen",
        "is_private": "Privado",
        "is_star": "Fijada",
        "item": "Objeto",
        "location": "Localización",
        "map": "Mapa",
        "name": "Nombre",
        "organisation": "Organización",
        "position": "Posición",
        "race": "Raza",
        "tag": "Etiqueta",
        "tags": "Etiquetas",
        "timeline": "Línea de tiempo",
        "tooltip": "Descripción emergente",
        "type": "Tipo",
        "visibility": "Visibilidad"
      },
      "files": {
        "actions": {
          "drop": "Haz clic para añadir o arrastra un archivo",
          "manage": "Administrar archivos de la entidad"
        },
        "errors": {
          "max": "Has alcanzado el número máximo ({max}) de archivos para esta entidad.",
          "no_files": "No hay archivos."
        },
        "files": "Archivos subidos",
        "hints": {
          "limit": "Cada entidad puede tener un máximo de {max} archivos.",
          "limitations": "Formatos soportados: jpg, png, gif y pdf. Tamaño máximo de archivo: {size}"
        },
        "title": "Archivos de {name}"
      },
      "filter": "Filtrar",
      "filters": {
        "all": "Mostrar todos los descendientes",
        "clear": "Quitar filtros",
        "direct": "Filtrar solo los descendientes directos",
        "filtered": "Mostrando {count} de {total} {entity}.",
        "hide": "Ocultar filtros",
        "options": {
          "exclude": "Excluir",
          "include": "Incluir",
          "none": "Nada"
        },
        "show": "Mostrar filtros",
        "sorting": {
          "asc": "Ascendiente por {field}",
          "desc": "Descendiente por {field}",
          "helper": "Controla en qué orden aparecen los resultados."
        },
        "title": "Filtros"
      },
      "forms": {
        "actions": {
          "calendar": "Añadir fecha de calendario"
        },
        "copy_options": "Opciones de copia"
      },
      "hidden": "Oculto",
      "hints": {
        "attribute_template": "Aplica una plantilla de atributos directamente al crear esta entidad.",
        "calendar_date": "Las fechas de calendario hacen que sea más fácil filtrar las listas, y también fijan los eventos al calendario seleccionado.",
        "header_image": "Esta imagen está situada sobre la entidad. Para obtener mejores resultados, usa una imagen apaisada.",
        "image_limitations": "Formatos soportados: jpg, png y gif. Tamaño máximo del archivo: {size}.",
        "image_patreon": "Aumenta el límite apoyándonos en Patreon",
        "is_private": "Ocultar a los \"Invitados\"",
        "is_star": "Los elementos fijados aparecerán en el menú principal de la entidad.",
        "map_limitations": "Formatos soportados: jpg, png, gif y svg. Tamaño máximo del archivo: {size}.",
        "tooltip": "Reemplaza la descripción emergente automática con uno de los siguientes contenidos.",
        "visibility": "Al seleccionar \"Administrador\", solo los miembros con el rol de administrador podrán ver esto. \"Solo yo\" significa que solo tú puedes ver esto."
      },
      "history": {
        "created": "Creado por <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "created_date": "Creado <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "unknown": "Desconocido",
        "updated": "Última modificación por <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated_date": "Última modificación <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "view": "Historial de cambios de la entidad"
      },
      "image": {
        "error": "No hemos podido obtener la imagen. Puede que la página web no nos permita descargarla (típico de Squarespace o DeviantArt), o que el enlace ya no es válido."
      },
      "is_private": "Esta entidad es privada y no será visible por los usuarios Invitados.",
      "linking_help": "¿Como puedo enlazar otras entradas?",
      "manage": "Administrar",
      "move": {
        "description": "Mover esta entidad a otro lugar",
        "errors": {
          "permission": "No tienes permiso para crear entidades de este tipo en la campaña seleccionada.",
          "same_campaign": "Debes seleccionar otra campaña donde mover la entidad.",
          "unknown_campaign": "Campaña desconocida."
        },
        "fields": {
          "campaign": "Nueva campaña",
          "copy": "Hacer una copia",
          "target": "Nuevo tipo"
        },
        "hints": {
          "campaign": "También puedes intentar mover esta entidad a otra campaña.",
          "copy": "Selecciona esta opción si quieres crear una copia en la nueva campaña.",
          "target": "Por favor ten en cuenta que algunos datos pueden perderse al mover un elemento de un tipo a otro."
        },
        "success": "Entidad '{name}' movida.",
        "success_copy": "Entidad '{name}' copiada.",
        "title": "Mover {name}"
      },
      "new_entity": {
        "error": "Por favor revisa lo introducido.",
        "fields": {
          "name": "Nombre"
        },
        "title": "Nueva entidad"
      },
      "or_cancel": "o <a href=\"{url}\">Cancelar</a>",
      "panels": {
        "appearance": "Apariencia",
        "attribute_template": "Plantilla de atributos",
        "calendar_date": "Fecha de calendario",
        "entry": "Presentación",
        "general_information": "Información general",
        "move": "Mover",
        "system": "Sistema"
      },
      "permissions": {
        "action": "Acción",
        "actions": {
          "bulk": {
            "add": "Permitir",
            "deny": "Denegar",
            "ignore": "Ignorar",
            "remove": "Quitar"
          },
          "bulk_entity": {
            "allow": "Permitir",
            "deny": "Denegar",
            "inherit": "Heredar"
          },
          "delete": "Eliminar",
          "edit": "Editar",
          "entity_note": "Notas de entidad",
          "read": "Leer",
          "toggle": "Cambiar"
        },
        "allowed": "Permitido",
        "fields": {
          "member": "Miembro",
          "role": "Rol"
        },
        "helper": "Usa esta interfaz para afinar qué usuarios y roles pueden interactuar con esta entidad.",
        "helpers": {
          "entity_note": "Permite a los usuarios crear notas dentro de esta entidad. Sin este permiso, podrán seguir viendo las notas de entidad que se muestren a todos.",
          "setup": "Usa esta interfaz para afinar cómo los diferentes roles y usuarios pueden interactuar con esta entidad. {allow} les permitirá hacer dicha acción; {deny} se la denegará, y {inherit} usará el permiso que ya tenga el rol o usuario. Un usuario con una acción puesta en {allow} podrá hacerla, aunque su rol esté en {deny}."
        },
        "inherited": "Este rol ya tiene este permiso en esta entidad.",
        "inherited_by": "Este usuario forma parte del rol \"{role}\", que le otorga este permiso en esta entidad.",
        "success": "Permisos guardados.",
        "title": "Permisos",
        "too_many_members": "Esta campaña tiene demasiados miembros (>10) para mostrarlos todos en esta interfaz. Puedes usar el botón de permisos en la vista de entidad para controlar los permisos detalladamente."
      },
      "placeholders": {
        "ability": "Escoge una habilidad",
        "calendar": "Escoge un calendario",
        "character": "Escoge un personaje",
        "entity": "Entidad",
        "event": "Elige un evento",
        "family": "Elige una familia",
        "image_url": "Puedes subir una imagen desde una URL",
        "item": "Elige un objeto",
        "location": "Escoge una localización",
        "map": "Elige un mapa",
        "organisation": "Elige una organización",
        "race": "Elige una raza",
        "tag": "Elige una etiqueta"
      },
      "relations": {
        "actions": {
          "add": "Añadir una relación"
        },
        "fields": {
          "location": "Localización",
          "name": "Nombre",
          "relation": "Relación"
        },
        "hint": "Se pueden relacionar entidades para representar sus conexiones."
      },
      "remove": "Eliminar",
      "rename": "Renombrar",
      "save": "Guardar",
      "save_and_close": "Guardar y cerrar",
      "save_and_copy": "Guardar y copiar",
      "save_and_new": "Guardar y crear nuevo",
      "save_and_update": "Guardar y seguir editando",
      "save_and_view": "Guardar y ver",
      "search": "Buscar",
      "select": "Seleccionar",
      "tabs": {
        "abilities": "Habilidades",
        "attributes": "Atributos",
        "boost": "Mejorar",
        "calendars": "Calendarios",
        "default": "Por defecto",
        "events": "Eventos",
        "inventory": "Inventario",
        "map-points": "Puntos del mapa",
        "mentions": "Menciones",
        "menu": "Menú",
        "notes": "Notas",
        "permissions": "Permisos",
        "relations": "Relaciones",
        "reminders": "Recordatorios",
        "timelines": "Líneas de tiempo",
        "tooltip": "Descripción emergente"
      },
      "update": "Actualizar",
      "users": {
        "unknown": "Desconocido"
      },
      "view": "Ver",
      "visibilities": {
        "admin": "Admin",
        "admin-self": "Yo + Admin",
        "all": "Todos",
        "self": "Solo yo"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": [],
    "settings": {
      "account": {
        "actions": {
          "social": "Cambiar a inicio de sesión en Kanka",
          "update_email": "Actualizar email",
          "update_password": "Actualizar contraseña"
        },
        "description": "Actualizar cuenta",
        "email": "Cambiar email",
        "email_success": "Email actualizado.",
        "password": "Cambiar contraseña",
        "password_success": "Contraseña actualizada.",
        "social": {
          "error": "Ya estás utilizando el inicio de sesión de Kanka con esta cuenta.",
          "helper": "Tu cuenta está vinculada con {provider}. Puedes dejar de usarla y cambiar al inicio de sesión estándar de Kanka escribiendo una contraseña.",
          "success": "Tu cuenta ahora usa el inicio de sesión de Kanka.",
          "title": "De social a Kanka"
        },
        "title": "Cuenta"
      },
      "api": {
        "description": "Actualizar configuración de API",
        "experimental": "¡Bienvenido a las APIs de Kanka! Estas prestaciones aún son experimentales pero deberían ser lo suficientemente estables para que puedas comunicarte con las APIs. Crea un Token de Acceso Personal para usar en tus solicitudes de API, o usa el Token Cliente si quieres que tu app tenga acceso a datos de usuario.",
        "help": "Kanka ofrecerá próximamente una RESTful API para que aplicaciones terceras puedan conectarse a la app. Aquí se irán mostrando los detalles sobre cómo gestionar tus claves API.",
        "link": "Leer la documentación de la API",
        "request_permission": "Actualmente estamos construyendo una poderosa RESTful API para que aplicaciones terceras puedan conectarse a la app. Sin embargo, de momento limitamos el número de usuarios que pueden interactuar con la API mientras la pulimos. Si quieres acceder a la API y construir apps guays que interactúan con Kanka, contáctanos y te enviaremos toda la información que necesitas.",
        "title": "API"
      },
      "apps": {
        "actions": {
          "connect": "Conectar",
          "remove": "Eliminar"
        },
        "benefits": "Kanka ofrece algunas integraciones con servicios de terceros. Hay más integraciones planeadas para el futuro.",
        "discord": {
          "errors": {
            "add": "Ha ocurrido un error tratando de vincular tu cuenta de Discord con Kanka. Por favor, inténtalo de nuevo."
          },
          "success": {
            "add": "Se ha vinculado tu cuenta de Discord.",
            "remove": "Se ha desvinculado tu cuenta de Discord."
          },
          "text": "Accede a los roles de suscripción automáticamente."
        },
        "title": "Integración de aplicaciones"
      },
      "boost": {
        "benefits": {
          "first": "Para asegurar un progreso contínuo en Kanka, algunas características de campaña se pueden desbloquear mejorando la campaña. Las mejoras se desbloquean mediante {patreon}. Cualquiera que pueda ver una campaña puede mejorarla; así el máster no tiene que pagar la cuenta siempre. Una campaña permanece mejorada mientras un usuario la esté mejorando y continúe apoyando a Kanka en {patreon}. Si una campaña deja de estar mejorada, los datos no se pierden: solo permanecen ocultos hasta que la campaña vuelva a ser mejorada.",
          "header": "Imágenes de cabecera para las entidades.",
          "images": "Imágenes por defecto personalizadas",
          "more": "Saber más sobre todas las características.",
          "second": "Mejorar una campaña activa los siguientes beneficios:",
          "theme": "Tema y estilo personalizado a nivel de campaña.",
          "third": "Para mejorar una campaña, dirígete a la página de la campaña y haz clic en el botón de \"{boost_button}\" que hay sobre el botón de \"{edit_button}\".",
          "tooltip": "Descripciones emergentes personalizadas para las entidades.",
          "upload": "Capacidad de subida de archivos ampliada para todos los miembros de la campaña."
        },
        "buttons": {
          "boost": "Mejorar"
        },
        "campaigns": "Campañas mejoradas {count} / {max}",
        "exceptions": {
          "already_boosted": "La campaña {name} ya está mejorada.",
          "exhausted_boosts": "Te has quedado sin mejoras. Elimina tu mejora de una campaña antes de dársela a otra."
        },
        "success": {
          "boost": "Campaña {name} mejorada.",
          "delete": "Tu mejora de {name} se ha eliminado."
        },
        "title": "Mejorar"
      },
      "countries": {
        "austria": "Austria",
        "belgium": "Bégica",
        "france": "Francia",
        "germany": "Alemania",
        "italy": "Italia",
        "netherlands": "Holanda",
        "spain": "España"
      },
      "invoices": {
        "actions": {
          "download": "Descargar PDF",
          "view_all": "Ver todas"
        },
        "empty": "Sin facturas",
        "fields": {
          "amount": "Cantidad",
          "date": "Fecha",
          "invoice": "Factura",
          "status": "Estado"
        },
        "header": "Puedes descargar tus últimas 24 facturas a continuación.",
        "status": {
          "paid": "Pagada",
          "pending": "Pendiente"
        },
        "title": "Facturas"
      },
      "layout": {
        "description": "Actualizar opciones de diseño",
        "success": "Opciones de diseño actualizadas.",
        "title": "Diseño"
      },
      "menu": {
        "account": "Cuenta",
        "api": "API",
        "apps": "Aplicaciones",
        "billing": "Método de pago",
        "boost": "Mejorar",
        "invoices": "Facturas",
        "layout": "Diseño",
        "other": "Otros",
        "patreon": "Patreon",
        "payment_options": "Opciones de pago",
        "personal_settings": "Ajustes personales",
        "profile": "Perfil",
        "subscription": "Suscripción",
        "subscription_status": "Estado de la suscripción"
      },
      "patreon": {
        "actions": {
          "link": "Enlazar cuenta",
          "view": "Visita la página de Patreon de Kanka"
        },
        "benefits": "Si nos ayudas en Patreon podrás subir imágenes más pesadas, y así nos ayudarás a cubrir los costes del servidor y a dedicarle más tiempo a trabajar en Kanka.",
        "benefits_features": "Funciones increíbles",
        "deprecated": "Funcionalidad discontinuada. Si deseas apoyar a Kanka, puedes hacerlo mediante una {subscription}. La vinculación con Patreon aún sigue activa para nuestros Patrons que vincularon sus cuentas antes de la mudanza de Patreon.",
        "description": "Sincronizando con Patreon",
        "errors": {
          "invalid_token": "¡Token no válido! Patreon no ha podido validar tu petición.",
          "missing_code": "¡Falta el código! Patreon no ha enviado un código para identificar tu cuenta.",
          "no_pledge": "¡Sin \"pledge\"! Patreon ha identificado tu cuenta, pero no detecta ningún \"pledge\" activo."
        },
        "link": "Usa el siguiente botón si estás apoyando a Kanka en Patreon actualmente. ¡Esto te dará acceso a más cosas fantásticas extras!",
        "linked": "¡Gracias por apoyar a Kanka en Patreon! Se ha enlazado tu cuenta.",
        "pledge": "Pledge {name}",
        "remove": {
          "button": "Desvincular mi cuenta de Patreon",
          "success": "Tu cuenta de Patreon se ha desvinculado.",
          "text": "Desvincular tu cuenta de Patreon de Kanka eliminará tus bonus, tu nombre en el salón de la fama, tus mejoras y otras funcionalidades vinculadas. Sin embargo, tu contenido mejorado no se perderá: si vuelves a suscribirte, volverás a tener acceso a esos datos, incluyendo la posibilidad de volver a mejorar dicha campaña.",
          "title": "Desvincular mi cuenta de Patreon de Kanka"
        },
        "success": "¡Gracias por apoyar a Kanka en Patreon!",
        "title": "Patreon",
        "wrong_pledge": "Añadimos manualmente tu nivel de \"pledge\", así que ten en cuenta que podemos tardar unos pocos días. Si al cabo de un tiempo sigue sin estar bien, contáctanos por favor."
      },
      "profile": {
        "actions": {
          "update_profile": "Actualizar perfil"
        },
        "avatar": "Foto de perfil",
        "description": "Actualizar perfil",
        "success": "Perfil actualizado.",
        "title": "Perfil personal"
      },
      "subscription": {
        "actions": {
          "cancel_sub": "Cancelar suscripción",
          "subscribe": "Suscribirse",
          "update_currency": "Guardar moneda preferida"
        },
        "benefits": "Si nos apoyas, desbloquearás algunas nuevas {features} y nos ayudarás a dedicar más tiempo a la mejora de Kanka. No guardaremos tu información bancaria. Usamos {stripe} para gestionar los cobros.",
        "billing": {
          "helper": "Tu información de pago se procesa y se guarda de forma segura mediante {stripe}. Este método de pago se usará para todas tus suscripciones.",
          "saved": "Método de pago guardado",
          "title": "Editar método de pago"
        },
        "cancel": {
          "text": "¡Lamentamos verte marchar! Al cancelar tu suscripción, esta seguirá activa hasta el nuevo ciclo de facturación, tras lo cual perderás tus mejoras de campaña y otros beneficios relacionados. No tengas miedo de informarnos sobre cómo podemos mejorar o qué te ha llevado a tomar esta decisión."
        },
        "cancelled": "Se ha cancelado tu suscripción. Puedes renovarla una vez el período de la suscripción actual termine.",
        "change": {
          "text": {
            "monthly": "Estás suscribiéndote al nivel {tier}, que cuesta {amount} mensuales.",
            "yearly": "Estás suscribiéndote al nivel {tier}, que cuesta {amount} anuales."
          },
          "title": "Cambiar nivel de suscripción"
        },
        "currencies": {
          "eur": "Euros",
          "usd": "Dólares estadounidenses"
        },
        "currency": {
          "title": "Cambia la moneda de facturación"
        },
        "errors": {
          "callback": "Nuestro proveedor de pagos nos ha informado de un error. Por favor, vuelve a intentarlo o infórmanos si el problema persiste.",
          "subscribed": "No se ha podido procesar tu suscripción. Stripe nos ha dado este mensaje:"
        },
        "fields": {
          "active_since": "Activa desde",
          "active_until": "Activa hasta",
          "billed_monthly": "Cobro mensual",
          "billing": "Cobro",
          "currency": "Moneda de cobro",
          "payment_method": "Método de pago",
          "plan": "Plan actual",
          "reason": "Razón"
        },
        "helpers": {
          "alternatives": "Paga por tu suscripción usando {method}. Este método de pago no se renovará automáticamente al final de tu suscripción. {method} solo está disponible en euros.",
          "alternatives_warning": "No se puede mejorar la suscripción usando este método. Por favor, crea una nueva suscripción cuando la actual termine.",
          "alternatives_yearly": "Debido a las restricciones de los pagos recurrentes, {method} solo está disponible para las suscripciones anuales."
        },
        "manage_subscription": "Gestionar suscripción",
        "payment_method": {
          "actions": {
            "add_new": "Añadir nuevo método de pago",
            "change": "Cambiar método de pago",
            "save": "Guardar método de pago",
            "show_alternatives": "Métodos de pago alternativos"
          },
          "add_one": "Aún no tienes ningún método de pago guardado.",
          "alternatives": "Puedes suscribirte usando estos métodos de pago alternativos. Esto hará un solo cobro en tu cuenta y no se renovará automáticamente cada mes.",
          "card": "Tarjeta",
          "card_name": "Nombre en la tarjeta",
          "country": "País de residencia",
          "ending": "Termina en",
          "helper": "Se usará esta tarjeta para todas tus suscripciones.",
          "new_card": "Añadir nuevo método de pago",
          "saved": "{brand} que termina en {last4}"
        },
        "placeholders": {
          "reason": "Opcionalmente, puedes contarnos por qué ya no apoyas a Kanka. ¿Faltaba algo? ¿Cambió tu situación financiera?"
        },
        "plans": {
          "cost_monthly": "{amount} {currency} mensuales",
          "cost_yearly": "{amount} {currency} anuales"
        },
        "sub_status": "Información sobre la suscripción",
        "subscription": {
          "actions": {
            "downgrading": "Contáctanos para bajar de nivel",
            "rollback": "Cambiar a Kobold",
            "subscribe": "Cambiar a {tier} al mes",
            "subscribe_annual": "Cambiar a {tier} anualmente"
          }
        },
        "success": {
          "alternative": "Se ha registrado tu pago. Recibirás una notificación en cuanto terminemos de procesarlo y se active tu suscripción.",
          "callback": "Tu suscripción ha tenido éxito. Tu cuenta será actualizada en cuanto nuestro proveedor de pagos nos informe del cambio (puede llevar algunos minutos).",
          "cancel": "Se ha cancelado tu suscripción. Continuará activa hasta el final del período de pago.",
          "currency": "Se ha actualizado tu moneda preferida.",
          "subscribed": "Tu suscripción ha tenido éxito. ¡No te olvides de suscribirte a la newsletter de votaciones comunitarias para enterarte cuando se abra una votación! Puedes cambiar tu configuración de newsletters en tu perfil."
        },
        "tiers": "Niveles de suscripción",
        "trial_period": "Las suscripciones anuales tienen un período de cancelación de 14 días. Contáctanos en {email} si quieres cancelar tu suscripción anual y recuperar el dinero.",
        "upgrade_downgrade": {
          "button": "Información acerca de subir o bajar de nivel",
          "downgrade": {
            "bullets": {
              "end": "Tu nivel actual estará activo hasta el final de tu ciclo de pago actual, tras el cual se bajará tu suscripción al nuevo nivel."
            },
            "title": "Bajar de nivel"
          },
          "upgrade": {
            "bullets": {
              "immediate": "Se cobrará en tu método de pago inmediatamente y tendrás acceso al nuevo nivel.",
              "prorate": "Al subir de nivel de Owlbear a Elemental, solo se te cobrará la diferencia entre los dos niveles."
            },
            "title": "Subir de nivel"
          }
        },
        "warnings": {
          "incomplete": "No hemos podido hacer el cobro en tu tarjeta de crédito. Por favor, actualiza la información de la tarjeta y volveremos a intentarlo en los próximos días. Si vuelve a fallar, tu suscripción será cancelada.",
          "patreon": "Tu cuenta se encuentra vinculada con Patreon. Desvincúlala en la configuración de {patreon} antes de cambiarla por una suscripción de Kanka."
        }
      }
    }
  },
  "fr": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "Créer une nouvelle conversation",
        "success": "Conversation '{name}' créée.",
        "title": "Nouvelle Conversation"
      },
      "destroy": {
        "success": "Conversation '{name}' supprimée."
      },
      "edit": {
        "description": "Modifier la conversation",
        "success": "Conversation '{name}' modifiée.",
        "title": "Conversation {name}"
      },
      "fields": {
        "messages": "Messages",
        "name": "Nom",
        "participants": "Participants",
        "target": "CIble",
        "type": "Type"
      },
      "hints": {
        "participants": "Ajoute des participants à la conversation."
      },
      "index": {
        "add": "Nouvelle Conversation",
        "description": "Gérer les conversations de {name}.",
        "header": "Conversations dans {name}",
        "title": "Conversations"
      },
      "messages": {
        "destroy": {
          "success": "Message supprimé."
        },
        "is_updated": "Modifié",
        "load_previous": "Messages précédants",
        "placeholders": {
          "message": "Ton message"
        }
      },
      "participants": {
        "create": {
          "success": "Participant {entity} ajouté à la conversation."
        },
        "description": "Ajouter ou retirer des participants à une conversation",
        "destroy": {
          "success": "Participant {entity} retiré de la conversation."
        },
        "modal": "Participants",
        "title": "Participants de {name}"
      },
      "placeholders": {
        "name": "Nom de la conversation",
        "type": "In Game, Préparation, Quête"
      },
      "show": {
        "description": "Vue détaillée d'une conversation",
        "title": "Conversation {name}"
      },
      "tabs": {
        "conversation": "Conversation",
        "participants": "Participants"
      },
      "targets": {
        "characters": "Personnages",
        "members": "Membres"
      }
    },
    "crud": {
      "actions": {
        "actions": "Actions",
        "apply": "Appliquer",
        "back": "Retour",
        "copy": "Copier",
        "copy_mention": "Copier mention [ ]",
        "copy_to_campaign": "Copier vers une campagne",
        "explore_view": "Vue Imbriquée",
        "export": "Export",
        "find_out_more": "En savoir plus",
        "go_to": "Aller à {name}",
        "json-export": "Export (JSON)",
        "more": "Autres Actions",
        "move": "Déplacer",
        "new": "Nouveau",
        "next": "Prochain",
        "private": "Privé",
        "public": "Publique",
        "reset": "Réinitialiser"
      },
      "add": "Ajouter",
      "alerts": {
        "copy_mention": "La mention avancée de cette entité a été copier au presse-papier."
      },
      "attributes": {
        "actions": {
          "add": "Ajouter un attribut",
          "add_block": "Ajouter un block",
          "add_checkbox": "Ajouter une case à docher",
          "add_text": "Ajouter un text",
          "apply_template": "Appliquer un modèle d'attribut",
          "manage": "Gérer",
          "remove_all": "Tout supprimer"
        },
        "create": {
          "description": "Créer un nouvel attribut",
          "success": "Attribut {name} ajouté à {entity}.",
          "title": "Nouvel attribut pour {name}"
        },
        "destroy": {
          "success": "Attribut {name} supprimé de {entity}."
        },
        "edit": {
          "description": "Modifier un attribut existant",
          "success": "Attribut {name} modifié pour {entity}.",
          "title": "Modifier l'attribut pour {name}"
        },
        "fields": {
          "attribute": "Attribut",
          "community_templates": "Modèles Communautaire",
          "is_private": "Attributs privés",
          "is_star": "Épinglé",
          "template": "Modèle",
          "value": "Valeur"
        },
        "helpers": {
          "delete_all": "Es-tu certain de vouloir supprimer tous les attributs de cette entité?"
        },
        "hints": {
          "is_private": "Tous les attributs d'une entité peuvent être cachés des membres non-admin."
        },
        "index": {
          "success": "Attributs modifiés pour {entity}.",
          "title": "Attributs pour {name}"
        },
        "placeholders": {
          "attribute": "Nombre de quêtes, niveau de difficulté, initiative, population",
          "block": "Nom du bloque",
          "checkbox": "Nom de la case à cocher",
          "section": "Nom de la section",
          "template": "Sélectionner un modèle",
          "value": "Valeur de l'attribut"
        },
        "template": {
          "success": "Modèle d'attribut {name} appliqué pour {entity}.",
          "title": "Appliquer un modèle d'attribut pour {name}"
        },
        "types": {
          "attribute": "Attribut",
          "block": "Block",
          "checkbox": "Case à cocher",
          "section": "Section",
          "text": "Texte multiligne"
        },
        "visibility": {
          "entry": "Attribut affiché sur le menu d'entité.",
          "private": "Attribut seulement visible aux membres du rôle \"Admin\".",
          "public": "Attribut visible par tous les membres.",
          "tab": "Attribut visible sous l'onglet Attributs."
        }
      },
      "boosted": "Boosté",
      "boosted_campaigns": "Campagnes Boostées",
      "bulk": {
        "actions": {
          "edit": "Opération de masse"
        },
        "age": {
          "helper": "Il est possible de préfixer le numéro avec + ou - pour modifier l'age dynamiquement."
        },
        "delete": {
          "title": "Suppression de plusieurs entités",
          "warning": "Es-tu sûr de vouloir supprimer les entités sélectionnées?"
        },
        "edit": {
          "tagging": "Action pour les étiquettes",
          "tags": {
            "add": "Ajouter",
            "remove": "Retirer"
          },
          "title": "Modifications de plusieurs entités"
        },
        "errors": {
          "admin": "Seulement les membres administrateur de la campagne peuvent changer le status des entités.",
          "general": "Un problème est survenu lors de l'exécution. Prière de ressayer de nouveau ou nous contacter en cas de problème persistant. Message d'erreur: {hint}."
        },
        "permissions": {
          "fields": {
            "override": "Remplacer"
          },
          "helpers": {
            "override": "Si sélectionné, les permissions des entités sélectionnées seront remplacer par ceux-ci. Si non-sélectionné, les permissions sélectionnées seront ajoutées à celles existantes."
          },
          "title": "Changer les permissions pour plusieurs entités"
        },
        "success": {
          "copy_to_campaign": "{1} {count} entité copiée à {campaign}.|[2,*] {count} entités copiées à {campaign}.",
          "editing": "{count} entité modifiée.|{count} entités modifiées.",
          "permissions": "Permissions changées pour {count} entité. |Permissions changées pour {count} entités.",
          "private": "{count} entité est maintenant privée.|{count} entitées sont maintenant privées.",
          "public": "{count} entité est maintenant visible.|{count} entitées sont maintenant visibles."
        }
      },
      "cancel": "Annuler",
      "click_modal": {
        "close": "Fermer",
        "confirm": "Confirmer",
        "title": "Confirme ton action"
      },
      "copy_to_campaign": {
        "bulk_title": "Copier vers une campagne",
        "panel": "Copier",
        "title": "Copier '{name}' vers une autre campagne"
      },
      "create": "Créer",
      "datagrid": {
        "empty": "Rien à afficher."
      },
      "delete_modal": {
        "close": "Fermer",
        "delete": "Supprimer",
        "description": "Est-tu sûr de vouloir supprimer {tag}?",
        "mirrored": "Supprimer la relation liée.",
        "title": "Confirmation la suppression"
      },
      "destroy_many": {
        "success": "{count} élément supprimé.|{count} éléments supprimés."
      },
      "edit": "Modifier",
      "errors": {
        "boosted": "Cette fonctionalité n'est que accessible pour aux campagnes boostées..",
        "node_must_not_be_a_descendant": "Node invalide (étiquette, lieu parent): l'entité serait un descendant de lui-même."
      },
      "events": {
        "hint": "Les événements de calendrier peuvent être associé à cette entité et être affiché ici."
      },
      "export": "Export",
      "fields": {
        "ability": "Pouvoirs",
        "attribute_template": "Modèle d'attribut",
        "calendar": "Calendrier",
        "calendar_date": "Date calendrier",
        "character": "Personnage",
        "colour": "Couleur",
        "copy_attributes": "Copier les attributs",
        "copy_notes": "Copier les notes d'entité",
        "creator": "Créateur",
        "dice_roll": "Jet de dés",
        "entity": "Entité",
        "entity_type": "Type d'entité",
        "entry": "Entrée",
        "event": "Evénement",
        "excerpt": "Extrait",
        "family": "Famille",
        "files": "Fichiers",
        "has_image": "Possède une image",
        "header_image": "Image d'en-tête",
        "image": "Image",
        "is_private": "Privé",
        "is_star": "Epinglé",
        "item": "Objet",
        "location": "Lieu",
        "map": "Carte",
        "name": "Nom",
        "organisation": "Organisation",
        "position": "Position",
        "race": "Race",
        "tag": "Etiquette",
        "tags": "Etiquettes",
        "timeline": "Chronologie",
        "tooltip": "Infobulle",
        "type": "Type",
        "visibility": "Visibilité"
      },
      "files": {
        "actions": {
          "drop": "Ajouter un fichier en cliquant ou en glissant déposant",
          "manage": "Gérer les fichiers d'entité"
        },
        "errors": {
          "max": "Nombre maximal de fichier ({max}) atteint pour cette entité.",
          "no_files": "Aucun fichier."
        },
        "files": "Fichiers uploadé",
        "hints": {
          "limit": "Chaque entité peut avoir un nombre maximal de {max} fichiers uploadé.",
          "limitations": "Formats supportés: {formats}. Taille maximale: {size}"
        },
        "title": "Fichiers d'entité pour {name}"
      },
      "filter": "Filtre",
      "filters": {
        "all": "Afficher tous les descendants",
        "clear": "Effacer les filtres",
        "direct": "Affichier seulement descendants directs",
        "filtered": "Affichant {count} de {total} {entity}.",
        "hide": "Cacher les filtres",
        "options": {
          "exclude": "Exclure",
          "include": "Inclure",
          "none": "Aucun(e)"
        },
        "show": "Afficher les filtres",
        "sorting": {
          "asc": "{field} ascendant",
          "desc": "{field} descendant",
          "helper": "Controler l'ordre d'affichage des résultats."
        },
        "title": "Filtres"
      },
      "forms": {
        "actions": {
          "calendar": "Ajouter une date de calendrier"
        },
        "copy_options": "Option de copie"
      },
      "hidden": "Caché",
      "hints": {
        "attribute_template": "Appliquer un modèl d'attribut lors de la création de cette entité.",
        "calendar_date": "Une date de calendrier permet un triage plus facile dans les listes, et garde à jour un événement de calendrier dans le calendrier sélectionné.",
        "header_image": "Cette image s'affiche au dela de l'entité. Les images larges mènent a un meilleur résultat.",
        "image_limitations": "Formats supportés: jpg, png et gif. Taille max: {size}.",
        "image_patreon": "Augmenter la taille limite?",
        "is_private": "Cacher des membres de type non-Admin",
        "is_star": "Les éléments épinglés sont affichés sur le menu de l'entité.",
        "map_limitations": "Formats supportés: jpg, png, gif et svg. Taille maximale: {size}.",
        "tooltip": "Remplace l'infobulle automatiquement généré avec le text ci-dessous.",
        "visibility": "Si la visibilité est définie à Admin, seuls les membres du rôle Admin de la campagne verront ceci. La visibilité \"Soit-même\" signifie que seulement tu peux le voir."
      },
      "history": {
        "created": "Créé par <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "created_date": "Créé <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "unknown": "Inconnu",
        "updated": "Dernière modification par <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated_date": "Dernière modification <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "view": "Visionner les journaux de l'entité"
      },
      "image": {
        "error": "Impossible de récupérer l'image demandée. Il est possible que le site web ne nous permet pas de télécharger des images (cela arrive par example avec squarespace et DeviantArt), ou le lien n'est plus valide."
      },
      "is_private": "Cet élément est privé et pas visible.",
      "linking_help": "Comment lier vers d'autres éléments?",
      "manage": "Gérer",
      "move": {
        "description": "Déplacer cet élément à un nouveau endroit",
        "errors": {
          "permission": "Droits insuffisants pour créer une entité de ce type dans la campagne sélectionnée.",
          "same_campaign": "Une autre campagne doit être sélectionnée pour y déplacer l'entité.",
          "unknown_campaign": "Campagne inconnue."
        },
        "fields": {
          "campaign": "Nouvelle campagne",
          "copy": "Créer une copie",
          "target": "Nouveau type"
        },
        "hints": {
          "campaign": "Il est aussi possible de déplacer cette entité vers une autre campagne.",
          "copy": "Activer cette option créé une copie dans la nouvelle campagne.",
          "target": "Attention! Certaines informations peuvent être perdues lors du déplacement d'un élément."
        },
        "success": "Elément {name} déplacé.",
        "success_copy": "Entité '{name}' copiée.",
        "title": "Déplacer {name} autre part"
      },
      "new_entity": {
        "error": "Vérifier les valeures.",
        "fields": {
          "name": "Nom"
        },
        "title": "Nouvel élément"
      },
      "or_cancel": "ou <a href=\"{url}\">annuler</a>",
      "panels": {
        "appearance": "Apparence",
        "attribute_template": "Modèle d'attribut",
        "calendar_date": "Date Calendrier",
        "entry": "Entrée",
        "general_information": "Information Generale",
        "move": "Déplacer",
        "system": "Système"
      },
      "permissions": {
        "action": "Action",
        "actions": {
          "bulk": {
            "add": "Ajouter",
            "deny": "Refuser",
            "ignore": "Ignorer",
            "remove": "Retirer"
          },
          "bulk_entity": {
            "allow": "Permettre",
            "deny": "Refuser",
            "inherit": "Hériter"
          },
          "delete": "Supprimer",
          "edit": "Modifier",
          "entity_note": "Notes d'entité",
          "read": "Lire",
          "toggle": "Basculer"
        },
        "allowed": "Permis",
        "fields": {
          "member": "Membre",
          "role": "Rôle"
        },
        "helper": "En utilisant cette interface, il est possible d'affiner les permissions des membres et rôles de la campagne pouvant interagir avec cette entité.",
        "helpers": {
          "setup": "Utilise cette interface pour affiner la manière dont les rôles et les utilisateurs peuvent interagir avec cette entité. {allow} permettra à l'utilisateur ou au rôle d'effectuer cette action. {deny} leur empêchera de prendre cette action. {inherit} utilisera le rôle de l'utilisateur ou l'autorisation de leur rôle. Un utilisateur avec {allow} peut effectuer l'action en question, même si son rôle est en {deny}."
        },
        "inherited": "Ce rôle a déjà cette permission pour ce type d'entité.",
        "inherited_by": "Cet utilisateur fait partie du rôle {role} qui permet cette permission pour ce type d'entité.",
        "success": "Permissions enregistrées.",
        "title": "Permissions",
        "too_many_members": "Cette campagne a trop de members (>10) pour afficher cette interface correctement. Prière d'utiliser le boutton Permission sur la vue de l'entité pour gérer les permissions."
      },
      "placeholders": {
        "ability": "Choix d'un pouvoir",
        "calendar": "Choix du calendrier",
        "character": "Choix du personnage",
        "entity": "Entité",
        "event": "Choix de l'événement",
        "family": "Choix de la famille",
        "image_url": "Ou depuis une URL",
        "item": "Choix d'un objet",
        "location": "Choix du lieu",
        "map": "Choix d'une carte",
        "organisation": "Choix d'une organisation",
        "race": "Choix d'une race",
        "tag": "Choix d'une étiquette"
      },
      "relations": {
        "actions": {
          "add": "Ajouter une relation"
        },
        "fields": {
          "location": "Lieu",
          "name": "Nom",
          "relation": "Relation"
        },
        "hint": "Des relations entre les entités peuvent être définies pour représenter leur connexion."
      },
      "remove": "Supprimer",
      "rename": "Renommer",
      "save": "Enregistrer",
      "save_and_close": "Enregistrer et Fermer",
      "save_and_copy": "Enregistrer et Copier",
      "save_and_new": "Enregistrer et Nouveau",
      "save_and_update": "Enregistrer et continuer la modification",
      "save_and_view": "Enregistrer et Afficher",
      "search": "Rechercher",
      "select": "Sélection",
      "tabs": {
        "abilities": "Pouvoirs",
        "attributes": "Attributs",
        "boost": "Boost",
        "calendars": "Calendriers",
        "default": "Défaut",
        "events": "Événements",
        "inventory": "Inventaire",
        "map-points": "Points de carte",
        "mentions": "Mentions",
        "menu": "Menu",
        "notes": "Notes",
        "permissions": "Permissions",
        "relations": "Relations",
        "reminders": "Rappels",
        "timelines": "Chronologies",
        "tooltip": "Infobulle"
      },
      "update": "Modifier",
      "users": {
        "unknown": "Inconnu"
      },
      "view": "Voir",
      "visibilities": {
        "admin": "Admin",
        "admin-self": "Sois-même & Admin",
        "all": "Tous",
        "self": "Sois-même"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": [],
    "settings": {
      "account": {
        "actions": {
          "social": "Changer au login Kanka",
          "update_email": "Modifier l'email",
          "update_password": "Modifier le mot de passe"
        },
        "email": "Modification de l'email",
        "email_success": "Email modifié.",
        "password": "Modification du mot de passe",
        "password_success": "Mot de passe modifié.",
        "social": {
          "error": "Tu utilises déjà le login Kanka pour ce compte.",
          "helper": "Ton compte est géré par {provider}. Tu peux changer au login Kanka en fournissant un login et un mot de passe.",
          "success": "Ton compte utilise d'orénavant le login Kanka.",
          "title": "Social à Kanka"
        },
        "title": "Compte"
      },
      "api": {
        "experimental": "Bienvenus aux API de Kanka! Ces fonctionalités sont encore experimental mais assez stable que tu puisses intéragire avec les APIs. Créé un jeton personnel pour utiliser dans tes requêtes API, ou un jeton client pour permettre à ton app d'accéder à tes données.",
        "help": "Kanka va prochainement mettre à disposition une API.",
        "link": "Lire la documentation",
        "request_permission": "Nous construisons en ce moment des API RESTful pour que des applications tièrces communiquent avec Kanka. Cependant nous limitons actuellement le nombre d'utilisateurs qui peuvent intéragire avec nos API, du moins jusqu'à ce que la qualité de nos APIs soit assez bonne. Si tu veux accéder aux API et construire des applications qui communiquent avec Kanka, prends contact avec nous et nous te donneront les infos dont tu as besoin!",
        "title": "API"
      },
      "apps": {
        "actions": {
          "connect": "Lier",
          "remove": "Retirer"
        },
        "benefits": "Kanka supporte quelques intégrations avec d'autres services. D'autres services seront ajoutés dans le futur.",
        "discord": {
          "errors": {
            "add": "Une erreur est survenue lors de liage de Discord avec le compte Kanka."
          },
          "success": {
            "add": "Compte Discord lié.",
            "remove": "Compte Discord délié."
          },
          "text": "Accès aux rôles automatique."
        },
        "title": "Ingération d'app"
      },
      "boost": {
        "benefits": {
          "first": "Pour assurer une évolution continue de Kanka, certaines fonctionnalités de l'application sont débloquées lorsqu'une campagne est boostée. Les boosts sont débloqués grâce a un abonnement. Une campagne peut être boostée par n'importe qui, du moment que le compte a accès à la campagne en question. Une campagne reste boostée tant que le compte a un {subscription} actif. Si une campagne n'est plus boostée, les informations ne sont pas perdues mais deviennent simplement invisible jusqu'à ce que la campagne sois à nouveau boostée..",
          "header": "Image d'en-tête pour entité.",
          "images": "Images d'entité par défaut personnalisées.",
          "more": "En savoir plus sur toutes les fonctionalités.",
          "second": "Booster une campagne débloques les bénéfices suivants:",
          "theme": "Thème de campagne et style personnalisé.",
          "third": "Pour booster une campagne, aller sur la page de la campagne et cliquer sur le bouton \"{boost_button}\" situé au dessus du bouton \"{edit_button}\".",
          "tooltip": "Infobulles personnalisés pour les entités.",
          "upload": "Taille de fichier uploadé plus grand pour tous les membres de la campagne."
        },
        "buttons": {
          "boost": "Boost"
        },
        "campaigns": "Campagnes boostées {count} / {max}",
        "exceptions": {
          "already_boosted": "La campagne {name} est déjà boostée.",
          "exhausted_boosts": "Tu n'as plus de boost disponnible. Retire un boost d'une campagne avant de pouvoir l'attribuer à une autre."
        },
        "success": {
          "boost": "Campagne {name} boostée.",
          "delete": "Boost retiré de {name}."
        },
        "title": "Boost"
      },
      "countries": {
        "austria": "Autriche",
        "belgium": "Belgique",
        "france": "France",
        "germany": "Allemagne",
        "italy": "Italie",
        "netherlands": "Pays Bas",
        "spain": "Espagne"
      },
      "invoices": {
        "actions": {
          "download": "Télécharger PDF",
          "view_all": "Tout voir"
        },
        "empty": "Aucune facture",
        "fields": {
          "amount": "Montant",
          "date": "Date",
          "invoice": "Facture",
          "status": "Status"
        },
        "header": "Liste des 24 dernières factures qui peuvent être téléchargées.",
        "status": {
          "paid": "Payé",
          "pending": "En attente"
        },
        "title": "Factures"
      },
      "layout": {
        "success": "Options de mise en page modifiées.",
        "title": "Mise en page"
      },
      "menu": {
        "account": "Compte",
        "api": "API",
        "apps": "Apps",
        "billing": "Méthode de paiement",
        "boost": "Boost",
        "invoices": "Factures",
        "layout": "Mise en Page",
        "other": "Autre",
        "patreon": "Patreon",
        "payment_options": "Options de paiement",
        "personal_settings": "Paramètres Personnels",
        "profile": "Profil",
        "subscription": "Abonnement",
        "subscription_status": "Status d'abonnement"
      },
      "patreon": {
        "actions": {
          "link": "Lier le compte",
          "view": "Visiter Kanka sur Patreon"
        },
        "benefits": "Nous supporter sur {patreon} active plein de {features} pour toi et tes campagnes, et nous permet de dédié plus de temps à travailler sur Kanka.",
        "benefits_features": "fonctionalités sympas",
        "deprecated": "Fonction obsolète - si tu souhaites supporter Kanka, fais-le avec un abonnement. La liaison Patreon est toujours active pour nos Patrons qui ont lié leur compte avant le changement d'abonnement.",
        "description": "Synchronisation avec Patreon",
        "errors": {
          "invalid_token": "Token invalid! Patreon n'a pas validé la requête.",
          "missing_code": "Code manquant! Patreon n'a pas envoyé de code d'authentification pour ton compte.",
          "no_pledge": "Pas de pledge! Patreon a identifié ton compte, mais ne croit pas que tu nous supportes."
        },
        "link": "Si tu supportes Kanka sur Patreon, tu peux utiliser le bouton pour lier ton compte. Cela te donnera accès a des bonus sympas!",
        "linked": "Merci pour ton support sur Patreon! Ton comptes est d'orénavant lié.",
        "pledge": "Pledge: {name}",
        "remove": {
          "button": "Délier le compte Patreon",
          "success": "Ton compte Patreon a été délié.",
          "text": "Délier le compte Patreon de Kanka supprime les bonus, le nom du Hall of Fame, les boosters de campagne et d'autres fonctionnalités liées au supporter de Kanka. Aucun contenu boosté ne sera perdu (par exemple les en-têtes d'entité). Lors du réabonnement, toutes les données seront à nouveau visibles, y compris la possibilité de booster des campagnes précédemment boostées.",
          "title": "Délier le compte Patreon de Kanka"
        },
        "success": "Merci pour ton support sur Patreon!",
        "title": "Patreon",
        "wrong_pledge": "Ton pledge est inséré manuellement par nous, du coups ça peut prendre quelques jours pour être actualisé. Si ça reste faux longtemps, n'hésites pas à nous contacter."
      },
      "profile": {
        "actions": {
          "update_profile": "Mettre à jour le profil"
        },
        "avatar": "Image de profil",
        "success": "Mise à jour effectuée.",
        "title": "Profil personnel"
      },
      "subscription": {
        "actions": {
          "cancel_sub": "Annuler l'abonnement",
          "subscribe": "Abonner",
          "update_currency": "Changer la devise"
        },
        "benefits": "En nous soutenant, tu peux débloquer de nouvelles fonctionnalités: et nous aider a investir plus de temps dans l'amélioration de Kanka. Aucune information concernant ta carte de crédit n'est stockée ou ne transite par nos serveurs. Nous utilisons {stripe} pour gérer toutes les factures.",
        "billing": {
          "helper": "Les informations de paiement sont gérées et sauvegardées de manière sécurisée à travers {stripe}. Cette méthode de paiement sera utilisée pour tous les abonnements.",
          "saved": "Méthode de paiement",
          "title": "Modifier la méthode de paiement"
        },
        "cancel": {
          "text": "Désolé de te voir partir! L'annulation de ton abonnement le gardera actif jusqu'au la fin du mois payé, après quoi tu perdras les bonus de ta campagne et les autres avantages liés au soutien de Kanka. N'hésite pas à remplir le formulaire suivant pour nous informer de ce que nous pouvons faire mieux, ou de ce qui a conduit à ta décision."
        },
        "cancelled": "L'abonnement a été annulé. Un nouvel abonnement peut être fait dès que celui-ci arrive à terme.",
        "change": {
          "text": {
            "monthly": "Abonnement au niveau {tier}, facturé mensuellement pour {amount}.",
            "yearly": "Abonnement au niveau {tier}, facturé annuellement pour {amount}."
          },
          "title": "Changement d'abonnement"
        },
        "currencies": {
          "eur": "EUR",
          "usd": "USD"
        },
        "currency": {
          "title": "Changer la devise de facturation"
        },
        "errors": {
          "callback": "Notre gestionnaire de paiement nous a remonté une erreur. Prière de ressayer et nous contacter si le problème persiste.",
          "subscribed": "Erreur lors de la gestion de l'abonnement. Stripe nous a fourni l'erreur suivante."
        },
        "fields": {
          "active_since": "Actif depuis",
          "active_until": "Active jusqu'à",
          "billing": "Facturation",
          "currency": "Devise",
          "payment_method": "Méthode de paiement",
          "plan": "Abonnement actuel",
          "reason": "Raison"
        },
        "helpers": {
          "alternatives": "Payez votre abonnement en utilisant {method}. Ce mode de paiement ne sera pas renouvelé automatiquement à la fin de votre abonnement. {method} n'est disponible qu'en Euros.",
          "alternatives_warning": "La mise à niveau de l'abonnement lors de l'utilisation de cette méthode n'est pas possible. Veuillez créer un nouvel abonnement à la fin de votre abonnement actuel.",
          "alternatives_yearly": "En raison des restrictions entourant les paiements récurrents,{method} n'est disponible que pour les abonnements annuels"
        },
        "manage_subscription": "Gérer l'abonnement",
        "payment_method": {
          "actions": {
            "add_new": "Ajouter une méthode de paiement",
            "change": "Modifier la méthode de paiement",
            "save": "Enregister la méthode de paiement",
            "show_alternatives": "Autres méthodes de paiement"
          },
          "add_one": "Aucune méthode de paiement actuellement saisie.",
          "alternatives": "Un abonnement peut être souscrit avec ces méthodes de paiement. Cette action générera qu'une seule facture et ne renouera pas automatiquement l'abonnement chaque mois.",
          "card": "Carte",
          "card_name": "Nom sur la carte",
          "country": "Pays de résidence",
          "ending": "Se terminant par",
          "helper": "Cette carte sera utilisée pour les abonnements.",
          "new_card": "Ajouter une méthode de paiement",
          "saved": "{brand} se terminant par {last4}"
        },
        "placeholders": {
          "reason": "(optionnelle) dis-nous pourquoi tu ne souhaites plus être abonné à Kanka. Manquait-il une fonctionnalité? Ta situation financière a-t-elle changé?"
        },
        "plans": {
          "cost_monthly": "{currency} {amount} facturé mensuellement",
          "cost_yearly": "{currency} {amount} facturé annuellement"
        },
        "sub_status": "Information d'abonnement",
        "subscription": {
          "actions": {
            "downgrading": "Prière de nous contacter pour un déclassement",
            "rollback": "Changer à Kobold",
            "subscribe": "Changer à {tier} mensuel",
            "subscribe_annual": "Changer à {tier} annuel"
          }
        },
        "success": {
          "alternative": "Le paiement a été enregistré. Une notification sera générée dès le paiement a été traité et l'abonnement activé.",
          "callback": "Ton abonnement est réussis! Ton compte sera mis à jour dès que notre gestionnaire de paiement nous informe des changement (cela peut prendre quelques minutes).",
          "cancel": "Ton abonnement est annulé. Il sera toujours actif jusqu'à la fin de la période actuel.",
          "currency": "Devise préférée sauvegardée.",
          "subscribed": "Ton abonnement est réussis! N'oublie pas de t'abonner à la newsletter Community Vote pour être averti lorsqu'un vote sera ouvert. Tu peux modifier tes paramètres de newsletter sur ta page de profil."
        },
        "tiers": "Niveaux d'abonnements",
        "trial_period": "Les abonnements annuels ont une période d'annulation de 14 jours. Nous contacter à  {email} pour annuler un abonnement et recevoir un remboursement.",
        "upgrade_downgrade": {
          "button": "Information sur l'upgrade/downgrade",
          "downgrade": {
            "bullets": {
              "end": "L'abonnement actuel reste actif jusqu'à la fin du cycle de paiement, après quoi le nouvel abonnement sera mis en place."
            },
            "title": "Lors du passage à un niveau inférieur"
          },
          "upgrade": {
            "bullets": {
              "immediate": "La méthode de paiement sera facturée immédiatement et les nouvelles fonctionnalités seront accessibles.",
              "prorate": "Lors du changement de Owlbear à Elemental, seulement la différence sera facturée."
            },
            "title": "Lors du passage à un niveau supérieur"
          }
        },
        "warnings": {
          "incomplete": "Ne n'avons pas pu débiter la carte de crédit. Vérifier les informations de la carte et mettre à jour si nécessaire. Nous essayerons à nouveau durant les prochains jours. Si ça échoue de nouveau, l'abonnement sera annulé.",
          "patreon": "Ce compte est actuellement lié à Patreon. Prière de délié le compte dans les paramètres {patreon} avant de pouvoir s'abonner à Kanka."
        }
      }
    },
    "timelines": []
  },
  "he": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "צור שיחה חדשה",
        "success": "השיחה '{name}' נוצרה.",
        "title": "שיחה חדשה"
      },
      "destroy": {
        "success": "השיחה '{name}' הוסרה."
      },
      "edit": {
        "description": "עדכן את השיחה",
        "success": "השיחה '{name}' עודכנה.",
        "title": "שיחה {name}"
      },
      "fields": {
        "messages": "הודעות",
        "name": "שם",
        "participants": "משתתפים",
        "target": "קטגוריה",
        "type": "סוג"
      },
      "hints": {
        "participants": "הוסף משתתפים בלחיצה על האייקון {icon} בצד שמאל למעלה."
      },
      "index": {
        "add": "שיחה חדשה",
        "description": "ניהול הקטגוריה של {name}.",
        "header": "שיחות ב{name}",
        "title": "שיחות"
      },
      "messages": {
        "destroy": {
          "success": "ההודעה הוסרה."
        },
        "is_updated": "עודכן",
        "load_previous": "טען הודעות קודמות",
        "placeholders": {
          "message": "ההודעה שלך"
        }
      },
      "participants": {
        "create": {
          "success": "{entity} הוסף לשיחה."
        },
        "description": "הוסף או הסר משתתפים",
        "destroy": {
          "success": "{entity} הוסר מהשיחה."
        },
        "modal": "משתתפים",
        "title": "המשתתפים של {name}"
      },
      "placeholders": {
        "name": "שם השיחה",
        "type": "בתוך המשחק, הכנה, עלילה"
      },
      "show": {
        "description": "מבט מפורט על שיחה",
        "title": "שיחה {name}"
      },
      "tabs": {
        "conversation": "שיחה",
        "participants": "משתתפים"
      },
      "targets": {
        "characters": "דמויות",
        "members": "שחקנים"
      }
    },
    "crud": {
      "actions": {
        "find_out_more": "לקריאה נוספת"
      },
      "boosted_campaigns": "מערכות מוגברות",
      "edit": "עריכה",
      "export": "ייצא",
      "fields": {
        "ability": "יכולת",
        "attribute_template": "תבנית מאפיינים",
        "calendar": "לוח שנה",
        "calendar_date": "תאריך בלוח שנה",
        "character": "דמות",
        "colour": "צבע",
        "copy_attributes": "העתק מאפיינים",
        "copy_notes": "העתק פתקי אובייקט",
        "creator": "יוצר",
        "dice_roll": "הטלת קוביה",
        "entity": "אובייקט",
        "entity_type": "סוג אובייקט",
        "entry": "ערך",
        "event": "אירוע",
        "excerpt": "תקציר",
        "family": "משפחה",
        "files": "קבצים",
        "has_image": "יש תמונה",
        "header_image": "תמונת כותרת",
        "image": "תמונה",
        "is_private": "פרטי",
        "is_star": "מוצמד",
        "item": "חפץ",
        "location": "מיקום",
        "map": "מפה",
        "name": "שם",
        "organisation": "ארגון",
        "position": "תפקיד",
        "race": "גזע",
        "tag": "תגית",
        "tags": "תגיות",
        "timeline": "ציר זמם",
        "tooltip": "רמז",
        "type": "סוג",
        "visibility": "נראות"
      },
      "files": {
        "actions": {
          "drop": "גרור קובץ או לחץ להוספה",
          "manage": "נהל קבצי אובייקט"
        },
        "errors": {
          "max": "הגעת למקסימום הקבצים ({max}) לאובייקט זה.",
          "no_files": "אין קבצים"
        },
        "files": "קבצים הועלו",
        "hints": {
          "limit": "לכל אובייקט יכולים להיות עד {max} קבצים.",
          "limitations": "סיומות נתמכות: jpg, .png, .gif., וpdf. גודל מירבי: {size}"
        },
        "title": "קבצים של {name}"
      },
      "filter": "סינון",
      "filters": {
        "all": "סנן לכל הצאצאים",
        "clear": "בטל סינון",
        "direct": "סנן לצאצאים ישירים",
        "filtered": "מציג {count} מתוך {total}.",
        "hide": "הסתר סינון",
        "options": {
          "exclude": "לא כולל",
          "include": "כולל"
        },
        "show": "הצג סינון",
        "sorting": {
          "asc": "{field} עולה",
          "desc": "{field} יורד",
          "helper": "בחר באיזה סדר יופיעו התוצאות"
        },
        "title": "מסננים"
      },
      "forms": {
        "actions": {
          "calendar": "הוסף תאריך בלוח שנה"
        },
        "copy_options": "העתק הגדרות"
      },
      "hidden": "מוסתר",
      "history": {
        "created": "נוצר על ידי <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "created_date": "נוצר <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated": "עדכון אחרון על ידי <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated_date": "עדכון אחרון <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>"
      },
      "remove": "הסר",
      "rename": "שנה שם",
      "save": "שמור",
      "save_and_close": "שמור וסגור",
      "save_and_copy": "שמור והעתק",
      "save_and_new": "שמור וצור חדש",
      "save_and_update": "שמור והמשך לעדכן",
      "save_and_view": "שמור וצפה",
      "search": "חיפוש",
      "select": "בחר",
      "tabs": {
        "abilities": "יכולות",
        "attributes": "מאפיינים",
        "boost": "מוגבר",
        "calendars": "לוחות שנה",
        "default": "ברירת מחדל",
        "events": "אירועים",
        "inventory": "ציוד",
        "map-points": "נקודות מפה",
        "mentions": "אזכורים",
        "menu": "תפריט",
        "notes": "פתקי אובייקט",
        "permissions": "הרשאות",
        "relations": "ייחסים",
        "reminders": "תזכורות",
        "timelines": "צירי זמן",
        "tooltip": "רמז"
      },
      "update": "עדכן",
      "users": {
        "unknown": "לא ידוע"
      },
      "view": "צפייה",
      "visibilities": {
        "admin": "מנהלים",
        "admin-self": "עצמי ומנהלים",
        "all": "כולם",
        "self": "עצמי"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": []
  },
  "hr": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "Kreiraj novi razgovor",
        "success": "Kreiran razgovor \"{name}\".",
        "title": "Novi razgovor"
      },
      "destroy": {
        "success": "Uklonjen razgovor \"{name}\"."
      },
      "edit": {
        "description": "Ažuriraj razgovor",
        "success": "Ažuriran razgovor \"{name}\".",
        "title": "Razgovor {name}"
      },
      "fields": {
        "messages": "Poruke",
        "name": "Naziv",
        "participants": "Sudionici",
        "target": "Meta",
        "type": "Tip"
      },
      "hints": {
        "participants": "Dodaj sudionike u razgovor pritiskom na ikonu {icon} u gornjem desnom kutu."
      },
      "index": {
        "add": "Novi razgovor",
        "description": "Upravljanje kategorijom u {name}.",
        "header": "Razgovori u {name}",
        "title": "Razgovori"
      },
      "messages": {
        "destroy": {
          "success": "Poruka uklonjena."
        },
        "is_updated": "Ažurirano",
        "load_previous": "Učitaj prethodne poruke",
        "placeholders": {
          "message": "Tvoja poruka"
        }
      },
      "participants": {
        "create": {
          "success": "Sudionik {entity} dodan u razgovor."
        },
        "description": "Dodavaj ili ukloni sudionika razgovora",
        "destroy": {
          "success": "Sudionik {entity} uklonjen iz razgovora."
        },
        "modal": "Sudionici",
        "title": "Sudionici u {name}"
      },
      "placeholders": {
        "name": "Naziv razgovora",
        "type": "U igri, Priprema, Zaplet"
      },
      "show": {
        "description": "Detaljan prikaz razgovora",
        "title": "Razgovor {name}"
      },
      "tabs": {
        "conversation": "Razgovor",
        "participants": "Sudionici"
      },
      "targets": {
        "characters": "Likovi",
        "members": "Članovi"
      }
    },
    "crud": {
      "actions": {
        "actions": "Akcije",
        "apply": "Primijeni",
        "back": "Natrag",
        "copy": "Kopiraj",
        "copy_mention": "Kopiraj [ ] spominjanje",
        "copy_to_campaign": "Kopiraj u kampanju",
        "explore_view": "Ugniježđeni pregled",
        "export": "Izvoz",
        "find_out_more": "Saznaj više",
        "go_to": "Idi na {name}",
        "json-export": "Izvoz (json)",
        "more": "Više akcija",
        "move": "Pomakni",
        "new": "Novo",
        "next": "Sljedeće",
        "private": "Privatno",
        "public": "Javno",
        "reset": "Resetiraj"
      },
      "add": "Dodaj",
      "alerts": {
        "copy_mention": "Napredno spominjanje entiteta kopirano je u međuspremnik."
      },
      "attributes": {
        "actions": {
          "add": "Dodaj atribut",
          "add_block": "Dodaj blok",
          "add_checkbox": "Dodaj potvrdni okvir",
          "add_text": "Dodaj tekst",
          "apply_template": "Primjeni predložak atributa",
          "manage": "Upravljanje",
          "remove_all": "Izbriši sve"
        },
        "create": {
          "description": "Izradi novi atribut",
          "success": "Atribut {name} dodan u {entity}.",
          "title": "Novi atribut za {name}"
        },
        "destroy": {
          "success": "Uklonjen atribut {name} s {entity}."
        },
        "edit": {
          "description": "Ažuriraj postojeći atribut",
          "success": "Ažuriran atribut {name} za {entity}.",
          "title": "Ažuriraj atribut za {name}"
        },
        "fields": {
          "attribute": "Atribut",
          "community_templates": "Predlošci zajednice",
          "is_private": "Privatni atributi",
          "is_star": "Prikvačeno",
          "template": "Predložak",
          "value": "Vrijednost"
        },
        "helpers": {
          "delete_all": "Jesi li siguran/a da želiš izbrisati sve atribute ovog entiteta?"
        },
        "hints": {
          "is_private": "Možeš sakriti sve atribute entiteta od svih članova koji nisu administratori tako što ćeš ga učiniti privatnim."
        },
        "index": {
          "success": "Ažurirani atributi za {entity}.",
          "title": "Atributi za {name}"
        },
        "placeholders": {
          "attribute": "Broj osvajanja, Razina izazova, Inicijativa, Stanovništvo",
          "block": "Naziv bloka",
          "checkbox": "Naziv potvrdnog okvira",
          "section": "Naziv odjeljka",
          "template": "Odaberi predložak",
          "value": "Vrijednost atributa"
        },
        "template": {
          "success": "Predložak atributa {name} primijenjen na {entity}",
          "title": "Primijeni predložak atributa za {name}"
        },
        "types": {
          "attribute": "Atribut",
          "block": "Blok",
          "checkbox": "Potvrdni okvir",
          "section": "Odjeljak",
          "text": "Tekst u više redova"
        },
        "visibility": {
          "entry": "Atribut je prikazan u izborniku entiteta.",
          "private": "Atribut vidljiv samo članovima uloge \"Administrator\".",
          "public": "Atribut vidljiv svim članovima.",
          "tab": "Atribut se prikazuje samo na kartici Atributi."
        }
      },
      "boosted": "Pojačano",
      "boosted_campaigns": "Pojačane kampanje",
      "bulk": {
        "actions": {
          "edit": "Skupno uređivanje i označavanje"
        },
        "age": {
          "helper": "Možeš koristiti + i - prije broja za ažuriranje dobi za taj iznos."
        },
        "delete": {
          "title": "Brisanje više entiteta",
          "warning": "Jesi li siguran/a da želiš izbrisati odabrane entitete?"
        },
        "edit": {
          "tagging": "Akcija za oznake",
          "tags": {
            "add": "Dodaj",
            "remove": "Ukloni"
          },
          "title": "Uređivanje više entiteta"
        },
        "errors": {
          "admin": "Samo administratori kampanje mogu promijeniti privatni status entiteta.",
          "general": "Došlo je do pogreške prilikom obrade tvoje akcije. Pokušaj ponovo i kontaktiraj nas ako se problem nastavi. Poruka o pogrešci: {hint}."
        },
        "permissions": {
          "fields": {
            "override": "Pregazi postojeće"
          },
          "helpers": {
            "override": "Ako je uključeno, dopuštenja odabranih entiteta će biti pregažena s ovima. Ako nije uključeno, odabrana dopuštenja će biti dodana postojećim."
          },
          "title": "Promijeni dozvole za nekoliko entiteta"
        },
        "success": {
          "copy_to_campaign": "{1} {count} entitet kopiran u {campaign}.|{2,4} {count} entiteta kopirana u {campaign}.|{5,*} {count} entiteta kopirano u {campaign}.",
          "editing": "{1} {count} entitet je ažuriran.|[2,4] {count} entiteta su ažurirana.|[5, *] {count} entiteta je ažurirano.",
          "permissions": "{1} Ovlasti promijenjene za {count} entitet.|[2,*] Ovlasti promijenjene za {count} entiteta.",
          "private": "{1} {count} entitet je sad privatan.|[2,4] {count} entiteta su sad privatna.|[5, *] {count} entiteta su sad privatno.",
          "public": "{1} {count} entitet je sad vidljiv.|[2,4] {count} entiteta su sad vidljiva.|[5, *] {count} entiteta je sad vidljivo."
        }
      },
      "cancel": "Otkaži",
      "click_modal": {
        "close": "Zatvori",
        "confirm": "Potvrdi",
        "title": "Potvrdi svoju akciju"
      },
      "copy_to_campaign": {
        "bulk_title": "Kopiraj entitete u drugu kampanju",
        "panel": "Kopiraj",
        "title": "Kopiraj \"{name}\" u drugu kampanju"
      },
      "create": "Kreiraj",
      "datagrid": {
        "empty": "Nema ništa za prikazati."
      },
      "delete_modal": {
        "close": "Zatvori",
        "delete": "Obriši",
        "description": "Jesi li siguran/a da želiš ukloniti {tag}?",
        "mirrored": "Ukloni zrcalni odnos.",
        "title": "Izbriši potvrdu"
      },
      "destroy_many": {
        "success": "Obrisano {count} entitet|Obrisano {count} entiteta."
      },
      "edit": "Uredi",
      "errors": {
        "boosted": "Ova je funkcionalnost dostupna samo za pojačane kampanje.",
        "node_must_not_be_a_descendant": "Nevažeći čvor (oznaka, roditeljska lokacija): bio bi potomak sam sebi."
      },
      "events": {
        "hint": "Dolje je prikazan popis svih kalendara kojima je ovaj entitet dodan pomoću sučelja \"Dodavanje događaja u kalendar\"."
      },
      "export": "Izvoz",
      "fields": {
        "ability": "Sposobnost",
        "attribute_template": "Predložak atributa",
        "calendar": "Kalendar",
        "calendar_date": "Datum kalendara",
        "character": "Lik",
        "colour": "Boja",
        "copy_attributes": "Kopiraj atribute",
        "copy_notes": "Kopiraj entitetske bilješke",
        "creator": "Tvorac",
        "dice_roll": "Bacanje kockica",
        "entity": "Entitet",
        "entity_type": "Tip entiteta",
        "entry": "Unos",
        "event": "Događaj",
        "excerpt": "Isječak",
        "family": "Obitelj",
        "files": "Datoteke",
        "has_image": "Ima sliku",
        "header_image": "Slika zaglavlja",
        "image": "Slika",
        "is_private": "Privatno",
        "is_star": "Prikvačeno",
        "item": "Predmet",
        "location": "Lokacija",
        "map": "Karta",
        "name": "Naziv",
        "organisation": "Organizacija",
        "position": "Položaj",
        "race": "Rasa",
        "tag": "Oznaka",
        "tags": "Oznake",
        "timeline": "Kronologija",
        "tooltip": "Kratki opis",
        "type": "Tip",
        "visibility": "Vidljivost"
      },
      "files": {
        "actions": {
          "drop": "Klikni za dodavanje ili dovuci datoteku",
          "manage": "Upravljanje datotekama entiteta"
        },
        "errors": {
          "max": "Dosegnut maksimalni broj ({max}) datoteka za ovaj entitet.",
          "no_files": "Nema datoteka."
        },
        "files": "Prenesene datoteke",
        "hints": {
          "limit": "Svaki entitet može imati maksimalno  {max} datoteka prenesenih na njega.",
          "limitations": "Podržani formati: jpg, png, gif i pdf. Maksimalna veličina datoteke: {size}"
        },
        "title": "Entitetske datoteke za {name}"
      },
      "filter": "Filtar",
      "filters": {
        "all": "Filtriraj na sve potomke",
        "clear": "Očistite filtre",
        "direct": "Filtriraj na direktne potomke",
        "filtered": "Prikazuje se {count} od {total} {entity}.",
        "hide": "Sakrij filtre",
        "options": {
          "exclude": "Izuzmi",
          "include": "Uključi",
          "none": "Ništa"
        },
        "show": "Prikaži filtre",
        "sorting": {
          "asc": "{field} uzlazno",
          "desc": "{field} silazno",
          "helper": "Kontroliraj u kojem se prikazuju rezultati."
        },
        "title": "Filteri"
      },
      "forms": {
        "actions": {
          "calendar": "Dodajte datum kalendara"
        },
        "copy_options": "Opcije kopiranja"
      },
      "hidden": "Skriveno",
      "hints": {
        "attribute_template": "Primijeni predložak atributa izravno prilikom stvaranja ovog entiteta.",
        "calendar_date": "Datum kalendara omogućava jednostavno filtriranje u popisima, također održavajući događaj kalendara u odabranom kalendaru.",
        "header_image": "Ova se slika postavlja iznad entiteta. Za najbolje rezultate koristite široku sliku.",
        "image_limitations": "Podržani formati: jpg, png i gif. Maksimalna veličina datoteke: {size}.",
        "image_patreon": "Povećaj ograničenje veličine datoteke?",
        "is_private": "Ako se postavi na privatno, ovaj će entitet biti vidljiv samo članovima koji su u ulozi kampanje \"Administrator\".",
        "is_star": "Prikvačeni elementi pojavit će se na izborniku entiteta",
        "map_limitations": "Podržani formati: jpg, png, gif i svg. Maksimalna veličina datoteke: {size}.",
        "tooltip": "Zamijeni automatski generirani kratki opis sljedećim sadržajem.",
        "visibility": "Postavljanje vidljivosti na \"Administratori\" znači da će samo članovi kampanje u ulozi Administrator vidjeti ovo. Postavljanje vidljivosti na \"Samo ja\" znači da samo ti vidiš ovo."
      },
      "history": {
        "created": "Kreirao/la <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "created_date": "Kreirano <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "unknown": "Nepoznato",
        "updated": "Zadnji/a promijenio/la <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated_date": "Zadnji puta ažurirano <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "view": "Pogledaj zapisnik entiteta"
      },
      "image": {
        "error": "Nismo uspjeli dobiti sliku koju ste tražili. Može biti da nam web mjesto ne dopušta preuzimanje slike (uobičajeno za Squarespace i DeviantArt) ili da veza više nije valjana. Provjerite također da slika nije veća od {size}."
      },
      "is_private": "Ovaj je entitet privatan i vidljiv samo članovima administratorske uloge.",
      "linking_help": "Kako mogu povezati s ostalim unosima?",
      "manage": "Upravljanje",
      "move": {
        "description": "Premjesti ovaj entitet na drugo mjesto",
        "errors": {
          "permission": "Nije ti dopušteno stvarati entitete tog tipa u ciljanoj kampanji.",
          "same_campaign": "Trebaš odabrati drugu kampanju u koju će se entitet premjestiti.",
          "unknown_campaign": "Nepoznata kampanja."
        },
        "fields": {
          "campaign": "Nova kampanja",
          "copy": "Napravi kopiju",
          "target": "Novi tip"
        },
        "hints": {
          "campaign": "Možeš pokušati premjestiti ovaj entitet u drugu kampanju.",
          "copy": "Odaberi ovu opciju ako želiš stvoriti kopiju u novoj kampanji.",
          "target": "Imaj na umu da se neki podaci mogu izgubiti prilikom premještanja elementa iz jedne vrste u drugu."
        },
        "success": "Premješten entitet \"{name}\".",
        "success_copy": "Kopiran entitet \"{name}\".",
        "title": "Premjesti {name}"
      },
      "new_entity": {
        "error": "Pregledaj svoje vrijednosti.",
        "fields": {
          "name": "Naziv"
        },
        "title": "Novi entitet"
      },
      "or_cancel": "ili <a href=\"{url}\">otkaži</a>",
      "panels": {
        "appearance": "Izgled",
        "attribute_template": "Predložak atributa",
        "calendar_date": "Datum kalendara",
        "entry": "Unos",
        "general_information": "Opće informacije",
        "move": "Premjesti",
        "system": "Sustav"
      },
      "permissions": {
        "action": "Akcija",
        "actions": {
          "bulk": {
            "add": "Dodaj",
            "deny": "Zabrani",
            "ignore": "Ignoriraj",
            "remove": "Ukloni"
          },
          "bulk_entity": {
            "allow": "Dozvoli",
            "deny": "Zabrani",
            "inherit": "Naslijedi"
          },
          "delete": "Brisanje",
          "edit": "Uređivanje",
          "entity_note": "Bilješke entiteta",
          "read": "Čitanje",
          "toggle": "Uključi ili isključi"
        },
        "allowed": "Dozvoljeno",
        "fields": {
          "member": "Član",
          "role": "Uloga"
        },
        "helper": "Koristi ovo sučelje za preciziranje korisnika i uloga koji mogu vidjeti ili koristiti ovaj entitet.",
        "helpers": {
          "setup": "Koristi ovo sučelje za detaljno namještanje ovlasti uloga i korisnika za ovaj entitet. {allow} će dozvoliti korisniku ili ulozi da odradi tu akciju. {deny} će zabraniti akciju. {inherit} će koristiti ovlasti korisnikove ili glavne uloge. Korisnik kojemu je postavljano {allow}, može odrađivati akciju čak i ako uloga čiji je član ima {deny}."
        },
        "inherited": "Ova uloga već ima postavljeno dopuštenje za ovu vrstu entiteta.",
        "inherited_by": "Ovaj je korisnik dio uloge \"{role}\" koja daje ova dopuštenja ovom entitetu.",
        "success": "Ovlasti spremljene.",
        "title": "Ovlasti",
        "too_many_members": "Ova kampanja ima previše članova (> 10) za prikaz u ovom sučelju. Upotrijebite gumb Ovlasti na prikazu entiteta za detaljnu kontrolu ovlasti."
      },
      "placeholders": {
        "ability": "Izaberi sposobnost",
        "calendar": "Izaberi kalendar",
        "character": "Izaberi lika",
        "entity": "Entitet",
        "event": "Izaberi događaj",
        "family": "Izaberi obitelj",
        "image_url": "Umjesto toga možete prenijeti sliku sa URL-a",
        "item": "Izaberi predmet",
        "location": "Izaberi lokaciju",
        "map": "Izaberi kartu",
        "organisation": "Izaberi organizaciju",
        "race": "Izaberi rasu",
        "tag": "Izaberi oznaku"
      },
      "relations": {
        "actions": {
          "add": "Dodaj odnos"
        },
        "fields": {
          "location": "Lokacija",
          "name": "Naziv",
          "relation": "Odnos"
        },
        "hint": "Odnosi između entiteta mogu se postaviti tako da predstavljaju njihove veze."
      },
      "remove": "Ukloni",
      "rename": "Preimenuj",
      "save": "Spremi",
      "save_and_close": "Spremi i zatvori",
      "save_and_copy": "Spremi i kopiraj",
      "save_and_new": "Spremi i kreni na novo",
      "save_and_update": "Spremi i ažuriraj",
      "save_and_view": "Spremi i pogledaj",
      "search": "Pretraži",
      "select": "Odaberi",
      "tabs": {
        "abilities": "Sposobnosti",
        "attributes": "Atributi",
        "boost": "Pojačavanje",
        "calendars": "Kalendari",
        "default": "Zadano",
        "events": "Događaji",
        "inventory": "Inventar",
        "map-points": "Točke na karti",
        "mentions": "Spominjanja",
        "menu": "Izbornik",
        "notes": "Bilješke o entitetu",
        "permissions": "Ovlasti",
        "relations": "Odnosi",
        "reminders": "Podsjetnici",
        "timelines": "Kronologije",
        "tooltip": "Kratki opis"
      },
      "update": "Ažuriraj",
      "users": {
        "unknown": "Nepoznato"
      },
      "view": "Vidljivost",
      "visibilities": {
        "admin": "Administratori",
        "admin-self": "Ja i administratori",
        "all": "Svi",
        "self": "Samo ja"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": [],
    "settings": {
      "account": {
        "actions": {
          "social": "Prebaci se na prijavu u Kanku",
          "update_email": "Ažuriraj email",
          "update_password": "Ažuriraj lozinku"
        },
        "email": "Promjena emaila",
        "email_success": "Email ažuriran.",
        "password": "Promjena lozinke",
        "password_success": "Lozinka promijenjena.",
        "social": {
          "error": "Već koristiš prijavu u Kanku za ovaj račun.",
          "helper": "Tvojim računom trenutno upravlja {provider}. Možeš ga prestati koristiti i prebaciti se na standardnu ​​prijavu u Kanku postavljanjem lozinke.",
          "success": "Tvoj račun sad koristi Kanka prijavu.",
          "title": "Društveno prema Kanki"
        },
        "title": "Račun"
      },
      "api": {
        "experimental": "Dobrodošli u Kanka API! Ove su funkcionalnosti još eksperimentalne, ali bi trebale biti dovoljno stabilne da započneš komunikaciju s API-ima. Napravi token osobnog pristupa koji će se upotrebljavati u tvojim API zahtjevima ili koristi token klijenta ako želiš da tvoja aplikacija ima pristup korisničkim podacima.",
        "help": "Kanka će uskoro pružati RESTful API tako da se aplikacije treće strane mogu povezati s aplikacijom. Pojedinosti o upravljanju API ključevima bit će prikazane ovdje.",
        "link": "Pročitaj dokumentaciju API-ja",
        "request_permission": "Trenutno gradimo moćan RESTful API tako da se aplikacije treće strane mogu povezati s aplikacijom. Međutim, trenutno ograničavamo broj korisnika koji mogu komunicirati s API-em dok ga poliramo. Ako želiš pristupiti API-ju i izgraditi programe koji razgovaraju s Kankom, kontaktiraj nas i poslat ćemo ti sve potrebne informacije.",
        "title": "API"
      },
      "apps": {
        "actions": {
          "connect": "Poveži",
          "remove": "Ukloni"
        },
        "benefits": "Kanka pruža nekoliko integracija na usluge trećih strana. U budućnosti se planira više integracija trećih strana.",
        "discord": {
          "errors": {
            "add": "Došlo je do pogreške u povezivanju tvog Discord računa s Kankom. Molim te pokušaj ponovno."
          },
          "success": {
            "add": "Tvoj Discord račun je povezan.",
            "remove": "Veza s tvojim Discord računom je uklonjena."
          },
          "text": "Pristupi svojim ulogama za pretplatu automatski."
        },
        "title": "Integracija s aplikacijom"
      },
      "boost": {
        "benefits": {
          "first": "Kako bi osigurali kontinuirani napredak na Kanki, pojedine značajke kampanje otključavaju se pojačavanjem kampanje. Pojačanja se otključavaju putem pretplate. Svatko tko može pogledati kampanju može ju pojačati tako da ne mora uvijek ista osoba plaćati račun. Kampanja ostaje pojačana sve dok korisnik pojačava kampanju i oni nastave podržavati Kanku. Ako se kampanja više ne pojačava, podaci se ne gube već su samo skriveni dok se kampanja ponovno ne pojača.",
          "header": "Slike zaglavlja entiteta.",
          "images": "Proizvoljne zadane slike entiteta.",
          "more": "Saznaj više o svim značajkama.",
          "second": "Pojačavanje kampanje omogućuje sljedeće prednosti:",
          "theme": "Tema na razini kampanje i proizvoljno stiliziranje.",
          "third": "Da biste pojačali kampanju, idite na stranicu kampanje i kliknite gumb \"{boost_button}\" iznad gumba \"{edit_button}\".",
          "tooltip": "Proizvoljni kratki opisi entiteta.",
          "upload": "Povećana veličina prijenosa za svakog člana u kampanji."
        },
        "buttons": {
          "boost": "Pojačaj"
        },
        "campaigns": "Pojačane kampanje {count} / {max}",
        "exceptions": {
          "already_boosted": "Kampanja {name} je već pojačana.",
          "exhausted_boosts": "Nemaš više pojačanja za pokloniti. Ukloni svoje pojačanje iz neke kampanje prije nego što ga daš drugoj."
        },
        "success": {
          "boost": "Kampanja {name} pojačana.",
          "delete": "Tvoje pojačanje je uklonjeno s {name}."
        },
        "title": "Pojačanje"
      },
      "countries": {
        "austria": "Austrija",
        "belgium": "Belgija",
        "france": "Francuska",
        "germany": "Njemačka",
        "italy": "Italija",
        "netherlands": "Nizozemska",
        "spain": "Španjolska"
      },
      "invoices": {
        "actions": {
          "download": "Preuzmi PDF",
          "view_all": "Pogledaj sve"
        },
        "empty": "Nema fakture",
        "fields": {
          "amount": "Količina",
          "date": "Datum",
          "invoice": "Faktura",
          "status": "Status"
        },
        "header": "Ispod je popis zadnje 24 fakture koje možete preuzeti.",
        "status": {
          "paid": "Plaćeno",
          "pending": "U tijeku"
        },
        "title": "Fakture"
      },
      "layout": {
        "success": "Ažurirane opcije rasporeda.",
        "title": "Izgled"
      },
      "menu": {
        "account": "Račun",
        "api": "API",
        "apps": "Aplikacije",
        "billing": "Način plaćanja",
        "boost": "Pojačanje",
        "invoices": "Fakture",
        "layout": "Raspored",
        "other": "Ostalo",
        "patreon": "Patreon",
        "payment_options": "Mogućnosti plaćanja",
        "personal_settings": "Osobne postavke",
        "profile": "Profil",
        "subscription": "Pretplata",
        "subscription_status": "Status pretplate"
      },
      "patreon": {
        "actions": {
          "link": "Poveži račun",
          "view": "Posjeti Kanku na Patreonu"
        },
        "benefits": "Podržavajući nas na {patreon} otključavaš svakakve {features} za tebe i tvoje kampanje, a pomažeš nam i da provedemo više vremena radeći na poboljšanju Kanke.",
        "benefits_features": "nevjerojatne funkcionalnosti",
        "deprecated": "Zastarjela značajka - ako želite podržati Kanku, učinite to putem {subscription}. Patreon povezivanje je i dalje aktivno za one koji su povezali svoj račun prije našeg odlaska iz Patreona.",
        "description": "Sinkroniziranje s Patreonom",
        "errors": {
          "invalid_token": "Pogrešan token! Patreon nije mogao potvrditi tvoj zahtjev.",
          "missing_code": "Nedostaje kod! Patreon nije poslao kôd koji identificira tvoj račun.",
          "no_pledge": "Nema zaloga! Patreon je identificirao tvoj račun, ali ne zna za nijedan aktivan zalog."
        },
        "link": "Upotrijebi sljedeći gumb ako trenutno podržavaš Kanka na {patreon}. To će otključati bonuse",
        "linked": "Hvala ti što podržavaš Kanku na Patreonu! Tvoj račun je povezan.",
        "pledge": "Zalog: {name}",
        "remove": {
          "button": "Prekini vezu s Patreon računom",
          "success": "Uklonjena je poveznica na tvoj Patreon račun.",
          "text": "Ako prekineš vezu tvog računa s Patreonom, Kanka će ukloniti tvoje bonuse, ime u kući slavnih, pojačanja kampanje, te druge značajke povezane s podrškom Kanke. Nijedan tvoj pojačani sadržaj neće biti izgubljen (npr. zaglavlja entiteta). Ako se ponovo pretplatiš, imat ćeš pristup svim svojim prethodnim podacima, uključujući mogućnost pojačanja prijašnjih pojačanih kampanja.",
          "title": "Prekini vezu Patreon računa s Kankom"
        },
        "success": "Hvala što podržavaš Kanku u Patreonu!",
        "title": "Patreon",
        "wrong_pledge": "Razinu tvog zaloga smo postavili ručno pa nam dopusti do nekoliko dana da je pravilno postavimo. Ako neko vrijeme ostane krivo, obrati nam se."
      },
      "profile": {
        "actions": {
          "update_profile": "Ažuriraj profil"
        },
        "avatar": "Profilna slika",
        "success": "Profil ažuriran.",
        "title": "Osobni profil"
      },
      "subscription": {
        "actions": {
          "cancel_sub": "Otkaži pretplatu",
          "subscribe": "Pretplata",
          "update_currency": "Spremite preferiranu valutu"
        },
        "benefits": "Podržavajući nas možete otključati neke nove {features} i pomoći nam da uložimo više vremena u poboljšanje Kanke. Podaci kreditne kartice se ne pohranjuju ili ne prolaze kroz naše poslužitelje. Koristimo {stripe} za obradu svih računa.",
        "billing": {
          "helper": "Podaci o naplati obrađuju se i pohranjuju na sigurno putem {stripe}. Ovaj način plaćanja koristi se za sve tvoje pretplate.",
          "saved": "Spremljen način plaćanja",
          "title": "Uredi način plaćanja"
        },
        "cancel": {
          "text": "Žao nam je što odlaziš! Ako otkažeš pretplatu, bit će aktivna do sljedećeg ciklusa naplate, nakon čega ćeš izgubiti pojačanja kampanje i druge pogodnosti povezane s podrškom Kanke. Slobodno ispuni sljedeći obrazac i obavijesti nas što možemo učiniti boljim ili što je dovelo do tvoje odluke."
        },
        "cancelled": "Tvoja pretplata je otkazana. Pretplatu možete obnoviti nakon završetka tvoje trenutne pretplate.",
        "change": {
          "text": {
            "monthly": "Pretplaćuješ se na sloj {tier} koji se naplaćuje mjesečno {amount}.",
            "yearly": "Pretplaćuješ se na sloj {tier} koji se naplaćuje godišnje {amount}."
          },
          "title": "Promijenite razinu pretplate"
        },
        "currencies": {
          "eur": "EUR",
          "usd": "USD"
        },
        "currency": {
          "title": "Promijenite željenu valutu naplate"
        },
        "errors": {
          "callback": "Naš pružatelj plaćanja prijavio je pogrešku. Molimo pokušaj ponovo ili nam se obrati ako se problem nastavi.",
          "subscribed": "Tvoju pretplatu nije moguće obraditi. Stripe je pružio sljedeći savjet."
        },
        "fields": {
          "active_since": "Aktivno od",
          "active_until": "Aktivno do",
          "billing": "Naplata",
          "currency": "Valuta naplate",
          "payment_method": "Način plaćanja",
          "plan": "Trenutni plan",
          "reason": "Razlog"
        },
        "helpers": {
          "alternatives": "Plati svoju pretplatu pomoću {method}. Na kraju pretplate ovaj se način plaćanja neće automatski obnoviti. {metoda} je dostupna samo u eurima.",
          "alternatives_warning": "Nadogradnja pretplate prilikom korištenja ove metode nije moguća. Stvori novu pretplatu kada se završi trenutna.",
          "alternatives_yearly": "Zbog ograničenja koja se odnose na ponavljajuća plaćanja, metoda {method} je dostupna samo za godišnje pretplate"
        },
        "manage_subscription": "Upravljanje pretplatom",
        "payment_method": {
          "actions": {
            "add_new": "Dodajte novi način plaćanja",
            "change": "Promjena načina plaćanja",
            "save": "Spremi način plaćanja",
            "show_alternatives": "Alternativni načini plaćanja"
          },
          "add_one": "Trenutno nema spremljenog načina plaćanja.",
          "alternatives": "Možeš se pretplatiti pomoću ovih alternativnih načina plaćanja. Ova radnja će teretiti tvoj račun jednom i neće automatski obnavljati pretplatu svaki mjesec.",
          "card": "Kartica",
          "card_name": "Ime na kartici",
          "country": "Zemlja prebivališta",
          "ending": "Završava za",
          "helper": "Ova će se kartica koristiti za sve tvoje pretplate.",
          "new_card": "Dodaj novi način plaćanja",
          "saved": "{brand} završava s {last4}"
        },
        "placeholders": {
          "reason": "Po želji nam možeš reći zašto više ne podržavaš Kanku. Nedostajala je funkcionalnost? Je li se promijenila tvoja financijska situacija?"
        },
        "plans": {
          "cost_monthly": "{currency} {amount} naplaćeno mjesečno",
          "cost_yearly": "{currency} {amount} naplaćeno godišnje"
        },
        "sub_status": "Informacije o pretplati",
        "subscription": {
          "actions": {
            "downgrading": "Molimo kontaktiraj nas radi smanjenja za nižu razinu",
            "rollback": "Promjena u Kobold",
            "subscribe": "Promjena u {tier} mjesečno",
            "subscribe_annual": "Promjeni na {tier} godišnje"
          }
        },
        "success": {
          "alternative": "Tvoja uplata je registrirana. Primit ćeš obavijest čim se obradi i tvoja pretplata postane aktivna.",
          "callback": "Tvoja pretplata je uspješna. Tvoj račun će biti ažuriran čim nas naš pružatelj plaćanja informira o promjeni (ovo može potrajati nekoliko minuta).",
          "cancel": "Tvoja pretplata je otkazana. I dalje će biti aktivna do kraja tvog trenutnog razdoblja naplate.",
          "currency": "Tvoja željena postavka valute je ažurirana.",
          "subscribed": "Tvoja pretplata je bila uspješna. Ne zaboravi se pretplatiti na bilten glasanja zajednice kako bi te obavijestili kada započne novo glasanje. Postavke biltena možeš promijeniti na stranici profila."
        },
        "tiers": "Razina pretplate",
        "trial_period": "Godišnje pretplate imaju pravo otkaza 14 dana. Kontaktiraj nas na {email} ako želiš otkazati godišnju pretplatu i dobiti povrat novca.",
        "upgrade_downgrade": {
          "button": "Informacije o promjeni razine",
          "downgrade": {
            "bullets": {
              "end": "Tvoja trenutna razina ostat će aktivna do kraja tvog trenutnog ciklusa naplate, nakon čega ćeš biti nadograđen na svoju novu razinu."
            },
            "title": "Pri prelasku na niži nivo"
          },
          "upgrade": {
            "bullets": {
              "immediate": "Tvoj način plaćanja bit će naplaćen odmah i imat ćeš pristup svom novom sloju.",
              "prorate": "Kada nadogradiš s Owlbear na Elemental, samo će ti se naplatiti ​​razlika do tvoje nove razine."
            },
            "title": "Pri nadogradnji na viši sloj"
          }
        },
        "warnings": {
          "incomplete": "Nismo mogli naplatiti tvoju kreditnu karticu. Ažuriraj podatke o svojoj kreditnoj kartici, a mi ćemo je pokušati ponovo naplatiti u narednih nekoliko dana. Ako opet ne uspije, pretplata će se otkazati.",
          "patreon": "Tvoj račun je trenutno povezan s Patreonom. Prekini vezu s računom u tvojim postavkama {patreon} prije prelaska na Kanka pretplatu."
        }
      }
    }
  },
  "hu": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "Új beszélgetés létrehozása",
        "success": "'{name}' beszélgetést létrehoztuk.",
        "title": "Új beszélgetés"
      },
      "destroy": {
        "success": "'{name}' beszélgetést eltávolítottuk."
      },
      "edit": {
        "description": "A beszélgetés frissítése",
        "success": "'{name}' beszélgetést frissítettük.",
        "title": "{name} beszélgetés"
      },
      "fields": {
        "messages": "Üzenetek",
        "name": "Megnevezés",
        "participants": "Résztvevők",
        "target": "Célpont",
        "type": "Típus"
      },
      "hints": {
        "participants": "Kérjük, adj résztvevőket a beszélgetésedhez az {icon} ikonra kattintva a jobb felső részen."
      },
      "index": {
        "add": "Új beszélgetés",
        "description": "{name} kategória kezelése",
        "header": "Beszélgetés itt: {name}",
        "title": "Beszélgetés"
      },
      "messages": {
        "destroy": {
          "success": "Üzenet eltávolítva."
        },
        "is_updated": "Frissítve",
        "load_previous": "Előző üzenet betöltése",
        "placeholders": {
          "message": "Üzeneted"
        }
      },
      "participants": {
        "create": {
          "success": "{entity} résztvevőt hozzáadtuk a beszélgetéshez."
        },
        "description": "Résztvevők hozzáadása vagy eltávolítása a beszélgetésből",
        "destroy": {
          "success": "{entity} résztvevőt eltávolítottuk a beszélgetésből."
        },
        "modal": "Résztvevők",
        "title": "{name} résztvevői"
      },
      "placeholders": {
        "name": "A beszélgetés megnevezése",
        "type": "Játékbeli, előkészület, cselekmény"
      },
      "show": {
        "description": "Egy beszélgetés részletes megjelenítése",
        "title": "{name} beszélgetés"
      },
      "tabs": {
        "conversation": "Beszélgetés",
        "participants": "Résztvevők"
      },
      "targets": {
        "characters": "Karakterek",
        "members": "Tagok"
      }
    },
    "crud": {
      "actions": {
        "actions": "Műveletek",
        "apply": "Alkalmaz",
        "back": "Vissza",
        "copy": "Másolás",
        "copy_mention": "Említett [ ] másolása",
        "copy_to_campaign": "Másolás Kampányba",
        "explore_view": "Hierarchikus nézet",
        "export": "Export (pdf)",
        "find_out_more": "Tudj meg többet!",
        "go_to": "Ugrás {name} entitáshoz",
        "json-export": "Exportálás (json)",
        "more": "Több művelet",
        "move": "Mozgatás",
        "new": "Új",
        "next": "Következő",
        "private": "Privát",
        "public": "Nyilvános",
        "reset": "Visszaállítás"
      },
      "add": "Hozzáadás",
      "alerts": {
        "copy_mention": "Az entitás említését átmásoltuk a vágólapodra."
      },
      "attributes": {
        "actions": {
          "add": "Tulajdonság hozzáadása",
          "add_block": "Blokk hozzáadása",
          "add_checkbox": "Jelölőnégyzet hozzáadása",
          "add_text": "Szöveg hozzáadása",
          "apply_template": "Tulajdonságsablon alkalmazása",
          "manage": "Kezelés",
          "remove_all": "Összes törlése"
        },
        "create": {
          "description": "Új tulajdonság létrehozása",
          "success": "{name} tulajdonságot hozzáadtuk {entity} entitáshoz.",
          "title": "{name} entitáshoz új tulajdonság hozzáadása"
        },
        "destroy": {
          "success": "{entity} {name} tulajdonságát eltávolítottuk."
        },
        "edit": {
          "description": "Létező entitás frissítése",
          "success": "{entity} {name} tulajdonságát frissítettük.",
          "title": "{name} tulajdonságnak frissítése"
        },
        "fields": {
          "attribute": "Tulajdonság",
          "community_templates": "Közösségi sablonok",
          "is_private": "Privát Tulajdonságok",
          "is_star": "Kitűzve",
          "template": "Sablon",
          "value": "Érték"
        },
        "helpers": {
          "delete_all": "Biztosan ki akarod törölni az entitás összes tulajdonságát?"
        },
        "hints": {
          "is_private": "Elrejtheted egy entitás összes tulajdonságát az összes, nem-admin szerepű felhasználó elől, úgy, hogy priváttá teszed őket."
        },
        "index": {
          "success": "{entity} számára frissítettük a tulajdonságokat.",
          "title": "Tulajdonságok {name} számára"
        },
        "placeholders": {
          "attribute": "Hódítások száma, Kihívási érték, kezdeményezés, népesség",
          "block": "Blokk megnevezése",
          "checkbox": "Jelölőnégyzet megnevezése",
          "section": "Szakasz neve",
          "template": "Válassz ki egy sablont!",
          "value": "A tulajdonság értéke"
        },
        "template": {
          "success": "{name} tulajdonságsablont alkalmaztuk {entity} entátáshoz.",
          "title": "{name} számára tulajdonságsablon alkalmazása"
        },
        "types": {
          "attribute": "Tulajdonság",
          "block": "Blokk",
          "checkbox": "Jelölőnégyzet",
          "section": "Szakasz",
          "text": "Többsoros szöveg"
        },
        "visibility": {
          "entry": "A tulajdonság megjelenik az entitás menüjén",
          "private": "A tulajdonság csak az \"Admin\" szerepű tagok számára látható.",
          "public": "A tulajdonság minden tag számára látható.",
          "tab": "A tulajdonság csak a Tulajdonságok fülön jelenik meg."
        }
      },
      "boosted": "Kiemelt",
      "boosted_campaigns": "Kiemelt kampányok",
      "bulk": {
        "actions": {
          "edit": "Tömeges szerkesztés, és címkézés"
        },
        "age": {
          "helper": "Használhatod a + és - gombokat a szám előtt, hogy frissítsd a korát az adott számmal."
        },
        "delete": {
          "title": "Több entitás törlése egyidejűleg",
          "warning": "Biztosan törölni szeretnéd a kijelölt entitásokat?"
        },
        "edit": {
          "tagging": "Címkézési esemény",
          "tags": {
            "add": "Hozzáadás",
            "remove": "Eltávolítás"
          },
          "title": "Több entitás együttes szerkesztése"
        },
        "errors": {
          "admin": "Csak a kampány adminjai tudják megváltoztatni egy entitás privát státuszát.",
          "general": "Hiba lépett fel a művelet feldolgozása közben. Kérlek próbáld újra, és vedd fel velünk a kapcsolatot, ha a probléma továbbra is fennáll. Hibaüzenet: {hint}."
        },
        "permissions": {
          "fields": {
            "override": "Felülírás"
          },
          "helpers": {
            "override": "Bepipálás esetén a kijelölt entitásokra vonatkozó korábbi jogosultságok elvesznek, és teljesen felülírásra kerülnek ezekkel a jogosultságokkal. Ha nincs bepipálva, a most kijelölt jogosultságok egyszerűen csak hozzáadódnak a már meglévők mellé az egyes entitásoknál."
          },
          "title": "Jogosultság változtatása több entitásra vonatkozóan"
        },
        "success": {
          "copy_to_campaign": "{1} {count} entitásból másolat jött létre itt: {campaign}.|[2,*] {count} entitásból másolat jött létre itt: {campaign}.",
          "editing": "{1} {count} entitás frissült.|[2,*] {count} entitás frissült.",
          "permissions": "{1} Jogosultságok változtak meg meg {count} entitás esetén.|[2,*]Jogosultságok változtak meg {count} entitás esetén.",
          "private": "{count} entitás most már privát|{count} entitás most már privát.",
          "public": "{count} entitás most már látható|{count} entitás most már látható."
        }
      },
      "cancel": "Mégse",
      "click_modal": {
        "close": "Bezárás",
        "confirm": "Megerősítés",
        "title": "Igazold vissza az akciódat!"
      },
      "copy_to_campaign": {
        "bulk_title": "Entitások másolása egy másik kampányba",
        "panel": "Másolás",
        "title": "'{name}' másolása egy másik kampányba"
      },
      "create": "Létrehozás",
      "datagrid": {
        "empty": "Nincs megjeleníthető adat"
      },
      "delete_modal": {
        "close": "Bezárás",
        "delete": "Törlés",
        "description": "Biztos, hogy eltávolítod?",
        "mirrored": "Tükörkapcsolat eltávolítása.",
        "title": "Törlés megerősítése"
      },
      "destroy_many": {
        "success": "{count} entitást töröltünk|{count} entitást töröltünk."
      },
      "edit": "Szerkesztés",
      "errors": {
        "boosted": "Ez a lehetőség csak a kiemelt kampányokban érhető el.",
        "node_must_not_be_a_descendant": "Érvénytelen csomópont (címke, előd helyszín): saját maga leszármazottja lehet."
      },
      "events": {
        "hint": "Ez egy lista minden naptárról, amihez ezt az entitást hozzáadták az \"Esemény hozzáadása a naptárhoz\" felületen."
      },
      "export": "Export",
      "fields": {
        "ability": "Képesség",
        "attribute_template": "Tulajdonságsablon",
        "calendar": "Naptár",
        "calendar_date": "Naptári dátum",
        "character": "Karakter",
        "colour": "Szín",
        "copy_attributes": "Tulajdonság másolása",
        "copy_notes": "Entitásjegyzetek másolása",
        "creator": "Létrehozó",
        "dice_roll": "Dobás",
        "entity": "Entitás",
        "entity_type": "Entitás Típusa",
        "entry": "Bejegyzés",
        "event": "Esemény",
        "excerpt": "Kivonat",
        "family": "Család",
        "files": "Állományok",
        "has_image": "Rendelkezik képpel",
        "header_image": "Fejléc kép",
        "image": "Kép",
        "is_private": "Privát",
        "is_star": "Kitűzve",
        "item": "Tárgy",
        "location": "Helyszín",
        "map": "Térkép",
        "name": "Név",
        "organisation": "Szervezet",
        "position": "Elhelyezkedés",
        "race": "Faj",
        "tag": "Címke",
        "tags": "Címkék",
        "timeline": "Idővonal",
        "tooltip": "Tooltip",
        "type": "Típus",
        "visibility": "Láthatóság"
      },
      "files": {
        "actions": {
          "drop": "Klikkelj ide egy állomány hozzáadásához vagy kidobásához",
          "manage": "Az entitás állományainak kezelése"
        },
        "errors": {
          "max": "Elérted az entitáshoz rendelhető állományok maximális számát ({max}).",
          "no_files": "Nincs állomány."
        },
        "files": "Feltöltött állomány",
        "hints": {
          "limit": "Minden entitáshoz maximum {max} állomány tölthető fel.",
          "limitations": "Támogatott formátumok: jpg, png, gif és pdf. Maximális méret: {size}"
        },
        "title": "{name} állományai"
      },
      "filter": "Szűrő",
      "filters": {
        "all": "Szűrés minden leszármazottra",
        "clear": "Szűrők törlése",
        "direct": "Szűrés közvetlen leszármazottakra",
        "filtered": "{count} {entity} a(z) {total} elemből",
        "hide": "Szűrők elrejtése",
        "options": {
          "exclude": "Nem tartalmazza",
          "include": "Tartalmazza",
          "none": "Nincs"
        },
        "show": "Szűrők megmutatása",
        "sorting": {
          "asc": "{field} Növekvő sorrend",
          "desc": "{field} Csökkenő sorrend",
          "helper": "A találatok megjelenítésének sorrendje."
        },
        "title": "Szűrők"
      },
      "forms": {
        "actions": {
          "calendar": "Naptári dátum hozzáadása"
        },
        "copy_options": "Másolási lehetőségek"
      },
      "hidden": "Rejtett",
      "hints": {
        "attribute_template": "Közvetlenül is alkalmazhatsz egy tulajdonságsablont, amikor létrehozod ezt az entitást.",
        "calendar_date": "Egy naptári dátum könnyű szűrést tesz lehetővé a listákban, és fenntart egy naptári eseményt is a választott naptárban.",
        "header_image": "Ez a kép az entitás fölött fog megjelenni. Érdemes széles képet választani.",
        "image_limitations": "Támogatott formátumok: jpg, png és gif. Maximális állományméret: {size}.",
        "image_patreon": "Megnöveled az állományméret korlátját?",
        "is_private": "Ha privátnak állítod be, ezt az entitást csak a kampány \"Admin\" szereplői fogják látni.",
        "is_star": "Kitűzött elemek az entitás menüjén jelennek meg",
        "map_limitations": "Támogatott formátumok: jpg, png, gif és svg. Maximális állományméret: {size}.",
        "tooltip": "Lecseréli az automatikusan generált tooltip szöveget az alábbi tartalommal.",
        "visibility": "Ha a láthatóságot Admin-ra állítod, akkor csak az Admin jogú felhasználók tudják megnézni ezt. 'Magam'-ra állítva csak te láthatod."
      },
      "history": {
        "created": "Létrehozta <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "created_date": "Létrejött <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "unknown": "Ismeretlen",
        "updated": "Utolsó módosítás: <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated_date": "Uoljára módosítva <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "view": "Entitásnapló megtekintése"
      },
      "image": {
        "error": "Nem érjük el a kívánt képet. Lehet, hogy a honlap nem engedi, hogy letöltsük a képet (ilyen a Squarespace és a DeviantArt), vagy a link nem érvényes már. Kérjük, arról is bizonyosodj meg, hogy a kép nem nagyobb, mint {size}."
      },
      "is_private": "Ez az entitás privát, így nem látható a nem-admin felhasználók számára.",
      "linking_help": "Hogyan hozhatok létre linket más entitásokhoz?",
      "manage": "Kezelés",
      "move": {
        "description": "Az entitás más helyre mozgatása",
        "errors": {
          "permission": "Nincs engedélyed ilyen tipusú entitás létrehozására ebben a kampányban.",
          "same_campaign": "Ki kell választanod egy másik kampányt, ahová az entitás szeretnéd mozgatni.",
          "unknown_campaign": "Ismeretlen kampány."
        },
        "fields": {
          "campaign": "Új kampány",
          "copy": "Készíts másolatot",
          "target": "Új típus"
        },
        "hints": {
          "campaign": "Megpróbálhatod egy másik kampányba mozgatni ezt az entitást.",
          "copy": "Ezt válaszd ki, ha szeretnél egy másolatot készíteni az új kampányba.",
          "target": "Kérjük, ne felejtsd el, hogy néhány adat elveszhet, amikor egy elemet az egyik típusból egy másikban mozgatod."
        },
        "success": "'{name}' entitást átmozgattuk.",
        "success_copy": "'{name}' entitást másoltuk.",
        "title": "{name} mozgatása"
      },
      "new_entity": {
        "error": "Kérjük, nézd meg jól az értékeket!",
        "fields": {
          "name": "Név"
        },
        "title": "Új entitás"
      },
      "or_cancel": "vagy <a href=\"{url}\">mégse</a>",
      "panels": {
        "appearance": "Megjelenés",
        "attribute_template": "Tulajdonságsablon",
        "calendar_date": "Naptári dátum",
        "entry": "Bejegyzés",
        "general_information": "Általános információ",
        "move": "Mozgatás",
        "system": "Rendszer"
      },
      "permissions": {
        "action": "Akció",
        "actions": {
          "bulk": {
            "add": "Hozzáadás",
            "deny": "Tilt",
            "ignore": "Figyelmen kívül hagyás",
            "remove": "Eltávolítás"
          },
          "bulk_entity": {
            "allow": "Engedélyez",
            "deny": "Tilt",
            "inherit": "Örököl"
          },
          "delete": "Törlés",
          "edit": "Szerkesztés",
          "entity_note": "Entitás jegyzetek",
          "read": "Olvasás",
          "toggle": "Átkapcsolás"
        },
        "allowed": "Engedélyezett",
        "fields": {
          "member": "Tag",
          "role": "Szerep"
        },
        "helper": "Használd ezt a felületet, hogy finomhangold, melyik felhasználó és szerep tud kapcsolatba lépni ezzel az entitással. {allow}",
        "helpers": {
          "entity_note": "Entitás Jegyzetek létrehozásának engedélyezése a felhasználók számára ezen az entitáson. Enélkül a jogosultság nélkül a felhasználók látják majd az Entitás Jegyzeteket, ha azok láthatósága 'Mindenki'-re van állítva.",
          "setup": "Használd ezt a felületet, hogy finomhangold, melyik felhasználó és szerep tud kapcsolatba lépni ezzel az entitással. {allow} engedélyezni fogja a felhasználó, vagy a szerep birtokosa számára, ennek a műveletnek az elvégzését. {deny} megtiltja hogy ezt a műveletet végezhessék. {inherit} beállítás esetén pedig a felhasználó szerepét, vagy fő szerepének jogosultságát fogja figyelembe venni. Egy felhasználói szinten beállított {allow} jog engedélyt fog adni a művelet elvégzésére, még akkor is, ha a felhasználó szerepköre {deny}-aná ezt."
        },
        "inherited": "Ez a szerep már rendelkezik ezzel a jogosultsággal ehhez a típusú entitáshoz.",
        "inherited_by": "Ez a felhasználó tagja a '{role}' szerepnek, amely rendelkezik jogosultsággal ezen az entitás típuson.",
        "success": "Engedélyeket elmentettük.",
        "title": "Engedélyek",
        "too_many_members": "A kampánynak túl sok tagja (>10) van ahhoz, hogy kijelezzük ezen a felületen. Kérjük, használd az entitás nézetben az Engedély gombot, hogy kezeld az engedélyek részleteit."
      },
      "placeholders": {
        "ability": "Válassz egy képességet",
        "calendar": "Válassz egy naptárat!",
        "character": "Válassz egy karaktert!",
        "entity": "Entitás",
        "event": "Válassz egy eseményt!",
        "family": "Válassz egy családot!",
        "image_url": "Egy URL-címről is feltölthetsz képet",
        "item": "Válassz egy tárgyat!",
        "location": "Válassz egy helyszínt!",
        "map": "Válassz térképet!",
        "organisation": "Válassz egy szervezetet!",
        "race": "Válassz egy fajt!",
        "tag": "Válassz egy címkét!"
      },
      "relations": {
        "actions": {
          "add": "Hozz létre egy kapcsolatot"
        },
        "fields": {
          "location": "Helyszín",
          "name": "Név",
          "relation": "Kapcsolat"
        },
        "hint": "Az entitások közötti kapcsolatok segítenek meghatározni a viszonyukat."
      },
      "remove": "Eltávolítás",
      "rename": "Átnevezés",
      "save": "Mentés",
      "save_and_close": "Mentés és bezárás",
      "save_and_copy": "Mentés és másolás",
      "save_and_new": "Mentés és új",
      "save_and_update": "Mentés és frissítés",
      "save_and_view": "Mentés és megtekintés",
      "search": "Keresés",
      "select": "Kiválasztás",
      "tabs": {
        "abilities": "Képességek",
        "attributes": "Tulajdonságok",
        "boost": "Boost",
        "calendars": "Naptárak",
        "default": "Alapértelmezett",
        "events": "Események",
        "inventory": "Felszerelés",
        "map-points": "Térképi pontok",
        "mentions": "Említések",
        "menu": "Menü",
        "notes": "Jegyzetek",
        "permissions": "Engedélyek",
        "relations": "Kapcsolatok",
        "reminders": "Emlékeztetők",
        "timelines": "Idővonalak",
        "tooltip": "Tooltip"
      },
      "update": "Frissítés",
      "users": {
        "unknown": "Ismeretlen"
      },
      "view": "Megtekintés",
      "visibilities": {
        "admin": "Admin",
        "admin-self": "Magam és az admin",
        "all": "Mindenki",
        "self": "Magam"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": [],
    "settings": {
      "account": {
        "actions": {
          "social": "Kanka bejelentkezésre váltás",
          "update_email": "E-mail megváltoztatása",
          "update_password": "Jelszó megváltoztatása"
        },
        "description": "Fiók szerkesztése",
        "email": "Email-cím megváltoztatása",
        "email_success": "Az email-címet sikeresen megváltoztattuk",
        "password": "Jelszó megváltoztatása",
        "password_success": "A jelszót sikeresen megváltoztattuk",
        "social": {
          "error": "Ehhez a fiókhoz már Kanka bejelentkezést használsz.",
          "helper": "A fiókodat jelenleg a(z) {provider} kezeli. Hagyományos Kanka bejelentkezésre válthatsz egy jelszó megadásával.",
          "success": "A fiókod mostantól a Kanka bejelentkezést használja.",
          "title": "Közösségiről Kanka"
        },
        "title": "Fiók"
      },
      "api": {
        "description": "API beállítások frissítése",
        "experimental": "Üdvözlünk a Kanka APIkban! Ezek a funkciók még kísérleti állapotban vannak, de elég stabilak kell, hogy legyenek ahhoz, hogy elkezdhess kommunikálni a Kanka APIval. Hozz létre egy Személyes Hozzáférés Tokent, amit az api hívásaidban használhatsz, vagy használd a Kliens Tokent, ha azt szeretnéd, hogy az alkalmazásod hozzáférjen a felhasználó adataihoz.",
        "help": "A Kanka rövidesen egy teljes REST API-t fog biztosítani, hogy harmadik féltől származó alkalmazások tudjanak csatlakozni hozzá. Az API kulcsok kezelésének részleteiről rövidesen itt olvashatsz.",
        "link": "Olvasd el az API dokumentációt",
        "request_permission": "Jelenleg is dolgozunk egy REST API-n amivel harmadik féltől származó alkalmazások is csatlakozhatnak a Kankához, azonban amíg az utolsó simításokat végezzük rajta, addig korlátozzuk a hozzáférések számát. Ha szeretnél hozzáférni az APIhoz és király alkalmazásokat fejleszteni, amelyek a Kankával kommunikálnak, kérjük, hogy lépj kapcsolatba velünk, és elküldünk minden információt, amire szükséged lehet.",
        "title": "API"
      },
      "apps": {
        "actions": {
          "connect": "Kapcsolódás",
          "remove": "Eltávolítás"
        },
        "benefits": "A Kanka integrációt nyújt néhány harmadik fél szolgáltatásához. További ilyen integrációkra lehet számítani a jövőben.",
        "discord": {
          "errors": {
            "0": "1",
            "add": "Hiba történt a Kanka és a Discord fiókod összekapcsolása során. Kérlek próbáld meg ismét."
          },
          "success": {
            "add": "A Discord fiókod össze lett kapcsolva.",
            "remove": "A Discord fiókod le lett választva."
          },
          "text": "Férj hozzá az előfizetői szerepekhez automatikusan."
        },
        "title": "App Integráció"
      },
      "boost": {
        "benefits": {
          "first": "Hogy biztosítsuk a Kanka folyamatos fejlődését, bizonyos funkciók az adott kampány boost-olása után válnak elérhetővé. A boost-olás lehetőségégének megszerzése {patreon}-on keresztül történik. Egy kampányt akárki boost-olhatja is, ha van joga megtekinteni azt, így nem minden esetben a Mesélőnek kell állnia a cehhet. Egy kampány addig marad boost-olva, amíg egy felhasználó fenntartja rajta a boost-ját, valamint a támogatását is {patreon}-on keresztül. Ha egy kampány boost-olása megszűnik, az adatok nem vesznek el, csupán eltűnnek szem elől, amíg ismét nem kerül boost-olásra.",
          "header": "Entitás fejléc képek.",
          "images": "Egyedi alapérzelmezett entitás képek.",
          "more": "Tudj meg többet a funkciókról.",
          "second": "Egy kampány Boost-olása az alábbi előnyöket biztosítja:",
          "theme": "Kampány-szintű téma, és egyedi megjelenítési stílus.",
          "third": "A kampány boost-olásához keresd fel a kampány oldalát, kattints a \"{boost_button}\" gombra, amely a \"{edit_button}\" felett helyezkedik el.",
          "tooltip": "Egyedi entitás tooltip-ek.",
          "upload": "Megnövelt fájlfeltöltési korlát az összes Tag számára."
        },
        "buttons": {
          "boost": "Boost"
        },
        "campaigns": "Boost-olt kapányok száma: {count} / {max}",
        "exceptions": {
          "already_boosted": "{name} kampány már boost-olva van.",
          "exhausted_boosts": "Elfogytak a kiosztható Boost-jaid. Vond vissza egy boost-od valamelyik kampányról, mielőtt egy újnak adnál egyet."
        },
        "success": {
          "boost": "{name} kampány boost-olva lett.",
          "delete": "Boost visszavonva innen: {name}"
        },
        "title": "Boost"
      },
      "countries": {
        "austria": "Ausztria",
        "belgium": "Belgium",
        "france": "Franciaország",
        "germany": "Németország",
        "italy": "Olaszország",
        "netherlands": "Hollandia",
        "spain": "Spanyolország"
      },
      "invoices": {
        "actions": {
          "download": "PDF letöltése",
          "view_all": "Összes megtekintése"
        },
        "empty": "Nincs számla",
        "fields": {
          "amount": "Mennyiség",
          "date": "Dátum",
          "invoice": "Számla",
          "status": "Állapot"
        },
        "header": "Alább található a legutolsó 24 számla listája, melyek letölthetőek.",
        "status": {
          "paid": "Fizetve",
          "pending": "Függőben"
        },
        "title": "Számlák"
      },
      "layout": {
        "description": "Elrendezési beállítások frissítése",
        "success": "Az elrendezési beállításokat frissítettük.",
        "title": "Elrendezés"
      },
      "menu": {
        "account": "Fiók",
        "api": "API",
        "apps": "Appok",
        "billing": "Fizetési Mód",
        "boost": "Boost",
        "invoices": "Számlák",
        "layout": "Elrendezés",
        "other": "Egyéb",
        "patreon": "Patreon",
        "payment_options": "Fizetési lehetőségek",
        "personal_settings": "Személyes beállítások",
        "profile": "Profil",
        "subscription": "Előfizetés",
        "subscription_status": "Előfizetés állapota"
      },
      "patreon": {
        "actions": {
          "link": "Fiókok összekapcsolása",
          "view": "Látogasd meg a Kankát a Patreonon!"
        },
        "benefits": "A Patreon támogatóink nagyobb képeket tölthetnek fel, segítenek nekünk fedezni a szerverköltségeket, valamint lehetővé teszik, hogy több időt fordíthassunk a Kankán végzett munkánkra.",
        "benefits_features": "csodálatos képességek",
        "deprecated": "Elavult funkció - ha támogatni szeretnéd a Kankát, kérlek tedd az {subscription} segítségével. A Patreon-on keresztüli fizetés természetesen aktív marad azon támogatóinknak, akik még az új előfizetési rendszer élesbe állítása előtt kezdték a támogatást.",
        "description": "Szinkronizálás a Patreonnal",
        "errors": {
          "invalid_token": "Érvénytelen token! A Patreon nem tudta érvényesíteni a kérésed.",
          "missing_code": "Hiányzó kód! A Patreon nem küldött vissza kódot, amely a fiókodat azonosítja.",
          "no_pledge": "Nincs támogatás! A Patreon azonosította a fiókodat, de nem tud aktív támogatásról."
        },
        "link": "Nyomd meg ezt a gombot, ha jelenleg támogatod a Kankát a Patreonon, aktiválva a bónuszaid.",
        "linked": "Köszönjük, hogy támogatsz minket a Patreonon! A fiókjaid összekapcsoltuk.",
        "pledge": "{name} támogatási szint",
        "remove": {
          "button": "Patreon fiók leválasztása",
          "success": "A Patreon fiókod le lett választva.",
          "text": "A Patreon fiók leválasztása megszűntet minden bónuszt, a Dicsőségcsarnokbeli jelenléted, kampány boost-ot, és egyéb, a támogatással szerzett funkciókat a Kankán. Fontos megjegyezni, hogy egyik boost-tal kihelyezett tartalmad sem fog elveszni (pl. entitás fejlécek). Amint ismét előfizetővé válasz, újra hozzá fogsz férni ezekhez az adatokhoz, beleértve a lehetőségét, hogy boost-olj, egy korábban boostolt kampányodat.",
          "title": "A Patreon fiókod leválasztása a Kankáról"
        },
        "success": "Köszönjük, hogy támogatsz minket a Patreonon!",
        "title": "Patreon",
        "wrong_pledge": "A támogatási szintedet manuálisan állítjuk be, így kérjük, adj nekünk pár napot, hogy megfelelően beállíthassuk. Ha továbbra is helytelennek látod, lépj velünk kapcsolatba."
      },
      "profile": {
        "actions": {
          "update_profile": "Profil módosítása"
        },
        "avatar": "Profilkép",
        "description": "Profil módosítása",
        "success": "A profilodat sikeresen módosítottuk.",
        "title": "Személyes profil"
      },
      "subscription": {
        "actions": {
          "cancel_sub": "Előfizetés lemondása",
          "subscribe": "Előfizetés",
          "update_currency": "Választott pénznem mentése"
        },
        "benefits": "Támogatásoddal lehetőséged nyílik, hogy hozzáférj új {featureshez}, valamint ezzel is segítesz minket, hogy több időt szentelhessünk a Kanka fejlesztésének. A szerverünkön nem tárolunk, és nem küldünk keresztül semmilyen bankkártya információt. A számlázáshoz a {stripe} vesszük segítségül.",
        "billing": {
          "helper": "A számlázási információid tárolása, és feldolgozása a {stripe}-on keresztül történik, biztonságos formában. Ez a fizetési mód kerül felhasználásra minden előfizetésed esetében.",
          "saved": "Mentett fizetési mód",
          "title": "Fizetési mód szerkesztése"
        },
        "cancel": {
          "text": "Sajnáljuk, hogy mész! Az előfizetésed lemondása aktívan tartja előfizetésed a következő számlázási ciklusig, amikor is megszűnnek a kampány boost-jait, és minden egyéb előnyöd, amelyet a Kanka támogatásával szereztél. Ha van kedved, kérlek töltsd ki az alábbi kérdőívet, hogy megtudhassuk, hogy mit csinálhatnánk jobban a jövőben, illetve hogy mi vezetett arra a döntésre, hogy megszüntesd az előfizetésed."
        },
        "cancelled": "Az előfizetésed felmondásra került. Ismét megújíthatod előfizetésed, amint a jelenlegi előfizetésed lejár.",
        "change": {
          "text": {
            "monthly": "A {tier} szintre vagy előfizetve, a számlázás havonta történik, {amount} értékben.",
            "yearly": "A {tier} szintre vagy előfizetve, a számlázás évente történik, {amount} értékben."
          },
          "title": "Előfizetői szint megváltoztatása"
        },
        "currencies": {
          "eur": "EUR",
          "usd": "USD"
        },
        "currency": {
          "title": "Változtasd meg a számlázás kívánt pénznemét."
        },
        "errors": {
          "callback": "A fizetési szolgáltatónk hibát jelzett. Kérlek próbáld meg újra, vagy vedd fel velünk a kapcsolatot, amennyiben a hiba továbbra is fennáll.",
          "subscribed": "Nem sikerült feldolgoznunk az előfizetésed. A Stripe az alábbi hibaokot feltételezi:"
        },
        "fields": {
          "active_since": "Előfizetés kezdete",
          "active_until": "Előfizetés vége",
          "billed_monthly": "Havonta számlázva",
          "billing": "Számlázás",
          "currency": "Számlázott összeg pénzneme",
          "payment_method": "Fizetési mód",
          "plan": "Aktuális terv",
          "reason": "Indok"
        },
        "helpers": {
          "alternatives": "Az előfizetésed fizetése a következővel {method}. Ez a fizetési mód nem fog automatikusan megújulni az előfizetésed végén. {method} csak Euróval történő fizetés esetén elérhető.",
          "alternatives_warning": "Az előfizetésed fejlesztése ezzel a fizetési móddal nem lehetséges. Kérlek válassz új előfizetést, amikor a jelenlegi előfizetésed lejárna.",
          "alternatives_yearly": "A megújuló előfizetés korlátozásai miatt, a(z) {metod} csak éves előfizetéssel használható."
        },
        "manage_subscription": "Előfizetés menedzselése",
        "payment_method": {
          "actions": {
            "add_new": "Új fizetési mód hozzáadása",
            "change": "Fizetési mód megváltoztatása",
            "save": "Fizetési mód mentése",
            "show_alternatives": "Alternatív fizetési lehetőségek."
          },
          "add_one": "Jelenleg nincs mentett fizetési módod.",
          "alternatives": "Előfizethetsz ezeket az alternatív előfizetési lehetőségeket választva. Ebben az esetben csupán egyszer kerül terhelésre a számlád, és nem fog automatikusan megújulni az előfizetésed minden hónapban.",
          "card": "Kártya",
          "card_name": "A kártyán szereplő név",
          "country": "Tartózkodási hely",
          "ending": "Lejárat",
          "helper": "Ez a kártya kerül használatra minden előfizetésed esetén.",
          "new_card": "Új fizetési mód hozzáadása",
          "saved": "{brand} utolsó számjegyei: {last4}"
        },
        "placeholders": {
          "reason": "Opcionálisan kérlek mondd el, miért nem támogatod tovább a Kankát. Esetleg anyagi okokból döntöttél így?"
        },
        "plans": {
          "cost_monthly": "{amount} {currency} havonta kiszámlázva.",
          "cost_yearly": "{amount} {currency} évente kiszámlázva."
        },
        "sub_status": "Előfizetési információk",
        "subscription": {
          "actions": {
            "downgrading": "Kérlek vedd fel velünk a kapcsolatot az alacsonyabb szintre váltáshoz",
            "rollback": "Kobold előfizetői szintre váltás",
            "subscribe": "{tier} előfizetői szintre váltás havi számlázással",
            "subscribe_annual": "{tier} előfizetői szintre váltás éves számlázással"
          }
        },
        "success": {
          "alternative": "A fizetésed regisztrálásra került. Értesítést fogsz kapni, amint feldolgozásra került, és az előfizetésed aktiválódott.",
          "callback": "Az előfizetés sikeresen megtörtént. A fiókod frissülni fog, amint a fizetési szolgáltatónk tudatja velünk a változást. (Ez néhány percet igénybe vehet.)",
          "cancel": "Az előfizetésed lemondásra került. A jelenlegi előfizetés továbbra is aktív marad a számlázási periódus végéig.",
          "currency": "A kívánt pénznem beállítása frissült.",
          "subscribed": "Az előfizetés sikeres volt. Ne feledkezz el feliratkozni a Közösségi szavazás hírlevelére, hogy értesülj, amikor egy szavazás elindul. A hírlevél beállításait a Profilodnál tudod szerkeszteni."
        },
        "tiers": "Előfizetői szintek",
        "trial_period": "Az éves előfizetésekre 14 napos visszamondási jog él. Vedd fel velünk a kapcsolatot a következő címen: {email} amennyiben szeretnéd lemondani az éves előfizetésed, és az összeg visszatérítését kérvényezni.",
        "upgrade_downgrade": {
          "button": "Magasabb, vagy Alacsonyabb szintre váltás információi",
          "downgrade": {
            "bullets": {
              "end": "Az aktuális szintednek megfelelő előnyök a jelenlegi számlázási ciklusod végéig érvényben maradnak, amelyet követően az alacsonyabb szintű előfizetés lép érvénybe."
            },
            "title": "Amikor egy alacsonyabb szintű előfizetésre váltasz"
          },
          "upgrade": {
            "bullets": {
              "immediate": "A fizetési módod azonnal kiszámlázásra kerül, és egyből hozzáférsz az új előfizetői szint előnyeihez.",
              "prorate": "Amikor Bagolymedvéből Elementállá emeled az előfizetésed, csak a szintek közötti különbség kerül kiszámlázásra."
            },
            "title": "Amikor magasabb szintű előfizetésre váltasz"
          }
        },
        "warnings": {
          "incomplete": "Nem sikerült az előfizetés összegét a kártyádra terhelni. Kérlek frissítsd a bakkártya adataidat, és a következő pár napban ismételten megpróbáljuk megterhelni az előfizetés összegével. Ha ismét sikertelen a tranzakció, az előfizetésed lemondásra kerül.",
          "patreon": "A fiókod jelenleg a Patreon-nal van összekapcsolva. Kérlek csatlakoztasd le a fiókod a {patreon} beállításaiban, mielőtt Kanka előfizetésre váltanál!"
        }
      }
    }
  },
  "it": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "Crea una nuova conversazione",
        "success": "Conversazione '{name}' creata.",
        "title": "Nuova conversazione"
      },
      "destroy": {
        "success": "Conversazione '{name}' rimossa."
      },
      "edit": {
        "description": "Aggiorna la conversazione",
        "success": "Conversazione '{name}' aggiornata.",
        "title": "Conversazione {name}"
      },
      "fields": {
        "messages": "Messaggi",
        "name": "Nome",
        "participants": "Partecipanti",
        "target": "Bersaglio",
        "type": "Tipo"
      },
      "hints": {
        "participants": "Per favore aggiungi partecipanti alla tua conversazione premendo l'icona {icon} in altro a destra."
      },
      "index": {
        "add": "Nuova conversazione",
        "description": "Gestisci la categoria di {name}.",
        "header": "Conversazioni in {name}",
        "title": "Conversazioni"
      },
      "messages": {
        "destroy": {
          "success": "Messaggio rimosso."
        },
        "is_updated": "Aggiornata",
        "load_previous": "Carica i messaggi precedenti",
        "placeholders": {
          "message": "Il tuo messaggio"
        }
      },
      "participants": {
        "create": {
          "success": "Partecipante {entity} aggiunto alla conversazione."
        },
        "description": "Aggiungi o rimuovi partecipanti di una conversazione",
        "destroy": {
          "success": "Partecipante {entity} rimosso dalla conversazione."
        },
        "modal": "Partecipanti",
        "title": "Partecipanti di {name}"
      },
      "placeholders": {
        "name": "Nome della conversazione",
        "type": "In Gioco, Preparazione, Trama"
      },
      "show": {
        "description": "Una vista dettagliata della conversazione",
        "title": "Conversazione {name}"
      },
      "tabs": {
        "conversation": "Conversazione",
        "participants": "Partecipanti"
      },
      "targets": {
        "characters": "Personaggi",
        "members": "Membri"
      }
    },
    "crud": {
      "actions": {
        "actions": "Azioni",
        "apply": "Applica",
        "back": "Indietro",
        "copy": "Copia",
        "copy_mention": "Copia [ ] menzione",
        "copy_to_campaign": "Copia nella Campagna",
        "explore_view": "Vista annidata",
        "export": "Esporta (PDF)",
        "find_out_more": "Scopri di più",
        "go_to": "Vai a {name}",
        "json-export": "Esporta (JSON)",
        "more": "Più Azioni",
        "move": "Sposta",
        "new": "Nuovo",
        "next": "Prossimo",
        "private": "Privato",
        "public": "Pubblico",
        "reset": "Resetta"
      },
      "add": "Aggiungi",
      "alerts": {
        "copy_mention": "La menzione avanzata dell'entità è stata copiata nei tuoi appunti."
      },
      "attributes": {
        "actions": {
          "add": "Aggiungi un attributo",
          "add_block": "Aggiungi un blocco",
          "add_checkbox": "Aggiungi un checkbox",
          "add_text": "Aggiungi un testo",
          "apply_template": "Applica un Template per gli Attributi",
          "manage": "Gestisci",
          "remove_all": "Cancella tutti"
        },
        "create": {
          "description": "Crea un nuovo attributo",
          "success": "L'Attributo {name} è stato aggiunto a {entity}",
          "title": "Nuovo Attributo per {name}"
        },
        "destroy": {
          "success": "L'attributo {name} è stato rimosso da {entity}"
        },
        "edit": {
          "description": "Aggiorna un attributo esistente",
          "success": "L'attributo {name} per {entity} è stato aggiornato.",
          "title": "Aggiorna l'attributo per {name}"
        },
        "fields": {
          "attribute": "Attributo",
          "community_templates": "Templates della Community",
          "is_private": "Attributi Privati",
          "is_star": "Fissato",
          "template": "Template",
          "value": "Valore"
        },
        "helpers": {
          "delete_all": "Sei sicuro di voler cancellare tutti gli attributi di questa entità?"
        },
        "hints": {
          "is_private": "Puoi nascondere tutti gli attributi di un'entità per tutti i membri al di fuori del gruppo degli amministratori rendendoli privati."
        },
        "index": {
          "success": "Attributo aggiornato per {entity}.",
          "title": "Attributi per {name}"
        },
        "placeholders": {
          "attribute": "Numero di conquiste, Grado di Sfida, Iniziativa, Popolazione",
          "block": "Nome del blocco",
          "checkbox": "Nome del checkbox",
          "section": "Nome della sezione",
          "template": "Seleziona un template",
          "value": "Valore dell'attributo"
        },
        "template": {
          "success": "Il Template di Attributi {name} è stato applicato su {entity}",
          "title": "Applica un Template degli Attributi per {name}"
        },
        "types": {
          "attribute": "Attributo",
          "block": "Blocco",
          "checkbox": "Checkbox",
          "section": "Sezione",
          "text": "Testo multilinea"
        },
        "visibility": {
          "entry": "Gli Attributi sono mostrati nella tab Principale.",
          "private": "Attributo visibile solamente ai membri del ruolo \"Admin\".",
          "public": "Attributo visibile a tutti i membri.",
          "tab": "Gli attributi sono visualizzati solamente nella tab degli Attributi."
        }
      },
      "boosted": "Potenziata",
      "boosted_campaigns": "Campagne potenziate",
      "bulk": {
        "actions": {
          "edit": "Modifica in blocco & assegnazione dei tag"
        },
        "age": {
          "helper": "Puoi usare + e - prima del numero per aggiornare l'età di quel quantitativo."
        },
        "delete": {
          "title": "Rimuovendo molteplici entità",
          "warning": "Sei sicuro di voler cancellare le entità selezionate?"
        },
        "edit": {
          "tagging": "Azione per i tag",
          "tags": {
            "add": "Aggiungi",
            "remove": "Rimuovi"
          },
          "title": "Modificando molteplici entità"
        },
        "errors": {
          "admin": "Solo gli amministratori della campagna possono cambiare lo stato di visibilità delle entità.",
          "general": "C'è stato un errore nell'elaborazione della tua azione. Per favore prova di nuovo e contattaci qualora il problema dovesse persistere. Messaggio di errore: {hint}."
        },
        "permissions": {
          "fields": {
            "override": "Sovrascrivi"
          },
          "helpers": {
            "override": "Se selezionato, i permessi delle entità selezionate saranno sovrascritti con questi. Se non selezionato i permessi selezionati saranno aggiunti a quelli già assegnati."
          },
          "title": "Cambia i permessi a più entità"
        },
        "success": {
          "copy_to_campaign": "{1} {count} entità copiata in {campaign}.|[2,*] {count} entità copiate in {campaign}.",
          "editing": "{1} {count} entità è stata aggiornata.|[2,*] {count} entitià sono state aggiornate.",
          "permissions": "{1} Permessi modificati per {count} entità.|[2,*] Permessi modificati per {count} entità.",
          "private": "{1} {count} entità è adesso privata|[2,*] {count} entità sono adesso private.",
          "public": "{1} {count} entità è adesso visibile|[2,*] {count} entità sono adesso visibili."
        }
      },
      "cancel": "Annulla",
      "click_modal": {
        "close": "Chiudi",
        "confirm": "Conferma",
        "title": "Conferma la tua azione"
      },
      "copy_to_campaign": {
        "bulk_title": "Copia le entità in un'altra campagna",
        "panel": "Copia",
        "title": "Copia '{name}' in una'ltra campagna"
      },
      "create": "Crea",
      "datagrid": {
        "empty": "Ancora non c'è nulla da mostrare."
      },
      "delete_modal": {
        "close": "Chiudi",
        "delete": "Cancella",
        "description": "Sei sicuro di voler rimuovere {tag}?",
        "mirrored": "Rimuovere la relazione speculare.",
        "title": "Conferma di cancellazione"
      },
      "destroy_many": {
        "success": "Cancellata {count} entità|Cancellate {count} entità."
      },
      "edit": "Modifica",
      "errors": {
        "boosted": "Questa funzionalità è disponibile solo per le campagne potenziate.",
        "node_must_not_be_a_descendant": "Nodo non valido (tag, luogo padre): sarebbe un discendente di sé stesso."
      },
      "events": {
        "hint": "Qui sotto puoi vedere una lista di tutti i calendari ai quali questa entità è stata aggiunta usando \"Aggiungi un evento ad un calendario\"."
      },
      "export": "Esporta",
      "fields": {
        "ability": "Abilità",
        "attribute_template": "Template di Attributi",
        "calendar": "Calendario",
        "calendar_date": "Data del Calendario",
        "character": "Personaggio",
        "colour": "Colore",
        "copy_attributes": "Copia Attributo",
        "copy_notes": "Copia le Note dell'Entità",
        "creator": "Creatore",
        "dice_roll": "Tiro di dado",
        "entity": "Entità",
        "entity_type": "Tipo di Entità",
        "entry": "Dato inserito",
        "event": "Evento",
        "excerpt": "Estratto",
        "family": "Famiglia",
        "files": "Files",
        "header_image": "Immagine dell'intestazione",
        "image": "Immagine",
        "is_private": "Privato",
        "is_star": "Fissato",
        "item": "Oggetto",
        "location": "Luogo",
        "map": "Mappa",
        "name": "Nome",
        "organisation": "Organizzazione",
        "race": "Razza",
        "tag": "Tag",
        "tags": "Tags",
        "tooltip": "Tooltip",
        "type": "Tipo",
        "visibility": "Visibilità"
      },
      "files": {
        "actions": {
          "drop": "Clicca per Aggiungere o Trascina un file",
          "manage": "Gestisci i files dell'entità"
        },
        "errors": {
          "max": "Hai raggiunto il numero massimo di file ({max}) per questa entità.",
          "no_files": "Nessun file."
        },
        "files": "Files Caricati",
        "hints": {
          "limit": "Ciascuna entità può avere un massimo di {max} files caricati.",
          "limitations": "Formati supportati: jpg, png, gif, e pdf. Dimensione massima del file: {size}"
        },
        "title": "Files dell'entità {name}"
      },
      "filter": "Filtra",
      "filters": {
        "all": "Filtra includendo tutti i discendenti",
        "clear": "Pulisci i Filtri",
        "direct": "Filtra includendo solamente i discendenti diretti",
        "filtered": "Visualizzati {count} di {total} {entity}.",
        "hide": "Nascondi i Filtri",
        "show": "Visualizza i Filtri",
        "sorting": {
          "asc": "{field} in ordine crescente",
          "desc": "{field} in ordine decrescente",
          "helper": "Gestisci l'ordine di visualizzazione dei risultati."
        },
        "title": "Filtri"
      },
      "forms": {
        "actions": {
          "calendar": "Aggiungi una data del calendario"
        },
        "copy_options": "Copia opzioni"
      },
      "hidden": "Nascosto",
      "hints": {
        "attribute_template": "Applica un template per gli attributi direttamente quando si crea questa entità.",
        "calendar_date": "La data di un calendario permette un semplice filtro nelle liste e mantiene un evento nel calendario selezionato.",
        "header_image": "Questa immagine è posizionata sopra all' entità. Per un miglior risultato, utilizza un'immagine larga.",
        "image_limitations": "Formati supportati: jpg, png e gif. Dimensione massima del file: {size}.",
        "image_patreon": "Aumentare la dimensione massima dei file?",
        "is_private": "Se impostata come privata, questa entità sarà visibile solamente ai membri appartenenti al ruolo \"Proprietario\" della campagna.",
        "is_star": "Gli elementi fissati appariranno nel menù dell'entità",
        "map_limitations": "Formati supportati{jpg}, png, gif e svg. Dimensione massima del file: {size}.",
        "tooltip": "Sostituisci il tooltip generato automaticamente con il seguente contenuto.",
        "visibility": "Impostare la visibilità agli amministratori significa che solamente i membri del ruolo \"Proprietario\" della campagna potranno visualizzarlo. Impostarlo a \"Te stesso\" significa che solo tu potrai vederlo."
      },
      "history": {
        "created": "Creato da <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "created_date": "Creato <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "unknown": "Sconosciuto",
        "updated": "Modificato l'ultima volta da <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated_date": "Ultima modifica <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "view": "Visualizza i log dell'entità"
      },
      "image": {
        "error": "Non siamo stati in gradi di recuperare l'immagine richiesta. Potrebbe essere che il sito web non ci permetta di scaricare l'immagine (solitamente ciò riguarda Squarespace e DeviantArt) o che il link non sia più valido. Per favore controlla anche che la dimensione dell'immagine non sia maggiore di {size}."
      },
      "is_private": "Questa entità è privata e visibile solamente ai membri del ruolo \"Proprietario\".",
      "linking_help": "Come posso creare un collegamento ad altre entità?",
      "manage": "Gestisci",
      "move": {
        "description": "Sposta questa entità in un altro posto",
        "errors": {
          "permission": "Non sei autorizzato a creare entità di questo tipo nella campagna selezionata.",
          "same_campaign": "Devi selezionare un'altra campagna verso cui spostare l'entità.",
          "unknown_campaign": "Campagna sconosciuta"
        },
        "fields": {
          "campaign": "Nuova campagna",
          "copy": "Crea una copia",
          "target": "Nuovo tipo"
        },
        "hints": {
          "campaign": "Puoi anche provare a spostare questa entità in un'altra campagna",
          "copy": "Seleziona questa opzione se vuoi crearne una copia nella nuova campagna.",
          "target": "Per favore considera che alcuni dati potrebbero andare persi nel caso si spostasse un elemento da un tipo ad un altro."
        },
        "success": "Entità '{name}' spostata.",
        "success_copy": "Entità '{name}' copiata.",
        "title": "Sposta {name}"
      },
      "new_entity": {
        "error": "Per favore controlla i tuoi valori.",
        "fields": {
          "name": "Nome"
        },
        "title": "Nuova entità"
      },
      "or_cancel": "o <a href=\"{url}\">annulla</a>",
      "panels": {
        "appearance": "Aspetto",
        "attribute_template": "Template di attributi",
        "calendar_date": "Data del Calendario",
        "entry": "Elemento",
        "general_information": "Informazioni Generali",
        "move": "Sposta",
        "system": "Sistema"
      },
      "permissions": {
        "action": "Azione",
        "actions": {
          "bulk": {
            "add": "Aggiungi",
            "deny": "Nega",
            "ignore": "Ignora",
            "remove": "Rimuovi"
          },
          "bulk_entity": {
            "allow": "Permetti",
            "deny": "Nega",
            "inherit": "Eredita"
          },
          "delete": "Cancella",
          "edit": "Modifica",
          "entity_note": "Note dell'Entità",
          "read": "Lettura",
          "toggle": "Attiva/Disattiva"
        },
        "allowed": "Permesso",
        "fields": {
          "member": "Membro",
          "role": "Ruolo"
        },
        "helper": "Utilizza questa interfaccia per rifinire e specificare quali utenti e ruoli possono interagire con questa entità.",
        "helpers": {
          "entity_note": "Permetti agli utenti di creare Note per questa Entità. Senza questo permesso, essi saranno ancora in grado di vedere le note dell'entità impostate come visibili per Tutti.",
          "setup": "Utilizza questa interfaccia per rifinire e specificare come utenti e ruoli possono interagire con questa entità. {allow} permetterà all'utente o al ruolo di fare questa azione. {deny} negherà loro tale azione. {inherit} farà riferimento al ruolo dell'utente o al permesso del ruolo. Un utente impostato come {allow} sarà in grado di fare l'azione anche se il suo ruolo sarà invece impostato su {deny}."
        },
        "inherited": "Questo ruolo ha già questo permesso impostato per questa tipologia di entità.",
        "inherited_by": "Questo utente fa parte del ruolo '{role}' che gli conferisce questo permesso su questa tipologia di entità.",
        "success": "Permessi salvati.",
        "title": "Permessi",
        "too_many_members": "Questa campagna ha troppi membri (più di 10) per poterli mostrare tutti in questa interfaccia. Ti preghiamo di usare il tasto Permessi sulla pagine dell'entità per poter verificare i permessi nel dettaglio."
      },
      "placeholders": {
        "ability": "Seleziona un'abilità",
        "calendar": "Seleziona un calendario",
        "character": "Seleziona un personaggio",
        "entity": "Entità",
        "event": "Seleziona un evento",
        "family": "Seleziona una famiglia",
        "image_url": "Altrimenti puoi caricare un'immagine da un URL",
        "item": "Seleziona un'oggetto",
        "location": "Seleziona un luogo",
        "map": "Seleziona una mappa",
        "organisation": "Seleziona un'organizzazione",
        "race": "Seleziona una razza",
        "tag": "Seleziona un tag"
      },
      "relations": {
        "actions": {
          "add": "Aggiungi una relazione"
        },
        "fields": {
          "location": "Luogo",
          "name": "Nome",
          "relation": "Relazione"
        },
        "hint": "Le relazioni fra le entità possono essere impostate per rappresentare le loro connessioni."
      },
      "remove": "Rimuovi",
      "rename": "Rinomina",
      "save": "Salva",
      "save_and_close": "Salva e Chiudi",
      "save_and_copy": "Salva e Copia",
      "save_and_new": "Salva e Crea Nuovo",
      "save_and_update": "Salve e Aggiorna",
      "save_and_view": "Salva e Visualizza",
      "search": "Cerca",
      "select": "Seleziona",
      "tabs": {
        "abilities": "Abilità",
        "attributes": "Attributi",
        "boost": "Potenzia",
        "calendars": "Calendari",
        "default": "Predefinito",
        "events": "Eventi",
        "inventory": "Inventario",
        "map-points": "Punti della Mappa",
        "mentions": "Menzioni",
        "menu": "Menù",
        "notes": "Note",
        "permissions": "Permessi",
        "relations": "Relazioni",
        "reminders": "Promemoria",
        "tooltip": "Tooltip"
      },
      "update": "Aggiorna",
      "users": {
        "unknown": "Sconosciuto"
      },
      "view": "Visualizza",
      "visibilities": {
        "admin": "Proprietario",
        "admin-self": "Te Stesso e Proprietario",
        "all": "Tutti",
        "self": "Te stesso"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": [],
    "settings": {
      "account": {
        "actions": {
          "social": "Vai al Login Kanka",
          "update_email": "Aggiorna e-mail",
          "update_password": "Aggiorna password"
        },
        "description": "Aggiorna il tuo account",
        "email": "Cambia e-mail",
        "email_success": "E-Mail aggiornata.",
        "password": "Cambia password",
        "password_success": "Password aggiornata.",
        "social": {
          "error": "Stai già utilizzando il login Kanka per questo account.",
          "helper": "Il tuo account è attualmente gestito da {provider}. Puoi smettere di utilizzarlo e passare al login standard di Kanka impostando una password.",
          "success": "Il tuo account ora utilizza il login Kanka.",
          "title": "Social a Kanka"
        },
        "title": "Account"
      },
      "api": {
        "description": "Aggiorna le impostazioni delle tue API",
        "experimental": "Benvenuto alle API di Kanka! Queste caratteristiche sono ancora in fase di sperimentazione ma dovrebbero essere abbastanza stabili per permetterti di incominciare a comunicare con le APIs. Crea un Token di Accesso Personale da utilizzare nelle tue richieste api o utilizza il Token del Client se vuoi che la tua app abbia accesso ai dati utente.",
        "help": "Kanka fornirà presto una RESTful API in modo che applicazioni di terze parti possano connettervisi. I dettagli su come gestire le tue chiavi API saranno mostrati qui.",
        "link": "Leggi la documentazione delle API",
        "request_permission": "Stiamo attualmente creando una potente RESTful API in modo che applicazioni di terze parti possano connettervisi. Stiamo attualmente limitando il numero di utenti che possono interagire con le API mentre le miglioriamo. Se vuoi avere accesso alle API e creare eccezionali apps che comunichino con Kanka, per favore contattaci e noi ti invieremo tutte le informazioni di cui hai bisogno.",
        "title": "API"
      },
      "layout": {
        "description": "Aggiorna le tue impostazioni di layout",
        "success": "Impostazioni di layout aggiornate.",
        "title": "Layout"
      },
      "menu": {
        "account": "Account",
        "api": "API",
        "layout": "Layout",
        "patreon": "Patreon",
        "personal_settings": "Impostazioni Personali",
        "profile": "Profilo"
      },
      "patreon": {
        "actions": {
          "link": "Collega Account",
          "view": "Visita Kanka su Patreon"
        },
        "benefits": "Supportarci su Patreon fa si che tu possa caricare immagini più grandi, aiuti noi a coprire i costi del server e ci permetti di dedicare più tempo a lavorare su Kanka.",
        "description": "Connetti con Patreon",
        "errors": {
          "invalid_token": "Token non valido! Patreon non può verificare la tua richiesta.",
          "missing_code": "Codice mancante! Patreon non ha ritornato un codice per l'identificazione del tuo account.",
          "no_pledge": "Nessun pledge! Patreon ha riconosciuto il tuo account my non è a conoscenza di nessun pledge attivo."
        },
        "link": "Usa questo bottone se stai attualmente supportando Kanka su {patreon}. Questo sbloccherà i bonus",
        "linked": "Grazie per supportare Kanka su Patreon! Il tuo account è stato collegato.",
        "pledge": "Pledge: {name}",
        "success": "Grazie per supportare Kanka su Patreon!",
        "title": "Patreon",
        "wrong_pledge": "Il livello del tuo pledge è settato manualmente da noi, quindi per favore daccia fino a qualche giorno per settarlo correttamente. Se resta sbagliato per diverso tempo ti preghiamo di contattarci."
      },
      "profile": {
        "actions": {
          "update_profile": "Aggiorna profilo"
        },
        "avatar": "Immagine del profilo",
        "description": "Aggiorna il tuo profilo",
        "success": "Profilo aggiornato.",
        "title": "Profilo Personale"
      }
    }
  },
  "nl": {
    "admin": [],
    "campaigns": [],
    "front": []
  },
  "pl": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "entities": [],
    "front": [],
    "maps": [],
    "randomizers": [],
    "timelines": []
  },
  "pt": [],
  "pt-BR": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "crud": {
      "actions": {
        "back": "Voltar",
        "copy": "Copiar",
        "export": "Exportar",
        "more": "Mais Ações",
        "move": "Mover",
        "new": "Novo",
        "private": "Privado",
        "public": "Público"
      },
      "add": "Adicionar",
      "attributes": {
        "actions": {
          "add": "Adicionar um atributo",
          "apply_template": "Aplicar um Modelo de Atributo",
          "manage": "Gerenciar"
        },
        "create": {
          "description": "Criar um novo atributo",
          "success": "Atributo {name} adicionado a {entity}",
          "title": "Novo Atributo para {name}"
        },
        "destroy": {
          "success": "Atributo {name} para {entity} removido"
        },
        "edit": {
          "description": "Atualizar um atributo existente",
          "success": "Atributo {name} para {entity} atualizado",
          "title": "Atualizar atributo para {name}"
        },
        "fields": {
          "attribute": "Atributo",
          "template": "Modelo",
          "value": "Valor"
        },
        "index": {
          "success": "Atributos de {entity} atualizados.",
          "title": "Atributos de {name}"
        },
        "placeholders": {
          "attribute": "Número de conquistas, Nível de Desafio, Iniciativa, População",
          "template": "Selecione um modelo",
          "value": "Valor do atributo"
        },
        "template": {
          "success": "Modelo de Atributo {name} aplicado em {entity}",
          "title": "Aplicar um Modelo de Atributo a {name}"
        }
      },
      "bulk": {
        "errors": {
          "admin": "Apenas administradores de campanha podem mudar o status privado de entidades"
        }
      },
      "cancel": "Cancelar",
      "click_modal": {
        "close": "Fechar",
        "confirm": "Confirmar",
        "title": "Confirmar sua ação"
      },
      "create": "Criar",
      "delete_modal": {
        "close": "Fechar",
        "delete": "Deletar",
        "description": "Tem certeza que deseja remover {tag}?",
        "title": "Confirmação de apagamento"
      },
      "destroy_many": {
        "success": "Deletado {count} entity|Deletado {count} entities."
      },
      "edit": "Editar",
      "fields": {
        "character": "Personagem",
        "creator": "Criador",
        "dice_roll": "Rolagem de Dados",
        "entity": "Entidade",
        "entry": "Entrada",
        "event": "Evento",
        "image": "Imagem",
        "is_private": "Privado",
        "location": "Local"
      },
      "filter": "Filtro",
      "hidden": "Esconder",
      "hints": {
        "is_private": "Esconder de \"Espectadores\""
      },
      "image": {
        "error": "Nós não fomos capazes de conseguir a imagem requisitada. Pode ser que o site não autorize o download da imagem por nós (tipicamente para Squarespace e DeviantArt), ou o link não está mais válido."
      },
      "is_private": "Essa entidade é privada e não visível para usuários espectadores.",
      "linking_help": "Como eu posso vincular a outras entidades?",
      "manage": "Gerenciar",
      "move": {
        "description": "Mover a entidade para outro lugar",
        "fields": {
          "target": "Novo tipo"
        },
        "hints": {
          "target": "Esteja ciente que alguns dados podem ser perdidos ao mudar um elemento de um tipo para outro."
        },
        "success": "Entidade {name} movida.",
        "title": "Mover {name} para outro lugar"
      },
      "new_entity": {
        "error": "Por favor cheque seus valores",
        "fields": {
          "name": "Nome"
        },
        "title": "Nova entidade"
      },
      "or_cancel": "ou <a href=\"{url}\">cancel</a>",
      "panels": {
        "appearance": "Aparência",
        "general_information": "Informações Gerais",
        "move": "Mover"
      },
      "permissions": {
        "action": "Ação",
        "actions": {
          "delete": "Deletar",
          "edit": "Editar",
          "read": "Ler"
        },
        "allowed": "Permitido",
        "fields": {
          "member": "Membro",
          "role": "Cargo"
        },
        "helper": "Use essa interface para escolher quais usuários e cargos podem interagir com essa entidade.",
        "success": "Permissões salvas.",
        "title": "Permissões"
      },
      "placeholders": {
        "character": "Escolha um personagem",
        "event": "Escolha um evento",
        "family": "Escolha uma família",
        "image_url": "Você também pode dar upload de uma imagem por uma URL",
        "location": "Escolha um local"
      },
      "relations": {
        "actions": {
          "add": "Adicionar uma relação"
        },
        "fields": {
          "location": "Local",
          "name": "Nome",
          "relation": "Relação"
        }
      },
      "remove": "Remover",
      "save": "Salvar",
      "save_and_new": "Salvar e Novo",
      "search": "Buscar",
      "select": "Selecionar",
      "tabs": {
        "attributes": "Atributos",
        "calendars": "Calendários",
        "permissions": "Permissões",
        "relations": "Relações"
      },
      "update": "Atualizar",
      "view": "Ver"
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": []
  },
  "ru": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "Создание нового Разговора",
        "success": "Разговор \"{name}\" создан.",
        "title": "Новый Разговор"
      },
      "destroy": {
        "success": "Разговор \"{name}\" удален."
      },
      "edit": {
        "description": "Обновление Разговора",
        "success": "Разговор \"{name}\" обновлен.",
        "title": "Разговор {name}"
      },
      "fields": {
        "messages": "Сообщения",
        "name": "Названия",
        "participants": "Участники",
        "target": "Участники",
        "type": "Тип"
      },
      "hints": {
        "participants": "Добавьте в свой Разговор участников, нажав на иконку {icon} справа вверху."
      },
      "index": {
        "add": "Новый Разговор",
        "description": "Управление категорией {name}.",
        "header": "Разговоры в {name}",
        "title": "Разговоры"
      },
      "messages": {
        "destroy": {
          "success": "Сообщение удалено."
        },
        "is_updated": "Обновлено",
        "load_previous": "Загрузить предыдущие сообщения",
        "placeholders": {
          "message": "Ваше сообщение"
        }
      },
      "participants": {
        "create": {
          "success": "Участник {entity} добавлен в Разговор."
        },
        "description": "Добавление или удаление участников Разговора.",
        "destroy": {
          "success": "Участник {entity} удален из Разговора"
        },
        "modal": "Участники",
        "title": "Участники {name}"
      },
      "placeholders": {
        "name": "Название Разговора",
        "type": "Игровой, подготовка, выдуманный"
      },
      "show": {
        "description": "Детальный вид разговора.",
        "title": "Разговор {name}"
      },
      "tabs": {
        "conversation": "Разговор",
        "participants": "Участники"
      },
      "targets": {
        "characters": "Персонажи",
        "members": "Члены"
      }
    },
    "crud": {
      "actions": {
        "actions": "Действия",
        "apply": "Применить",
        "back": "Назад",
        "copy": "Копировать",
        "copy_mention": "Копировать [ ] ссылку",
        "copy_to_campaign": "Копировать в Кампанию",
        "explore_view": "Свернутый вид",
        "export": "Экспортировать (PDF)",
        "find_out_more": "Узнать больше",
        "go_to": "Перейти к {name}",
        "json-export": "Экспортировать (JSON)",
        "more": "Больше действий",
        "move": "Переместить",
        "new": "Новый",
        "next": "Следующее",
        "private": "Приватный",
        "public": "Публичный",
        "reset": "Сброс"
      },
      "add": "Добавить",
      "alerts": {
        "copy_mention": "Специальная ссылка на объект скопирована в ваш буфер обмена."
      },
      "attributes": {
        "actions": {
          "add": "Добавить атрибут",
          "add_block": "Добавить блок",
          "add_checkbox": "Добавить флажок",
          "add_text": "Добавить текст",
          "apply_template": "Применить Шаблон Атрибутов",
          "manage": "Управление",
          "remove_all": "Удалить все"
        },
        "create": {
          "description": "Создание нового атрибута.",
          "success": "Атрибут {name} добавлен к {entity}.",
          "title": "Новый Атрибут для {name}"
        },
        "destroy": {
          "success": "Атрибут {name} для {entity} удален."
        },
        "edit": {
          "description": "Обновление существующего атрибута.",
          "success": "Атрибут {name} для {entity} обновлен.",
          "title": "Обновление атрибута для {name}"
        },
        "fields": {
          "attribute": "Атрибут",
          "community_templates": "Шаблоны сообщества",
          "is_private": "Приватные атрибуты",
          "is_star": "Закреплен",
          "template": "Шаблон",
          "value": "Значение"
        },
        "helpers": {
          "delete_all": "Вы уверены, что хотите удалить все атрибуты этого объекта?"
        },
        "hints": {
          "is_private": "Вы можете скрыть все атрибуты объекта для всех участников без роли \"Админ\", сделав их приватными."
        },
        "index": {
          "success": "Атрибуты для {name} обновлены.",
          "title": "Атрибуты для {name}"
        },
        "placeholders": {
          "attribute": "Число завоеваний, оценка испытаний, инициатива, население",
          "block": "Название блока",
          "checkbox": "Название флажка",
          "section": "Название раздела",
          "template": "Выберите Шаблон",
          "value": "Значение атрибута"
        },
        "template": {
          "success": "Шаблон Атрибутов {name} применен к {entity}",
          "title": "Применение Шаблона Атрибутов к {name}"
        },
        "types": {
          "attribute": "Атрибут",
          "block": "Блок",
          "checkbox": "Флажок",
          "section": "Раздел",
          "text": "Большой текст"
        },
        "visibility": {
          "entry": "Атрибут расположен в меню объектов.",
          "private": "Атрибут виден только участникам с ролью \"Админ\".",
          "public": "Атрибут виден всем участникам.",
          "tab": "Атрибут отображается только во вкладке атрибутов."
        }
      },
      "boosted": "Усилена",
      "boosted_campaigns": "Усиленные Кампании",
      "bulk": {
        "actions": {
          "edit": "Массовый редактор и Тэги"
        },
        "age": {
          "helper": "Вы можете использовать + и - перед числом, чтобы изменить возраст на это число."
        },
        "delete": {
          "title": "Удаление нескольких объектов",
          "warning": "Вы уверены, что хотите удалить выбранные объекты?"
        },
        "edit": {
          "tagging": "Действие с тэгами",
          "tags": {
            "add": "Добавить",
            "remove": "Удалить"
          },
          "title": "Редактирование нескольких объектов"
        },
        "errors": {
          "admin": "Статус приватности объектов могут редактировать только Админы Кампании.",
          "general": "При выполнении вашего действия произошла ошибка. Пожалуйста, попробуйте снова и свяжитесь с нами, если проблема повторится. Сообщение ошибки: {hint}."
        },
        "permissions": {
          "fields": {
            "override": "Перезапись"
          },
          "helpers": {
            "override": "Если включена, то разрешения выбранных объектов будут заменены. Если нет, эти разрешения будут добавлены к существующим."
          },
          "title": "Изменение разрешений нескольких объектов"
        },
        "success": {
          "copy_to_campaign": "{1} {count} объект скопирован в {campaign}.|[2, 4] {count} объекта скопировано в {campaign}.|[5, *] {count} объектов скопировано в {campaign}.",
          "editing": "{1} {count} объект обновлен.|[2, 4] {count} объекта обновлено.|[5, *] {count} объектов обновлено.",
          "permissions": "{1} Разрешения изменены для {count} объекта.|[2, *] Разрешения изменены для {count} объектов.",
          "private": "{1} {count} объект теперь приватен.|[2, 4] {count} объекта теперь приватно.|[5, *] {count} объектов теперь приватны.",
          "public": "{1} {count} объект теперь невидим.|[2, 4] {count} объекта теперь невидимы.|[5, *] {count} объектов теперь невидимы."
        }
      },
      "cancel": "Отмена",
      "click_modal": {
        "close": "Закрыть",
        "confirm": "Подтвердить",
        "title": "Подтверждение вашего действия"
      },
      "copy_to_campaign": {
        "bulk_title": "Копирование объектов в другую Кампанию",
        "panel": "Копировать",
        "title": "Копирование \"{name}\" в другую Кампанию"
      },
      "create": "Создать",
      "datagrid": {
        "empty": "Нечего показать."
      },
      "delete_modal": {
        "close": "Закрыть",
        "delete": "Удалить",
        "description": "Вы уверены, что хотите удалить {tag}?",
        "mirrored": "Удалить зеркальную связь",
        "title": "Подтверждение удаления"
      },
      "destroy_many": {
        "success": "Удален {count} объект.|Удалено {count} объектов."
      },
      "edit": "Редактировать",
      "errors": {
        "boosted": "Эта функция доступна только для усиленный Кампаний.",
        "node_must_not_be_a_descendant": "Неправильный узел (Тэг, родительская Локация): это потомок самого себя."
      },
      "events": {
        "hint": "Ниже расположен список всех Календарей, в которые добавлено это событие с помощью \"Добавить Событие в Календарь\"."
      },
      "export": "Экспортировать",
      "fields": {
        "ability": "Способность",
        "attribute_template": "Шаблон Артибутов",
        "calendar": "Календарь",
        "calendar_date": "Дата Календаря",
        "character": "Персонаж",
        "colour": "Цвет",
        "copy_attributes": "Копировать атрибуты",
        "copy_notes": "Копировать заметки объекта",
        "creator": "Создатель",
        "dice_roll": "Бросок Кубика",
        "entity": "Объект",
        "entity_type": "Тип объекта",
        "entry": "Текст",
        "event": "Событие",
        "excerpt": "Выдержка",
        "family": "Семья",
        "files": "Файлы",
        "has_image": "Есть изображение",
        "header_image": "Изображение заголовка",
        "image": "Изображение",
        "is_private": "Приватный",
        "is_star": "Закреплен",
        "item": "Предмет",
        "location": "Локация",
        "map": "Карта",
        "name": "Название",
        "organisation": "Организация",
        "position": "Позиция",
        "race": "Раса",
        "tag": "Тэг",
        "tags": "Тэги",
        "timeline": "Хронология",
        "tooltip": "Подсказка",
        "type": "Тип",
        "visibility": "Видимость"
      },
      "files": {
        "actions": {
          "drop": "Нажмите, чтобы добавить или удалить файл",
          "manage": "Управление файлами объектов"
        },
        "errors": {
          "max": "Вы достигли лимита ({max}) файлов для этого объекта.",
          "no_files": "Нет файлов."
        },
        "files": "Обновленные файлы",
        "hints": {
          "limit": "Каждый объект может иметь не более {max} загруженных файлов.",
          "limitations": "Форматы: jpg, png, gif и pdf. Макс. размер файла: {size}."
        },
        "title": "Файлы объекта {name}"
      },
      "filter": "Фильтр",
      "filters": {
        "all": "Фильтр для всех потомков",
        "clear": "Очистить фильтры",
        "direct": "Фильтр для прямых потомков",
        "filtered": "Показано {count} из {total} {entity}",
        "hide": "Скрыть фильтры",
        "options": {
          "exclude": "Исключить",
          "include": "Включить",
          "none": "Нет"
        },
        "show": "Показать фильтры",
        "sorting": {
          "asc": "По возрастанию {field}",
          "desc": "По убыванию {field}",
          "helper": "Управление порядком сортировки результатов"
        },
        "title": "Фильтры"
      },
      "forms": {
        "actions": {
          "calendar": "Добавить дату Календаря."
        },
        "copy_options": "Копировать опции"
      },
      "hidden": "Скрытый",
      "hints": {
        "attribute_template": "Применять Шаблон Атрибутов непосредственно при создании объекта.",
        "calendar_date": "Дата Календаря позволяет легко фильтровать в списках, а также хранит Событие выбранного Календаря.",
        "header_image": "Это изображение будет расположено над объектом. Лучше использовать широкое изображение.",
        "image_limitations": "Форматы: jpg, png и gif. Макс. размер файла: {size}.",
        "image_patreon": "Увеличить лимит размера файла?",
        "is_private": "Если установлено на \"Приватный\", то этот объект могут видеть только участники Кампании с ролью \"Админ\".",
        "is_star": "Закрепленные элементы появятся в меню объектов.",
        "map_limitations": "Форматы: jpg, png, gif и svg. Макс. размер файла: {size}.",
        "tooltip": "Заменить автоматически сгенерированную подсказку на следующее содержание.",
        "visibility": "Значение видимости \"Админ\" означает, что это могут видеть только участники Кампании с ролью \"Админ\". Значение \"Я\" означает, что это можете видеть только вы."
      },
      "history": {
        "created": "Создан <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>.",
        "created_date": "Создан <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>.",
        "unknown": "Неизвестно",
        "updated": "Последнее изменение от <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>.",
        "updated_date": "Последнее изменение <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>.",
        "view": "Показать журнал объекта"
      },
      "image": {
        "error": "Нам не удалось получить запрошенное изображение. Возможно, сайт не позволяет нам скачать изображение (типично для Squarespace и DeviantArt) или эта ссылка уже не действительна. Пожалуйста, убедитесь также, что изображение не превышает {size}."
      },
      "is_private": "Этот объект приватен и виден только участникам с ролью \"Админ\".",
      "linking_help": "Как я могу ссылаться на другие объекты.",
      "manage": "Управление",
      "move": {
        "description": "Перемещение этого объекта в другое место.",
        "errors": {
          "permission": "Вам не разрешено создавать объекты этого типа в этой Кампании.",
          "same_campaign": "Вам нужно выбрать другую Кампанию, чтобы переместить в нее этот объект.",
          "unknown_campaign": "Неизвестная Кампания."
        },
        "fields": {
          "campaign": "Новая Кампания",
          "copy": "Создать копию",
          "target": "Новый тип"
        },
        "hints": {
          "campaign": "Вы также можете попробовать переместить этот объект в другую Кампанию.",
          "copy": "Выберите эту опцию, если хотите создать копию в новой Кампании.",
          "target": "Пожалуйста, учтите, что некоторые данные могут быть потеряны при перемещении элемента из одного типа в другой."
        },
        "success": "Объект \"{name}\" перемещен.",
        "success_copy": "Объект \"{name}\" скопирован.",
        "title": "Перемещение {name}"
      },
      "new_entity": {
        "error": "Пожалуйста, проверьте ваши значения.",
        "fields": {
          "name": "Название"
        },
        "title": "Новый объект"
      },
      "or_cancel": "или <a href=\"{url}\">отменить</a>",
      "panels": {
        "appearance": "Оформление",
        "attribute_template": "Шаблон Атрибутов",
        "calendar_date": "Дата Календаря",
        "entry": "Текст",
        "general_information": "Основная информация",
        "move": "Переместить",
        "system": "Система"
      },
      "permissions": {
        "action": "Действия",
        "actions": {
          "bulk": {
            "add": "Разрешить",
            "deny": "Запретить",
            "ignore": "Пропустить",
            "remove": "Удалить"
          },
          "bulk_entity": {
            "allow": "Разрешить",
            "deny": "Запретить",
            "inherit": "Наследовать"
          },
          "delete": "Удалить",
          "edit": "Редактировать",
          "entity_note": "Заметки объекта",
          "read": "Читать",
          "toggle": "Изменить"
        },
        "allowed": "Позволено",
        "fields": {
          "member": "Участник",
          "role": "Роль"
        },
        "helper": "Используйте этот интерфейс, чтобы настроить, какие пользователи и роли могут взаимодействовать с этим объектом. {allow}",
        "helpers": {
          "setup": "Используйте этот интерфейс, чтобы настроить то, как роли и пользователи могут взаимодействовать с этим объектом. {allow} позволит пользователю или роли совершать это действие. {deny} запретит им это действие. {inherit} будет использовать разрешение роли пользователя или основной роли. Пользователь с {allow} может совершать даже те действия, которые для его роли установлены как {deny}."
        },
        "inherited": "У этой роли уже есть это разрешение для этого типа объектов.",
        "inherited_by": "Этот пользователь входит в роль \"{role}\", у которой есть эти разрешения для этого типа объектов.",
        "success": "Разрешения сохранены.",
        "title": "Разрешения",
        "too_many_members": "В этой Кампании слишком много участников (>10) для отображения этого интерфейса. Пожалуйста, используйте кнопку \"Разрешения\" объекта для детального контроля разрешений."
      },
      "placeholders": {
        "ability": "Выберите Способность",
        "calendar": "Выберите Календарь",
        "character": "Выберите Персонажа",
        "entity": "Объект",
        "event": "Выберите Событие",
        "family": "Выберите Семью",
        "image_url": "Вы также можете загрузить изображение из URL",
        "item": "Выберите Предмет",
        "location": "Выберите Локацию",
        "map": "Выберите Карту",
        "organisation": "Выберите Организацию",
        "race": "Выберите Расу",
        "tag": "Выберите Тэг"
      },
      "relations": {
        "actions": {
          "add": "Добавить связь"
        },
        "fields": {
          "location": "Локация",
          "name": "Название",
          "relation": "Связь"
        },
        "hint": "Связи между объектами можно назначить для обозначения их отношений друг с другом."
      },
      "remove": "Удалить",
      "rename": "Переименовать",
      "save": "Сохранить",
      "save_and_close": "Сохранить и Копировать",
      "save_and_copy": "Сохранить и Копировать",
      "save_and_new": "Сохранить и Создать",
      "save_and_update": "Сохранить и Обновить",
      "save_and_view": "Сохранить и Показать",
      "search": "Искать",
      "select": "Выбрать",
      "tabs": {
        "abilities": "Способности",
        "attributes": "Атрибуты",
        "boost": "Усиление",
        "calendars": "Календари",
        "default": "Умолчание",
        "events": "События",
        "inventory": "Инвентарь",
        "map-points": "Точки на карте",
        "mentions": "Упоминания",
        "menu": "Меню",
        "notes": "Заметки объекта",
        "permissions": "Разрешения",
        "relations": "Связи",
        "reminders": "Напоминания",
        "timelines": "Хронологии",
        "tooltip": "Подсказка"
      },
      "update": "Обновить",
      "users": {
        "unknown": "Неизвестно"
      },
      "view": "Показать",
      "visibilities": {
        "admin": "Админ",
        "admin-self": "Вы и Админ",
        "all": "Все",
        "self": "Вы"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": [],
    "settings": {
      "account": {
        "actions": {
          "social": "Вход Kanka",
          "update_email": "Обновить электронную почту",
          "update_password": "Обновить пароль"
        },
        "email": "Смена электронной почты",
        "email_success": "Электронная почта обновлена.",
        "password": "Смена пароля",
        "password_success": "Пароль обновлен.",
        "social": {
          "error": "Вы уже используете вход Kanka на этом аккаунте.",
          "helper": "Ваш аккаунт сейчас управляется с помощью {provider}. Вы можете остановить это и включить стандартный вход Kanka через ввод пароля.",
          "success": "Теперь ваш аккаунт использует вход Kanka.",
          "title": "Вход Kanka"
        },
        "title": "Аккаунт"
      },
      "api": {
        "experimental": "Добро пожаловать в Kanka API! Эти функции пока экспериментальные, но достаточно стабильные, чтобы вы могли начать общаться с помощью API. Создайте личный токен доступа для использования ваших API запросов или используйте клиентский токен, если вы хотите, чтобы ваше приложение имело доступ к данным пользователей.",
        "help": "Kanka скоро обеспечит RESTful API, чтобы приложения третьей стороны могли подключаться к этому приложению. Детали управления API ключами будут показаны ниже.",
        "link": "Читать API документацию",
        "request_permission": "Мы работаем над созданием RESTful API, чтобы приложения третьей стороны могли подключаться к этому приложению. Однако, мы ограничиваем число пользователей, которые могут взаимодействовать с API, пока мы работаем над ним. Если вы хотите получить доступ к API и создавать крутые приложения для доступа к Kanka, пожалуйста свяжитесь с нами, и мы отправим вам всю необходимую информацию.",
        "title": "API"
      },
      "apps": {
        "actions": {
          "connect": "Подключиться",
          "remove": "Удалить"
        },
        "benefits": "Kanka поддерживает несколько соединений с сервисами третьей стороны. Больше соединений планируется в будущем.",
        "discord": {
          "errors": {
            "add": "При соединении с вашим Discord аккаунтом через Kanka произошла ошибка. Пожалуйста, попробуйте снова."
          },
          "success": {
            "add": "Ваш Discord аккаунт подключен.",
            "remove": "Ваш Discord аккаунт отключен."
          },
          "text": "Получите доступ к вашим ролям подписки автоматически."
        },
        "title": "Подключение к приложению"
      },
      "boost": {
        "benefits": {
          "first": "Для гарантии продолжения развития Kanka, некоторые черты Кампаний доступны только с помощью усилителей Кампаний. Усилители доступны по подписке. Любой, кто видит Кампанию, может усилить ее, так что Админ не всегда должен за это платить. Кампания остается усиленной пока пользователь ее усиливает и продолжает поддерживать Kanka. Если Кампания теряет усиление, то данные не теряются, они просто скрываются, пока Кампанию снова не усилят.",
          "header": "Изображения заголовков объектов",
          "images": "Заказные изображения объектов по умолчанию",
          "more": "Узнать больше обо всех функциях",
          "second": "Усиление Кампании дает следующие преимущества:",
          "theme": "Тема уровней Кампании и заказной стиль",
          "third": "Чтобы усилить Кампанию, перейдите на ее страницу и нажмите на кнопку \"{boost_button}\" над кнопкой \"{edit_button}\".",
          "tooltip": "Заказные подсказки для объектов",
          "upload": "Увеличенный вес загружаемых файлов для всех членов Кампании"
        },
        "buttons": {
          "boost": "Усилить"
        },
        "campaigns": "Усиленные Кампании {count}/{max}",
        "exceptions": {
          "already_boosted": "Кампания {name} уже усилена.",
          "exhausted_boosts": "У вас закончились усилители. Уберите усилитель с одной из Кампаний, чтобы применить его на другую."
        },
        "success": {
          "boost": "Кампания {name} усилена.",
          "delete": "Ваше усиление удалено с {name}."
        },
        "title": "Усилить"
      },
      "countries": {
        "austria": "Австрия",
        "belgium": "Бельгия",
        "france": "Франция",
        "germany": "Германия",
        "italy": "Италия",
        "netherlands": "Нидерланды",
        "spain": "Испания"
      },
      "invoices": {
        "actions": {
          "download": "Скачать PDF",
          "view_all": "Показать все"
        },
        "empty": "Нет счетов",
        "fields": {
          "amount": "Количество",
          "date": "Дата",
          "invoice": "Счет",
          "status": "Статус"
        },
        "header": "Ниже список ваших последних 24 счетов, которые можно скачать.",
        "status": {
          "paid": "Оплачен",
          "pending": "Неоплачен"
        },
        "title": "Счета"
      },
      "layout": {
        "success": "Оформление обновлено.",
        "title": "Оформление"
      },
      "menu": {
        "account": "Аккаунт",
        "api": "API",
        "apps": "Приложения",
        "billing": "Способ оплаты",
        "boost": "Усилители",
        "invoices": "Счета",
        "layout": "Оформление",
        "other": "Другое",
        "patreon": "Patreon",
        "payment_options": "Способы оплаты",
        "personal_settings": "Персональные настройки",
        "profile": "Профиль",
        "subscription": "Подписка",
        "subscription_status": "Статус подписки"
      },
      "patreon": {
        "actions": {
          "link": "Подключить аккаунт",
          "view": "Посетить Kanka на Patreon"
        },
        "benefits": "Поддержка нашего {patreon} разблокирует все {features} для вас и ваших Кампаний, а также позволит нам проводить больше времени, работая над улучшением Kanka.",
        "benefits_features": "потрясающие функции",
        "deprecated": "Устаревшая функция - если вы хотите поддержать Kanka, пожалуйста сделайте это с помощью {subscription}. Ссылка на Patreon до сих пор активна для наших патреонцев, которые подключили их аккаунты до выхода с Patreon.",
        "description": "Синхронизация с Patreon.",
        "errors": {
          "invalid_token": "Недействительный токен! Patreon не может утвердить ваш запрос.",
          "missing_code": "Код отсутствует! Patreon вернул код, определяющий ваш аккаунт.",
          "no_pledge": "Залог отсутствует! Patreon определил ваш аккаунт, но у вас нет на нем активного залога."
        },
        "link": "Используйте следующую кнопку, если вы уже поддерживаете Kanka на {patreon}. Это разблокирует бонусы.",
        "linked": "Спасибо за поддержку на Patreon! Ваш аккаунт подключен.",
        "pledge": "Залог: {name}",
        "remove": {
          "button": "Отключить ваш Patreon аккаунт",
          "success": "Ваш Patreon аккаунт отключен.",
          "text": "Отключение вашего Patreon аккаунта Kanka удалит ваши бонусы, имя в Зале Славы, усилители Кампаний и другие функции, включенные в поддержку Kanka. Все созданное при усилении не пропадет (например заголовки объектов). Подписавшись назад вы получите доступ ко всем этим данным, включая возможность усиливать ваши кампании.",
          "title": "Отключение вашего Patreon аккаунта Kanka"
        },
        "success": "Спасибо за поддержку Kanka на Patreon!",
        "title": "Patreon",
        "wrong_pledge": "Уровень вашего залога устанавливается нами вручную, так что, пожалуйста, дайте нам пару дней на то, чтобы правильно его настроить."
      },
      "profile": {
        "actions": {
          "update_profile": "Обновить профиль"
        },
        "avatar": "Картинка профиля",
        "success": "Профиль обновлен",
        "title": "Личный профиль"
      },
      "subscription": {
        "actions": {
          "cancel_sub": "Отменить подписку",
          "subscribe": "Подписаться",
          "update_currency": "Сохранить предпочитаемую валюту"
        },
        "benefits": "Поддерживая нас, вы можете разблокировать новые {features} и помочь нам проводить больше времени над улучшением Kanka. Информация кредитной карты не сохраняется и не передается через наши сервера. Мы используем {stripe} для управления оплатой.",
        "billing": {
          "helper": "Информация о вашей оплате обработана и сохранена с помощью {stripe}. Этот способ оплаты используется для всех ваших подписок.",
          "saved": "Сохраненный способ оплаты",
          "title": "Редактировать Способ Оплаты"
        },
        "cancel": {
          "text": "Жаль, что вы уходите! Отмена вашей подписки сохранит ее активной до следующего цикла оплаты, после которого вы потеряете ваши усилители Кампаний и другие привилегии относящиеся к поддержке Kanka. Можете заполнить следующую форму, чтобы сообщить нам, что мы можем сделать лучше или почему вы приняли это решение."
        },
        "cancelled": "Ваша подписка отменена. Вы можете обновить подписку, как только у вас закончится нынешняя подписка.",
        "change": {
          "text": {
            "monthly": "Вы подписываетесь на уровень {tier}, оплачиваемый в {amount} в месяц.",
            "yearly": "Вы подписываетесь на уровень {tier}, оплачиваемый в {amount} в год."
          },
          "title": "Изменение уровня подписки"
        },
        "currencies": {
          "eur": "EUR",
          "usd": "USD"
        },
        "currency": {
          "title": "Изменение вашей предпочитаемой валюты оплаты"
        },
        "errors": {
          "callback": "Наш провайдер счетов сообщил об ошибке. Пожалуйста, попробуйте еще раз или свяжитесь с нами, если проблема повторится.",
          "subscribed": "Невозможно обработать вашу подписку. Stripe предоставил следующий совет."
        },
        "fields": {
          "active_since": "Активна с",
          "active_until": "Активна до",
          "billing": "Оплата",
          "currency": "Валюта оплаты",
          "payment_method": "Способ оплаты",
          "plan": "Текущий план",
          "reason": "Причина"
        },
        "helpers": {
          "alternatives": "Оплатите свою подписку с помощью {method}. Этот способ оплаты не будет обновляться по окончанию вашей подписки. {method} доступен только для Евро.",
          "alternatives_warning": "Повышение вашего уровня подписки при данном способе невозможно. Пожалуйста, создайте новую подписку, когда закончится текущая.",
          "alternatives_yearly": "Из-за ограничений, связанных с повторяющимися оплатами, {method} доступен только для годовых подписок."
        },
        "manage_subscription": "Управление подпиской",
        "payment_method": {
          "actions": {
            "add_new": "Добавить новый способ оплаты",
            "change": "Изменить способ оплаты",
            "save": "Сохранить способ оплаты",
            "show_alternatives": "Альтернативные способы оплаты"
          },
          "add_one": "У вас нет сохраненного способа оплаты.",
          "alternatives": "Вы можете подписаться с помощью альтернативных способов оплаты. Это действие изменит ваш аккаунт один раз и не будет обновлять его каждый месяц.",
          "card": "Карта",
          "card_name": "Имя на карте",
          "country": "Страна проживания",
          "ending": "Заканчивается на",
          "helper": "Эта карта будет использоваться для всех ваших подписок.",
          "new_card": "Добавить новый способ оплаты",
          "saved": "{brand} заканчивается на {last4}"
        },
        "placeholders": {
          "reason": "Если хотите, можете сказать нам, почему вы больше не поддерживаете Kanka. Отсутствует необходимая функция? Изменилась ваша финансовая ситуация?"
        },
        "plans": {
          "cost_monthly": "{currency} {amount} выплачивается в месяц",
          "cost_yearly": "{currency} {amount} выплачивается в год"
        },
        "sub_status": "Информация о подписке",
        "subscription": {
          "actions": {
            "downgrading": "Пожалуйста, свяжитесь с нами для понижения",
            "rollback": "Изменить на Kobold",
            "subscribe": "Изменить на месячный {tier}",
            "subscribe_annual": "Изменять на годовой {tier}"
          }
        },
        "success": {
          "alternative": "Ваша оплата зарегистрирована. Вы получите уведомление, как только она будет обработана и ваша подписка будет активирована.",
          "callback": "Ваша подписка успешно оформлена. Ваш аккаунт будет обновлен, как только наш провайдер счетов сообщит нам об изменении (это может занять несколько минут)",
          "cancel": "Ваша подписка была отменена. Она будет активной до окончания вашего текущего периода оплаты.",
          "currency": "Настройки вашей предпочитаемой валюты обновлены.",
          "subscribed": "Ваша подписка успешно оформлена. Не забудьте подписаться на рассылку голосований, чтобы знать, когда начнется голосование. Вы можете изменить свои настройки рассылки на странице вашего профиля."
        },
        "tiers": "Уровни подписки",
        "trial_period": "У годовых подписок есть возможность отмены в течение 14 дней. Свяжитесь с нами через {email}, если вы хотите отменить вашу годовую подписку и получить деньги назад.",
        "upgrade_downgrade": {
          "button": "Информация о повышении и понижении",
          "downgrade": {
            "bullets": {
              "end": "Ваш текущий уровень будет активен до окончания текущего цикла оплаты, после чего вы будете понижены до вашего нового уровня."
            },
            "title": "При понижении на уровень"
          },
          "upgrade": {
            "bullets": {
              "immediate": "Ваш способ оплаты будет немедленно оплачен и вы получите доступ к вашему новому уровню.",
              "prorate": "При повышении с Owlbear на Elemental вы заплатите только разницу с вашим новым уровнем."
            },
            "title": "При повышении на уровень"
          }
        },
        "warnings": {
          "incomplete": "Не удалось снять деньги с вашей карты. Пожалуйста обновите информацию вашей кредитной карты, и мы попробуем снова в течение следующих нескольких дней. Если ошибка произойдет снова, ваша подписка будет отменена.",
          "patreon": "Ваш аккаунт подключен к Patreon. Пожалуйста, отключите ваш аккаунт в ваших настройках {patreon} перед включением Kanka подписки."
        }
      }
    }
  },
  "sk": {
    "admin": [],
    "calendars": [],
    "campaigns": [],
    "conversations": {
      "create": {
        "description": "Vytvoriť novú diskusiu",
        "success": "Diskusia {name} vytvorená.",
        "title": "Nová diskusia"
      },
      "destroy": {
        "success": "Diskusia {name} odstránená."
      },
      "edit": {
        "description": "Upraviť diskusiu",
        "success": "Diskusia {name} upravená.",
        "title": "Diskusia {name}"
      },
      "fields": {
        "messages": "Správy",
        "name": "Meno",
        "participants": "Účastníci",
        "target": "Cieľ",
        "type": "Typ"
      },
      "hints": {
        "participants": "Prosím, pridaj do diskusiu účastníkov tým, že klikneš na symbol {icon} hore vpravo."
      },
      "index": {
        "add": "Nová diskusia",
        "description": "Spravovať kategóriu {name}.",
        "header": "Diskusie v {name}",
        "title": "Diskusie"
      },
      "messages": {
        "destroy": {
          "success": "Správa odstránená."
        },
        "is_updated": "Upravená",
        "load_previous": "Nahrať predchádzajúce správy",
        "placeholders": {
          "message": "Tvoja správa"
        }
      },
      "participants": {
        "create": {
          "success": "Účastník {entity} pridaný do diskusie."
        },
        "description": "Pridať alebo odstrániť účastníkov z diskusie",
        "destroy": {
          "success": "Účastník {entity} odstránený z diskusie."
        },
        "modal": "Účastníci",
        "title": "Účastníci {name}"
      },
      "placeholders": {
        "name": "Názov diskusie",
        "type": "V hre, príprave, deji"
      },
      "show": {
        "description": "Detailné zobrazenie diskusie",
        "title": "Diskusia {name}"
      },
      "tabs": {
        "conversation": "Diskusia",
        "participants": "Účastníci"
      },
      "targets": {
        "characters": "Postavy",
        "members": "Členovia"
      }
    },
    "crud": {
      "actions": {
        "actions": "Akcie",
        "apply": "Použiť",
        "back": "Naspäť",
        "copy": "Kopírovať",
        "copy_mention": "Kopírovať [ ] referenciu",
        "copy_to_campaign": "Kopírovať do kampane",
        "explore_view": "Vložené zobrazenie",
        "export": "Exportovať (PDF)",
        "find_out_more": "Dozvedieť sa viac",
        "go_to": "Prejsť na {name}",
        "json-export": "Exportovať (json)",
        "more": "Ďalšie akcie",
        "move": "Premiestniť",
        "new": "Nový",
        "next": "Ďalej",
        "private": "Súkromný",
        "public": "Verejný",
        "reset": "Resetovať"
      },
      "add": "Pridať",
      "alerts": {
        "copy_mention": "Rozšírená referencia objektu bola skopírovaná do tvojej schránky."
      },
      "attributes": {
        "actions": {
          "add": "Pridať atribúť",
          "add_block": "Pridať blok",
          "add_checkbox": "Pridať zaškrtávacie políčko",
          "add_text": "Pridať text",
          "apply_template": "Použiť šablónu atribútov",
          "manage": "Spravovať",
          "remove_all": "Odstrániť všetko"
        },
        "create": {
          "description": "Vytvoriť nový atribút",
          "success": "Atribút {name} pridaný k {entity}.",
          "title": "Nový atribút pre {name}"
        },
        "destroy": {
          "success": "Atribút {name} odstránený z {entity}."
        },
        "edit": {
          "description": "Upraviť existujúci atribút",
          "success": "Atribút {name} upravený pre {entity}.",
          "title": "Upraviť atribút pre {name}"
        },
        "fields": {
          "attribute": "Atribút",
          "community_templates": "Komunitné šablóny",
          "is_private": "Súkromné atribúty",
          "is_star": "Pripnutý",
          "template": "Šablóna",
          "value": "Hodnota"
        },
        "helpers": {
          "delete_all": "Naozaj chceš odstrániť všetky atribúty tohto objektu?"
        },
        "hints": {
          "is_private": "Všetky atribúty objektu je možné skryť pred všetkými členmi okrem tých s rolou Admin, ak ho nastavíš ako súkromný."
        },
        "index": {
          "success": "Atribúty pre {entity} upravené.",
          "title": "Atribúty pre {name}"
        },
        "placeholders": {
          "attribute": "Počet dobytí, úroveň obtiažnosti výzvy, iniciatíva, obyvateľstvo",
          "block": "Názov bloku",
          "checkbox": "Názov zaškrtávacieho políčka",
          "section": "Názov sekcie",
          "template": "Vybrať šablónu",
          "value": "Hodnota atribútu"
        },
        "template": {
          "success": "Šablóna atribútov {name} použitá na {entity}",
          "title": "Použiť šablónu atribútov na {name}"
        },
        "types": {
          "attribute": "Atribút",
          "block": "Blok",
          "checkbox": "Zaškrtávacie políčko",
          "section": "Sekcia",
          "text": "Viacriadkový text"
        },
        "visibility": {
          "entry": "Atribút je zobrazený v menu objektu.",
          "private": "Atribút viditeľný len pre členov s rolou Admin.",
          "public": "Atribút viditeľný pre všetkých členov.",
          "tab": "Atribút je zobrazený len v karte atribútov."
        }
      },
      "boosted": "Boostnutá",
      "boosted_campaigns": "Boostnuté kampane",
      "bulk": {
        "actions": {
          "edit": "Hromadná úprava a kategórie"
        },
        "age": {
          "helper": "Môžeš použiť + a - pred číslom na úpravu veku o danú hodnotu."
        },
        "delete": {
          "title": "Odstraňujú sa viaceré objekty",
          "warning": "Naozaj chceš odstrániť vybrané objekty?"
        },
        "edit": {
          "tagging": "Akcie s kategóriami",
          "tags": {
            "add": "Pridať",
            "remove": "Odstrániť"
          },
          "title": "Úprava viacerých objektov"
        },
        "errors": {
          "admin": "Iba administrátori kampane vedia zmeniť súkromný štatút objektu.",
          "general": "Pri spracovávaní tvojej akcie došlo k chybe. Prosím, skús to opäť a kontaktuj nás, ak problém pretrváva. Hlásenie chyby: {hint}."
        },
        "permissions": {
          "fields": {
            "override": "Prepísať"
          },
          "helpers": {
            "override": "Ak aktivované, oprávnenia vybratých objektov budú týmito prepísané. Ak deaktivované, vybrané oprávnenia budú pridané k predchádzajúcim."
          },
          "title": "Zmeniť oprávnenia pre viaceré objekty"
        },
        "success": {
          "copy_to_campaign": "{1} {count} objekt bol skopírovaný do {campaign}.|[2,4] {count} objekty boli skopírované do {campaign}.|[5,*] {count} objektov bolo skopírovaných do {campaign}.",
          "editing": "{1} {count} objekt bol upravený.|[2,4] {count} objekty boli upravené.|[5,*] {count} objektov bolo upravených.",
          "permissions": "{1} Oprávnenia zmenené pre {count} objekt.|[2,4] Oprávnenia zmenené pre {count} objekty.|[5,*] Oprávnenia zmenené pre {count} objektov.",
          "private": "{1} {count} objekt je teraz súkromný.|[2,4] {count} objekty je teraz súkromné.|[5,*] {count} objektov je teraz súkromných.",
          "public": "{1} {count} objekt je teraz viditeľný.|[2,4] {count} objekty sú teraz viditeľné.|[5,*] {count} objektov je teraz viditeľných."
        }
      },
      "cancel": "Zrušiť",
      "click_modal": {
        "close": "Zavrieť",
        "confirm": "Potvrdiť",
        "title": "Potvrdiť akciu"
      },
      "copy_to_campaign": {
        "bulk_title": "Kopírovať objekty do inej kampane",
        "panel": "Kopírovať",
        "title": "Kopírovať {name} do inej kampane"
      },
      "create": "Vytvoriť",
      "datagrid": {
        "empty": "Zatiaľ je tu prázdno."
      },
      "delete_modal": {
        "close": "Zatvoriť",
        "delete": "Odstrániť",
        "description": "Naozaj chceš odstrániť {tag}?",
        "mirrored": "Odstrániť zrkadlený vzťah.",
        "title": "Potvrdiť odstránenie"
      },
      "destroy_many": {
        "success": "{count} objekt zmazaný|{count} objekty zmazané"
      },
      "edit": "Upraviť",
      "errors": {
        "boosted": "Táto funkcia je dostupná iba pre boostnuté kampane.",
        "node_must_not_be_a_descendant": "Neplatný objekt (kategória, miesto): bol by potomok samého seba."
      },
      "events": {
        "hint": "Kalendárne udalosti, ktoré sú prepojené s týmto objektom, sa zobrazujú na tomto mieste."
      },
      "export": "Exportovať",
      "fields": {
        "ability": "Schopnosť",
        "attribute_template": "Šablóna atribútov",
        "calendar": "Kalendár",
        "calendar_date": "Dátum",
        "character": "Postava",
        "colour": "Farba",
        "copy_attributes": "Kopírovať atribúty",
        "copy_notes": "Kopírovať poznámky objektu",
        "creator": "Autor",
        "dice_roll": "Hod kockou",
        "entity": "Objekt",
        "entity_type": "Typ objektu",
        "entry": "Záznam",
        "event": "Udalosť",
        "excerpt": "Výpis",
        "family": "Rod",
        "files": "Súbory",
        "header_image": "Obrázok záhlavia",
        "image": "Obrázok",
        "is_private": "Súkromný",
        "is_star": "Pripnutý",
        "item": "Predmet",
        "location": "Miesto",
        "map": "Mapa",
        "name": "Názov",
        "organisation": "Organizácia",
        "position": "Pozícia",
        "race": "Rasa",
        "tag": "Kategória",
        "tags": "Kategórie",
        "timeline": "Časová os",
        "tooltip": "Bublina",
        "type": "Typ",
        "visibility": "Viditeľnosť"
      },
      "files": {
        "actions": {
          "drop": "Kliknutím pridať alebo súbor pretiahnuť na toto miesto (Drag & Drop).",
          "manage": "Spravovať súbory objektov"
        },
        "errors": {
          "max": "Max. počet ({max}) súborov v tomto objekte dosiahnutý.",
          "no_files": "Žiadne súbory."
        },
        "files": "Nahraté súbory",
        "hints": {
          "limit": "Do každého objektu môže byť nahratých maximálne {max} súborov.",
          "limitations": "Podporované formáty: jpg, png, gif a pdf. Max. veľkosť súboru: {size}."
        },
        "title": "Súbory objektu {name}"
      },
      "filter": "Filter",
      "filters": {
        "all": "Filter zobrazenia všetkých podobjektov",
        "clear": "Resetovať filter",
        "direct": "Filter zobrazenia iba priamych podobjektov",
        "filtered": "Zobraziť {count} z {total} {entity}.",
        "hide": "Skryť",
        "show": "Zobraziť",
        "sorting": {
          "asc": "{field} vzostupne",
          "desc": "{field} zostupne",
          "helper": "Nastav poradie zoradenia výsledkov."
        },
        "title": "Filter"
      },
      "forms": {
        "actions": {
          "calendar": "Doplniť dátum"
        },
        "copy_options": "Kopírovať nastavenia"
      },
      "hidden": "Skrytý",
      "hints": {
        "attribute_template": "Aplikovať šablónu atribútov automaticky pri vytvorení objektu.",
        "calendar_date": "Dátum umožňuje filtrovať zoznamy a zadať udalosť do vybraného kalendára.",
        "header_image": "Tento obrázok je umiestnený nad objekt. Odporúčame používať obrázok na šírku.",
        "image_limitations": "Podporované formáty: jpg, png a gif. Max. veľkosť súboru: {size}.",
        "image_patreon": "Zvýš svoj limit tým, že nás podporíš na Patreone.",
        "is_private": "Nastaviť ako súkromný.",
        "is_star": "Pripnuté objekty sa zobrazia v menu objektu.",
        "map_limitations": "Podporované formáty: jpg, png, gif a svg. Max. veľkosť súboru: {size}.",
        "tooltip": "Nahradiť automaticky generovaný obsah bubliny týmto obsahom.",
        "visibility": "Ak je viditeľnosť nastavená na \"Admin\", vidia to len členovia a členky roly Admin. Ak je nastavená na \"Vlastník\", môže to vidieť len ty."
      },
      "history": {
        "created": "Vytvorené: <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "created_date": "Vytvorené: <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "unknown": "Neznámy",
        "updated": "Posledná úprava: <strong>{name}</strong> <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "updated_date": "Posledná úprava: <span data-toggle=\"tooltip\" title=\"{realdate}\">{date}</span>",
        "view": "Zobraziť protokol objektu"
      },
      "image": {
        "error": "Požadovaný obrázok nebolo možné stiahnuť. Zdá sa, že daná webová stránka nepovoľuje sťahovanie obrázkov (typické správanie Squarescape a DeviantArt) alebo že link už nie je platný."
      },
      "is_private": "Tento objekt je súkromný a neviditeľný pre divákov.",
      "linking_help": "Ako môžem prepojiť ďalšie objekty?",
      "manage": "Spravovať",
      "move": {
        "description": "Premiestniť objekt na iné miesto",
        "errors": {
          "permission": "Nemáš oprávnenie vytvoriť objekty tohto typu v tejto kampani.",
          "same_campaign": "Musíš vybrať inú kampaň, do ktorej chceš daný objekt premiestniť.",
          "unknown_campaign": "Neznáma kampaň"
        },
        "fields": {
          "campaign": "Nová kampaň",
          "copy": "Vytvoriť kópiu",
          "target": "Nový typ"
        },
        "hints": {
          "campaign": "Môžeš tiež skúsiť premiestniť tento objekt do inej kampane.",
          "copy": "Vyber si túto možnosť, ak chceš vytvoriť kópiu v novej kampani.",
          "target": "Prosím, uvedom si, že niektoré dáta môžu zmiznúť, ak sa objekt premiestni do iného typu."
        },
        "success": "Objekt {name} premiestnený",
        "success_copy": "Objekt {name} skopírovaný",
        "title": "Premiestniť {name} na iné miesto"
      },
      "new_entity": {
        "error": "Prosím, prekontroluj tvoje zadanie.",
        "fields": {
          "name": "Názov"
        },
        "title": "Nový objekt"
      },
      "or_cancel": "alebo <a href=\"{url}\">Zrušiť</a>",
      "panels": {
        "appearance": "Výzor",
        "attribute_template": "Šablóna atribútov",
        "calendar_date": "Dátum",
        "entry": "Záznam",
        "general_information": "Všeobecné informácie",
        "move": "Premiestniť",
        "system": "Systém"
      },
      "permissions": {
        "action": "Akcie",
        "actions": {
          "bulk": {
            "add": "Povoliť",
            "deny": "Zakázať",
            "ignore": "Ignorovať",
            "remove": "Odstrániť"
          },
          "bulk_entity": {
            "allow": "Povoliť",
            "deny": "Zakázať",
            "inherit": "Zdediť"
          },
          "delete": "Zmazať",
          "edit": "Upraviť",
          "entity_note": "Poznámky objektu",
          "read": "Čítať",
          "toggle": "Prepnúť"
        },
        "allowed": "Povolené",
        "fields": {
          "member": "Člen",
          "role": "Rola"
        },
        "helper": "Použi toto rozhranie na nastavenie oprávnení pre užívateľov a role pre daný objekt.",
        "helpers": {
          "entity_note": "Povoliť užívateľom vytvárať poznámky k tomuto objektu. Aj bez tohto oprávnenia budú ešte stále vidieť poznámky s nastavením viditeľnosti pre všetkých.",
          "setup": "Pomocou tohto rozhrania môžeš presne nastaviť ako role a užívatelia pracujú s týmto objektom. {allow} dovolí užívateľovi alebo role urobiť danú akciu. {deny} im túto akciu zakáže. {inherit} preberie nastavenie z roly užívateľa alebo z oprávnení hlavnej roly. Užívateľ s nastavením {allow} môže danú akciu vykonať, aj keď má jeho rola nastavenie {deny}."
        },
        "inherited": "Táto rola má už pridelené oprávnenia na tento typ objektov.",
        "inherited_by": "Tomuto užívateľovi je pridelená rola {role}, ktorá mu poskytuje oprávnenia na tento typ objektov.",
        "success": "Oprávnenia uložené.",
        "title": "Oprávnenia",
        "too_many_members": "Táto kampaň má príliš veľa členov (> 10), aby boli zobrazení v tomto rozhraní. Prosím, použi tlačidlo Oprávnení na danom objekte, aby sa zobrazili detaily nastavenia oprávnení."
      },
      "placeholders": {
        "ability": "Vybrať schopnosť",
        "calendar": "Vybrať kalendár",
        "character": "Vybrať postavu",
        "entity": "Objekt",
        "event": "Vybrať udalosť",
        "family": "Vybrať rod",
        "image_url": "Obrázok je možné pridať aj nahratím cez URL.",
        "item": "Vyber predmet",
        "location": "Vyber miesto",
        "map": "Vyber mapu",
        "organisation": "Vyber organizáciu",
        "race": "Vyber rasu",
        "tag": "Vyber kategóriu"
      },
      "relations": {
        "actions": {
          "add": "Pridať vzťah"
        },
        "fields": {
          "location": "Miesto",
          "name": "Názov",
          "relation": "Vzťah"
        },
        "hint": "Vzťahy je možné vytvoriť medzi objektami a zobraziť tak ich prepojenie."
      },
      "remove": "Zmazať",
      "rename": "Premenovať",
      "save": "Uložiť",
      "save_and_close": "Uložiť a zavrieť",
      "save_and_copy": "Uložiť a kopírovať",
      "save_and_new": "Uložiť a nový",
      "save_and_update": "Uložiť a upraviť",
      "save_and_view": "Uložiť a zobraziť",
      "search": "Hľadať",
      "select": "Vybrať",
      "tabs": {
        "abilities": "Schopnosti",
        "attributes": "Atribúty",
        "boost": "Boost",
        "calendars": "Kalendáre",
        "default": "Štandardný",
        "events": "Udalosti",
        "inventory": "Inventár",
        "map-points": "Značky na mape",
        "mentions": "Referencie",
        "menu": "Menu",
        "notes": "Poznámky",
        "permissions": "Oprávnenia",
        "relations": "Vzťahy",
        "reminders": "Pripomenutia",
        "timelines": "Časové osi",
        "tooltip": "Bublina"
      },
      "update": "Upraviť",
      "users": {
        "unknown": "Neznámy"
      },
      "view": "Zobraziť",
      "visibilities": {
        "admin": "Admin",
        "admin-self": "Vlastník a Admin",
        "all": "Všetci",
        "self": "Vlastník"
      }
    },
    "entities": [],
    "front": [],
    "maps": [],
    "randomisers": []
  },
  "tr": [],
  "zh_CN": []
});

/***/ }),

/***/ 10:
/*!*********************************************!*\
  !*** multi ./resources/assets/js/abilities ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\Payne\Php\kanka\resources\assets\js\abilities */"./resources/assets/js/abilities.js");


/***/ })

/******/ });