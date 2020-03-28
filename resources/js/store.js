import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
const store = new Vuex.Store({
  state: {
    counter:100,
    authUser: {
      contact: localStorage.getItem('contact')|| null,
      email : localStorage.getItem('email')|| null,
      id: localStorage.getItem('id')|| null,
      name: localStorage.getItem('name')|| null,
      userType: localStorage.getItem('userType')|| null,
      status: localStorage.getItem('status')|| null,
      token:  localStorage.getItem('token') || null,
    },
    load:false,
    token:  localStorage.getItem('token') || null,
    notifications:[],
  },

  /*All getters*/
  getters: {
    getCounter(state){
      return state.counter
    },
    isLoggedIn(state){
      if(_.isEmpty(state.authUser)){
        return false
      }else{
        return true
      }
      
    },
    loggedInUser(state){
      return state.authUser
    },
    load(state){
      return state.load
    },
    noti(state){
      return state.notifications
    },
  },

  /*all mutations*/
  mutations: {
    update (state,data) {
       state.counter++
    },
    user(state,user){
      state.authUser=user
      localStorage.setItem('token',user.token);
      localStorage.setItem('contact',user.user);
      localStorage.setItem('email',user.email);
      localStorage.setItem('id',user.id);
      localStorage.setItem('name',user.name);
      localStorage.setItem('userType',user.userType);
      localStorage.setItem('status',user.status);
    },
   
  },

 /*all actions*/
  actions: {
    update ({commit},data) {
     commit('update',data)
    },
    user({commit},user){
      commit('user',user)
    },
   
   
  }
})

export default store