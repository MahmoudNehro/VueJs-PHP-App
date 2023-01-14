
<script setup>
import AllProducts from '../components/AllProducts.vue';
</script>
<template>
  <div class="about">
    <AllProducts/>
  </div>
</template>

<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
    margin-right: 70px;
    margin-left: 70px;
  }
}
</style>
