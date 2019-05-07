module.exports = {
  register: function (url, data, callbackSuccess, callbackError) {
    fetch(url, {
      cache: false,
      data: data,
      method: 'post'
    }).then(response => {
      callbackSuccess(response);
    }).catch(err => {
      callbackError(err);
    });
  },

  login: function () {

  }
}
