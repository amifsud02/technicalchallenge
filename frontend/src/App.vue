<script setup lang="ts">
import UserTable from './components/UserTable/UserTable.vue';

</script>

<script lang="ts">

export default {
  data() {
    return {
      showAddUserModal: false,        
    };
  },
};
</script>

<template>
  <main className="container">

    <div class="section__header">
      <h2 className="">Media Troopers Technical Challenge</h2>
    </div>
  
    <UserTable/>
  </main>
</template>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  gap: 40px;
  height: 800px;
  padding: 25px;
}

.section__header {
  display: flex;
  justify-content: space-between;
}

.toggle__menu {
  display: flex;
  flex-direction: row;
  height: fit-content;
  width: fit-content;
  gap: 20px;
}

.toggle__menu>button {
  cursor: pointer;
  padding: 10px 20px;
  border-radius: 4px;
  font-size: 11px;
}
</style>
