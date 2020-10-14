<template>
  <div id="main">
    <Header></Header>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-sm-6">
          <div class="card card-default">
            <div class="card-header" v-text="$ml.get('login')"></div>
            <div class="card-body">
              <div class="alert alert-danger pb-0" v-if="load_error && !success">
                <p v-if="error == 'login_error'" v-text="$ml.get('error_validation')"></p>
                <p v-else v-text="$ml.get('error_network')"></p>
              </div>
              <form autocomplete="off" @submit.prevent="login" method="post">
                <div class="form-group">
                  <label for="email" v-text="$ml.get('email')"></label>
                  <input
                    type="email"
                    id="email"
                    class="form-control"
                    placeholder
                    v-model="email"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="password" v-text="$ml.get('password')"></label>
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    v-model="password"
                    required
                  />
                </div>
                <div class="custom-control custom-checkbox mb-3">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    id="customCheck"
                    v-model="rememberMe"
                  />
                  <label
                    class="custom-control-label"
                    for="customCheck"
                    v-text="$ml.get('rememberme')"
                  ></label>
                </div>
                <button type="submit" class="btn btn-primary" v-text="$ml.get('login')"></button>
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
      email: null,
      rememberMe: false,
      password: null,
      success: false,
      load_error: false,
      error: ""
    };
  },
  mounted() {
    if (this.$auth.check()) this.$router.push("/");
  },
  methods: {
    login() {
      this.load_error = false;
      this.error = "";
      this.$auth.login({
        data: {
          email: this.email,
          password: this.password
        },
        success: function() {
          this.success = true;
          const redirectTo = "home";
          this.$router.push({
            name: redirectTo
          });
        },
        error: function(res) {
          this.load_error = true;
          this.error = res.response.data.error;
        },
        rememberMe: this.rememberMe,
        fetchUser: true
      });
    }
  }
};
</script>
