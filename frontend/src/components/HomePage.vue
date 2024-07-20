<template>
  <div class="container">
    <div class="input-group mb-3 down size">
      <div class="input-group-prepend ">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
            </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" @click="setSearchType('title')">Title</a>
          <a class="dropdown-item" @click="setSearchType('description')">Description</a>
          <a class="dropdown-item" @click="setSearchType('type')">Type</a>
          <a class="dropdown-item" @click="setSearchType('query')">Query</a>
        </div>
      </div>
      <input type="text" v-model="searchQuery" class="form-control" aria-label="Text input with dropdown button">
      <button class="btn btn-outline-secondary" @click="performSearch">Search</button>
    </div>
    <div v-if="errorMessage" class="alert alert-danger">
      {{ errorMessage }}
    </div>
    <table class="table table-bordered" v-if="!errorMessage">
      <thead>
        <tr>
          <th scope="col">Book ID</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Type</th>
          <th scope="col">Price</th>
          <th scope="col">Take It</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="books.length === 0">
          <td colspan="6" class="text-center">No books found.</td>
        </tr>
        <tr v-else v-for="book in books" :key="book.bookid">
          <th scope="row">{{ book.bookid }}</th>
          <td>{{ book.title }}</td>
          <td>{{ book.description }}</td>
          <td>{{ book.type }}</td>
          <td>{{ book.price }}</td>
          <td>
            <button @click="takeBook(book.bookid)" class="btn btn-primary">Take It</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

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
        console.error('Error performing search:', error);
        this.errorMessage = 'Error performing search. Not Founded.';
      }
    },
    setSearchType(type) {
      this.searchType = type;
    },
    async takeBook(bookid) {
      // Handle book taking logic here
    },
  },
};
</script>

<style scoped>
.table {
  width: 1000px;
}
.container {
  justify-content: center;
}
.down {
  margin-top: 200px;
}
.size {
  width: 1000px;
}


</style>
