<template>
  <NavBar/>
  <div class="container rounded bg-white mt-5 mb-5 shadow-sm">
    <div class="row">
      <!-- User Profile Section -->
      <div class="col-md-4 border-right">
        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
          <img class="rounded-circle mb-3" width="150px" 
               :src="user.profileImage || 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'" 
               alt="Profile Image">
          <h4 class="font-weight-bold">{{ user.username }}</h4>
          <p class="text-muted">{{ user.email }}</p>
          <p class="text-muted">{{ user.contactnumber || 'N/A' }}</p>
        </div>
      </div>
      
      <!-- User Details Form -->
      <div class="col-md-8">
        <div class="p-4 py-5">
          <h4 class="text-center mb-4">Profile</h4>
          <form @submit.prevent="updateProfile">
            <div class="form-group">
              <label for="username">User Name</label>
              <input type="text" id="username" class="form-control" v-model="user.username" disabled>
            </div>
            <div class="form-group mt-3">
              <label for="email">Email</label>
              <input type="email" id="email" class="form-control" v-model="user.email" disabled>
            </div>
            <div class="form-group mt-3">
              <label for="contactnumber">Mobile Number</label>
              <input type="text" id="contactnumber" class="form-control" v-model="user.contactnumber" disabled>
            </div>
            <div class="mt-4 text-center">
              <!-- Update profile button could be added here -->
            </div>
          </form>
          <div class="mt-4 text-center">
            <button class="btn btn-danger" @click="logout">Log Out</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Books Table Section -->
    <div class="row mt-4">
      <div class="col-md-12">
        <h5 class="text-center">My Books</h5>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th scope="col">Book ID</th>
              <th scope="col">Title</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="book in books" :key="book.id">
              <th scope="row">{{ book.bookid }}</th>
              <td>{{ book.booktitle }}</td>
              <td><button class="btn btn-success" @click="returnBook(book.bookid)">Return</button></td>
            </tr>
            <tr v-if="!books.length">
              <td colspan="3" class="text-center">No books available</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from '../components/NavBar.vue';
import axios from 'axios';

export default {
  name: 'UserProfile',
  components: {
    NavBar
  },
  data() {
    return {
      user: JSON.parse(localStorage.getItem('user')) || {},
      books: [], // Placeholder for borrowed books data
    };
  },
  methods: {
    async logout() {
      localStorage.removeItem('user'); // Clear user data from localStorage
      this.$router.push('/'); // Redirect to login page
    },
    async returnBook(bookId) {
      try {
        const response = await axios.delete(`http://127.0.0.1:8000/api/borrowings/${bookId}`);
        if (response.status === 200) {
          this.books = this.books.filter(book => book.bookid !== bookId); // Remove the returned book from the array
          alert('Book returned successfully');
        } else {
          alert('Error returning the book. Please try again.');
        }
      } catch (error) {
        console.error('Error returning the book:', error);
        alert('Error returning the book. Please try again.');
      }
    }
  },
  async mounted() {
    try {
      const user = JSON.parse(localStorage.getItem('user'));
      if (user && user.email) {
        // Fetch borrowed books for the logged-in user
        const response = await axios.get(`http://127.0.0.1:8000/api/borrowings/search?useremail=${user.email}`);
        console.log('API Response:', response.data); // Debugging: Check the API response structure
        this.books = response.data; // Adjust this if the response structure is different
      } else {
        alert('User not logged in.');
        this.$router.push('/'); // Redirect to login page
      }
    } catch (error) {
      console.error('borrowed books not yet');
      
    }
  }
};
</script>

<style scoped>
.shadow-sm {
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}
</style>
