<template>
    <div class="PhotoView">
      <img :src="image.src" :alt="image.alt" class="image">
      <div class="image-details">
        <h2 class="description">{{ image.description }}</h2>
        <p class="uploaded-by">Uploaded by: {{ image.uploadedBy }}</p>
        <div class="comments">
          <h3>Comments</h3>
          <ul>
            <li v-for="comment in image.comments" :key="comment.id">
              {{ comment.text }}
            </li>
          </ul>
        </div>
        <form class="comment-form">
          <textarea v-model="newComment" rows="4" placeholder="Add a comment"></textarea>
          <button @click="addComment">Post Comment</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        imageId: null,
        image: {
          id: 1,
          src: "/path/to/image.jpg",
          alt: "Image",
          description: "Example image",
          uploadedBy: "John Doe",
          comments: [
            {
              id: 1,
              text: "Awesome image!",
            },
            // Add more comment objects here
          ],
        },
        newComment: "",
      };
    },
    mounted() {
        this.imageId = this.$route.params.id;
    },
    methods: {
      addComment() {
        if (this.newComment.trim() !== "") {
          const comment = {
            id: Date.now(),
            text: this.newComment.trim(),
          };
          this.image.comments.push(comment);
          this.newComment = "";
        }
      },
    },
  };
  </script>
  
  <style scoped lang="scss">
  .PhotoView {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 20px;
  }
  
  .image {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
  }
  
  .image-details {
    text-align: center;
  }
  
  .description {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
  }
  
  .uploaded-by {
    margin-bottom: 20px;
  }
  
  .comments {
    margin-bottom: 20px;
  }
  
  .comment-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
  }
  
  .comment-form button {
    background-color: #1890ff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
  }
  
  .comment-form button:hover {
    background-color: #40a9ff;
  }
  
  ul {
    list-style-type: none;
    padding: 0;
  }
  
  li {
    margin-bottom: 5px;
  }
  </style>
  