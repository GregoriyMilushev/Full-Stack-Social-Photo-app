<template>
  <a-layout class="layout">
    <header-navigation />
      <router-view></router-view>
  </a-layout>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
import { Layout } from 'ant-design-vue';
import HeaderNavigation from './components/HeaderNavigation.vue';

export default {
  components: {
    'a-layout': Layout,
    HeaderNavigation,
    RouterView
  },
};
</script>

<style scoped>
.layout {
  min-height: 100vh;
}

/* a-layout-header {
  display: flex;
  align-items: center;
  padding: 0 20px;
  background-color: #3c3c3b;
  color: #fff;
} */

a-layout-content {
  padding: 20px;
}

.router-view-enter-active,
.router-view-leave-active {
  transition: opacity 0.3s ease;
}

.router-view-enter,
.router-view-leave-to {
  opacity: 0;
}
</style>
