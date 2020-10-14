<template>
  <div id="main">
    <Header v-bind:name="this.user.name" />
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="alert text-center" v-if="loading">
            <div class="lds-dual-ring"></div>
          </div>
          <div v-else-if="load_error" class="alert alert-danger fade show" role="alert">
            <span v-text="$ml.get('error_network')"></span>
            <button
              style="float: right; margin-top: -7px; margin-right: -15px;"
              class="btn btn-success reload"
              v-on:click="getUser"
              v-text="$ml.get('error_reload')"
            ></button>
          </div>
          <div v-else class="card">
            <div class="card-header" v-text="$ml.get('profile')"></div>

            <div class="card-body">
              <div class="alert alert-danger pb-0" v-if="errors">
                <p v-if="errors.name" v-text="$ml.get('error_validate_name')"></p>
                <p v-if="errors.email" v-text="$ml.get('error_validate_email')"></p>
                <p v-if="errors.password" v-text="$ml.get('error_validate_password')"></p>
              </div>

              <div class="alert alert-success" v-if="changed" v-text="$ml.get('saved_changes')"></div>

              <form autocomplete="off" @submit.prevent="update" method="post">
                <div class="form-group">
                  <label for="inputName" v-text="$ml.get('name')"></label>
                  <input
                    type="text"
                    class="form-control"
                    id="inputName"
                    aria-describedby="nameHelp"
                    placeholder="Enter name"
                    v-model="user.name"
                  />
                  <small id="nameHelp" class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                  <label for="inputEmail" v-text="$ml.get('email')"></label>
                  <input
                    type="email"
                    class="form-control"
                    id="inputEmail"
                    aria-describedby="emailHelp"
                    placeholder="Enter email"
                    v-model="user.email"
                    required
                  />
                  <small id="emailHelp" class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                  <label for="inputPassword" v-text="$ml.get('password')"></label>
                  <input
                    type="text"
                    class="form-control mb-1"
                    id="inputPassword"
                    v-bind:placeholder="$ml.get('newpassword')"
                    v-model="user.password"
                  />
                </div>

                <button type="submit" class="btn btn-primary" v-text="$ml.get('save')"></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Header from "../includes/Header.vue";
export default {
  components: {
    Header
  },
  data() {
    return {
      loading: null,
      user: [],
      load_error: null,
      changed: false,
      errors: false
    };
  },
  mounted() {
    this.getUser();
  },
  methods: {
    getUser() {
      this.loading = true;
      this.load_error = false;
      this.$http({
        url: `auth/user`,
        method: "GET"
      }).then(
        res => {
          this.user = res.data.data;
          this.loading = false;
        },
        () => {
          this.load_error = true;
          this.loading = false;
        }
      );
    },
    update() {
      this.errors = false;
      this.changed = false;
      this.$http({
        url: "/auth/update",
        method: "POST",
        data: {
          name: this.user.name,
          email: this.user.email,
          password: this.user.password
        }
      }).then(
        res => {
          if (res.data.status != "error") {
            this.user.password = "";
            this.changed = true;
            this.$auth.fetch();
          } else {
            this.errors = res.data.errors;
          }
        },
        () => {
          this.errors = true;
        }
      );
    }
  }
};
</script>
