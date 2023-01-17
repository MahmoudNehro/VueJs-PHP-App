<script>
import NavBar from "../components/NavBar.vue";
import RequestService from "../Services/RequestServiceClass.js";

export default {
  data() {
    return {
      products: []
    };
  },
  methods: {
    getAllProducts() {
      RequestService.getAll()
        .then(response => {
          this.products = response.data;
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
    <NavBar pageName="Product List" pageUrl="add-product" />

    <div id="wrapper">
      <div class="container">
        <div class="card text-center">
          <div class="input-group-text">
            <input type="checkbox" />
          </div>

          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p
              class="card-text"
            >With supporting text below as a natural lead-in to additional content.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p
              class="card-text"
            >With supporting text below as a natural lead-in to additional content.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p
              class="card-text"
            >With supporting text below as a natural lead-in to additional content.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p
              class="card-text"
            >With supporting text below as a natural lead-in to additional content.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p
              class="card-text"
            >With supporting text below as a natural lead-in to additional content.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p
              class="card-text"
            >With supporting text below as a natural lead-in to additional content.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p
              class="card-text"
            >With supporting text below as a natural lead-in to additional content.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p
              class="card-text"
            >With supporting text below as a natural lead-in to additional content.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p
              class="card-text"
            >With supporting text below as a natural lead-in to additional content.</p>
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
  height: 150px;
  max-height: 250px;
}
.input-group-text {
  background-color: white;
  border: none;
}
</style>