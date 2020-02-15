<template>
  <div id='app'>
    <header>
      <h2>Take Away</h2>
    </header>
    <main>
      <div class='content'>
        <h3>Failed messages in last 24 hours</h3>
      </div>
      <div class='content'>
        <h3>Recent Messages</h3>
        <b-table
          sticky-header
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
