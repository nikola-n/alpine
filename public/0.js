(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./resources/js/components/taskApp.js":
/*!********************************************!*\
  !*** ./resources/js/components/taskApp.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.taskApp = function () {
  return {
    tasks: [],
    newTask: '',
    submit: function submit() {
      this.tasks.push({
        body: this.newTask,
        completed: false
      });
      this.newTask = '';
    }
  };
};

/***/ })

}]);