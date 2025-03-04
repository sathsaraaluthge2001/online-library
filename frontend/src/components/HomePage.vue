<template>
  <NavBar/>
  <div class="maindiv">
    <div class="container mt-5">
      <h2 class="text-center mb-4" style="color: white;">Available Books</h2>
      <div class="input-group mb-4">
        <div class="input-group-prepend">
          <button class="btn dropdown-toggle drp " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Search By
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" @click="setSearchType('title')">Title</a>
            <a class="dropdown-item" @click="setSearchType('description')">Description</a>
            <a class="dropdown-item" @click="setSearchType('type')">Type</a>
            <a class="dropdown-item" @click="setSearchType('query')">Query</a>
          </div>
        </div>
        <input type="text" v-model="searchQuery" class="form-control" placeholder="Enter your search query...">
        <div class="input-group-append">
          <button class="btn btn-primary" @click="performSearch">Search</button>
        </div>
      </div>

      <div v-if="errorMessage" class="alert alert-danger">
        {{ errorMessage }}
      </div>

      <div v-if="!errorMessage" class="table-container">
        <table class="table " style="color: whitesmoke;">
          <thead>
            <tr>
              <th scope="col" class="ths">Book ID</th>
              <th scope="col" class="ths">Title</th>
              <th scope="col" class="ths">Description</th>
              <th scope="col" class="ths">Type</th>
              <th scope="col" class="ths">Price</th>
              <th scope="col" class="ths">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="books.length === 0">
              <td colspan="6" class="text-center">No books found.</td>
            </tr>
            <tr class="blur-container" v-else v-for="book in books" :key="book.bookid">
              <th scope="row" class="bg-transparent">{{ book.bookid }}</th>
              <td>{{ book.title }}</td>
              <td>{{ book.description }}</td>
              <td>{{ book.type }}</td>
              <td>${{ book.price.toFixed(2) }}</td>
              <td>
                <button @click="takeBook(book)" class="btn btn-success">Take It</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import NavBar from '../components/NavBar.vue';

export default {
  name: 'HomePage',
  data() {
    return {
      books: [],
      searchQuery: '',
      searchType: 'query', // Default search type
      errorMessage: '', // Error message for displaying errors
    };
  },
  created() {
    this.fetchBooks();
  },
  methods: {
    async fetchBooks() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/book');
        this.books = response.data;
      } catch (error) {
        console.error('Error fetching books:', error);
        this.errorMessage = 'Error fetching books. Please try again later.';
      }
    },
    async performSearch() {
      try {
        let url = '';
        switch (this.searchType) {
          case 'title':
            url = `http://127.0.0.1:8000/api/book/search/title/${encodeURIComponent(this.searchQuery)}`;
            break;
          case 'description':
            url = `http://127.0.0.1:8000/api/book/search/description/${encodeURIComponent(this.searchQuery)}`;
            break;
          case 'type':
            url = `http://127.0.0.1:8000/api/book/search/type/${encodeURIComponent(this.searchQuery)}`;
            break;
          case 'query':
          default:
            url = `http://127.0.0.1:8000/api/book/search/query?query=${encodeURIComponent(this.searchQuery)}`;
            break;
        }
        console.log('Requesting URL:', url);
        const response = await axios.get(url);
        console.log('API Response:', response.data);
        
        // Check if the response data is an array or an object
        if (Array.isArray(response.data)) {
          this.books = response.data;
          this.errorMessage = this.books.length === 0 ? 'No books found.' : '';
        } else {
          // Handle case where single book object is returned
          this.books = [response.data];
          this.errorMessage = this.books.length === 0 ? 'No books found.' : '';
        }
      } catch (error) {
        console.error('Error performing search:');
        this.errorMessage = 'No books found.';
      }
    },
    setSearchType(type) {
      this.searchType = type;
    },
    async takeBook(book) {
      const user = JSON.parse(localStorage.getItem('user'));
      if (!user || !user.email) {
        alert('User not logged in.');
        this.$router.push('/'); // Redirect to login page
        return;
      }

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/borrowing', {
          bookid: book.bookid,
          useremail: user.email,
          booktitle: book.title,
        });

        if (response.status === 201) {
          alert('Book borrowed successfully');
          this.fetchBooks(); // Refresh the book list
        } else {
          alert('Error borrowing the book. Please try again.');
        }
      } catch (error) {
        console.error('Error borrowing the book:', error);
        alert('Error borrowing the book. Please try again.');
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
  background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white background */
  padding: 20px;
  border-radius: 10px;
  background: url('src/images/bookwallpaper.jpg') no-repeat center center fixed;
  background-size: cover;
}

.input-group {
  max-width: 800px;
  margin: 0 auto;
}

.table-container {
  height: 400px;
  overflow-y: auto; /* Enable vertical scrolling */
  
}

.table {
  margin-top: 20px;
  width: 100%;
  border-collapse: collapse; /* Ensure table borders are combined */
}

.table th, .table td {
  text-align: left;
  padding: 10px;
}

.table th {
  background-color: #f8f9fa;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: #f2f2f2;
}

.table-hover tbody tr:hover {
  background-color: #e9ecef;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-success {
  background-color: #4e290f;
  border-color: #fafafa;
}

.alert {
  margin-top: 20px;
}

.blur-container {
            backdrop-filter: blur(3px);
            background-color: rgba(36, 29, 29, 0.247); 
            padding: 20px;
} 

.ths {
  background-color: rgba(0, 0, 0, 0.2); 
  color: #2c2c2c;  }
  .drp {
  background-color: rgba(180, 157, 157, 0.9); 
  color: #fcfcfc;  }
</style>
