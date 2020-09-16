module.exports = {
  methods: {
    auth: (field) => {
      if (window.auth[field] === undefined) {
        return '';
      }
      return window.auth[field];
    }
  }
};
