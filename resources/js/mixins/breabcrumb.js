module.exports = {
  methods: {
    linkText: () => window.text,
    breadcrumbs: () => window.breadcrumbs,
    hasText: () => window.text.length > 0
  }
};
