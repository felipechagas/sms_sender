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
          sticky-header
          striped
          hover
          borderless
          head-variant='light'
          :items="messages"
          :fields="fields"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          responsive="sm"
        ></b-table>
      </div>
    </main>
  </div>
</template>

<script>
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { BTable } from 'bootstrap-vue';

export default {
  data() {
    return {
      sortBy: 'id',
      sortDesc: false,
      fields: [
        { key: 'id', sortable: true },
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
        })
        .catch(error => {
          console.log(error);
        });
    }
  },

  components: {
    BTable
  }
};
</script>

<style lang='scss'>

</style>
