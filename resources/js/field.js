Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-calculated-field', require('./components/IndexField'))
  Vue.component('detail-nova-calculated-field', require('./components/DetailField'))
  Vue.component('form-nova-calculated-field', require('./components/FormField'))
})
