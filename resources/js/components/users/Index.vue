<template>
  <div class="card">
    <div class="card-header">Users</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <user v-for="user in users" :user="user" :key="user.id"></user>
          </tbody>
        </table>
      </div>
      <pagination v-if="meta.current_page" :meta="meta" v-on:pagination:switched="switchPage"></pagination>
    </div>
  </div>
</template>
<script>
import User from "./partials/User.vue";
import Pagination from "../pagination/Pagination.vue";
export default {
  components: {
    User,
    Pagination
  },
  data() {
    return {
      users: [],
      meta: {}
    };
  },
  watch: {
    "$route.query"(query) {
      this.getUsers(query.page);
    }
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers(page = this.$route.query.page) {
      axios
        .get("/api/users", {
          params: {
            page
          }
        })
        .then(response => {
          this.users = response.data.data;
          this.meta = response.data.meta;
        });
    },
    switchPage(page) {
      this.$router.replace({
        name: "users.index",
        query: {
          page
        }
      });
    }
  }
};
</script>
