<template>
  <div id="main">
    <Header></Header>
    <div class="container">
      <div class="alert alert-danger pb-0" v-if="errors">
        <p v-if="errors.name">Поле имя не заполнено</p>
        <p v-if="errors.description">Поле описание не заполнено</p>
        <p v-else>Ошибка сохранения</p>
      </div>

      <div class="card">
        <div class="card-header">Создание калькулятора</div>
        <div class="card-body">
          <form autocomplete="off" @submit.prevent="save" method="post">
            <div class="row">
              <div class="col-sm-4">
                <input
                  type="text"
                  class="form-control mb-3 mb-sm-0"
                  placeholder="Название"
                  v-model="name"
                  required
                />
              </div>
              <div class="col-sm-4">
                <input
                  type="text"
                  class="form-control mb-3 mb-sm-0"
                  placeholder="Описание"
                  v-model="description"
                  required
                />
              </div>
              <div class="col-sm-2">
                <button type="submit" class="btn btn-success btn-block mb-3 mb-sm-0">Сохранить</button>
              </div>
              <div class="col-sm-2">
                <router-link to="/" type="button" class="btn btn-danger btn-block">Отменить</router-link>
              </div>
            </div>
          </form>
        </div>
        <div class="card-body pt-0 row">
          <div class="col-sm-4">
            <div class="card mb-3 mb-sm-0">
              <div class="card-header">Категории</div>

              <draggable
                tag="ul"
                :list="data"
                class="list-group"
                handle=".handle"
                draggable=".d-flex"
              >
                <li
                  class="list-group-item d-flex align-items-center border-left-0 border-right-0"
                  v-for="item in data"
                  v-bind:key="item.id"
                  v-bind:class="{ selected : item.selected }"
                >
                  <div class="handle mr-2" v-on:click="select(item)"></div>
                  <input
                    type="text"
                    class="form-control mr-2"
                    placeholder="Название"
                    v-model="item.name"
                    v-on:click="select(item)"
                  />
                  <button
                    class="btn btn-secondary ml-auto"
                    v-on:click="removeCategory(item)"
                    v-if="data.length != 1"
                  >X</button>
                </li>
                <li
                  class="btn-add list-group-item text-center p-0 border-0"
                  v-on:click="addCategory()"
                >+</li>
              </draggable>
            </div>
          </div>

          <div class="col-sm-8">
            <div class="card">
              <div class="card-header">
                <div class="d-flex row">
                  <div class="col-1 pl-0"></div>
                  <div class="col-6 pl-0">
                    <label class="mb-0">Название</label>
                  </div>
                  <div class="col-1 pl-0">
                    <label class="mb-0">Front</label>
                  </div>
                  <div class="col-1 pl-0">
                    <label class="mb-0">Back</label>
                  </div>
                  <div class="col-1 pl-0">
                    <label class="mb-0">Designer</label>
                  </div>
                  <div class="col-1 pl-0">
                    <label class="mb-0">Tester</label>
                  </div>
                  <div class="col-1 pl-0"></div>
                </div>
              </div>
              <draggable
                tag="ul"
                :list="data[selected].data"
                class="list-group"
                handle=".handle"
                draggable=".d-flex"
              >
                <li
                  class="list-group-item d-flex align-items-center border-left-0 border-right-0"
                  v-for="item in data[selected].data"
                  v-bind:key="item.id"
                >
                  <div class="row">
                    <div class="col-1 pt-1">
                      <div class="handle"></div>
                    </div>
                    <div class="col-6 pl-1 pr-1">
                      <input
                        type="text"
                        class="form-control p-1"
                        placeholder="Название"
                        v-model="item.name"
                      />
                    </div>
                    <div class="col-1 pl-1 pr-1">
                      <input
                        type="number"
                        class="form-control p-1"
                        placeholder="0"
                        v-model="item.front"
                      />
                    </div>
                    <div class="col-1 pl-1 pr-1">
                      <input
                        type="number"
                        class="form-control p-1"
                        placeholder="0"
                        v-model="item.back"
                      />
                    </div>
                    <div class="col-1 pl-1 pr-1">
                      <input
                        type="number"
                        class="form-control p-1"
                        placeholder="0"
                        v-model="item.designer"
                      />
                    </div>
                    <div class="col-1 pl-1 pr-1">
                      <input
                        type="number"
                        class="form-control p-1"
                        placeholder="0"
                        v-model="item.tester"
                      />
                    </div>
                    <div class="col-1 pl-1 pr-1 d-flex">
                      <button
                        class="btn btn-secondary w-100"
                        v-on:click="removeItem(item)"
                        v-if="data[selected].data.length != 1"
                      >X</button>
                    </div>
                  </div>
                </li>
                <li
                  class="btn-add list-group-item text-center p-0 border-0"
                  v-on:click="addItem()"
                >+</li>
              </draggable>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Header from "../includes/Header.vue";
import draggable from "vuedraggable";
export default {
  components: {
    Header,
    draggable
  },
  data() {
    return {
      errors: false,
      name: '',
      description: '',
      data: [
        {
          selected: true,
          name: '',
          data: [
            {
              name: '',
              back: '',
              front: '',
              design: '',
              tester: ''
            }
          ]
        }
      ]
    };
  },
  mounted() {
    //this.items = data[0].data;
  },
  methods: {
    select(element) {
      this.data.forEach(element => {
        element.selected = false;
      });
      this.data[this.data.indexOf(element)].selected = true;
    },
    addCategory() {
      this.data.push({
        selected: false,
        name: '',
        data: [
          {
            name: '',
            back: '',
            front: '',
            design: '',
            tester: ''
          }
        ]
      });
    },
    addItem() {
      this.data[this.selected].data.push({
        name: '',
        back: '',
        front: '',
        design: '',
        tester: ''
      });
    },
    removeCategory(item) {
      if (this.data.length != 1) {
        let selected = item.selected;
        this.data.splice(this.data.indexOf(item), 1);
        if (selected) this.select(this.data[0]);
      }
    },
    removeItem(item) {
      if (this.data[this.selected].data.length != 1) {
        this.data[this.selected].data.splice(
          this.data[this.selected].data.indexOf(item),
          1
        );
      }
    },
    save() {
      this.select(this.data[0]);
      this.errors = false;
      this.$http({
        url: `savecalc`,
        method: "POST",
        data: {
          name: this.name,
          description: this.description,
          data: this.data
        }
      }).then(
        res => {
          if (res.data.status == "success") {
            this.$router.push("/");
          } else {
            this.errors = res.data.errors;
          }
        },
        () => {
          this.errors = true;
        }
      );
    }
  },

  computed: {
    selected() {
      return this.data.findIndex(item => item.selected);
    }
  }
};
</script>
<style scoped>
.list-group .form-control {
  border: none;
}
.btn-add {
  cursor: pointer;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
    border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.btn-add:hover {
  background: lightgray;
}
.btn-add:active {
  background: gray;
}

.handle {
  cursor: pointer;
  width: 24px;
  height: 24px;
  background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAKUlEQVRIiWNgGOqAkYGB4T8tLWCipeGjYBQMETCa0UbBKKADGM1oAw8A4D4DB6WZLegAAAAASUVORK5CYII=");
  background-repeat: no-repeat;
  background-position: center;
}

.selected {
  background: lightgray;
}
.selected input {
  background: lightgray;
}
.selected input:focus {
  box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.5);
}
.list-group-item:first-child {
  border-top-left-radius: 0px;
  border-top-right-radius: 0px;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield;
}
</style>
