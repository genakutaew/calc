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
          v-on:click="getCalcs"
          v-text="$ml.get('error_reload')"
        ></button>
      </div>

      <div v-else>
        <div class="d-flex mb-4">
          <div class="col-auto mr-auto"></div>

          <router-link
            to="/create"
            type="button"
            class="btn btn-success mr-2"
            v-if="user.role == 1"
            v-text="$ml.get('add')"
          ></router-link>

          <form class="form-inline my-0" onsubmit="return false;">
            <input
              class="form-control mr-2"
              type="search"
              v-bind:placeholder="$ml.get('search')"
              aria-label="Search"
              v-model="filter"
            />
            <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button> -->
          </form>
        </div>

        <div class="d-flex flex-wrap justify-content-between">
          <div class="homeItem" v-for="calc in calcs" v-bind:key="calc.id">
            <div class="card m-2">
              <router-link :to="{ name: 'calc', params: { calcId: calc.id }}">
                <h5 class="card-header">{{ calc.name }}</h5>
              </router-link>

              <div class="card-body">
                <p class="card-text">{{ calc.description }}</p>
                <div class="d-flex justify-content-between">
                  <router-link :to="{ name: 'edit', params: { calcId: calc.id }}">
                    <button
                      type="button"
                      class="btn btn-light"
                      v-if="user.role == 1"
                      v-text="$ml.get('edit')"
                    ></button>
                  </router-link>
                  <button
                    type="button"
                    class="btn btn-danger"
                    v-if="user.role == 1"
                    data-toggle="modal"
                    data-target="#removeModal"
                    v-on:click="removeSelect(calc.id)"
                    v-text="$ml.get('remove')"
                  ></button>
                </div>
              </div>
            </div>
          </div>
          <div class="homeItem empty"></div>
          <div class="homeItem empty"></div>
          <div class="homeItem empty"></div>
        </div>

        <div class="alert alert-primary pb-0" v-if="calcs != null && calcs.length == 0">
          <p v-text="$ml.get('none')"></p>
        </div>

        <!-- <nav aria-label="Page navigation example" class="m-2">
        <ul class="pagination justify-content-center">
          <li class="page-item">
            <a class="page-link" href="#">Previous</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">1</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">2</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">3</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">Next</a>
          </li>
        </ul>
        </nav>-->
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
              <p v-text="$ml.get('error_remove')"></p>
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
      loading_error: false,
      remove_error: false,
      user: [],
      calcs_buffer: [],
      selected: [],
      filter: ""
    };
  },
  computed: {
    calcs() {
      return this.calcs_buffer.filter(
        item => item.name.indexOf(this.filter) != -1
      );
    }
  },
  mounted() {
    this.user = this.$auth.user();
    this.getCalcs();
  },
  methods: {
    getCalcs(load = true) {
      if (load) this.loading = true;
      this.load_error = false;
      this.$http({
        url: `/getcalcs`,
        method: "GET"
      }).then(
        res => {
          this.calcs_buffer = res.data.data;
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
      this.calcs.forEach(item => {
        if (item.id == id) this.selected = item;
      });
    },
    remove() {
      if (this.selected != []) this.loading_error = true;
      this.remove_error = false;
      this.$http({
        url: `/removecalc/` + this.selected.id,
        method: "GET"
      }).then(
        res => {
          $("#removeModal").modal("hide");
          this.loading_error = false;
          this.getCalcs(false);
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
.homeItem {
  width: 100%;
}
.homeItem.empty {
  height: 0;
  padding-top: 0;
  padding-bottom: 0;
  margin-top: 0;
}
@media (min-width: 768px) {
  .homeItem {
    width: 50%;
  }
}

@media (min-width: 992px) {
  .homeItem {
    width: 33%;
  }
}

@media (min-width: 1200px) {
  .homeItem {
    width: 25%;
  }
}
</style>
