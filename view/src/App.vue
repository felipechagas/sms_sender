<template>
  <div id='app'>
    <header>
      <h3>Take Away</h3>
    </header>
    <hr/>
    <main>
      <div class='content'>
        <h5>Failed messages in last 24 hours</h5>
        <b-table
          class='message-table'
          id='failedMessages'
          sticky-header
          striped
          hover
          borderless
          head-variant='light'
          :items="failedMessages"
          :fields="fields"
          :sort-by.sync="failedSmsSortBy"
          :sort-desc.sync="failedSmsSortDesc"
          :per-page="failedSmsPerPage"
          :current-page="failedSmsCurrentPage"
          responsive="sm"
        ></b-table>

        <b-pagination
          pills
          v-model="failedSmsCurrentPage"
          size="sm"
          align="center"
          :total-rows="failedSmsRows"
          :per-page="failedSmsPerPage"
          aria-controls="failedMessages"
          first-text="First"
          prev-text="Prev"
          next-text="Next"
          last-text="Last"
        ></b-pagination>
      </div>
      <hr/>
      <div class='content'>
        <h5>Recent Messages</h5>
        <b-form-group>
          <b-input-group size="sm">
            <b-form-input
              v-model="filter"
              type="search"
              id="filterInput"
              placeholder="Type to Search"
            ></b-form-input>
            <b-input-group-append>
              <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>

        <b-table
          class='message-table'
          id='lastMessages'
          sticky-header
          striped
          hover
          borderless
          head-variant='light'
          :items="messages"
          :fields="fields"
          :filter="filter"
          :filterIncludedFields="filterOn"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          :per-page="perPage"
          :current-page="currentPage"
          responsive="sm"
          @filtered="onFiltered"
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
import { BTable, BPagination, BFormGroup } from 'bootstrap-vue';

export default {
  name: 'MessageLog',
  data() {
    return {
      fields: [
        { key: 'body', sortable: true },
        { key: 'status', sortable: true },
        { key: 'created_at', sortable: true }
      ],

      // Failed messages table
      failedSmsSortBy: 'id',
      failedSmsSortDesc: true,
      failedSmsCurrentPage: 1,
      failedSmsPerPage: 5,
      failedSmsRows: 50,
      failedMessages: [],
      getFailedMessages: 'http://localhost:8080/messages?take=50&status=error&from=1440',

      // All messages table
      sortBy: 'id',
      sortDesc: true,
      currentPage: 1,
      perPage: 5,
      rows: 50,
      messages: [],
      getMessages: 'http://localhost:8080/messages?take=50',
      filter: null,
      filterOn: [],
      filterByFormatted: true,
    };
  },

  created() {
    this.getAllMessages();
    this.getAllFailedMessages();
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
    },
    getAllFailedMessages() {
      axios
        .get(this.getFailedMessages)
        .then(response => {
          this.failedMessages = response.data.data;
          this.failedSmsRows = this.failedMessages.length;
        })
        .catch(error => {
          console.log(error);
        });
    },
    onFiltered(filteredItems) {
      this.totalRows = filteredItems.length
      this.currentPage = 1
    }
  },

  components: {
    BTable,
    BPagination,
    BFormGroup
  }
};
</script>

<style lang='scss'>
  .content {
    padding-top: 20px;
  }

  .content .message-table {
    margin-top: 10px;
  }

  h5 {
    margin-left: 20px;
  }
</style>
