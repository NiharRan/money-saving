module.exports = {
  methods: {
    __(key, replace) {
      let transaction, transactionNotFound = true;
      try {
        transaction = key.split('.').reduce((t, i) => {
          return t[i] || null;
        }, window._translations[window._locale].php);

        if (transaction) {
          transactionNotFound = false;
        }
      }catch (e) {
        transaction = key;
      }

      if (transactionNotFound) {
        transaction = window._translations[window._locale]['json'][key]
          ? window._translations[window._locale]['json'][key]
          : key;
      }

      _.forEach(replace, (value, key) => {
        transaction = transaction.replace(':' + key, value);
      });

      return transaction;
    }
  }
};
