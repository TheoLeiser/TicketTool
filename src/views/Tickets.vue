<template>
  <div>
    <div v-if="store.role != 3"> <!-- MES TICKETS, pour USER et DEV -->
      <!-- Model de création -->
      <div v-if="createModel">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">{{ dynamicTitle }}</h4>
                  <button type="button" class="close" @click="createModel=false"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Entrez le titre</label>
                    <input type="text" class="form-control" v-model="titre" />
                  </div>
                  <div class="form-group">
                    <label>Entrez la description</label>
                    <textarea class="form-control" rows="4" v-model="contenu"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Indiquez la sévérité</label>
                    <br />
                    <select type="select" v-model="severite">
                      <option>WARNING</option>
                      <option>ERROR</option>
                      <option v-if="store.role == 2">FATAL</option>
                    </select>
                  </div>
                  <br />
                  <div align="center">
                    <input type="button" class="btn btn-success btn-xs" v-model="actionButton" @click="createTicket" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Tableaux de tickets -->
      <div class="div_flex_space-between">
        <h1>Mes tickets</h1>
        <input id="btn_creer" type="button" class="btn btn-success btn-xs" @click="openCreateModel" value="Creer un nouveau ticket" />
      </div>
      <table class="table table-bordered table-striped">
        <tr>
          <th>Titre</th>
          <th>Contenu</th>
          <th>Etat</th>
          <th>Severite</th>
        </tr>
        <tr v-for="row in myTickets" :key="row">
          <td>{{ row.titre }}</td>
          <td>{{ row.contenu }}</td>
          <td>{{ row.etat }}</td>
          <td>{{ row.severite }}</td>
          <td border=0 ><input type="button" @click="updateTicket('delete', row.id)" value="Supprimer" /></td>
        </tr>
      </table>
    </div>
    <div v-if="store.role == 2"> <!-- TICKETS ATTRIBUES + TICKETS EN ATTENTE, pour DEV -->
      <h1>Tickets attribués</h1>
      <table class="table table-bordered table-striped">
        <tr>
          <th>Titre</th>
          <th>Contenu</th>
          <th>Etat</th>
          <th>Severite</th>
          <th></th>
        </tr>
        <tr v-for="row in assignedTickets" :key="row">
          <td>{{ row.titre }}</td>
          <td>{{ row.contenu }}</td>
          <td>{{ row.etat }}</td>
          <td>{{ row.severite }}</td>
          <td border=0 ><input type="button" @click="updateTicket('solve', row.id)" value="Résoudre" /></td>
        </tr>
      </table>
      <h1>Tickets en attente</h1>
      <table class="table table-bordered table-striped">
        <tr>
          <th>Titre</th>
          <th>Contenu</th>
          <th>Etat</th>
          <th>Severite</th>
          <th></th>
        </tr>
        <tr v-for="row in waitingTickets" :key="row">
          <td>{{ row.titre }}</td>
          <td>{{ row.contenu }}</td>
          <td>{{ row.etat }}</td>
          <td>{{ row.severite }}</td>
          <td border=0 ><input type="button" @click="updateTicket('assign', row.id)" value="Se l'attribuer" /></td>
        </tr>
      </table>
    </div>
    <div v-if="store.role == 3"> <!-- TOUT LES TICKETS, pour ADMIN -->
      <h1>Liste des tickets</h1>
      <table class="table table-bordered table-striped">
        <tr>
          <th>Titre</th>
          <th>Contenu</th>
          <th>Etat</th>
          <th>Severite</th>
          <th></th>
        </tr>
        <tr v-for="row in allTickets" :key="row">
          <td>{{ row.titre }}</td>
          <td>{{ row.contenu }}</td>
          <td>{{ row.etat }}</td>
          <td>{{ row.severite }}</td>
          <td border=0 ><input type="button" @click="updateTicket('delete', row.id)" value="Supprimer" /></td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { store } from '../store.js'

export default {
  name: 'Tickets',
  data () {
    return {
      store: store,
      // Creation model
      createModel: false,
      actionButton: '',
      dynamicTitle: '',
      // Tickets
      myTickets: '',
      assignedTickets: '',
      waitingTickets: '',
      allTickets: ''
    }
  },
  methods: {
    openCreateModel () {
      this.titre = ''
      this.contenu = ''
      this.severite = 'WARNING'
      this.actionButton = 'Creer'
      this.dynamicTitle = 'Creer un ticket'
      this.createModel = true
    },
    async fetchTickets (action) {
      const bodyFormData = new FormData()
      bodyFormData.append('action', action)
      bodyFormData.append('idUtilisateur', store.id)
      const response = await axios.post('http://localhost/TickettoolBackend/fetchTickets.php', bodyFormData)
      if (action === 'my') {
        this.myTickets = response.data
      }
      if (action === 'assigned') {
        this.assignedTickets = response.data
      }
      if (action === 'waiting') {
        this.waitingTickets = response.data
      }
      if (action === 'all') {
        this.allTickets = response.data
      }
    },
    refreshTickets () {
      this.fetchTickets('my')
      this.fetchTickets('assigned')
      this.fetchTickets('waiting')
      this.fetchTickets('all')
    },
    async createTicket () {
      if (this.titre !== '' && this.contenu !== '') {
        const bodyFormData = new FormData()
        bodyFormData.append('idUtilisateur', store.id)
        bodyFormData.append('titre', this.titre)
        bodyFormData.append('contenu', this.contenu)
        bodyFormData.append('severite', this.severite)
        await axios.post('http://localhost/TickettoolBackend/createTickets.php', bodyFormData)
        this.createModel = false
        this.titre = ''
        this.contenu = ''
        this.refreshTickets()
      } else {
        alert('Remplissez tout les champs')
      }
    },
    async updateTicket (action, idTicket) {
      const bodyFormData = new FormData()
      bodyFormData.append('action', action)
      bodyFormData.append('idTicket', idTicket)
      bodyFormData.append('idUtilisateur', store.id)
      await axios.post('http://localhost/TickettoolBackend/updateTickets.php', bodyFormData)
      this.refreshTickets()
    }
  },
  mounted () { // Execute automatiquement le code suivant après la création de la page
    this.refreshTickets()
  }
}
</script>
