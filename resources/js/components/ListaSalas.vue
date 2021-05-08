<template>
     <v-card class="mx-auto">

      <v-container
        fluid
        grid-list-lg
      >
        <v-layout row wrap>
          <v-flex xs12 md3 v-for="sala in listaSalas" :key="sala.id">
            <v-card :color="sala.color" class="white--text" >
              <v-card-title primary-title>
                <div>
                  <div class="headline">
                    {{ sala.nombre }}
                    </div>
                  <span>{{ sala.direccion }}</span>
                </div>
              </v-card-title>
              <v-divider ></v-divider>
              <v-card-actions>
                <v-btn outline @click="verReserva(sala)" flat dark>Ver Reservas</v-btn>
                
                <v-btn outline @click="editarSala(sala)" color="white" class="ml-4"  v-if="loggin">
                   Editar
                  </v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>

        </v-layout>
      </v-container>
      <v-card-text v-if="loggin">
            <v-btn
              absolute
              dark
              fab
              bottom
              right
              color="pink"
              @click="nuevaSala()"
            >
              <v-icon>add</v-icon>
            </v-btn>
          </v-card-text>



      <v-dialog v-model="dialogEdit" persistent max-width="400px">
      <v-card>
        <v-card-title 
        v-bind:class="[classEditModal.headline, classEditModal.colorFondo, classEditModal.colorText]">
          <span class="headline">Editar Sala</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md v-if="editSala">
            <v-layout wrap>

              <v-flex xs12>
                <v-text-field label="Nombre*" required v-model="editSala.nombre"></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-text-field label="Direccion*" required v-model="editSala.direccion"></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-text-field label="Color*" required v-model="editSala.color"></v-text-field>
              </v-flex>


            </v-layout>
          </v-container>

        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click="dialogEdit = false">Cerrar</v-btn>
          <v-btn color="blue darken-1" flat @click="actualizarSala()">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </v-card>
</template>

<script>
export default {
  data: function () {
    return {
      loggin: false,
      listaSalas: null,
      dialogEdit: false,
      editSala: null,
      classEditModal:{
        headline: 'headline',
        colorFondo: 'blue',
        colorText: 'white--text'
      }
    }
  },
  created: function () {
       this.obtenerSalas();
       this.$bus.$emit('cambiarTextoTitulo', 'Lista de Salas')
       if(User.isAdministrator()){
          this.loggin = true
      }else{
           this.loggin = false
      }
  },
  methods:{
        obtenerSalas(){
            axios.get('/api/sala')
            .then((res) => {
              this.listaSalas = res.data.data;
              console.log(res.data.data)
            })
            .catch((error) => {
              this.errors = error.response.data.errors
            })
            
        },
        verReserva(sala){
          if(User.loggedIn()){
            localStorage.sala_id = sala.id
            this.$bus.$emit('cambiarTextoTitulo', sala.nombre)
            this.$router.push({ path: 'reserva' })  
          }else{
            this.$router.push({ path: 'login' })  
          }
          
        },
        nuevaSala(){
          this.$router.push({ path: 'registrar-sala' })  
        },

        editarSala(sala){
          this.editSala =  sala
          this.classEditModal.colorFondo = this.editSala.color
          this.dialogEdit = true
        },
        actualizarAmbiente(){
          axios.put(`/api/sala/${this.editSala.id}`,this.editSala)
            .then((res) => {
              //User.resposeAfterLogin(res)
              this.obtenerSalas()
              this.dialogEdit = false
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
