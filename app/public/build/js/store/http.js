(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["js/store/http"],{

/***/ "./resources/assets/js/store/http.js":
/*!*******************************************!*\
  !*** ./resources/assets/js/store/http.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = {
  register: function register(url, data, callbackSuccess, callbackError) {
    fetch(url, {
      cache: false,
      data: data,
      method: 'post'
    }).then(function (response) {
      callbackSuccess(response);
    })["catch"](function (err) {
      callbackError(err);
    });
  },
  login: function login() {}
};

/***/ })

},[["./resources/assets/js/store/http.js","runtime"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3N0b3JlL2h0dHAuanMiXSwibmFtZXMiOlsibW9kdWxlIiwiZXhwb3J0cyIsInJlZ2lzdGVyIiwidXJsIiwiZGF0YSIsImNhbGxiYWNrU3VjY2VzcyIsImNhbGxiYWNrRXJyb3IiLCJmZXRjaCIsImNhY2hlIiwibWV0aG9kIiwidGhlbiIsInJlc3BvbnNlIiwiZXJyIiwibG9naW4iXSwibWFwcGluZ3MiOiI7Ozs7Ozs7OztBQUFBQSxNQUFNLENBQUNDLE9BQVAsR0FBaUI7QUFDZkMsVUFBUSxFQUFFLGtCQUFVQyxHQUFWLEVBQWVDLElBQWYsRUFBcUJDLGVBQXJCLEVBQXNDQyxhQUF0QyxFQUFxRDtBQUM3REMsU0FBSyxDQUFDSixHQUFELEVBQU07QUFDVEssV0FBSyxFQUFFLEtBREU7QUFFVEosVUFBSSxFQUFFQSxJQUZHO0FBR1RLLFlBQU0sRUFBRTtBQUhDLEtBQU4sQ0FBTCxDQUlHQyxJQUpILENBSVEsVUFBQUMsUUFBUSxFQUFJO0FBQ2xCTixxQkFBZSxDQUFDTSxRQUFELENBQWY7QUFDRCxLQU5ELFdBTVMsVUFBQUMsR0FBRyxFQUFJO0FBQ2ROLG1CQUFhLENBQUNNLEdBQUQsQ0FBYjtBQUNELEtBUkQ7QUFTRCxHQVhjO0FBYWZDLE9BQUssRUFBRSxpQkFBWSxDQUVsQjtBQWZjLENBQWpCLEMiLCJmaWxlIjoianMvc3RvcmUvaHR0cC5qcyIsInNvdXJjZXNDb250ZW50IjpbIm1vZHVsZS5leHBvcnRzID0ge1xuICByZWdpc3RlcjogZnVuY3Rpb24gKHVybCwgZGF0YSwgY2FsbGJhY2tTdWNjZXNzLCBjYWxsYmFja0Vycm9yKSB7XG4gICAgZmV0Y2godXJsLCB7XG4gICAgICBjYWNoZTogZmFsc2UsXG4gICAgICBkYXRhOiBkYXRhLFxuICAgICAgbWV0aG9kOiAncG9zdCdcbiAgICB9KS50aGVuKHJlc3BvbnNlID0+IHtcbiAgICAgIGNhbGxiYWNrU3VjY2VzcyhyZXNwb25zZSk7XG4gICAgfSkuY2F0Y2goZXJyID0+IHtcbiAgICAgIGNhbGxiYWNrRXJyb3IoZXJyKTtcbiAgICB9KTtcbiAgfSxcblxuICBsb2dpbjogZnVuY3Rpb24gKCkge1xuXG4gIH1cbn1cbiJdLCJzb3VyY2VSb290IjoiIn0=