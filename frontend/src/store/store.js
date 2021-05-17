export default {
  state: {
    categories: [],
  },

  getters: {
    getCategory(state) {
      return state.categories
    },
  },

  actions: {
    category(context) {
      axios.get('/all-category')
          .then((response) => {
            //console.log(response.data)
            context.commit("allCategory", response.data)
          })
    },

    getProducstbyId(context, payload) {
      axios.get('/product-details/' + payload)
          .then((response) => {
            //console.log(response.data)
            context.commit("getSingleProduct", response.data)
          })
    },

  },

  mutations: {
    allCategory(state, data) {
      return state.categories = data
    },
  }
}