import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Login from '../components/login/Login';
import Signup from '../components/login/Signup';
import Calendar from '../components/Calendar';
import ListaSalas from '../components/ListaSalas';
import CrearSala from '../components/CrearSala';
import ListaUsuario from '../components/ListaUsuario';

const routes = [
    { path: '/', component: ListaSalas },
    { path: '/login', component: Login },
    { path: '/lista-salas', component: ListaSalas },
    { path: '/registrar-sala', component: CrearSala },
    { path: '/lista-usuarios', component: ListaUsuario },
    { path: '/registrar-usuario', component: Signup },
    { path: '/reserva', component: Calendar },
    
]

const router = new VueRouter({
    routes // short for `routes: routes`
})

export default router