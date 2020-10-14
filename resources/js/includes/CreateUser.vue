<template>
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
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
              <p v-if="errors.name">Введите имя</p>
              <p v-if="errors.email">Email занят</p>
              <p v-if="errors.password">Пароли не совпадают</p>
            </div>

            <div class="form-group">
              <label for="name">Имя</label>
              <input type="text" id="name" class="form-control" placeholder v-model="name" required />
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
              <input type="password" id="password" class="form-control" v-model="password" required />
            </div>
            <div class="form-group">
              <label for="password_confirmation">Подтверждение пароля</label>
              <input
                type="password"
                id="password_confirmation"
                class="form-control"
                v-model="password_confirmation"
                required
              />
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
</template>
<script>
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",

      errors: false
    };
  },
  methods: {
    register() {
      this.$auth.register({
        data: {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        },
        success: function() {},
        error: function(res) {
          this.errors = res.response.data.errors || {};
        }
      });
    }
  }
};
</script>
