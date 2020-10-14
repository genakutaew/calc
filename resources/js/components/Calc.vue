<template>
  <div id="main">
    <Header></Header>
    <div class="container">
      <div class="alert text-center" v-if="loading">
        <div class="lds-dual-ring"></div>
      </div>
      <div class="alert alert-danger" v-else-if="load_error">
        <p>Ошибка загрузки</p>
      </div>
      <div class="row" v-else>
        <div class="col-sm-4 mb-3">
          <div class="card mb-3">
            <div class="card-header">Итог</div>
            <div class="card-body">
              <div class="row">
                <div class="col-4">
                  <label>Время:</label>
                  <br />
                  <label>Стоимость:</label>
                </div>
                <div class="col-8">
                  <!-- <label>{{time.month}} месяцев, {{time.day}} дней, {{time.hour}} часов</label> -->
                  <label>{{time | hours}}</label>
                  <br />
                  <label>{{price}} $</label>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">Переменные</div>
            <div class="card-body p-2">
              <label class="container-fluid text-center font-weight-bold">Frontend</label>
              <div class="row pb-2">
                <div class="col-6">
                  <div class="input-group" v-bind:class="{invalid: data.front.col<0}">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Кол-во</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="999"
                      class="form-control"
                      placeholder="0"
                      v-model="data.front.col"
                    />
                  </div>
                </div>

                <div class="col-6">
                  <div class="input-group" v-bind:class="{invalid: data.front.price<0}">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$/Час</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="999"
                      step="0.01"
                      class="form-control"
                      placeholder="0"
                      v-model="data.front.price"
                    />
                  </div>
                </div>
              </div>

              <label class="container-fluid text-center font-weight-bold">Backend</label>
              <div class="row pb-2">
                <div class="col-6">
                  <div class="input-group" v-bind:class="{invalid: data.back.col<0}">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Кол-во</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="999"
                      class="form-control"
                      placeholder="0"
                      v-model="data.back.col"
                    />
                  </div>
                </div>

                <div class="col-6">
                  <div class="input-group" v-bind:class="{invalid: data.back.price<0}">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$/Час</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="999"
                      step="0.01"
                      class="form-control"
                      placeholder="0"
                      v-model="data.back.price"
                    />
                  </div>
                </div>
              </div>

              <label class="container-fluid text-center font-weight-bold">Дизайнер</label>
              <div class="row pb-2">
                <div class="col-6">
                  <div class="input-group" v-bind:class="{invalid: data.design.col<0}">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Кол-во</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="999"
                      class="form-control"
                      placeholder="0"
                      v-model="data.design.col"
                    />
                  </div>
                </div>

                <div class="col-6">
                  <div class="input-group" v-bind:class="{invalid: data.design.price<0}">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$/Час</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="999"
                      step="0.01"
                      class="form-control"
                      placeholder="0"
                      v-model="data.design.price"
                    />
                  </div>
                </div>
              </div>

              <label class="container-fluid text-center font-weight-bold">Тестировщик</label>
              <div class="row pb-2">
                <div class="col-6">
                  <div class="input-group" v-bind:class="{invalid: data.tester.col<0}">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Кол-во</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="999"
                      class="form-control"
                      placeholder="0"
                      v-model="data.tester.col"
                    />
                  </div>
                </div>

                <div class="col-6">
                  <div class="input-group" v-bind:class="{invalid: data.tester.price<0}">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$/Час</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="999"
                      step="0.01"
                      class="form-control"
                      placeholder="0"
                      v-model="data.tester.price"
                    />
                  </div>
                </div>
              </div>

              <!--<label class="container-fluid text-center font-weight-bold">Управление проектом</label>
              <div class="row">
                <div class="col-5">
                  <div
                    class="input-group"
                    v-bind:class="{invalid: data.control.value>100 || data.control.value<0}"
                  >
                    <div class="input-group-prepend">
                      <span class="input-group-text">%</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="100"
                      step="0.1"
                      class="form-control"
                      placeholder="20"
                      v-model="data.control.value"
                    />
                  </div>
                </div>

                <div class="col-7">
                  <div class="custom-control custom-checkbox">
                    <input
                      type="checkbox"
                      class="custom-control-input"
                      id="customCheck1"
                      name="example6"
                      v-model="data.control.check"
                    />
                    <label class="custom-control-label" for="customCheck1">
                      Заложить управление
                      проектом в стоимость разработки
                    </label>
                  </div>
                </div>
              </div>

              <label class="container-fluid text-center font-weight-bold">Тестирование</label>
              <div class="row">
                <div class="col-5">
                  <div
                    class="input-group"
                    v-bind:class="{invalid: data.test.value>100 || data.test.value<0}"
                  >
                    <div class="input-group-prepend">
                      <span class="input-group-text">%</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="100"
                      step="0.1"
                      class="form-control"
                      placeholder="15"
                      v-model="data.test.value"
                    />
                  </div>
                </div>

                <div class="col-7">
                  <div class="custom-control custom-checkbox">
                    <input
                      type="checkbox"
                      class="custom-control-input"
                      id="customCheck2"
                      name="example3"
                      v-model="data.test.check"
                    />
                    <label class="custom-control-label" for="customCheck2">
                      Заложить тестирование
                      в стоимость разработки
                    </label>
                  </div>
                </div>
              </div>-->

              <label class="container-fluid text-center font-weight-bold">
                Риски и партнерские
                отчисления
              </label>
              <div class="row">
                <div class="col-6">
                  <div class="input-group" v-bind:class="{invalid: data.risks>100 || data.risks<0}">
                    <div class="input-group-prepend">
                      <span class="input-group-text">%</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="100"
                      step="0.1"
                      class="form-control"
                      placeholder="0"
                      v-model="data.risks"
                    />
                  </div>
                </div>

                <div class="col-6">
                  <div
                    class="input-group"
                    v-bind:class="{invalid: data.partner>100 || data.partner<0}"
                  >
                    <div class="input-group-prepend">
                      <span class="input-group-text">%</span>
                    </div>
                    <input
                      type="number"
                      min="0"
                      max="100"
                      step="0.1"
                      class="form-control"
                      placeholder="0"
                      v-model="data.partner"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="card mb-3">
            <div class="card-header d-flex">
              <b class="mt-2">{{ calc.name }}</b>
              <div class="dropdown ml-auto">
                <!-- <button
                  class="btn btn-secondary dropdown-toggle"
                  type="button"
                  id="dropdownSave"
                  data-toggle="dropdown"
                >Сохранить</button>
                <div class="dropdown-menu" aria-labelledby="dropdownSave">
                  <a class="dropdown-item" href="#">Сохранить в закладки</a>
                  <a class="dropdown-item" href="#">Скачать word</a>
                  <a class="dropdown-item" href="#">Скачать pdf</a>
                </div>-->
              </div>
            </div>
            <div class="card-body">{{ calc.description }}</div>
          </div>

          <div class="card">
            <table class="table bg-white">
              <thead class="table-active">
                <tr>
                  <th style="width: 2%" scope="col"></th>
                  <th style="width: 58%" scope="col">Name</th>
                  <th style="width: 10%" scope="col">Front</th>
                  <th style="width: 10%" scope="col">Back</th>
                  <th style="width: 10%" scope="col">Design</th>
                  <th style="width: 10%" scope="col">Test</th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(items, parent_index) in data_calc">
                  <tr v-bind:key="parent_index">
                    <td colspan="6">
                      <!-- <div class="custom-control custom-checkbox">
                        <input
                          type="checkbox"
                          class="custom-control-input"
                          v-bind:id="'cat_'+parent_index"
                          v-model="items.select"
                          v-bind:click="click_cat(parent_index)"
                        />
                        <label class="custom-control-label w-100" v-bind:for="'cat_'+parent_index">
                          <b>{{items.name}}</b>
                        </label>
                      </div>-->
                      <b>{{items.name}}</b>
                    </td>
                  </tr>
                  <tr v-for="(item, index) in items.data" v-bind:key="parent_index+'_'+index">
                    <td></td>
                    <td>
                      <div class="custom-control custom-checkbox">
                        <input
                          type="checkbox"
                          class="custom-control-input"
                          v-bind:id="'podcat_'+parent_index+'_'+index"
                          v-model="item.select"
                          v-bind:click="click_cat(index)"
                        />
                        <label
                          class="custom-control-label"
                          v-bind:for="'podcat_'+parent_index+'_'+index"
                        >{{item.name}}</label>
                      </div>
                    </td>
                    <td>
                      <input
                        type="number"
                        class="form-control"
                        placeholder="0"
                        v-model="item.front"
                      />
                    </td>
                    <td>
                      <input type="number" class="form-control" placeholder="0" v-model="item.back" />
                    </td>
                    <td>
                      <input
                        type="number"
                        class="form-control"
                        placeholder="0"
                        v-model="item.design"
                      />
                    </td>
                    <td>
                      <input
                        type="number"
                        class="form-control"
                        placeholder="0"
                        v-model="item.tester"
                      />
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
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
      selected: 0,
      data_calc: [],
      data: {
        front: {
          col: "",
          price: ""
        },
        back: {
          col: "",
          price: ""
        },
        design: {
          col: "",
          price: ""
        },
        tester: {
          col: "",
          price: ""
        },
        control: {
          value: "",
          check: false
        },
        test: {
          value: "",
          check: false
        },
        risks: "",
        partner: ""
      },
      id: null,
      user: null,
      load_error: false,
      loading: false,
      calc: []
    };
  },
  filters: {
    trim(item) {
      return item.replace(/\s+/g, "");
    },
    hours(item) {
      let lastitem = Number(
        item.toString().substr(item.toString().length - 1, 1)
      );
      let text = "";
      if (lastitem == 0) {
        text = "часов";
      } else if (lastitem == 1) {
        text = "час";
      } else if (lastitem >= 2 && lastitem <= 4) {
        text = "часа";
      } else if (lastitem >= 5 && lastitem <= 9) {
        text = "часов";
      }
      return item + " " + text;
    }
  },
  computed: {
    time() {
      let res = 0;
      for (var items of this.data_calc)
        for (var item of items.data) {
          if (item.select) {
            let back = (Number(item.back) / Number(this.data.back.col));
            let front = (Number(item.front) / Number(this.data.front.col));
            let design = (Number(item.design) / Number(this.data.design.col));
            let tester = (Number(item.tester) / Number(this.data.tester.col));
            res += (back | 0) + (front | 0) + (design | 0) + (tester | 0);
          }
        }
        res += res * (this.data.risks / 100);
      return res;
    },
    price() {
      let res = 0;
      for (var items of this.data_calc)
        for (var item of items.data) {
          if (item.select) {
            let back = (Number(item.back) * Number(this.data.back.price));
            let front = (Number(item.front) * Number(this.data.front.price));
            let design = (Number(item.design) * Number(this.data.design.price));
            let tester = (Number(item.tester) * Number(this.data.tester.price));
            res += (back | 0) + (front | 0) + (design | 0) + (tester | 0);
          }
        }
        res += res * (this.data.partner / 100);
      return res;
    }
  },
  mounted() {
    this.id = this.$route.params.calcId;
    this.user = this.$auth.user();
    this.getCalc();

    $('.form-control').keypress(function(e) {
        if (!(e.which==8 || e.which==44 ||e.which==45 ||e.which==46 ||(e.which>47 && e.which<58))) return false;
    });

  },
  methods: {
    click_cat(cat) {
      //console.log("cat ", cat);
    },
    click_item(item) {
      //console.log("item ", item);
    },
    selectedItems(items) {
      return items.filter(item => item.selected).length;
    },
    getCalc() {
      this.loading = true;
      this.load_error = false;
      this.$http({
        url: `/getcalc/` + this.id,
        method: "GET"
      }).then(
        res => {
          this.calc = res.data.data;
          this.data_calc = JSON.parse(res.data.data.json);
          this.loading = false;
        },
        () => {
          this.load_error = true;
          this.loading = false;
        }
      );
    }
  }
};
</script>


<style>
.invalid .input-group-text,
.invalid .form-control {
  border-color: #e3342f;
}
.list-group-item:first-child {
  border-top-left-radius: 0px;
  border-top-right-radius: 0px;
}
.selected {
  background: lightgray;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield;
}
table .form-control {
  border: none;
}
.table th,
.table td {
  padding: 0.5rem;
  vertical-align: middle;
  height: 50px;
}
.custom-control-label {
  width: 100%;
}
.table thead th {
  vertical-align: middle;
  border-bottom: 2px solid #dee2e6;
}
.table {
  margin-bottom: 0px;
}
</style>
