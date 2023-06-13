<template>
    <div class="login-view">
      <h2>Login</h2>
      <form class="login-form">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="email" placeholder="Enter your email">
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" placeholder="Enter your password">
        </div>
        <button @click="submitForm">Login</button>
      </form>
    </div>
  </template>

<script>
   import { useAuthStore } from '../stores/auth';
   import { mapActions, mapState } from 'pinia'

export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  computed: {
    ...mapState(useAuthStore, { 
        currentUser: 'auth'
    })
  },
  methods: {
    ...mapActions(useAuthStore, ['login']),
    async submitForm() {
        await this.login(this.email, this.password);
        console.log(this.currentUser, 'Current USer');
    },
  },
};
</script>

<style scoped lang="scss">
.login-view {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 20px;
}

.login-form {
  width: 300px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

input {
  width: 100%;
  padding: 10px;
}

button {
  background-color: #1890ff;
  color: #fff;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
}

button:hover {
  background-color: #40a9ff;
}
</style>







