<script setup>
defineProps({
  pageName: {
    type: String,
    required: true
  },
  pageUrl: {
    required: true
  },
  ButtonLabel: {
    type: String,
    required: true
  },
  massDelete: {
    type: Function,
    required: false
  },
  deleteActive: {
    type: Boolean,
    required: false,
  },
  submitFunction: {
    type: Function,
    required: false
  }
});
</script>

<template>
  <div id="navbar">
    <nav class="navbar navbar-expand-lg navbar-light">
      <span class="navbar-brand">{{pageName}}</span>
            <span class="text-center text-danger d-none" id="delete-error"> Please choose products </span>

      <div>
        <RouterLink :to="{name:pageUrl}" class="btn btn-success">{{ButtonLabel}}</RouterLink>

        <button
          v-if="deleteActive"
          id="delete-product-btn"
          @click="massDelete"
          class="btn btn-danger"
        >MASS DELETE</button>

        <button v-if="!deleteActive" @click="submitFunction" class="btn btn-primary mx-2">Save</button>
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
