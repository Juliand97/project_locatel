<template>
    <div class="card">
        <div class="card-header text-center">
          <i class="material-icons">face</i>   Nuevos Usuarios
        </div>
        <div class="card-body">
            <form @submit.prevent="register">
                <div class="form-group">
                    <label for="" class="control-label">N° Documento</label>
                    <input required type="number" name="iden_clie" id="iden_clie" v-model="formData.iden_clie" class="form-control">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="control-label">Nombre</label>
                            <input required type="text" name="name_clie" id="name_clie" v-model="formData.name_clie" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="" class="control-label">Apellidos</label>
                            <input required type="text" name="last_name" id="last_name" v-model="formData.last_name" class="form-control">
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Email</label>
                    <input required type="email" name="email" id="email" v-model="formData.email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Celular</label>
                    <input required type="number" name="phone_clie" id="phone_clie" v-model="formData.phone_clie" class="form-control">
                </div>
                <br>
                <div class="form-group text-center">
                    <button type="submit" id="save" class=" btn btn-success"><i class="material-icons">save</i> Guardar Información</button>
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
        iden_clie: '',
        name_clie: '',
        last_name: '',
        email: '',
        phone_clie: '',
      },
    };
  },
  methods: {
    async register() {
        console.log(this.formData)
        this.formData.iden_clie = String(this.formData.iden_clie);
        this.formData.phone_clie = String(this.formData.phone_clie);
      try {
        const response = await this.$axios.post('/api/new_client', this.formData);
        let data=response.data;
        Swal.fire({
              title: (data.state=='error') ? 'Error' : 'Éxito',
              text: data.msg+". Su numero de cuenta es "+data.data.account_numb,
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
<style scoped></style>