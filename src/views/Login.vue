<template>
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{ dynamicTitle }}</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Entrez votre adresse mail</label>
                <input type="text" class="form-control" v-model="email" />
              </div>
              <div class="form-group">
                <label>Entrez votre mot de passe</label>
                <input type="password" class="form-control" v-model="motDePasse" />
              </div>
              <br />
              <div align="center">
                <input type="button" class="btn btn-success btn-xs" v-model="actionButton" @click="submitConnectionData" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios'
import { store } from '../store.js'

export default {
  name: 'Login',
  data () {
    return {
      store: store,
      actionButton: 'Confirmer',
      dynamicTitle: 'Se connecter',
      email: 'dev@mail.com',
      motDePasse: 'P@ssword'
    }
  },
  methods: {
    async submitConnectionData () {
      if (this.email !== '' && this.motDePasse !== '') {
        const bodyFormData = new FormData()
        bodyFormData.append('email', this.email)
        bodyFormData.append('motDePasse', this.motDePasse)

        const response = await axios.post('http://localhost/TickettoolBackend/login.php', bodyFormData)
        if (response.data.successful) {
          this.store.id = response.data.id
          this.store.nom = response.data.nom
          this.store.prenom = response.data.prenom
          this.store.role = response.data.role
          this.$router.push('/tickets')
        } else {
          alert('Identifiants incorrects')
        }
      } else {
        alert('Remplissez tout les champs')
      }
    }
  }
}
</script>
