<script>
import RequestService from "../Services/RequestServiceClass.js";
import NavBar from "./NavBar.vue";
export default {
  components: { NavBar },
  data() {
    return {
      categories: [],
      optionsData: [],
      category_id: 0,
      name: "",
      sku: "",
      price: 0,
      category_id: 0
    };
  },
  methods: {
    getAllCategories() {
      RequestService.getAllCategories()
        .then(response => {
          this.categories = response.data.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    getCategory(id) {
      console.log(id);
      RequestService.getOneCategory(id)
        .then(response => {
          console.log(response.data.data[0]);
          this.optionsData = response.data.data[0].attribute_category;
        })
        .catch(e => {
          console.log(e);
        });
    },
    createProduct(e) {
      e.preventDefault();
      let attributes = [];
      let attributesValues = document.querySelectorAll('[name="attributes[]"]');
      attributesValues.forEach(attribute => {
        let attributeValue = {
          id: parseInt(attribute.dataset.attribute_id),
          value: attribute.value
        };
        attributes.push(attributeValue);
      });

      let product = {
        name: this.name,
        sku: this.sku,
        price: parseInt(this.price),
        category_id: parseInt(this.category_id),
        attributes: attributes
      };
      RequestService.create(product)
        .then(response => {
          console.log(response.data.data);
        })
        .catch(e => {
          console.log(e);
        });
    }
  },

  mounted() {
    this.getAllCategories();
  }
};
</script>
<template>
  <div>
    <NavBar pageName="Product Add" pageUrl="product-list" ButtonLabel="Cancel"></NavBar>
    <div id="wrapper">
      <form  @submit.prevent="createProduct">
        <div class="form-group">
          <label for="sku">SKU</label>
          <input class="form-control" id="sku" v-model="sku" />
        </div>
        <div class="form-group">
          <label for="sku">Name</label>
          <input class="form-control" id="name" v-model="name" />
        </div>
        <div class="form-group">
          <label for="sku">Price($)</label>
          <input class="form-control" id="price" v-model="price" />
        </div>

        <div class="form-group">
          <label for="type">Type Switcher</label>
          <select
            class="form-control"
            id="productType"
            v-model="category_id"
            @change="getCategory(category_id)"
          >
            <option
              v-for="category in categories"
              :key="category.id"
              :value="category.id"
            >{{category.name}}</option>
          </select>
        </div>
        <div v-for="attribute in optionsData" :key="attribute.attribute_id" class="form-group">
          <label for="sku">{{attribute.attribute_name}} ({{attribute.unit_name}})</label>
          <input
            class="form-control"
            name="attributes[]"
            :data-attribute_id="attribute.attribute_id"
            :id="attribute.attribute_name"
          />
        </div>

        <button  class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.container {
  width: 329px;
  height: 200px;
  margin: auto;
}
#wrapper {
  display: flex;
  flex-wrap: wrap;
  margin-top: 20px;
}
.card {
  height: 150px;
  max-height: 250px;
}
</style>