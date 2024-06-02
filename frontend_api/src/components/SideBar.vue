<template>
    <div class="col-md-4">
      <ul class="list-group list_options">
        <li class="option_menu list-group-item list-group-item-success list-group-item-action "><RouterLink to="/home"><i class="material-icons">home</i> Inicio</RouterLink></li>
        <li class="option_menu list-group-item list-group-item-success list-group-item-action "><RouterLink to="/balance"><i class="material-icons">account_balance_wallet</i> Consulta De Movimientos</RouterLink></li>
        <li class="option_menu list-group-item list-group-item-success list-group-item-action "><RouterLink to="/register"><i class="material-icons">face</i> Crear Nuevo Usuario</RouterLink></li>
        <li class="option_menu list-group-item list-group-item-success list-group-item-action "><RouterLink to="/move_bank"><i class="material-icons">payments</i> Consignar/Retirar</RouterLink></li>
        <li class="option_menu list-group-item list-group-item-success list-group-item-action "><RouterLink to="/close_account"><i class="material-icons">close</i> Inactivar Cliente</RouterLink></li>
      </ul>
    </div>
</template>
<script setup>
</script>
<style>
  .list_options > li > a{
    text-decoration: none;
    color:rgb(251, 246, 246);
  }
  
  .option_menu{
    background-color: rgb(38, 157, 38);
  }
</style>