<template>
<v-container fluid grid-list-xl>
    <v-layout row justify-center>
      
      <v-flex xs12 md3>
        <v-card >
          <v-card-text>
              <h3 class="headline mb-0 text-md-center">Registro de Sala</h3>
              <v-form  @submit.prevent="registrarSala">
                 <v-text-field
                v-model="form.nombre"
                label="Nombre"
                required
                ></v-text-field>
                <span class="red--text" v-if="errors.nombre">{{errors.nombre[0]}}</span>
                <v-text-field
                v-model="form.direccion"
                label="Direccion"
                required
                ></v-text-field>
                <span class="red--text" v-if="errors.direccion">{{errors.direccion[0]}}</span>
                <v-text-field
                v-model="form.color"
                label="Color"
                required
                ></v-text-field>
                <span class="red--text" v-if="errors.color">{{errors.color[0]}}</span>
                
                <v-radio-group
                v-model="form.color"
                column
                required
                >
                  <v-radio
                    label="red"
                    color="red"
                    value="red"
                  ></v-radio>
                  <v-radio
                    label="red darken-3"
                    color="red darken-3"
                    value="red darken-3"
                  ></v-radio>
                  <v-radio
                    label="indigo"
                    color="indigo"
                    value="indigo"
                  ></v-radio>
                  <v-radio
                    label="indigo darken-3"
                    color="indigo darken-3"
                    value="indigo darken-3"
                  ></v-radio>
                  <v-radio
                    label="orange"
                    color="orange"
                    value="orange"
                  ></v-radio>
                  <v-radio
                    label="orange darken-3"
                    color="orange darken-3"
                    value="orange darken-3"
                  ></v-radio>
                  <v-radio
                label="primary"
                color="primary"
                value="primary"
              ></v-radio>
              <v-radio
                label="secondary"
                color="secondary"
                value="secondary"
              ></v-radio>
              <v-radio
                label="success"
                color="success"
                value="success"
              ></v-radio>
              <v-radio
                label="info"
                color="info"
                value="info"
              ></v-radio>
              <v-radio
                label="warning"
                color="warning"
                value="warning"
              ></v-radio>
              <v-radio
                label="error"
                color="error"
                value="error"
              ></v-radio>
                </v-radio-group>
                <span class="red--text" v-if="errors.color">{{errors.color[0]}}</span>
                <div class="text-md-center">
                <v-btn type="submit" color="primary">Registrar Sala</v-btn>
                </div>

            </v-form >
          </v-card-text>
        </v-card>
      </v-flex>
     
    </v-layout>
</v-container>
</template>

<script>
export default {
    data () {
      return {
        form: {
            nombre: null,
            direccion: null,
            color: null
        },
        ex7: 'red',
        errors:{}
      }
    },
    methods:{
        registrarSala(){
            console.log(this.form);
            //User.signup(this.form);
            axios.post('/api/sala',this.form)
            .then((res) => {
              this.$router.push({ path: 'lista-salas' })  
            })
            .catch((error) => {
              this.errors = error.response.data.errors
            })
            
        }
    }
}
</script>

<style>

</style>