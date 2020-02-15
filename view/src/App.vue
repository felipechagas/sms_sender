<template>
  <div id='app'>
    <header>
      <h1>Messages Log</h1>
    </header>
    <main>
      <div class='content'>
        <b-table
          :items="messages"
          :fields="fields"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          responsive="sm"
        ></b-table>
      </div>
      <div class='content'></div>
    </main>
  </div>
</template>

<script>
import axios from 'axios';
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
    //this.getAllMessages();
  },

  methods: {
    getAllMessages() {
      axios
        .get(this.getMessages)
        .then(response => {
          this.messages = response.data;
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
body {
  margin: 0;
  padding: 0;
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

h1,
h2 {
  font-weight: normal;
}

</style>
