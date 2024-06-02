<script setup>
import SideBar from '../components/SideBar.vue'
</script>

<template>
  <div class="content">
    <SideBar></SideBar>
    <div class="content_views col-md-6" >
      <router-view></router-view>
    </div>
  </div>
</template>
<style scoped>
.content{
 display: flex;
 padding:20%;
}

.content_views{
  flex:1;
  margin-top: -20%;
  padding:20px;
} 

/*
*/
</style>
