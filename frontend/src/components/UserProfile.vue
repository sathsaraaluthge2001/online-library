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
                <input type="text" id="username" class="form-control" v-model="user.username">
              </div>
              <div class="form-group mt-3">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" v-model="user.email">
              </div>
              <div class="form-group mt-3">
                <label for="contactnumber">Mobile Number</label>
                <input type="text" id="contactnumber" class="form-control" v-model="user.contactnumber">
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
                <th scope="col">Price</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="book in books" :key="book.id">
                <th scope="row">{{ book.id }}</th>
                <td>{{ book.title }}</td>
                <td>${{ book.price.toFixed(2) }}</td>
                <td>
                  <button class="btn btn-success" @click="borrowBook(book.id)">Borrow</button>
                </td>
              </tr>
              <tr v-if="!books.length">
                <td colspan="4" class="text-center">No books available</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import NavBar from '../components/NavBar.vue';
  
  export default {
    name: 'UserProfile',
    components: {
      NavBar
    },
    data() {
      return {
        user: JSON.parse(localStorage.getItem('user')) || {},
        books: [] // Placeholder for books data
      };
    },
    methods: {
      logout() {
        localStorage.removeItem('user'); // Clear user data from localStorage
        this.$router.push('/'); // Redirect to login page
      },
      updateProfile() {
        // Add logic to update the user profile
        alert('Profile updated!');
      },
      borrowBook(bookId) {
        // Add logic to handle borrowing a book
        alert(`Book with ID ${bookId} borrowed!`);
      }
    },
    mounted() {
      // Fetch books data here (simulate with empty array for now)
      this.books = [
        // Example book data
        { id: '1', title: 'Book One', price: 29.99 },
        { id: '2', title: 'Book Two', price: 39.99 }
      ];
    }
  };
  </script>
  
  <style scoped>
  .shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
  }
  </style>
  