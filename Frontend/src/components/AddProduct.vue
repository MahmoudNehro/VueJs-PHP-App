<script>
import RequestService from "../Services/RequestServiceClass.js";
import NavBar from "./NavBar.vue";
export default {
  components: { NavBar },
  data() {
    return {
      categories: [],
      optionsData: [],
      category_id: "",
      name: "",
      sku: "",
      price: "",
      errors: {}
    };
  },
  methods: {
    ucFirst(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
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
      this.errors = {};
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
        price: parseFloat(this.price),
        category_id: parseInt(this.category_id),
        attributes: attributes
      };
      RequestService.create(product)
        .then(response => {
          this.$router.push("/");
        })
        .catch(e => {
          let errors = e.response.data.data;
          this.errors = errors;
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
    <NavBar
      pageName="Product Add"
      pageUrl="product-list"
      ButtonLabel="Cancel"
      :submitFunction="createProduct"
    ></NavBar>
    <form @submit.prevent="createProduct" class="container" id="product_form">
      <div class="form-group">
        <label for="sku">SKU</label>
        <input @change="errors.sku=''" class="form-control input" id="sku" v-model="sku" />
      </div>
      <span class="text-danger text-center" v-if="errors.sku">{{errors.sku}}</span>

      <div class="form-group">
        <label for="sku">Name</label>
        <input @change="errors.name=''" class="form-control input" id="name" v-model="name" />
      </div>
      <span class="text-danger text-center" v-if="errors.name">{{errors.name}}</span>

      <div class="form-group">
        <label for="sku">Price ($)</label>
        <input @change="errors.price=''" class="form-control input" id="price" v-model="price" />
      </div>
      <span class="text-danger text-center" v-if="errors.price">{{errors.price}}</span>

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
      <span
        class="text-danger text-center"
        v-if="errors.category_id"
      >{{errors.category_id.replace("category_id","category")}}</span>

      <div
        v-for="attribute in optionsData"
        :key="attribute.attribute_id"
        class="form-group"
        style="display:block!important;"
      >
        <div class="d-flex">
          <label for="sku">{{ucFirst(attribute.attribute_name)}} ({{attribute.unit_name}})</label>
          <input
            class="form-control"
            name="attributes[]"
            :data-attribute_id="attribute.attribute_id"
            :id="attribute.attribute_name"
            @change="errors.attributes=''"
          />
        </div>
        <p
          class="fs-6 mt-5"
          v-if="optionsData.length <2"
        >Please provide {{attribute.attribute_name}} in {{attribute.unit_name}}</p>
      </div>
      <span class="text-danger d-block" v-if="errors.attributes">{{errors.attributes}}</span>
      <p class="fs-6 mt-5" v-if="optionsData.length >2">Please provide Dimensions in CM</p>
    </form>
  </div>
</template>

<style scoped>
form {
  width: 270px;
  margin-left: 20px;
}
.card {
  height: 150px;
  max-height: 250px;
}
.form-group {
  display: flex;
  margin-top: 20px;
}
.form-group label {
  width: 200px;
  margin-right: 20px;
}
.form-group .input {
  width: 170px;
  height: 30px;
}
</style>