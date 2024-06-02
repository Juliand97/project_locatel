<template>
    <div class="cliente">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="material-icons">account_balance_wallet</i> Balance De Cuenta</h3>
        </div>
        <div class="card-body">
          <form @submit.prevent="search_balance_user">
            <div class="row">
              <div class="col-md-12 form-group">
                <label for="account_number" class="control-label">Numero De Cuenta</label>
                <input class="form-control" type="string" name="account_number" id="account_number" v-model="formData.account_number">
              </div>
            </div>
         
            <br>
            <div class="col-md-12">
              <button type="submit" class="btn btn-success"><i class="material-icons">search</i> Buscar Movimientos</button>
            </div>
          </form>
        </div>
        <div class="card-footer">
            <div v-if="this.moves.data && this.moves.data > 0 ">mostrar</div>
            <div class="table table-responsive">
              <table class="table table-striped table-responsive">
                  <thead>
                      <tr>
                          <th># Cuenta</th>
                          <td colspan="2">{{this.moves.data.account_number}}</td>
                          <th>Saldo Actual</th>
                          <td>${{this.moves.data.current_cash}}</td>
                      </tr>
                      <tr>
                          <th>#</th>
                          <th># Cuenta</th>
                          <th>Tipo Transaccion</th>
                          <th>Valor</th>
                          <th>Estado</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="move in this.moves.data.current_movements" :key="this.moves.data.current_movements.id">
                          <td>{{ move.id }}</td>
                          <td>{{ move.account_number }}</td>
                          <td>{{ move.type_transaction==='CON' ? 'Consignación' : 'Retiro' }}</td>
                          <td>{{ move.value_transaction }}</td>
                          <td>{{ move.state_transaction === 'CER' ? 'Cerrado' : 'Pendiente' }}</td>
                      </tr>
                  </tbody>
                  <tfoot>
                      <tr>
                          <th>#</th>
                          <th># Cuenta</th>
                          <th>Tipo Transaccion</th>
                          <th>Valor</th>
                          <th>Estado</th>
                      </tr>
                  </tfoot>
              </table>
            </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        moves: {data:[]},
        formData: {
          account_number: ""
        }
      };
    },
    methods: {
      async search_balance_user() {
        try {
          const response = await this.$axios.post('/api/state_account', this.formData);
          this.moves=response.data
        } catch (error) {
          console.error(error);
        }
      }
    }
  };
  </script>
  
  <style>
  .cliente{
    margin-top: 10%;
    width: 150%;
  }
  /* Estilos específicos si los necesitas */
  </style>
  