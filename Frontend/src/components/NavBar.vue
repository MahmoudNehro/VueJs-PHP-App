<script setup>
defineProps({
  name: {
    type: String,
    required: true
  }
});
</script>

<template>
  <div id="navbar">
    <nav class="navbar navbar-expand-lg navbar-light">
      <span class="navbar-brand">{{name}}</span>
      <div>
        <RouterLink to="/create">
          <button class="btn btn-success">create</button>
        </RouterLink>
        <button id="delete-product-btn" class="btn btn-danger">mass delete</button>
      </div>
    </nav>
    <hr />
  </div>
</template>

<style scoped>
#navbar {
  margin: 30px;
}
.navbar {
  justify-content: space-between;
}
#delete-product-btn {
  margin-left: 10px;
  margin-right: 10px;
}

</style>
