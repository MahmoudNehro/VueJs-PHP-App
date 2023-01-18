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
    getAllProducts() {
      RequestService.getAll()
        .then(response => {
          this.products = response.data.data;
          console.log(response);
        })
        .catch(e => {
          console.log(e);
        });
    },
    massDelete() {
      let productIds = [];
      let checkboxes = document.querySelectorAll(".delete-checkbox");
      checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
          productIds.push(checkbox.value);
        }
      });
      RequestService.massDelete(productIds)
        .then(response => {
          console.log(response.data);
          this.getAllProducts();
        })
        .catch(e => {
          console.log(e);
        });
    },
    getAllCategories() {
      RequestService.getAllCategories()
        .then(response => {
          console.log(response.data);
        })
        .catch(e => {
          console.log(e);
        });
    },
    createProduct() {
      RequestService.create()
        .then(response => {
          console.log(response.data);
        })
        .catch(e => {
          console.log(e);
        });
    }
  },

  mounted() {
    this.getAllProducts();
  }
};
</script>
<template>
  <div>
    <NavBar pageName="Product List" pageUrl="add-product" ButtonLabel="Add" />
    <button id="delete-product-btn" @click="massDelete" class="btn btn-danger">MASS delete</button>

    <div id="wrapper">
      <div class="container" v-for="product in products" :key="product.id">
        <div class="card text-center">
          <div class="input-group-text">
            <input type="checkbox" :value="product.id" class="delete-checkbox" name="product_ids[]" />
          </div>

          <div class="card-body">
            <h5 class="card-title">{{product.sku}}</h5>
            <div class="card-text">
              <p>{{product.name}}</p>
              <p>{{ Math.round(product.price,2)}} $</p>
              <ul>
                <li
                  v-for="attribute in product.attribute_items"
                  :key="attribute.id"
                >{{attribute.attribute_name}}: {{attribute.value}} {{attribute.unit_name}}</li>
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
  height: 200px;
  margin: auto;
}
#wrapper {
  display: flex;
  flex-wrap: wrap;
  margin-top: 20px;
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
</style>