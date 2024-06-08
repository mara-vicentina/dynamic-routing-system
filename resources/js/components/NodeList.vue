<template>
    <div class="node-list">
      <h2>Listagem dos Nós</h2>
      <BCol>
        <add-node-modal @nodeAdded="update"></add-node-modal>
      </BCol>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Endereço de IP</th>
            <th>Velocidade (Mbps)</th>
            <th>Custo</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
            <tr v-for="node in nodes.data" :key="node.id">
                <td>{{ node.id }}</td>
                <td>{{ node.name }}</td>
                <td>{{ node.ip_address }}</td>
                <td>{{ node.speed }}</td>
                <td>{{ node.cost }}</td>
                <td>
                  <BButton @click="updateNode(node)" variant="primary" size="xs">Editar</BButton>&nbsp;
                  <BButton @click="deleteNode(node.id)" variant="danger" size="xs">Remover</BButton>
                </td>
            </tr>
        </tbody>
      </table>
      <div class="pagination" v-if="nodes.last_page > 1">
        <b-button @click="fetchNodes(nodes.prev_page_url)" :disabled="!nodes.prev_page_url">Anterior</b-button>
        <b-button @click="fetchNodes(nodes.next_page_url)" :disabled="!nodes.next_page_url" class="ml-3">Próximo</b-button>
      </div>
      <edit-node-modal ref="editNodeModal" :editNode="editNode" @nodeEdited="update"></edit-node-modal>
    </div>

  </template>
  
  <script>
  import axios from 'axios';
  import AddNodeModal from './AddNodeModal.vue';
  import EditNodeModal from './EditNodeModal.vue';
  
  export default {
    name: 'NodeList',
    components: {
      AddNodeModal,
      EditNodeModal
    },
    data() {
      return {
        nodes: [],
        editNode: {},
      };
    },
    methods: {
      // Atualiza a lista de nós chamando a função fetchNodes
      update() {
        this.fetchNodes();
      },
      // Busca a lista de nós da API, com paginação
      fetchNodes(url = '/api/nodes/limited?per_page=8') {
        axios.get(url).then(response => {
          this.nodes = response.data;
        });
      },
      // Exclui um nó específico pela ID e atualiza a lista
      deleteNode(nodeId) {
        axios.delete(`/api/nodes/${nodeId}`);
        this.fetchNodes();
      },
      // Atualiza as informações de um nó específico e exibe o modal de edição
      updateNode(node) {
        this.editNode = Object.assign({}, node);
        this.$refs.editNodeModal.showModal();
      }
    },
    // Carrega a lista de nós quando o componente é montado
    mounted() {
      this.fetchNodes();
    }
  };
  </script>
  
  <style scoped>
  .node-list {
    padding: 20px;
  }
  
  .table {
    width: 100%;
    margin-top: 20px;
    background-color: white;
  }
  </style>
  