

<template>
  <div class="HomeView">
    <h1>Home</h1>
    <photos-list :images="images"/>
  </div>
</template>

<script>
import PhotosList from "../components/PhotosList.vue"

export default {

  components: {
    PhotosList
  },

  data() {
    return {
      images: [
        {
          id: 1,
          src: "/public/favicon.ico",
          alt: "Image 1",
        },
        {
          id: 2,
          src: "/public/favicon.ico",
          alt: "Image 2",
        },
        
      ],
    };
  },
};
</script>

<style scoped lang="scss">
.HomeView {
  padding: 20px;
}

</style>
