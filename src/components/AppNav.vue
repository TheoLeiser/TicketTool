<template>
  <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul id="navbar_nav" class="navbar-nav">
        <li class="nav-item">
          <span class="navbar-brand">TicketTool</span>
        </li>
        <li class="nav-item">
          <span class="navbar-brand">{{ store.prenom }} {{ store.nom }}</span>
        </li>
        <li class="nav-item">
          <input v-if="store.role !== 0" type="button" class="btn btn-success btn-xs" @click="disconnect" value="Se déconnecter" />
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import { store } from '../store.js'

export default {
  name: 'AppNav',
  data () {
    return {
      store: store
    }
  },
  methods: {
    disconnect () {
      this.store.id = ''
      this.store.nom = ''
      this.store.prenom = ''
      this.store.role = 0
      this.$router.push('/')
    }
  }
}
</script>
