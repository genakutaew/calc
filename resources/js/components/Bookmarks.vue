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
          v-text="$ml.get('error_reload')"
        ></button>
      </div>
      <div v-else class="card">
        <div class="card-header">
          <label class="mt-2">Закладки</label>

          <div class="float-right d-flex">
            <input
              class="form-control"
              type="search"
              v-bind:placeholder="$ml.get('search')"
              v-model="filter"
            />
          </div>
        </div>
        <div class="card-body p-0">
          <div class="alert alert-primary mt-3 ml-3 mr-3" v-if="bookmarks.length == 0">Пусто</div>
          <table v-else class="table">
            <tr v-for="bookmark in bookmarks" v-bind:key="bookmark.id">
              <td class="pl-3 w-100">
                <router-link to="/">{{bookmark.name}}</router-link>
              </td>
              <td class="pr-3">
                <button
                  class="btn btn-secondary dropdown-toggle"
                  type="button"
                  id="dropdownMenu"
                  data-toggle="dropdown"
                >Меню</button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                  <a class="dropdown-item" href="#">Переименовать</a>
                  <a class="dropdown-item" href="#">Сделать копию</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Скачать word</a>
                  <a class="dropdown-item" href="#">Скачать pdf</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Удалить</a>
                </div>
              </td>
            </tr>
          </table>
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
      loading: false,
      load_error: false,
      filter: "",
      bookmark_buffer: [
        { id: 1, name: "Сохраненный калькулятор 1" },
        { id: 2, name: "Сохраненный калькулятор 2" },
        { id: 3, name: "Сохраненный калькулятор 3" }
      ]
    };
  },
  computed: {
    bookmarks() {
      return this.bookmark_buffer.filter(
        item => item.name.indexOf(this.filter) != -1
      );
    }
  },
  mounted() {},
  methods: {}
};
</script>
<style scoped>
.table td {
  padding: 5px;
  vertical-align: middle;
}
</style>
