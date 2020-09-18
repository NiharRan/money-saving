module.exports = {
  methods: {
    auth: (field) => {
      if (field === 'is_admin') {
        return  window.auth.role['name'] === 'Admin';
      }
      if (window.auth[field] === undefined) {
        return '';
      }
      return window.auth[field];
    }
  }
};
