import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
// import PhotosView from '../views/PhotosView.vue'
// import UsersView from '../views/UsersView.vue'
import PhotoView from '../views/PhotoView.vue'
import LoginView from '../views/LoginView.vue'



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    // {
    //   path: '/photos',
    //   name: 'photos',
    //   component: PhotosView
    // },
    {
      path: '/photo/:id',
      name: 'photo',
      component: PhotoView
    },
    // {
    //   path: '/users',
    //   name: 'users',
    //   component: UsersView,
    //   // beforeEnter: (to, from, next) => {
    //   //   const store = useQuoteStore();
    //   //   if (store.stage < 11) {
    //   //     next('/');
    //   //   } else {
    //   //     next();
    //   //   }
    //   // },
    // }
  ]
})

export default router
