<template>
    <a-layout-header>
      <a-menu mode="horizontal" theme="dark">
        <a-menu-item key="home">
          <router-link to="/">Home</router-link>
        </a-menu-item>
        <a-menu-item key="photos">
          <router-link to="/photos">Photos</router-link>
        </a-menu-item>
        <a-menu-item key="contact">
          <router-link to="/login">Login</router-link>
        </a-menu-item>
      </a-menu>
    </a-layout-header>
  </template>
  
  <script>
    import { defineComponent } from 'vue';
    import { Layout, Menu } from 'ant-design-vue';
    import { RouterLink } from 'vue-router'
    export default defineComponent({
  components: {
    'a-layout-header': Layout.Header,
    'a-menu': Menu,
    'a-menu-item': Menu.Item,
    RouterLink
  },
});
  </script>
  
  <style scoped lang="scss">
  a-menu-item a {
    color: #fff;
  }
  
  a-menu-item-active a {
    color: #1890ff;
  }
  </style>
  