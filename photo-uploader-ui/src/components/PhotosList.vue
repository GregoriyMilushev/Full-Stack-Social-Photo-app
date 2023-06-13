<template>
  <div class="PhotosList">
        <a v-for="image in images" :key="image.id" :href="`/image/${image.id}`" style="margin-right: 0px">
          <img :src="image.src" :alt="image.alt">
        </a>
  </div>
</template>

<script>

export default {
  name: 'PhotosList',

  components: {

  },

  props: {
    loading: {
      type: Boolean,
      default: false
    },
    images: {
      type: Array,
      default: () => []
    },
  },

  computed: {
   
  },

  methods: {
    
  }
};
</script>

<style lang="scss">
.PhotosList {
  display: flex;
  // grid-template-columns: repeat(5, 1fr);
  gap: 20px;

  img {
    cursor: pointer;
    display: flex;
    align-items: center;
    padding: 10px;
    width: 200px;
    height: 200px;
    border: 1px solid transparent;
    border-radius: 6px;
    background-color: #fff;
  }
}
</style>
