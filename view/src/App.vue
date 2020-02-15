<template>
  <div id='app'>
    <header>
      <h3>Take Away</h3>
    </header>
    <main>
      <div class='content'>
        <h4>Failed messages in last 24 hours</h4>
      </div>
      <div class='content'>
        <h4>Recent Messages</h4>
        <b-table
          id='lastMessages'
          sticky-header
          striped
          hover
          borderless
          head-variant='light'
          :items="messages"
          :fields="fields"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          :per-page="perPage"
          :current-page="currentPage"
          responsive="sm"
        ></b-table>

        <b-pagination
          pills
          v-model="currentPage"
          size="sm"
          align="center"
          :total-rows="rows"
          :per-page="perPage"
          aria-controls="lastMessages"
          first-text="First"
          prev-text="Prev"
          next-text="Next"
          last-text="Last"
        ></b-pagination>
      </div>
    </main>
  </div>
</template>

<script>
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { BTable, BPagination } from 'bootstrap-vue';

export default {
  name: 'MessageLog',
  data() {
    return {
      sortBy: 'id',
      sortDesc: true,
      currentPage: 1,
      perPage: 5,
      rows: 50,
      fields: [
        { key: 'body', sortable: true },
        { key: 'status', sortable: true },
        { key: 'created_at', sortable: true }
      ],
      messages: [],
      getMessages: 'http://localhost:8080/messages?take=50'
    };
  },

  created() {
    this.getAllMessages();
  },

  methods: {
    getAllMessages() {
      axios
        .get(this.getMessages)
        .then(response => {
          this.messages = response.data.data;
          this.rows = this.messages.length;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },

  components: {
    BTable,
    BPagination
  }
};
</script>

<style lang='scss'>

</style>
