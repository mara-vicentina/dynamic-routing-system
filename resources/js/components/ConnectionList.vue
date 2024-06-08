<template>
    <div class="connection-list">
      <h2>Listagem das Conexões</h2>
      <BCol>
        <add-connection-modal :nodes="nodes" :connections="connections" @connectionAdded="fetchConnectionsLimit"></add-connection-modal>
      </BCol>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Do Nó</th>
            <th>Para o Nó</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
            <tr v-for="connection in connectionsLimit.data" :key="connection.id">
                <td>{{ connection.id }}</td>
                <td>{{ connection.from_node.name }}</td>
                <td>{{ connection.to_node.name }}</td>
                <td>
                  <BButton @click="deleteConnection(connection.id)" variant="danger" size="xs">Remover</BButton>
                </td>
            </tr>
        </tbody>
      </table>
      <div class="pagination" v-if="connections.last_page > 1">
        <b-button @click="fetchConnectionsLimit(connections.prev_page_url)" :disabled="!connections.prev_page_url">Anterior</b-button>
        <b-button @click="fetchConnectionsLimit(connections.next_page_url)" :disabled="!connections.next_page_url" class="ml-3">Próximo</b-button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import AddConnectionModal from './AddConnectionModal.vue';
  
  export default {
    name: 'ConnectionList',
    components: {
      AddConnectionModal
    },
    data() {
      return {
        nodes: [],
        connections: [],
        connectionsLimit: []
      };
    },
    methods: {
      // Busca a lista de nós da API
      fetchNodes() {
        axios.get('/api/nodes').then(response => {
          this.nodes = response.data;
        });
      },
      // Busca a lista completa de conexões da API
      fetchConnections() {
        axios.get('/api/connections').then(response => {
          this.connections = response.data.map(connection => ({
            ...connection,
            source: connection.from_node_id,
            target: connection.to_node_id
          }));
        });
      },
      // Busca a lista limitada de conexões da API, com paginação
      fetchConnectionsLimit(url = '/api/connections/limited?per_page=8') {
        axios.get(url).then(response => {
          this.connectionsLimit = response.data;
        });
      },
      // Exclui uma conexão específica pela ID e atualiza a lista limitada de conexões
      deleteConnection(connectionId) {
        axios.delete(`/api/connections/${connectionId}`);
        this.fetchConnectionsLimit();
      }
    },
    // Carrega a lista de nós e conexões quando o componente é montado
    mounted() {
      this.fetchNodes();
      this.fetchConnections();
      this.fetchConnectionsLimit();
    }
  };
  </script>
  
  <style scoped>
  .connection-list {
    padding: 20px;
  }
  
  .table {
    width: 100%;
    margin-top: 20px;
    background-color: white;
  }
  </style>  