<template>
    <div>
      <h1>Mes discussions</h1>
      <input type="button" class="btn btn-success btn-xs" @click="openCreateModel" value="Creer" />

      <table class="table table-bordered table-striped">
        <tr v-for="row in allTickets" :key="row">
          <td>{{ row.titre }}</td>
          <td>{{ row.contenu }}</td>
        </tr>
      </table>
      <h1>Autres discussions</h1>
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
                  <br />
                  <div align="center">
                    <input type="hidden" v-model="hiddenID" />
                    <input type="button" class="btn btn-success btn-xs" v-model="actionButton" @click="submitDiscussionData" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import { store } from '../store.js'
import axios from 'axios'

export default {
  name: 'Discussions',
  data () {
    return {
      store: store,
      createModel: false,
      allTickets: '',
      actionButton: '',
      dynamicTitle: ''
    }
  },
  methods: {
    openCreateModel () {
      this.titre = ''
      this.contenu = ''
      this.actionButton = 'Creer'
      this.dynamicTitle = 'Creer une discussion'
      this.createModel = true
    },
    async submitDiscussionData () {
      if (this.titre !== '' && this.contenu !== '') {
        const bodyFormData = new FormData()
        bodyFormData.append('titre', this.titre)
        bodyFormData.append('contenu', this.contenu)

        const response = await axios.post('http://localhost/TickettoolBackend/A_DEFINIR', bodyFormData)
        alert(response.data)
        this.createModel = false
        this.fetchDiscussions()
        this.titre = ''
        this.contenu = ''
      } else {
        alert('Remplissez tout les champs')
      }
    }
  }
}
</script>
