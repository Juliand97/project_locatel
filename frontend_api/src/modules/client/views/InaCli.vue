<template>
    <div class="card inac_clie">
        <div class="card-header text-center">
          <i class="material-icons">face</i> Cerrar Cuenta De Ahorros
        </div>
        <div class="card-body">
            <form @submit.prevent="unregister">
                <div class="form-group">
                    <label for="" class="control-label">N° Documento</label>
                    <input required type="number" name="iden_clie" id="iden_clie" v-model="formData.iden_clie" class="form-control">
                </div>
                <br>
                <div class="form-group text-center">
                    <button type="submit" id="save" class=" btn btn-success"><i class="material-icons">close</i> Inactivar Cliente</button>
                </div>
            </form>

        </div>
    </div>
</template>
<script >
import Swal from 'sweetalert2';

export default { 
  data() {
    return {
      formData: {
        iden_clie: ''
      },
    };
  },
  methods: {
    async unregister() {
        this.formData.iden_clie = String(this.formData.iden_clie);
      try {
        const response = await this.$axios.post('/api/edit_client', this.formData);
        let data=response.data;
        Swal.fire({
              title: (data.state=='error') ? 'Error' : 'Éxito',
              text: data.msg,
              icon: data.state
        });
        this.formData = {};
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
<style scoped>
.inac_clie{
  margin-top: 30%;
}

</style>