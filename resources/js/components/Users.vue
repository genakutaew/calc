<template>
  <div id="main">
    <Header></Header>
    <div class="container">
      <div class="alert text-center" v-if="loading">
        <div class="lds-dual-ring"></div>
      </div>
      <div v-else-if="load_error" class="alert alert-danger fade show" role="alert">
        <span v-text="$ml.get('error_network')"></span>
        <button
          style="float: right; margin-top: -7px; margin-right: -15px;"
          class="btn btn-success reload"
          v-on:click="getUsers"
          v-text="$ml.get('error_reload')"
        ></button>
      </div>
      <div v-else class="card">
        <div class="card-header">
          <label class="mt-2" v-text="$ml.get('users')"></label>

          <div class="float-right d-flex">
            <button
              class="btn btn-success mr-2"
              data-toggle="modal"
              data-target="#createModal"
              v-text="$ml.get('add')"
            ></button>
            <input
              class="form-control"
              type="search"
              v-bind:placeholder="$ml.get('search')"
              v-model="filter"
            />
          </div>
        </div>
        <div class="card-body p-0">
          <div class="alert alert-primary mt-3 ml-3 mr-3" v-if="users.length == 0">Пусто</div>
          <table v-else class="table text-center">
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Имя</th>
              <th scope="col">E-mail</th>
              <th class="d-none d-sm-block" scope="col">Дата регистрации</th>
              <th scope="col">Роль</th>
              <th scope="col"></th>
            </tr>
            <tr v-for="user in users" v-bind:key="user.id" style="margin-bottom: 5px;">
              <th scope="row">{{ user.id }}</th>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td class="d-none d-sm-block">{{ user.created_at}}</td>
              <td>{{ user.role == 1 ? 'Admin' : 'User' }}</td>
              <td>
                <button
                  class="btn btn-danger float-right"
                  v-if="user.role!=1"
                  data-toggle="modal"
                  data-target="#removeModal"
                  v-on:click="removeSelect(user.id)"
                >X</button>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="createModal"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Создание пользователя</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form autocomplete="off" @submit.prevent="register" method="post">
            <div class="modal-body">
              <div class="alert alert-danger pb-0" v-if="errors">
                <p v-if="errors.name">Имя должно быть не менее 3 символов</p>
                <p v-if="errors.email">Email занят</p>
                <p v-if="errors.password">Пароль должен быть не менее 3 символов</p>
              </div>

              <div class="form-group">
                <label for="name">Имя</label>
                <input
                  type="text"
                  id="name"
                  class="form-control"
                  placeholder
                  v-model="name"
                  required
                />
              </div>
              <div class="form-group">
                <label for="email">Почтовый ящик</label>
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
                <label for="password">Пароль</label>
                <input type="text" id="password" class="form-control" v-model="password" required />
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Создать</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
              <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
          </form>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="removeModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" v-text="$ml.get('remove')"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" v-text="$ml.with(selected.name).get('remove_name')"></div>
          <div class="alert alert-danger pb-0 mb-0" v-if="remove_error">
            <p>Ошибка удаления</p>
          </div>
          <div class="alert text-center" v-else-if="loading_error">
            <div class="lds-dual-ring"></div>
          </div>

          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-danger"
              v-on:click="remove()"
              v-text="$ml.get('remove')"
            ></button>
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              v-text="$ml.get('cancel')"
            ></button>
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
      loading: true,
      load_error: false,
      user: null,
      users_buffer: null,

      name: "",
      email: "",
      password: "",
      errors: false,

      filter: "",

      remove_error: false,
      loading_error: false,
      selected: {}
    };
  },
  computed: {
    users() {
      return this.users_buffer.filter(
        item =>
          item.name.indexOf(this.filter) != -1 ||
          item.email.indexOf(this.filter) != -1
      );
    }
  },
  mounted() {
    this.user = this.$auth.user();
    this.getUsers();
  },
  methods: {
    register() {
      this.errors = false;
      this.$auth.register({
        data: {
          name: this.name,
          email: this.email,
          password: this.password
        },
        success: function() {
          this.errors = "";
          this.name = "";
          this.password = "";
          $("#createModal").modal("hide");
          this.getUsers();
        },
        error: function(res) {
          this.errors = res.response.data.errors || {};
        }
      });
    },
    getUsers(load = true) {
      if (load) this.loading = true;
      this.load_error = false;
      this.$http({
        url: `/getusers`,
        method: "GET"
      }).then(
        res => {
          this.users_buffer = res.data.data;
          this.loading = false;
        },
        () => {
          this.load_error = true;
          this.loading = false;
        }
      );
    },

    removeSelect(id) {
      this.remove_error = false;
      this.users.forEach(item => {
        if (item.id == id) this.selected = item;
      });
    },
    remove() {
      if (this.selected != []) this.loading_error = true;
      this.remove_error = false;
      this.$http({
        url: `/removeuser/` + this.selected.id,
        method: "GET"
      }).then(
        res => {
          $("#removeModal").modal("hide");
          this.loading_error = false;
          this.getUsers(false);
        },
        () => {
          this.loading_error = false;
          this.remove_error = true;
        }
      );
    }
  }
};
</script>
<style scoped>
.table td {
  padding: 5px;
  vertical-align: middle;
}
</style>
