<template>
  <div class="row">
    <div class="col-1">
      <button class="btn btn-secondary button" @click="add">Add</button>
    </div>

    <div class="col-7">
      <draggable tag="ul" :list="list" class="list-group" handle=".handle">
        <li class="list-group-item" v-for="(element, idx) in list" :key="element.name">
          <div style="width: 15px; height: 15px; background: red" class="handle"></div>

          <span class="text">{{ element.name }}</span>

          <input type="text" class="form-control" v-model="element.text" />

          <div
            class="close"
            style="width: 15px; height: 15px; background: red"
            @click="removeAt(idx)"
          ></div>
        </li>
      </draggable>
    </div>
  </div>
</template>

<script>
let id = 3;
import draggable from "vuedraggable";
export default {
  components: {
    draggable
  },
  data() {
    return {
      list: [
        { name: "John", text: "", id: 0 },
        { name: "Joao", text: "", id: 1 },
        { name: "Jean", text: "", id: 2 }
      ]
    };
  },
  methods: {
    removeAt(idx) {
      this.list.splice(idx, 1);
    },
    add: function() {
      id++;
      this.list.push({ name: "Juan " + id, id, text: "" });
    }
  }
};
</script>
<style scoped>
.sortable-ghost {
  opacity: 0.5;
  background: #c8ebfb;
}
</style>
