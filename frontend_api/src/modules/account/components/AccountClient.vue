<template>
    <div class="cliente">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="material-icons">payments</i> Tipo De Movimiento</h3>
          <select required ref="tipoMoveSelect" v-model="type_move" name="type_move" id="type_move" class="form-select">
            <option value="" selected>Seleccione un tipo de movimiento..</option>
            <option value="deposit">Consignación</option>
            <option value="withdrawal">Retiro</option>
          </select>
        </div>
        <div class="card-body">
          <form @submit.prevent="move_account">
            <div class="row">
              <div class="col-md-6 form-group">
                <label for="account_number" class="control-label">Numero De Cuenta</label>
                <input required  class="form-control" type="string" name="account_number" id="account_number" v-model="formData.account_number">
              </div>
              <div class="col-md-6 form-group">
                <label for="value_transaction" class="control-label">Monto</label>
                <input required class="form-control" type="number" name="value_transaction" id="value_transaction" v-model="formData.value_transaction">
              </div>
            </div>
         
            <br>
            <div class="col-md-12">
              <button type="submit" class="btn btn-success"><i class="material-icons">wallet</i> Realizar Transacción</button>
            </div>
          </form>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </template>
  
  <script>
  import Swal from 'sweetalert2';
  export default {
    data() {
      return {
        type_move: "",
        formData: {
          account_number: "",
          value_transaction: "",
          tipo_move: "" 
        }
      };
    },
    methods: {
      async move_account() {
        try {
          const tipoMoveSelect = this.$refs.tipoMoveSelect; 
          const selectedValue = tipoMoveSelect.value; 
          if (selectedValue=='') {
            Swal.fire({
              title: "Error",
              text: "Seleccione el tipo de movimiento que desea hacer",
              icon: "error"
            });
            return false;
          }

          const response = await this.$axios.post('/api/'+selectedValue, this.formData);
          Swal.fire({
              title: (response.data.state=='error') ? 'Error' : 'Éxito',
              text: response.data.msg,
              icon: response.data.state
            });
            this.formData = {};
        } catch (error) {
          console.error(error);
        }
      }
    }
  };
  </script>
  
  <style>
  .cliente{
    margin-top: 15%;
  }
  </style>
  