<template>
  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('src/images/bookwallpaper.jpg');"></div>
    <div class="contents order-2 order-md-1">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Login to <strong>Online-Library</strong></h3>
            <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>
            <form @submit.prevent="login">
              <div class="form-group first">
                <label for="username">Email</label>
                <input type="text" class="form-control" placeholder="your-email@gmail.com" v-model="email" id="username">
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Your Password" v-model="password" id="password">
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0">
                  <span class="caption">Remember me</span>
                  <input type="checkbox" v-model="rememberMe"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
              </div>

              <input type="submit" value="Log In" class="btn btn-block btn-primary">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  name: 'LoginPage',
  data() {
    return {
      email: '',
      password: '',
      rememberMe: false,
    };
  },
  methods: {
    async login() {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      email: this.email,
      password: this.password
    });

    // Handle successful login
    alert(response.data.message);
    this.$router.push('/home');
  } catch (error) {
    // Check if the error response is available
    if (error.response) {
      // Handle known error responses
      if (error.response.status === 401) {
        alert('Invalid credentials. Please try again.');
      } else if (error.response.status === 422) {
        alert('Validation error: ' + Object.values(error.response.data.errors).flat().join(' '));
      } else {
        alert('Error: ' + (error.response.data.message || 'An error occurred'));
      }
    } else if (error.request) {
      // Handle network errors
      alert('Network error: Unable to reach the server.');
    } else {
      // Handle other types of errors
      alert('Unexpected error: ' + error.message);
    }
  }
}

  }
};
</script>


