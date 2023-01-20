<script>
import NavBar from "./NavBar.vue";

import RequestService from "../Services/RequestServiceClass.js";

export default {
  components: { NavBar },

  data() {
    return {
      products: []
    };
  },
  methods: {
    ucFirst(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    getAllProducts() {
      RequestService.getAll()
        .then(response => {
          this.products = response.data.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    massDelete() {
      let productIds = [];
      let checkboxes = document.querySelectorAll(".delete-checkbox");
      let deleteError = document.querySelector("#delete-error");
      checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
          let product_id = parseInt(checkbox.value);
          productIds.push(product_id);
        }
      });
      if (productIds.length == 0) {
        deleteError.classList.remove("d-none");
      } else {
        deleteError.classList.add("d-none");
        RequestService.massDelete(productIds)
          .then(response => {
            this.getAllProducts();
          })
          .catch(e => {
            console.log(e.response.data.data);
          });
      }
    }
  },

  mounted() {
    this.getAllProducts();
  }
};
</script>
<template>
  <div>
    <NavBar
      pageName="Product List"
      :massDelete="massDelete"
      pageUrl="add-product"
      ButtonLabel="Add"
      :deleteActive="true"
    />
    <div id="wrapper">
      <div class="container" v-for="product in products" :key="product.id">
        <div class="card text-center">
          <div class="input-group-text">
            <input type="checkbox" :value="product.id" class="delete-checkbox" />
          </div>

          <div class="card-body">
            <h5 class="card-title">{{product.sku}}</h5>
            <div class="card-text">
              <p class="product-list">{{product.name}}</p>
              <p class="product-list">{{ product.price}} $</p>
              <ul class="product-attributes dimensions" v-if="product.attribute_items.length > 1">
                Dimensions:
                <li v-for="(attribute, index) in product.attribute_items" :key="attribute.id">
                  {{attribute.value}}<span v-if="index<2">x</span>
                </li>
              </ul>
              <ul class="product-attributes" v-if="product.attribute_items.length < 3">
                <li
                  v-for="attribute in product.attribute_items"
                  :key="attribute.id"
                >{{ucFirst(attribute.attribute_name)}}: {{attribute.value}} {{attribute.unit_name}}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  width: 329px;
  height: 250px;
  margin: auto;
}
#wrapper {
  display: flex;
  flex-wrap: wrap;
  margin: 40px;
}
.card {
  height: 200px;
  max-height: 250px;
}
.input-group-text {
  background-color: white;
  border: none;
}
li {
  list-style: none;
}
ul {
  display: flex;
  justify-content: space-around;
}
.product-list {
  margin: 0;
}
.product-attributes {
  padding: 0;
}
.dimensions {
  display: block;
}
.dimensions li {
  display: inline;
}
.delete-checkbox {
  position: relative;
  top: 15px;
  left: 25px;
}
</style>