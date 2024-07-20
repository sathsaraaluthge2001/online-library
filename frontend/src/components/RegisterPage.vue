<template>
    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('src/images/bookwallpaper.jpg');"></div>
        <div class="contents order-2 order-md-1">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        <h3>Register with <strong>Online-Library</strong></h3>
                        <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>
                        <form @submit.prevent="register">
                            <div class="form-group first">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" v-model="username" required>
                            </div>
                            <div class="form-group first">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" v-model="email" required>
                            </div>
                            <div class="form-group first">
                                <label for="contactNumber">Contact No</label>
                                <input type="text" class="form-control" id="contactNumber" v-model="contactNumber" required>
                            </div>
                            <div class="form-group last mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" v-model="password" required>
                            </div>
                            <div class="d-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-0">
                                    <span class="caption">Remember me</span>
                                    <input type="checkbox" checked="checked"/>
                                    <div class="control__indicator"></div>
                                </label>
                                <span class="ml-auto"><a href="#" class="forgot-pass">Already have account?</a></span>
                            </div>
                            <input type="submit" value="Register" class="btn btn-block btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'RegisterPage',
    data() {
        return {
            username: '',
            email: '',
            contactNumber: '',
            password: '',
        };
    },
    methods: {
        async register() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/register', {
                    username: this.username,
                    email: this.email,
                    contactnumber: this.contactNumber, // Send as a string
                    password: this.password,
                });
                console.log(response.data);
                alert('Register Successfully');
                // Redirect to the LoginPage
                this.$router.push('/'); // Use this.$router

            } catch (error) {
                if (error.response) {
                    // Server responded with a status other than 2xx
                    console.error('Response data:', error.response.data);
                    console.error('Response status:', error.response.status);
                    console.error('Response headers:', error.response.headers);
                    alert('Please Try again');
                    // Display validation errors to the user
                } else if (error.request) {
                    // Request was made but no response was received
                    console.error('Request data:', error.request);
                    alert('Please Try again');
                } else {
                    // Something else happened while setting up the request
                    console.error('Error message:', error.message);
                    alert('Please Try again');
                }
                console.error('Error config:', error.config);
                alert('Please Try again');
            }
        },
    },
};
</script>

<style scoped>
/* Add styles if needed */
</style>
